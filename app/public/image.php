
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="handleUpload.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Ladda upp bild till sidan</legend>
            <label for="upload">Välj bild</label>
            <input type="file" name="upload" id="upload">
            <input type="hidden" name="page_id" value="<?= $id ?>">
            <input type="submit" value="Ladda upp">
        </fieldset>
    </form>
</body>
</html>