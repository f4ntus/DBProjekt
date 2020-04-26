<!DOCTYPE html>

<html>

<?php
// wird noch bearbeitet, Funktion noch nicht gegeben;
require "../Controller/BefragerController.php";
$befragerController = new BefragerController();
$fbnr = $befragerController->getFbNr($_POST['titel']);
var_dump($_POST);
// $postController->createFragen($fbnr, $_POST[$i], $_POST['fragetext']);
?>


</html>