<?php
/**
 * ACF Custom Blocks Registration
 */

function hj_register_acf_blocks() {
	// Text & Image Module Block
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( array(
			'name'            => 'text-image',
			'title'           => 'Text & Image',
			'description'     => 'Text content with image or video',
			'render_template' => HJ_THEME_DIR . '/blocks/text-image.php',
			'category'        => 'layout',
			'icon'            => 'format-image',
			'keywords'        => array( 'text', 'image', 'video', 'media' ),
			'supports'        => array(
				'align'  => false,
				'anchor' => true,
			),
			'enqueue_style'   => HJ_THEME_URI . '/assets/css/blocks.css',
		) );
	}
}
add_action( 'acf/init', 'hj_register_acf_blocks' );

/**
 * Register Text & Image block ACF fields
 */
function hj_register_text_image_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'      => 'group_hj_text_image_block',
		'title'    => 'Text & Image Block',
		'fields'   => array(
			array(
				'key'      => 'field_hj_ti_heading',
				'label'    => 'Heading',
				'name'     => 'heading',
				'type'     => 'text',
				'required' => 0,
			),
			array(
				'key'      => 'field_hj_ti_subheading',
				'label'    => 'Subheading',
				'name'     => 'subheading',
				'type'     => 'text',
				'required' => 0,
			),
			array(
				'key'      => 'field_hj_ti_content',
				'label'    => 'Content',
				'name'     => 'content',
				'type'     => 'wysiwyg',
				'required' => 0,
				'tabs'     => 'all',
				'toolbar'  => 'full',
			),
			array(
				'key'          => 'field_hj_ti_media',
				'label'        => 'Image / Video',
				'name'         => 'media',
				'type'         => 'image',
				'required'     => 0,
				'return_format' => 'id',
				'preview_size' => 'large',
				'library'      => 'all',
			),
			array(
				'key'     => 'field_hj_ti_position',
				'label'   => 'Image Position',
				'name'    => 'position',
				'type'    => 'radio',
				'choices' => array(
					'left'  => 'Left',
					'right' => 'Right',
				),
				'default_value' => 'right',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			),
			array(
				'key'     => 'field_hj_ti_layout',
				'label'   => 'Layout',
				'name'    => 'layout',
				'type'    => 'radio',
				'choices' => array(
					'container'  => 'Container',
					'fullwidth'  => 'Full Width',
				),
				'default_value' => 'container',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			),
			array(
				'key'   => 'field_hj_ti_bg_color',
				'label' => 'Background Color',
				'name'  => 'bg_color',
				'type'  => 'color_picker',
				'required' => 0,
				'default_value' => '#ffffff',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'block',
					'operator' => '==',
					'value'    => 'acf/text-image',
				),
			),
		),
	) );
}
add_action( 'acf/init', 'hj_register_text_image_fields' );
