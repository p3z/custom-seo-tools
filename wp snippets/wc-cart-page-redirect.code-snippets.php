<?php

/**
 * WC cart page redirect
 *
 * This isn't a typical ecommerce store. There's only one product, so we dont want a typical cart. If user tries to visit cart page redirect them as needed
 */
add_action( 'wp_enqueue_scripts', 'pws_wc_cart_redirect' );
function pws_wc_cart_redirect() {
	
	// Check if cart page: 
	$is_checkout = is_page('cart');
	
	if($is_checkout){		
		
		
		$cart = WC()->cart->cart_contents;
		$cart_total = count($cart);
		
		// If cart is empty, shdnt be here, redirect them		
		if($cart_total === 0){
			
			$current_user = get_current_user_id();
			
			if($current_user === 0){
				
				wp_redirect( home_url( '/' ) ); //manage-subscription/
				exit(); // always exit
				
			} else {
				wp_redirect( home_url( '/my-account' ) ); //manage-subscription/
				exit(); // always exit
			}
			
			
			

		} // end cart check
		
		
	} // end page check
	
}
