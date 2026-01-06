<?php
/**
 * ACF Theme Settings
 * Registracija custom theme settings u ACF
 */

function hj_theme_register_acf_settings() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		// Main theme settings
		acf_add_options_page( array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'HJ Theme Settings',
			'menu_slug'  => 'hj-theme-settings',
			// Use edit_theme_options so users who can manage menus can also pick them here.
			'capability' => 'edit_theme_options',
			'redirect'   => false,
			'icon_url'   => 'dashicons-admin-appearance',
			'position'   => 70,
		) );
	}


}
add_action( 'acf/init', 'hj_theme_register_acf_settings' );

/**
 * Filter to populate menu choices for footer column fields from JSON
 * Applies to fields loaded from group_hj_theme_settings.json
 */
function hj_theme_populate_menu_choices( $field ) {
	// Only apply to footer menu column fields
	if ( ! in_array( $field['name'], array( 'footer_menu_col_1', 'footer_menu_col_2', 'footer_menu_col_3', 'footer_menu_col_4' ), true ) ) {
		return $field;
	}

	// Populate with available menus
	$field['choices'] = hj_theme_get_menus_for_acf_choices();
	return $field;
}
add_filter( 'acf/load_field', 'hj_theme_populate_menu_choices' );

/**
 * Helper to provide ACF choices for menus
 * Returns array id => name for all registered menus
 */
function hj_theme_get_menus_for_acf_choices() {
    $choices = array();
    $menus = wp_get_nav_menus();
    if ( ! is_array( $menus ) ) {
        return $choices;
    }
    foreach ( $menus as $menu ) {
        $choices[ (string) $menu->term_id ] = $menu->name;
    }
    return $choices;
}

/**
 * Render Zoho authentication status and button in ACF settings
 */
function hj_theme_render_zoho_auth_status( $field ) {
	// Only render on API Integration tab
	if ( $field['name'] !== 'zoho_auth_status' ) {
		return $field;
	}

	$access_token = get_option( 'zoho_access_token' );
	$token_expires = get_option( 'zoho_token_expires' );
	$is_authenticated = ! empty( $access_token ) && ( empty( $token_expires ) || $token_expires > time() );
	
	// Get credentials to build auth URL
	$client_id = get_field( 'zoho_client_id', 'option' );
	$redirect_uri = get_field( 'zoho_redirect_uri', 'option' );
	
	$auth_url = '';
	if ( ! empty( $client_id ) && ! empty( $redirect_uri ) ) {
		$auth_url = 'https://accounts.zoho.eu/oauth/v2/auth?' . http_build_query( array(
			'scope'         => 'ZohoCRM.modules.ALL,ZohoCRM.settings.ALL',
			'client_id'     => $client_id,
			'response_type' => 'code',
			'access_type'   => 'offline',
			'redirect_uri'  => $redirect_uri,
		) );
	}
	
	ob_start();
	?>
	<div class="zoho-auth-status" style="background: #fff; border: 1px solid #ccd0d4; padding: 15px; margin: 10px 0;">
		<?php if ( $is_authenticated ) : ?>
			<p style="color: #46b450; font-weight: 600; margin: 0 0 10px 0;">
				✓ Authenticated with Zoho CRM
			</p>
			<?php if ( ! empty( $token_expires ) ) : ?>
				<p style="color: #666; font-size: 13px; margin: 0;">
					Token expires: <?php echo esc_html( date( 'Y-m-d H:i:s', $token_expires ) ); ?>
				</p>
			<?php endif; ?>
		<?php else : ?>
			<p style="color: #dc3232; font-weight: 600; margin: 0 0 10px 0;">
				✗ Not authenticated
			</p>
			<?php if ( ! empty( $auth_url ) ) : ?>
				<a href="<?php echo esc_url( $auth_url ); ?>" class="button button-primary">
					Authenticate with Zoho CRM
				</a>
			<?php else : ?>
				<p style="color: #666; font-size: 13px; margin: 0;">
					Please fill in Client ID and Redirect URI above, then save to enable authentication.
				</p>
			<?php endif; ?>
		<?php endif; ?>
		
		<p style="margin: 10px 0 0 0;">
			<a href="<?php echo admin_url( 'options-general.php?page=zoho-crm-settings' ); ?>" class="button">
				View Zoho CRM Settings & Logs
			</a>
		</p>
	</div>
	<?php
	
	$field['message'] = ob_get_clean();
	return $field;
}
add_filter( 'acf/load_field', 'hj_theme_render_zoho_auth_status' );
