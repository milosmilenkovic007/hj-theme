<?php
/**
 * ACF Theme Settings
 * Registracija custom theme settings u ACF
 */

function hj_theme_register_acf_settings() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		// Main theme settings
		acf_add_options_page( array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'HJ Theme Settings',
			'menu_slug'  => 'hj-theme-settings',
			// Use edit_theme_options so users who can manage menus can also pick them here.
			'capability' => 'edit_theme_options',
			'redirect'   => false,
			'icon_url'   => 'dashicons-admin-appearance',
			'position'   => 70,
		) );
	}

	// Register footer per-column menu selectors if ACF available
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		acf_add_local_field_group( array(
			'key' => 'group_hj_footer_menus_columns',
			'title' => 'Footer Menu Columns',
			'fields' => array(
				array(
					'key' => 'field_hj_footer_columns_info',
					'label' => 'Footer Columns Info',
					'name' => '',
					'type' => 'message',
					'message' => 'Select which menu appears in each footer column based on the chosen number of columns.',
				),
				// Column 1 title + menu
				array(
					'key' => 'field_hj_footer_title_col_1',
					'label' => 'Footer Column 1 Title',
					'name' => 'footer_title_col_1',
					'type' => 'text',
					'placeholder' => 'Column 1',
					'wrapper' => array( 'width' => 25 ),
				),
				array(
					'key' => 'field_hj_footer_menu_col_1',
					'label' => 'Footer Column 1 Menu',
					'name' => 'footer_menu_col_1',
					'type' => 'select',
					'choices' => hj_theme_get_menus_for_acf_choices(),
					'ui' => 1,
					'allow_null' => 1,
					'wrapper' => array( 'width' => 25 ),
					'conditional_logic' => 0,
				),
				// Column 2 title + menu
				array(
					'key' => 'field_hj_footer_title_col_2',
					'label' => 'Footer Column 2 Title',
					'name' => 'footer_title_col_2',
					'type' => 'text',
					'placeholder' => 'Column 2',
					'wrapper' => array( 'width' => 25 ),
					'conditional_logic' => array(
						array(
							array(
								'field' => 'footer_columns',
								'operator' => '>=',
								'value' => '2',
							),
						),
					),
				),
				array(
					'key' => 'field_hj_footer_menu_col_2',
					'label' => 'Footer Column 2 Menu',
					'name' => 'footer_menu_col_2',
					'type' => 'select',
					'choices' => hj_theme_get_menus_for_acf_choices(),
					'ui' => 1,
					'allow_null' => 1,
					'wrapper' => array( 'width' => 25 ),
					'conditional_logic' => array(
						array(
							array(
								'field' => 'footer_columns',
								'operator' => '>=',
								'value' => '2',
							),
						),
					),
				),
				// Column 3 title + menu
				array(
					'key' => 'field_hj_footer_title_col_3',
					'label' => 'Footer Column 3 Title',
					'name' => 'footer_title_col_3',
					'type' => 'text',
					'placeholder' => 'Column 3',
					'wrapper' => array( 'width' => 25 ),
					'conditional_logic' => array(
						array(
							array(
								'field' => 'footer_columns',
								'operator' => '>=',
								'value' => '3',
							),
						),
					),
				),
				array(
					'key' => 'field_hj_footer_menu_col_3',
					'label' => 'Footer Column 3 Menu',
					'name' => 'footer_menu_col_3',
					'type' => 'select',
					'choices' => hj_theme_get_menus_for_acf_choices(),
					'ui' => 1,
					'allow_null' => 1,
					'wrapper' => array( 'width' => 25 ),
					'conditional_logic' => array(
						array(
							array(
								'field' => 'footer_columns',
								'operator' => '>=',
								'value' => '3',
							),
						),
					),
				),
				// Column 4 title + menu
				array(
					'key' => 'field_hj_footer_title_col_4',
					'label' => 'Footer Column 4 Title',
					'name' => 'footer_title_col_4',
					'type' => 'text',
					'placeholder' => 'Column 4',
					'wrapper' => array( 'width' => 25 ),
					'conditional_logic' => array(
						array(
							array(
								'field' => 'footer_columns',
								'operator' => '==',
								'value' => '4',
							),
						),
					),
				),
				array(
					'key' => 'field_hj_footer_menu_col_4',
					'label' => 'Footer Column 4 Menu',
					'name' => 'footer_menu_col_4',
					'type' => 'select',
					'choices' => hj_theme_get_menus_for_acf_choices(),
					'ui' => 1,
					'allow_null' => 1,
					'wrapper' => array( 'width' => 25 ),
					'conditional_logic' => array(
						array(
							array(
								'field' => 'footer_columns',
								'operator' => '==',
								'value' => '4',
							),
						),
					),
				),
				// Contact block settings
				array(
					'key' => 'field_hj_footer_contact_column',
					'label' => 'Contact Column',
					'name' => 'footer_contact_column',
					'type' => 'select',
					'choices' => array(
						'0' => 'Disabled',
						'1' => 'Column 1',
						'2' => 'Column 2',
						'3' => 'Column 3',
						'4' => 'Column 4',
					),
					'default_value' => '0',
					'ui' => 1,
					'wrapper' => array( 'width' => 25 ),
				),
				array(
					'key' => 'field_hj_footer_contact_title',
					'label' => 'Contact Title',
					'name' => 'footer_contact_title',
					'type' => 'text',
					'placeholder' => 'Contact Us',
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_hj_footer_contact_column',
								'operator' => '!=',
								'value' => '0',
							),
						),
					),
				),
				array(
					'key' => 'field_hj_footer_contact_address',
					'label' => 'Contact Address',
					'name' => 'footer_contact_address',
					'type' => 'textarea',
					'rows' => 3,
					'new_lines' => 'br',
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_hj_footer_contact_column',
								'operator' => '!=',
								'value' => '0',
							),
						),
					),
				),
				array(
					'key' => 'field_hj_footer_contact_email',
					'label' => 'Contact Email',
					'name' => 'footer_contact_email',
					'type' => 'email',
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_hj_footer_contact_column',
								'operator' => '!=',
								'value' => '0',
							),
						),
					),
				),
				array(
					'key' => 'field_hj_footer_contact_phone',
					'label' => 'Contact Phone',
					'name' => 'footer_contact_phone',
					'type' => 'text',
					'placeholder' => '+90 555 086 91 12',
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_hj_footer_contact_column',
								'operator' => '!=',
								'value' => '0',
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'hj-theme-settings',
					),
				),
			),
			'menu_order' => 100,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		) );
	}
}
add_action( 'acf/init', 'hj_theme_register_acf_settings' );

/**
 * Helper to provide ACF choices for menus
 * Returns array id => name for all registered menus
 */
function hj_theme_get_menus_for_acf_choices() {
    $choices = array();
    $menus = wp_get_nav_menus();
    if ( ! is_array( $menus ) ) {
        return $choices;
    }
    foreach ( $menus as $menu ) {
        $choices[ (string) $menu->term_id ] = $menu->name;
    }
    return $choices;
}
