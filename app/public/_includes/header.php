<header>
    <span><?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?></span>

    </header>

    <nav>
        <a href="/">Start</a> |
        <a href="pages.php"> Alla sidor </a>
        <?php

    if (!isset($_SESSION['username'])) {
        echo '<a href="login.php">Logga in</a> <hr>';
        echo '<a href="register.php">Registrera</a>';
    } else {
        echo '<a href="logout.php">Logga ut</a>';
    }

    ?>

    </nav>
    <hr>
