<?php

/**
 * Redirect: Tools - Child pages
 *
 * Protects the tool routes from those who don't have an active subscription
 */
$tools_args = [
	'check_page' => 'tools',
	'redirect_to' => 'my-account',
	'condition' => [get_current_user_id(), 0], // Key/value pair
	'user' => get_current_user_id()
];


	
// Needed to pass args into the hook
add_action( 'redirect_router_config_tools_child', function() use ($tools_args) {
	
	global $post;
		
	$page_slug = $post->post_name;
	$check_page = $tools_args['check_page'];	
	$redirect_to = $tools_args['redirect_to'];
	$condition_key = $tools_args['condition'][0];
	$condition_value = $tools_args['condition'][1];
	$user = $tools_args['user'];
	
	

	// Check if we're on a tools page
	if (strpos($_SERVER['REQUEST_URI'], 'tools') !== false) {
		
		// Check if it's a tool, or just the overview page
		if ( is_page() && $post->post_parent ) {
			
			// Is child page, so check if user has a subscription
			if($user !== 0){ // THey need to be logged in to do this
			

				$customer_orders = [];
				$orders = wc_get_orders(['customer_id' => $user]);

				foreach ( $orders as $order ) {
					$order_num = $order->get_id();

					array_push($customer_orders, $order_num); // $customer_orders now contains all this users orders.
				}

				// Now get active subscriptions
				$active_subscription_ids = get_posts( [
				'post_type'      => 'sumosubscriptions',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_query'     => [
					'relation' => 'AND',
						array(
						'key'     => 'sumo_get_status',
						'value'   => array( 'Active' ),
						'compare' => 'IN',
						),
					],
				] ) ;
			
			
				$active_orders = [];
				foreach ( $active_subscription_ids as $i => $subscription_id ) {

					// Now get orders associated with active subscriptions
					$assoc_order_id = get_post_meta( $subscription_id, 'sumo_get_parent_order_id', true ) ;
					array_push($active_orders, $assoc_order_id); // $active orders now contains only active orders

					echo "--------------------------<br>";

				} // End loop
				
				// Finally see if any of customers orders are active!
				$compare = array_intersect($customer_orders, $active_orders);
				$matches = count($compare);
				
				if($matches === 0){
					// User does not have an active subscription (bounce 'em back)
					
					wp_redirect( home_url( "/my-account/#subscription_required" ) );
					//	exit(); // always exit
					exit;
					
				} else {
					// User has active subscription, let 'em in
					return;
				}
			
			
			} else{	// User not logged in, bounce 'em back
				
				wp_redirect( home_url( "/#sign-in-active" ) );
			//	exit(); // always exit
				exit;
				
			}
	
		
			
		//	echo "Active orders:";
		//	print_r($active_orders);
		//	echo "<br>";
		//	echo "Current user's orders:";
		//	print_r($customer_orders);
				
		
		} 
		
	} // end if

	
	
	
	// Unfinished -> Fix for oxygen builder to prevent accidental redirects 	
//	if (strpos(['REQUEST_URI'], 'ct_builder') !== false) {
//   		return;
//	} else{
////		echo "<h1> Not oxygen page! </h1>";
//	}
	
	// If current page is 'tools', check if it's a child page
	if($check_page === 'tools'){
		
		
		
		// Need to handle oxygen (its currently redirecting when signed in as admin when trying to use oxygen)
		// ?ct_builder=true&ct_inner=true
		
		if($condition_key !== $condition_value){ // Only redirect those who don't meet the value
			
			
			
		//	wp_redirect( home_url( $redirect_to ) ); //manage-subscription/
		//	exit(); // always exit
			
		}
		
	}
	

});




// Allows us to hook do_action to a filter. do_action in turn allows us to pass in arguents
function tools_router_init() {
	do_action('redirect_router_config_tools_child', $home_args);
}

add_filter('wp_enqueue_scripts', 'tools_router_init');
