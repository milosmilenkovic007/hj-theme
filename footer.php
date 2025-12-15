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
		$footer_cert_id     = hj_get_footer_certificate();
		$footer_text        = hj_get_setting( 'footer_text', '' );
		$footer_columns     = hj_get_footer_columns();
		$footer_column_menus = hj_get_footer_column_menu_ids();
		$footer_column_titles = hj_get_footer_column_titles();
		$footer_contact       = hj_get_footer_contact_config();
		$social_links         = hj_get_social_links();
		$footer_copyright   = hj_get_footer_copyright();
		?>

		<footer
			id="colophon"
			class="site-footer pro-footer"
			style="--footer-bg: <?php echo esc_attr( $footer_bg ); ?>; --footer-bottom-bg: <?php echo esc_attr( $footer_bottom_bg ); ?>;"
		>
			<div class="container footer-top">
				<div class="footer-brand">
					<div class="footer-brand-logos">
						<?php if ( $footer_logo_id ) : ?>
							<?php echo wp_get_attachment_image( $footer_logo_id, 'full', false, array( 'class' => 'footer-logo-img' ) ); ?>
						<?php else : ?>
							<a class="footer-brand-text" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
						<?php endif; ?>

						<?php if ( $footer_cert_id ) : ?>
							<div class="footer-certificate">
								<?php echo wp_get_attachment_image( $footer_cert_id, 'medium', false, array( 'class' => 'footer-certificate-img', 'loading' => 'lazy' ) ); ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $footer_text ) ) : ?>
						<p class="footer-description"><?php echo wp_kses_post( $footer_text ); ?></p>
					<?php endif; ?>
				</div>

				<nav class="footer-nav" aria-label="Footer">
					<?php
						echo '<div class="footer-menu-grid columns-' . esc_attr( $footer_columns ) . '">';
						for ( $col = 1; $col <= $footer_columns; $col++ ) {
							$menu_id_for_col = isset( $footer_column_menus[$col] ) ? (int) $footer_column_menus[$col] : 0;
							$menu_args = array(
								'menu_class'  => 'footer-menu-column column-' . $col,
								'container'   => false,
								'fallback_cb' => false,
								'depth'       => 1,
							);

							if ( $menu_id_for_col ) {
								$menu_args['menu'] = $menu_id_for_col;
							} else {
								$menu_args['theme_location'] = 'footer';
							}

							$column_classes = array( 'footer-column' );
							$contact_enabled = ( isset( $footer_contact['column'] ) && (int) $footer_contact['column'] === $col );
							if ( $contact_enabled ) {
								$column_classes[] = 'contact-column';
							}
							echo '<div class="' . esc_attr( implode( ' ', $column_classes ) ) . '">';
							$col_title = isset( $footer_column_titles[$col] ) ? $footer_column_titles[$col] : '';
							if ( $contact_enabled ) {
								$contact_title = ! empty( $footer_contact['title'] ) ? $footer_contact['title'] : $col_title;
								if ( ! empty( $contact_title ) ) {
									echo '<h3 class="footer-column-title">' . esc_html( $contact_title ) . '</h3>';
								}
								if ( ! empty( $footer_contact['address'] ) ) {
									$address_raw = str_replace( array( '<br />', '<br/>', '<br>' ), "\n", $footer_contact['address'] );
									$address_raw = wp_strip_all_tags( $address_raw );
									$lines = preg_split( '/\r\n|\r|\n/', $address_raw );
									$lines = array_map( 'esc_html', array_filter( array_map( 'trim', $lines ) ) );
									$address_html = implode( '<br>', $lines );
									echo '<div class="footer-contact-address">' . $address_html . '</div>';
								}
								if ( ! empty( $footer_contact['email'] ) || ! empty( $footer_contact['phone'] ) ) {
									echo '<ul class="footer-contact-list">';
									if ( ! empty( $footer_contact['email'] ) ) {
										$email = esc_attr( $footer_contact['email'] );
										$icon_email = '<svg class="icon icon-email" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4 6h16a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1zm0 0 8 6 8-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
										echo '<li class="contact-item email"><span class="contact-icon" aria-hidden="true">' . $icon_email . '</span><a href="mailto:' . $email . '">' . esc_html( $footer_contact['email'] ) . '</a></li>';
									}
									if ( ! empty( $footer_contact['phone'] ) ) {
										$tel = preg_replace( '/\s+/', '', $footer_contact['phone'] );
										$tel = esc_attr( $tel );
										$icon_phone = '<svg class="icon icon-phone" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M6.5 3h2l1.2 3.5-2 1a11 11 0 0 0 5.8 5.8l1-2L18 15.5v2a1.5 1.5 0 0 1-1.6 1.5 13.5 13.5 0 0 1-11.4-11.4A1.5 1.5 0 0 1 6.5 3z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
										echo '<li class="contact-item phone"><span class="contact-icon" aria-hidden="true">' . $icon_phone . '</span><a href="tel:' . $tel . '">' . esc_html( $footer_contact['phone'] ) . '</a></li>';
									}
									echo '</ul>';
								}
							} else {
								if ( ! empty( $col_title ) ) {
									echo '<h3 class="footer-column-title">' . esc_html( $col_title ) . '</h3>';
								}
								wp_nav_menu( $menu_args );
							}
							echo '</div>';
						}
						echo '</div>';
					?>
				</nav>
			</div><!-- .footer-top -->

			<div class="footer-bottom">
				<div class="footer-bottom-inner">
					<div class="footer-copyright"><?php echo wp_kses_post( $footer_copyright ); ?></div>
					<?php if ( ! empty( $social_links ) ) : ?>
						<div class="footer-social" aria-label="Social media">
							<?php
							foreach ( $social_links as $link ) {
								if ( empty( $link['platform'] ) || empty( $link['url'] ) ) {
									continue;
								}
								$platform = strtolower( $link['platform'] );
								$url = esc_url( $link['url'] );
								switch ( $platform ) {
									case 'facebook':
										$icon = '<svg class="icon icon-social" viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 9H15V6.5h-1.5c-1.3 0-2 .8-2 2V10H10v2.5h1.5V18h2V12.5h1.7L15.7 10H13.5V8.7c0-.5.1-.7.7-.7Z" fill="currentColor"/></svg>';
										break;
									case 'instagram':
										$icon = '<svg class="icon icon-social" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.5 4h7A3.5 3.5 0 0 1 19 7.5v7A3.5 3.5 0 0 1 15.5 18h-7A3.5 3.5 0 0 1 5 14.5v-7A3.5 3.5 0 0 1 8.5 4Zm0 1.5A2 2 0 0 0 6.5 7.5v7a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-7Zm7.38 1.12a.88.88 0 1 1 0 1.76.88.88 0 0 1 0-1.76ZM12 8.5A3.5 3.5 0 1 1 8.5 12 3.5 3.5 0 0 1 12 8.5Zm0 1.75A1.75 1.75 0 1 0 13.75 12 1.75 1.75 0 0 0 12 10.25Z" fill="currentColor"/></svg>';
										break;
									case 'twitter':
									case 'x':
										$icon = '<svg class="icon icon-social" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 5.5h2.4l3.1 4.2 3.2-4.2H17l-4 5.1 4.3 5.9h-2.4l-3.4-4.7-3.4 4.7H5.7l4.2-5.6Z" fill="currentColor"/></svg>';
										break;
									case 'linkedin':
										$icon = '<svg class="icon icon-social" viewBox="0 0 24 24" aria-hidden="true"><path d="M7.2 9H5V19h2.2V9Zm-1.1-1.6a1.3 1.3 0 1 0 0-2.6 1.3 1.3 0 0 0 0 2.6ZM10 9h2.1v1.4c.3-.7 1-1.6 2.4-1.6 1.6 0 2.5 1 2.5 3V19H15V12.3c0-.9-.3-1.5-1.1-1.5-.9 0-1.3.6-1.3 1.8V19H10V9Z" fill="currentColor"/></svg>';
										break;
									case 'youtube':
										$icon = '<svg class="icon icon-social" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 7.2c.2-.8.8-1.4 1.6-1.5C7.7 5.5 9.9 5.4 12 5.4s4.3.1 5.9.3c.8.1 1.4.7 1.6 1.5.2 1 .3 2.1.3 3.2s-.1 2.2-.3 3.2c-.2.8-.8 1.4-1.6 1.5-1.6.2-3.8.3-5.9.3s-4.3-.1-5.9-.3c-.8-.1-1.4-.7-1.6-1.5A22.4 22.4 0 0 1 4.2 10c0-1.1.1-2.2.3-3.2Zm5.4 5.8 4.2-2.5-4.2-2.5v5Z" fill="currentColor"/></svg>';
										break;
									case 'tiktok':
										$icon = '<svg class="icon icon-social" viewBox="0 0 24 24" aria-hidden="true"><path d="M14.5 5.2c.6.9 1.6 1.6 2.7 1.8v2.1a5 5 0 0 1-2.7-.8v5a4.8 4.8 0 1 1-4.8-4.8 4.9 4.9 0 0 1 1 .1V10a2.7 2.7 0 1 0 1.7 2.5V4.5h2.1v.7Z" fill="currentColor"/></svg>';
										break;
									case 'whatsapp':
										$icon = '<svg class="icon icon-social" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 19.5 5.7 16A7 7 0 1 1 12 19a7.2 7.2 0 0 1-3.5-.9L5 19.5Zm3.4-3 1.1.6a5 5 0 0 0 7-4.4 5 5 0 1 0-9.6 0l-.2 1.3 1.7-.2Zm.6-7.6c.2-.5.5-.5.8-.5h.6c.2 0 .5 0 .6.4.2.5.6 1.5.6 1.6 0 .1.1.3 0 .4l-.2.4c-.1.2-.3.3-.5.5-.1.1-.3.2-.1.5.1.3.6 1 1.3 1.6.9.7 1.7.9 2 .9.2 0 .3 0 .4-.3l.5-.7c.1-.2.2-.2.4-.1l1.4.6c.3.1.3.2.3.4 0 .2.1 1.3-.8 1.3-.7.1-1.4.1-2.2-.2-.5-.2-1.1-.3-2-.8-.9-.5-1.8-1.2-2.6-2.1-.4-.4-.7-.8-.9-1.1a6.1 6.1 0 0 1-.7-1.5c-.3-.6-.3-1.2-.3-1.6 0-.8.3-1.3.5-1.5Z" fill="currentColor"/></svg>';
										break;
									default:
										$icon = '<svg class="icon icon-social" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a9 9 0 1 1 0 18 9 9 0 0 1 0-18Zm0 1.5a7.5 7.5 0 0 0-1.2 14.9c0-.4.1-.9.2-1.4l.1-.5c-.1-.2-.2-.6-.2-1 0-.8.5-1.4 1-1.4.5 0 .8.4.8.9 0 .6-.3 1-.4 1.6-.1.4.3.7.7.6 1.2-.5 2-1.8 2-3.2 0-1.7-1.3-3-3.1-3-2.1 0-3.3 1.6-3.3 3.2 0 .6.2 1.3.5 1.6.1.1.1.2.1.3l-.2 1c0 .2-.2.3-.4.2-1-.5-1.6-1.9-1.6-3 0-2.4 1.7-4.6 5-4.6 2.6 0 4.5 1.9 4.5 4.4 0 2.5-1.6 4.6-3.9 4.6-.7 0-1.4-.4-1.6-.9 0 0-.4 1.4-.5 1.7-.2.5-.4 1-.7 1.4A7.5 7.5 0 0 0 12 4.5Z" fill="currentColor"/></svg>';
								}
								echo '<a class="footer-social-link" href="' . $url . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( ucfirst( $platform ) ) . '">' . $icon . '</a>';
							}
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
	<script>
		// Header Menu Toggle Functionality
		document.addEventListener('DOMContentLoaded', function() {
			const menuToggle = document.getElementById('header-menu-toggle');
			const mobileMenu = document.getElementById('header-mobile-menu');

			if (!menuToggle || !mobileMenu) {
				return;
			}

			// Toggle menu on button click
			menuToggle.addEventListener('click', function(e) {
				e.preventDefault();
				const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
				
				menuToggle.setAttribute('aria-expanded', !isExpanded);
				menuToggle.classList.toggle('active');
				mobileMenu.classList.toggle('active');

				// Prevent body scroll when menu is open
				if (!isExpanded) {
					document.body.style.overflow = 'hidden';
				} else {
					document.body.style.overflow = '';
				}
			});

			// Close menu when clicking on a link
			const menuLinks = mobileMenu.querySelectorAll('a');
			menuLinks.forEach(link => {
				link.addEventListener('click', function() {
					menuToggle.setAttribute('aria-expanded', 'false');
					menuToggle.classList.remove('active');
					mobileMenu.classList.remove('active');
					document.body.style.overflow = '';
				});
			});

			// Close menu when pressing Escape
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape' && menuToggle.getAttribute('aria-expanded') === 'true') {
					menuToggle.setAttribute('aria-expanded', 'false');
					menuToggle.classList.remove('active');
					mobileMenu.classList.remove('active');
					document.body.style.overflow = '';
				}
			});

			// Close menu when clicking outside
			document.addEventListener('click', function(e) {
				const header = document.querySelector('.site-header');
				if (!header.contains(e.target) && menuToggle.getAttribute('aria-expanded') === 'true') {
					menuToggle.setAttribute('aria-expanded', 'false');
					menuToggle.classList.remove('active');
					mobileMenu.classList.remove('active');
					document.body.style.overflow = '';
				}
			});
		});
	</script>
</body>
</html>
