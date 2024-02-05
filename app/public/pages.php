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

$database = new Database();
$page = new Page();
$user = new User();
$imageModel = new Image();

// Preparing variables used in the form 
$user_id = $_SESSION['user_id'];
$id = isset($_GET['id']) ? $_GET['id'] : null;
$url = isset($_GET['url']) ? $_GET['url'] : '';
$page_id = isset($_GET['page_id']) ? $_GET['page_id'] : null;
$form_title = isset($_GET['title']) ? $_GET['title'] : null;

// insert new page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get user data from form
    $form_title = $_POST['title'];
    $form_content = $_POST['content'];
    $form_user_id = $_POST['user_id'];

    // send to database
    $date_created = date('Y-m-d H:i:s');
    $pageId = $page->add_one($form_title, $form_content, $date_created, $form_user_id);
    echo "function add_one return: $pageId";

    try {
        if ($pageId > 0) {
            // if OK redirect to pages page
            header("location: pages.php");
        }
    } catch (PDOException $err) {
        echo "There was a problem: " . $err->getMessage();
    }

    // code for editing a page 
    $pageEdit = $page->edit_page($form_title, $form_content, $form_user_id);
    echo "function edit_page return: $pageEdit";
    // Kontrollera om uppdateringen lyckades
    if ($pageEdit) {
        header('Location: pages.php?action=update');
        exit;
    }
    print_r2($pageEdit);

}

// displaying pages and images retrieved from the database with the use of Class and Models
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $rows = $page->getAllPages();
    $rowPage = $page->getPageById($id);

    print_r2($rowPage);
    $isLoggedIn = isset($_SESSION["username"]);

    if ($isLoggedIn && $rowPage) {
        include "handleUpload.php";
    } else {
        // om inte, skriv ut ett annat meddelande
        echo "<p>Inloggning krävs för att ladda upp bilder</p>";
    }
    $pageImage = $imageModel->getImagesByPageId($page_id);

    print_r2($pageImage);
} else {
    // Handle the case when getImage was not successful
    return false;
}

// delete from db
// $result = $language->delete_one(10);
// echo "function delete_one return: $result";
// print_r2($rows);

// Kontrollera om användare är inloggad

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
    <aside class="asideBar">
        <nav>
            <ul>
                <?php
                // Controlling that the array is not empty 
                // displaying the title of the pages published to the public
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        $id = $row["id"];
                        $form_title = $row["title"];

                        echo '<div class= "aside">';
                        echo "<li><a href='pages.php?id=$id'>$form_title</a></li></div>";
                        '</div>';

                        // displaying the details of the page to the users who are signed in 
                        if ($rowPage && isset($_GET['id']) && $_GET['id'] == $id) {
                            echo '<div class="contentDiv"> ';
                            // echo '<h3>Text</h3>';
                            echo '<p>' . $row['content'] . '</p>';
                            // echo '<h4>Publicerad</h4>';
                            echo $row['date_created'];
                            echo '<hr>';
                            // echo '<h5>Användare</h5>';
                            echo $row['username'];

                            // Check if 'url' is an array and handle it appropriately
                            if (isset($row['url'])) {
                                // foreach ($row['url'] as $url) {
                                echo $url . '<br>';
                                // }
                            } else {
                                echo 'No URL available';
                            }
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                } else {
                    echo 'No pages found.';
                }

                ?>

            </ul>
        </nav>
    </aside>


    <?php

    // Creating a table for inserting the data in the database in the table ´page´
    if (isset($_SESSION['user_id']))
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="form1">


        <p>
            <label for="title"> <b> Titel </b></label>
            <hr>
            <input type="text" name="title" id="title" required minlength="2" maxlength="25">
            <hr>
            <label for="content"><b> Innehåll </b></label>
            <hr>
            <textarea name="content" id="content" cols="30" rows="10" required minlength="2" maxlength="255"></textarea>
            <hr>
            <!-- för att koppla en användare till tabellen används ett dolt fält med användarens id -->
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        </p>
        <p>
            <input type="submit" value="Spara" class="button">
            <br>
            <input type="reset" value="Nollställ" class="button1">
        </p>
        <p>
            <hr>
            <input type="submit" value="Uppdatera" name="pageEdit" class="button">
        </p>
    </form>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
        <input type="submit" value="Ta bort" name="delete" class="button1">
    </form>

</body>

</html>