<?php
/**
 * Template Name: Thank You Page
 * Description: Dedicated thank-you page template with direct contact actions.
 */

get_header();

$footer_contact      = function_exists( 'hj_get_footer_contact_config' ) ? hj_get_footer_contact_config() : array();
$phone_display       = ! empty( $footer_contact['phone'] ) ? trim( (string) $footer_contact['phone'] ) : '';
$phone_link          = $phone_display ? preg_replace( '/[^+\d]/', '', $phone_display ) : '';
$email_address       = ! empty( $footer_contact['email'] ) ? trim( (string) $footer_contact['email'] ) : '';
$whatsapp_url        = function_exists( 'hj_get_social_link_by_platform' ) ? hj_get_social_link_by_platform( 'whatsapp' ) : false;
$contact_page_url    = home_url( '/contact/' );
$background_color    = function_exists( 'hj_get_background_color' ) ? hj_get_background_color() : '#ffffff';
$primary_color       = function_exists( 'hj_get_primary_color' ) ? hj_get_primary_color() : '#007bff';
$secondary_color     = function_exists( 'hj_get_secondary_color' ) ? hj_get_secondary_color() : '#6c757d';
$accent_color        = function_exists( 'hj_get_accent_color' ) ? hj_get_accent_color() : '#ffc107';
$heading_color       = function_exists( 'hj_get_heading_color' ) ? hj_get_heading_color() : '#1f2937';
$body_text_color     = function_exists( 'hj_get_body_text_color' ) ? hj_get_body_text_color() : '#4b5563';
$button_radius       = function_exists( 'hj_get_button_radius' ) ? (int) hj_get_button_radius() : 6;
$button_border_color = function_exists( 'hj_get_button_border_color' ) ? hj_get_button_border_color() : $primary_color;

$get_thank_you_field = static function( $field_name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $field_name );

	if ( is_string( $value ) ) {
		return '' !== trim( $value ) ? $value : $default;
	}

	return null !== $value && false !== $value && '' !== $value ? $value : $default;
};

if ( ! $whatsapp_url && $phone_link ) {
	$whatsapp_digits = preg_replace( '/\D+/', '', $phone_link );
	if ( $whatsapp_digits ) {
		$whatsapp_url = 'https://wa.me/' . $whatsapp_digits;
	}
}
?>

<main
	id="main"
	class="site-main thank-you-page"
	style="--thankyou-bg: <?php echo esc_attr( $background_color ); ?>; --thankyou-primary: <?php echo esc_attr( $primary_color ); ?>; --thankyou-secondary: <?php echo esc_attr( $secondary_color ); ?>; --thankyou-accent: <?php echo esc_attr( $accent_color ); ?>; --thankyou-heading: <?php echo esc_attr( $heading_color ); ?>; --thankyou-text: <?php echo esc_attr( $body_text_color ); ?>; --thankyou-radius: <?php echo esc_attr( $button_radius ); ?>px; --thankyou-border: <?php echo esc_attr( $button_border_color ); ?>;"
>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			$badge_text                    = $get_thank_you_field( 'thank_you_badge_text', __( 'Inquiry received', 'hj-theme' ) );
			$main_heading                  = $get_thank_you_field( 'thank_you_heading', __( 'Thank you for your message.', 'hj-theme' ) );
			$subheading                    = $get_thank_you_field( 'thank_you_subheading', __( 'We will get in touch with you shortly.', 'hj-theme' ) );
			$body_content_override         = $get_thank_you_field( 'thank_you_body_content', '' );
			$contact_heading               = $get_thank_you_field( 'thank_you_contact_heading', __( 'Need to talk now?', 'hj-theme' ) );
			$contact_text_both             = $get_thank_you_field( 'thank_you_contact_text_both', __( 'You can also reach us directly on WhatsApp or give us a call.', 'hj-theme' ) );
			$contact_text_whatsapp         = $get_thank_you_field( 'thank_you_contact_text_whatsapp', __( 'You can also reach us directly on WhatsApp.', 'hj-theme' ) );
			$contact_text_phone            = $get_thank_you_field( 'thank_you_contact_text_phone', __( 'You can also reach us directly by phone.', 'hj-theme' ) );
			$contact_text_fallback         = $get_thank_you_field( 'thank_you_contact_text_fallback', __( 'If you need anything else, our team is here to help.', 'hj-theme' ) );
			$email_prefix                  = $get_thank_you_field( 'thank_you_email_prefix', __( 'Or email us at', 'hj-theme' ) );
			$primary_button_text           = $get_thank_you_field( 'thank_you_primary_button_text', __( 'Message us now', 'hj-theme' ) );
			$secondary_button_text         = $get_thank_you_field( 'thank_you_secondary_button_text', __( 'Call us', 'hj-theme' ) );
			$fallback_primary_button_text  = $get_thank_you_field( 'thank_you_fallback_primary_button_text', __( 'Back to home', 'hj-theme' ) );
			$fallback_secondary_button_text = $get_thank_you_field( 'thank_you_fallback_secondary_button_text', __( 'Contact page', 'hj-theme' ) );

			$content_raw = is_string( $body_content_override ) && '' !== trim( wp_strip_all_tags( $body_content_override ) )
				? $body_content_override
				: get_the_content();
			$has_content = '' !== trim( wp_strip_all_tags( $content_raw ) );
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'thank-you-entry' ); ?>>
				<section class="thank-you-shell">
					<div class="container">
						<div class="thank-you-hero">
							<p class="thank-you-badge"><?php echo esc_html( $badge_text ); ?></p>
							<h1 class="thank-you-title"><?php echo esc_html( $main_heading ); ?></h1>
							<p class="thank-you-subtitle"><?php echo esc_html( $subheading ); ?></p>

							<?php if ( $has_content ) : ?>
								<div class="thank-you-copy">
									<?php echo apply_filters( 'the_content', $content_raw ); ?>
								</div>
							<?php endif; ?>
						</div>

						<section class="thank-you-panel" aria-labelledby="thank-you-contact-title">
							<div class="thank-you-panel-copy">
								<h2 id="thank-you-contact-title" class="thank-you-panel-title"><?php echo esc_html( $contact_heading ); ?></h2>
								<p class="thank-you-panel-text">
									<?php
									if ( $whatsapp_url && $phone_display ) {
										echo esc_html( $contact_text_both );
									} elseif ( $whatsapp_url ) {
										echo esc_html( $contact_text_whatsapp );
									} elseif ( $phone_display ) {
										echo esc_html( $contact_text_phone );
									} else {
										echo esc_html( $contact_text_fallback );
									}
									?>
								</p>

								<?php if ( $phone_display ) : ?>
									<a class="thank-you-phone" href="tel:<?php echo esc_attr( $phone_link ); ?>"><?php echo esc_html( $phone_display ); ?></a>
								<?php endif; ?>

								<?php if ( $email_address ) : ?>
									<p class="thank-you-email">
										<?php echo esc_html( $email_prefix ); ?>
										<a href="mailto:<?php echo esc_attr( $email_address ); ?>"><?php echo esc_html( $email_address ); ?></a>
									</p>
								<?php endif; ?>
							</div>

							<div class="thank-you-actions">
								<?php if ( $whatsapp_url ) : ?>
									<a class="thank-you-action thank-you-action--primary" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $primary_button_text ); ?></a>
								<?php endif; ?>

								<?php if ( $phone_link ) : ?>
									<a class="thank-you-action thank-you-action--secondary" href="tel:<?php echo esc_attr( $phone_link ); ?>"><?php echo esc_html( $secondary_button_text ); ?></a>
								<?php endif; ?>

								<?php if ( ! $whatsapp_url && ! $phone_link ) : ?>
									<a class="thank-you-action thank-you-action--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $fallback_primary_button_text ); ?></a>
									<a class="thank-you-action thank-you-action--secondary" href="<?php echo esc_url( $contact_page_url ); ?>"><?php echo esc_html( $fallback_secondary_button_text ); ?></a>
								<?php endif; ?>
							</div>
						</section>
					</div>
				</section>
			</article>
		<?php endwhile; ?>
	<?php endif; ?>
</main>

<?php get_footer(); ?>