<?php
    // Functie: Databaseverbinding
    // Auteur: Lucas Tanis

    namespace Opdracht6Login\classes;

    use \PDO;
    use \PDOException;

    class Database{

        private $username = "root";
        private $password = "";
        private $dbname = "login";
        private $hostname = "localhost";
        private $conn;


        public function __construct()
        {
            try {
                $this->conn = new PDO("mysql:host=$this->hostname;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
            catch(PDOException $e) {
                echo "Verbinding mislukt: " . $e->getMessage();
            }
        }

        public function GetData($sql, $params = array()){
            $result = [];

            try {
                if(!$this->conn) {
                    $this->__construct();
                }

                $query = $this->conn->prepare($sql);
                $query->execute($params);
                $result = $query->fetchAll();
            } catch(PDOException $e) {
                echo "Fout: " . $e->getMessage();
            }

            return $result;
        }
    }



?>
