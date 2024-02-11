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

$id = 0;
$pageTitle = "Alla sidor";
$title = "";
$content = "";
$user_id = $_SESSION['user_id'];
$edit_link = "";
$page_id = "";
$url = "";


// displaying pages and images retrieved from the database with the use of Class and Models
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $rows = $page->getAllPages();
    if ($rows) {
        echo '<ul>';
        foreach ($rows as $row) {
            echo '<li><a href="page.php?id=' . $row['id'] . '">' . $row['title'] . '</a></li>';
        }
        echo '</ul>';
    }
}
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
                // $image = $pageImage['id'];
                echo '<img src="' . $pageImage['url'] . '" alt="database image" width="400" height="225">
                <br>
                <br>
                <a href="image_edit.php?id=' . $id . '" class="button1"> Ta bort bild </a>   <br>   <br>';

            }
            echo '</div>';
        } else {
            echo '<p>No images found for this page</p>';
        }
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['user_id']) {
            $edit_link = '<a href="page_edit.php?id=' . $id . '"> Redigera sidan </a>';

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
    <?php $pageTitle ?>

    <div class="contentDiv">
        <main>
            <?php echo $title ?>
            <hr>
            <?php echo $content ?>
            <br>
            <br>
            <?php echo $edit_link ?>
          

        </main>
        <aside>
            <!-- meny -->
        </aside>
    </div>