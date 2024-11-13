<?php
session_start();

if(!empty($_POST)){
    try {
    $product = new Product();
    $product->setTitle($_POST['title']);
    $product->setPrice($_POST['price']);
    $product->setImg($_POST['img']);
    $product->setDescription($_POST['description']);
    $product->setStock($_POST['stock']);
    $product->setVariation($_POST['variation']);
    

    $product->save();
    $success = "user saved!";
}
catch(\Throwable $th){
    //throw $th;
    $error = $th->getMessage();
}
}

/*if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
    exit;
}

if (isset($_POST['title']) && isset($_POST['price'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];

    $conn = new PDO('mysql:dbname=makeupshop;host=localhost', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $conn->prepare("INSERT INTO products (title, price) VALUES (:title, :price)");
    $statement->bindValue(':title', $title);
    $statement->bindValue(':price', $price);
    $statement->execute();

    $successMessage = "Product successfully added!";
}*/
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
</head>
<body>
    <h2>Add a New Product</h2>

    <!-- Display success message if set -->
    <?php if (isset($successMessage)): ?>
        <p><?php echo $successMessage; ?></p>
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
            <input type="text" name="description" required>
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
            <input type="submit" value="Add Product">
        </div>
    </form>
</body>
</html>