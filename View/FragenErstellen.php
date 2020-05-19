<?php
session_start();
require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
$fbnr = $_GET['Fbnr'];
$anzFragen = $_GET['AnzahlFragen'];
$title = $_GET['Titel']
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

  ?>

  <h1>Neue Fragen erstellen:</h1>

  <?php
  echo "<h2>Fragebogentitel: " . $title . "</h2>";
?>

  <form method="post" action="">
    </br>

    Fragen: </br></br>
    <?php
    $fragefelder = $befragerController->createFrageFelder($anzFragen);
    echo $fragefelder;
    ?>
    <button type="submit" name="fragenspeichern">Fragen Speichern</button>
  </form>
  <?php
  if (isset($_POST['fragenspeichern'])) {
    echo $befragerController->createFragen($fbnr, $anzFragen, $_POST);
    // movetofreiben mit nummer und erfolgsmeldung
  }
  ?>

</body>

</html>