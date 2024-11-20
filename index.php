<?php
    namespace Hatice\makeupshop;
    $pathToSSL = __DIR__ . "/CA.pem";
    session_start(); //elke pagina da je wilt checke
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
    }
    
    $conn = Db::getConnection(); //hier was PDO
    //select * from products and fetch as array
    $statement = $conn->prepare("SELECT * FROM products");
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
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
            <div class="newsfeedInfo">
            <h3>Your fave blush just got a bronzer bestie!</h3>
            <p>Get even more long-lasting Camo color with NEW Camo Liquid Bronzer & Contour + 3 NEW shades of Liquid Blush. Only $7 each.</p>
            <a href="">Shop</a>
        </div>
        <?php foreach($products as $product): ?>
        <article>
            <h2><?php echo $product["title"] . " " . $product["price"]; ?> </h2>
        </article>
        <?php endforeach; ?>
    </article>
</body>
</html>