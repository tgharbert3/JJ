<?php //The cart workings
session_start();
if (empty($_SESSION['cart'])) {
	$_SESSION['cart'] = array();
}
// ini_set('display_errors', 1);

// Determine the action to perform
if (!empty($_GET['action'])) {
	$action = $_GET['action'];
}

if (!empty($_POST['action'])) {
	$action = $_POST['action'];
}

if (empty($_GET['action']) && empty($_POST['action'])) {
	$action = 'show_cart';
}

// Add or update cart as needed
switch ($action) {
	case 'details':
		include('product_details.php');
		break;
	case 'add':
		$imgID = filter_var(
			$_POST['image_id'],
			FILTER_SANITIZE_NUMBER_INT
		);
		$qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);
		if (isset($_SESSION['cart'][$imgID])) { //item already in cart
			$_SESSION['cart'][$imgID]['quantity'] += $qty; //update the quantity
			//Get the price from the cart in $_SESSION and set it to $cart_price
			$cart_price = $_SESSION['cart'][$imgID]['price'];
		} else { // New product to the cart.
			// Get the print's data from the database:
			require_once '../../pdo_connect.php'; // Connect to the database.
			$getImage = "SELECT * FROM JJ_images WHERE image_id = ?";
			$stmt = $dbc->prepare($getImage);
			$stmt->bindParam(1, $imgID);
			$stmt->execute();
			$rows = $stmt->rowCount();
			if ($rows == 1) { // Valid print ID.
				// Fetch the information.
				$item = $stmt->fetch();
				$imgID = $item['image_id'];
				$imgTitle = $item['caption'];
				$imgPrice = $item['price'];
				// Add to the cart:
				$_SESSION['cart'][$imgID]['caption'] = $imgTitle;
				$_SESSION['cart'][$imgID]['quantity'] = $qty;
				$_SESSION['cart'][$imgID]['price'] = $imgPrice;

			} else { // Not a valid print ID.
				require 'includes/header.php';
				echo '<main><h2>We are unable to process your request at  this  time.</h2><h3>Please try again later.</h3></main>';
				include 'includes/footer';
				exit;
			}
		} // end of new product else
		include('cart_view.php');
		break;
	case 'update':
		$new_qty_list = filter_var($_POST['newqty'], FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
		foreach ($new_qty_list as $img => $qty) {
			if ($_SESSION['cart'][$img]['quantity'] != $qty) {
				$quantity = (int) $qty;
				if (isset($_SESSION['cart'][$img])) {
					if ($quantity <= 0) {
						unset($_SESSION['cart'][$img]);
					} else {
						$_SESSION['cart'][$img]['quantity'] = $quantity;
					}
				}
			}
		}
		include('cart_view.php');
		break;
	case 'show_cart':
		include('cart_view.php');
		break;
	case 'empty_cart':
		unset($_SESSION['cart']);
		include('cart_view.php');
		break;
} //end switch
?>