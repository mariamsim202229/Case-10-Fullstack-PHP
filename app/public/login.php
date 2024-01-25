<?php 

    // se till att sessioner används på sidan
    session_start();
        
    include_once("_includes/database-connection.php");
    include_once("_includes/global-functions.php");
    include_once("_models/User.php");

    $userModel = new User();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <?php

    include "_includes/header.php";

    ?>

    <h1>Login</h1>

    <?php 
        include "_includes/error-message.php";
    ?>
    <form action="" method="post">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username">

        <label for="password">Password: </label>
        <input type="password" name="password" id="password">
        
        <button type="submit">Login</button>
    </form>

    <?php 
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $result = $userModel->authenticate($_POST["username"], $_POST["password"]);
            
            // no user found with these credentials
            if ($result == -1) {
                header("location: login.php");
                $_SESSION["error_message"] = "no user found with these credentials";
                exit();
            }

            // user found but incorrect password
            if ($result == -2) {
                header("location: login.php");
                $_SESSION["error_message"] = "Incorrect password";
                exit();
            }


            // när rätt lösenord är angivet är användaren känd
            // skapa sessionsvariabler som kan användas 
            // TODO: fixa username och user_id
            $_SESSION['username'] = $result['username'];
            $_SESSION['user_id'] = $result['user_id'];


            // redirect to start page
            header("location: index.php");
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