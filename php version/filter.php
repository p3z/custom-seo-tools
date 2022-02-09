<?php
	
// Use js on front end to turn list into array (pretty standard) -> pass it up as json

$dummy_input = ["Saab", "Volvo", "BMW", "BMW", "BMW", "Saab", "BMW"];

// Parse through an array of strings and remove duplicates
// Returns an assoc. array containing the number of duplicates removed
//and the resulting array
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

	}


	$output = [
		'num_individual_keys_removed' => $orig_length - $unique_val_length,
		'duplicates' => $duplicates,
		'values' => $unique_vals
	];
	
	
	
	return $output;
	
}

$keyword_list = remove_duplicates($dummy_input);
///////////////////////////////////////////////////
function inList($keyword, $blacklist = [], $matches_only = 0){
	
	echo "Mode:";
	echo $matches_only;
	echo "<br><br>";
	
	for($i = 0; $i < count($blacklist); $i++){
		$black_word = $blacklist[$i];
		
		if($matches_only){
			// Strict mode active
			
			 if( $black_word == $keyword ){
				 
				 echo "Strict match! $keyword | $black_word";
                echo "<br>";
				 echo "<br>";
                // If match, return true
                return true;

            }
			//else{
			//	echo "What was this?";
             //   echo $black_word | $keyword;
			//	 echo "<br>";
			//	 echo "<br>";
			//}
		} else{
			// Loose mode active
			
			// Check if entry contains current value
            if( strpos($black_word, $keyword, ) !== false ){
				echo "Loose match! $keyword | $black_word";
				echo "<br>";
                return true;
			}
			//else{
			//	echo "What was this?";
             //   echo $black_word;
			//}
			
		}// end strict mode check
		
	
	} // end loop

} // end function












echo count($keyword_list['values']);
echo "<br>";
print_r($keyword_list['values']);
echo "<h1>End:</h1>";
$output = inList("BM", $keyword_list['values'], 1);
echo $output;


// This is the actual app below:

$final_output = [];
$exceptions = $dummy_input = [];
$use_strict_mode = 1;
$output_catcher = "";

foreach($keyword_list['values'] as $word){
	$is_blackisted_word = inList($word, $exceptions, $use_strict_mode);
	
	 if(!$is_blackisted_word){
		 array_push($final_output, $word);
	 }
}

// Return this to the user:
json_encode($final_output)


?>