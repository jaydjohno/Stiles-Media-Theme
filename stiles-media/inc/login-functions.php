<?php

$id = get_site_option( 'custom_login_url' );
$url = get_permalink( $id );

function redirect_wpLogin()
{
  global $pagenow;
  if( 'wp-login.php' == $pagenow ) {
    if ( isset( $_POST['wp-submit'] ) ||   // in case of LOGIN
      ( isset($_GET['action']) && $_GET['action']=='logout') ||   // in case of LOGOUT
      ( isset($_GET['checkemail']) && $_GET['checkemail']=='confirm') ||   // in case of LOST PASSWORD
      ( isset($_GET['checkemail']) && $_GET['checkemail']=='registered') ) return;    // in case of REGISTER
    else wp_redirect( home_url('/login') ); // or wp_redirect(home_url('/login'));
    exit();
  }
}

add_action('init','redirect_wpLogin');


function auto_redirect_external_after_logout()
{
    wp_redirect( $url . '?loggedout=true' );
    exit();
}

add_action('wp_logout','auto_redirect_external_after_logout');

if(is_woocommerce_activated())
{
    function stiles_login_redirect( $redirect_to, $request, $user ) 
    {
        if ( ! is_wp_error( $user ) ) 
        {
            // do redirects on successful login
            if ( $user->has_cap( 'administrator' ) || $user->has_cap( 'shop_manager' ) ) 
            {
                return admin_url( );
            } else 
            {
                return site_url();
            }
        } else 
        {
            // display errors, basically
            return $redirect_to;
        }
    }
    
    add_filter( 'login_redirect', 'stiles_login_redirect', 10, 3 );
}