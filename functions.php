<?php
/**
 * HJ Theme - functions.php
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define theme constants
define( 'HJ_THEME_DIR', get_template_directory() );
define( 'HJ_THEME_URI', get_template_directory_uri() );
define( 'HJ_THEME_VERSION', '1.0.0' );

// ACF JSON Save/Load Path - MORA biti pre nego što ACF učitava
add_filter( 'acf/settings/save_json', function() {
	return HJ_THEME_DIR . '/inc/acf-json';
}, 1 );

add_filter( 'acf/settings/load_json', function( $paths ) {
	// Dodaj našu ACF-json putanju
	$paths[] = HJ_THEME_DIR . '/inc/acf-json';
	return $paths;
}, 1 );

// Enable ACF to show local field groups in admin
add_filter( 'acf/settings/show_admin', '__return_true' );
add_filter( 'acf/settings/save_json_enabled', '__return_true' );

// Allow SVG uploads (sanity: svg+xml mime)
add_filter( 'upload_mimes', function( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
} );

// Include theme support and features
require_once HJ_THEME_DIR . '/inc/theme-support.php';
require_once HJ_THEME_DIR . '/inc/enqueue-assets.php';
require_once HJ_THEME_DIR . '/inc/cpt-packages.php';
require_once HJ_THEME_DIR . '/inc/acf-register-fields.php';
require_once HJ_THEME_DIR . '/inc/seed-packages.php';
require_once HJ_THEME_DIR . '/inc/acf-theme-settings.php';
require_once HJ_THEME_DIR . '/inc/acf-blocks.php';
require_once HJ_THEME_DIR . '/inc/theme-settings-helpers.php';

// Load text domain
function hj_theme_load_textdomain() {
	load_theme_textdomain( 'hj-theme', HJ_THEME_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'hj_theme_load_textdomain' );

/**
 * One-time rewrite flush after CPT changes.
 *
 * Without this, WordPress may not match /packages/{slug}/ to the Package CPT yet,
 * and can end up redirecting to an attachment with the same slug.
 */
function hj_theme_maybe_flush_rewrite_rules() {
	if ( ! is_admin() ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$option_key = 'hj_theme_rewrite_flushed_' . HJ_THEME_VERSION;
	if ( get_option( $option_key ) ) {
		return;
	}

	flush_rewrite_rules( false );
	update_option( $option_key, 1 );
}
add_action( 'admin_init', 'hj_theme_maybe_flush_rewrite_rules' );
