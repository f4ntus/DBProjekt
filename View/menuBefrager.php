<?php

/**
 * @author Christoph Böhringer
 * Diese Page dient als Basis für die Oberfläche des Hauptmenüs des Befragers. 
 */
session_start();
require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
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
        if (isset($_GET['info'])) {
                echo '<div class="infoKasten">';
                switch ($_GET['info']) {

                        case 'kopiert':
                                echo '<p>Ihr Fragebogen wurde erfolgreich kopiert.</p>';
                                break;

                        case 'erstellt':
                                echo '<p>Ihr Kurs wurde erfolgreich angelegt.</p>';
                                break;

                        case 'geloescht':
                                echo '<p>Ihr Fragebogen wurde vollständig gelöscht.</p>';
                                break;
                        case 'fb_erstellt':
                                echo '<p>Ihr Fragebogen wurde erfolgreich erstellt.</p>';
                                break;
                        case 'kursErstellt':
                                echo '<p>Ihr Kurs wurde erfolgreich angelegt.</p>';
                                break;
                        case 'studentErstellt':
                                echo '<p>Student wurde erfolgreich angelegt.</p>';
                                break;
                }
                echo '</div>';
        }

        if (isset($_GET['error'])) {
                echo '<div class="errorKasten">';
                if ($_GET['error'] == 'andererBefrager') {
                        echo '<p>Sie haben keinen Zugriff auf den Fragebogen.</p>';
                }
                echo '</div>';
        }

        echo "<h1>Willkommen zurück, " . $_SESSION['befrager'] . "!</h1>";
        echo "<h2>Was möchten Sie tun?</h2>"
        ?>

        <p>Optionen Fragebogen:</p>
        <a href="neuerFragebogen.php"><button>+ Neuen Fragebogen erstellen</button></a>
        <a href="FragebogenBearbeiten.php"><button>Fragebogen bearbeiten</button></a>
        <a href="FragebogenKopieren.php"><button>Fragebogen kopieren</button></a>
        <a href="FragebogenLoeschen.php"><button>Fragebogen löschen</button></a>
        <a href="FreischaltungKurs.php"><button>Kurs freischalten</button></a>
        <p>Anlegen:</p>
        <a href="neuerKurs.php"><button>Neuen Kurs anlegen</button></a>
        <a href="neuerStudent.php"><button>Neuen Student anlegen</button></a>
        <p>Ergebnisse:</p>
        <a href="Auswertung.php"><button>Auswertung</button></a>

        <p>Übersicht Ihrer bereits erstellen Fragebögen:</p>

        <?php
        $uebersicht = $befragerController->createInnerTableBefrager($_SESSION['befrager']);
        if ($uebersicht == '') {
                echo '<p>Sie haben noch keinen Fragebogen erstellt.</p>';
        } else {
                echo "<table> <tr> <th>FbNr</th> <th>Titel</th> </tr>" . $uebersicht . "</table>";
        }
        ?>


</body>

</html>