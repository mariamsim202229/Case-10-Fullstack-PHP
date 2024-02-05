<?php

session_start();

$title = "About PHP";

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/Page.php";

$pageModel = new Page();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="css" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $title; ?>
    </title>
</head>

<body>

    <?php
    include "_includes/header.php";
    ?>

    <?php
    include "_includes/error-message.php";
    ?>

    <style>
        <?php include 'styles/styles.css'; ?>
    </style>

    <?php
    $isLoggedIn = isset($_SESSION["username"]);

    include "_includes/footer.php";
    ?>
</body>

</html>