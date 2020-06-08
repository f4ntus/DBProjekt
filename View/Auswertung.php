
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
<?php    
if (isset($_GET['error'])) {
        echo '<div class="errorKasten">';
        
        if ($_GET['error'] == 'noValues') {
            echo '<p>Der ausgewählte Fragebogen wurde noch von keinem Studenten abgeschlossen</p>';
        }

        echo '</div>';
    }
?>

<?php
if( !((isset($_GET['fbnr'])) && (isset($_POST['Kurs']))) ){
    echo "<div>";
    
?>

<form method="post" action="Auswertung.php">
    <?php
    $dropdown = $befragerController->createDropdownFreigeschaltet($recentUser);
    echo "<label>Welchen Fragebogen möchten Sie auswerten?</br></br><select name='FragebogenFreigeschaltet'>" . $dropdown . "</select></label>";

    ?>
    </br></br>
    <button type="submit" name="auswählen">auswählen</button>

</form></br>


<?php 
if (isset($_GET['fbnr'])) {
?>
    
    <form method="post">
    <?php
    $dropdown = $befragerController->selectKurseZuFragebogen($_GET['fbnr']);
    echo "<label>Über welchen Kurs möchten Sie auswerten?</br></br><select name='Kurs'>" . $dropdown . "</select></label>";
    echo "<button type='submit' name='auswerten'>auswerten</button>";
   ?>
    </form>
    </br>
    
<?php } 

} else echo "<div hidden>";?>
</div>


<?php

if (isset($_POST['Kurs']))  { 
    echo "<div>"
?>

    <p>Auswertung:</p>
    <table cellpadding="6">
        <tr>
            <th>Frage</th>
            <th>Fragetext</th>
            <th>Durchschnitt</th>
            <th>Maximal</th>
            <th>Minimal</th>
            <th>Standardabweichung</th>
        </tr>
        <?php
        $table = $befragerController->auswertungAnzeigen($_GET['fbnr'], $_POST['Kurs']);
        echo $table;
        ?>
    </table>
</br>

    <p><b>Kommentare:</b></p>
    <?php
    $string = $befragerController->kommentareAnzeigen($_GET['fbnr'], $_POST['Kurs']);
    echo $string;
    ?>

<?php
    } else echo "<div hidden>";
?>

    </div>



<?php
if (isset($_POST['auswählen'])) {
    $befragerController->fragebogenAuswählen($_POST['FragebogenFreigeschaltet']);
}
if (isset($_POST['auswerten'])) {
    $befragerController->auswertungAnzeigen($_GET['fbnr'], $_POST['Kurs']);    
}

?>


</body>


</html>

