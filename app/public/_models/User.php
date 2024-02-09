<?php
    // inkludera föräldern så att man kan ärva
    include_once "_models/Database.php";

    // 1. Börja med att göra en tom class 'User' som ärver från Database
    class User extends Database {

        function __construct() {
            // 1. få kontakt med databasen i vår docker-compose
            parent::__construct();
            // 2. gör något extra som är specifikt för User
            $this->setup_user();
        }

        // Denna metoden ska köras när en UserModel skapas
        // Den ansvara för att starta upp en tabell i databasen om det
        // inte redan finns
        private function setup_user() {
            $sql = "CREATE TABLE IF NOT EXISTS `user` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `username` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
              )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; ";
        
            // Execute query
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }

        public function register($username, $password) {
            // hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // add to database
            $stmt = $this->db->prepare("INSERT INTO `user` (`username`, `password`) VALUES (?, ?)");

            $stmt->execute([$username, $hashed_password]);
            return $this->db->lastInsertId();
        }

        public function authenticate($username, $password) {
            // send to database
            $stmt = "SELECT * FROM `user` WHERE `username` = '$username' ";
            $result = $this->db->query($stmt);
            
            $user = $result->fetch();
            
            // no user found with these credentials
            if (!$user) {
                header("location: login.php");
                return -1;
            }

            $is_correct_password = password_verify($password, $user['password']);
            if (!$is_correct_password) {
                return -2;
            }

            // Allt gick bra
            return $user;
        }
    }
?>