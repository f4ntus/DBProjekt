
<?php
session_start();

require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
include "navbar.php";
$recentUser = $_SESSION['befrager'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Auswertung</title>
</head>

<body>


<form method="post" action="Auswertung.php">

<?php
$dropdown = $befragerController->createDropdownFreigeschaltet($recentUser);
echo "<label>Welchen Fragebogen möchten Sie auswerten?</br></br><select name='FragebogenFreigeschaltet'>" . $dropdown . "</select></label>";

?>
</br></br>
<button type="submit" name="auswählen">auswählen</button>

</form></br>

<?php

if (isset($_POST['auswählen'])) {
    $befragerController->fragebogenAuswählen($_POST['FragebogenFreigeschaltet']);
}
   
if (isset($_GET['fbnr'])) { 
    
    $dropdown = $befragerController->selectKurseZuFragebogen($_GET['fbnr']);
    echo "<label>Über welchen Kurs möchten Sie auswerten?</br></br><select name='Kurs'>" . $dropdown . "</select></label>";
    echo "<button type='submit' name='auswerten'>auswerten</button>";
}

?>

<?php
if (isset($_POST['auswerten'])){
    $befragerController->fragebogenAuswerten($fbnr, $_POST['Kurs']);
}


?>

</body>


</html>

