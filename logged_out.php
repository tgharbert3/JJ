<?php
require('includes/header.php');
if (isset($_COOKIE['PHPSESSID'])) {
    if (!empty($_SESSION['first_name'])) {
        $firstname = $_SESSION['first_name'];
        $message = "You are logged out $firstname";
        $message2 = "See you next time";
        $_SESSION = array();
        session_destroy();
        setcookie('PHPSESSID', "", time() - 3600, '/');
    }
} else {
    $message = 'You have reached this page in error';
    $message2 = 'Please use the menu at the right';
}

echo '<h2>' . $message . '</h2>';
echo '<h3>' . $message2 . '</h3>';

// Include the footer and quit the script:
include('includes/footer.php');
?>