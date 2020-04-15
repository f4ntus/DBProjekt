<!DOCTYPE html>
<html>
                <h1>Hallo Gregory Peck!</h1>
        <form>
                <input type="submit" name="fb_neu" value=" + Neuen Fragebogen erstellen" />
        </form>

        <p>Übersicht Ihrer bereits erstellen Fragebögen:</p>
</html>








<?php
require 'PostController.php';
$postController = new PostController();
$db_erg = $postController->controllAnmeldung($_POST);
//$postController->controllAnmeldung($_POST);
if ( $db_erg == 'success'){
    echo "<p> Sie haben noch keinen Fragebogen erstellt. </p>"; 
} else {
    echo $db_erg;
}
$postController = NULL;
?>