<?php

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) 
{
	function is_woocommerce_activated() 
    {
		if ( class_exists( 'woocommerce' ) ) 
        { 
            return true; 
        } 
        else 
        { 
            return false; 
        }
	}
}

/**
 * Check if WP Job Manager is activated
 */
if ( ! function_exists( 'is_job_manager_activated' ) ) 
{
	function is_job_manager_activated() 
    {
        if( function_exists( 'WPJM' ) ) 
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
}
    
if ( ! function_exists( 'is_importer_activated' ) ) 
{
    function is_importer_activated()
    {
        if( class_exists( 'OCDI_Plugin' ) ) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}


if ( ! function_exists( 'is_stiles_plugin_activated' ) ) 
{
    function is_stiles_plugin_activated()
    {
        if( class_exists( 'SMW_Loader' ) ) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}