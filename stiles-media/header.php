<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package StilesMedia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php $viewport_content = apply_filters( 'stiles_media_viewport_content', 'width=device-width, initial-scale=1' ); ?>
	<meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
    <title>
    <?php 
        if (function_exists('is_tag') && is_tag()) { 
           echo 'Tag Archive for &quot;'.$tag.'&quot; | '; 
        } elseif (is_archive()) { 
           wp_title(''); echo ' Archive | '; 
        } elseif (is_search()) { 
           echo 'Search for &quot;'.wp_specialchars($s).'&quot; | '; 
        } elseif (!(is_404()) && (is_single()) || (is_page()) && !(is_front_page())) { 
           wp_title(''); echo ' | '; 
        } elseif (is_404()) {
           echo 'Not Found | '; 
        }
        elseif( is_front_page()){
            echo '';
        }
        bloginfo('name'); 
    ?>
    </title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
stiles_media_body_open();
?>

<?php

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) 
{
	get_template_part( 'template-parts/header' );
}
