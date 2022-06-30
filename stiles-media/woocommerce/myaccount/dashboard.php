<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<p>
    <?php
    printf(
        /* translators: 1: user display name 2: logout url */
        __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
        '<strong>' . esc_html( $current_user->display_name ) . '</strong>',
        esc_url( wc_logout_url() )
    );
    ?>
</p><br>
            
<p>
	<?php $user = wp_get_current_user();
            
    if( $user && in_array( 'store_manager', $user->roles ) )
    {
        echo 'Welcome to the Family Connects Management Portal from this portal you can view your reports, input your sales information and manage your staff';
        
        echo '<br/><br/>';
        
        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
        
        echo '<br/><br/>';
        
        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
    }
    if( $user && in_array( 'multi_manager', $user->roles ) )
    {
        echo 'Welcome to the Family Connects Management Portal from this portal you can view your reports, input your sales information and manage your staff';
        
        echo '<br/><br/>';
        
        echo 'As you are a multi site manager, you need to set the store that you wish to manage when looking at users, reports etc, if this is not set you will not see the relevant information.';
        
        echo '<br/><br/>';
        
        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
        
        echo '<br/><br/>';
        
        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
    }
    if( $user && in_array( 'senior_manager', $user->roles ) )
    {
        echo 'Welcome to the Family Connects Management Portal from this portal you can view reports, view sales information and manage staff';
        
        echo '<br/><br/>';
        
        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
        
        echo '<br/><br/>';
        
        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
    }
    elseif( $user && in_array( 'employee', $user->roles ) )
    {
        echo 'Welcome to the Family Connects Advisor Portal, from this portal you can check your employee details, browse your current sales target and how close you are to achieving it.';
        
        echo '<br/><br/>';
        
        echo 'If there is any issue with your employee details, or you believe your sales target or sales figures are wrong then speak to your store manager who can have a look at this for you.';
    }
    elseif( $user && in_array( 'senior_advisor', $user->roles ) )
    {
        echo 'Welcome to the Family Connects Advisor Portal, from this portal you can check your employee details, browse your current sales target and how close you are to achieving it, as well as viewing your Stores sales report.';
        
        echo '<br/><br/>';
        
        echo 'If there is any issue with your employee details, or you believe your sales target or sales figures are wrong then speak to your store manager who can have a look at this for you.';
    }
    elseif( $user && in_array( 'administrator', $user->roles ) )
    {
        printf(
            __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
            esc_url( wc_get_endpoint_url( 'orders' ) ),
            esc_url( wc_get_endpoint_url( 'edit-address' ) ),
            esc_url( wc_get_endpoint_url( 'edit-account' ) )
        );
    }
    ?>
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */