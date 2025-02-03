<?php require("./includes/header.php") ?>

<?php
if (isset($_GET['submit']) && $_GET['submit'] == 'Submit') {
	if (!empty($_GET['name'])) {
		$name = $_GET['name'];
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
		$subscribe = $_GET['subscribe'];
	} else {
		$missing['subscribe'] = "Please make a selection.";
	}

	if (isset($_GET['interests'])) {
		$interests = $_GET['interests'];
	} else {
		$missing['interests'] = "You must select at least one interest.";
	}

	if (isset($_GET['select']) && $_GET['select'] !== "Select One") {
		$select = $_GET['select'];
	} else {
		$missing['select'] = "You must select one";
	}

	if (empty($missing)) {
		echo "<h3> Thank you for contacting us</h3>";
		echo "<h3>You submitted the following: </h3>";
		echo "<p> Name: $name </p>";
		echo "<p> Email: $email </p>";
		echo "<p> Comments: $comments </p>";
		echo "<p> Subscribe: $subscribe </p>";
		echo "<p>Interests: </p>";
		echo "<ul>";
		foreach ($interests as $key => $value) {
			echo "<li> $value </li>";
		}
		echo "</ul>";
		echo "<p>You heard about us how: $select</p>";
		echo "<p>$terms</p>";
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
		<label for="name">Name</label>
		<?php
		if (!empty($missing['name'])) {
			echo '<p class="warning">' . $missing['name'] . '</p>';
		}
		?>
		<input type="text" name="name" id=name <?php
		if (isset($name)) {
			echo ' value = "' . htmlspecialchars($name) . '"';
		}
		?>>
		<label for="email">Email:</label>
		<?php
		if (!empty($missing['email'])) {
			echo '<p class="warning">' . $missing['email'] . '</p>';
		}
		?>
		<input type="text" name="email" id="email" <?php
		if (isset($email)) {
			echo ' value = "' . htmlspecialchars($email) . '"';
		}
		?>>
		<label>Comments: </label>
		<textarea name="comments"><?php
		if (isset($comments)) {
			echo htmlspecialchars($comments);
		}
		?></textarea>
	</fieldset>
	<br>
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