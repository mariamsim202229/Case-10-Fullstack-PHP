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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
</head>

<body>

    <?php
        include "_includes/header.php";
    ?>

    <?php
        include "_includes/error-message.php";
    ?>
    
    <?php
    $isLoggedIn = isset($_SESSION["username"]);
    if ($isLoggedIn) {

        echo "<h2>Your files</h2>";
        $pages_from_user = $pageModel->getPagesByUserId($_SESSION["user_id"]);

        var_dump($pages_from_user);

        // Kontrollera om användare är inloggad
        include "_includes/upload-form.php";
    } else {
        // om inte, skriv ut ett annat meddelande
        echo "<p>You need to login in order to upload files</p>";
    }
    ?>

    <?php
    include "_includes/footer.php";
    ?>
</body>

</html>