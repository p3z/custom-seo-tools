<?php

/**
 * Kiwi Functions
 *
 * These are the functions that facilitate the Kiwi keywords specific routes
 */
function remove_duplicates($input_vals){
	
	$orig_length = count($input_vals);
	
	$unique_vals = array_unique($input_vals);
	$unique_val_length = count($unique_vals);
	
	$value_freq = array_count_values($input_vals);
	
	$duplicates = [];
	
	foreach($value_freq as $val => $freq){
		if($freq > 1){
			array_push($duplicates, $val);
			
		}
	} // end loop


	$output = [
		'num_individual_keys_removed' => $orig_length - $unique_val_length,
		'duplicates' => $duplicates,
		'values' => $unique_vals
	];
		
	return $output;
	
}

function inList($keyword, $blacklist = [], $matches_only = 0){
		
	for($i = 0; $i < count($blacklist); $i++){
		$black_word = $blacklist[$i];
		
		if($matches_only){
			// Strict mode active
			
			 if( $black_word == $keyword ){
                return true;
            }
			
		} else{
			// Loose mode active
			
			// Check if entry contains current value
            if( strpos($keyword, $black_word ) !== false ){
			//	echo "Loose match! $keyword | $black_word";
			//	echo "<br>";
                return true;
			}
			
		}// end strict mode check
		
	
	} // end loop
return false;
} // end function
