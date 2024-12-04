<?php
include_once(__DIR__ . '/bootstrap.php');
include_once(__DIR__ . '/classes/User.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_SESSION);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword !== $confirmPassword) {
        $error = "New passwords do not match.";
    } else {
        $conn = new PDO('mysql:dbname=makeupshop;host=localhost', "root", "root");
        $statement = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue(':email', $_SESSION['email']);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStatement = $conn->prepare('UPDATE users SET password = :password WHERE email = :email');
            $updateStatement->bindValue(':password', $newPasswordHash);
            $updateStatement->bindValue(':email', $_SESSION['email']);
            $updateStatement->execute();

            $success = "Password successfully changed.";
        } else {
            $error = "Current password is incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
    <div class="formDiv">
        <form action="" method="post" class="form">
            <h2 form__title>Change Password</h2>

            <?php if(isset($error)): ?>
            <div class="formError">
                <p><?php echo $error; ?></p>
            </div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
            <div class="formSuccess">
                <p><?php echo $success; ?></p>
            </div>
            <?php endif; ?>

            <div class="formField">
                <label for="currentPassword">Current Password</label>
                <input type="password" name="currentPassword" required>
            </div>
            <div class="formField">
                <label for="newPassword">New Password</label>
                <input type="password" name="newPassword" required>
            </div>
            <div class="formField">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" name="confirmPassword" required>
            </div>

            <div class="formField formFieldBottom">
                <input type="submit" value="Change Password" class="btn btn--primary">
            </div>
        </form>
    </div>
</body>
</html>