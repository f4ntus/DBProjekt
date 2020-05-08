<?php
session_start();
require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
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
if (isset($_GET['error'])) {
    echo '<div class="errorKasten">';
    if ($_GET['error'] == 'nameInUse') {
      echo '<p>Ihr Kurs ist bereits erstellt.</p>';
    }
    echo '</div>'; 
}
?>


<h1>Neuen Kurs anlegen:</h1>

<form method="post" action="neuerKurs.php">

    <p>Name des Kurses:</p>
    
    <input type="text" name="kursname">
    <input type="submit" name="neuerkurs" value="Anlegen">

</form> 

<?php
    if (isset($_POST['neuerkurs'])) {
      $befragerController->controllNameKurs();
    }
?>


</body>

</html>