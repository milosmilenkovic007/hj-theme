<?php
/**
 * Example Header With Theme Settings
 * Prikazuje kako koristiti theme helper functions
 */

// Dobijanje vrednosti iz theme settings-a
$logo_id = get_header_logo();
$nav_position = get_header_nav_position();
$header_bg = get_header_bg_color();
$primary_color = get_theme_primary_color();
?>

<header class="site-header" style="background-color: <?php echo esc_attr( $header_bg ); ?>">
	<div class="container">
		<div class="header-content">
			<!-- Logo -->
			<?php if ( $logo_id ) : ?>
				<div class="site-logo">
					<a href="<?php echo esc_url( home_url() ); ?>" class="logo-link">
						<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'class' => 'logo-image' ) ); ?>
					</a>
				</div>
			<?php endif; ?>

			<!-- Navigation -->
			<nav class="site-navigation" style="flex-direction: <?php echo esc_attr( $nav_position === 'right' ? 'row-reverse' : 'row' ); ?>;">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'fallback_cb'     => 'wp_page_menu',
					'container'       => false,
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				) );
				?>
			</nav>

			<!-- Social Links (ako su dostupni u settings) -->
			<?php
			$social_links = get_social_links();
			if ( ! empty( $social_links ) ) :
				?>
				<div class="social-links">
					<?php
					foreach ( $social_links as $link ) {
						?>
						<a href="<?php echo esc_url( $link['url'] ); ?>" 
						   class="social-link" 
						   target="_blank" 
						   rel="noopener noreferrer"
						   title="<?php echo esc_attr( $link['label'] ); ?>">
							<?php echo $link['label']; ?>
						</a>
						<?php
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</header>

<style>
	.site-header {
		padding: var(--spacing-md);
		background-color: <?php echo esc_attr( $header_bg ); ?>;
	}

	.header-content {
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: var(--spacing-lg);
	}

	.site-logo img {
		max-height: 60px;
		width: auto;
	}

	.site-navigation a {
		color: var(--text-color);
		text-decoration: none;
		padding: var(--spacing-sm) var(--spacing-md);
		transition: color 0.3s ease;
	}

	.site-navigation a:hover {
		color: var(--primary-color);
	}

	.social-links {
		display: flex;
		gap: var(--spacing-sm);
	}

	.social-link {
		width: 40px;
		height: 40px;
		display: flex;
		align-items: center;
		justify-content: center;
		background-color: var(--primary-color);
		color: white;
		border-radius: 50%;
		text-decoration: none;
		transition: all 0.3s ease;
	}

	.social-link:hover {
		transform: scale(1.1);
		background-color: var(--secondary-color);
	}
</style>
