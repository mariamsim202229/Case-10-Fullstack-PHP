<?php

session_start();

$title = "Applikation för att publicera sidor";

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/User.php";
include_once "_models/Page.php";

$userModel = new User();
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
    <main>
        <h1><?php echo $title; ?></h1>
    </main>
    <style>
        <?php include 'styles/styles.css'; ?>
    </style>

    <?php

    include "_includes/footer.php";
    ?>
</body>

</html>