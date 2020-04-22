<!DOCTYPE html>

<html>
<?php
require "PostController.php";
$postController = new PostController();
$fbnr = $postController->getFbNr($_POST['titel']);
var_dump($_POST);
// $postController->createFragen($fbnr, $_POST[$i], $_POST['fragetext']);
?>


</html>