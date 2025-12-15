<?php
/**
 * The header template
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page">
		<header id="masthead" class="site-header pro-header">
			<div class="header-inner">
				<div class="header-brand">
					<?php
					$settings_logo_id = function_exists( 'get_field' ) ? get_field( 'header_logo', 'option' ) : null;
					$home_url = esc_url( home_url( '/' ) );
					if ( $settings_logo_id ) {
						$logo_html = wp_get_attachment_image( $settings_logo_id, 'full', false, array( 'class' => 'brand-logo-img' ) );
						if ( $logo_html ) {
							echo '<a class="brand-logo-link" href="' . $home_url . '" aria-label="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . $logo_html . '</a>';
						}
					} elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
						?>
						<a class="brand-logo" href="<?php echo $home_url; ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php the_custom_logo(); ?></a>
						<?php
					} else {
						?>
						<a class="brand-text" href="<?php echo $home_url; ?>"><?php bloginfo( 'name' ); ?></a>
						<?php
					}
					?>
				</div>

				<nav class="header-nav" aria-label="Primary">
					<?php
					$nav_block_id = function_exists( 'get_field' ) ? (int) get_field( 'header_navigation', 'option' ) : 0;
					$menu_id      = function_exists( 'get_field' ) ? (int) get_field( 'header_menu', 'option' ) : 0;

					if ( $nav_block_id ) {
						// Render a Navigation block (wp_navigation post) if provided.
						$nav_block = sprintf( '<!-- wp:navigation {"ref":%d} /-->', $nav_block_id );
						echo wp_kses_post( do_blocks( $nav_block ) );
					} else {
						$args = array(
							'menu_class'  => 'header-menu',
							'container'   => false,
							'fallback_cb' => 'wp_page_menu',
						);
						if ( $menu_id ) {
							$args['menu'] = $menu_id;
						} else {
							$args['theme_location'] = 'primary';
						}
						wp_nav_menu( $args );
					}
					?>
				</nav>

				<?php
				$cta_label = 'Contact Us';
				$cta_url   = home_url( '/contact' );
				if ( function_exists( 'get_field' ) ) {
					$cta_label = get_field( 'header_cta_label', 'option' ) ?: $cta_label;
					$cta_url   = get_field( 'header_cta_url', 'option' ) ?: $cta_url;
				}
				?>
				<div class="header-cta">
					<a class="btn btn-primary" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a>
				</div>

				<button class="header-toggle" aria-label="Toggle navigation" aria-expanded="false" id="header-menu-toggle">
					<span></span><span></span><span></span>
				</button>
			</div><!-- .header-inner -->

			<!-- Mobile Menu -->
			<nav class="header-mobile-menu" id="header-mobile-menu" aria-label="Mobile Menu">
				<div class="mobile-menu-inner">
					<?php
					if ( $nav_block_id ) {
						$nav_block = sprintf( '<!-- wp:navigation {"ref":%d} /-->', $nav_block_id );
						echo wp_kses_post( do_blocks( $nav_block ) );
					} else {
						$args = array(
							'menu_class'  => 'header-menu-mobile',
							'container'   => false,
							'fallback_cb' => 'wp_page_menu',
						);
						if ( $menu_id ) {
							$args['menu'] = $menu_id;
						} else {
							$args['theme_location'] = 'primary';
						}
						wp_nav_menu( $args );
					}
					?>
					<div class="mobile-menu-cta">
						<a class="btn btn-primary btn-block" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a>
					</div>
				</div>
			</nav>
		</header><!-- #masthead -->

		<div id="content" class="site-content">
