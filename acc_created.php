<?php
session_start();
require_once '../reg_conn.php';
require_once 'includes/header.php';

if (isset($_GET['first'])) {
    $firstname = $_GET['first'];
    $lastname = $_GET['last'];
    echo "<h2>Thank you $firstname $lastname for registering</h2><h3>Please use the menu to login.</h3>";
}
// if (isset($_SESSION['fname'])) {
//     $firstname = $_SESSION['fName'];
//     $lastname = $_SESSION['lName'];
//     echo "<h2>Thank you $firstname $lastname for registering</h2><h3>Please use the menu to login.</h3>";
// } else {
//     $message = 'You have reached this page in error';
//     $message2 = 'Please use the menu at the right';
//     echo '<h2>' . $message . '</h2>';
//     echo '<h3>' . $message2 . '</h3>';
// }


include('includes/footer.php');
?>