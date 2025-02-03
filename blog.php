<!DOCTYPE HTML>
<!--  -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Japan Journey</title>
    <link href="styles/journey.css" rel="stylesheet" type="text/css">
</head>

<body>
	<header>
		<h1>Japan Journey</h1>
	</header>
	<div id="wrapper"> <!--Required for CSS to work properly-->
		<main>
			<h2>November 2, 2019</h2>
			<p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor excepteur sint occaecat. <a href="#">More</a></p>
			<h2>November 3, 2019</h2>
			<p>Eu fugiat nulla pariatur. Ut labore et dolore magna aliqua. Cupidatat non proident, quis nostrud exercitation ut enim ad minim veniam. <a href="#">More</a></p>
			<h2>November 4, 2019</h2>
			<p>Consectetur adipisicing elit, duis aute irure dolor. Lorem ipsum dolor sit amet, ut enim ad minim veniam, consectetur adipisicing elit. Duis aute irure dolor ut aliquip ex ea commodo consequat. <a href="#">More</a></p>
			<h2>November 5, 2019</h2>
			<p>Quis nostrud exercitation eu fugiat nulla pariatur. Ut labore et dolore magna aliqua. Sed do eiusmod tempor incididunt velit esse cillum dolore ullamco laboris nisi. <a href="#">More</a></p>
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
