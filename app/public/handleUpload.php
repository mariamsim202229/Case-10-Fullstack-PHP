<?php
// session_start();

include_once "_includes/database-connection.php";
include_once "_models/Image.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // File upload directory
    $uploadDir = "uploads/";

    // Get the uploaded file information
    $url = basename($_FILES["image"]["url"]);
    $targetFilePath = $uploadDir . $url;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $url = isset($_POST['url']) ? $_POST['url'] : '';
    $page_id = isset($_POST['page_id']) ? $_POST['page_id'] : null;

    echo "Page ID: " . $page_id;
    // Check if the uploaded file is an image
    $isValidImage = getimagesize($_FILES["url"]["tmp_name"]) !== false;

    if ($isValidImage) {
        // Move the uploaded file to the specified directory
        move_uploaded_file($_FILES["url"]["tmp_name"], $targetFilePath);

        // method for saving the url in the database
        $db = new Database();
        $url = $targetFilePath;

        //creating a new model for the class Image 
        $imageModel = new Image();

        $imageId = $imageModel->add_image($targetFilePath, $page_id);
        echo "function add_image return: $imageId";
        if ($imageId) {
            header('Location: pages.php');
            exit;
        } else {
            echo "Error saving image URL to the database.";
        }
    } else {
        echo "Invalid image file.";
    }
} else {
    echo "Invalid request method.";
}
?>

<style>
    <?php include 'styles/styles.css'; ?>
</style>
<h1>Ladda upp en fil</h1>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="form1" enctype="multipart/form-data">
    <label for="image">Select image</label>
    <input class="button" type="file" name="url" id="url" required />
    <br>
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
    <input type="hidden" name="page_id" value="<?= $page_id ?>">
    <br>
    <input type="submit" value="Upload Image">
</form>