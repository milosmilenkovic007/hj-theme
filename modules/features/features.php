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
			<div class="features-grid features-grid-<?php echo esc_attr( $columns ); ?>">
				<?php foreach ( $features as $feature ) : ?>
					<div class="feature-item">
						<?php if ( ! empty( $feature['icon'] ) ) : ?>
							<div class="feature-icon">
								<?php echo wp_kses_post( $feature['icon'] ); ?>
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
