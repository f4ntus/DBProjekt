<?php
/**
 * @author Christoph Böhringer
 * Diese Klasse dient als Basis für die Oberfläche der Fragebogen-Löschen Funktion.
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
    //Hier werden potentielle Fehler und Infos aufgelistet.
    if (isset($_GET['error'])) {
        echo '<div class="errorKasten">';
        if ($_GET['error'] == 'sqlError') {
            echo '<p>Ups da ist etwas schief gelaufen versuchen sie es nochmal oder wenden Sie sich an ihren Systemadmistrator</p>';
        }
        echo '</div>';
    }
    ?>

    <h1>Fragebogen löschen:</h1>

    <form method="post">
        <?php
        $dropdown = $befragerController->createDropdownFragebogen($_SESSION['befrager']);
        echo "<label>Welchen Fragebogen möchten Sie löschen?</br></br><select name='Fragebogen'>" . $dropdown . "</select></label>";
        ?>

        <button type="submit" name="loeschen">löschen</button>

    </form>

    <?php
    if (isset($_POST['loeschen'])) {

        $result = $befragerController->fragebogenLoeschen($_POST['Fragebogen']);
        echo $result;
    }
    ?>
</body>


</html>