<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\User;
use Hatice\makeupshop\Product;


$userId = User::getByEmail($_SESSION["email"])['id'];

try {
    $cartData = Product::viewCart($userId);
    $cartItems = $cartData['items'];
    $totalPrice = $cartData['totalPrice'];
} catch (Exception $e) {
    echo "Error fetching cart: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
    $address = trim($_POST['address']);

    if (empty($address)) {
        $error = "Please provide a valid address.";
    } else {
        try {
            Product::order($userId, $address);
            header("Location: cart.php");
        } catch (Exception $e) {
            $error = "Error placing the order: " . $e->getMessage();
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
<h1>Your Cart</h1>

    <?php if (!empty($error)): ?>
        <p><?php echo ($error); ?></p>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cartItems as $item): ?>
                <li>
                    <strong><?php echo htmlspecialchars($item['title']); ?></strong>: 
                    $<?php echo htmlspecialchars($item['price']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total Price:</strong> $<?php echo ($totalPrice); ?></p>
    <?php endif; ?>

    <form action="cart.php" method="post" class="form">
        <input type="text" name="address" placeholder="Your address">
        <input type="submit" name="order" value="Order">
    </form>
    <a href="orders.php">View orders</a>
</body>
</html>