<?php
/**
 * Packages Showcase Module - packages-showcase.php
 */

$title = get_sub_field( 'title' );
$background_color = get_sub_field( 'background_color' );

$style_attr = '';
if ( $background_color ) {
	$style_attr = ' style="background-color: ' . esc_attr( $background_color ) . ';"';
}

$default_check_icon = get_template_directory_uri() . '/assets/images/HealtCheckUpIstanbulCheckmark.svg';
?>

<section class="module module-packages-showcase"<?php echo $style_attr; ?>>
	<div class="container">
		<?php if ( $title ) : ?>
			<h2 class="section-heading"><?php echo wp_kses_post( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( function_exists( 'have_rows' ) && have_rows( 'packages' ) ) : ?>
			<div class="packages-showcase">
				<?php
				while ( have_rows( 'packages' ) ) :
					the_row();

					$image_id = (int) get_sub_field( 'image' );
					$image_position = get_sub_field( 'image_position' ) ?: 'left';
					$heading = get_sub_field( 'heading' );
					$description = get_sub_field( 'description' );
					$button_text = get_sub_field( 'button_text' );
					$button_link = get_sub_field( 'button_link' );
					$button_url = is_array( $button_link ) ? ( $button_link['url'] ?? '' ) : $button_link;
					$button_target = is_array( $button_link ) ? ( $button_link['target'] ?? '' ) : '';

					$row_class = 'packages-showcase-row packages-showcase-row--image-' . sanitize_html_class( $image_position );
					?>
					<div class="<?php echo esc_attr( $row_class ); ?>">
						<?php if ( $image_id ) : ?>
							<div class="packages-showcase-media">
								<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'img-responsive' ) ); ?>
							</div>
						<?php endif; ?>

						<div class="packages-showcase-content">
							<?php if ( $heading ) : ?>
								<h3 class="packages-showcase-heading"><?php echo wp_kses_post( $heading ); ?></h3>
							<?php endif; ?>

							<?php if ( $description ) : ?>
								<p class="packages-showcase-description"><?php echo wp_kses_post( $description ); ?></p>
							<?php endif; ?>

							<?php if ( function_exists( 'have_rows' ) && have_rows( 'items' ) ) : ?>
								<ul class="packages-showcase-items">
									<?php
									while ( have_rows( 'items' ) ) :
										the_row();
										$icon_id = (int) get_sub_field( 'icon' );
										$text = get_sub_field( 'text' );
										if ( ! $text ) {
											continue;
										}
										?>
										<li class="packages-showcase-item">
											<span class="packages-showcase-item-icon" aria-hidden="true">
												<?php if ( $icon_id ) : ?>
													<?php echo wp_get_attachment_image( $icon_id, 'thumbnail', false, array( 'class' => 'img-responsive' ) ); ?>
												<?php else : ?>
													<img src="<?php echo esc_url( $default_check_icon ); ?>" alt="" />
												<?php endif; ?>
											</span>
											<span class="packages-showcase-item-text"><?php echo esc_html( $text ); ?></span>
										</li>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>

							<?php if ( $button_text && $button_url ) : ?>
								<a class="btn btn-primary" href="<?php echo esc_url( $button_url ); ?>"<?php echo $button_target ? ' target="' . esc_attr( $button_target ) . '" rel="noopener"' : ''; ?>>
									<?php echo esc_html( $button_text ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
