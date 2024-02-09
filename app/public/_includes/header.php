<header>
    <span><?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?></span>
    <span><?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ""; ?></span>

    </header>

    <div class="headerDiv"> 
    <nav>
    <br>
        <a href="/">Start</a> |
        <br>
        <br>
        <a href="page.php"> Visa alla sidor </a>
        <br>
        <br>
        <a href="page_create.php"> Skapa</a>
        <br>
        <br>
        <a href="page_edit.php"> Redigera</a>
        <br>
        <br>
        <?php

    if (!isset($_SESSION['username'])) {
        echo '<a href="login.php">Logga in</a> <hr>';
        // echo '<br>';
        echo '<a href="register.php">Registrera</a>';
    } else {
         echo '<br>';
        echo '<a href="logout.php">Logga ut</a>';
    }
    ?>
</div>
    </nav>
    <hr>
