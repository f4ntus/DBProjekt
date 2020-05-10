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
if (isset($_GET['error'])) {
  echo '<div class="errorKasten">';
  if ($_GET['error'] == 'sqlError') {
    echo "<p>Ups, da ist etwas schiefgelaufen, wurde der Kurs schon freigeschalten?</p>";
  }
  echo '</div>';
}
  ?>

  <h1>Kurs freischalten:</h1>

  <?php
  if (!isset($_GET['fb_auswaehlen'])) {
    echo "<div>";
  } else {
    echo "<div hidden>";
  }
  ?>
  <form method="post">
    <?php
    $dropdownFragebogen = $befragerController->createDropdownFragebogen($recentUser);
    echo "<label>Welchen Fragebogen möchten Sie freischalten?</br></br><select name='Fragebogen'>" . $dropdownFragebogen . "</select></label>";
    echo "</br></br>";

    $dropdownKurs = $befragerController->createDropdownKurs();
    echo "<label>Welchen Kurs möchten Sie freischalten?</br></br><select name='Kurs'>" . $dropdownKurs . "</select></label>";
    ?>

</br></br>
    <button type="submit" name="freischalten">Kurs freischalten</button>
  </form>
  </div>

  <?php
if (isset($_POST['freischalten'])){
  $result = $befragerController->freischaltenKurs($_POST['Fragebogen'], $_POST['Kurs']);
  echo $result;
}
  ?>



</body>


</html>