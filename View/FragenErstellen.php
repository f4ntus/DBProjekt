<?php
session_start();
?>

<!DOCTYPE html>

<html lang="de">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>Befragungstool</title>
</head>

<body>

<!-- Platzhalter, hier werden potentzielle Fehler angezeigt -->
  <?php

  $titel = $_POST['titel'];
  $benutzername = $_SESSION['befrager'];
  echo "<h2>Titel des Fragebogens: $titel </h2>";
 
  ?>

  <h1>Neue Fragen erstellen:</h1>


  <form method="post" action="FreischaltungKurs.php">
    </br>

    Fragen: </br></br>
    <?php

  require '../Controller/BefragerController.php';
  $befragerController = new BefragerController();
  $fragebogen = $befragerController->controllTitelFragebogen($titel, $benutzername);
  echo $fragebogen;
  $fragefelder = $befragerController->createFrageFelder($_POST['anzahlFragen']);
  echo $fragefelder;
  $befragerController = NULL;

  ?>
    <button type="submit" name="fragenspeichern">Fragen Speichern</button>
  </form>


</body>

</html>