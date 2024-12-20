<?php 
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
    echo "Error fetching cart: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
    $address = htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8');

    if (empty($address)) {
        $error = "Please provide a valid address.";
    } else {
        try {
            Product::order($userId, $address);
            header("Location: cart.php");
        } catch (Exception $e) {
            $error = "Error placing the order: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
<h1>Your Cart</h1>

    <?php if (!empty($error)): ?>
        <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
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
        <p><strong>Total Price:</strong> $<?php echo htmlspecialchars($totalPrice, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form action="cart.php" method="post" class="form">
        <input type="text" name="address" placeholder="Your address">
        <input type="submit" name="order" value="Order">
    </form>
    <a href="orders.php">View orders</a>
</body>
</html>