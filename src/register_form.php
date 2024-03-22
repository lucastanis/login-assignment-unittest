<?php
	// Functie: Registratieformulier
    // Auteur: Lucas Tanis

	// Inclusief benodigde bestanden
	// require_once('classes/user.php');
	require_once "../vendor/autoload.php";
	use Opdracht6Login\classes\User;


	// Is de registreerknop geklikt?
	if(isset($_POST['register-btn'])){

		$user = new User();
		$errors=[];

		$user->username = $_POST['username'];
		$user->SetPassword($_POST['password']);

		$user->ShowUser();

		// Valideren van gegevens
		// Hoe???
		$errors = $user->ValidateUser();

		if(count($errors) == 0){
			// Gebruiker registreren
			$errors = $user->RegisterUser();
		}
		
		if(count($errors) > 0){
			$message = "";
			foreach ($errors as $error) {
				$message .= $error . "\\n";
			}
			
			echo "
			<script>alert('" . $message . "')</script>
			<script>window.location = 'register_form.php'</script>";
		
		} else {
			echo "
				<script>alert('" . "Gebruiker geregistreerd" . "')</script>
				<script>window.location = 'login_form.php'</script>";
		
		}

	}
?>

<!DOCTYPE html>
<html lang="nl">

<body>
	

		<h3>PHP - PDO Inloggen en Registreren</h3>
		<hr/>

			<form action="" method="POST">	
				<h4>Hier registreren...</h4>
				<hr>
				
				<div>
					<label>Gebruikersnaam</label>
					<input type="text"  name="username" />
				</div>
				<div >
					<label>Wachtwoord</label>
					<input type="password"  name="password" />
				</div>
				<br />
				<div>
					<button type="submit" name="register-btn">Registreren</button>
				</div>
				<a href="index.php">Home</a>
			</form>


</body>
</html>
