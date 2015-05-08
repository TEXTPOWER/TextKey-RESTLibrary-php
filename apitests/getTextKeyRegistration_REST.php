<?php 
// Include the TextKey classes
include_once("../textkey_rest.php");

// Setup the API call parameters
$RetrieveBy = "ByCellNumber";
$CellNumber = "1231231234";
$Suppl1 = "";
$Suppl2 = "";

// Set the authentication
$apikey = "PUT API KEY HERE";

// Create a TK object
$tk = new textKey($apikey);

// Handle the operation
$textkey_result = $tk->perform_getTextKeyRegistration($RetrieveBy, $CellNumber, $Suppl1, $Suppl2);

// Handle the results
if ($textkey_result->errorDescr == "") {
	$tkResultsArr = get_object_vars($textkey_result);
	$results = "";
	foreach($tkResultsArr as $key => $value) { 
		if (is_array($value)) {
			$results .= $key . ': ' . var_export($value, true) . "<BR>";;
		}
		else if (is_object($value)) {
			$results .= $key . ': ' . print_r($value, true);
		}
		else {
			$results .= $key . ': ' . $value . "<BR>";;
		}
	} 			
	echo $results;
}
else {
	$results = 'Error: ' . $textkey_result->errorDescr . "<BR>";
	echo $results;
}
?>