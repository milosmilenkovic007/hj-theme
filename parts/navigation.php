<?php
/**
 * Navigation template part
 */

wp_nav_menu( array(
	'theme_location' => 'primary',
	'menu_class'     => 'main-menu',
	'fallback_cb'    => 'wp_page_menu',
) );
