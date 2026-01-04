<?php
/**
 * Enqueue Assets (CSS, JS)
 */

function hj_theme_enqueue_assets() {
	// Enqueue main stylesheet
	wp_enqueue_style( 
		'hj-theme-main', 
		HJ_THEME_URI . '/assets/css/main.css', 
		array(), 
		HJ_THEME_VERSION 
	);

	// Enqueue main script
	wp_enqueue_script( 
		'hj-theme-main', 
		HJ_THEME_URI . '/assets/js/main.js', 
		array(), 
		HJ_THEME_VERSION, 
		true 
	);

	// Header interactions (mobile toggle + scroll state)
	wp_enqueue_script(
		'hj-theme-header',
		HJ_THEME_URI . '/assets/js/header.js',
		array(),
		HJ_THEME_VERSION,
		true
	);

	// Enqueue jQuery (ako je potreban)
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'hj_theme_enqueue_assets' );
