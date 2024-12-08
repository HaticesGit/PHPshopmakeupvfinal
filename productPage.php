<?php
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
$product_id = isset($_GET['id']) ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8') : null;
$allReviews = Review::getAll($product_id);

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
        die("Error fetching product: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
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

    Product::editProduct($id, $title, $price, $img, $descr, $stock, $variation);
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
        echo "Error adding product to cart: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <div class="product">
        <h2><?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
        <img src=" <?php echo htmlspecialchars($product['img'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
        <p>Price:  <?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><?php echo htmlspecialchars($product['descr'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Stock:  <?php echo htmlspecialchars($product['stock'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Variation:  <?php echo htmlspecialchars($product['variation'], ENT_QUOTES, 'UTF-8'); ?></p>
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
            <li><?php echo $review['text']; ?></li>
        <?php endforeach; ?>
    </ul>
    </div>

    <?php if ($isAdmin['admin']): ?>
    <div class="editProductForm formField">
        <h2>Edit Product</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?>">
            <label for="price">Price</label>
            <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>">
            <label for="img">Image</label>
            <input type="text" name="img" id="img" value="<?php echo htmlspecialchars($product['img'], ENT_QUOTES, 'UTF-8'); ?>">
            <label for="descr">Description</label>
            <input type="text" name="descr" id="descr" value="<?php echo htmlspecialchars($product['descr'], ENT_QUOTES, 'UTF-8'); ?>">
            <label for="stock">Stock</label>
            <input type="text" name="stock" id="stock" value="<?php echo htmlspecialchars($product['stock'], ENT_QUOTES, 'UTF-8'); ?>">
            <label for="variation">Variation</label>
            <input type="text" name="variation" id="variation" value="<?php echo htmlspecialchars($product['variation'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="submit" name="aciton" value="Edit Product">
            <a href="deleteProduct.php?id=<?php echo htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8'); ?>">Delete</a>
        </form>
    </div>
    <?php endif; ?>

    <script src="app.js" ></script>
</body>
</html>