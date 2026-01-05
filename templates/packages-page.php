<?php
/**
 * Template Name: Packages Page
 * Description: Packages landing page template using ACF flexible content (page_sections)
 */

get_header();
?>

<main id="main" class="site-main packages-page">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php
					if ( function_exists( 'have_rows' ) && have_rows( 'page_sections' ) ) {
						while ( have_rows( 'page_sections' ) ) {
							the_row();
							$layout = get_row_layout();
							$folder_name = str_replace( '_', '-', $layout );

							$module_path = HJ_THEME_DIR . '/modules/' . $folder_name . '/' . $folder_name . '.php';
							if ( file_exists( $module_path ) ) {
								include $module_path;
							}
						}
					}
					?>
				</div>
			</article>
			<?php
		}
	}
	?>
</main>

<?php
get_footer();
