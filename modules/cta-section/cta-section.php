<?php
/**
 * CTA Section Module - cta-section.php
 */

$heading = get_sub_field( 'heading' );
$content = get_sub_field( 'content' );
$button_text = get_sub_field( 'button_text' );
$button_link = get_sub_field( 'button_link' );

$button_url = is_array( $button_link ) ? ( $button_link['url'] ?? '' ) : $button_link;
$button_target = is_array( $button_link ) ? ( $button_link['target'] ?? '' ) : '';
?>

<section class="module module-cta-section">
	<div class="container">
		<div class="cta-section-inner">
			<?php if ( $heading ) : ?>
				<h2 class="section-heading"><?php echo wp_kses_post( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $content ) : ?>
				<div class="section-description"><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>

			<?php if ( function_exists( 'have_rows' ) && have_rows( 'features' ) ) : ?>
				<div class="cta-section-features">
					<?php
					while ( have_rows( 'features' ) ) :
						the_row();
						$icon_id = (int) get_sub_field( 'icon' );
						$title = get_sub_field( 'title' );
						$description = get_sub_field( 'description' );
						?>
						<div class="cta-section-feature">
							<?php if ( $icon_id ) : ?>
								<div class="cta-section-feature-icon">
									<?php echo wp_get_attachment_image( $icon_id, 'thumbnail', false, array( 'class' => 'img-responsive' ) ); ?>
								</div>
							<?php endif; ?>

							<div class="cta-section-feature-body">
								<?php if ( $title ) : ?>
									<h3 class="cta-section-feature-title"><?php echo esc_html( $title ); ?></h3>
								<?php endif; ?>

								<?php if ( $description ) : ?>
									<p class="cta-section-feature-description"><?php echo esc_html( $description ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>

			<?php if ( $button_text && $button_url ) : ?>
				<a class="btn btn-primary" href="<?php echo esc_url( $button_url ); ?>"<?php echo $button_target ? ' target="' . esc_attr( $button_target ) . '" rel="noopener"' : ''; ?>>
					<?php echo esc_html( $button_text ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
