<?php
$_SERVER['HTTP_HOST'] = 'ada.cis.uncw.edu';
$_SERVER['REQUEST_URI'] = '/~tgh1432/jj/logged_out.php';

$https = $_SERVER['HTTPS'];
if ($https == "on") {
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $url = 'http://' . $host . $uri;
    header("Location: " . $url);
    exit();
}
?>