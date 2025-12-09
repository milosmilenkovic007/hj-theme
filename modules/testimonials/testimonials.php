<?php
/**
 * Testimonials Module - testimonials.php
 */

$heading = get_sub_field( 'heading' );
$description = get_sub_field( 'description' );
$testimonials = get_sub_field( 'testimonials' );

?>

<section class="module module-testimonials">
	<div class="container">
		<?php if ( $heading ) : ?>
			<h2 class="section-heading"><?php echo wp_kses_post( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="section-description"><?php echo wp_kses_post( $description ); ?></p>
		<?php endif; ?>

		<?php if ( $testimonials && is_array( $testimonials ) ) : ?>
			<div class="testimonials-slider" data-testimonials="<?php echo esc_attr( count( $testimonials ) ); ?>">
				<?php foreach ( $testimonials as $testimonial ) : ?>
					<div class="testimonial-item">
						<div class="testimonial-content">
							<p class="testimonial-text"><?php echo wp_kses_post( $testimonial['text'] ); ?></p>
						</div><!-- .testimonial-content -->

						<div class="testimonial-author">
							<?php if ( ! empty( $testimonial['image'] ) ) : ?>
								<div class="author-image">
									<?php echo wp_get_attachment_image( $testimonial['image'], 'thumbnail', false, array( 'class' => 'img-responsive' ) ); ?>
								</div><!-- .author-image -->
							<?php endif; ?>

							<div class="author-info">
								<?php if ( ! empty( $testimonial['name'] ) ) : ?>
									<h4 class="author-name"><?php echo esc_html( $testimonial['name'] ); ?></h4>
								<?php endif; ?>

								<?php if ( ! empty( $testimonial['title'] ) ) : ?>
									<p class="author-title"><?php echo esc_html( $testimonial['title'] ); ?></p>
								<?php endif; ?>

								<?php if ( ! empty( $testimonial['rating'] ) ) : ?>
									<div class="author-rating" data-rating="<?php echo esc_attr( $testimonial['rating'] ); ?>">
										<?php
										for ( $i = 1; $i <= 5; $i++ ) {
											echo ( $i <= $testimonial['rating'] ) ? '★' : '☆';
										}
										?>
									</div><!-- .author-rating -->
								<?php endif; ?>
							</div><!-- .author-info -->
						</div><!-- .testimonial-author -->
					</div><!-- .testimonial-item -->
				<?php endforeach; ?>
			</div><!-- .testimonials-slider -->
		<?php endif; ?>
	</div><!-- .container -->
</section><!-- .module-testimonials -->
