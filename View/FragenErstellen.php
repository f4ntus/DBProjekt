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
  require '../Controller/BefragerController.php';
  $befragerController = new BefragerController();
  $fragefelder = $befragerController->createFrageFelder($_POST['anzahlFragen']);
  echo $fragefelder;
  $fragebogen = $befragerController->createFragebogen($titel, $benutzername); 
  echo $fragebogen;
  $befragerController = NULL;

  ?>
  
    <button type="submit" name="fragenspeichern">Fragen Speichern</button>
</form>

  </html>