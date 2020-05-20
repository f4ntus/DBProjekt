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
  if (isset($_GET['error'])) {
    echo '<div class="errorKasten">';
    if ($_GET['error'] == 'leereFrage') {
      echo '<p>Sie können keine leere Frage speichern, bitte füllen Sie die Felder aus.</p>';
    }
    if ($_GET['error'] == 'gleicheFrage') {
      echo '<p>Sie können keine gleichen Fragen speichern, bitte füllen Sie die Felder erneut aus.</p>';
    }
    if ($_GET['error'] == 'sqlError') {
      echo '<p>Ups da ist etwas schief gelaufen versuchen sie es nochmal oder wenden Sie sich an ihren Systemadmistrator.</p>';
    }
    echo '</div>';
  }

  ?>

  <h1>Neue Fragen erstellen:</h1>

  <?php
  echo "<h2>Fragebogentitel: " . $title . "</h2>";
  ?>

  <form method="post">
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
    echo $befragerController->createFragen($fbnr, $anzFragen, $_POST, $_GET['Titel']);
  }
  ?>

</body>

</html>