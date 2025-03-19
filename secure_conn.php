<?php
$_SERVER['HTTP_HOST'] = 'ada.cis.uncw.edu';
$_SERVER['REQUEST_URI'] = '/~tgh1432/jj/create_acct.php';

$https = $_SERVER['HTTPS'];
if ($https != "on") {
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $url = 'https://' . $host . $uri;
    header("Location: " . $url);
    exit();
}
?>