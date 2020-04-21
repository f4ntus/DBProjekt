<?php
session_start();
?>

<!DOCTYPE html>

<html>
<h1>Neuen Fragebogen erstellen:</h1>
</br>
Titel des Fragebogens: </br></br>

<form method="post" action="FreischaltungKurs.php">
  <input type="text" name="titel">
  </br></br>


  Fragen: </br></br>

  <?php
  require 'PostController.php';
  $postController = new PostController();
  $fragefelder = $postController->createFrageFelder($_POST['anzahlFragen']);
  echo $fragefelder;
  $postController = NULL;

  ?>
  
    <input type="submit" name="fragebogenspeichern" value="Speichern" />
</form>

<?php
  if (isset($_POST['fragebogenspeichern'])) {
    $postController = new PostController();
    $fragebogen = $postController->createFragebogen($_POST['titel'], $_SESSION['befrager'] ); 
    echo $fragebogen;
  }
?>

  </html>