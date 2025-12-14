<?php
/**
 * Side Images Module
 */

$heading = get_sub_field( 'heading' );
$subheading = get_sub_field( 'subheading' );
$subheading_color = get_sub_field( 'subheading_color' ) ?: '#6c757d';
$alignment = get_sub_field( 'heading_alignment' ) ?: 'center';
$items = get_sub_field( 'items' );
$background_color = get_sub_field( 'background_color' ) ?: '#ffffff';

if ( ! $items ) {
	return;
}

?>

<section class="module module-side-images" style="background-color: <?php echo esc_attr( $background_color ); ?>;">
	<div class="container">
		
		<?php if ( $heading || $subheading ) : ?>
			<div class="side-images-header text-<?php echo esc_attr( $alignment ); ?>">
				<?php if ( $heading ) : ?>
					<h2 class="side-images-heading"><?php echo wp_kses_post( $heading ); ?></h2>
				<?php endif; ?>
				
				<?php if ( $subheading ) : ?>
					<p class="side-images-subheading" style="color: <?php echo esc_attr( $subheading_color ); ?>;"><?php echo wp_kses_post( $subheading ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="side-images-items">
			<?php foreach ( $items as $index => $item ) : 
				$image_position = $item['image_position'] ?: 'left';
				$item_heading = $item['heading'];
				$image = $item['image'];
				$content = $item['content'];
				$button_text = $item['button_text'];
				$button_link = $item['button_link'];
			?>
				
				<?php if ( $index > 0 ) : ?>
					<hr class="side-images-separator">
				<?php endif; ?>

			<div class="side-images-item side-images-item--<?php echo esc_attr( $image_position ); ?>">
				<div class="side-images-image">
					<?php echo wp_get_attachment_image( $image, 'large', false, array( 'class' => 'img-responsive' ) ); ?>
				</div>

				<div class="side-images-content text-left">
						<?php if ( $item_heading ) : ?>
							<h3 class="side-images-item-heading"><?php echo wp_kses_post( $item_heading ); ?></h3>
						<?php endif; ?>
						
						<div class="side-images-text">
							<?php echo wp_kses_post( $content ); ?>
						</div>

						<?php if ( $button_text && $button_link ) : ?>
							<a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-primary">
								<?php echo esc_html( $button_text ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>

			<?php endforeach; ?>
		</div>

	</div>
</section>
