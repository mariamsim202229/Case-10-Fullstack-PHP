<?php
// inkludera föräldern så att man kan ärva
include_once("_models/Database.php");

// vi vill göra en klass som ärver från Database.php för att följer Anders kodkonverstion
// File Model ska ansvara för att allt som har göra med tabellen 'files'
// T.ex Create, Read, Update, Delete av filer
// 1. Börja med att göra en tom class 'File' som ärver från Database
class Page extends Database
{

    function __construct()
    {
        // 1. få kontakt med databasen i vår docker-compose
        parent::__construct();
        // 2. gör något extra som är specifikt för File
        $this->setup_page();
    }

    // Denna metoden ska köras när en FileModel skapas
    // Den ansvara för att starta upp en tabell i databasen om det
    // inte redan finns
    private function setup_page()
    {
        // SQL to create table if it does not exist
        $sql = "CREATE TABLE IF NOT EXISTS `page` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
            `content` text DEFAULT NULL,
            `date_created` date NOT NULL DEFAULT current_timestamp(),
            `user_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`),
            CONSTRAINT `page_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            )";

        // Execute query
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function add_one($id, $title, $content, $date_created, $user_id)
    {
        $stmt = $this->db->prepare("INSERT INTO page (id, title, content, date_created, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $title, $content, $date_created, $user_id]);

        // MySQL returns an id - last insterted Id...
        return $this->db->lastInsertId();
    }

    public function getPagesByUserId($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM page WHERE user_id = ?");
        $stmt->execute([$user_id]);

        return $stmt->fetchAll();
    }
}

?>