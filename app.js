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

    var output = remove_duplicates(data);

    // console.log("After removing duplicates:");
    // console.log(output.values);

    return output.values;
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

    console.log("Inside remove_exceptions");
    // console.log(blacklist);
    // console.log(main_list);

    main_list.forEach( word => {
        
        blacklist.forEach( exception => {

          //  console.log(exception)

            if ( word.includes(exception) ){
             //   console.log(exception)
                return;
                
            }

            output.push(word);
        }); // Inner loop

        

    }); // Outer loop

   let final_output = remove_duplicates(output)

    return final_output.values;

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