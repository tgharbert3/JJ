	<?php 
	$currentPage = basename($_SERVER['SCRIPT_FILENAME']); ?>
	<ul id="nav">
        <li><a href="index.php" <?php if ($currentPage == 'index.php') {echo 'id="here"'; } ?>>Home</a></li>
        <li><a href="blog.php" <?php if ($currentPage == 'blog.php') {echo 'id="here"'; } ?>>Blog</a></li>
        <li><a href="gallery.php" <?php if ($currentPage == 'gallery.php') {echo 'id="here"'; } ?>>Gallery</a></li>
		<li><a href="product_list.php" <?php if ($currentPage == 'product_list.php') {echo 'id="here"'; } ?>>Purchase Prints</a></li>
		<li><a href="contact_us.php" <?php if ($currentPage == 'contact_us.php') {echo 'id="here"'; } ?>>Contact</a></li>
    </ul>