<!DOCTYPE html>
<html>
                <h1>Hallo Gregory Peck!</h1>
        <form action ="neuerFragebogen.php">
                <input type="submit" name="fb_neu" value=" + Neuen Fragebogen erstellen" />
        </form>

        <p>Übersicht Ihrer bereits erstellen Fragebögen:</p>
</html>








<?php
require 'PostController.php';
$postController = new PostController();
$response = $postController->anzeigenFrageboegen();
    echo $response;
$postController = NULL;
?>