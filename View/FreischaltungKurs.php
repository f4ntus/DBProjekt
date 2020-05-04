<?php
  session_start();
  require '../Controller/BefragerController.php';
  $befragerController = new BefragerController();
  $fbnr = $_GET['fbnr'];
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
if (isset($_GET['error'])) {
  echo '<div class="errorKasten">';
  if ($_GET['error'] == 'sqlError') {
    echo '<p>Etwas ist schiefgelaufen, wurde ihr Fragebogen schon freigeschalten?</p>';
  }
  echo '</div>';
}
if (isset($_GET['erstellt'])) {
    echo '<div class="infoKasten">';
    if ($_GET['erstellt'] == 'true') {
      echo '<p>Ihr Fragebogen wurde erfolgreich erstellt. Bitte wählen Sie den zu freischaltenen Kurs aus.</p>';
    }
    echo '</div>';
  }
?>

<h1>Kurs freischalten:</h1>

<form method="post" action="">
<!-- Checkboxen für die einzelnen Kurse über Controller aufrufen -->
<?php
$kursfelder = $befragerController->createKursFelder();
echo $kursfelder;
?>

<button type="submit" name="kurs_freischalten">Kurs freischalten</button>

</form>

<?php
if (isset($_POST['kurs_freischalten'])){
  $result = $befragerController->freischaltenKurs($fbnr,$_POST);
  echo $result;
}
?>

</body>


</html>