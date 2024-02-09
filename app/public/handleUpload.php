<?php
// session_start();

var_dump($_FILES);
include_once "_includes/database-connection.php";
include_once "_models/Image.php";
// include "_includes/header.php";

// method for saving the url in the database
$db = new Database();
//creating a new model for the class Image 
$imageModel = new Image();

// Get the uploaded file information
// $url = basename($_FILES["file"]["url"]);
$url = "1-scaled.jpeg";
$id = isset($_GET['id']) ? $_GET['id'] : null;
$url = isset($_POST['url']) ? $_POST['url'] : '';

$page_id = isset($_POST['page_id']) ? $_POST['page_id'] : null;

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // File upload directory
    $target_dir = "uploads/";

    if (isset($_POST['page_id'])) {
        $page_id = $_POST['page_id'];
    
        // filen som ska sparas
    $fileToUpload = $_FILES["file"]["name"];

    // full path blir
    $fullPath = $target_dir . $fileToUpload; // /uploads/runbox_invoice.pdf

    echo "You want to upload " . $fileToUpload . " to " . $fullPath;

    $succesfullUpload = move_uploaded_file($_FILES ['file']["tmp_name"], $fullPath);

    if ($succesfullUpload) {
        echo "<p>This was a success!</p>";

        $imageId = $imageModel->add_image($_FILES["file"]["name"], $fullPath);

        if ($imageId > 0) {
            echo "<p>Successfull insertion into table 'image' with id: " . $imageId . "</p>";
        }
    }
}
    } else {
        echo "<p> Not successful</p>";
    }
    
    foreach ($page_images as $page_image) {
        echo '<img src="'. $page_image['url'] .'">';
    }


?>

<style>
    <?php include 'styles/styles.css'; ?>
</style>
<h1>Ladda upp en fil</h1>


<form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Ladda upp bild till sidan</legend>
            <label for="upload">Välj bild</label>
            <input type="file" name="upload" id="upload">
            <input type="hidden" name="page_id" value="<?= $id ?>">
            <input type="submit" value="Ladda upp">
        </fieldset>
    </form>

