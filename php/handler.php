<?php

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "kenthfrank01@gmail.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$home_page = "../index.html";
$error_page = "error.html";
$feedback_page = "../feedback.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$email_address = $_REQUEST['email'] ;
debug_to_console($_REQUEST);
$comments = $_REQUEST['message'] ;
$name  = $_REQUEST['name'] ;
$phone_number  = $_REQUEST['phone'] ;
$needed_services  = $_REQUEST['service'];
$product  = $_REQUEST['type-product'];
$msg =
"Name: " . $name . "\r\n" .
"Email: " . $email_address . "\r\n" .
"Phone Number: " . $phone_number .  "\r\n" .
"Needed Serives: " . $needed_services .  "\r\n" .
"Products I sell: " . $product .  "\r\n" .
"Message: " . $comments .  "\r\n" 
;

/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

/* If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email_address'])) {
header( "Location: $home_page" );
}*/

// If the form fields are empty, redirect to the error page.
if (empty($comments) || empty($email_address)) {
header( "Location: $error_page" );
}

/*
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email_address) ||  isInjected($comments) ) {
header( "Location: $error_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "You have a new message from NH Pharmaceuticals Contact Us", $msg );

	header( "Location: $feedback_page" );
}
?>
