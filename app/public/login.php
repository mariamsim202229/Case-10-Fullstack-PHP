<?php

// se till att sessioner används på sidan
session_start();

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";
include_once "_models/User.php";


setup_user($pdo);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get user data from form
    $form_username = $_POST['username'];
    $form_password = $_POST['password'];

    // send to database
    $sql_statement = "SELECT * FROM `user` WHERE `username` = '$form_username'";

    // try {
    $result = $pdo->query($sql_statement);
    $user = $result->fetch();

    // no user found with these credentials
    if (!$user) {
        header("location: login.php");
        exit();
    }

    $is_correct_password = password_verify($form_password, $user['password']);
    if ($is_correct_password) {
        header("location: page.php");
    } else {
        header("location: login.php");
        exit();
    }
    // när rätt lösenord är angivet är användaren känd
    // skapa sessionsvariabler som kan användas 
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];
}


?>

<html lang="en">

<head>
    <link rel="stylesheet" type="css" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <style>
        <?php include 'styles/styles.css'; ?>
    </style>
    <?php include "_includes/header.php"; ?>

    <h1>Login</h1>
    <form action="" method="post" class="form1">
        <label for="username">Username: </label>
        <br>
        <input type="text" name="username" id="username">
        <br>
        <br>
        <label for="password">Password: </label>
        <br>
        <input type="password" name="password" id="password">
        <br>
        <button type="submit">Login</button>
    </form>

   

    <?php
    include "_includes/footer.php";
    ?>
</body>

</html>