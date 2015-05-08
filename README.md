TextKey REST Library
====================

This PHP library allows you to use TextKey's REST API calls server-side from a PHP backend.

Common use-Case
---------------

To ensure a secure environment, you don't want to use APIs directly from the front-end, but rather through web-services inside your PHP backend.

More Information
----------------

To get more detailed information on the TextKey API Services or to investigate the API in more detail, you can refer to the following:

* [TextKey Developer Site](http://developer.textkey.com)
* [TextKey API Call Documentation](http://developer.textkey.com/apidocumentation.php)
* [Test All TextKey API Calls](http://developer.textkey.com/apitestapicalls.php)
* [TextKey Sample Site](http://developer.textkey.com/apitextkeyexample.php)

Using the REST Library
----------------------

There are two PHP includes in this repository: `textkey_rest.php` and `textkey_rest_debug.php`. 

`textkey_rest.php` contains the barebones class and `textkey_rest_debug.php` has options to display the call information as well as outgoing and incoming payloads.

How to use it?
--------------

The simple use case is to create a textkey object, call the appropriate API method and handle the returned object payload. The class will handle the details between the request and response and will return an object to work with.

For example, here is a use case to check if a user has already been registered using the `doesRegistrationUserIDExist` API Call.

```php
<?php
// Include the TextKey classes
include_once("textkey_rest.php");

// Setup the API call parameters
$testuserid ="BobSmithUID";
$isHashed = TRUE;

// Set the authentication
$apikey = "PUT API KEY HERE";

// Create a TK object
$tk = new textKey($apikey);

// Handle the operation
$textkey_result = $tk->perform_DoesRegistrationUserIDExist($testuserid, $isHashed);

// Handle the results
if ($textkey_result->errorDescr == "") {
  $tkResultsArr = get_object_vars($textkey_result);
	$results = "";
  foreach($tkResultsArr as $key => $value) { 
    $results .= $key . ': ' . $value . "<BR>";
  } 			
  echo $results;
}
else {
  $results = 'Error: ' . $textkey_result->errorDescr . "<BR>";
  echo $results;
}
?>
```

Initialization
---------------

The basic initialize step consists of including the REST Library and then creating a textkey object.

```php
// Include the TextKey classes
include_once("textkey_rest.php");

// Set the authentication
$apikey = "PUT API KEY HERE";

// Create a TK object
$tk = new textKey($apikey);
```

Making the API Call
-------------------

Once initialized, you can now make a call out to the specific TextKey API using the textkey object you just created.

```php
// Setup the API call parameters
$testuserid ="BobSmithUID";
$isHashed = TRUE;

// Handle the operation
$textkey_result = $tk->perform_DoesRegistrationUserIDExist($testuserid, $isHashed);
```

Handling the resulting payload
------------------------------

The API call will return back an object with all of the API fields included. First check for an error (i.e. in the `errorDescr` field of the returned object) and then pull the data you need from the object.

```php
// Handle the results
if ($textkey_result->errorDescr == "") {
  $tkResultsArr = get_object_vars($textkey_result);
	$results = "";
  foreach($tkResultsArr as $key => $value) { 
    $results .= $key . ': ' . $value . "<BR>";
  } 			
  echo $results;
}
else {
  $results = 'Error: ' . $textkey_result->errorDescr . "<BR>";
  echo $results;
}
```

How to view more details
------------------------

In order to get more detailed information on the API call handling, use the `textkey_rest_debug.php` include library instead. The calling protocol and class methods are the same as above, however the library contains two include files: `textkeyshared.php` for display functionality and `apiconfig.php` for configuration settings and based on those settings it will display detailed results.

Configuration Settings
----------------------

You have the following options in the `apiconfig.php` file.

To display output, turn on the debugging flag by setting it to true.

```php
define('DEBUGGING', true);		// Turn this on to show output
```

To define the level of details, set OUTPUT_STATE. 

You have 3 options: 

```php
define('OUTPUT_PLAYLOAD', 0);				// Just show the output payload
define('OUTPUT_LIMITED', 1);				// Show more details about the API call
define('OUTPUT_FULL', 2);					// Show all detials about the API call

/*
** Display Settings
*/
define('OUTPUT_STATE', OUTPUT_FULL);		// Set the output level
```

Define your API key with the following definitions:

```php
// TextKey API
define('TK_API', 'PUT YOUR API KEY HERE');
define('TK_DISPLAY_API', TK_API);
```

Here is an example

```php
<?php
// Include the TextKey classes
include_once("textkey_rest_debug.php");

// Setup the API call parameters
$testuserid ="BobSmithUID";
$isHashed = TRUE;

// Set the authentication
$apikey = TK_API;

// Create a TK object
$tk = new textKey($apikey);

// Handle the operation
$textkey_result = $tk->perform_DoesRegistrationUserIDExist($testuserid, $isHashed);

// Handle the results
if ($textkey_result->errorDescr == "") {
  $tkResultsArr = get_object_vars($textkey_result);
	$results = "";
  foreach($tkResultsArr as $key => $value) { 
    $results .= $key . ': ' . $value . "<BR>";
  } 			
  echo $results;
}
else {
  $results = 'Error: ' . $textkey_result->errorDescr . "<BR>";
  echo $results;
}
?>
```

Sample Code
-----------

We have included a folder called `apitests` in this repository with sample code for all current API calls. There are two flavors for each call: one using the textkey REST Library and one directly making a CURL request.

We have also included some front end html/JS examples using the REST API calls however we strongly advise against doing this unless you use the `getTempAPIKey` API call to get a temporary API key server-side and then use that API Key to make the API call. That API Key has a short lifespan and you should never expose your permanent API Key in any client side code.

Contributing to this SDK
------------------------

**Issues**

Please discuss issues and features on Github Issues. We'll be happy to answer to your questions and improve the SDK based on your feedback.

**Pull requests**

You are welcome to fork this SDK and to make pull requests on Github. We'll review each of them, and integrate in a future release if they are relevant.
