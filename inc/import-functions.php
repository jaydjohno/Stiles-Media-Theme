<?php

function ocdi_import_files() 
{
	return array(
		array(
			'import_file_name'             => 'Default Setup',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'import/demo-content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'import/widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'import/customizer.dat',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'import/redux.json',
					'option_name' => 'redux_option_name',
				),
			),
			'import_preview_image_url'     => '',
			'import_notice'                => __( 'Please ensure before running this import that you have Installed Elementor and Elementor Pro' ),
			'preview_url'                  => '',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );

function ocdi_after_import_setup() 
{
	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );

function ocdi_plugin_page_setup( $default_settings ) 
{
	$default_settings['parent_slug'] = 'smw_page';
	$default_settings['page_title']  = esc_html__( 'Stiles Media Import' , 'stiles-media' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'stiles-media' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'stiles-one-click-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'ocdi_plugin_page_setup' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );