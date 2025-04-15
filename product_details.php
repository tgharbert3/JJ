<?php
//ini_set('display_errors', 1);
require 'includes/header.php';
require_once '../../pdo_connect.php';

function shortTitle($title)
{
	$title = substr($title, 0, -4);
	$title = str_replace('_', ' ', $title);
	$title = ucwords($title);
	return $title;
}
if (isset($_GET['image_id'])) {
	$imgID = filter_var($_GET['image_id'], FILTER_SANITIZE_NUMBER_INT);
	$getDetails = "SELECT * FROM JJ_images WHERE image_id = ?";
	$stmt = $dbc->prepare($getDetails);
	$stmt->bindParam(1, $imgID);
	$stmt->execute();
	$rows = $stmt->rowCount();
	if ($rows == 1) { // Valid print ID.
		// Fetch the information.
		$item = $stmt->fetch();
		// Retrieve the query results into scalar variables
		$filename = $item['filename'];
		$caption = $item['caption'];
		$details = $item['details'];
		$price = $item['price'];
		?>
		<h2>Purchase <?= shortTitle($filename) ?>:</h2>
		<p><img src="images/<?= $filename ?>" alt="<?= $caption ?>"></p>
		<h3><strong>Description:</strong></h3>
		<h4><?= $caption ?></h4>
		<h4><?= $details ?></h4>
		<h4><strong>Price: </strong>$<?= $price ?>
			<!-- Insert Add to Cart button here -->
			<form action="cart.php" method="POST" style="display:inline">
				<input type="submit" name="submit" value="Add to Cart">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="image_id" value="<?= $imgID ?>">
				<input type="hidden" name="qty" value="1">
			</form>
			<button type="button" onclick="document.location='cart.php'">View Cart</button>
		</h4>
	<?php } else {
		echo "<main><h2>We are unable to process your request at  this  time.</h2><h3>Please try again later.</h3></main>";
		include 'includes/footer.php';
		exit;
	}
} else {
	echo "<main><h2>You have reached this page in error</h2><h3>Use the menu at the left to view our products.</h3></main>";
	include 'includes/footer.php';
	exit;
}
include 'includes/footer.php'; ?>