<?php //This is the login page for registered users
require_once '../secure_conn.php';
require 'includes/header.php';
if (isset($_POST['send']) && $_POST['send'] == "Login") {
	$errors = array();

	$valid_email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);	//returns a string or null if empty or false if not valid	
	if (empty($_POST['email']))
		$errors['email'] = 'Please enter an email address';
	elseif (!$valid_email)
		$errors['email'] = 'Please enter a valid email address';
	else
		$email = $valid_email;

	$password = trim($_POST['password']);
	if (empty($password))
		$errors['pw'] = "A password is required";

	while (!$errors) {
		try {
			require_once('../../pdo_connect.php'); // Connect to the db.
			//Query for email
			$sql = "SELECT * FROM JJ_reg_users WHERE emailAddr = :email";
			$stmt = $dbc->prepare($sql);
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			$numRows = $stmt->rowCount();
			if ($numRows == 0)
				$errors['no_email'] = "That email address wasn't found";
			else { // email found, validate password
				$result = $stmt->fetch(); //convert the result object pointer to an associative array 
				$pw_hash = $result['pw'];
				$folderName = $result['folder'];
				if (password_verify($password, $pw_hash)) { //passwords match
					$firstname = $result['firstName'];
					//your code here
					session_start();
					$_SESSION['first_name'] = $firstname;
					$_SESSION['user_email'] = $email;
					$_SESSION['folder'] = $folderName;
					header('Location: ./logged_in.php');
					exit;
				} else {
					$errors['wrong_pw'] = "That isn't the correct password";
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	} // end while 	
} //end isset $_POST['send']
?>
<h2>Japan Journey</h2>
<p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco
	laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor
	excepteur sint occaecat.</p>
<form method="post" action="login.php">
	<fieldset>
		<legend>Registered Users Login</legend>
		<?php if ($errors)
			echo "<h2 class=\"warning\">Please fix the item(s) indicated.</h2>";

		if ($errors['email'])
			echo "<h2 class=\"warning\">{$errors['email']}</h2>";
		if ($errors['no_email'])
			echo "<h2 class=\"warning\">{$errors['no_email']}</h2>";
		?>
		<p>
			<label for="email">Email: </label>
			<input name="email" id="email" type="text" <?php if (isset($email) && !$errors['no_email']) {
				echo 'value="' . htmlspecialchars($email) . '"';
			} ?>>
		</p>
		<?php if ($errors['pw'])
			echo "<h2 class=\"warning\">{$errors['pw']}</h2>";
		if ($errors['wrong_pw'])
			echo "<h2 class=\"warning\">{$errors['wrong_pw']}</h2>";
		?>
		<p>
			<label for="pw">Password: </label>
			<input name="password" id="pw" type="password">
		</p>
		<p>
			<input name="send" type="submit" value="Login">
		</p>
	</fieldset>
</form>
<?php include './includes/footer.php'; ?>