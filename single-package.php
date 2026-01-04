<?php
/**
 * Single Package template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$package_id            = get_the_ID();
		$package_title         = get_the_title();
		$price                 = function_exists( 'get_field' ) ? get_field( 'price' ) : '';
		$short_description     = function_exists( 'get_field' ) ? get_field( 'short_description' ) : '';
		$package_featured_image = get_the_post_thumbnail_url( $package_id, 'large' );

		$package_bg_color      = function_exists( 'get_field' ) ? get_field( 'package_bg_color' ) : '';
		$package_text_color    = function_exists( 'get_field' ) ? get_field( 'package_text_color' ) : '';
		$package_icon_bg_color = function_exists( 'get_field' ) ? get_field( 'package_icon_bg_color' ) : '';
		$package_icon_color    = function_exists( 'get_field' ) ? get_field( 'package_icon_color' ) : '';
		$package_arrow_color   = function_exists( 'get_field' ) ? get_field( 'package_arrow_color' ) : '';
		$is_additional_package = function_exists( 'get_field' ) ? (bool) get_field( 'is_additional_package' ) : false;

		$package_cta_heading     = function_exists( 'get_field' ) ? get_field( 'package_cta_heading' ) : '';
		$package_cta_subheading  = function_exists( 'get_field' ) ? get_field( 'package_cta_subheading' ) : '';
		$package_cta_image_id    = function_exists( 'get_field' ) ? (int) get_field( 'package_cta_image' ) : 0;
		$package_cta_button_text = function_exists( 'get_field' ) ? get_field( 'package_cta_button_text' ) : '';
		$package_cta_button_link = function_exists( 'get_field' ) ? get_field( 'package_cta_button_link' ) : null;

		$package_testimonials_title     = function_exists( 'get_field' ) ? get_field( 'package_testimonials_title' ) : '';
		$package_testimonials_shortcode = function_exists( 'get_field' ) ? get_field( 'package_testimonials_shortcode' ) : '';

		$package_final_cta_heading     = function_exists( 'get_field' ) ? get_field( 'package_final_cta_heading' ) : '';
		$package_final_cta_button_text = function_exists( 'get_field' ) ? get_field( 'package_final_cta_button_text' ) : '';
		$package_final_cta_button_link = function_exists( 'get_field' ) ? get_field( 'package_final_cta_button_link' ) : null;
		$package_final_cta_image_id    = function_exists( 'get_field' ) ? (int) get_field( 'package_final_cta_image' ) : 0;

		$style_vars = array();
		if ( is_string( $package_bg_color ) && $package_bg_color !== '' ) {
			$style_vars[] = '--pkg-bg-color:' . esc_attr( $package_bg_color );
		}
		if ( is_string( $package_text_color ) && $package_text_color !== '' ) {
			$style_vars[] = '--pkg-text-color:' . esc_attr( $package_text_color );
		}
		if ( is_string( $package_icon_bg_color ) && $package_icon_bg_color !== '' ) {
			$style_vars[] = '--pkg-icon-bg-color:' . esc_attr( $package_icon_bg_color );
		}
		if ( is_string( $package_icon_color ) && $package_icon_color !== '' ) {
			$style_vars[] = '--pkg-icon-color:' . esc_attr( $package_icon_color );
		}
		if ( is_string( $package_arrow_color ) && $package_arrow_color !== '' ) {
			$style_vars[] = '--pkg-arrow-color:' . esc_attr( $package_arrow_color );
		}

		$style_attr = ! empty( $style_vars ) ? ' style="' . esc_attr( implode( ';', $style_vars ) ) . '"' : '';
		?>
		<main id="content" class="site-main single-package"<?php echo $style_attr; ?>>
			<section class="hero-section-module package-hero-banner">
				<div class="hero-section-module__inner">
					<div class="hero-section-module__grid">
						<div class="hero-section-module__content">
							<h1 class="hero-section-module__title">
								<?php echo wp_kses_post( $package_title ); ?>
							</h1>
							<?php if ( is_string( $short_description ) && $short_description !== '' ) : ?>
								<p class="hero-section-module__subtitle">
									<?php echo wp_kses_post( $short_description ); ?>
								</p>
							<?php endif; ?>

							<?php if ( $is_additional_package ) : ?>
								<p class="package-flag"><?php echo esc_html__( 'Additional package', 'hj-theme' ); ?></p>
							<?php endif; ?>

							<div class="hero-section-module__button">
								<a href="#package-sections" class="btn btn-primary btn--primary">
									<?php echo esc_html__( 'Explore Package', 'hj-theme' ); ?>
								</a>
							</div>
						</div>

						<?php if ( $package_featured_image ) : ?>
							<div class="hero-section-module__image">
								<img src="<?php echo esc_url( $package_featured_image ); ?>" alt="<?php echo esc_attr( $package_title ); ?>" loading="lazy">
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>

			<?php if ( function_exists( 'get_field' ) ) : ?>
				<?php
				$sections = get_field( 'include_sections', $package_id );
				if ( is_array( $sections ) && count( $sections ) > 0 ) :
					?>
					<section class="package-sections" id="package-sections">
						<div class="container">
							<h2 class="package-sections__heading"><?php echo esc_html__( "What's Included in Your Check-Up", 'hj-theme' ); ?></h2>
							<div class="package-sections__accordion">
								<?php foreach ( $sections as $section ) : ?>
									<?php
									$title_line_1  = isset( $section['title_line_1'] ) ? (string) $section['title_line_1'] : '';
									$title_line_2  = isset( $section['title_line_2'] ) ? (string) $section['title_line_2'] : '';
									$section_items = isset( $section['items'] ) && is_array( $section['items'] ) ? $section['items'] : array();
									?>
									<details class="package-sections__accordion-item">
										<summary class="package-sections__accordion-summary">
											<div class="package-sections__accordion-title">
												<?php if ( $title_line_1 ) : ?>
													<span class="package-sections__title-line-1"><?php echo esc_html( $title_line_1 ); ?></span>
												<?php endif; ?>
												<?php if ( $title_line_2 ) : ?>
													<span class="package-sections__title-line-2"><?php echo esc_html( $title_line_2 ); ?></span>
												<?php endif; ?>
											</div>
											<span class="package-sections__accordion-icon" aria-hidden="true">
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</span>
										</summary>
										<?php if ( ! empty( $section_items ) ) : ?>
											<div class="package-sections__accordion-content">
												<ul class="package-sections__list">
													<?php foreach ( $section_items as $item ) : ?>
														<?php
														$item_text = isset( $item['text'] ) ? (string) $item['text'] : '';
														if ( $item_text === '' ) {
															continue;
														}
														?>
														<li class="package-sections__list-item">
															<span class="package-sections__text"><?php echo wp_kses_post( $item_text ); ?></span>
														</li>
													<?php endforeach; ?>
												</ul>
											</div>
										<?php endif; ?>
									</details>
								<?php endforeach; ?>
							</div>
						</div>
					</section>
					<?php
				endif;
				?>
			<?php endif; ?>

			<?php
			$cta_url    = '';
			$cta_target = '';
			if ( is_array( $package_cta_button_link ) ) {
				$cta_url    = isset( $package_cta_button_link['url'] ) ? (string) $package_cta_button_link['url'] : '';
				$cta_target = isset( $package_cta_button_link['target'] ) ? (string) $package_cta_button_link['target'] : '';
			}
			?>
			<?php if ( $package_cta_heading || $package_cta_subheading || $package_cta_image_id || $package_cta_button_text ) : ?>
				<section class="module-cta-package">
					<div class="cta-package__inner">
						<div class="cta-package__block">
							<div class="cta-package__content">
								<?php if ( $package_cta_heading ) : ?>
									<p class="cta-package__heading"><?php echo esc_html( $package_cta_heading ); ?></p>
								<?php endif; ?>
								<?php if ( $package_cta_subheading ) : ?>
									<h2 class="cta-package__subheading"><?php echo esc_html( $package_cta_subheading ); ?></h2>
								<?php endif; ?>

								<?php if ( $cta_url && $package_cta_button_text ) : ?>
									<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary btn--primary cta-package__button"<?php echo $cta_target ? ' target="' . esc_attr( $cta_target ) . '" rel="noopener"' : ''; ?>>
										<span class="btn__text"><?php echo esc_html( $package_cta_button_text ); ?></span>
										<span class="btn__icon" aria-hidden="true">
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1 8h14M8 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</span>
									</a>
								<?php endif; ?>
							</div>

							<?php if ( $package_cta_image_id ) : ?>
								<div class="cta-package__image-wrap">
									<?php echo wp_get_attachment_image( $package_cta_image_id, 'large', false, array( 'class' => 'cta-package__image', 'loading' => 'lazy' ) ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>

			<?php
			$other_packages_args = array(
				'post_type'      => 'package',
				'posts_per_page' => 3,
				'post__not_in'   => array( $package_id ),
				'orderby'        => 'rand',
				'fields'         => 'ids',
			);
			$other_packages_query = new WP_Query( $other_packages_args );
			if ( $other_packages_query->have_posts() ) :
				?>
				<section class="other-packages">
					<div class="other-packages__inner">
						<div class="other-packages__header">
							<h2 class="other-packages__title"><?php echo esc_html__( 'Explore Our Diagnostic Packages', 'hj-theme' ); ?></h2>
							<p class="other-packages__subtitle"><?php echo esc_html__( 'A selection of specialised check-up programs designed to match different medical needs and levels of care.', 'hj-theme' ); ?></p>
						</div>
						<div class="other-packages__grid">
							<?php while ( $other_packages_query->have_posts() ) : ?>
								<?php
								$other_packages_query->the_post();
								$other_id    = get_the_ID();
								$other_title = get_the_title();
								$other_short = function_exists( 'get_field' ) ? get_field( 'short_description', $other_id ) : '';
								$other_img   = get_the_post_thumbnail_url( $other_id, 'medium' );
								?>
								<article class="other-packages__card">
									<a class="other-packages__card-link" href="<?php echo esc_url( get_permalink( $other_id ) ); ?>">
										<?php if ( $other_img ) : ?>
											<div class="other-packages__image">
												<img src="<?php echo esc_url( $other_img ); ?>" alt="<?php echo esc_attr( $other_title ); ?>" loading="lazy">
											</div>
										<?php endif; ?>
										<div class="other-packages__content">
											<h3 class="other-packages__card-title"><?php echo esc_html( $other_title ); ?></h3>
											<?php if ( $other_short ) : ?>
												<?php
												$short_desc = wp_strip_all_tags( $other_short );
												$short_desc = mb_strlen( $short_desc ) > 120 ? mb_substr( $short_desc, 0, 120 ) . '...' : $short_desc;
												?>
												<p class="other-packages__description"><?php echo esc_html( $short_desc ); ?></p>
											<?php endif; ?>
											<span class="other-packages__read-more">
												<?php echo esc_html__( 'Read more', 'hj-theme' ); ?>
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="other-packages__arrow">
													<path d="M1 8h14M8 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</span>
										</div>
									</a>
								</article>
							<?php endwhile; ?>
						</div>
					</div>
				</section>
				<?php
			endif;
			wp_reset_postdata();
			?>

			<?php if ( $package_testimonials_title || $package_testimonials_shortcode ) : ?>
				<section class="module-testimonials">
					<div class="testimonials__inner">
						<?php if ( $package_testimonials_title ) : ?>
							<div class="testimonials__header">
								<h2 class="testimonials__title"><?php echo esc_html( $package_testimonials_title ); ?></h2>
							</div>
						<?php endif; ?>

						<?php if ( $package_testimonials_shortcode ) : ?>
							<div class="testimonials__carousel">
								<?php echo do_shortcode( wp_kses_post( $package_testimonials_shortcode ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php
			$final_url    = '';
			$final_target = '';
			if ( is_array( $package_final_cta_button_link ) ) {
				$final_url    = isset( $package_final_cta_button_link['url'] ) ? (string) $package_final_cta_button_link['url'] : '';
				$final_target = isset( $package_final_cta_button_link['target'] ) ? (string) $package_final_cta_button_link['target'] : '';
			}
			?>
			<?php if ( $package_final_cta_heading || $package_final_cta_image_id || $package_final_cta_button_text || $final_url || ( function_exists( 'have_rows' ) && have_rows( 'package_final_cta_features' ) ) ) : ?>
				<section class="module-cta-section package-final-cta">
					<div class="cta-section__panel">
						<div class="cta-section__grid">
							<div class="cta-section__left">
								<?php if ( $package_final_cta_heading ) : ?>
									<h2 class="cta-section__heading"><?php echo wp_kses_post( $package_final_cta_heading ); ?></h2>
								<?php endif; ?>
								<div class="cta-section__separator" aria-hidden="true"></div>

								<?php if ( function_exists( 'have_rows' ) && have_rows( 'package_final_cta_features' ) ) : ?>
									<div class="cta-section__items">
										<?php while ( have_rows( 'package_final_cta_features' ) ) : ?>
											<?php
											the_row();
											$feature_icon_id = (int) get_sub_field( 'icon' );
											$feature_title   = (string) get_sub_field( 'title' );
											$feature_desc    = (string) get_sub_field( 'description' );
											?>
											<div class="cta-section__item">
												<?php if ( $feature_icon_id ) : ?>
													<div class="cta-section__item-icon">
														<?php echo wp_get_attachment_image( $feature_icon_id, 'thumbnail' ); ?>
													</div>
												<?php endif; ?>
												<div class="cta-section__item-body">
													<?php if ( $feature_title !== '' ) : ?>
														<h3 class="cta-section__item-heading"><?php echo esc_html( $feature_title ); ?></h3>
													<?php endif; ?>
													<?php if ( $feature_desc !== '' ) : ?>
														<p class="cta-section__item-content"><?php echo esc_html( $feature_desc ); ?></p>
													<?php endif; ?>
												</div>
											</div>
										<?php endwhile; ?>
									</div>
								<?php endif; ?>
							</div>

							<?php if ( $package_final_cta_image_id ) : ?>
								<div class="cta-section__right">
									<div class="cta-section__card">
										<div class="cta-section__image-wrap">
											<?php echo wp_get_attachment_image( $package_final_cta_image_id, 'large', false, array( 'class' => 'cta-section__image', 'loading' => 'lazy' ) ); ?>
										</div>
										<?php if ( $final_url && $package_final_cta_button_text ) : ?>
											<a href="<?php echo esc_url( $final_url ); ?>" class="btn btn-primary btn--primary cta-section__button"<?php echo $final_target ? ' target="' . esc_attr( $final_target ) . '" rel="noopener"' : ''; ?>>
												<span class="btn__text"><?php echo esc_html( $package_final_cta_button_text ); ?></span>
												<span class="btn__icon" aria-hidden="true">
													<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M1 8h14M8 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
												</span>
											</a>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>

			<?php
			if ( function_exists( 'have_rows' ) && have_rows( 'page_sections' ) ) {
				echo '<section class="package-modules">';
				while ( have_rows( 'page_sections' ) ) {
					the_row();
					$layout = get_row_layout();

					$module_path = HJ_THEME_DIR . '/modules/' . $layout . '/' . $layout . '.php';
					if ( file_exists( $module_path ) ) {
						include $module_path;
					}
				}
				echo '</section>';
			}
			?>
		</main>
		<?php
	endwhile;
else :
	echo '<p>' . esc_html__( 'No content found', 'hj-theme' ) . '</p>';
endif;

get_footer();
