<?php
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

use Hatice\makeupshop\Db;

$category = isset($_GET['category']) ? $_GET['category'] : null;

if($category){
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT * FROM products WHERE category_id = :category_id");
    $statement->bindValue(':category_id', $category);
    $statement->execute();
    $product = $statement->fetchAll(\PDO::FETCH_ASSOC);
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
    <?php foreach ($product as $p): ?>
    <li>
        <a href="productPage.php?id=<?php echo $p['id']; ?>">
            <div class="product">
                <h2><?php echo ($p['title']); ?></h2>
                <p><img src="<?php echo ($p['img']); ?>" alt=""> </p>
                <p>Price: <?php echo ($p['price']); ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</body>
</html>