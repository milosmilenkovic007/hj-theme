<?php
/**
 * Footer Template sa Theme Settings
 * Primer kako koristiti ACF Theme Settings
 */

$footer_copyright = hj_get_footer_copyright();
$footer_logo = hj_get_footer_logo();
$show_widgets = hj_show_footer_widgets();
$show_newsletter = hj_show_footer_newsletter();
$footer_bg = hj_get_footer_background();
$social_links = hj_get_social_links();
?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer" style="background-color: <?php echo esc_attr( $footer_bg ); ?>;">
			<div class="site-footer-content">
				<div class="footer-container">
					<!-- Footer Main Content -->
					<div class="footer-main">
						<?php if ( $footer_logo ) : ?>
							<div class="footer-logo">
								<?php 
								echo wp_get_attachment_image( 
									$footer_logo, 
									'full', 
									false, 
									array( 'alt' => get_bloginfo( 'name' ) ) 
								); 
								?>
							</div><!-- .footer-logo -->
						<?php endif; ?>

						<?php if ( $show_newsletter ) : ?>
							<div class="footer-newsletter">
								<h3><?php esc_html_e( 'Subscribe to our newsletter', 'hj-theme' ); ?></h3>
								<?php
								// Prikazuj newsletter formu iz THEME SETTINGS-a
								// Možete koristiti Gravity Forms ili WPForms
								?>
							</div><!-- .footer-newsletter -->
						<?php endif; ?>
					</div><!-- .footer-main -->

					<!-- Footer Widgets -->
					<?php if ( $show_widgets ) : ?>
						<div class="footer-widgets">
							<?php
							if ( is_active_sidebar( 'footer-widget-1' ) ) {
								dynamic_sidebar( 'footer-widget-1' );
							}
							?>
						</div><!-- .footer-widgets -->
					<?php endif; ?>

					<!-- Footer Bottom -->
					<div class="footer-bottom">
						<div class="footer-copyright">
							<p><?php echo wp_kses_post( $footer_copyright ); ?></p>
						</div><!-- .footer-copyright -->

						<?php if ( $social_links ) : ?>
							<div class="footer-social">
								<?php
								foreach ( $social_links as $link ) {
									printf(
										'<a href="%s" target="_blank" rel="noopener noreferrer" class="social-link social-%s" title="%s">%s</a>',
										esc_url( $link['url'] ),
										esc_attr( $link['platform'] ),
										esc_attr( ucfirst( $link['platform'] ) ),
										ucfirst( esc_html( $link['platform'] ) )
									);
								}
								?>
							</div><!-- .footer-social -->
						<?php endif; ?>
					</div><!-- .footer-bottom -->
				</div><!-- .footer-container -->
			</div><!-- .site-footer-content -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
