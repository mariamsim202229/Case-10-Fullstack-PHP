<header>
  

    <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>
    <?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "" ; ?>
</header>
<nav>
    <a href="/">Start</a> | 
    <a href="login.php">Logga in</a> | 
    <a href="logout.php">Logga ut</a> | 
    <a href="register.php">Registrera</a> | 
    <a href="pages.php"> All pages </a>
</nav>
<hr>