<?php
    // Functie: Inlogprogramma OOP 
    // Auteur: Younes Et-Talby

	// Inclusief benodigde bestanden
	// require_once('classes/user.php');
	require_once "../vendor/autoload.php";
	use Opdracht6Login\classes\User;


?>

<!DOCTYPE html>

<html lang="nl">

<body>

	<h3>PDO Inloggen en Registreren</h3>
	<hr/>

	<h3>Welkom op de THUIS-pagina!</h3>
	<br />
	<?php

		// Start sessie
		session_start();

		// Maak een User object
		$user = new User();

		// Als Uitloggen is geklikt
		if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
			$user->Logout(); // Roep de Logout methode aan
		}

		// Controleer inlogsessie: is de gebruiker ingelogd?
		if(!$user->IsLoggedin()){
			// Toon melding als niet ingelogd
			echo "U bent niet ingelogd. Log in om verder te gaan.<br><br>";
			// Toon inlogknop
			echo '<a href = "login_form.php">Login</a>';
		} else {
			
			// Selecteer gebruikersgegevens uit database
			// $user->GetUser($user->username);
			$user->GetUser($_SESSION['username']);
			
			// Toon gebruikersgegevens
			echo "<h2>Laat het spel beginnen</h2>";
			echo "U bent ingelogd als:<br/>";
			$user->ShowUser();
			echo "<br><br>";
			echo '<a href = "?logout=true">Uitloggen</a>';
		}
	
	?>

</body>
</html>
