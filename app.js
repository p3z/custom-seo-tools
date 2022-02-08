// Converts a keyword list (as a csv string) into an array
function csv2array(input){
    var data = [];
   // var rows = input.slice(input.indexOf("\n")).split("\n");
   var rows = input.split("\n");

    // console.log("Inside csv2array");
    // console.log(rows)

    rows.forEach(element => {

        if (element === ""){
            // Skip empty entries
            return;            
        }

        data.push(element)
    });

    // console.log("Before removing duplicates:");
    // console.log(data);

   // var output = remove_duplicates(data);

    // console.log("After removing duplicates:");
    // console.log(output.values);

    return data;
}





// Check a single string against an entire array of strings
function is_fresh_input(str, arr){
    
    var code_in_array = arr.includes(str);

    if(code_in_array){
        return false;
    } else{
        return true;
    }

}



// Parse through two arrays and remove any matches across both
// Also remove any entries from array 1 that contain those from array 2
function remove_exceptions(main_list, blacklist){
    let output = [];
    let exceptions = [];

    console.log("Inside remove_exceptions");
    // console.log(blacklist);
    // console.log(main_list);

    loop1:
    for(let i = 0; i < main_list.length; i++){

        var word  = main_list[i];

        loop2:
        for(let j = 0; j < blacklist.length; j++){

            var exception = blacklist[i];

            // If it's in the blacklist, skip this word
            if ( word.includes(exception) ){
                exceptions.push(exception);
                break loop1;
            }

            // If it's already in the output array, skip this word
            if( output.includes(word) ){
                continue loop1;
            }

            // If here, then add word shd be added to output
            output.push(word);
            console.log("Word added");         
            

        } // Inner loop
        

    }; // Outer loop

    console.log(exceptions)
    console.log(output)

   let final_output = remove_duplicates(output)

  //  return final_output.values;

}


// Parse through an array of strings and remove duplicates
// Returns an object containing the number of duplicates removed and the resulting array
function remove_duplicates(input){

    var orig_length = input.length;

   
    // From here: // https://stackoverflow.com/questions/49215358/checking-for-duplicate-strings-in-javascript-array
    let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index);

    
    
    // An array of duplicated keys 
     var duplicates = [...new Set(findDuplicates(input))]
    //  console.log("Are there duplicates?")
    //  console.log(duplicates)

    // Loop over the input, and this time remove all duplicates from it
    var unique_vals = [...new Set(input)];
    var unique_length = unique_vals.length;  

    return {
        num_individual_keys_removed: `${duplicates.length}`,
        duplicates: duplicates,        
        values: unique_vals
    }
    
}

// Check if value is in array, return true if so, false if not
// set matches_only to true if you want only exact matches
function inList(keyword, blacklist = [], matches_only = false){

   

    // Loop through the array    
    for(let i = 0; i < blacklist.length; i++){

        let black_word = blacklist[i];

       
        if(matches_only == 1){
            console.log("strict mode ran")
            if( black_word === keyword ){
                
                // If match, return true
                return true;

            }

        } else {
            
            // Check if entry contains current value
            if( keyword.indexOf(black_word) != -1){
                console.log("loose mode ran")
                // If match, return true
                return true;
            }

        }

    };

    return false;

}