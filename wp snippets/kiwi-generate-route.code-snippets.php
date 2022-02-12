<?php

/**
 * Kiwi Generate Route
 */
add_action( 'rest_api_init', function () {
  register_rest_route( 'shay_custom/v1', 'generate', array(
    'methods' => 'GET',
    'callback' => 'generate_keywords'	  
  ) );
} );

// Example: https://kiwikeywords.com/wp-json/shay_custom/v1/generate
function generate_keywords( WP_REST_Request $request ){
	
	$user_prompt = sanitize_text_field('yellow'); // This will be the info coming from the request via a form
	
	$API_KEY = OPEN_AI_API_KEY;
	$prompt = "Generate one hundred words that someone might be looking for when searching for the term '" . $user_prompt. "'. Exclude duplicates, questions, brand names, and software names.  Put them in a numbered list.";
	
	$temperature = 1;
	
	//$user = wp_get_current_user()->data->ID ?? 0;
	
	//if($user === 0){
	//	return "Error code 724";
//	}
	
	
$body = array(
    'prompt'    => sanitize_text_field( $prompt ),
    'max_tokens'   => 2000,
    'temperature' => 1
);
	
		
$args = array(
    'body'        => json_encode($body),
	'headers' => [
		'Authorization' => 'Bearer ' . $API_KEY,
		  'content-type' => 'application/json'
	]
);
	
	$response = wp_remote_post( 'https://api.openai.com/v1/engines/text-davinci-001/completions', $args );

	$data = [
		'test' => 'BRUH',
		'body' => $body,
		'response' => $response
	];
	
//	pws_create_log("/home/sites/21b/6/65b8885419/kiwi_logs", "filter_log", $final_output);
	
	return $data;
	
	 //return json_encode($data);
}

