<?php
$currentPage = basename($_SERVER['SCRIPT_FILENAME']); ?>
<ul id="nav">
	<li><a href="index.php" <?php if ($currentPage == 'index.php') {
		echo 'id="here"';
	} ?>>Home</a></li>
	<li><a href="blog.php" <?php if ($currentPage == 'blog.php') {
		echo 'id="here"';
	} ?>>Blog</a></li>
	<li><a href="gallery.php?page=1" <?php if ($currentPage == 'gallery.php') {
		echo 'id="here"';
	} ?>>Gallery</a></li>
	<li><a href="product_list.php" <?php if ($currentPage == 'product_list.php') {
		echo 'id="here"';
	} ?>>Purchase
			Prints</a></li>
	<li><a href="contact_us.php" <?php if ($currentPage == 'contact_us.php') {
		echo 'id="here"';
	} ?>>Contact</a></li>
	<?php
	if (!isset($_SESSION['first_name'])) {
		echo '<li><a href="create_acct.php"';
		if ($currentPage == 'create_acct.php') {
			echo 'id="here"';
		}
		echo '> Register</a></li>';
		echo '<li><a href="login.php"';
		if ($currentPage == 'login.php') {
			echo 'id="here"';
		}
		echo '> Login</a></li>';
	} else {
		echo '<li><a href="logged_out.php">Logout</a></li>';
	}
	?>
</ul>