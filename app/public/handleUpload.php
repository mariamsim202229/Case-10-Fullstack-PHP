<?php

include_once "_includes/database-connection.php";
include_once "_models/Image.php";

// method for saving the url in the database
$db = new Database();
//creating a new model for the class Image 
$imageModel = new Image();

$page_id = "";

// logic for submitting a file to the database, based on its id, url, and the page_id
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['upload'])) {

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $page_id = isset($_POST['page_id']) ? (int) $_POST['page_id'] : 0;

        // Get the uploaded file information
        $file_name = $_FILES['upload']['name'];
        $file_tmp = $_FILES['upload']['tmp_name'];
        $url = "uploads/" . $file_name;

        if (move_uploaded_file($file_tmp, $url)) {
            // lägg till bildens url i databasens tabell image
            $imageId = $imageModel->add_image($url, $page_id);

            if ($imageId > 0) {
                echo "<p>Successfull insertion into table 'image' with id: " . $imageId . "</p>";
                header("Location: page.php?id=$page_id");
            }
        } else {
            echo "<p> Not successful</p>";
        }
    }
}

?>

<style>
    <?php include 'styles/styles.css'; ?>
</style>
<h1>Ladda upp en fil</h1>

<?php

// Creating a table for inserting the data in the database in the table ´image´
if (isset($_SESSION['user_id'])) {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
?>
<?php
}

//a form for uploading files and inserting it into database, table image
?>
<form action="handleUpload.php" method="post" enctype="multipart/form-data" class="form2">
    <label for="upload">Välj bild</label>
    <br>
    <br>
    <input type="file" name="upload" id="upload" class="button4">
    <input type="hidden" name="page_id" value="<?= $id ?>">
    <br>
    <br>
    <input type="submit" value="Ladda upp" class="button">
</form>