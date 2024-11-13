<?php
	function canLogIn($p_email, $p_password){ //p voor parameter, kan eender wat noemn
		$conn = new PDO('mysql:dbname=makeupshop;host=localhost', "root", "root");
		$statement = $conn->prepare('SELECT * FROM users WHERE email = :email'); //?
		$statement->bindValue(':email', $p_email); // bindvalue?
		$statement->execute();
		$user = $statement->fetch(PDO::FETCH_ASSOC); //?
		if($user){
			$hash = $user['password'];
			if(password_verify($p_password, $hash)){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			//not found
			return false;
		}
	}
	
	if(!empty($_POST)){
		$email = $_POST["email"]; //in form 
		$password = $_POST["password"];

		if(canLogIn($email, $password)){
			session_start();
			$_SESSION["loggedin"] = true;
			$_SESSION["email"]=$email;
			header('Location: index.php');
		}
		else{
			//niet ok
			$error = true;
		}
	}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
<form action="" method="post">
				<h2 form__title>Log In</h2>

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
					<input type="submit" value="Sign in" class="btn btn--primary">	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="labelInline">Remember me</label>
				</div>
			</form>
</body>
</html>