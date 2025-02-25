<!-- Tyler Harbert -->
<?php require("./includes/header.php") ?>

<?php
if (isset($_GET['submit']) && $_GET['submit'] == 'Submit') {
	if (!empty($_GET['name'])) {
		$name = $_GET['name'];
		$tempName = explode(" ", $name);
		$firstName = $tempName[0];
		if (!empty($tempName[1])) {
			$lastName = $tempName[1];
		} else {
			$lastName = null;
		}

	} else {
		$missing['name'] = "A name is required";
	}

	if (!empty($_GET['email'])) {
		$email = $_GET['email'];
	} else {
		$missing['email'] = "Email is required";
	}

	if (isset($_GET['comments'])) {
		$comments = $_GET['comments'];
	} else {
		$comments = "None given.";
	}

	if (isset($_GET['terms'])) {
		$terms = "You agreed to the terms.";
	} else {
		$missing['terms'] = "You must agree to terms.";
	}

	if (isset($_GET['subscribe'])) {
		$subscribe = 1;

	} else {
		$missing['subscribe'] = "Please make a selection.";
		$subscribe = 0;
	}

	if (isset($_GET['interests'])) {
		$interests = $_GET['interests'];
		$anime = 0;
		$arts = 0;
		$judo = 0;
		$langauge = 0;
		$science = 0;
		$travel = 0;
		foreach ($interests as $interest) {
			if ($interest == "anime") {
				$anime = 1;
			}
			if ($interest == "arts") {
				$arts = 1;
			}
			if ($interest == "judo") {
				$judo = 1;
			}
			if ($interest == "language") {
				$langauge = 1;
			}
			if ($interest == "science") {
				$science = 1;
			}
			if ($interest == "travel") {
				$travel = 1;
			}
		}

	} else {
		$missing['interests'] = "You must select at least one interest.";
	}

	if (isset($_GET['select']) && $_GET['select'] !== "Select One") {
		//To be able to fit in db. varchar(20)
		if ($_GET['select'] === "Recommended by friends") {
			$select = "Friends";
		} else {
			$select = $_GET['select'];
		}
		
	} else {
		$missing['select'] = "You must select one";
	}

	if (empty($missing)) {
			if (isset($lastName)) {
				echo "<h2> Thank you " . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . " for contacting us</h2>";
			} else {
				echo "<h2> Thank you " . htmlspecialchars($firstName) . " for contacting us.</h2>";
			}
			require_once('../../pdo_connect.php');
			try {
				$sql = "SELECT * FROM JJ_contacts WHERE emailAddr = :em";
				$stmt = $dbc->prepare($sql);
				$stmt->bindParam(":em", $email);
				$stmt->execute();
				$result = $stmt->fetch();
				$numRows = $stmt->rowCount();
				$stmt->closeCursor();
				if ($numRows > 0 ) {
					echo "<p>Email has already been used. Please try another.</p>";
					
					include('./includes/footer.php');
					exit;
				} else {
					$sql = "INSERT INTO JJ_contacts (firstName, lastName, emailAddr, comments, newsletter, howhear, anime,
						arts, judo, lang, sci, travel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					
					$stmt=$dbc->prepare($sql);
					$stmt->bindParam(1, $firstName);
					$stmt->bindParam(2, $lastName);
					$stmt->bindParam(3, $email);
					$stmt->bindParam(4, $comments);
					$stmt->bindParam(5, $subscribe);
					$stmt->bindParam(6, $select);
					$stmt->bindParam(7, $anime);
					$stmt->bindParam(8, $arts);
					$stmt->bindParam(9, $judo);
					$stmt->bindParam(10, $langauge);
					$stmt->bindParam(11, $science);
					$stmt->bindParam(12, $travel);
					
					$stmt->execute();
					$numRows = $stmt->rowCount();
					if ($numRows == 1) {
						echo "<p>We saved your information </p>" ;
					} else {
						echo "We were unable to store your information";
					}
				}
			} catch (Exception $e) {
				echo "". $e->getMessage() ."";
			}
			require("./includes/footer.php");
			exit;
	}
}
?>
<h2>Japan Journey</h2>
<p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore
	ullamco laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute
	irure dolor excepteur sint occaecat.</p>
<form method="get" action="contact_us.php">
	<fieldset>
		<legend>Contact Us</legend>
		<?php
		if (isset($missing)) {
			echo '<h3 class="warning"> Please fix the following: </h3>';
		}
		?>
		<p>
			<?php
			if (!empty($missing['name'])) {
				echo '<span class="warning">' . $missing['name'] . '</span>';
			}
			?>
			<label for="name">Name</label>
			<input type="text" name="name" id=name <?php
			if (isset($name)) {
				echo ' value = "' . htmlspecialchars($name) . '"';
			}
			?>>
		</p>

		<p>
			<?php
			if (!empty($missing['email'])) {
				echo '<span class="warning">' . $missing['email'] . '</span>';
			}
			?>
			<label for="email">Email:</label>
			<input type="text" name="email" id="email" <?php
			if (isset($email)) {
				echo ' value = "' . htmlspecialchars($email) . '"';
			}
			?>>
		</p>

		<p>
			<label>Comments: </label>
			<textarea name="comments"><?php
			if (isset($comments)) {
				echo htmlspecialchars($comments);
			}
			?></textarea>
		</p>

	</fieldset>
	<fieldset id="subscribe">
		<h2>Subscribe to newsletter?</h2>
		<?php
		if (isset($missing['subscribe'])) {
			echo '<p class="warning">' . $missing['subscribe'] . '</p>';
		}
		?>
		<p>
			<label><input type="radio" name="subscribe" value="yes" <?php
			if (isset($subscribe) && $subscribe === "yes") {
				echo ' checked="checked"';
			}
			?>>Yes </label><br>
		</p>
		<p>
			<label><input type="radio" name="subscribe" value="no" <?php
			if (isset($subscribe) && $subscribe === 'no') {
				echo ' checked="checked"';
			}
			?>>No </label><br>
		</p>
	</fieldset>
	<fieldset id="interests">

		<h2>Interests in Japan</h2>
		<?php
		if (isset($missing['interests'])) {
			echo '<p class="warning">' . $missing['interests'] . '</p>';
		}
		?>
		<div>
			<p><label><input type="checkbox" name="interests[]" value="anime" <?php
			if (isset($interests) && in_array("anime", $interests)) {
				echo " checked";
			}
			?>> Anime/Manga</label></p>
			<p><label><input type="checkbox" name="interests[]" value="arts" <?php
			if (isset($interests) && in_array("arts", $interests)) {
				echo " checked";
			}
			?>> Arts & Crafts</label></p>
			<p><label><input type="checkbox" name="interests[]" value="judo" <?php
			if (isset($interests) && in_array("judo", $interests)) {
				echo " checked";
			}
			?>> Judo, karate, etc. </label>
			</p>
		</div>
		<div>
			<p><label><input type="checkbox" name="interests[]" value="language" <?php
			if (isset($interests) && in_array("language", $interests)) {
				echo " checked";
			}
			?>> Language/literature
				</label> </p>
			<p><label><input type="checkbox" name="interests[]" value="science" <?php
			if (isset($interests) && in_array("science", $interests)) {
				echo " checked";
			}
			?>> Science &
					technology</label> </p>
			<p><label><input type="checkbox" name="interests[]" value="travel" <?php
			if (isset($interests) && in_array("travel", $interests)) {
				echo " checked";
			}
			?>> Travel </label></p>
		</div>
	</fieldset>
	<fieldset>

		<h2>How did you hear of Japan Journey?</h2>
		<?php
		if (isset($missing['select'])) {
			echo '<p class="warning">' . $missing['select'] . '</p>';
		}
		?>
		<p>
			<select name="select">
				<option>Select One</option>
				<option <?php
				if (isset($select) && $select === "Social Media") {
					echo " selected";
				}
				?>>Social
					Media </option>

				<option <?php
				if (isset($select) && $select === "Recommended by friends") {
					echo " selected";
				}
				?>>Recommended
					by friends</option>
				<option>Search Engine </option>
			</select>
		</p>

		<?php
		if (isset($missing['terms'])) {
			echo '<p class="warning">' . $missing['terms'] . '</p>';
		}
		?>
		<p><label><input type="checkbox" name="terms" <?php
		if (isset($terms)) {
			echo " checked";
		}
		?>> I agree
				to terms and conditions</label></p>

		<p>
			<input type="submit" name="submit" value="Submit">
			<input type="reset" name="reset" value="reset">
		</p>
	</fieldset>
</form>
<?php require("./includes/footer.php") ?>