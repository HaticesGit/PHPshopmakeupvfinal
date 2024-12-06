<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
include_once(__DIR__ . "/classes/User.php");
use Hatice\makeupshop\User;
use Hatice\makeupshop\Db;

$email = $_SESSION['email'];
$isAdmin = User::adminCheck($email);

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

if(!empty($_POST)){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $descr = $_POST['descr'];
    $stock = $_POST['stock'];
    $variation = $_POST['variation'];

    User::editProduct($id, $title, $price, $img, $descr, $stock, $variation);
    //show feedback
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

    <?php if ($isAdmin['admin']): ?>
    <div class="editProductForm formField">
        <h2>Edit Product</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo $product['title']; ?>">
            <label for="price">Price</label>
            <input type="text" name="price" id="price" value="<?php echo $product['price']; ?>">
            <label for="img">Image</label>
            <input type="text" name="img" id="img" value="<?php echo $product['img']; ?>">
            <label for="descr">Description</label>
            <input type="text" name="descr" id="descr" value="<?php echo $product['descr']; ?>">
            <label for="stock">Stock</label>
            <input type="text" name="stock" id="stock" value="<?php echo $product['stock']; ?>">
            <label for="variation">Variation</label>
            <input type="text" name="variation" id="variation" value="<?php echo $product['variation']; ?>">
            <input type="submit" value="Edit Product">
        </form>
    </div>
    <?php endif; ?>
</body>
</html>