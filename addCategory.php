<?php
namespace Hatice\makeupshop;
require_once(__DIR__.'\bootstrap.php');
include_once(__DIR__.'\classes\Category.php');
include_once(__DIR__.'\classes\User.php');
use Hatice\makeupshop\Db;
use Hatice\makeupshop\Category;

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];

    $category = new Category();
    $category->setType($type);

    $result = $category->addCategory($type);
    echo "Category added successfully!";
}
?><!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
<?php include_once("nav.inc.php"); ?>
    <h1>Add Category</h1>
    <form method="POST" action="">
        <label for="type">Category Type:</label>
        <input type="text" id="type" name="type" required>
        <button type="submit">Add Category</button>
    </form>
</body>
</html>