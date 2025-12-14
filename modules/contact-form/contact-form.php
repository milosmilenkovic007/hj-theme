<?php
/**
 * Contact Form Module - contact-form.php
 */

$heading = get_sub_field( 'heading' );
$description = get_sub_field( 'description' );
$form_input = trim( (string) get_sub_field( 'form_id' ) );
$background_color = get_sub_field( 'background_color' );
$background_style = 'background-color: transparent;';

?>

<section class="module module-contact-form" style="<?php echo esc_attr( $background_style ); ?>">
	<div class="container">
		<div class="contact-form-wrapper">
			<?php if ( $heading ) : ?>
				<h2 class="section-heading"><?php echo wp_kses_post( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<p class="section-description"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>

			<?php if ( $form_input ) : ?>
				<div class="form-container">
					<?php
					// Accept either a plain ID (e.g., 3) or a full shortcode like [fluentform id="3"]
					$shortcode = preg_match( '/\[[^\]]+\]/', $form_input )
						? $form_input
						: '[fluentform id="' . esc_attr( $form_input ) . '"]';

					$output = do_shortcode( $shortcode );
					if ( ! empty( $output ) ) {
						echo $output;
					} else {
						// Fallback message to help debugging when plugin or form is missing
						echo '<p>' . esc_html__( 'Fluent Forms plugin is not active or the form ID is invalid.', 'custom-theme' ) . '</p>';
					}
					?>
				</div><!-- .form-container -->
			<?php endif; ?>
		</div><!-- .contact-form-wrapper -->
	</div><!-- .container -->
</section><!-- .module-contact-form -->
