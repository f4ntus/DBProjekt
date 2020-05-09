<?php
session_start();
require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
$recentUser = $_SESSION['befrager'];
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

  <!-- Platzhalter, hier werden potentzielle Fehler und Informationen angezeigt -->
  <?php

  ?>

  <h1>Kurs freischalten:</h1>

  <?php
  if (!isset($_POST['fb_auswaehlen'])) {
    echo "<div>";
  } else {
    echo "<div hidden>";
  }
  ?>
  <form method="post">
    <?php
    $dropdown = $befragerController->createDropdownFragebogen($recentUser);
    echo "<label>Welchen Fragebogen möchten Sie freischalten?</br></br><select name='Fragebogen'>" . $dropdown . "</select></label>";
    ?>
    <button type="submit" name="fb_auswaehlen">Auswählen</button>
  </form>
  </div>


  <?php
  if (isset($_POST['fb_auswaehlen'])) {
    $fragebogen = $_POST['Fragebogen'];
    $bereitsFreigeschalten = $befragerController->showBereitsFreigeschaltet($fragebogen);
    echo "<p>Bereits freigeschaltene Kurse für den Fragebogen: " . $fragebogen . "</p>";
    echo $bereitsFreigeschalten;
    echo "<form method='post'></br>";
    echo "<p> Bitte ankreuzen, welcher Kurs noch freigeschalten werden soll.</p></br>";
    $kursfelder = $befragerController->createKursFelder();
    echo $kursfelder;
    //Im zweiten Formular wird noch kein Fragebogentitel oder FbNr mitgegeben, weshalb freischaltenKurs Funktion fehlschlägt. Entweder in der URL mitgeben oder über Post.

    echo "<button type='submit' name='kurs_freischalten'>Kurs freischalten</button></form>";
  }

  if (isset($_POST['kurs_freischalten'])) {
    $result = $befragerController->freischaltenKurs($fragebogen, $_POST);
    echo $result;
  }
  ?>


</body>


</html>