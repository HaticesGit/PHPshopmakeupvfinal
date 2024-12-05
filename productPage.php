<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\Db;

$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if($product_id){
    try {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM products WHERE id = :product_id");
        $statement->bindValue(':product_id', $product_id, \PDO::PARAM_INT);
        $statement->execute();
        $product = $statement->fetch(\PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        die("Error fetching product: " . $e->getMessage());
    }
    
}
else {
    header("Location: index.php");
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($product['title'] ?? "Product Page"); ?></title>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <div class="product">
        <h2><?php echo ($product['title']); ?></h2>
        <p><?php echo ($product['img']); ?></p>
        <p>Price: <?php echo ($product['price']); ?></p>
        <p><?php echo ($product['descr']); ?></p>
        <p>Stock: <?php echo ($product['stock']); ?></p>
        <p>Variation: <?php echo ($product['variation']); ?></p>
    </div>
</body>
</html>