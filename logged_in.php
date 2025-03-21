<?php
require_once '../reg_conn.php';
require_once 'includes/header.php';
if (isset($_COOKIE['PHPSESSID'])) {
	$firstname = $_SESSION['first_name'];
	$message = "Welcome back $firstname";
	$message2 = "You are now logged in";
} else {
	$message = 'You have reached this page in error';
	$message2 = 'Please use the menu at the right';
}
//The require header is deferred until session variables are set so that the menu can display correctly

// Print the message:
echo '<h2>' . $message . '</h2>';
echo '<h3>' . $message2 . '</h3>';
// Include the footer and quit the script:
include('includes/footer.php');
?>