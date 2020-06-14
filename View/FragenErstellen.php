<?php
/**
 * @author Christoph Böhringer
 * Diese Page dient als Basis für die Oberfläche der Fragen-Erstellen Funktion.
 */
session_start();
require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
$befragerController->pruefeBefrager();
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

  <?php
  include "navbar.php";
  //Hier werden potentielle Fehler und Infos aufgelistet.
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
  echo "<h2>Fragebogentitel: " . $_GET['Titel'] . "</h2>";
?>

  <form method="post">
    </br>

    Fragen: </br></br>
    <?php
    $fragefelder = $befragerController->createFrageFelder($_GET['AnzahlFragen']);
    echo $fragefelder;
    ?>
    <button type="submit" name="fragenspeichern">Fragen Speichern</button>
  </form>
  <?php
  if (isset($_POST['fragenspeichern'])) {
    echo $befragerController->createFragen($_GET['Fbnr'], $_GET['AnzahlFragen'], $_POST, $_GET['Titel']);
  }
  ?>

</body>

</html>