<?php
$https = $_SERVER['HTTPS'];
if ($https == "on") {
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $url = 'http://' . $host . $uri;
    header("Location: " . $url);
    exit();
}
?>