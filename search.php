<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\User;
use Hatice\makeupshop\Product;


$search = isset($_GET['search']) ? $_GET['search'] : null;
$results = [];

if($search){
    $results = Product::search($search);
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <h1>Search Results for "<?php echo htmlspecialchars($search); ?>"</h1>
    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $product): ?>
                <li>
                    <a href="productPage.php?id=<?php echo $product['id']; ?>">
                    <div class="product">
                        <h2><?php echo ($product['title']); ?></h2>
                        <p><?php echo ($product['img']); ?></p>
                        <p>Price: <?php echo ($product['price']); ?></p>
                    </div>
            </a>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</body>
</html>