<?php
session_start();

// var_dump($_FILES);
include_once "_includes/database-connection.php";
include_once "_models/Page.php";
include_once "_models/Image.php";

// När fileModel skapas så kommer en ny tabell files att skapas i databasen
$image = new Image();

// platsen där vi ska spara filen
$target_dir = "uploads/images";

// filen som ska sparas
$fileToUpload = $_FILES["file"]["name"];

// full path blir
$fullPath = $target_dir . '/' . $fileToUpload; // /uploads/runbox_invoice.pdf

echo "You want to upload " . $fileToUpload . " to " . $fullPath;

$succesfullUpload = move_uploaded_file($_FILES["file"]["tmp_name"], $fullPath);

if ($succesfullUpload) {
    echo "<p>This was a success!</p>";

    $uploadedId = $image->add_image($_FILES["file"]["name"], $fullPath);

    if ($uploadedId > 0) {
        echo "<p>Successfull insertion into table 'image' with id: " . $uploadedId . "</p>";
    }
}

?>