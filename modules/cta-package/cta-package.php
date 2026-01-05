<?php
/**
 * CTA Package Module - cta-package.php
 */

$heading = get_sub_field( 'heading' );
$subheading = get_sub_field( 'subheading' );
$content = get_sub_field( 'content' );
$button_text = get_sub_field( 'button_text' );
$button_link = get_sub_field( 'button_link' );
$image_id = (int) get_sub_field( 'image' );

$button_url = is_array( $button_link ) ? ( $button_link['url'] ?? '' ) : $button_link;
$button_target = is_array( $button_link ) ? ( $button_link['target'] ?? '' ) : '';
?>

<section class="module module-cta-package">
	<div class="container">
		<div class="cta-package-grid">
			<div class="cta-package-content">
				<?php if ( $subheading ) : ?>
					<p class="cta-package-subheading"><?php echo esc_html( $subheading ); ?></p>
				<?php endif; ?>

				<?php if ( $heading ) : ?>
					<h2 class="cta-package-heading"><?php echo wp_kses_post( $heading ); ?></h2>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="cta-package-text"><?php echo wp_kses_post( $content ); ?></div>
				<?php endif; ?>

				<?php if ( $button_text && $button_url ) : ?>
					<a class="btn btn-primary" href="<?php echo esc_url( $button_url ); ?>"<?php echo $button_target ? ' target="' . esc_attr( $button_target ) . '" rel="noopener"' : ''; ?>>
						<?php echo esc_html( $button_text ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( $image_id ) : ?>
				<div class="cta-package-media">
					<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'img-responsive' ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
