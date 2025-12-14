<?php
/**
 * Hero Module - hero.php
 */

$title = get_sub_field( 'title' );
$subtitle = get_sub_field( 'subtitle' );
$description = get_sub_field( 'description' );
$media_type = get_sub_field( 'media_type' ) ?: 'image';
$image = get_sub_field( 'image' );
$youtube_url = get_sub_field( 'youtube_url' );
$cta_text = get_sub_field( 'cta_text' );
$cta_link = get_sub_field( 'cta_link' );
$background_color = get_sub_field( 'background_color' ) ?: '#ffffff';

// Extract YouTube video ID from URL
$youtube_id = '';
if ( $media_type === 'video' && $youtube_url ) {
	preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtube_url, $matches );
	if ( ! empty( $matches[1] ) ) {
		$youtube_id = $matches[1];
	}
}

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

			<?php if ( $media_type === 'image' && $image ) : ?>
				<div class="hero-image">
					<?php echo wp_get_attachment_image( $image, 'large', false, array( 'class' => 'img-responsive' ) ); ?>
				</div><!-- .hero-image -->
			<?php elseif ( $media_type === 'video' && $youtube_id ) : ?>
				<div class="hero-video">
					<div class="video-wrapper" data-video-id="<?php echo esc_attr( $youtube_id ); ?>" onclick="playHeroVideo(this)">
						<img 
							src="https://img.youtube.com/vi/<?php echo esc_attr( $youtube_id ); ?>/maxresdefault.jpg" 
							alt="Video Thumbnail" 
							class="video-thumbnail"
							onerror="this.src='https://img.youtube.com/vi/<?php echo esc_attr( $youtube_id ); ?>/hqdefault.jpg'"
						>
						<button class="video-play-button" aria-label="Play video">
						<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="40" cy="40" r="38" stroke="white" stroke-width="3" fill="rgba(255,255,255,0.15)"/>
							<path d="M32 25L55 40L32 55V25Z" fill="white"/>
							</svg>
						</button>
					</div>
				</div><!-- .hero-video -->
				<script>
					function playHeroVideo(wrapper) {
						const videoId = wrapper.getAttribute('data-video-id');
						if (!videoId) return;
						
						const iframe = document.createElement('iframe');
						iframe.setAttribute('width', '100%');
						iframe.setAttribute('height', '100%');
						iframe.setAttribute('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1');
						iframe.setAttribute('title', 'YouTube video player');
						iframe.setAttribute('frameborder', '0');
						iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
						iframe.setAttribute('allowfullscreen', '');
						iframe.style.position = 'absolute';
						iframe.style.top = '0';
						iframe.style.left = '0';
						iframe.style.width = '100%';
						iframe.style.height = '100%';
						
						wrapper.innerHTML = '';
						wrapper.appendChild(iframe);
					}
				</script>
			<?php endif; ?>
		</div><!-- .hero-content -->
	</div><!-- .container -->
</section><!-- .module-hero -->
