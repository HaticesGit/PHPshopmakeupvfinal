<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Review.php");
use Hatice\makeupshop\Review;
use Hatice\makeupshop\User;
use Hatice\makeupshop\Db;
use Hatice\makeupshop\Product;

$userId = User::getByEmail($_SESSION["email"])['id'];
$email = $_SESSION['email'];
$isAdmin = User::adminCheck($email);
$product_id = isset($_GET['id']) ? $_GET['id'] : null;
$allReviews = Review::getAll($product_id);
var_dump($allReviews);

$canReview = Review::hasOrderedProduct($userId, $product_id);

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

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aciton'])){
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToCart'])) {
    $productId = $_GET['id'];
    // $userId = User::getByEmail($_SESSION["email"])['id'];

    try {
        Product::addToCart($userId, $productId);
        echo "Product added to cart successfully!";
    } catch (Exception $e) {
        echo "Error adding product to cart: " . $e->getMessage();
    }
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
        <form action="" method="POST">
            <input type="submit" name="addToCart" value="Add to cart">
        </form>
    </div>

    <div class="reviews">
    <h2>Here are some reviews</h2>
    <?php if ($canReview): ?>
        <input type="text" name="reviews" id="reviewText" placeholder="Leave a review!">
        <a href="#" class="btn" id="btnAddReview" data-productid="<?php echo $product['id']; ?>">Add review</a>
    <?php else: ?>
        <p>You need to purchase this product to leave a review.</p>
    <?php endif; ?>
    <ul class="reviewLI">
        <?php foreach ($allReviews as $review): ?>
            <li><?php echo htmlspecialchars($review['text']); ?></li>
        <?php endforeach; ?>
    </ul>
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
            <input type="submit" name="aciton" value="Edit Product">
            <a href="deleteProduct.php?id=<?php echo $product['id']; ?>">Delete</a>
        </form>
    </div>
    <?php endif; ?>

    <script src="app.js" ></script>
</body>
</html>