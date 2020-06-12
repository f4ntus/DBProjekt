<?php
/**
 * @author Christoph Böhringer
 * Diese Klasse dient als Basis für die Oberfläche der Fragebogen-Bearbeiten Funktion.
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
        if ($_GET['error'] == 'gleicheFrage') {
            echo '<p>Die eingegebene Frage ist bereits im Fragebogen vorhanden</p>';
        }
        if ($_GET['error'] == 'leereFrage') {
            echo '<p>Eine Frage darf nicht leer sein, bitte füllen sie das Feld nochmals aus</p>';
        }

        echo '</div>';
    }

    if (isset($_GET['info'])) {
        echo '<div class="infoKasten">';
        if ($_GET['info'] == 'frage_geloescht') {
            echo '<p>Die ausgewählte Frage wurde erfolgreich gelöscht</p>';
        }
        if ($_GET['info'] == 'frage_hinzugefügt') {
            echo '<p>Die Frage wurde erfolgreich hinzugefügt</p>';
        }

        echo '</div>';
    }
    ?>


    <h1>Fragebogen bearbeiten:</h1>

    <?php
    if (!isset($_GET['fbnr'])) {
        echo "<div>";
    } else echo "<div hidden>";
    ?>

    <form method="post">
        <?php
        $dropdown = $befragerController->createDropdownFragebogen($_SESSION['befrager']);
        echo "<label>Welchen Fragebogen möchten Sie bearbeiten?</br></br><select name='Fragebogen'>" . $dropdown . "</select></label>";
        ?>
        </br></br>
        <button type="submit" name="bearbeiten">bearbeiten</button>

    </form>
    </div>


    <?php
    if (isset($_GET['fbnr'])) {
        $befragerController->pruefeBefrager($_GET['fbnr']);
        echo "<div>";
    ?>

        <form method="post">
            <p>Übersicht Ihrer Fragen:</p>
            <table>
                <tr>
                    <th>Frage</th>
                    <th>Fragetext</th>
                </tr>
                <?php
                $table = $befragerController->fragenAnzeigenBearbeiten($_GET['fbnr']);
                echo $table;
                ?>
            </table>
        </form>
        </br>

        <form method="post">
            <label for='neue_frage'>Frage hinzufügen:</label></br>
            <input type="text" name="neue_frage">
            <button type="submit" name="frage_hinzufügen">Frage hinzufügen</button>
        </form>
    <?php
    } else echo "<div hidden>";
    ?>

    </div>


    <?php
    if (isset($_POST['bearbeiten'])) {
        $befragerController->fragebogenBearbeiten($_POST['Fragebogen']);
    }
    if (isset($_POST['frage_loeschen'])) {
        $befragerController->einzelneFrageLoeschen($_POST['frage_loeschen'], $_GET['fbnr']);
    }
    if (isset($_POST['frage_hinzufügen'])) {
        $befragerController->einzelneFrageHinzufügen($_GET['fbnr'], $_POST['neue_frage']);
    }
    ?>

</body>

</html>