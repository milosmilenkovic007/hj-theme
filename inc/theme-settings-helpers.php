<?php
/**
 * HJ Theme Settings Helper Functions
 * Easy access to theme settings throughout the site
 */

/**
 * Get theme setting value
 * 
 * @param string $field_name The ACF field name
 * @param mixed $default Default value if not found
 * @return mixed The field value
 */
function hj_get_setting( $field_name, $default = '' ) {
	return get_field( $field_name, 'option' ) ?: $default;
}

/**
 * Get header settings
 */
function hj_get_header_logo() {
	return hj_get_setting( 'header_logo' );
}

function hj_get_header_logo_width() {
	return hj_get_setting( 'header_logo_width', 200 );
}

function hj_get_header_tagline() {
	return hj_get_setting( 'header_tagline' );
}

function hj_is_header_sticky() {
	return hj_get_setting( 'header_sticky', true );
}

function hj_show_header_search() {
	return hj_get_setting( 'header_search', true );
}

/**
 * Get footer settings
 */
function hj_get_footer_copyright() {
	$default = sprintf( '© %s %s. All rights reserved.', date( 'Y' ), get_bloginfo( 'name' ) );
	// Back-compat: check legacy copyright_text if new field empty.
	return hj_get_setting( 'footer_copyright', hj_get_setting( 'copyright_text', $default ) );
}

function hj_get_footer_logo() {
	return hj_get_setting( 'footer_logo' );
}

function hj_get_footer_menu_id() {
	return (int) hj_get_setting( 'footer_menu', 0 );
}

function hj_get_footer_columns() {
	$columns = (int) hj_get_setting( 'footer_columns', 3 );
	return $columns >= 2 && $columns <= 4 ? $columns : 3;
}

function hj_show_footer_widgets() {
	return hj_get_setting( 'footer_widgets', true );
}

function hj_show_footer_newsletter() {
	return hj_get_setting( 'footer_newsletter', false );
}

function hj_get_footer_background() {
	return hj_get_setting( 'footer_background', '#0b1220' );
}

function hj_get_footer_bottom_bar_color() {
	return hj_get_setting( 'footer_bottom_bar_color', '#0a0f1c' );
}

/**
 * Get typography settings
 */
function hj_get_body_font() {
	return hj_get_setting( 'body_font', 'system' );
}

function hj_get_heading_font() {
	return hj_get_setting( 'heading_font', 'playfair' );
}

function hj_get_body_font_size() {
	return hj_get_setting( 'body_font_size', 16 );
}

function hj_get_body_line_height() {
	return hj_get_setting( 'body_line_height', 1.6 );
}

function hj_get_h1_size() {
	return hj_get_setting( 'h1_size', 48 );
}

/**
 * Get color settings
 */
function hj_get_primary_color() {
	return hj_get_setting( 'primary_color', '#007bff' );
}

function hj_get_secondary_color() {
	return hj_get_setting( 'secondary_color', '#6c757d' );
}

function hj_get_accent_color() {
	return hj_get_setting( 'accent_color', '#ffc107' );
}

function hj_get_body_text_color() {
	return hj_get_setting( 'body_text_color', '#343a40' );
}

function hj_get_heading_color() {
	return hj_get_setting( 'heading_color', '#000000' );
}

function hj_get_background_color() {
	return hj_get_setting( 'background_color', '#ffffff' );
}

/**
 * Get style settings
 */
function hj_get_button_style() {
	return hj_get_setting( 'button_style', 'filled' );
}

function hj_get_border_radius() {
	return hj_get_setting( 'border_radius', 6 );
}

/**
 * Get social links
 */
function hj_get_social_links() {
	return hj_get_setting( 'social_links', array() );
}

function hj_get_social_link_by_platform( $platform ) {
	$links = hj_get_social_links();
	
	if ( ! $links ) {
		return false;
	}

	foreach ( $links as $link ) {
		if ( $link['platform'] === $platform ) {
			return $link['url'];
		}
	}

	return false;
}

/**
 * Get tracking settings
 */
function hj_get_google_analytics() {
	return hj_get_setting( 'google_analytics' );
}

function hj_get_facebook_pixel() {
	return hj_get_setting( 'facebook_pixel' );
}

function hj_get_gtm_id() {
	return hj_get_setting( 'gtm_id' );
}

function hj_get_robots_meta() {
	$robots = hj_get_setting( 'robots', array( 'index', 'follow' ) );
	return $robots ? implode( ', ', $robots ) : 'index, follow';
}

/**
 * Output inline CSS with theme settings
 */
function hj_output_theme_css() {
	$primary = hj_get_primary_color();
	$secondary = hj_get_secondary_color();
	$accent = hj_get_accent_color();
	$body_color = hj_get_body_text_color();
	$heading_color = hj_get_heading_color();
	$bg_color = hj_get_background_color();
	$body_size = hj_get_body_font_size();
	$h1_size = hj_get_h1_size();
	$radius = hj_get_border_radius();
	$btn_primary_bg = hj_get_setting( 'button_primary_bg', '#007bff' );
	$btn_primary_text = hj_get_setting( 'button_primary_text', '#ffffff' );
	$btn_secondary_bg = hj_get_setting( 'button_secondary_bg', '#6c757d' );
	$btn_secondary_text = hj_get_setting( 'button_secondary_text', '#ffffff' );

	?>
	<style>
		:root {
			--hj-primary: <?php echo esc_attr( $primary ); ?>;
			--hj-secondary: <?php echo esc_attr( $secondary ); ?>;
			--hj-accent: <?php echo esc_attr( $accent ); ?>;
			--hj-body-color: <?php echo esc_attr( $body_color ); ?>;
			--hj-heading-color: <?php echo esc_attr( $heading_color ); ?>;
			--hj-bg-color: <?php echo esc_attr( $bg_color ); ?>;
			--hj-body-size: <?php echo absint( $body_size ); ?>px;
			--hj-h1-size: <?php echo absint( $h1_size ); ?>px;
			--hj-radius: <?php echo absint( $radius ); ?>px;
			--hj-btn-primary-bg: <?php echo esc_attr( $btn_primary_bg ); ?>;
			--hj-btn-primary-text: <?php echo esc_attr( $btn_primary_text ); ?>;
			--hj-btn-secondary-bg: <?php echo esc_attr( $btn_secondary_bg ); ?>;
			--hj-btn-secondary-text: <?php echo esc_attr( $btn_secondary_text ); ?>;
		}

		body {
			--color-primary: var(--hj-primary);
			--color-secondary: var(--hj-secondary);
			--color-dark: var(--hj-body-color);
			--background-color: var(--hj-bg-color);
		}

		h1, h2, h3, h4, h5, h6 {
			--color-dark: var(--hj-heading-color);
		}
	</style>
	<?php
}
add_action( 'wp_head', 'hj_output_theme_css', 5 );
