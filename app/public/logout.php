<?php

session_start();
include "_includes/header.php";
// logga ut användare genom att använda session destroy
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga ut</title>
</head>
<body>

<style>
        <?php include 'styles/styles.css'; ?>
    </style>
    
    Du är nu utloggad - tillbaka till <a href="login.php">Login</a>;

</body>
</html>