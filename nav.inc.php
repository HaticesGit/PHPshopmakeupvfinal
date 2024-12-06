<?php 
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\Db;
use Hatice\makeupshop\User;

$email = $_SESSION['email'];
$isAdmin = User::adminCheck($email);

// if(!empty ($_GET['search'])){
//     $search = $_GET['search'];
//     header("Location: search.php?search=$search");
//     exit;
// }

?><nav>
    <a href=""><Img></Img></a>
    <a href="index.php">Home</a>
    <a href="">Products</a>
    
    

    <form action="search.php" method="get">
        <input type="text" name="search" placeholder="Search for products">
        <button type="submit">Search</button>
    </form>


    <a href=""><img src="" alt=""></a> <!--heart-->
    <a href=""><img src="" alt="">Cart</a> <!--cart-->
    <a href="">Account</a>

    <?php if ($isAdmin['admin']): ?>
        <a href="addProduct.php">Add Product</a>
        <a href="addCategory.php">Add Category</a>
    <?php endif; ?>

    <a href="changePassword.php">Change Password</a>
    <a href="logout.php">Log Out</a>
    <!--<a href="">Wallet : ?php echo  ?> </a>-->

    
</nav>