<?php
// inkludera föräldern så att man kan ärva
include_once "_models/Database.php";

// vi vill göra en klass som ärver från Database.php för att följer Anders kodkonverstion
// File Model ska ansvara för att allt som har göra med tabellen 'files'
// T.ex Create, Read, Update, Delete av filer

// 1. Börja med att göra en tom class 'File' som ärver från Database
class Image extends Database

{

    function __construct()
    {
        // 1. få kontakt med databasen i vår docker-compose
        parent::__construct();
        // 2. gör något extra som är specifikt för File
        $this->setup_image();
    }

    // Denna metoden ska köras när en FileModel skapas
    // Den ansvara för att starta upp en tabell i databasen om det
    // inte redan finns
    private function setup_image()
    {
        // SQL to create table if it does not exist
        $sql = "CREATE TABLE IF NOT EXISTS image (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        url varchar(255) NOT NULL,
        page_id int(11) NOT NULL,
        KEY `page_id` (`page_id`),
        CONSTRAINT `image_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
         )";

        // Execute query
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function add_image($url, $page_id)
    {
        $stmt = $this->db->prepare("INSERT INTO image ( url, page_id) VALUES ( ?, ?)");
        $stmt->execute([$url, $page_id]);

        // MySQL returns an id - last insterted Id...
        return $this->db->lastInsertId();
    }

    public function getImagesByPageId($page_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM image JOIN page ON image.page_id = page.id ");
        $stmt->execute([$page_id]);
        return $stmt->fetchAll();
    }
}

?>