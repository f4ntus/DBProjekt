<?php
/** 
 * @author Lukas Schick
 * Neuen Student anlegen
*/

require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
session_start();
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
if (isset($_GET['error'])) {
    echo '<div class="errorKasten">';
    if ($_GET['error'] == 'matrikelnummerInUse') {
      echo '<p>Die Matrikelnummer ist bereits vorhanden.</p>';
    }
    if ($_GET['error'] == 'matrikelnummerNotNumeric') {
      echo '<p>Die Matrikelnummer darf nur Zahlen enthalten.</p>';
    }
    echo '</div>'; 
}
?>


<h1>Neuen Student anlegen:</h1>

<form method="post" action="neuerStudent.php">

    <p>Matrikelnummer des Studenten:</p>
    
    <input type="text" name="matrikelnummer" maxLength="7" minLength="7">


        <?php
        $dropdown = $befragerController->createDropdownKurs();
        echo "</br></br><label>Welchem Kurs möchten Sie den Student zuordnen?</br></br><select name='Kurs'>" . $dropdown . "</select></label>";
        ?>
        
        <button type="submit" name="anlegen">Student anlegen</button>

</form> 

<?php
    if (isset($_POST['anlegen'])) {
        $befragerController->controllMatrikelnummer();
    }
?>


</body>

</html>