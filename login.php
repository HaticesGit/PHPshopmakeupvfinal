<?php
	include_once('classes/User.php');
	use Hatice\makeupshop\User;

	if (!empty($_POST)) {
		$email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    	$password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');

		$user = User::canLogin($email, $password);
		if ($user) {
			session_start();
			$_SESSION["loggedin"] = true;
			$_SESSION["email"] = $email;
			$_SESSION['user'] = $user;
			header('Location: index.php');
		} else {
			$error = true;
		}
	}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/makeupshop.css">
</head>
<body>
	<div class="formDiv">
<form action="" method="post" class="form">
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

				<div class="formField formFieldBottom">
					<input type="submit" value="Sign in" class="btn btn--primary">	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="labelInline">Remember me</label>
				</div>
				<div class="formField link"><a href="signup.php">Sign up</a></div>

			</form>
			</div>
</body>
</html>