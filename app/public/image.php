
<?php
$isLoggedIn = isset($_SESSION["username"]);
$pageImage = $imageModel->getImagesByPageId($page_id);
print_r2($pageImage) ;
if ($isLoggedIn && $rowPage) {
    include "handleUpload.php";
} else {
    // om inte, skriv ut ett annat meddelande
    echo "<p>Inloggning krävs för att ladda upp bilder</p>";
}

?>