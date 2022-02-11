<?php

/**
 * Home redirect router
 *
 * Responsible for creating custom redirects
 */
$home_args = [
	'check_page' => 'home',
	'redirect_to' => 'my-account',
	'condition' => [get_current_user_id(), 0] // Key/value pair
];


	
// Needed to pass args into the hook
add_action( 'redirect_router_config', function() use ($home_args) {
	
	global $post;
	
	$page_slug = $post->post_name;
	$check_page = $home_args['check_page'];	
	$redirect_to = $home_args['redirect_to'];
	$condition_key = $home_args['condition'][0];
	$condition_value = $home_args['condition'][1];
	
	// If current page is check_page, redirect, else proceed
	if($page_slug === $check_page){
		
		if($condition_key !== $condition_value){ // Only redirect those who don't meet the value
			
			wp_redirect( home_url( $redirect_to ) ); //manage-subscription/
			exit(); // always exit
			
		}
		
	}
	

});




// Allows us to hook do_action to a filter. do_action in turn allows us to pass in arguents
function home_router_init() {
	do_action('redirect_router_config', $home_args);
}

add_filter('wp_enqueue_scripts', 'home_router_init');
