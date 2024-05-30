
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

$id = 0;
$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete'])) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $imageDelete = $imageModel->delete_image($id);

    if ($imageDelete) {

        header('Location: page.php');
        exit;
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
    <h1></h1>

    <form action="image_edit.php" method="POST" class="form1">
        <input type="text" name="id" value=<? $id ?>>
        <input type="submit" value="Ta bort" name="delete" class="button1">';

</body>

</html> 