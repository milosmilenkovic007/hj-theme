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
