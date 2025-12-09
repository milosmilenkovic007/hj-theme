<?php
/**
 * CTA Module - cta.php
 */

$heading = get_sub_field( 'heading' );
$description = get_sub_field( 'description' );
$button_text = get_sub_field( 'button_text' );
$button_link = get_sub_field( 'button_link' );
$button_style = get_sub_field( 'button_style' ) ?: 'primary';
$background_color = get_sub_field( 'background_color' ) ?: '#f5f5f5';
$text_color = get_sub_field( 'text_color' ) ?: '#000000';

?>

<section class="module module-cta" style="background-color: <?php echo esc_attr( $background_color ); ?>;color: <?php echo esc_attr( $text_color ); ?>;">
	<div class="container">
		<div class="cta-wrapper">
			<?php if ( $heading ) : ?>
				<h2 class="cta-heading"><?php echo wp_kses_post( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<p class="cta-description"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>

			<?php if ( $button_text && $button_link ) : ?>
				<a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-<?php echo esc_attr( $button_style ); ?>">
					<?php echo esc_html( $button_text ); ?>
				</a>
			<?php endif; ?>
		</div><!-- .cta-wrapper -->
	</div><!-- .container -->
</section><!-- .module-cta -->
