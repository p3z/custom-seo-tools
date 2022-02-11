<?php

/**
 * Kiwi Separator Route
 */
add_action( 'rest_api_init', function () {
  register_rest_route( 'shay_custom/v1', 'separate', array(
    'methods' => 'POST',
    'callback' => 'kiwi_separate_keywords'	  
  ) );
} );

// Example: https://kiwikeywords.com/wp-json/shay_custom/v1/filter
function kiwi_separate_keywords( WP_REST_Request $request ){	
	
	$user = wp_get_current_user()->data->ID ?? 0;
	
	if($user === 0){
		return "Error code 724";
	}
	
	$user_keyword_list = explode(",", $request->get_param('keyword_list')) ?? [];
	$user_catchlist = explode(",", $request->get_param('catchlist')) ?? [];
	$user_strict_mode = $request->get_param('use_strict_mode');
	
	$keyword_list = remove_duplicates($user_keyword_list);
	
	$output_catcher = "";
	$was_caught_as_match = [];
	
	$matchlist_output = [];
	$remainderlist_output = [];
	
	
	foreach($keyword_list['values'] as $word){
		
		$is_matchlist_word = inList($word, $user_catchlist, $user_strict_mode);
		$was_caught_as_match[$word] = $is_blackisted_word;
		
		
		if($is_matchlist_word){
			array_push($matchlist_output, $word);
		} else {
			array_push($remainderlist_output, $word);
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
		'catchlist' => $user_catchlist,
		"matchlist_output" => $matchlist_output,
		'remainderlist_output' => $remainderlist_output,
		'was_caught_as_match' => $was_caught_as_match
		
	];
	
	return $data;
	
	 //return json_encode($data);
	
}

