<?php
session_start();
// including files which are used in the code
include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/Page.php";
include_once "_models/Image.php";
include "_includes/header.php";

$database = new Database();
$page = new Page();
$imageModel = new Image();

//variables for the app
$id = 0;
$pageTitle = "Alla sidor";
$title = "";
$content = "";
$edit_link = "";
$page_id = "";
$url = "";

// displaying all pages retrieved from the database with the use of Class and Models
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $rows = $page->getAllPages();
    if ($rows) {
        echo $pageTitle;
        echo '<ul>';
        foreach ($rows as $row) {
            echo '<div class="form1"><a href="page.php?id=' . $row['id'] . '">' . $row['title'] . '---', "användare:", $row['username'] . '---', "datum:", $row['date_created'] . '</a></div>';
            echo '<br>';
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

        $pageImages = $imageModel->getImagesByPageId($id);
        if ($pageImages) {
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            echo '<div>';
            foreach ($pageImages as $pageImage) {
                echo '<img src="' . $pageImage['url'] . '" alt="database image" width="300" height="170"> <br> <br>';
            }
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['user_id']) {
                '<a href="image_edit.php?id=' . $id . '" class="button1"> Ta bort bild </a>   <br>   <br>';
            }
            echo '</div>';
        } else {
            echo '<p>No images found for this page</p>';
        }

        // if user is logged in, an upload form is shows under the page which the user has created
        // a link to editing the page is also displayed 
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['user_id']) {
            include "handleUpload.php";
            $edit_link = '<a href="page_edit.php?id=' . $id . '"> Redigera sidan </a>';
        } else {
            echo '<p> Inloggning krävs för att redigera eller för att lägga till bilder på sidan</p>';
        }
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