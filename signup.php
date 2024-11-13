<?php
    if(!empty($_POST)){
        $email = $_POST["email"];
        $password = $_POST["password"];

        $options = [
            'cost' => 12,
        ];
        $hash = password_hash($password, PASSWORD_DEFAULT, $options);
        echo $hash;
    
        $conn = new PDO('mysql:dbname=makeupshop;host=localhost', "root", "root");
        $statement = $conn->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
        $statement->bindValue(':email', $email); //veilig tegen sql ijectie
        $statement->bindValue(':password', $hash);
        $statement->execute();
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create your account</title>
</head>
<body>
    <form action="" method="post">
        <h2 form__title>Sign Up</h2>

        <?php if(isset($error)): ?>
        <div class="formError">
            <p>
                Sorry, we can't log you in with that email address and password. Can you try again?
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

        <div class="formField">
            <input type="submit" value="Sign up" class="btn btn--primary">	
        </div>
    </form>
</body>
</html>