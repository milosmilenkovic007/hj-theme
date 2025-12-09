<?php
/**
 * Example Footer With Theme Settings
 * Prikazuje kako koristiti footer helper functions
 */

// Dobijanje footer settings
$footer_logo_id = get_footer_logo();
$footer_bg = get_footer_bg_color();
$footer_text_color = get_footer_text_color();
$copyright_text = get_footer_copyright();
$social_links = get_social_links();
?>

<footer class="site-footer" style="background-color: <?php echo esc_attr( $footer_bg ); ?>; color: <?php echo esc_attr( $footer_text_color ); ?>">
	<div class="container">
		<!-- Footer Content -->
		<div class="footer-content">
			<!-- Logo & Description -->
			<div class="footer-section footer-brand">
				<?php if ( $footer_logo_id ) : ?>
					<div class="footer-logo">
						<?php echo wp_get_attachment_image( $footer_logo_id, 'medium', false, array( 'class' => 'logo-image' ) ); ?>
					</div>
				<?php endif; ?>
				<?php
				$footer_description = get_theme_setting( 'footer_description' );
				if ( $footer_description ) {
					?>
					<p class="footer-description"><?php echo wp_kses_post( $footer_description ); ?></p>
					<?php
				}
				?>
			</div>

			<!-- Quick Links -->
			<?php
			$footer_menu_1 = wp_get_nav_menu_items( 'footer-menu-1' );
			if ( ! empty( $footer_menu_1 ) ) {
				?>
				<div class="footer-section footer-links">
					<h3>Nasty Linkovi</h3>
					<ul>
						<?php
						foreach ( $footer_menu_1 as $item ) {
							?>
							<li>
								<a href="<?php echo esc_url( $item->url ); ?>">
									<?php echo esc_html( $item->title ); ?>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<?php
			}
			?>

			<!-- Contact Info -->
			<?php
			$contact_email = get_theme_setting( 'contact_email' );
			$contact_phone = get_theme_setting( 'contact_phone' );
			if ( $contact_email || $contact_phone ) {
				?>
				<div class="footer-section footer-contact">
					<h3>Kontakt</h3>
					<?php if ( $contact_email ) : ?>
						<p>Email: <a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a></p>
					<?php endif; ?>
					<?php if ( $contact_phone ) : ?>
						<p>Telefon: <a href="tel:<?php echo esc_attr( $contact_phone ); ?>"><?php echo esc_html( $contact_phone ); ?></a></p>
					<?php endif; ?>
				</div>
				<?php
			}
			?>

			<!-- Social Links -->
			<?php if ( ! empty( $social_links ) ) : ?>
				<div class="footer-section footer-social">
					<h3>Pratite Nas</h3>
					<div class="social-links">
						<?php
						foreach ( $social_links as $link ) {
							?>
							<a href="<?php echo esc_url( $link['url'] ); ?>" 
							   class="social-link"
							   target="_blank"
							   rel="noopener noreferrer"
							   title="<?php echo esc_attr( $link['label'] ); ?>">
								<?php echo esc_html( $link['label'] ); ?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- Footer Bottom -->
		<div class="footer-bottom">
			<?php if ( $copyright_text ) : ?>
				<p class="copyright"><?php echo wp_kses_post( $copyright_text ); ?></p>
			<?php else : ?>
				<p class="copyright">
					&copy; <?php echo esc_html( date( 'Y' ) ); ?> 
					<a href="<?php echo esc_url( home_url() ); ?>">
						<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					</a>
				</p>
			<?php endif; ?>

			<!-- Payment Icons (ako postoji ACF polje) -->
			<?php
			$payment_methods = get_theme_setting( 'payment_methods' );
			if ( ! empty( $payment_methods ) ) {
				?>
				<div class="payment-methods">
					<?php
					foreach ( $payment_methods as $method ) {
						?>
						<img src="<?php echo esc_url( $method ); ?>" alt="Payment Method">
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</footer>

<style>
	.site-footer {
		background-color: var(--footer-bg-color, #222);
		color: var(--footer-text-color, #fff);
		padding: var(--spacing-xxl) var(--spacing-lg);
		margin-top: var(--spacing-xxl);
	}

	.footer-content {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
		gap: var(--spacing-xxl);
		margin-bottom: var(--spacing-xl);
	}

	.footer-section h3 {
		margin-bottom: var(--spacing-md);
		font-size: 1.1rem;
		font-weight: 600;
	}

	.footer-section ul {
		list-style: none;
		padding: 0;
	}

	.footer-section ul li {
		margin-bottom: var(--spacing-sm);
	}

	.footer-section a {
		color: inherit;
		text-decoration: none;
		transition: color 0.3s ease;
	}

	.footer-section a:hover {
		color: var(--primary-color);
	}

	.footer-logo img {
		max-width: 200px;
		height: auto;
		margin-bottom: var(--spacing-md);
	}

	.footer-description {
		font-size: 0.9rem;
		line-height: 1.6;
		opacity: 0.8;
	}

	.footer-bottom {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding-top: var(--spacing-lg);
		border-top: 1px solid rgba(255, 255, 255, 0.1);
		font-size: 0.9rem;
	}

	.copyright {
		margin: 0;
	}

	.social-links {
		display: flex;
		gap: var(--spacing-md);
	}

	.social-link {
		display: inline-block;
		width: 40px;
		height: 40px;
		background-color: rgba(255, 255, 255, 0.1);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		text-decoration: none;
		transition: all 0.3s ease;
	}

	.social-link:hover {
		background-color: var(--primary-color);
		transform: scale(1.1);
	}

	.payment-methods {
		display: flex;
		gap: var(--spacing-md);
		align-items: center;
	}

	.payment-methods img {
		height: 30px;
		width: auto;
		opacity: 0.7;
		transition: opacity 0.3s ease;
	}

	.payment-methods img:hover {
		opacity: 1;
	}

	@media (max-width: 768px) {
		.footer-content {
			grid-template-columns: 1fr;
		}

		.footer-bottom {
			flex-direction: column;
			gap: var(--spacing-md);
			text-align: center;
		}
	}
</style>
