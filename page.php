<?php
/**
 * Default page template
 */

global $post;

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<main class="page-default">
			<section class="page-hero">
				<div class="container hero-grid">
					<div class="hero-copy">
						<?php $subheading = function_exists('get_field') ? get_field('page_subheading') : ''; ?>
						<p class="hero-eyebrow"><?php echo esc_html( $subheading ?: get_bloginfo( 'name' ) ); ?></p>
						<h1 class="hero-title"><?php the_title(); ?></h1>
					</div>
				</div>
			</section>

			<section class="page-body">
				<div class="container">
					<article <?php post_class( 'page-content' ); ?>>
						<?php
						the_content();

						if ( function_exists( 'have_rows' ) && have_rows( 'page_sections' ) ) {
							while ( have_rows( 'page_sections' ) ) {
								the_row();
								$layout = get_row_layout();

								$module_path = HJ_THEME_DIR . '/modules/' . $layout . '/' . $layout . '.php';
								if ( file_exists( $module_path ) ) {
									include $module_path;
								}
							}
						}
						?>
					</article>
				</div>
			</section>
		</main>
		<?php
	endwhile;
else :
	echo '<p>' . esc_html__( 'No content found', 'hj-theme' ) . '</p>';
endif;

get_footer();
