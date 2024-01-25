<?php
    // kan kommunicera med databasen m.h.a $pdo
    include_once("_includes/database-connection.php");

    try {
        // Kontrollera om php scriptet körs på grund av en HTTP POST request
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<p> I should handle the post request now</p>";

            // Få tag på användarens input
            // var_dump($_POST);
            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            // fråga databasen om användarnamnet är upptaget
            // Vi behöver alltså skriva en sql query
            $stmt = $pdo->prepare("SELECT (username) FROM Users WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            $row = $stmt->fetch();

            // Namnet är ledigt
            if ($row == false) {
                // Lägga in användaren till databasen
                $stmt = $pdo->prepare("INSERT INTO Users (username, password) VALUES (:username, :password)");
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":password", $password);
                $stmt->execute();

                echo "<p>User record has been created</p>";
                echo "<p>You can now <a href='login.php'>login</a></p>";

            }
        }
    } catch (PDOException $e) {
        echo "Error" . $e->getMessage();
    }
?>

<h1>Sign Up</h1>
<form action="signup.php" method="post">
    username: <input type="text" name="username" placeholder="Your new username"/>
    password: <input type="password" name="password" placeholder="Your new password"/>
    <button type="submit">Sign up</button>
</form>