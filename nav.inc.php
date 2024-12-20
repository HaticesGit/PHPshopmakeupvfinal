<?php 
include_once(__DIR__ . "/bootstrap.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Product.php");
use Hatice\makeupshop\Db;
use Hatice\makeupshop\User;

$email = $_SESSION['email'];
$isAdmin = User::adminCheck($email);
$userMoney = User::viewMoney($email);

?><nav>
    <div class="leftNav">
        <a href="index.php">Home</a>

        <form action="search.php" method="get">
            <input type="text" name="search" placeholder="Search for products">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="rightNav">
        <div class="navRow">
        <a href="cart.php"><img src="" alt="">Cart</a>
        <p>Wallet: <?php echo htmlspecialchars($userMoney['units'] ?? '0'); ?></p>

        

        <a href="changePassword.php">Change Password</a>
        <a href="logout.php">Log Out</a>
        </div>

        
    </div>
    
    
</nav>
        <div class="AdminBar">
            <?php if ($isAdmin['admin']): ?>
                <a href="addProduct.php">Add Product</a>
                <a href="addCategory.php">Add Category</a>
            <?php endif; ?>
        </div>