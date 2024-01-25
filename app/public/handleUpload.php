<?php
session_start();

// var_dump($_FILES);
include_once("_includes/database-connection.php");
include_once("_models/File.php");

// När fileModel skapas så kommer en ny tabell files att skapas i databasen
$imageModel = new Image();

// platsen där vi ska spara filen
$target_dir = "uploads/";

// filen som ska sparas
$imageToUpload = $_FILES["image"]["name"];

// full path blir
$fullPath = $target_dir . $imageToUpload; // /uploads/runbox_invoice.pdf

echo "You want to upload " . $imageToUpload . " to " . $fullPath;

$succesfullUpload = move_uploaded_file($_FILES["image"]["name"], $fullPath);

if ($succesfullUpload) {
    echo "<p>This was a success!</p>";

    $uploadedId = $imageModel->add_one($_FILES["image"]["url"], $_IMAGES["image"]["page_id"]);

    if ($uploadedId > 0) {
        echo "<p>Successfull insertion into table 'files' with id: " . $uploadedId . "</p>";
    }
}

?>