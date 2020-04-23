<!DOCTYPE html>

<html>

<?php
// wird noch bearbeitet, Funktion noch nicht gegeben;
require "PostController.php";
$postController = new PostController();
$fbnr = $postController->getFbNr($_POST['titel']);
var_dump($_POST);
// $postController->createFragen($fbnr, $_POST[$i], $_POST['fragetext']);
?>


</html>