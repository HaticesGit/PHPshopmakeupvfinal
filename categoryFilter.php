<?php
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\Product;

ini_set('display_errors', 1);
error_reporting(E_ALL);

use Hatice\makeupshop\Db;

$category = isset($_GET['category']) ? $_GET['category'] : null;

// if($category){
//     $conn = Db::getConnection();
//     $statement = $conn->prepare("SELECT * FROM products WHERE category_id = :category_id");
//     $statement->bindValue(':category_id', $category);
//     $statement->execute();
//     $product = $statement->fetchAll(\PDO::FETCH_ASSOC);
// }
if ($category) {
    $products = Product::getProductsByCategory($category);
}
else{
    //error
    echo "No category selected";
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Our products </title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
    <?php foreach ($products as $p): ?>
    <li>
        <a href="productPage.php?id=<?php echo $p['id']; ?>">
            <div class="product">
                <h3><?php echo htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p><img src="<?php echo htmlspecialchars($p['img'], ENT_QUOTES, 'UTF-8'); ?>" alt=""> </p>
                <p>Price:  <?php echo htmlspecialchars($p['price'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</body>
</html>