<?php
// declare(strict_types=1);
session_start();

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include "_includes/header.php";

$database = new Database();
$page = new Page();
$user = new User();

$user_id = $_SESSION['user_id'];
$id = isset($_GET['id']) ? $_GET['id'] : null;
$form_title = isset($_GET['title']) ? $_GET['title'] : null;

// Förbereder variabler som kommer att användas i formuläret

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

    $pageEdit = $page->edit_page($form_title, $form_content, $form_user_id);
    echo "function edit_page return: $pageEdit";
    // Kontrollera om uppdateringen lyckades
    if ($pageEdit) {
        header('Location: pages.php?action=update');
        exit;
    }
    print_r2($pageEdit);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $link = "pages.php?id=:id";
    $rowPage = $page->getPageById($id);
    print_r2($rowPage);
    $rows = $page->getAllPages();
}


echo "<a href= \"$link\"  target=\"_blank\">$form_title</a><br>";

// delete from db
// $result = $language->delete_one(10);
// echo "function delete_one return: $result";

// print_r2($rows);
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
    <?php

    // Skapa en tabell för att visa/redigera resultatet
    if (isset($_SESSION['user_id'])) {
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="form1">

            <p>

                <label for="title"> <b> PAGE TITLE </b></label>
                <hr>
                <input type="text" name="title" id="title" required minlength="2" maxlength="25">
                <hr>
                <label for="content"><b> CONTENT </b></label>
                <hr>
                <textarea name="content" id="content" cols="30" rows="10" required minlength="2" maxlength="50"></textarea>
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
        </form>

        <aside>
            <h2>Menu</h2>
            <nav>
                <ul>
                    <?php
                    if (!empty($rows)) {
                        foreach ($rows as $row) {
                            $id = $row["id"];
                            $form_title = $row["title"];
                            echo "<li><a href='pages.php?id=$id'>$form_title</a></li>";
                            // Kontrollera om arrayen inte är tom
                            echo '<div>';
                            echo '<h3>Content</h3>';
                            echo '<p>' . $row['content'] . '</p>';
                            echo '<h4>Date created</h4>';
                            echo '<p>' . $row['date_created'] . '</p>';
                            echo '<h5>Username</h5>';
                            echo '<p>' . $row['username'] . '</p>';
                            echo '</tr>';
                        }
                        echo '</div>';
                    } else {
                        echo 'No pages found.';
                    }
    } else {
        echo "0 results";
    }

    ?>
            </ul>
        </nav>
    </aside>


</body>

</html>