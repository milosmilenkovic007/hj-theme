<?php
/**
 * Testimonials Module - testimonials.php
 */

$heading = get_sub_field( 'heading' );
$description = get_sub_field( 'description' );
$testimonials = get_sub_field( 'testimonials' );

$excerpt_limit = 240;

$testimonial_count = is_array( $testimonials ) ? count( $testimonials ) : 0;

?>

<section class="module module-testimonials">
	<div class="container">
		<?php if ( $heading ) : ?>
			<h2 class="section-heading"><?php echo wp_kses_post( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="section-description"><?php echo wp_kses_post( $description ); ?></p>
		<?php endif; ?>

		<?php if ( function_exists( 'have_rows' ) && have_rows( 'testimonials' ) ) : ?>
			<div class="testimonials-grid" data-testimonials="<?php echo esc_attr( $testimonial_count ); ?>">
				<?php
				$index = 0;
				while ( have_rows( 'testimonials' ) ) :
					the_row();
					$index++;
					$text = get_sub_field( 'text' );
					$image_id = (int) get_sub_field( 'image' );
					$name = get_sub_field( 'name' );
					$title = get_sub_field( 'title' );
					$rating = (int) get_sub_field( 'rating' );

					$plain_text = is_string( $text ) ? trim( wp_strip_all_tags( $text ) ) : '';
					$text_length = function_exists( 'mb_strlen' ) ? mb_strlen( $plain_text ) : strlen( $plain_text );
					$is_long = $text_length > $excerpt_limit;
					$excerpt = $is_long ? ( ( function_exists( 'mb_substr' ) ? mb_substr( $plain_text, 0, $excerpt_limit ) : substr( $plain_text, 0, $excerpt_limit ) ) . '…' ) : $plain_text;
					$full_id = 'testimonial-full-' . $index;
					?>
					<div class="testimonial-item">
						<div class="testimonial-author">
							<?php if ( $image_id ) : ?>
								<div class="author-image">
									<?php echo wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'class' => 'img-responsive' ) ); ?>
								</div><!-- .author-image -->
							<?php endif; ?>

							<div class="author-info">
								<?php if ( $name ) : ?>
									<h4 class="author-name"><?php echo esc_html( $name ); ?></h4>
								<?php endif; ?>

								<?php if ( $title ) : ?>
									<p class="author-title"><?php echo esc_html( $title ); ?></p>
								<?php endif; ?>

								<?php if ( $rating ) : ?>
									<div class="author-rating" data-rating="<?php echo esc_attr( $rating ); ?>">
										<?php
										for ( $i = 1; $i <= 5; $i++ ) {
											echo ( $i <= $rating ) ? '★' : '☆';
										}
										?>
									</div><!-- .author-rating -->
								<?php endif; ?>
							</div><!-- .author-info -->
						</div><!-- .testimonial-author -->

						<div class="testimonial-content">
							<?php if ( $plain_text ) : ?>
								<p class="testimonial-text testimonial-text--excerpt"><?php echo esc_html( $excerpt ); ?></p>
								<div id="<?php echo esc_attr( $full_id ); ?>" class="testimonial-text testimonial-text--full" hidden>
									<?php echo wp_kses_post( $text ); ?>
								</div>
								<?php if ( $is_long ) : ?>
									<button type="button" class="testimonial-readmore" aria-expanded="false" aria-controls="<?php echo esc_attr( $full_id ); ?>">
										Read more
									</button>
								<?php endif; ?>
							<?php endif; ?>
						</div><!-- .testimonial-content -->
					</div><!-- .testimonial-item -->
				<?php endwhile; ?>
			</div><!-- .testimonials-grid -->
		<?php elseif ( $testimonials && is_array( $testimonials ) ) : ?>
			<div class="testimonials-grid" data-testimonials="<?php echo esc_attr( count( $testimonials ) ); ?>">
				<?php foreach ( $testimonials as $index => $testimonial ) : ?>
					<?php
						$text = isset( $testimonial['text'] ) ? $testimonial['text'] : '';
						$plain_text = is_string( $text ) ? trim( wp_strip_all_tags( $text ) ) : '';
						$text_length = function_exists( 'mb_strlen' ) ? mb_strlen( $plain_text ) : strlen( $plain_text );
						$is_long = $text_length > $excerpt_limit;
						$excerpt = $is_long ? ( ( function_exists( 'mb_substr' ) ? mb_substr( $plain_text, 0, $excerpt_limit ) : substr( $plain_text, 0, $excerpt_limit ) ) . '…' ) : $plain_text;
						$full_id = 'testimonial-full-array-' . ( (int) $index + 1 );
					?>
					<div class="testimonial-item">
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

						<div class="testimonial-content">
							<?php if ( $plain_text ) : ?>
								<p class="testimonial-text testimonial-text--excerpt"><?php echo esc_html( $excerpt ); ?></p>
								<div id="<?php echo esc_attr( $full_id ); ?>" class="testimonial-text testimonial-text--full" hidden>
									<?php echo wp_kses_post( $text ); ?>
								</div>
								<?php if ( $is_long ) : ?>
									<button type="button" class="testimonial-readmore" aria-expanded="false" aria-controls="<?php echo esc_attr( $full_id ); ?>">
										Read more
									</button>
								<?php endif; ?>
							<?php endif; ?>
						</div><!-- .testimonial-content -->
					</div><!-- .testimonial-item -->
				<?php endforeach; ?>
			</div><!-- .testimonials-grid -->
		<?php endif; ?>
	</div><!-- .container -->
</section><!-- .module-testimonials -->
