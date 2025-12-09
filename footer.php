<?php
/**
 * The footer template
 */

?>
		</div><!-- #content -->

		<?php
		$footer_bg          = hj_get_footer_background();
		$footer_bottom_bg   = hj_get_footer_bottom_bar_color();
		$footer_logo_id     = hj_get_footer_logo();
		$footer_text        = hj_get_setting( 'footer_text', '' );
		$footer_menu_id     = hj_get_footer_menu_id();
		$footer_nav_block   = function_exists( 'get_field' ) ? (int) get_field( 'footer_navigation', 'option' ) : 0;
		$footer_columns     = hj_get_footer_columns();
		$footer_copyright   = hj_get_footer_copyright();
		?>

		<footer
			id="colophon"
			class="site-footer pro-footer"
			style="--footer-bg: <?php echo esc_attr( $footer_bg ); ?>; --footer-bottom-bg: <?php echo esc_attr( $footer_bottom_bg ); ?>;"
		>
			<div class="footer-top container">
				<div class="footer-brand">
					<?php if ( $footer_logo_id ) : ?>
						<?php echo wp_get_attachment_image( $footer_logo_id, 'full', false, array( 'class' => 'footer-logo-img' ) ); ?>
					<?php else : ?>
						<a class="footer-brand-text" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>

					<?php if ( ! empty( $footer_text ) ) : ?>
						<p class="footer-description"><?php echo wp_kses_post( $footer_text ); ?></p>
					<?php endif; ?>
				</div>

				<nav class="footer-nav" aria-label="Footer">
					<?php
					if ( $footer_nav_block ) {
						$nav_block = sprintf( '<!-- wp:navigation {"ref":%d} /-->', $footer_nav_block );
						echo wp_kses_post( do_blocks( $nav_block ) );
					} else {
						$menu_args = array(
							'menu_class'  => 'footer-menu columns-' . $footer_columns,
							'container'   => false,
							'fallback_cb' => 'wp_page_menu',
							'depth'       => 1,
						);

						if ( $footer_menu_id ) {
							$menu_args['menu'] = $footer_menu_id;
						} else {
							$menu_args['theme_location'] = 'footer';
						}

						wp_nav_menu( $menu_args );
					}
					?>
				</nav>
			</div><!-- .footer-top -->

			<div class="footer-bottom">
				<div class="container footer-bottom-inner">
					<div class="footer-copyright"><?php echo wp_kses_post( $footer_copyright ); ?></div>
				</div>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
