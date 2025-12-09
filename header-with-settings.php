<?php
/**
 * Header Template sa Theme Settings
 * Primer kako koristiti ACF Theme Settings
 */

$header_logo = hj_get_header_logo();
$header_logo_width = hj_get_header_logo_width();
$header_tagline = hj_get_header_tagline();
$is_sticky = hj_is_header_sticky();
$show_search = hj_show_header_search();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="<?php echo esc_attr( hj_get_robots_meta() ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page">
		<header id="masthead" class="site-header <?php echo $is_sticky ? 'sticky-header' : ''; ?>">
			<div class="site-header-content">
				<div class="site-branding">
					<?php if ( $header_logo ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
							<?php 
							echo wp_get_attachment_image( 
								$header_logo, 
								'full', 
								false, 
								array(
									'width' => $header_logo_width,
									'alt' => get_bloginfo( 'name' )
								) 
							); 
							?>
						</a>
					<?php endif; ?>

					<div class="site-title-wrapper">
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php bloginfo( 'name' ); ?>
							</a>
						</h1>
						
						<?php if ( $header_tagline ) : ?>
							<p class="site-tagline"><?php echo wp_kses_post( $header_tagline ); ?></p>
						<?php endif; ?>
					</div><!-- .site-title-wrapper -->
				</div><!-- .site-branding -->
				
				<nav id="site-navigation" class="main-navigation">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'main-menu',
						'fallback_cb'    => 'wp_page_menu',
						'depth'          => 3,
					) );
					?>
				</nav><!-- #site-navigation -->

				<?php if ( $show_search ) : ?>
					<div class="header-search">
						<?php get_search_form(); ?>
					</div><!-- .header-search -->
				<?php endif; ?>
			</div><!-- .site-header-content -->
		</header><!-- #masthead -->

		<div id="content" class="site-content">
