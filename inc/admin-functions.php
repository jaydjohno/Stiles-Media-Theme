<?php
/**
 * Stiles Media admin functions.
 *
 * @package StilesMedia
 */

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @return void
 */
function stiles_media_fail_load_admin_notice() 
{
	// Leave to Elementor Pro to manage this.
	if ( function_exists( 'elementor_pro_load_plugin' ) ) 
	{
		return;
	}

	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	if ( 'true' === get_user_meta( get_current_user_id(), '_stiles_media_install_notice', true ) ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	$installed_plugins = get_plugins();

	$is_elementor_installed = isset( $installed_plugins[ $plugin ] );

	if ( $is_elementor_installed ) 
	{
		if ( ! current_user_can( 'activate_plugins' ) ) 
		{
			return;
		}

		$message = __( 'This Stiles Media theme is a lightweight starter theme designed to work perfectly with Elementor Page Builder plugin. Please install all required plugins and then run the Demo Importer and pick your website type.', 'stiles-media' );

		$button_text = __( 'Activate Elementor', 'stiles-media' );
		$button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) 
		{
			return;
		}

		$message = __( 'This Stiles Media theme is a lightweight starter theme. We recommend you use it together with Elementor Page Builder plugin, they work perfectly together! After Install run all the required plugins and then run the Demo Importer and choose your website type.', 'stiles-media' );

		$button_text = __( 'Install Elementor', 'stiles-media' );
		$button_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
	}

	?>
	<style>
		.notice.stiles-media-notice {
			border-left-color: #9b0a46 !important;
			padding: 20px;
		}
		.rtl .notice.stiles-media-notice {
			border-right-color: #9b0a46 !important;
		}
		.notice.stiles-media-notice .stiles-media-notice-inner {
			display: table;
			width: 100%;
		}
		.notice.stiles-media-notice .stiles-media-notice-inner .stiles-media-notice-icon,
		.notice.stiles-media-notice .stiles-media-notice-inner .stiles-media-notice-content,
		.notice.stiles-media-notice .stiles-media-notice-inner .stiles-media-install-now {
			display: table-cell;
			vertical-align: middle;
		}
		.notice.stiles-media-notice .stiles-media-notice-icon {
			color: #9b0a46;
			font-size: 50px;
			width: 50px;
		}
		.notice.stiles-media-notice .stiles-media-notice-content {
			padding: 0 20px;
		}
		.notice.stiles-media-notice p {
			padding: 0;
			margin: 0;
		}
		.notice.stiles-media-notice h3 {
			margin: 0 0 5px;
		}
		.notice.stiles-media-notice .stiles-media-install-now {
			text-align: center;
		}
		.notice.stiles-media-notice .stiles-media-install-now .stiles-media-install-button {
			padding: 5px 30px;
			height: auto;
			line-height: 20px;
			text-transform: capitalize;
		}
		.notice.stiles-media-notice .stiles-media-install-now .stiles-media-install-button i {
			padding-right: 5px;
		}
		.rtl .notice.stiles-media-notice .stiles-media-install-now .stiles-media-install-button i {
			padding-right: 0;
			padding-left: 5px;
		}
		.notice.stiles-media-notice .stiles-media-install-now .stiles-media-install-button:active {
			transform: translateY(1px);
		}
		@media (max-width: 767px) {
			.notice.stiles-media-notice {
				padding: 10px;
			}
			.notice.stiles-media-notice .stiles-media-notice-inner {
				display: block;
			}
			.notice.stiles-media-notice .stiles-media-notice-inner .stiles-media-notice-content {
				display: block;
				padding: 0;
			}
			.notice.stiles-media-notice .stiles-media-notice-inner .stiles-media-notice-icon,
			.notice.stiles-media-notice .stiles-media-notice-inner .stiles-media-install-now {
				display: none;
			}
		}
	</style>
	<script>jQuery( function( $ ) {
			$( 'div.notice.stiles-media-install-elementor' ).on( 'click', 'button.notice-dismiss', function( event ) {
				event.preventDefault();

				$.post( ajaxurl, {
					action: 'stiles_media_set_admin_notice_viewed'
				} );
			} );
		} );</script>
	<div class="notice updated is-dismissible stiles-media-notice stiles-media-install-elementor">
		<div class="stiles-media-notice-inner">
			<div class="stiles-media-notice-icon">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/stiles-admin-logo.png' ); ?>" alt="Elementor Logo" />
			</div>

			<div class="stiles-media-notice-content">
				<h3><?php esc_html_e( 'Thanks for installing the Stiles Media theme!', 'stiles-media' ); ?></h3>
				<p>
					<p><?php echo esc_html( $message ); ?></p>
					<a href="https://stiles.media" target="_blank"><?php esc_html_e( 'Learn more about Stiles Media and what we do', 'stiles-media' ); ?></a>
				</p>
			</div>

			<div class="stiles-media-install-now">
				<a class="button button-primary stiles-media-install-button" href="<?php echo esc_attr( $button_link ); ?>"><i class="dashicons dashicons-download"></i><?php echo esc_html( $button_text ); ?></a>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Set Admin Notice Viewed.
 *
 * @return void
 */
function ajax_stiles_media_set_admin_notice_viewed() {
	update_user_meta( get_current_user_id(), '_stiles_media_install_notice', 'true' );
	die;
}

add_action( 'wp_ajax_stiles_media_set_admin_notice_viewed', 'ajax_stiles_media_set_admin_notice_viewed' );

if ( ! did_action( 'elementor/loaded' ) ) 
{
	add_action( 'admin_notices', 'stiles_media_fail_load_admin_notice' );
}

if( ! is_stiles_plugin_activated() )
{
    add_action( 'admin_notices', 'plugin_not_activated' );

    function plugin_not_activated() 
    {
        ?>
       <div class="notice notice-error">
          <p><?php _e( 'This Theme requires the Stiles Media Widgets plugin, please install it to get all the Theme features.', 'stiles-media' );?></p>
       </div>
       <?php 
    }
}