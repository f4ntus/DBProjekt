<?php
require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
session_start();
$recentUser = $_SESSION['befrager'];
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
        if ($_GET['error'] == 'sqlError') {
            echo '<p>Ups da ist etwas schief gelaufen versuchen sie es nochmal oder wenden Sie sich an ihren Systemadmistrator</p>';
        }

        echo '</div>';
    }

    if (isset($_GET['info'])) {
        echo '<div class="infoKasten">';
        if ($_GET['info'] == 'erfolgreich') {
            echo '<p>Die ausgewählten Fragen wurden erfolgreich gelöscht</p>';
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
        $dropdown = $befragerController->createDropdownFragebogen($recentUser);
        echo "<label>Welchen Fragebogen möchten Sie bearbeiten?</br></br><select name='Fragebogen'>" . $dropdown . "</select></label>";
        ?>
        </br></br>
        <button type="submit" name="bearbeiten">bearbeiten</button>

    </form>
    </div>

    <form method="post">
    <?php
    if (isset($_GET['fbnr'])) {
        echo "<div>";
        $fragen = $befragerController->fragenAnzeigenBearbeiten($_GET['fbnr']);
        echo $fragen;
    } else echo "<div hidden>";
    ?>
    <button type="submit" name="fragen_loeschen">Fragen löschen</button>
    </form>
</div>


    <?php
    if (isset($_POST['bearbeiten'])) {
        $befragerController->fragebogenBearbeiten($_POST['Fragebogen']);
    }
    if (isset($_POST['fragen_loeschen'])) {
        $befragerController->einzelneFragenLoeschen($_POST);
    }
    ?>

</body>

</html>