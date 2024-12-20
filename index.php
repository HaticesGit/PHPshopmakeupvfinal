<?php
namespace Hatice\makeupshop;
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\Db;
use Hatice\makeupshop\Product;

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
}
$pathToSSL = __DIR__ . "/CA.pem";
    
$conn = Db::getConnection();
//select * from products and fetch as array
$products = Product::getAll();

$product = new Product();
$newProducts = $product->getNewProducts();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
    <div class="filter">
        <a href="categoryFilter.php?category=1">Blush</a>
        <a href="categoryFilter.php?category=2">Lipgloss</a>
        <a href="categoryFilter.php?category=4">Eyeshadow</a>
        <a href="categoryFilter.php?category=3">Mascara</a>
    </div>

    <article class="display">
        <h2>New!</h3>
        <div class="newsfeed displayDiv">
            
            <?php foreach ($newProducts as $product): ?>
                <li>
                    <a href="productPage.php?id=<?php echo $product['id']; ?>">
                        <div class="product">
                            <h3><?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                            <img src="<?php echo htmlspecialchars($product['img'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                            <p>Price:  <?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </div>
    </article>
</body>
</html>