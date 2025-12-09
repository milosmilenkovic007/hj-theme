<?php
/**
 * Text & Image Block Template
 */

$heading   = get_field( 'heading' ) ?: '';
$subheading = get_field( 'subheading' ) ?: '';
$content   = get_field( 'content' ) ?: '';
$media_id  = get_field( 'media' ) ?: 0;
$position  = get_field( 'position' ) ?: 'right';
$layout    = get_field( 'layout' ) ?: 'container';
$bg_color  = get_field( 'bg_color' ) ?: '#ffffff';

$wrapper_class = 'text-image-block';
$wrapper_class .= ' position-' . sanitize_html_class( $position );
$wrapper_class .= ' layout-' . sanitize_html_class( $layout );

if ( isset( $block['align'] ) ) {
	$wrapper_class .= ' align' . sanitize_html_class( $block['align'] );
}

if ( isset( $block['anchor'] ) ) {
	$wrapper_class .= ' ' . sanitize_html_class( $block['anchor'] );
}
?>

<section class="<?php echo esc_attr( $wrapper_class ); ?>" style="background-color: <?php echo esc_attr( $bg_color ); ?>;">
	<?php
	$inner_class = 'text-image-inner';
	if ( 'container' === $layout ) {
		$inner_class .= ' container';
	}
	?>
	<div class="<?php echo esc_attr( $inner_class ); ?>">
		<div class="text-image-content">
			<?php if ( ! empty( $subheading ) ) : ?>
				<p class="text-image-subheading"><?php echo esc_html( $subheading ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $heading ) ) : ?>
				<h2 class="text-image-heading"><?php echo wp_kses_post( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $content ) ) : ?>
				<div class="text-image-text">
					<?php echo wp_kses_post( $content ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $media_id ) : ?>
			<div class="text-image-media">
				<?php echo wp_get_attachment_image( $media_id, 'large', false, array( 'class' => 'text-image-img' ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
