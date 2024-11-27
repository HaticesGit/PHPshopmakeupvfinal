<?php
namespace Hatice\makeupshop;
require_once(__DIR__.'\bootstrap.php');
include_once(__DIR__.'\classes\Category.php');
use Hatice\makeupshop\Db;
use Hatice\makeupshop\Category;

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
</head>
<body>
    <h1>Add Category</h1>
    <form method="POST" action="">
        <label for="type">Category Type:</label>
        <input type="text" id="type" name="type" required>
        <button type="submit">Add Category</button>
    </form>
</body>
</html>