<?php
// inkludera föräldern så att man kan ärva
include_once "_models/Database.php";

// 1. Börja med att göra en tom class 'Page' som ärver från Database
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
    public function getAllPages()
    {
        $stmt = $this->db->prepare("SELECT page.*, user.username FROM page INNER JOIN user ON page.user_id = user.id");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPageById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `page` WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function add_one($title, $content, $user_id)
    {
        $stmt = $this->db->prepare("INSERT INTO page (title, content, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $user_id]);
        // MySQL returns an id - last insterted Id...
        return $this->db->lastInsertId();
    }
    public function edit_page($id, $form_title, $form_content)
    {
        $stmt = $this->db->prepare("UPDATE `page` SET `title`= :title,`content`= :content WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(":title", $form_title, PDO::PARAM_STR);
        $stmt->bindParam(":content", $form_content, PDO::PARAM_STR);
        // return $stmt->rowCount();
       return $stmt->execute();
        // return $this->db->lastInsertId();
    }

    public function delete_one($id)
    {
        $stmt = $this->db->prepare("DELETE FROM `page` WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        // return number of affected rows
        return $stmt->rowCount();
    }
}
