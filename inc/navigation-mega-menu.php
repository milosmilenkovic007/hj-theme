<?php
/**
 * Mega menu enhancements (header primary menu)
 *
 * - Marks a parent menu item as "mega" if its direct children include Package CPT items.
 * - Injects package featured images into submenu item labels (desktop header menu only).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add helper classes and thumbnail URLs to menu items.
 *
 * @param WP_Post[] $items Menu items.
 * @param stdClass  $args  Menu args.
 * @return WP_Post[]
 */
function hj_theme_header_menu_megamenu_objects( $items, $args ) {
	if ( ! is_object( $args ) || empty( $args->menu_class ) ) {
		return $items;
	}

	// Only enhance the desktop header menu.
	if ( strpos( (string) $args->menu_class, 'header-menu' ) === false ) {
		return $items;
	}

	// Avoid affecting the mobile menu.
	if ( strpos( (string) $args->menu_class, 'header-menu-mobile' ) !== false ) {
		return $items;
	}

	$children_by_parent = array();
	foreach ( $items as $item ) {
		$parent_id = (int) $item->menu_item_parent;
		if ( $parent_id > 0 ) {
			if ( ! isset( $children_by_parent[ $parent_id ] ) ) {
				$children_by_parent[ $parent_id ] = array();
			}
			$children_by_parent[ $parent_id ][] = $item;
		}
	}

	$mega_parent_ids = array();
	foreach ( $children_by_parent as $parent_id => $children ) {
		foreach ( $children as $child ) {
			// Mark parent as mega if it contains package CPT links.
			if ( isset( $child->object ) && $child->object === 'package' ) {
				$mega_parent_ids[ $parent_id ] = true;
				break;
			}
		}
	}

	foreach ( $items as $item ) {
		$item_id = (int) $item->ID;

		if ( isset( $mega_parent_ids[ $item_id ] ) ) {
			$item->classes[] = 'menu-mega';
		}

		// Enhance only direct children of mega parents.
		$parent_id = (int) $item->menu_item_parent;
		if ( $parent_id > 0 && isset( $mega_parent_ids[ $parent_id ] ) ) {
			$item->classes[] = 'menu-mega__item';

			if ( isset( $item->object, $item->object_id ) && $item->object === 'package' ) {
				$post_id = (int) $item->object_id;
				$thumb_id = get_post_thumbnail_id( $post_id );
				if ( $thumb_id ) {
					$src = wp_get_attachment_image_url( $thumb_id, 'thumbnail' );
					if ( is_string( $src ) && $src !== '' ) {
						$item->hj_menu_thumb_url = $src;
						$item->classes[]        = 'menu-item--has-thumb';
					}
				}
			}
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'hj_theme_header_menu_megamenu_objects', 10, 2 );

/**
 * Render the injected thumbnail markup in the menu title.
 *
 * @param string   $title Menu title.
 * @param WP_Post  $item  Menu item.
 * @param stdClass $args  Menu args.
 * @param int      $depth Depth.
 * @return string
 */
function hj_theme_header_menu_megamenu_item_title( $title, $item, $args, $depth ) {
	if ( ! is_object( $args ) || empty( $args->menu_class ) ) {
		return $title;
	}

	if ( strpos( (string) $args->menu_class, 'header-menu' ) === false ) {
		return $title;
	}

	if ( strpos( (string) $args->menu_class, 'header-menu-mobile' ) !== false ) {
		return $title;
	}

	if ( $depth < 1 ) {
		return $title;
	}

	$has_mega_class = is_array( $item->classes ) && in_array( 'menu-mega__item', $item->classes, true );
	if ( ! $has_mega_class ) {
		return $title;
	}

	$thumb = '';
	if ( isset( $item->hj_menu_thumb_url ) && is_string( $item->hj_menu_thumb_url ) && $item->hj_menu_thumb_url !== '' ) {
		$thumb = '<span class="menu-mega__thumb" aria-hidden="true"><img src="' . esc_url( $item->hj_menu_thumb_url ) . '" alt="" loading="lazy" decoding="async"></span>';
	}

	return '<span class="menu-mega__link">' . $thumb . '<span class="menu-mega__label">' . esc_html( wp_strip_all_tags( $title ) ) . '</span></span>';
}
add_filter( 'nav_menu_item_title', 'hj_theme_header_menu_megamenu_item_title', 10, 4 );
