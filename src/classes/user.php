<?php
    // Functie: Classdefinitie User 
    // Auteur: Lucas Tanis

    namespace Opdracht6Login\classes;

    class User extends Database{

        // Eigenschappen 
        public $username;
        public $email;
        private $password;
        
        function SetPassword($password){
            $this->password = $password;
        }
        function GetPassword(){
            return $this->password;
        }

        public function ShowUser() {
            echo "<br>Username: $this->username<br>";
            echo "<br>Password: $this->password<br>";
            echo "<br>Email: $this->email<br>";
        }
        
        public function RegisterUser(){
            $status = false;
            $errors=[];
            if($this->username != "" || $this->password != ""){ 

                if ($this->username != "") { // Check if the username is provided
                    $sql = "SELECT * FROM `user` WHERE `username` = :username";
                    $params = [':username' => $this->username];
                    $existingUser = $this->GetData($sql, $params);

                    if ($existingUser) {
                        array_push($errors, "Username bestaat al.");
                    } else {
                        // Manier 1
                        // Username opslaan in tabel login
                        $sql = "INSERT INTO `user` (`username`, `password`, `role`) VALUES (:username, :password, '')";
                        $params = [
                            ':username' => $this->username,
                            ':password' => $this->password  
                        ];
                        $this->GetData($sql, $params);
                        
                        $status = true;
                    }
                            
                }
            }
            return $errors;
        }

        public function ValidateUser(){
            $errors = [];
            
            if (empty($this->username)){
                array_push($errors, "Invalid username");
            }
            
            if (empty($this->password)){
                array_push($errors, "Invalid password");
            }
            
            if (strlen($this->username) < 3 || strlen($this->username) > 50) {
                array_push($errors, 'Username moet > 3 en < 50 tekens zijn.');
            }
        
            return $errors;
        }
        
        

        public function LoginUser(){
            // Connect database
            $this->__construct();
        
            // Zoek user in de table user
            $sql = "SELECT * FROM `user` WHERE `username` = :username AND `password` = :password";
            $params = [
                ':username' => $this->username,
                ':password' => $this->password
            ];
            $userData = $this->GetData($sql, $params);
        
            // Indien gevonden dan sessie vullen
            if ($userData) {
                // Check if a session is already active
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
        
                // Populate the session with user data
                $_SESSION['username'] = $this->username;
        
                // Indicate successful login
                return true;
            } else {
                // Indicate failed login attempt
                return false;
            }
        }
        
        // Check if the user is already logged in
        public function IsLoggedin() {
            // Check if a session is already active
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Check if user session has been set
            return isset($_SESSION['username']);
        }
        
        public function GetUser($username){
            // Doe SELECT * from user WHERE username = $username
            $sql = "SELECT * FROM `user` WHERE `username` = :username";
            $params = [':username' => $username];
            $userData = $this->GetData($sql, $params);
        
            if ($userData) {
                // Indien gevonden eigenschappen vullen met waarden uit de SELECT
                $this->username = $userData[0]['username'];
                $this->password = $userData[0]['password']; // Set the password property
                $this->email = $userData[0]['email']; // Set the email property
        
                // Set session variables if needed
                $_SESSION['username'] = $this->username;
                $_SESSION['email'] = $this->email;
        
                return true; // Return true to indicate user found
            } else {
                return false; // Return false to indicate user not found
            }
        }
        
        
        
        

        public function Logout(){
            session_start();
            // remove all session variables
            session_unset();
        
            // destroy the session
            session_destroy();
            
            #header('location: index.php');
        }
    }
?>
