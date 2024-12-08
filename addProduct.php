<?php
namespace Hatice\makeupshop;
require_once(__DIR__.'/bootstrap.php');
include_once(__DIR__.'/classes/User.php');
//var_dump(file_exists(__DIR__ . "/classes/Product.php")); // Should output: bool(true)
//var_dump(class_exists("Hatice\\makeupshop\\Product"));

// ini_set('display_errors', 1);
// error_reporting(E_ALL);
// include_once(__DIR__."\classes\Db.php");
// include_once(__DIR__."\classes\Product.php");

use Hatice\makeupshop\Db;
use Hatice\makeupshop\Product;
$email = $_SESSION['email'];
$isAdmin = User::adminCheck($email);

if (!$isAdmin['admin']) {
    header('Location: index.php');
    exit;
}

// if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
//     header('Location: index.php');
//     exit;
// }

$allProducts = Product::getAll();

//var_dump($allProducts);

if(!empty($_POST)){
    try {
    $product = new Product();
    $product->setTitle(htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8'));
    $product->setPrice(htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8'));
    $product->setImg(htmlspecialchars($_POST['img'], ENT_QUOTES, 'UTF-8'));
    $product->setDescription(htmlspecialchars($_POST['descr'], ENT_QUOTES, 'UTF-8'));
    $product->setStock(htmlspecialchars($_POST['stock'], ENT_QUOTES, 'UTF-8'));
    $product->setVariation(htmlspecialchars($_POST['variation'], ENT_QUOTES, 'UTF-8'));
    $product->setCategory_id(htmlspecialchars($_POST['category_id'], ENT_QUOTES, 'UTF-8'));
    
    
    $result = $product->save();
    echo htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
    $success = "user saved!";
}
catch(\Throwable $th){
    //throw $th;
    echo "error";
    $error = htmlspecialchars($th->getMessage(), ENT_QUOTES, 'UTF-8');
}
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
    <h2>Add a New Product</h2>

    <!-- Display success message if set -->
    <?php if (isset($successMessage)): ?>
    <p style="color: green;"><?php echo $successMessage; ?></p>
<?php endif; ?>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

    <form action="addProduct.php" method="post">
        <div>
            <label for="title">Product Title:</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label for="price">Product Price:</label>
            <input type="text" name="price" required>
        </div>
        <div>
            <label for="img">Product Image:</label>
            <input type="text" name="img" required>
        </div>
        <div>
            <label for="description">Product Description:</label>
            <input type="text" name="descr" required>
        </div>
        <div>
            <label for="stock">Product Stock:</label>
            <input type="text" name="stock" required>
        </div>
        <div>
            <label for="variation">Product Variation:</label>
            <input type="text" name="variation" required>
        </div>
        <div>
            <label for="category">Product Category:</label>
            <input type="text" name="category_id" required>
        </div>

        <div>
            <input type="submit" value="Add Product">
        </div>
    </form>
</body>
</html>
