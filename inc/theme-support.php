<?php
/**
 * Theme Support
 */

function hj_theme_setup() {
	// Add theme support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Register menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'hj-theme' ),
		'footer'  => esc_html__( 'Footer Menu', 'hj-theme' ),
	) );
}
add_action( 'after_setup_theme', 'hj_theme_setup' );

/**
 * Disable Gutenberg Editor based on Theme Settings
 */
function hj_disable_gutenberg_editor() {
	if ( function_exists( 'get_field' ) ) {
		$disable_gutenberg = get_field( 'disable_gutenberg', 'option' );
		
		if ( $disable_gutenberg ) {
			// Disable Gutenberg for posts and pages
			add_filter( 'use_block_editor_for_post', '__return_false', 10 );
			add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
			
			// Dequeue Gutenberg scripts and styles
			remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );
		}
	}
}
add_action( 'init', 'hj_disable_gutenberg_editor' );
