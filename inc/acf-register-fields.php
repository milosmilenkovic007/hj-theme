<?php
/**
 * Register ACF Field Groups
 * Direktno registruje field groups iz JSON fajla
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hj_theme_register_acf_fields() {
	// Proverite da li je ACF aktiviran
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$template_dir = get_template_directory();
	$json_files   = array(
		'group_page_sections.json',
		'group_hj_theme_settings.json',
		'group_packages_cpt_fields.json',
	);

	foreach ( $json_files as $file ) {
		$json_path = $template_dir . '/inc/acf-json/' . $file;

		if ( ! file_exists( $json_path ) ) {
			continue;
		}

		$json_content = file_get_contents( $json_path );
		$field_group  = json_decode( $json_content, true );

		if ( ! is_array( $field_group ) ) {
			continue;
		}

		// Registruj field group
		acf_add_local_field_group( $field_group );
	}
}

// Registruj na 'init' hook sa prioritetom 5 - PRE nego što ACF učitava svoje stvari
add_action( 'init', 'hj_theme_register_acf_fields', 5 );
