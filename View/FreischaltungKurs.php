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
require "../Controller/BefragerController.php";
$befragerController = new BefragerController();
if (isset($_GET['erstellt'])) {
    echo '<div class="infoKasten">';
    if ($_GET['erstellt'] == 'true') {
      echo '<p>Ihr Fragebogen wurde erfolgreich erstellt. Bitte wählen Sie den zu freischaltenen Kurs aus.</p>';
    }
    echo '</div>';
  }
?>

<h1>Kurs freischalten:</h1>

<form>
<!-- Checkboxen für die einzelnen Kurse über Controller aufrufen -->
<?php
$kursfelder = $befragerController->createKursFelder();
echo $kursfelder;
?>
</form>


<?php
// wird noch bearbeitet, Funktion noch nicht gegeben;


//$fbnr = $befragerController->getFbNr($_POST['titel']);
//var_dump($_POST);
// $postController->createFragen($fbnr, $_POST[$i], $_POST['fragetext']);
?>

</body>


</html>