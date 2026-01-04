<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hj_theme_register_packages_cpt() {
	$labels = array(
		'name'                  => __( 'Packages', 'hj-theme' ),
		'singular_name'         => __( 'Package', 'hj-theme' ),
		'menu_name'             => __( 'Packages', 'hj-theme' ),
		'name_admin_bar'        => __( 'Package', 'hj-theme' ),
		'add_new'               => __( 'Add New', 'hj-theme' ),
		'add_new_item'          => __( 'Add New Package', 'hj-theme' ),
		'new_item'              => __( 'New Package', 'hj-theme' ),
		'edit_item'             => __( 'Edit Package', 'hj-theme' ),
		'view_item'             => __( 'View Package', 'hj-theme' ),
		'all_items'             => __( 'All Packages', 'hj-theme' ),
		'search_items'          => __( 'Search Packages', 'hj-theme' ),
		'parent_item_colon'     => __( 'Parent Packages:', 'hj-theme' ),
		'not_found'             => __( 'No packages found.', 'hj-theme' ),
		'not_found_in_trash'    => __( 'No packages found in Trash.', 'hj-theme' ),
		'featured_image'        => __( 'Featured image', 'hj-theme' ),
		'set_featured_image'    => __( 'Set featured image', 'hj-theme' ),
		'remove_featured_image' => __( 'Remove featured image', 'hj-theme' ),
		'use_featured_image'    => __( 'Use as featured image', 'hj-theme' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'packages', 'with_front' => false ),
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon'          => 'dashicons-clipboard',
		'show_in_menu'       => true,
		'exclude_from_search'=> false,
		'publicly_queryable' => true,
	);

	register_post_type( 'package', $args );
}
add_action( 'init', 'hj_theme_register_packages_cpt' );

function hj_theme_register_packages_taxonomies() {
	$category_labels = array(
		'name'          => __( 'Package Categories', 'hj-theme' ),
		'singular_name' => __( 'Package Category', 'hj-theme' ),
	);

	register_taxonomy(
		'package_category',
		'package',
		array(
			'hierarchical' => true,
			'labels'       => $category_labels,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'package-category' ),
		)
	);

	$tag_labels = array(
		'name'          => __( 'Package Tags', 'hj-theme' ),
		'singular_name' => __( 'Package Tag', 'hj-theme' ),
	);

	register_taxonomy(
		'package_tag',
		'package',
		array(
			'hierarchical' => false,
			'labels'       => $tag_labels,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'package-tag' ),
		)
	);
}
add_action( 'init', 'hj_theme_register_packages_taxonomies' );

/**
 * Fix routing collisions for the Packages base.
 *
 * If a Page with slug "packages" exists (or an attachment under it), WordPress can resolve
 * /packages/{slug}/ as a page/attachment and redirect (often to the media file) for logged-out users.
 * This ensures package singles win when a matching package exists.
 */
function hj_theme_packages_request_override( $query_vars ) {
	if ( is_admin() ) {
		return $query_vars;
	}

	// Most common collision: a Page path match.
	if ( isset( $query_vars['pagename'] ) && is_string( $query_vars['pagename'] ) ) {
		$pagename = $query_vars['pagename'];
		if ( strncmp( $pagename, 'packages/', 9 ) === 0 ) {
			$slug = trim( substr( $pagename, 9 ), '/' );
			if ( $slug !== '' ) {
				$package = get_page_by_path( $slug, OBJECT, 'package' );
				if ( $package instanceof WP_Post ) {
					return array(
						'post_type' => 'package',
						'name'      => $slug,
					);
				}
			}
		}
	}

	// Another collision shape: attachment resolution.
	if ( isset( $query_vars['attachment'] ) && is_string( $query_vars['attachment'] ) ) {
		$slug = $query_vars['attachment'];
		if ( $slug !== '' ) {
			$package = get_page_by_path( $slug, OBJECT, 'package' );
			if ( $package instanceof WP_Post ) {
				return array(
					'post_type' => 'package',
					'name'      => $slug,
				);
			}
		}
	}

	return $query_vars;
}
add_filter( 'request', 'hj_theme_packages_request_override', 1 );
