<?php

// se till att sessioner används på sidan
session_start();

require_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/User.php";


$userModel = new User();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>

    <?php
    include "_includes/header.php";
    ?>

    <h1>Register</h1>
    <form action="" method="post">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password: </label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Register</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $userId = $userModel->register($_POST['username'], $_POST['password']);
            if ($userId > 0) {
                // if OK redirect to login page
                header("location: login.php");
            }
        } catch (PDOException $err) {
            echo "There was a problem: " . $err->getMessage();
        }
    }

    ?>


    <?php
    include "_includes/footer.php";
    ?>

</body>

</html>