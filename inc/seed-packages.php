<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hj_theme_seed_packages_get_seed_file_path() {
	return HJ_THEME_DIR . '/inc/seed-data/packages.json';
}

function hj_theme_seed_packages_load_data() {
	$seed_file = hj_theme_seed_packages_get_seed_file_path();
	if ( ! file_exists( $seed_file ) ) {
		return new WP_Error( 'hj_seed_missing_file', 'Seed file not found.' );
	}

	$raw = file_get_contents( $seed_file );
	if ( $raw === false ) {
		return new WP_Error( 'hj_seed_read_failed', 'Failed to read seed file.' );
	}

	$data = json_decode( $raw, true );
	if ( ! is_array( $data ) ) {
		return new WP_Error( 'hj_seed_invalid_json', 'Seed file JSON is invalid.' );
	}

	return $data;
}

function hj_theme_seed_packages_upsert_post( array $item ) {
	$title = isset( $item['title'] ) ? (string) $item['title'] : '';
	if ( $title === '' ) {
		return new WP_Error( 'hj_seed_missing_title', 'Seed item missing title.' );
	}

	$existing = get_page_by_title( $title, OBJECT, 'package' );

	$postarr = array(
		'post_title'  => $title,
		'post_type'   => 'package',
		'post_status' => 'publish',
	);

	if ( $existing instanceof WP_Post ) {
		$postarr['ID'] = $existing->ID;
		$post_id       = wp_update_post( $postarr, true );
		$action        = 'updated';
	} else {
		$post_id = wp_insert_post( $postarr, true );
		$action  = 'created';
	}

	if ( is_wp_error( $post_id ) ) {
		return $post_id;
	}

	if ( function_exists( 'update_field' ) ) {
		if ( isset( $item['price'] ) ) {
			update_field( 'price', $item['price'], $post_id );
		}

		if ( isset( $item['short_description'] ) ) {
			update_field( 'short_description', (string) $item['short_description'], $post_id );
			wp_update_post(
				array(
					'ID'           => $post_id,
					'post_excerpt' => (string) $item['short_description'],
				)
			);
		}

		if ( isset( $item['include_sections'] ) && is_array( $item['include_sections'] ) ) {
			$sections_value = array();
			foreach ( $item['include_sections'] as $section ) {
				if ( ! is_array( $section ) ) {
					continue;
				}

				$items_value = array();
				if ( isset( $section['items'] ) && is_array( $section['items'] ) ) {
					foreach ( $section['items'] as $text ) {
						$text = is_scalar( $text ) ? (string) $text : '';
						if ( $text === '' ) {
							continue;
						}
						$items_value[] = array( 'text' => $text );
					}
				}

				$sections_value[] = array(
					'title_line_1' => isset( $section['title_line_1'] ) ? (string) $section['title_line_1'] : '',
					'title_line_2' => isset( $section['title_line_2'] ) ? (string) $section['title_line_2'] : '',
					'items'        => $items_value,
				);
			}

			update_field( 'include_sections', $sections_value, $post_id );
		}
	} else {
		return new WP_Error( 'hj_seed_acf_missing', 'ACF not available: update_field() missing.' );
	}

	return array(
		'post_id' => (int) $post_id,
		'action'  => $action,
	);
}

function hj_theme_seed_packages_run() {
	if ( ! post_type_exists( 'package' ) ) {
		return new WP_Error( 'hj_seed_missing_cpt', 'Package CPT not registered.' );
	}

	$data = hj_theme_seed_packages_load_data();
	if ( is_wp_error( $data ) ) {
		return $data;
	}

	$results = array(
		'created' => 0,
		'updated' => 0,
		'errors'  => array(),
	);

	foreach ( $data as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$res = hj_theme_seed_packages_upsert_post( $item );
		if ( is_wp_error( $res ) ) {
			$results['errors'][] = $res->get_error_message();
			continue;
		}
		if ( $res['action'] === 'created' ) {
			$results['created']++;
		} else {
			$results['updated']++;
		}
	}

	return $results;
}

function hj_theme_seed_packages_admin_menu() {
	add_management_page(
		__( 'Seed Packages', 'hj-theme' ),
		__( 'Seed Packages', 'hj-theme' ),
		'manage_options',
		'hj-seed-packages',
		'hj_theme_seed_packages_admin_page'
	);
}
add_action( 'admin_menu', 'hj_theme_seed_packages_admin_menu' );

function hj_theme_seed_packages_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'hj-theme' ) );
	}

	$notice = null;
	$error  = null;

	if ( isset( $_POST['hj_seed_packages'] ) ) {
		check_admin_referer( 'hj_seed_packages_action' );

		$result = hj_theme_seed_packages_run();
		if ( is_wp_error( $result ) ) {
			$error = $result->get_error_message();
		} else {
			$notice = sprintf(
				'Packages seeded. Created: %d, Updated: %d',
				(int) $result['created'],
				(int) $result['updated']
			);
			if ( ! empty( $result['errors'] ) ) {
				$error = implode( "\n", array_map( 'sanitize_text_field', $result['errors'] ) );
			}
		}
	}

	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( 'Seed Packages', 'hj-theme' ) . '</h1>';

	if ( $notice ) {
		echo '<div class="notice notice-success"><p>' . esc_html( $notice ) . '</p></div>';
	}

	if ( $error ) {
		echo '<div class="notice notice-error"><p>' . nl2br( esc_html( $error ) ) . '</p></div>';
	}

	echo '<p>' . esc_html__( 'This will create or update Package posts from the JSON seed file.', 'hj-theme' ) . '</p>';
	echo '<p><code>' . esc_html( hj_theme_seed_packages_get_seed_file_path() ) . '</code></p>';
	echo '<form method="post">';
	wp_nonce_field( 'hj_seed_packages_action' );
	echo '<p><button class="button button-primary" type="submit" name="hj_seed_packages" value="1">' . esc_html__( 'Run Seeder', 'hj-theme' ) . '</button></p>';
	echo '</form>';
	echo '</div>';
}
