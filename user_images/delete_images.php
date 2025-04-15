<?php 	
	//This script deletes the images in the given directory in the uploads folder and then deletes the user image data.
	//It is for admin use only -- it is not part of the user site
	//It does not update the database.  This should be added or done manually in PHP MyAdmin
	require "includes/header2.php";
	echo "<main><h1>Admins Only</h1>";
	require_once ('../../../pdo_connect.php'); //Connect to the database
	if(isset($_POST['submit'])){
		$email= filter_var(trim($_POST['email']));
		$folder = preg_replace("/[^a-zA-Z0-9]/", "", $email);
		// make lowercase:
		$folder = strtolower($folder);	
		$dir = "../../../uploads/$folder"; // Define the directory to view.
		echo "$dir";
		$files = scandir($dir); // Read all the images into an array.
		foreach ($files as $image) {
			if (substr($image, 0, 1) != '.') { // Ignore anything starting with a period.
				$image_loc = "../../../uploads/$folder/$image";
				chmod($image_loc, 0777);
				unlink($image_loc);
			} // End IF.
		} // End foreach loop.
		//Also, optionally, delete the empty folder
		//rmdir($dir);
		//Then delete the user image data
		$sql2 = "DELETE FROM JJ_user_images WHERE email = ?";
		$stmt2 = $dbc -> prepare($sql2);
		$stmt2->bindParam(1, $email);
		$stmt2-> execute();
		$affected = $stmt2->rowCount();
		echo $affected;
		if ($affected > 0 )
			echo "<h2>$affected files were successfully deleted</h2></main>";
		else
			echo "<h2>There was a problem deleting the data</h2></main>";
		include "includes/footer.php";
		exit;
	} ?>
	<form method="post" action="delete_images.php">
		<fieldset>Delete a user's uploads folder</fieldset>
		<label>Select the email address of the user's images to be deleted:
		<select name="email">
			<?php 
				$sql = "SELECT emailAddr FROM JJ_reg_users";
				$result = $dbc->query($sql);
				if ($result) {
					foreach($result as $row) 
						echo "<option>{$row['emailAddr']}</option>";
				}
				else {
					echo "We are unable to process your request at  this  time. Please try again later.";
					include 'includes/footer.php'; 
					exit;
				} ?>
		</select>
		</label><br>
		<input type="submit" name="submit" value="Delete this user's images and image data">
	</form>
</main>
<?php include "includes/footer.php"; ?>