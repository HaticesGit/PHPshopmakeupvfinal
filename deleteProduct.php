<?php 
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
include_once(__DIR__ . "/classes/User.php");
use Hatice\makeupshop\User;
use Hatice\makeupshop\Db;

$email = $_SESSION['email'];
$isAdmin = User::adminCheck($email);

if(!$isAdmin['admin']) {
    header('Location: index.php');
    exit;
}

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

if(isset($_POST['Delete'])){
    $id = $_POST['id'];
    User::deleteProduct($id);
    header("Location: index.php");
    exit;
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleting product</title>
</head>
<body>
    <h2>Deleting product</h2>
    <p>Are you sure you want to delete this product?</p>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="submit" name="Delete" value="Delete">
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>