<?php 
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
use Hatice\makeupshop\Db;
use Hatice\makeupshop\User;

$email = $_SESSION['email'];
$isAdmin = User::adminCheck($email);
?>
?><nav>
    <a href=""><Img></Img></a>
    <a href="index.php">Home</a>
    <a href="">Products</a>
    
    

    <input type="text" name="search" placeholder="search">
    <a href=""><img src="" alt=""></a> <!--heart-->
    <a href=""><img src="" alt=""></a> <!--cart-->
    <a href="">Account</a>

    <?php if ($isAdmin['admin']): ?>
        <a href="addProduct.php">Add Product</a>
        <a href="addCategory.php">Add Category</a>
    <?php endif; ?>

    <a href="changePassword.php">Change Password</a>
    <a href="logout.php">Log Out</a>
    <!--<a href="">Wallet : ?php echo  ?> </a>-->

    
</nav>