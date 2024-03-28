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

                if ($this->username != "") {
                    $sql = "SELECT * FROM `user` WHERE `username` = :username";
                    $params = [':username' => $this->username];
                    $existingUser = $this->GetData($sql, $params);

                    if ($existingUser) {
                        array_push($errors, "Username bestaat al.");
                    } else {
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
        
            if ($userData) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
        
                $_SESSION['username'] = $this->username;
        
                return true;
            } else {
                return false;
            }
        }
        
        public function IsLoggedin() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            return isset($_SESSION['username']);
        }
        
        public function GetUser($username){
            $sql = "SELECT * FROM `user` WHERE `username` = :username";
            $params = [':username' => $username];
            $userData = $this->GetData($sql, $params);
        
            if ($userData) {
                $this->username = $userData[0]['username'];
                $this->password = $userData[0]['password']; 
                $this->email = $userData[0]['email']; 
                $_SESSION['username'] = $this->username;
                $_SESSION['email'] = $this->email;
        
                return true;
            } else {
                return false; 
            }
        }
        
        
        
        

        public function Logout(){
            session_start();
            session_unset();
        
            session_destroy();
            
        }
    }
?>
