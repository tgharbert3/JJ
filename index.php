<?php
require 'includes/header.php';
//Query the database to determine $numImages
require_once '../../pdo_connect.php';
try {
	$sql = "SELECT * FROM JJ_images";
	$result = $dbc->query($sql);
	$numImages = $result->rowCount();
} catch (Exception $e) {
	echo $e->getMessage();
}
//Choose a random number from the number of images in the database
$i = mt_rand(1, $numImages) - 1; //Mersenne Twister algorithm  This assumes $numImages is set previously.

//Retrieve the image info for the random image.
require_once '../../pdo_connect.php';
try {
	$getImg = "SELECT * FROM JJ_images LIMIT $i, 1";
	$img = $dbc->query($getImg);
	foreach ($img as $imgs) {
		$fileName = $imgs['filename'];
		$caption = $imgs['caption'];
	}
	$src = "./images/$fileName";
	$imgInfo = getimagesize($src);
} catch (Exception $e) {
	$e->getMessage();
}

?>

<h2>A Journey through Japan with PHP</h2>
<p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco
	laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor
	excepteur sint occaecat.</p>
<figure><img src='<?php echo $src ?>' alt="Random image" width=<?php echo $imgInfo[0] ?> height=<?php echo $imgInfo[1] ?>>
	<figcaption style=<?php echo '"width: ' . $imgInfo[0] . 'px"'; ?>>
		<?php echo $caption ?>

	</figcaption>
</figure>
<p>Eu fugiat nulla pariatur. Ut labore et dolore magna aliqua. Cupidatat non proident, quis nostrud exercitation ut enim
	ad minim veniam.</p>
<p>Consectetur adipisicing elit, duis aute irure dolor. Lorem ipsum dolor sit amet, ut enim ad minim veniam, consectetur
	adipisicing elit. Duis aute irure dolor ut aliquip ex ea commodo consequat.</p>
<p>Quis nostrud exercitation eu fugiat nulla pariatur. Ut labore et dolore magna aliqua. Sed do eiusmod tempor
	incididunt velit esse cillum dolore ullamco laboris nisi.</p>
<p>Sed do eiusmod tempor incididunt ullamco laboris nisi consectetur adipisicing elit. Ut aliquip ex ea commodo
	consequat. Qui officia deserunt ut labore et dolore magna aliqua. Velit esse cillum dolore eu fugiat nulla pariatur.
	Sed do eiusmod tempor incididunt cupidatat non proident, sunt in culpa. Sunt in culpa duis aute irure dolor
	excepteur sint occaecat.</p>
<p>Quis nostrud exercitation eu fugiat nulla pariatur. Ut labore et dolore magna aliqua. Sunt in culpa duis aute irure
	dolor excepteur sint occaecat.</p>

<?php include 'includes/footer.php'; ?>