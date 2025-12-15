<?php
/**
 * Features Module - features.php
 */

$heading = get_sub_field( 'heading' );
$description = get_sub_field( 'description' );
$columns = get_sub_field( 'columns' ) ?: 3;
$features = get_sub_field( 'features' );

?>

<section class="module module-features">
	<div class="container">
		<?php if ( $heading ) : ?>
			<h2 class="section-heading"><?php echo wp_kses_post( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="section-description"><?php echo wp_kses_post( $description ); ?></p>
		<?php endif; ?>

		<?php if ( $features && is_array( $features ) ) : ?>
			<div class="features-grid features-grid-4">
				<?php foreach ( $features as $feature ) : ?>
					<?php
					$icon_color = ! empty( $feature['icon_color'] ) ? $feature['icon_color'] : '#3B82F6';
					$bg_color = ! empty( $feature['bg_color'] ) ? $feature['bg_color'] : '#ffffff';
					$bg_gradient_enabled = ! empty( $feature['bg_gradient_enabled'] );
					$bg_gradient_end = ! empty( $feature['bg_gradient_end'] ) ? $feature['bg_gradient_end'] : '#f9fafb';
					$bg_gradient_angle = ! empty( $feature['bg_gradient_angle'] ) ? (int) $feature['bg_gradient_angle'] : 135;
					
					$style = 'style="--icon-color: ' . esc_attr( $icon_color ) . '; ';
					
					if ( $bg_gradient_enabled ) {
						$style .= '--bg-color: linear-gradient(' . esc_attr( $bg_gradient_angle ) . 'deg, ' . esc_attr( $bg_color ) . ' 0%, ' . esc_attr( $bg_gradient_end ) . ' 100%);';
					} else {
						$style .= '--bg-color: ' . esc_attr( $bg_color ) . ';';
					}
					
					$style .= '"';
					?>
					<div class="feature-item" <?php echo $style; ?>>
						<?php if ( ! empty( $feature['icon_upload'] ) ) : ?>
							<div class="feature-icon">
								<?php echo wp_get_attachment_image( $feature['icon_upload'], 'thumbnail', false, array( 'class' => 'feature-svg' ) ); ?>
							</div><!-- .feature-icon -->
						<?php endif; ?>

						<?php if ( ! empty( $feature['title'] ) ) : ?>
							<h3 class="feature-title"><?php echo esc_html( $feature['title'] ); ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $feature['description'] ) ) : ?>
							<p class="feature-description"><?php echo wp_kses_post( $feature['description'] ); ?></p>
						<?php endif; ?>
					</div><!-- .feature-item -->
				<?php endforeach; ?>
			</div><!-- .features-grid -->
		<?php endif; ?>
	</div><!-- .container -->
</section><!-- .module-features -->
