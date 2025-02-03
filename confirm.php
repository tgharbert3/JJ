<!DOCTYPE HTML>
<!-- Tyler Harbert  -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Japan Journey</title>
    <link href="./styles/journey.css" rel="stylesheet" type="text/css">
</head>

<body>
	<header>
		<h1>Japan Journey</h1>
	</header>
	<div id="wrapper"> <!--Required for CSS to work properly-->
		<main>
			<h2>Japan Journey</h2>
			<p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor excepteur sint occaecat.</p>
			<?php 
				if (isset($_GET['submit']) && $_GET['submit'] === 'Submit') {
					echo "<h3>Thank you for Contacting us</h3>";
					echo "<h3>You Submitted the following:</h3>";
					echo "<ul>"; 
						foreach($_GET as $key => $value) {
							if($value === "") {
								echo "<li> $key not selected";
							} elseif ($key === "interests") {
								$interest = $_GET["interests"];
								echo "<li>Interests:</li>";
								foreach($interest as $interestKey => $interestValue) {
								echo "<li>&emsp; $interestValue </li>";
								} 
							} elseif ($key === 'submit') {
								echo "";
							} else {
								echo "<li>$key: $value </li>";
							}
					};
					echo "</ul>";			
				} else {
					echo "<h3>You have reached this page in error.</h3>";
				};
			?>
		</main>
		<footer>
			<p>&copy;
			<?php
				date_default_timezone_set("America/New_York");
				$startYear = 2006;
				$thisYear = date('Y');
				if ($startYear == $thisYear) {
					echo $startYear;
				} else {
					echo "$startYear".'&ndash;'."$thisYear";
				}
			?>
			David Powers</p>
		</footer>
	</div>
</body>
</html>
