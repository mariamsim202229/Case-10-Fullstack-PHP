<?php

session_start();

if (!isset($_SESSION['username'])) {
    die("Register and login...<a href='/'>Start</a>");
}

include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_includes/global-functions.php";

$database = new Database();
$language = new Page();

$rows = $language->get_all("language", "ASC");


// insert new language
$result = $language->add_one("gotländska", 1, 3);
echo "function add_one return: $result";


// delete from db
// $result = $language->delete_one(10);
// echo "function delete_one return: $result";

print_r2($rows);

?>