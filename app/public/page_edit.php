<?php
//starting a session 
session_start();

// including files which are used in the code
include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";
include "_includes/header.php";

$title = "Redigera";
$database = new Database();
$page = new Page();
$user = new User();
$imageModel = new Image();

$id = 0;
$row = null;
$title = "";
$content = "";
$user_id = $_SESSION['user_id'];

if (isset($_SESSION['user_id'])) {

    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update'])) {
        // var_dump($_POST);
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : "";
        $content = isset($_POST['content']) ? trim($_POST['content']) : "";
        $pageUpdate = $page->edit_page($id, $title, $content);

        // Kontrollera om uppdateringen lyckades
        if ($pageUpdate) {
            header("Location: page.php");
            exit;
        } else {
            echo "cannot update page";
        }

        print_r2($pageUpdate);
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete'])) {
    // var_dump($_POST);
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $imagesDelete = $imageModel->deleteImagesByPageId($id);

    if ($imagesDelete) {
        header('Location: page.php');
        echo "successful deletion of images";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete'])) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $pageDelete = $page->delete_one($id);
    // Kontrollera om raderingen lyckades
    if ($pageDelete) {
        // Omdirigera till en framgångssida eller visa ett framgångsmeddelande
        header('Location: page.php');
        exit;
    }
}

if ($_GET) {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $row = $page->getPageById($id);
    if ($row) {
        $title = $row['title'];
        $content = $row['content'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        <?php include 'styles/styles.css'; ?>
    </style>

    <?php
    // Creating a table for inserting the data in the database in the table ´page´
    ?>
    <?php
    if ($row && isset($_SESSION['user_id'])) {
        include "handleUpload.php";
        ?>
        <form action="page_edit.php" method="POST" class="form1">
            <p>
                <label> Redigera och ta bort </label>
                <br>
                <input type="text" name="title" id="title" value="<?= $title ?>" maxlength="25">
                <hr>
                <input type="text" name="content" id="content" value="<?= $content ?>" cols="30" rows="10" maxlength="255">
                <hr>
            </p>
            <input type="hidden" name="id" id="id" value="<?= $id ?>">
            <input type="submit" value="update" name="update" class="button">
            <input type="submit" value="Ta bort" name="delete" class="button1">
        </form>
        <?php
    }
    ?>
</body>

</html>