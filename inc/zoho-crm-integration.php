<?php
/**
 * Zoho CRM Integration
 * Integrates Fluent Forms submissions with Zoho CRM (European servers)
 */

// Zoho API endpoints for European servers
define( 'ZOHO_ACCOUNTS_URL', 'https://accounts.zoho.eu' );
define( 'ZOHO_API_URL', 'https://www.zohoapis.eu' );

// Hook into Fluent Forms submission
add_action( 'fluentform/submission_inserted', 'hj_send_to_zoho_crm', 20, 3 );

// Add admin menu for Zoho CRM management
add_action( 'admin_menu', 'hj_zoho_crm_admin_menu' );

/**
 * Get Zoho credential from ACF theme settings
 *
 * @param string $key Credential key (client_id, client_secret, redirect_uri)
 * @return string Credential value
 */
function hj_get_zoho_credential( $key ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$field_map = array(
		'client_id'     => 'zoho_client_id',
		'client_secret' => 'zoho_client_secret',
		'redirect_uri'  => 'zoho_redirect_uri',
	);

	$field_name = isset( $field_map[ $key ] ) ? $field_map[ $key ] : '';
	return $field_name ? get_field( $field_name, 'option' ) : '';
}

/**
 * Check if Zoho CRM integration is enabled
 *
 * @return bool
 */
function hj_is_zoho_enabled() {
	return function_exists( 'get_field' ) && get_field( 'zoho_enable', 'option' );
}

/**
 * Get valid Zoho access token (refresh if needed)
 *
 * @return string|false Access token or false on failure
 */
function hj_get_zoho_access_token() {
	$access_token = get_option( 'zoho_access_token' );
	$expires_at   = get_option( 'zoho_token_expires_at' );

	// Return cached token if still valid
	if ( $access_token && $expires_at > time() ) {
		return $access_token;
	}

	// Refresh token
	$refresh_token = get_option( 'zoho_refresh_token' );

	if ( ! $refresh_token ) {
		hj_log_zoho_lead( 'System', 'Error', 'No refresh token available' );
		return false;
	}

	$token_url = ZOHO_ACCOUNTS_URL . '/oauth/v2/token';
	$response  = wp_remote_post(
		$token_url,
		array(
			'body' => array(
				'refresh_token'  => $refresh_token,
				'client_id'      => hj_get_zoho_credential( 'client_id' ),
				'client_secret'  => hj_get_zoho_credential( 'client_secret' ),
				'grant_type'     => 'refresh_token',
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		hj_log_zoho_lead( 'System', 'Error', 'Token refresh failed: ' . $response->get_error_message() );
		return false;
	}

	$body       = wp_remote_retrieve_body( $response );
	$token_data = json_decode( $body, true );

	if ( isset( $token_data['access_token'] ) ) {
		update_option( 'zoho_access_token', $token_data['access_token'] );
		update_option( 'zoho_token_expires_at', time() + $token_data['expires_in'] );
		return $token_data['access_token'];
	}

	hj_log_zoho_lead( 'System', 'Error', 'Failed to obtain access token: ' . print_r( $token_data, true ) );
	return false;
}

/**
 * Log Zoho lead submission
 *
 * @param string $name Lead name
 * @param string $status Status (Success/Error)
 * @param string $error Error message (optional)
 */
function hj_log_zoho_lead( $name, $status, $error = '' ) {
	$logs   = get_option( 'zoho_lead_submission_logs', array() );
	$logs[] = array(
		'timestamp' => current_time( 'mysql' ),
		'name'      => $name,
		'status'    => $status,
		'error'     => $error,
	);

	// Keep only the last 50 logs
	$logs = array_slice( $logs, -50 );
	update_option( 'zoho_lead_submission_logs', $logs );
}

/**
 * Clear all Zoho lead submission logs
 */
function hj_clear_zoho_logs() {
	update_option( 'zoho_lead_submission_logs', array() );
}

/**
 * Send Fluent Forms submission to Zoho CRM
 *
 * @param int   $entry_id Entry ID
 * @param array $form_data Form data
 * @param object $form Form object
 */
function hj_send_to_zoho_crm( $entry_id, $form_data, $form ) {
	// Check if integration is enabled
	if ( ! hj_is_zoho_enabled() ) {
		return;
	}

	// Get configured form ID
	$configured_form_id = function_exists( 'get_field' ) ? (int) get_field( 'zoho_form_id', 'option' ) : 3;
	
	// Only process configured form
	if ( ! isset( $form->id ) || (int) $form->id !== $configured_form_id ) {
		return;
	}

	// Debug: Log all form data
	error_log( 'Zoho CRM Debug - Form Data: ' . print_r( $form_data, true ) );

	$access_token = hj_get_zoho_access_token();

	if ( ! $access_token ) {
		hj_log_zoho_lead( 'Unknown', 'Error', 'No valid access token available' );
		return;
	}

	// Get field mappings from ACF
	$field_mappings = function_exists( 'get_field' ) ? get_field( 'zoho_field_mapping', 'option' ) : array();
	
	// Build lead data from field mappings
	$lead_data = array();
	$lead_name = 'Unknown';

	if ( is_array( $field_mappings ) && ! empty( $field_mappings ) ) {
		foreach ( $field_mappings as $mapping ) {
			$fluent_field = isset( $mapping['fluent_field'] ) ? $mapping['fluent_field'] : '';
			$zoho_field   = isset( $mapping['zoho_field'] ) ? $mapping['zoho_field'] : '';

			if ( empty( $fluent_field ) || empty( $zoho_field ) ) {
				continue;
			}

			// Extract value from nested Fluent Forms data (e.g., "names.first_name")
			$value = hj_get_nested_form_value( $form_data, $fluent_field );

			if ( $value !== null && $value !== '' ) {
				$lead_data[ $zoho_field ] = is_array( $value ) ? implode( ', ', $value ) : $value;
				
				// Track lead name for logging
				if ( in_array( $zoho_field, array( 'Full_Name', 'First_Name', 'Last_Name' ), true ) && empty( $lead_name ) ) {
					$lead_name = $value;
				}
			}
		}
	} else {
		// Fallback to default mappings if no custom mappings configured
		$lead_data = hj_get_default_zoho_mapping( $form_data );
		$lead_name = isset( $form_data['names']['first_name'] ) ? $form_data['names']['first_name'] : 'Unknown';
	}

	// Add automatic fields
	$lead_source = function_exists( 'get_field' ) ? get_field( 'zoho_lead_source', 'option' ) : '';
	$lead_data['Lead_Source']     = $lead_source ?: 'Website';
	$lead_data['Lead_Status']     = 'New';
	$lead_data['Lead_Source_URL'] = isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';

	// Ensure Last_Name is set (Zoho requirement)
	if ( empty( $lead_data['Last_Name'] ) ) {
		$lead_data['Last_Name'] = isset( $lead_data['Full_Name'] ) ? $lead_data['Full_Name'] : 'Unknown';
	}

	// Debug: Log lead data being sent
	error_log( 'Zoho CRM Debug - Lead Data being sent: ' . print_r( $lead_data, true ) );

	// Send to Zoho CRM
	$zoho_api_url = ZOHO_API_URL . '/crm/v2/Leads';
	$response     = wp_remote_post(
		$zoho_api_url,
		array(
			'headers' => array(
				'Authorization' => "Zoho-oauthtoken {$access_token}",
				'Content-Type'  => 'application/json',
			),
			'body'    => wp_json_encode( array( 'data' => array( $lead_data ) ) ),
			'timeout' => 30,
		)
	);

	// Handle response
	if ( is_wp_error( $response ) ) {
		hj_log_zoho_lead( $lead_name, 'Error', 'API Error: ' . $response->get_error_message() );
		return;
	}

	$body   = wp_remote_retrieve_body( $response );
	$result = json_decode( $body, true );

	if ( isset( $result['data'][0]['status'] ) && $result['data'][0]['status'] === 'success' ) {
		hj_log_zoho_lead( $lead_name, 'Success' );
	} else {
		hj_log_zoho_lead( $lead_name, 'Error', 'Lead creation failed: ' . print_r( $result, true ) );
	}
}

/**
 * Get nested value from form data using dot notation
 *
 * @param array  $data Form data
 * @param string $key Dot-notated key (e.g., "names.first_name")
 * @return mixed|null
 */
function hj_get_nested_form_value( $data, $key ) {
	$keys = explode( '.', $key );
	$value = $data;

	foreach ( $keys as $nested_key ) {
		if ( is_array( $value ) && isset( $value[ $nested_key ] ) ) {
			$value = $value[ $nested_key ];
		} else {
			return null;
		}
	}

	return is_string( $value ) ? sanitize_text_field( $value ) : $value;
}

/**
 * Get default Zoho field mapping (fallback)
 *
 * @param array $form_data Form data
 * @return array
 */
function hj_get_default_zoho_mapping( $form_data ) {
	$full_name   = isset( $form_data['names']['first_name'] ) ? sanitize_text_field( $form_data['names']['first_name'] ) : '';
	$phone       = isset( $form_data['phone'] ) ? sanitize_text_field( $form_data['phone'] ) : '';
	$description = isset( $form_data['description'] ) ? sanitize_textarea_field( $form_data['description'] ) : '';
	$gclid       = isset( $form_data['zc_gad'] ) ? sanitize_text_field( $form_data['zc_gad'] ) : '';

	return array(
		'Full_Name'    => $full_name,
		'Last_Name'    => $full_name ?: 'Unknown',
		'Phone'        => $phone,
		'Mobile'       => $phone,
		'Multi_Line_7' => $description,
		'$gclid'       => $gclid,
	);
}

/**
 * Add Zoho CRM admin menu
 */
function hj_zoho_crm_admin_menu() {
	add_options_page(
		'Zoho CRM Settings',
		'Zoho CRM',
		'manage_options',
		'zoho-crm-settings',
		'hj_zoho_crm_settings_page'
	);
}

/**
 * Render Zoho CRM settings page
 */
function hj_zoho_crm_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'hj-theme' ) );
	}

	// Fetch Zoho fields
	$zoho_fields = array();
	if ( isset( $_GET['fetch_fields'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'fetch_zoho_fields' ) ) {
		$access_token = hj_get_zoho_access_token();
		if ( $access_token ) {
			$fields_url = ZOHO_API_URL . '/crm/v2/settings/fields?module=Leads';
			$response = wp_remote_get(
				$fields_url,
				array(
					'headers' => array(
						'Authorization' => "Zoho-oauthtoken {$access_token}",
					),
				)
			);

			if ( ! is_wp_error( $response ) ) {
				$body = wp_remote_retrieve_body( $response );
				$data = json_decode( $body, true );
				if ( isset( $data['fields'] ) ) {
					$zoho_fields = $data['fields'];
				}
			}
		}
	}

	// Clear logs
	if ( isset( $_POST['clear_logs_nonce'] ) && wp_verify_nonce( $_POST['clear_logs_nonce'], 'clear_zoho_logs' ) ) {
		hj_clear_zoho_logs();
		echo '<div class="updated"><p>Logs cleared successfully!</p></div>';
	}

	// Get credentials from ACF
	$client_id     = hj_get_zoho_credential( 'client_id' );
	$client_secret = hj_get_zoho_credential( 'client_secret' );
	$redirect_uri  = hj_get_zoho_credential( 'redirect_uri' );

	// Handle OAuth callback
	if ( isset( $_GET['code'] ) ) {
		$token_url = ZOHO_ACCOUNTS_URL . '/oauth/v2/token';
		$response  = wp_remote_post(
			$token_url,
			array(
				'body' => array(
					'code'          => sanitize_text_field( wp_unslash( $_GET['code'] ) ),
					'client_id'     => $client_id,
					'client_secret' => $client_secret,
					'redirect_uri'  => $redirect_uri,
					'grant_type'    => 'authorization_code',
				),
			)
		);

		if ( ! is_wp_error( $response ) ) {
			$body       = wp_remote_retrieve_body( $response );
			$token_data = json_decode( $body, true );

			if ( isset( $token_data['access_token'] ) ) {
				update_option( 'zoho_access_token', $token_data['access_token'] );
				update_option( 'zoho_refresh_token', $token_data['refresh_token'] );
				update_option( 'zoho_token_expires_at', time() + $token_data['expires_in'] );
				echo '<div class="updated"><p><strong>Successfully authenticated with Zoho CRM!</strong></p></div>';
			} else {
				echo '<div class="error"><p>Failed to obtain access token: ' . esc_html( print_r( $token_data, true ) ) . '</p></div>';
			}
		} else {
			echo '<div class="error"><p>Error: ' . esc_html( $response->get_error_message() ) . '</p></div>';
		}
	}

	// Generate auth URL
	$auth_url = add_query_arg(
		array(
			'scope'        => 'ZohoCRM.modules.leads.CREATE',
			'client_id'    => $client_id,
			'response_type'=> 'code',
			'access_type'  => 'offline',
			'redirect_uri' => urlencode( $redirect_uri ),
		),
		ZOHO_ACCOUNTS_URL . '/oauth/v2/auth'
	);

	$token_status = get_option( 'zoho_refresh_token' ) ? '<span style="color:green;">✓ Authenticated</span>' : '<span style="color:red;">✗ Not Authenticated</span>';
	$is_enabled   = hj_is_zoho_enabled() ? '<span style="color:green;">✓ Enabled</span>' : '<span style="color:orange;">⚠ Disabled</span>';

	?>
	<div class="wrap">
		<h1>Zoho CRM Integration</h1>
		
		<div class="notice notice-info">
			<p><strong>Integration Status:</strong> <?php echo wp_kses_post( $is_enabled ); ?> | <strong>Authentication Status:</strong> <?php echo wp_kses_post( $token_status ); ?></p>
			<p>Configure Zoho credentials in <a href="<?php echo esc_url( admin_url( 'admin.php?page=hj-theme-settings' ) ); ?>">Theme Settings → API Integration</a></p>
		</div>

		<?php if ( ! $client_id || ! $client_secret || ! $redirect_uri ) : ?>
			<div class="notice notice-warning">
				<p><strong>Missing Configuration!</strong> Please configure your Zoho credentials in Theme Settings before authenticating.</p>
			</div>
		<?php else : ?>
			<div class="card" style="max-width: 600px;">
				<h2>Authenticate with Zoho CRM</h2>
				<p>Click the button below to authorize this application to access your Zoho CRM account.</p>
				<p><a href="<?php echo esc_url( $auth_url ); ?>" class="button button-primary button-large">Authenticate with Zoho CRM</a></p>
			</div>
		<?php endif; ?>

		<hr>

		<h2>Available Zoho CRM Fields</h2>
		<p>
			<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'fetch_fields', '1' ), 'fetch_zoho_fields' ) ); ?>" class="button">
				Show All Available Zoho Fields
			</a>
		</p>

		<?php if ( ! empty( $zoho_fields ) ) : ?>
			<table class="wp-list-table widefat fixed striped" style="margin-top: 10px; max-width: 800px;">
				<thead>
					<tr>
						<th>Field Label</th>
						<th>API Name (use this in mapping)</th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $zoho_fields as $field ) : ?>
						<?php if ( ! isset( $field['field_label'] ) || ! isset( $field['api_name'] ) ) continue; ?>
						<tr>
							<td><?php echo esc_html( $field['field_label'] ); ?></td>
							<td><code style="background:#f0f0f0;padding:2px 6px;border-radius:3px;"><?php echo esc_html( $field['api_name'] ); ?></code></td>
							<td><?php echo esc_html( $field['data_type'] ?? 'N/A' ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>

		<hr>

		<h2>Recent Lead Submissions</h2>
		<form method="post" action="">
			<?php wp_nonce_field( 'clear_zoho_logs', 'clear_logs_nonce' ); ?>
			<input type="submit" name="clear_logs" class="button button-secondary" value="Clear Logs">
		</form>

		<table class="wp-list-table widefat fixed striped" style="margin-top: 10px;">
			<thead>
				<tr>
					<th style="width: 180px;">Timestamp</th>
					<th style="width: 200px;">Lead Name</th>
					<th style="width: 100px;">Status</th>
					<th>Error Details</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$logs = get_option( 'zoho_lead_submission_logs', array() );
				$logs = array_reverse( $logs );

				if ( empty( $logs ) ) {
					echo '<tr><td colspan="4" style="text-align:center;padding:20px;color:#666;">No logs available</td></tr>';
				} else {
					foreach ( $logs as $index => $log ) {
						$error       = esc_html( $log['error'] );
						$short_error = mb_substr( $error, 0, 100 );
						$has_more    = mb_strlen( $error ) > 100;
						$status_class = $log['status'] === 'Success' ? 'color:green;font-weight:600;' : 'color:red;font-weight:600;';

						echo '<tr>';
						echo '<td>' . esc_html( $log['timestamp'] ) . '</td>';
						echo '<td>' . esc_html( $log['name'] ) . '</td>';
						echo '<td style="' . esc_attr( $status_class ) . '">' . esc_html( $log['status'] ) . '</td>';
						echo '<td>';
						
						if ( $error ) {
							echo '<div id="short-error-' . esc_attr( $index ) . '">' . esc_html( $short_error ) . ( $has_more ? '... ' : '' ) . '</div>';
							if ( $has_more ) {
								echo '<div id="full-error-' . esc_attr( $index ) . '" style="display:none;">' . esc_html( $error ) . '</div>';
								echo '<a href="#" class="toggle-error" data-index="' . esc_attr( $index ) . '">Show More</a>';
							}
						} else {
							echo '—';
						}
						
						echo '</td>';
						echo '</tr>';
					}
				}
				?>
			</tbody>
		</table>
	</div>

	<script>
	jQuery(document).ready(function($) {
		$('.toggle-error').on('click', function(e) {
			e.preventDefault();
			var index = $(this).data('index');
			var $short = $('#short-error-' + index);
			var $full = $('#full-error-' + index);

			if ($short.is(':visible')) {
				$short.hide();
				$full.show();
				$(this).text('Show Less');
			} else {
				$full.hide();
				$short.show();
				$(this).text('Show More');
			}
		});
	});
	</script>
	<?php
}
