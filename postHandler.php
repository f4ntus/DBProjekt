<?php
require 'PostController.php';
$postController = new PostController();
$response = $postController->controllAnmeldung($_POST);
//$postController->controllAnmeldung($_POST);

// if Anmeldung -> Anmeldung Prüfen -> Link zum Hauptmenü
// if Registrierung -> Registrierung Prüfen -> Link zum Hauptmenü

if ( $response == 'success'){
    echo "<p> Du hast dich erfolgreich angemeldet </p>"; 
} else {
    echo $response;
}
$postController = NULL;
?>