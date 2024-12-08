<?php
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\User;
use Hatice\makeupshop\Product;


$userId = User::getByEmail($_SESSION["email"])['id'];

try {
    $cartData = Product::viewOrder($userId);
    $cartItems = $cartData['items'];
    $totalPrice = $cartData['totalPrice'];
} catch (Exception $e) {
    echo "Error fetching order: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
<h1>Your Orders</h1>

<?php if (!empty($error)): ?>
    <p><?php echo ($error); ?></p>
<?php endif; ?>

<?php if (empty($cartItems)): ?>
    <p>Your Order is empty.</p>
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
</body>
</html>