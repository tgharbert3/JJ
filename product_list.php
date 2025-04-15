<?php
// ini_set('display_errors', 1);
require 'includes/header.php';
require_once '../../pdo_connect.php';

$sql = 'SELECT * FROM JJ_images';
$result = $dbc->query($sql);
$error = $dbc->errorInfo()[2];
if (!$error) {
	$numRows = $result->rowCount();
} else {
	echo "We are unable to process your request at  this  time. Please try again later.";
	include 'includes/footer.php';
	exit;
}

//This function creates a title from the filename of each image
function shortTitle($title)
{
	$title = substr($title, 0, -4); #remove the .ext from each title
	$title = str_replace('_', ' ', $title); #replace underscores with blanks
	$title = ucwords($title); #capitalize each word
	return $title;
}
?>


<h2>Images of Japan</h2>
<h3>Each of our lovely images may be purchased for you to enjoy in your home or to give as a gift</h3>
<h4>Please click the View Details button to make a purchase
	<?php if (!empty($_SESSION['cart'])) {
		echo "or <a href='cart.php'>View your cart</a> ";
	}

	?>
</h4>

<table>
	<tr>
		<th>Title</th>
		<th>Image</th>
		<th></th>
	</tr>
	<?php foreach ($result as $row) {
		$title = shortTitle($row['filename']);
		?>
		<tr>
			<td><?= $title; ?></td>
			<td><img src="images/thumbs/<?= $row['filename']; ?>"></td>
			<td>
				<form action="product_details.php" method="GET">
					<input type="hidden" name="image_id" value="<?= $row['image_id'] ?>">
					<input type="submit" name="submit" value="View Details">
				</form>
			</td>
		</tr>

	<?php } //end while loop ?>

</table>

<?php include 'includes/footer.php'; ?>