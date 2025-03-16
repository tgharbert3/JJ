<?php
require 'includes/header.php';
define("ROWS", 3);
define("NUM_IMAGES", 6);
define("COLS", 2);

function shortTitle($title)
{
	$title = substr($title, 0, -4); #remove the .ext from each title
	$title = str_replace('_', ' ', $title); #replace underscores with blanks
	$title = ucwords($title); #capitalize each word
	return $title;
}

require_once('../../pdo_connect.php');
try {
	$sqlAll = "SELECT * FROM JJ_images";
	$all = $dbc->query($sqlAll);
	$picNum = $all->rowCount();
} catch (Exception $e) {
	echo $e->getMessage();
}
$pageNum = $_GET['page'];
$startImg = ($pageNum - 1) * NUM_IMAGES + 1;
$offset = $startImg - 1;
if ($startImg + NUM_IMAGES > $picNum) {
	$endImage = $picNum;
} else {
	$endImage = $offset + 6;
}
require_once('../../pdo_connect.php');
try {
	$sql = "SELECT * FROM JJ_images LIMIT $offset, " . NUM_IMAGES;
	$result = $dbc->query($sql);
} catch (Exception $e) {
	echo $e->getMessage();
}
?>
<h2>Japan Journey</h2>
<?php
if (isset($_GET["image_id"])) {
	$imgNum = $_GET['image_id'];
	echo "<p id='picCount'> Showing $startImg - $endImage of $picNum </p>";
} else {
	echo "<p id='picCount'> Showing 1 - $endImage of $picNum </p>";
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
				$caption = $row['caption'];
				echo "<tr>";
				echo "<td>";
				echo '<a href="gallery.php?page=' . $pageNum . '&image_id=' . $row['image_id'] . '">';
				echo '<img src="./images/thumbs/' . $row['filename'] . '" alt="' . $row['caption'] . '" width="80" height="54">';
				echo "</a>";
				echo "</td>";
			} else {
				echo "<td>";
				echo '<a href="gallery.php?page=' . $pageNum . '&image_id=' . $row['image_id'] . '">';
				echo '<img src="./images/thumbs/' . $row['filename'] . '" alt="' . $row['caption'] . '" width="80" height="54">';
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			$counter += 1;
		}
		if ($pageNum == 1) {
			echo '<tr><td>' . "" . '</td>';
			echo "<td>" . '<a href="gallery.php?page=' . ($pageNum + 1) . '&image_id=7">' . "Next>></a>" . "</td></tr>";
		}
		if ($pageNum > 1 && $endImage < $picNum) {
			echo '<tr><td>' . '<a href="gallery.php?page=' . ($pageNum - 1) . '"> &lt;&lt; Prev' . '</td>';
			echo "<td>" . '<a href="gallery.php?page=' . ($pageNum + 1) . '&image_id=7">' . "Next>></a>" . "</td></tr>";
		}
		if ($pageNum > 1 && $endImage == $picNum) {
			echo '<tr><td>' . '<a href="gallery.php?page=' . ($pageNum - 1) . '"> &lt;&lt; Prev</a>' . '</td>';
		}

		?>
	</table>
	<?php

	?>
	<figure id="main_image">
		<?php
		if (isset($_GET["image_id"])) {
			echo '<img src="./images/' . $imageToShow . '" alt="' . $imageCaption . '">';
			$shortCaption = shortTitle($imageCaption);
			echo "<figcaption>$shortCaption</figcaption>";
		} else {
			echo '<img src="./images/basin.jpg" alt="" >';
			echo '<figcaption>"Water basin at Ryoanji temple, Kyoto"</figcaption>';
		}
		?>
	</figure>
</section>
<?php include 'includes/footer.php'; ?>