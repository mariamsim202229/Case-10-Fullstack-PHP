<?php
session_start();
// including files which are used in the code
include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/Page.php";
include "_includes/header.php";

$database = new Database();
$page = new Page();

// displaying pages and images retrieved from the database with the use of Class and Models
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $rows = $page->getAllPages();
    $rowPage = $page->getPageById($id);
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


    <?php
    // Controlling that the array is not empty 
    // displaying the title of the pages published to the public
    if (!empty($rows)) {
        foreach ($rows as $row) {
            $id = $row["id"];
            $title = $row["title"];
            echo "<li><a href='page.php?id=$id'>$title</a></li>";
            // displaying the details of the page to the users who are signed in 
            if ($rowPage && isset($_GET['id']) && $_GET['id'] == $id) {

                echo '<div class= "contentDiv">';
                echo '<p>' . $row['content'] . '</p>';
                echo 'Publicerad:';
                echo $row['date_created'];
                echo '<hr>';
                echo 'Användare:';
                echo $row['username'];
                echo '<form action="page_edit.php" method="post">
                            <input type="hidden" name="id" value="' . $id . '">
                            <input type="submit" value="Ta bort" name="delete" class="button1">
                        </form>';

                // } else {
                // Check if 'url' is an array and handle it appropriately
                // if (isset($row['url'])) {
                //     // foreach ($row['url'] as $url) {
                //     echo $url . '<br>';
                //     // }
                // } else {
                //     echo 'No URL available';
                // }
                // echo '</div>';
                echo '<a href="page_edit.php?id= ' . $id . '</a> UPDATE';
            }
        }
        echo '</div>';
    } else {
        echo 'No pages found.';
    }
    ?>

    <?