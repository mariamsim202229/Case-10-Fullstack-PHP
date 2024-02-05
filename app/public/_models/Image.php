<?php
include_once "_models/Database.php";

// 1. class Image 
class Image extends Database
{
    function __construct()
    {
        // 1. få kontakt med databasen i vår docker-compose
        parent::__construct();
        // 2. gör något extra som är specifikt för File
        $this->setup_image();
    }

    // Denna metoden ska köras när en ImageModel skapas
    // Den ansvarar för att starta upp en tabell i databasen om det
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

    public function getImagesByPageId($page_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM image INNER JOIN page ON image.page_id = page.id  WHERE image.page_id = :page_id ");
        // $stmt->bindParam(':url', $url, PDO::PARAM_STR);
        $stmt->bindParam(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function add_image($url, $page_id)
    {
        $stmt = $this->db->prepare("INSERT INTO image ( url, page_id) VALUES ( :url, :page_id)");
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->execute();
        // MySQL returns an id - last insterted Id...
        return $this->db->lastInsertId();
    }
}