<?php
session_start();
// including files which are used in the code
include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/Page.php";
include_once "_models/Image.php";
include_once "_models/User.php";
include "_includes/header.php";

$database = new Database();
$page = new Page();
$user = new User();
$imageModel = new Image();

//variables for the app
$id = 0;
$image_id = "";
$pageTitle = "Alla sidor";
$title = "";
$content = "";
$edit_link = "";
$page_id = "";
$url = "";
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$row = null;

$date_created = date('Y-m-d');

// displaying all pages retrieved from the database with the use of Class and Models
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $rows = $page->getAllPages();
    if ($rows) {
        echo $pageTitle;
        echo '<ul>';
        foreach ($rows as $row) {

            echo
                '<h1><a href="page.php?id=' . $row['id'] . '">' . $row['title'] . "-Användare:", $row['username'] . '</h1>';
        }
        echo '</ul>';
    }
}
// displaying a specific page based on its id, and display content, images, date_created, username 

if ($_GET) {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $row = $page->getPageById($id);

    if ($row && isset($_GET['id']) && $_GET['id'] == $id) {
        $title = isset($_GET['title']) ? trim($_GET['title']) : "";
        $content = isset($_GET['content']) ? trim($_GET['content']) : "";
        $content = $row['content'];
        echo '<div> Skapad den:' . $date_created . '</div>';
    }

    // if user is logged in, an upload form is shown under the page which the user has created
    // a link to editing the page is also displayed 
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['user_id']) {
        $edit_link = '<a href="page_edit.php?id=' . $id . '"> Redigera sidan </a>';
    } else {
        echo '<p> Inloggning krävs för att redigera eller för att lägga till bilder på sidan</p>';
    }

    $pageImages = $imageModel->getImagesByPageId($id);

    if ($pageImages) {
        echo '<div>';
        foreach ($pageImages as $pageImage) {
            $image_id = $pageImage['image_id'];
            $url = $pageImage['url'];

            echo '<img src="' . $url . '" alt="database image"> <br> <br>';

            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['user_id']) {

                echo ' <form action="page.php" method="POST" class="form1">
                <input type="hidden" name="image_id" id="$image_id" value=" ' . $image_id . '">
                    <input type="submit" value="Ta bort bild" name="delete" class="button1"> <br>
                      </form>';
            }
        }

        echo '</div>';
    }

}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete'])) {
    var_dump($_POST);
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $imagesDelete = $imageModel->deleteImagesByPageId($id);
    if ($imagesDelete) {
        header("Location: page.php?id=$id");
        echo "successful deletion of images";
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete'])) {

    $image_id = isset($_POST['image_id']) ? (int) $_POST['image_id'] : 0;
    $imageDelete = $imageModel->delete_image($image_id);

    if ($imageDelete) {
        header("Location: page.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="css" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEW PAGE</title>
</head>

<body>
    <style>
        <?php include 'styles/styles.css'; ?>
    </style>

    <div class="contentDiv">
        <main>
            <hr>
            <?php echo $content ?>
            <hr>
            <br>
            <br>
            <?php echo $edit_link ?>
        </main>
        <aside>
            <?php echo $title ?>
        </aside>
    </div>