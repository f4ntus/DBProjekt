<!DOCTYPE html>

<html lang="de">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Befragungstool</title>
</head>

<body>

<?php
// wird noch bearbeitet, Funktion noch nicht gegeben;
require "PostController.php";
$postController = new PostController();
$fbnr = $postController->getFbNr($_POST['titel']);
var_dump($_POST);
// $postController->createFragen($fbnr, $_POST[$i], $_POST['fragetext']);
?>

</body>


</html>