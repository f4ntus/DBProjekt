<?php
session_start();
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
                if ($_GET['info'] == 'freigeschalten') {
                        echo '<p>Ihr Fragebogen wurde für die ausgewählten Kurse erfolgreich freigeschalten.</p>';
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
        <form action="FreischaltungFragebogen.php">
                <button type="submit" name="freischalten">Kurs freischalten</button>
        </form>

        <p>Übersicht Ihrer bereits erstellen Fragebögen:</p>

        <?php

        require '../Controller/BefragerController.php';
        $befragerController = new BefragerController();
        $response = $befragerController->createInnerTableBefrager($recentUser);

        if ($response == '') {
                echo '<p>Sie haben noch keinen Fragebogen erstellt.</p>';
        } else {
                echo "<table> <tr> <th>FbNr</th> <th>Titel</th> </tr>" . $response . "</table>";
        }
        ?>

</body>

</html>