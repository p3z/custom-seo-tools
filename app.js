// Converts a keyword list (as a csv string) into an array
function csv2array(input){
    var output = [];
    var rows = input.slice(input.indexOf("\n") + 1).split("\n")   

    rows.forEach(element => {

        if (element === ""){
            // Skip empty entries
            return;            
        }

        output.push(element)
    });

    return output;
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

// Parse through an array of strings and remove duplicates
// Returns an object containing the number of duplicates removed and the resulting array
function remove_duplicates(catalog){

    var orig_length = catalog.length;

    //(if needed)
    // From here: // https://stackoverflow.com/questions/49215358/checking-for-duplicate-strings-in-javascript-array
    let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index);
    
    // An array of duplicated keys 
     var duplicates = [...new Set(findDuplicates(catalog))]


    // Loop over the catalog, and this time remove all duplicates from it
    var unique_vals = [...new Set(catalog)];
    var unique_length = unique_vals.length;  

    return {
        num_keys_removed: `${duplicates.length}`,
        duplicates: duplicates,        
        catalog: unique_vals
    }
    
}
