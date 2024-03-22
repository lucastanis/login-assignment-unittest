<?php
	// Functie: Loginformulier
    // Auteur: Lucas Tanis

	// Inclusief benodigde bestanden
	// require_once('classes/user.php');
	require_once "../vendor/autoload.php";
    use Opdracht6Login\classes\User;

	
	// Is de inlogknop geklikt?
	if(isset($_POST['login-btn']) ){
		
		$user = new User();

		$user->username = $_POST['username'];
		$user->SetPassword($_POST['password']);

		$user->ShowUser();

		// Valideren van gegevens
		$errors = $user->ValidateUser();

		// Indien geen fouten, dan inloggen
		if(count($errors)== 0){
			// Inloggen
			if ($user->LoginUser()){
				echo "Inloggen gelukt";
				// Doorsturen naar pagina??
				header("location: index.php");
			} else
			{
				array_push($errors, "Inloggen mislukt");
				echo "Inloggen NIET gelukt";
			}
		}

		if(count($errors) > 0){
			$message = "";
			foreach ($errors as $error) {
				$message .= $error . "\\n";
			}
			
			echo "
			<script>alert('" . $message . "')</script>
			<script>window.location = 'login_form.php'</script>";
		
		}
		
	}
?>

<!DOCTYPE html>
<html lang="nl">
	<head>
	</head>
<body>

	<h3>PHP - PDO Inloggen en Registreren</h3>
	<hr/>
	
	<form action="" method="POST">	
		<h4>Hier inloggen...</h4>
		<hr>
		
		<label>Gebruikersnaam</label>
		<input type="text" name="username" />
		<br>
		<label>Wachtwoord</label>
		<input type="password" name="password" />
		<br>
		<button type="submit" name="login-btn">Inloggen</button>
		<br>
		<a href="register_form.php">Registratie</a>
	</form>
		
</body>
</html>
