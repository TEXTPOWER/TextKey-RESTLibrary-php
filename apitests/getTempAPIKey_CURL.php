<?php 
// TextKey REST path
define('TK_REST', 'https://secure.textkey.com/REST/TKRest.asmx/');

// Setup the API call parameters
$minutesDuration = 2;

// Set the authentication
$apikey = "PUT API KEY HERE";

// Build the REST API URL
$url = TK_REST . 'getTempAPIKey';

// Setup data
$postdata = json_encode(
	array('DataIn' => 
		array(
			'apiKey' => urlencode($apikey),
			'minutesDuration' => urlencode($minutesDuration)
		)
	),
JSON_PRETTY_PRINT);

// Handle the API request via CURL
$curl = curl_init($url);

// Set the CURL params and make sure it is a JSON request
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  // Wildcard certificate

$response = curl_exec($curl);
curl_close($curl);

// Handle the payload
$textkey_payload = json_decode($response);
if ($textkey_payload->d) {
	$textkey_result = $textkey_payload->d;
}
else {
	$textkey_result = $textkey_payload;
};

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