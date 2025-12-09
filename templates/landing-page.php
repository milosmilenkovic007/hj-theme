<?php
/**
 * Template Name: Landing Page
 * Description: Landing page template sa ACF flexible content
 */

get_header();
?>

<main id="main" class="site-main landing-page">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php
					// Prikazuj ACF flexible content
					if ( function_exists( 'have_rows' ) && have_rows( 'page_sections' ) ) {
						while ( have_rows( 'page_sections' ) ) {
							the_row();
							$layout = get_row_layout();
							
							// Učitaj modul fajl
							$module_path = HJ_THEME_DIR . '/modules/' . $layout . '/' . $layout . '.php';
							if ( file_exists( $module_path ) ) {
								include $module_path;
							}
						}
					}
					?>
				</div><!-- .entry-content -->
			</article><!-- #post-<?php the_ID(); ?> -->
			<?php
		}
	}
	?>
</main><!-- #main -->

<?php
get_footer();
