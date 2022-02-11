<?php

/**
 * Logging
 *
 * This code creates a function that writes the date time, and data to a log
 */
// Data to capture:
// $log is the path to the file
function pws_add_to_log($log, $data = []){
	
	$date = date('m/d/Y h:i:s a');
	
	// Loop through $data and write to file
	foreach($data as $datum){
		$insert = $date . " | " . $datum . "\n";
		file_put_contents($log, $insert,  FILE_APPEND | LOCK_EX);
	}
	
}

function pws_create_log($log_dir = "", $file_name = "", $data = []){
	
	// Check if log dir exists, if not, create it.
	if(!is_dir($log_dir)){
		mkdir($log_dir, 0700);
	}
	
	// Create the file
	$abs_path_to_file  = $log_dir ."/". $file_name . ".txt";
	
	// Check if it already exists, if not, create it
	if(!file_exists($abs_path_to_file)){
		
		$file = fopen($abs_path_to_file, "w") or die("Unable to open file!");
		fclose($file);
		
		// Ensure peeps can't read it
		chmod($abs_path_to_file, 0640);

	} // file exists check
	
	pws_add_to_log($abs_path_to_file, $data);
	
}


