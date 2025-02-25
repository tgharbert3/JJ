<?php
require 'includes/header.php';
function shortTitle($title)
{
	$title = substr($title, 0, -4); #remove the .ext from each title
	$title = str_replace('_', ' ', $title); #replace underscores with blanks
	$title = ucwords($title); #capitalize each word
	return $title;
}

require_once('../../pdo_connect.php');
try {
	$sql = "SELECT * FROM JJ_images";
	$result = $dbc->query($sql);
	$picNum = $result->rowCount();
} catch (Exception $e) {
	echo $e->getMessage();
}
define("COLS", 2);
?>
<h2>Japan Journey</h2>
<?php
if (isset($_GET["image_id"])) {
	$imgNum = $_GET['image_id'];
	echo "<p id='picCount'> Displaying 1 to $imgNum of $picNum </p>";
} else {
	echo "<p id='picCount'> Displaying 1 to 1 of $picNum </p>";
}
?>
<section id="gallery">
	<table id="thumbs">
		<?php
		if (isset($_GET['image_id'])) {
			$image_id = $_GET['image_id'];
		}
		$counter = 0;
		foreach ($result as $row) {
			if ($row['image_id'] == $image_id) {
				$imageToShow = $row['filename'];
				$imageCaption = $row['caption'];
			}
			if ($counter % COLS == 0) {
				echo "<tr>";
				echo "<td>";
				echo "<a href=gallery.php?image_id=" . $row['image_id'] . ">";
				echo "<img src=./images/thumbs/" . $row['filename'] . " alt=" . $row['caption'] . " width='80' height='54'>";
				echo "</a>";
				echo "</td>";
			} else {
				echo "<td>";
				echo "<a href=gallery.php?image_id=" . $row['image_id'] . ">";
				echo " <img src=./images/thumbs/" . $row['filename'] . " alt=" . $row['caption'] . " width='80' height='54'>";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			$counter += 1;
		} ?>
	</table>
	<figure id="main_image">
		<?php
		if (isset($_GET["image_id"])) {
			echo "<img src=./images/$imageToShow alt=$imageCaption>";
			$shortCaption = shortTitle($imageCaption);
			echo "<figcaption>$shortCaption</figcaption>";
		} else {
			echo "<img src=./images/basin.jpg alt=''";
			echo "<figcaption>Water basin at Ryoanji temple, Kyoto</figcaption>";
		}
		?>


	</figure>
</section>
<?php include 'includes/footer.php'; ?>