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
$user_id = $_SESSION['user_id'];
$date_created = date('Y-m-d H:i:s');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
// Preparing variables used in the form 
        $user_id = $_SESSION['user_id'];
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : "";
        $content = isset($_POST['content']) ? trim($_POST['content']) : "";

        //använda class Page och metoden add_one för att lägga till nya sidor
        $pageId = $page->add_one($title, $content, $user_id);
        echo "function add_one return: $pageId";
        if ($pageId) {
            header('Location: page.php');
            exit;
        }
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

    <h1>Skapa en ny sida </h1>
    <?php
    // Creating a table for inserting the data in the database in the table ´page´
    if (isset($_SESSION['user_id']))
    ?>
    <form action="page_create.php" method="POST" class="form1">
        <p>
            <input type="text" name="title" id="title" placeholder="titel" required minlength="2" maxlength="25">
            <hr>
            <textarea name="content" id="content" cols="30" rows="10" placeholder="Innehåll" required minlength="2"
                maxlength="255"></textarea>
            <hr>
            <input type="hidden" name="id" id="id">
        </p>
        <div>
            <input type="submit" value="Spara" class="button">
            <input type="reset" value="Nollställ" class="button1">
        </div>

    </form>
</body>

</html>
</body>

</html>