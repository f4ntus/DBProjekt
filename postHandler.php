<?php
require 'PostController.php';
$postController = new PostController();
$response = $postController->controllAnmeldung($_POST);
//$postController->controllAnmeldung($_POST);
if ( $response == 'success'){
    echo "<p> Du hast dich erfolgreich angemeldet </p>"; 
} else {
    echo $response;
}
$postController = NULL;
?>