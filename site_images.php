<?php
define('MAX_SIZE', 350);  //350x350 is the biggest size for a "main" image on the gallery page
require './includes/header2.php';
// header2 is a site header without the navigation menu as might be used for a password protected admin page.

function resizeImage($shortType, $new_w, $new_h, $width, $height, $location, $destination)
{
	if ($shortType == 'gif') {
		$resource = imagecreatefromgif($location);
	} elseif ($shortType == 'png') {
		$resource = imagecreatefrompng($location);
	} else {
		$resource = imagecreatefromjpeg($location); //Must be last since $shortType could be jpg or jpeg
	}
	$resized = imagecreatetruecolor($new_w, $new_h);  //Create a new blank image of the specified size.
	imagecopyresampled($resized, $resource, 0, 0, 0, 0, $new_w, $new_h, $width, $height);

	if ($shortType == 'gif') {
		imagegif($resized, $destination);
	} elseif ($shortType == 'png') {
		imagepng($resized, $destination);
	} else {
		imagejpeg($resized, $destination);
	}
}

if (isset($_POST['submit']) && $_POST['submit'] == "Upload!") {
	if (isset($_FILES['site_img'])) {
		$filename = $_FILES['site_img']['name'];
		$destination = "images/$filename";
		if (move_uploaded_file($_FILES['site_img']['tmp_name'], $destination)) {
			$img = getimagesize("images/$filename");
			$width = $img[0];
			$height = $img[1];
			$type = $img['mime'];

			//Determine if image needs to be resized to fit site requirements of 350px x 350px
			if ($width <= MAX_SIZE && $height <= MAX_SIZE) {
				$ratio = 1;
			} elseif ($width > $height) {
				$ratio = MAX_SIZE / $width;
			} else {
				$ratio = MAX_SIZE / $height;
			}
			$new_w = round($width * $ratio);
			$new_h = round($height * $ratio);
			$shortType = substr($type, 6);  //strip off MIME: image/
			$location = "images/$filename";
			$destination = "images/$filename";
			if ($ratio != 1)
				resizeImage($shortType, $new_w, $new_h, $width, $height, $location, $destination);

			//Create thumbnail image in images/thumbs folder
			$width = 80;
			$height = 54;
			$destination = './images/thumbs';
			resizeImage($shortType, $new_w, $new_h, $width, $height, $location, $destination);

			//Send image data to db:
			if (isset($_POST['caption']))
				$caption = trim($_POST['caption']);
			else
				$caption = NULL;

			if (isset($_POST['price']))
				$price = (float) $_POST['price'];
			else
				$price = NULL;

			if (isset($_POST['description']))
				$description = trim($_POST['description']);
			else
				$description = NULL;
			try {
				require_once('../../../pdo_connect.php'); // Connect to the db.
				$sql = "INSERT into JJ_images(filename, caption) VALUES (?, ?, ?, ?)";
				$stmt = $dbc->prepare($sql);
				$stmt->bindParam(1, $filename);
				$stmt->bindParam(2, $caption);
				$stmt->bindParam(3, $price);
				$stmt->bindParam(4, $description);
				$result = $stmt->execute();
				$numRows = $stmt->rowCount();
				if ($numRows == 1) {
					echo "<h2>We have saved the new item</h2>";
					echo "<img src = 'images/$filename'>";
				} else {
					echo "<h3>There was a problem saving to the database</h3>";
					include 'includes/footer.php';
					exit;
				}
			} catch (PDOException $e) {
				echo "<p>There was an error saving your information. Please try again later.</p>";
				echo "<p>Error: " . $e->getMessage() . "</p>";
				exit;
			}
		} elseif ($_FILES['site_img']['error'] > 0) {
			echo '<p class="error">The file could not be uploaded because: <strong>';

			// Print a message based upon the error.
			switch ($_FILES['site_img']['error']) {
				case 1:
					echo 'The file exceeds the upload_max_filesize setting in php.ini.';
					break;
				case 2:
					echo 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
					break;
				case 3:
					echo 'The file was only partially uploaded.';
					break;
				case 4:
					echo 'No file was uploaded.';
					break;
				case 6:
					echo 'No temporary folder was available.';
					break;
				case 7:
					echo 'Unable to write to the disk.';
					break;
				case 8:
					echo 'File upload stopped.';
					break;
				default:
					echo 'A system error occurred.';
					break;
			} // End of switch.
			echo '</strong></p>';
		} // End of error IF.
		else {
			echo "<main><h3>Some unknown error has occurred.</h3></main>";
			exit;
		}
	} //isset $_FILES
	include 'includes/footer.php';
	//release the uploaded file resource
	if (file_exists($_FILES['site_img']['tmp_name']) && is_file($_FILES['site_img']['tmp_name']))
		unlink($_FILES['site_img']['tmp_name']);
	exit;
}
?>
<h2>Admin Upload Site Images</h2>
<form action="./site_images.php" method="POST">
	<div>
		<label for="site_img">Upload a product image</label><br>
		<input type="file" name="site_img" id="image">

	</div>

	<div>
		<br>
		<label for="caption">Give a brief caption: </label><br>
		<input type="text" name="caption" id="caption">
	</div>

	<div>
		<br>
		<label for="price">Enter the product price: </label><br>
		<input type="text" name="price" id="price">
	</div>

	<div>
		<br>
		<label for="description">Enter a description of the artwork: </label><br>
		<textarea name="description" id="description"></textarea>
	</div>

	<br>
	<input type="submit" name="Upload" id="upload" value="Upload">
</form>

<?php // Include the footer and quit the script:
include('./includes/footer.php');
?>