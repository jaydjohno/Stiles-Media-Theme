<?php

function custom_cart()
{
  echo '<div id="stiles-cart">' ?>

   <?php echo '<div class="stiles-cart-wrapper clearfix">'; ?>
			<?php echo '<div class="tg-container">'; ?>
				<?php echo '<div' ?> <?php echo '" class="wishlist-cart-wrapper clearfix">'; ?>
					<?php
					if ( function_exists( 'YITH_WCWL' ) ) {
						$wishlist_url = YITH_WCWL()->get_wishlist_url();
						?>
						<?php echo '<div class="wishlist-wrapper">' ?>
							<?php echo '<a class="quick-wishlist" href="' ?> <?php echo esc_url( $wishlist_url ); ?> <?php echo'" title="Wishlist">'; ?>
								<?php echo '<i class="fa fa-heart"></i>'; ?>
								<?php echo '<span class="wishlist-value">'; ?> <?php echo absint( yith_wcwl_count_products() ); ?> <?php echo '</span>'; ?>
							<?php echo '</a>'; ?>
						<?php echo '</div>'; ?>
						<?php
					}
					if ( class_exists( 'woocommerce' ) ) : ?>
						<?php echo '<div class="cart-wrapper">'; ?>
							<?php echo '<div class="estore-cart-views">'; ?>

								<?php $cart_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url(); ?>

								<?php echo '<a href="'; ?> <?php echo esc_url( $cart_url ); ?> <?php echo '" class="wcmenucart-contents">'; ?>
									<?php echo '<i class="fa fa-shopping-cart"></i>'; ?>
									<?php echo '<span class="cart-value">' ?> <?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?> <?php echo '</span>'; ?>
								<?php echo '</a>'; ?>

								<?php echo '<div class="my-cart-wrap">'; ?>
									<?php echo '<div class="my-cart">'; ?> <?php esc_html_e( 'Total', 'estore' ); ?> <?php echo'</div>'; ?>
									<?php echo '<div class="cart-total">'; ?> <?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?> <?php echo '</div>'; ?>
								<?php echo '</div>'; ?>
							<?php echo '</div>'; ?>

							<?php the_widget( 'WC_Widget_Cart', '' ); ?>
						<?php echo '</div>'; ?>
					<?php endif; ?>
				<?php echo '</div>'; ?>
			<?php echo '</div>' ?>
		<?php echo '</div>'; ?>
  <?php echo '</div>';
}

function show_cart()
{
  return custom_cart();
}

add_shortcode('stiles-cart', 'show_cart');

function stiles_navbar()
{
  		echo '<div class="bottom-header-wrapper clearfix">
				<div class="tg-container">';
				$menu_location  = 'secondary';
				$menu_locations = get_nav_menu_locations();
				$menu_object    = ( isset( $menu_locations[ $menu_location ] ) ? wp_get_nav_menu_object( $menu_locations[ $menu_location ] ) : null );
				$menu_name      = ( isset( $menu_object->name ) ? $menu_object->name : '' );
				if ( has_nav_menu( $menu_location ) ) {
					?>
					<?php echo '<div class="category-menu">
						<div class="category-toggle">'; ?>
							<?php echo esc_html( $menu_name ); ?> <?php echo'<i class="fa fa-navicon"> </i>
						</div>
						<nav id="category-navigation" class="category-menu-wrapper hide" role="navigation">'; ?>
							<?php wp_nav_menu(
								array(
									'theme_location' => 'secondary',
									'menu_id'        => 'category-menu',
									'fallback_cb'    => 'false',
								)
							);
							?>
						<?php echo '</nav>
					</div>'; ?>
				<?php } 

        echo '<div class="search-user-wrapper clearfix">
            <div class="search-wrapper search-user-block">
                <div class="search-icon">
                    <i class="fa fa-search"> </i>
                </div>
                <div class="header-search-box">
                    <form role="search" method="get" class="searchform" action=" '; ?> <?php echo get_site_url(); ?> <?php echo '">
                        <input type="search" class="search-field" placeholder="Search &hellip;" value="" name="s">
                        <button type="submit" class="searchsubmit" name="submit" value="Search"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="user-wrapper search-user-block">
                <a href="/my-account/"
                title="" class="user-icon"><i
                class="fa fa-user-times"></i></a>
            </div>
        </div>';
  
  echo '<nav id="site-navigation" class="main-navigation" role="navigation">
	<div class="toggle-wrap"><span class="toggle"><i class="fa fa-reorder"> </i></span></div>'; ?>
		<?php wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				)
				);
		?>
	<?php echo '</nav
    	</div>
	</div>';
}

function show_nav()
{
  return stiles_navbar();
}

add_shortcode('stiles-nav', 'show_nav'); 

?>