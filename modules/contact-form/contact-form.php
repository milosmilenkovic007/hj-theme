<?php
/**
 * Contact Form Module - contact-form.php
 */

$heading = get_sub_field( 'heading' );
$description = get_sub_field( 'description' );
$form_id = get_sub_field( 'form_id' );
$background_color = get_sub_field( 'background_color' ) ?: '#ffffff';

?>

<section class="module module-contact-form" style="background-color: <?php echo esc_attr( $background_color ); ?>;">
	<div class="container">
		<div class="contact-form-wrapper">
			<?php if ( $heading ) : ?>
				<h2 class="section-heading"><?php echo wp_kses_post( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<p class="section-description"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>

			<?php if ( $form_id ) : ?>
				<div class="form-container">
					<?php
					// Support za Gravity Forms i WPForms
					if ( class_exists( 'GFForms' ) ) {
						gravity_form( intval( $form_id ), false, false, false, null, true, 0, false );
					} elseif ( function_exists( 'wpforms_display' ) ) {
						wpforms_display( intval( $form_id ) );
					} else {
						echo '<p>' . esc_html__( 'Contact form plugin not found.', 'custom-theme' ) . '</p>';
					}
					?>
				</div><!-- .form-container -->
			<?php endif; ?>
		</div><!-- .contact-form-wrapper -->
	</div><!-- .container -->
</section><!-- .module-contact-form -->
