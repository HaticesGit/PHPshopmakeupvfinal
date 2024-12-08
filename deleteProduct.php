<?php 
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
include_once(__DIR__ . "/classes/User.php");
use Hatice\makeupshop\User;
use Hatice\makeupshop\Db;
use Hatice\makeupshop\Product;

$email = $_SESSION['email'];
$isAdmin = User::adminCheck($email);

if(!$isAdmin['admin']) {
    header('Location: index.php');
    exit;
}

$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if($product_id){
    try {
        $product = Product::getProductById($product_id);
    }
    catch (Exception $e) {
        die("Error fetching product: " . $e->getMessage());
    }
    
}
else {
    header("Location: index.php");
    exit;
}

if(isset($_POST['Delete'])){
    $id = $_POST['id'];
    Product::deleteProduct($id);
    header("Location: index.php");
    exit;
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleting product</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
    <h2>Deleting product</h2>
    <p>Are you sure you want to delete this product?</p>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="submit" name="Delete" value="Delete">
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>