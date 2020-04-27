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
    if ($_GET['error'] == 'titleInUse') {
      echo '<p>Der Titel wurde bereits vergeben, bitte geben Sie einen neuen ein</p>';
    }
    echo '</div>';
  }
?>
<h1>Neuen Fragebogen erstellen:</h1>

<form method="get" action="FragenErstellen.php">

    <p>Titel des Fragebogens</p>
    <input type="text" name="titel">

    </br>
    </br>


    <p>Anzahl Fragen</p>
    <input type="number" name="anzahlFragen">

    </br>
    </br>

    <input type="submit" name="submitAnzFragen" value="Bestätigen">


</form>


</body>
</html>