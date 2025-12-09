<?php
/**
 * Hero Module - hero.php
 */

$title = get_sub_field( 'title' );
$subtitle = get_sub_field( 'subtitle' );
$description = get_sub_field( 'description' );
$image = get_sub_field( 'image' );
$cta_text = get_sub_field( 'cta_text' );
$cta_link = get_sub_field( 'cta_link' );
$background_color = get_sub_field( 'background_color' ) ?: '#ffffff';

?>

<section class="module module-hero" style="background-color: <?php echo esc_attr( $background_color ); ?>;">
	<div class="container">
		<div class="hero-content">
			<div class="hero-text">
				<?php if ( $title ) : ?>
					<h1 class="hero-title"><?php echo wp_kses_post( $title ); ?></h1>
				<?php endif; ?>

				<?php if ( $subtitle ) : ?>
					<h2 class="hero-subtitle"><?php echo wp_kses_post( $subtitle ); ?></h2>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<p class="hero-description"><?php echo wp_kses_post( $description ); ?></p>
				<?php endif; ?>

				<?php if ( $cta_text && $cta_link ) : ?>
					<a href="<?php echo esc_url( $cta_link ); ?>" class="btn btn-primary">
						<?php echo esc_html( $cta_text ); ?>
					</a>
				<?php endif; ?>
			</div><!-- .hero-text -->

			<?php if ( $image ) : ?>
				<div class="hero-image">
					<?php echo wp_get_attachment_image( $image, 'large', false, array( 'class' => 'img-responsive' ) ); ?>
				</div><!-- .hero-image -->
			<?php endif; ?>
		</div><!-- .hero-content -->
	</div><!-- .container -->
</section><!-- .module-hero -->
