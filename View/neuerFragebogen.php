<?php
/**
 * @author Christoph Böhringer
 * Diese Klasse dient als Basis für die Oberfläche der neuer-Fragebogen Funktion.
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
    if ($_GET['error'] == 'titleInUse') {
      echo '<p>Der Titel wurde bereits vergeben, bitte geben Sie einen neuen ein</p>';
    }
    if ($_GET['error'] == 'sqlError') {
      echo '<p>Ups da ist etwas schief gelaufen versuchen sie es nochmal oder wenden Sie sich an ihren Systemadmistrator</p>';
    }
    if ($_GET['error'] == 'keineFragen') {
      echo '<p>Ihr Fragebogen muss mindestens eine Frage beinhalten. Bitte versuchen Sie es erneut</p>';
    }
    if ($_GET['error'] == 'leererTitel') {
      echo '<p>Bitte vergeben Sie einen Titel</p>';
    }

    echo '</div>';
  }
  ?>
  <h1>Neuen Fragebogen erstellen:</h1>

  <form method="post" action="neuerFragebogen.php">

    <label for='titel'>Titel des Fragebogens</label></br>
    <input type="text" name="titel">

    </br>
    </br>


    <label for='anzahlFragen'>Anzahl Fragen</label></br>
    <input type="number" name="anzahlFragen">

    </br>
    </br>

    <input type="submit" name="submitAnzFragen" value="Bestätigen">

    <?php
    if (isset($_POST['titel'])) {
      $befragerController->controllTitelFragebogen($_POST['titel'], $_SESSION['befrager'], $_POST['anzahlFragen']);
    }
    ?>

  </form>


</body>

</html>