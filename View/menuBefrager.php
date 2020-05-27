<?php
session_start();
if (isset($_SESSION['befrager']) == false)
{
    header ('Location: http://localhost/DBProjekt/view/index.php');
    exit;
}
require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
include "navbar.php";
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
                }
                echo '</div>';
        }

        if (isset($_GET['info'])) {
                echo '<div class="infoKasten">';
                if ($_GET['info'] == 'studentErstellt') {
                        echo '<p>Student wurde erfolgreich angelegt.</p>';
                }
                echo '</div>';
        }

        $recentUser = $_SESSION['befrager'];
        echo "<h1>Willkommen zurück, $recentUser!</h1>";
        echo "<h2>Was möchten Sie tun?</h2>"
        ?>

        <form method="post" action="neuerFragebogen.php">
                <button type="submit" name="fb_neu">+ Neuen Fragebogen erstellen</button>
        </form>
        </br>
        <form mehthod="post" action="FreischaltungKurs.php">
                <button type="submit" name="fb_freischalten">Kurs freischalten</button>
        </form>
        </br>
        <form method="post" action="FragebogenBearbeiten.php">
                <button type="submit" name="fb_bearbeiten">Fragebogen bearbeiten</button>
        </form>
        </br>
        <form method="post" action="FragebogenKopieren.php">
                <button type="submit" name="fb_kopieren">Fragebogen kopieren</button>
        </form>
        </br>
        <form method="post" action="FragebogenLoeschen.php">
                <button type="submit" name="fb_löschen">Fragebogen löschen</button>
        </form>
        </br>
        <form method="post" action="neuerKurs.php">
                <button type="submit" name="kursanlegen">Neuen Kurs anlegen</button>
        </form>
        </br>
        <form method="post" action="neuerStudent.php">
                <button type="submit" name="studentanlegen">Neuen Student anlegen</button>
        </form>



        <p>Übersicht Ihrer bereits erstellen Fragebögen:</p>

        <?php
        $response = $befragerController->createInnerTableBefrager($recentUser);
        if ($response == '') {
                echo '<p>Sie haben noch keinen Fragebogen erstellt.</p>';
        } else {
                echo "<table> <tr> <th>FbNr</th> <th>Titel</th> </tr>" . $response . "</table>";
        }
        ?>


</body>

</html>