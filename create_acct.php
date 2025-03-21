<?php
session_start();
require 'includes/header.php';//This page checks for required content, errors, and provides sticky output
require_once '../secure_conn.php';
if (isset($_POST['send']) && $_POST['send'] == "Register") {
	$errors = array();

	$firstname = trim($_POST['firstname']); //returns a string
	if (empty($firstname))
		$errors['firstname'] = "First name is required";

	$lastname = trim($_POST['lastname']); //returns a string
	if (empty($lastname))
		$errors['lastname'] = "Last name is required";

	$valid_email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);	//returns a string or null if empty or false if not valid	
	if (empty($_POST['email']))
		$errors['email'] = 'Please enter an email address';
	elseif (!$valid_email)
		$errors['email'] = 'Please enter a valid email address';
	else
		$email = $valid_email;

	$password1 = trim($_POST['password1']);
	$password2 = trim($_POST['password2']);
	// Check for a password:
	if (empty($password1) || empty($password2))
		$errors['pw'] = 'Please enter the password twice';
	elseif ($password1 !== $password2)
		$errors['pwmatch'] = 'The passwords don\'t match';
	else
		$password = $password1;

	//Check to see if email address already exists
	//Handle as an error if yes 
	try {
		require_once '../../pdo_connect.php';  //$dbc is the connection string set upon successful connection
		$sql = "SELECT * FROM JJ_reg_users WHERE emailAddr = :email";
		$stmt = $dbc->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$numRows = $stmt->rowCount();
		if ($numRows >= 1)
			$errors['exists'] = "That email address is already registered.";

		if (!$errors) {

			$sql2 = "INSERT INTO JJ_reg_users (firstName, lastName, emailAddr, pw) VALUES (?, ?, ?, ?)";
			$stmt2 = $dbc->prepare($sql2);
			$pw_hash = password_hash($password, PASSWORD_DEFAULT);
			$stmt2->bindParam(1, $firstname);
			$stmt2->bindParam(2, $lastname);
			$stmt2->bindParam(3, $email);
			$stmt2->bindParam(4, $pw_hash);
			$stmt2->execute();
			$numRows = $stmt2->rowCount();
			if ($numRows != 1)
				echo "<h2>We are unable to process your request at  this  time. Please try again later.</h2>";
			else {
				header('Location: ./acc_created.php?first=' . $firstname . '&last=' . $lastname);
			}
			include 'includes/footer.php';
			exit;

		}#end !errors 
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
} //isset
?>
<h2>Japan Journey</h2>
<p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco
	laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor
	excepteur sint occaecat.</p>
<form method="post" action="create_acct.php">
	<fieldset>
		<legend>Become a Registered User:</legend>
		<?php if ($errors) { ?>
			<h2 class="warning">Please fix the item(s) indicated.</h2>
		<?php } ?>

		<?php if ($errors['firstname'])
			echo "<h2 class=\"warning\">{$errors['firstname']}</h2>"; ?>
		<p>
			<label for="fn">First Name: </label>
			<input name="firstname" id="fn" type="text" <?php if (isset($firstname)) {
				echo 'value="' . htmlspecialchars($firstname) . '"';
			} ?>>
		</p>
		<?php if ($errors['lastname'])
			echo "<h2 class=\"warning\">{$errors['lastname']}</h2>"; ?>
		<p>
			<label for="ln">Last Name: </label>
			<input name="lastname" id="ln" type="text" <?php if (isset($lastname)) {
				echo 'value="' . htmlspecialchars($lastname) . '"';
			} ?>>
		</p>
		<?php
		if ($errors['email'])
			echo "<h2 class=\"warning\">{$errors['email']}</h2>";
		if ($errors['exists'])
			echo "<h2 class=\"warning\">{$errors['exists']}</h2>";
		?>
		<p>
			<label for="email">Email: </label>
			<input name="email" id="email" type="text" <?php if (isset($email) && !$errors['email'] && !$errors['exists']) {
				echo 'value="' . htmlspecialchars($email) . '"';
			} ?>>
		</p>
		<?php if ($errors['pw'])
			echo "<h2 class=\"warning\">{$errors['pw']}</h2>";
		if ($errors['pwmatch'])
			echo "<h2 class=\"warning\">{$errors['pwmatch']}</h2>";
		?>
		<p>
			<label for="pw1">Password: </label>
			<input name="password1" id="pw1" type="password">
		</p>
		<p>
			<label for="pw2">Confirm Password: </label>
			<input name="password2" id="pw2" type="password">
		</p>
		<p>
			<input name="send" type="submit" value="Register">
		</p>
	</fieldset>
</form>
<?php include 'includes/footer.php'; ?>