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

$title = "";
$content = "";
$user_id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    if (isset($_POST['delete'])) {
        $pageDelete = $page->delete_one($id);
        header('Location: page.php');
    }
}

    if ($_SERVER["REQUEST_METHOD"] == "POST"  ) {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $content = isset($_GET['content']) ? $_GET['content'] : '';
    
        $user_id = $_SESSION['user_id'];
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : "";
        $content = isset($_POST['content']) ? trim($_POST['content']) : "";

    if (isset($_POST['update'])) {
        $pageUpdate = $page->edit_page($title, $content);
        header('Location: page.php?id= ' . $id . '');
    }

    print_r2($pageUpdate);
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

    <h1>Redigera en sida</h1>
    <?php


    // Creating a table for inserting the data in the database in the table ´page´
    // if (isset($_POST['update'])) { 
    
    if (isset($_SESSION['user_id'])) { 
    ?>
    <form action="page_edit.php" method="POST" class="form1">
        <p>
            <input type="text" name="title" id="title" value="<?= $title ?>" required minlength="2" maxlength="25">
            <hr>
            <textarea name="content" id="content"  value="<?= $content ?>" cols="30" rows="10" required minlength="2" maxlength="255"></textarea>
            <hr>
            <input type="hidden" name="id" id="id" value= "<?= $id ?>">
        </p>
        <div>
            <input type="submit" value="Uppdatera" name="update" class="button2">
        </div>
    </form>

    <?php
    }
    ?>
</body>

</html>