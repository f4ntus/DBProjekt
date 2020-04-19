<!DOCTYPE html>


<h1>Neuen Fragebogen erstellen:</h1>
        </br>
        Titel des Fragebogens: </br></br>
        <input type="text" name="titel">
        </br></br>
        
        Fragen: </br></br>

<?php
require 'PostController.php';
$postController = new PostController();
$anzFragen = $postController->getAnzahlFragen($_POST);
$postController->createFrageFelder($anzFragen);
$postController = NULL;

?>
<form method="post" action="FreischaltungKurs.php">
  <input type="submit" name="speichern" value="Speichern" />
</form>

</html>

