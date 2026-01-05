<?php
/**
 * Packages Details Module - packages-details.php
 */

$heading = get_sub_field( 'heading' );
$description = get_sub_field( 'description' );
$packages = get_sub_field( 'packages' );
$additional_package = get_sub_field( 'additional_package' );

if ( is_array( $additional_package ) ) {
	$additional_package = $additional_package[0] ?? null;
}

$packages = is_array( $packages ) ? array_values( array_filter( $packages ) ) : array();

if ( empty( $packages ) && ! $additional_package ) {
	return;
}

$instance_id = 'hj-packages-details-' . uniqid();

$default_check_icon = get_template_directory_uri() . '/assets/images/HealtCheckUpIstanbulCheckmark.svg';

$render_include_sections = function ( $post_id ) use ( $default_check_icon ) {
	$include_sections = function_exists( 'get_field' ) ? get_field( 'include_sections', $post_id ) : array();
	$include_sections = is_array( $include_sections ) ? $include_sections : array();

	if ( empty( $include_sections ) ) {
		echo '<p class="packages-details-empty">' . esc_html__( 'No details available.', 'hj-theme' ) . '</p>';
		return;
	}

	echo '<div class="packages-details-accordions">';

	foreach ( $include_sections as $index => $section ) {
		$title_1 = isset( $section['title_line_1'] ) ? trim( (string) $section['title_line_1'] ) : '';
		$title_2 = isset( $section['title_line_2'] ) ? trim( (string) $section['title_line_2'] ) : '';
		$title = trim( $title_1 . ' ' . $title_2 );
		$items = isset( $section['items'] ) && is_array( $section['items'] ) ? $section['items'] : array();

		if ( ! $title && empty( $items ) ) {
			continue;
		}

		$accordion_id = 'packages-details-acc-' . (int) $post_id . '-' . (int) $index . '-' . uniqid();
		$is_biochem = $title && stripos( $title, 'biochemistry' ) !== false;
		?>
		<div class="packages-details-accordion">
			<button type="button" class="packages-details-accordion-toggle" aria-expanded="false" aria-controls="<?php echo esc_attr( $accordion_id ); ?>">
				<span class="packages-details-accordion-title"><?php echo esc_html( $title ?: __( 'Details', 'hj-theme' ) ); ?></span>
				<span class="packages-details-accordion-icon" aria-hidden="true"></span>
			</button>
			<div id="<?php echo esc_attr( $accordion_id ); ?>" class="packages-details-accordion-panel" hidden>
				<?php if ( ! empty( $items ) ) : ?>
					<ul class="packages-details-items<?php echo $is_biochem ? ' packages-details-items--biochemistry' : ''; ?>">
						<?php foreach ( $items as $item ) : ?>
							<?php
							$text = isset( $item['text'] ) ? trim( (string) $item['text'] ) : '';
							if ( ! $text ) {
								continue;
							}
							?>
							<li class="packages-details-item">
								<span class="packages-details-item-icon" aria-hidden="true">
									<img src="<?php echo esc_url( $default_check_icon ); ?>" alt="" />
								</span>
								<span class="packages-details-item-text"><?php echo esc_html( $text ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	echo '</div>';
};
?>

<section class="module module-packages-details" data-packages-details="<?php echo esc_attr( $instance_id ); ?>">
	<div class="container">
		<?php if ( $heading ) : ?>
			<h2 class="section-heading"><?php echo wp_kses_post( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="section-description"><?php echo wp_kses_post( $description ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $packages ) ) : ?>
			<div class="packages-details-tabs" role="tablist" aria-label="<?php echo esc_attr__( 'Packages', 'hj-theme' ); ?>">
				<?php foreach ( $packages as $idx => $package_post ) : ?>
					<?php
					$post_id = is_object( $package_post ) ? (int) $package_post->ID : (int) $package_post;
					$tab_id = $instance_id . '-tab-' . $post_id;
					$panel_id = $instance_id . '-panel-' . $post_id;
					?>
					<button
						type="button"
						class="packages-details-tab"
						role="tab"
						id="<?php echo esc_attr( $tab_id ); ?>"
						aria-controls="<?php echo esc_attr( $panel_id ); ?>"
						aria-selected="<?php echo $idx === 0 ? 'true' : 'false'; ?>"
					>
						<?php echo esc_html( get_the_title( $post_id ) ); ?>
					</button>
				<?php endforeach; ?>
			</div>

			<div class="packages-details-panels">
				<?php foreach ( $packages as $idx => $package_post ) : ?>
					<?php
					$post_id = is_object( $package_post ) ? (int) $package_post->ID : (int) $package_post;
					$tab_id = $instance_id . '-tab-' . $post_id;
					$panel_id = $instance_id . '-panel-' . $post_id;
					$price = function_exists( 'get_field' ) ? get_field( 'price', $post_id ) : '';
					$short_description = function_exists( 'get_field' ) ? get_field( 'short_description', $post_id ) : '';
					?>
					<div
						id="<?php echo esc_attr( $panel_id ); ?>"
						class="packages-details-panel"
						role="tabpanel"
						aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
						<?php echo $idx === 0 ? '' : 'hidden'; ?>
					>
						<div class="packages-details-panel-header">
							<h3 class="packages-details-title"><?php echo esc_html( get_the_title( $post_id ) ); ?></h3>
							<?php if ( $price ) : ?>
								<p class="packages-details-price"><?php echo esc_html( $price ); ?></p>
							<?php endif; ?>
							<?php if ( $short_description ) : ?>
								<p class="packages-details-summary"><?php echo esc_html( $short_description ); ?></p>
							<?php endif; ?>
						</div>

						<?php $render_include_sections( $post_id ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $additional_package ) : ?>
			<?php
			$additional_post_id = is_object( $additional_package ) ? (int) $additional_package->ID : (int) $additional_package;
			$additional_id = $instance_id . '-additional';
			?>
			<div class="packages-details-additional-wrap">
				<button type="button" class="packages-details-additional-toggle" aria-expanded="false" aria-controls="<?php echo esc_attr( $additional_id ); ?>">
					<?php echo esc_html__( 'Show additional package', 'hj-theme' ); ?>: <?php echo esc_html( get_the_title( $additional_post_id ) ); ?>
				</button>
				<div id="<?php echo esc_attr( $additional_id ); ?>" class="packages-details-additional" hidden>
					<div class="packages-details-panel-header">
						<h3 class="packages-details-title"><?php echo esc_html( get_the_title( $additional_post_id ) ); ?></h3>
					</div>
					<?php $render_include_sections( $additional_post_id ); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
