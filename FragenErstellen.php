<?php
session_start();
?>

<!DOCTYPE html>

<html>
<h1>Neue Fragen erstellen:</h1>
<?php

$titel = $_POST['titel'];
$benutzername = $_SESSION['befrager'];
echo "<h2>Titel des Fragebogens: $titel </h2>";
?> 

<form method="post" action="FreischaltungKurs.php">
  </br>

  Fragen: </br></br>

  <?php
  require 'PostController.php';
  $postController = new PostController();
  $fragefelder = $postController->createFrageFelder($_POST['anzahlFragen']);
  echo $fragefelder;
  $fragebogen = $postController->createFragebogen($titel, $benutzername); 
  echo $fragebogen;
  $postController = NULL;

  ?>
  
    <button type="submit" name="fragenspeichern">Fragen Speichern</button>
</form>

<?php
?>

  </html>