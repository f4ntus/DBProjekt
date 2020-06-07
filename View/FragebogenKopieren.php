<?php
require '../Controller/BefragerController.php';
$befragerController = new BefragerController();
session_start();
if (isset($_SESSION['befrager']) == false)
{
    header ('Location: http://localhost/DBProjekt/view/index.php');
    exit;
}
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
    include "navbar.php";
    if (isset($_GET['error'])) {
        echo '<div class="errorKasten">';
        if ($_GET['error'] == 'titleInUse') {
            echo '<p>Der Titel wurde bereits vergeben, bitte geben Sie einen neuen ein</p>';
        }
        if ($_GET['error'] == 'sqlError') {
            echo '<p>Ups da ist etwas schief gelaufen versuchen sie es nochmal oder wenden Sie sich an ihren Systemadmistrator</p>';
        }

        echo '</div>';
    }
    ?>


    <h1>Fragebogen kopieren:</h1>


    <form method="post">
        <?php
        $dropdown = $befragerController->createDropdownFragebogen($recentUser);
        echo "<label>Welchen Fragebogen möchten Sie kopieren?</br></br><select name='Fragebogen'>" . $dropdown . "</select></label>";
        ?>
        </br></br>
        <p>Neuer Fragebogentitel (Titel muss abweichen):</p>
        <input type="text" name="title_copy">
        </br></br>
        <button type="submit" name="kopieren">kopieren</button>

    </form>

    <?php
    if (isset($_POST['kopieren'])) {

        $result = $befragerController->fragebogenKopieren($recentUser, $_POST['Fragebogen'], $_POST['title_copy']);
        echo $result;
    }
    ?>

</body>

</html>