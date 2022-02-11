<?php

/**
 * Kiwi Filter Route
 */
add_action( 'rest_api_init', function () {
  register_rest_route( 'shay_custom/v1', 'filter', array(
    'methods' => 'POST',
    'callback' => 'filter_keywords'	  
  ) );
} );

// Example: https://kiwikeywords.com/wp-json/shay_custom/v1/filter
function filter_keywords( WP_REST_Request $request ){
	
	$user = wp_get_current_user()->data->ID ?? 0;
	
	if($user === 0){
		return "Error code 724";
	}
	
	$user_keyword_list = explode(",", $request->get_param('keyword_list')) ?? [];
	$user_blacklist = explode(",", $request->get_param('blacklist')) ?? [];
	$user_strict_mode = $request->get_param('use_strict_mode');
	
	
		
	
	$keyword_list = remove_duplicates($user_keyword_list);
	
	$final_output = [];
	$output_catcher = "";
	$was_caught_as_match = [];
	
	
	foreach($keyword_list['values'] as $word){
		
		$is_blackisted_word = inList($word, $user_blacklist, $user_strict_mode);
		$was_caught_as_match[$word] = $is_blackisted_word;
		
	
		 if(!$is_blackisted_word){
			 array_push($final_output, $word);
		 }
	} // end loop

	if($user_strict_mode === "1"){
		$mode = 'strict';
	} else{
		$mode = 'loose';
	}
	
	
		
	$data = [
		'user' => $user,
		'mode' => $mode,
		'is_strict_mode' => $user_strict_mode,
		'orig_keyword_list' => $user_keyword_list,
		'exclusions' => $dummy_blacklist,
		"output" => $final_output,
		'was_caught_as_match' => $was_caught_as_match
		
	];
	
	return $data;
	
	 //return json_encode($data);
}

