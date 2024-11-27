<?php
namespace Hatice\makeupshop;
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\Db;
use Hatice\makeupshop\Product;
session_start(); //elke pagina da je wilt checke
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
}
$pathToSSL = __DIR__ . "/CA.pem";
    
$conn = Db::getConnection(); //hier was PDO
//select * from products and fetch as array
$statement = $conn->prepare("SELECT * FROM products");
$statement->execute();
$products = $statement->fetchAll(\PDO::FETCH_ASSOC);

$product = new Product();
$newProducts = $product->getNewProducts();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
    <article class="display">
        <div class="newsfeed">
            <h3>New!</h3>
            <?php foreach ($newProducts as $product): ?>
            <li>
                <h2><?php echo ($product['title']); ?></h2>
                <p><?php echo ($product['img']); ?></p>
                <p>Price: <?php echo htmlspecialchars($product['price']); ?></p>
            </li>
        <?php endforeach; ?>
            <div class="newsfeedInfo">
            <h3>Your fave blush just got a bronzer bestie!</h3>
            <p>Get even more long-lasting Camo color with NEW Camo Liquid Bronzer & Contour + 3 NEW shades of Liquid Blush. Only $7 each.</p>
            <a href="">Shop</a>
        </div>
        <?php foreach($products as $product): ?>
        <article>
            <h2><?php
    echo '<h2>' . $product['title'] . '</h2>';
    echo '<p>' . $product['price'] . '</p>';
    echo '<img src="' . $product['img'] . '" alt="' . $product['title'] . '">'; ?> </h2>
        </article>
        <?php endforeach; ?>
    </article>
</body>
</html>