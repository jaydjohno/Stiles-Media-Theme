<?php
/**
 * Theme functions and definitions
 *
 * @package StilesMedia
 */

if ( ! defined( 'ABSPATH' ) ) 
{
	exit; // Exit if accessed directly.
}

require_once get_template_directory() . '/inc/dependencies.php';

include get_template_directory() . "/inc/plugin-checks.php";

if( is_woocommerce_activated() )
{
    include get_template_directory() . "/inc/woocommerce-functions.php";
}

if( is_job_manager_activated() )
{
    include get_template_directory() . "/inc/job-manager-functions.php";
}

if( is_importer_activated() )
{
    include get_template_directory() . "/inc/import-functions.php";
}

add_action('after_switch_theme', 'setup_theme_options');

function setup_theme_options () 
{
    if( get_option('first_theme_activation') === false)
    {
        // Set a flag if the theme activation happened
        add_option('first_theme_activation', true, '', false);

        // stuff here only runs once, when the theme is activated for the 1st time
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure( '/%postname%/' );
    }
}

define( 'STILES_MEDIA_VERSION', '1.0.0' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'stiles_media_setup' ) ) 
{
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function stiles_media_setup() 
    {
		$hook_result = apply_filters_deprecated( 'stiles_media_theme_load_textdomain', [ true ], '1.0', 'stiles_media_load_textdomain' );
		if ( apply_filters( 'stiles_media_load_textdomain', $hook_result ) ) {
			load_theme_textdomain( 'stiles-media', get_template_directory() . '/languages' );
		}

		$hook_result = apply_filters_deprecated( 'stiles_media_theme_register_menus', [ true ], '1.0', 'stiles_media_register_menus' );
		if ( apply_filters( 'stiles_media_register_menus', $hook_result ) ) 
        {
            // This theme uses wp_nav_menu() in four locations.
            register_nav_menus( array(
                'site'   => esc_html__( 'Site Menu', 'stiles-media' ),
                'header'    => esc_html__( 'Header Menu', 'stiles-media' ),
                'footer' => esc_html__( 'Footer Menu', 'stiles-media' ),
                'social' => esc_html__( 'Social Menu', 'stiles-media' ),
            ) );
            
            if(is_woocommerce_activated())
            {
			     register_nav_menus( array( 'shop' => __( 'Shop Menu', 'stiles-media' ) ) );
            }
            
            if(is_job_manager_activated())
            {
			     register_nav_menus( array( 'shop' => __( 'Job Manager Menu', 'stiles-media' ) ) );
            }
		}

		$hook_result = apply_filters_deprecated( 'stiles_media_theme_add_theme_support', [ true ], '1.0', 'stiles_media_add_theme_support' );
		if ( apply_filters( 'stiles_media_add_theme_support', $hook_result ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				)
			);
			add_theme_support(
				'custom-logo',
				array(
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				)
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'editor-style.css' );

			/*
			 * WooCommerce.
			 */
			$hook_result = apply_filters_deprecated( 'stiles_media_theme_add_woocommerce_support', [ true ], '2.0', 'stiles_media_add_woocommerce_support' );
			if ( apply_filters( 'stiles_media_add_woocommerce_support', $hook_result ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
				// Job Manager in general.
                add_theme_support( 'job-manager-templates' );
			}
            
            
            $args = array(
                'default-color' => 'ffffff',
            );
 
            $args = apply_filters( 'stiles_custom_background_args', $args );
 
            if ( function_exists( 'wp_get_theme' ) ) 
            {
                add_theme_support( 'custom-background', $args );
            } else 
            {
                define( 'BACKGROUND_COLOR', $args['default-color'] );
                define( 'BACKGROUND_IMAGE', $args['default-image'] );
                add_custom_background();
            }
            
            if ( function_exists('register_sidebar') ) 
            {
                if(is_woocommerce_activated())
                {
                    register_sidebar(
                        array (
                            'name' => __( 'Shop Sidebar', 'stiles-media' ),
                            'id' => 'stiles-shop-sidebar',
                            'description' => __( 'Stiles Shop Sidebar', 'stiles-media' ),
                            'before_widget' => '<div class="widget-content">',
                            'after_widget' => "</div>",
                            'before_title' => '<h3 class="widget-title">',
                            'after_title' => '</h3>',
                        )
                    ); 
                }
                
                if(is_job_manager_activated())
                {
                    register_sidebar(
                        array (
                            'name' => __( 'Job Manager Sidebar', 'stiles-media' ),
                            'id' => 'stiles-jobs-sidebar',
                            'description' => __( 'Stiles Jobs Sidebar', 'stiles-media' ),
                            'before_widget' => '<div class="widget-content">',
                            'after_widget' => "</div>",
                            'before_title' => '<h3 class="widget-title">',
                            'after_title' => '</h3>',
                        )
                    ); 
                }
                
                register_sidebar(
                    array (
                        'name' => __( 'Footer Widget 1', 'stiles-media' ),
                        'id' => 'stiles-footer-1-sidebar',
                        'description' => __( 'Stiles Footer Widget 1', 'stiles-media' ),
                        'before_widget' => '<div class="widget-content">',
                        'after_widget' => "</div>",
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    )
                ); 
                
                register_sidebar(
                    array (
                        'name' => __( 'Footer Widget 2', 'stiles-media' ),
                        'id' => 'stiles-footer-2-sidebar',
                        'description' => __( 'Stiles Footer Widget 2', 'stiles-media' ),
                        'before_widget' => '<div class="widget-content">',
                        'after_widget' => "</div>",
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    )
                ); 
                
                register_sidebar(
                    array (
                        'name' => __( 'Footer Widget 3', 'stiles-media' ),
                        'id' => 'stiles-footer-3-sidebar',
                        'description' => __( 'Stiles Footer Widget 3', 'stiles-media' ),
                        'before_widget' => '<div class="widget-content">',
                        'after_widget' => "</div>",
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    )
                ); 
                
                register_sidebar(
                    array (
                        'name' => __( 'Footer Widget 4', 'stiles-media' ),
                        'id' => 'stiles-footer-4-sidebar',
                        'description' => __( 'Stiles Footer Widget 4', 'stiles-media' ),
                        'before_widget' => '<div class="widget-content">',
                        'after_widget' => "</div>",
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    )
                );
                
                register_sidebar(
                    array (
                        'name' => __( 'Site Sidebar', 'stiles-media' ),
                        'id' => 'stiles-site-sidebar',
                        'description' => __( 'Stiles Site Sidebar', 'stiles-media' ),
                        'before_widget' => '<div class="widget-content">',
                        'after_widget' => "</div>",
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    )
                );
                
                register_sidebar(
                    array (
                        'name' => __( 'Blog Sidebar', 'stiles-media' ),
                        'id' => 'stiles-blog-sidebar',
                        'description' => __( 'Stiles Blog Sidebar', 'stiles-media' ),
                        'before_widget' => '<div class="widget-content">',
                        'after_widget' => "</div>",
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    )
                );
                
                register_sidebar(
                    array (
                        'name' => __( 'Search Sidebar', 'stiles-media' ),
                        'id' => 'stiles-search-sidebar',
                        'description' => __( 'Stiles Search Sidebar', 'stiles-media' ),
                        'before_widget' => '<div class="widget-content">',
                        'after_widget' => "</div>",
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    )
                );
            }
		}
	}
}
add_action( 'after_setup_theme', 'stiles_media_setup' );

if ( ! function_exists( 'stiles_media_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function stiles_media_scripts_styles() 
    {
		$enqueue_basic_style = apply_filters_deprecated( 'stiles_media_theme_enqueue_style', [ true ], '2.0', 'stiles_media_enqueue_style' );
		$min_suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'stiles_media_enqueue_style', $enqueue_basic_style ) ) 
        {
			wp_enqueue_style(
				'stiles-media',
				get_template_directory_uri() . '/style.css',
				[],
				'STILES_MEDIA_VERSION'
			);
		}

		if ( apply_filters( 'stiles_media_enqueue_theme_style', true ) ) 
        {
			wp_enqueue_style(
				'stiles-media-theme-style',
				get_template_directory_uri() . '/theme.css',
				[],
				'STILES_MEDIA_VERSION'
			);
            
            wp_enqueue_style(
				'stiles-media-screen-fixes-style',
				get_template_directory_uri() . '/assets/css/screen-fixes.css',
				[],
				'STILES_MEDIA_VERSION'
			);
            
            if(is_woocommerce_activated())
            {
                wp_enqueue_style(
                    'stiles-media-woocommerce-style',
                    get_template_directory_uri() . '/assets/css/woocommerce.css',
                    [],
                    'STILES_MEDIA_VERSION'
                );
            }
            
            if(is_job_manager_activated())
            {
                wp_enqueue_style(
                    'stiles-media-job manager-style',
                    get_template_directory_uri() . '/assets/css/job-manager.css',
                    [],
                    'STILES_MEDIA_VERSION'
                );
            }
		}
	}
}
add_action( 'wp_enqueue_scripts', 'stiles_media_scripts_styles' );

if ( ! function_exists( 'stiles_media_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function stiles_media_register_elementor_locations( $elementor_theme_manager ) {
		$hook_result = apply_filters_deprecated( 'stiles_media_theme_register_elementor_locations', [ true ], '2.0', 'stiles_media_register_elementor_locations' );
		if ( apply_filters( 'stiles_media_register_elementor_locations', $hook_result ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'stiles_media_register_elementor_locations' );

if ( ! function_exists( 'stiles_media_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function stiles_media_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'stiles_media_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'stiles_media_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/inc/admin-functions.php';
}

if ( ! function_exists( 'stiles_media_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function stiles_media_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = \Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'stiles_media_page_title', 'stiles_media_check_hide_title' );

/**
 * Wrapper function to deal with backwards compatibility.
 */
if ( ! function_exists( 'stiles_media_body_open' ) ) {
	function stiles_media_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
}

if( is_woocommerce_activated() )
{
    function change_woocommerce_return_to_shop_text( $translated_text, $text, $domain )
    {
        switch ( $translated_text ) 
        {
            case 'Return to shop' :
            $translated_text = __( 'Order Products', 'woocommerce' );
            break;
        }
        return $translated_text; 
    }

    function custom_woocommerce_product_add_to_cart_text() 
    {
        global $product;

        $product_type = $product->product_type;

        switch ( $product_type ) 
        {
            case 'external':
                return __( 'Buy product', 'woocommerce' );
            break;
            case 'grouped':
                return __( 'View products', 'woocommerce' );
            break;
            case 'simple':
                return __( 'View Product', 'woocommerce' );
            break;
            case 'variable':
                return __( 'Select options', 'woocommerce' );
            break;
            default:
                return __( 'Read more', 'woocommerce' );
        }
	
    }
    
    add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
    
    add_filter( 'gettext', 'change_woocommerce_return_to_shop_text', 20, 3 );
}