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
    print_r2($rows);
}
if ($_GET) {

    // var_dump($_GET);
    print_r2($_GET);


    $id = isset($_GET['id']) ? $_GET['id'] : 0;

    $row = $page->getPageById($id);

    if ($row && isset($_GET['id']) && $_GET['id'] == $id) {


        $title = isset($_GET['title']) ? trim($_GET['title']) : "";
        $content = isset($_GET['content']) ? trim($_GET['content']) : "";
        $page_id = isset($_GET['page_id']) ? $_GET['page_id'] : 0;
        $url = isset($_GET['url']) ? trim($_GET['url']) : "";
        $content = $row['content'];
        print_r2($row);

        $pageImages = $imageModel->getImagesByPageId($page_id);

        // if (isset($_GET['page_id']) && $_GET['page_id'] == $page_id) {

        foreach ($pageImages as $pageImage) {
            if (isset($pageImage['page_id'])) {
                $url = $pageImage['url'];
                $page_id = $pageImage['page_id'];
                echo '<div>';
                echo '<img src="' . $pageImage['url'] . '">';
                echo '<li><a href="page.php?id=' . $pageImage['page_id'] . '"></a></li>';
                echo '</div>';
            }
            print_r2($pageImages);

        }

    } else {
        echo '<p>No images found for this page</p>';
    }

    // $date_created = $row['date_created'];
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['user_id']) {
        $edit_link = '<a href="page_edit.php?id=' . $id . '"> UPDATE </a>';
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

    <h1>Alla publicerade sidor</h1>

    <div class="contentDiv">
        <main>
            <?php echo $title ?>
            <hr>
            <?php echo $content ?>
            <br>
            <br>
            <?php echo $url ?>
            <br>
            <?php echo $page_id ?>
            <br>
            <?php echo $edit_link ?>
        </main>
        <aside>
            <!-- meny -->
        </aside>
    </div>