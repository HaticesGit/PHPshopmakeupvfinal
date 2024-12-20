<?php
include_once(__DIR__ . "/classes/User.php");
use Hatice\makeupshop\User;
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(!empty($_POST)){
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');

    if (empty($email)) {
        $error = "Email cannot be empty.";
    } else {
        $user = User::canLogin($email, $password);
        if ($user) {
            $error = "This email is already in use. Please choose another one.";
        } else {
            $options = [
                'cost' => 12,
            ];
            $hash = password_hash($password, PASSWORD_DEFAULT, $options);
        
            $newUser = new User();
            $newUser->setEmail($email);
            $newUser->setPassword($hash);
            $newUser->save();

            header('Location: index.php');
        }
    }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create your account</title>
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
<div class="formDiv">
    <form action="" method="post" class="form">
        <h2 form__title>Sign Up</h2>

        <?php if(isset($error)): ?>
        <div class="formError">
            <p>
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </p>
        </div>
        <?php endif; ?>

        <div class="formField">
            <label for="Email">Email</label>
            <input type="text" name="email">
        </div>
        <div class="formField">
            <label for="Password">Password</label>
            <input type="password" name="password">
        </div>

        <div class="formField formFieldBottom">
            <input type="submit" value="Sign up" class="btn btn--primary">	
        </div>
        <div class="formField link"><a href="login.php">Log in</a></div>
    </form>
        </div>
</body>
</html>