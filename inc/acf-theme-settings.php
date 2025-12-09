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
