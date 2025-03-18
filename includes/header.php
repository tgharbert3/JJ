<?php session_start(); ?>
<!DOCTYPE HTML>
<!--Tyler Harbert  -->
<html lang="en">
<?php include("./includes/title.php") ?>

<head>
    <meta charset="utf-8">
    <title>Japan Journey <?php if (isset($title)) {
        echo "&mdash;$title";
    } ?></title>
    <link href="styles/journey.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <h1>Japan Journey</h1>
    </header>
    <div id="wrapper"> <!--Required for CSS to work properly-->
        <?php include("./includes/menu.php") ?>
        <main>