<?php
try {
	require 'includes/header.php';
	require_once '../../pdo_connect.php';
	$sql = 'SELECT * FROM JJ_images';
	$result = $dbc->query($sql);
	$numRows = $result->rowCount();
} catch (PDOException $e) {
	echo $e->getMessage();
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
<main>
	<h2>Images of Japan</h2>
	<h3>Each of our lovely images may be purchased for you to enjoy in your home or to give as a gift</h3>
	<table>
		<tr>
			<th>Title</th>
			<th>Image</th>
		</tr>
		<?php foreach ($result as $row) {
			echo "<tr>";
			echo "<td>" . shortTitle($row["filename"]) . "</td>";
			echo "<td> <img src=./images/" . $row["filename"] . " alt=text> </td>";
			echo "</tr>";
			?>


		<?php } //end while loop ?>
	</table>
</main>
<?php include 'includes/footer.php'; ?>