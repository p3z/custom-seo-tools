<?php

/**
 * WC Cart Mods
 *
 * Last updated 11/02/22
 */
// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     unset($fields['billing']['billing_company']);
	 unset($fields['billing']['billing_address_1']);
	 unset($fields['billing']['billing_address_2']);
	 unset($fields['billing']['billing_country']);
	 unset($fields['billing']['billing_state']);
	 unset($fields['billing']['billing_city']);
	//
	 unset($fields['billing']['billing_postcode']);
	 unset($fields['billing']['billing_phone']);
//	 unset($fields['billing']['billing_email']);
     return $fields;
} 

// Remove Order Notes Field
add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );

function remove_order_notes( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}


// Removes Order Notes Title - Additional Information & Notes Field
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );


// Remove 'Continue shopping' button from 'added to cart' notice
add_filter('wc_add_to_cart_message_html','remove_continue_shoppping_button',10,2);

function remove_continue_shoppping_button($message, $products) {
    if (strpos($message, 'Continue shopping') !== false) {
        return preg_replace('/<a.*<\/a>/m','', $message);
    } else {
        return $message;
    }
}


// Remove 'cart totals' On checkout page
add_action( 'woocommerce_checkout_order_review', 'remove_checkout_totals', 1 );
function remove_checkout_totals(){
    // Remove cart totals block
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
}

// Remove 'cart totals' Onn cart page
add_action( 'woocommerce_cart_collaterals', 'remove_cart_totals', 9 );
function remove_cart_totals(){
    // Remove cart totals block
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

    // Add back "Proceed to checkout" button (and hooks)
    echo '<div class="cart_totals">';
    do_action( 'woocommerce_before_cart_totals' );

    echo '<div class="wc-proceed-to-checkout">';
    do_action( 'woocommerce_proceed_to_checkout' );
    echo '</div>';

    do_action( 'woocommerce_after_cart_totals' );
    echo '</div><br clear="all">';
}

// Auto Complete all WooCommerce orders
add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );
	
	 wp_redirect( home_url( '/my-account/' ) ); //manage-subscription/
	exit(); // always exit
}

