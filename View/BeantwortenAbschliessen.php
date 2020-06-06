<!DOCTYPE html>
<?php
session_start();
require '../Controller/StudentController.php';
$studentController = new StudentController();
?>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Fragen</title>
</head>

<body>
<?php 
    if (isset($_GET['error'])) {
        echo '<div class="errorKasten">';
        if ($_GET['error'] == 'noKommentar') {
            echo '<p>Sie müssen einen Kommentar verfassen, bevor Sie ihn speichern wollen.</p>';
        }
        echo '</div>';
    }

    if (isset($_GET['info'])) {
        echo '<div class="infoKasten">';
        if ($_GET['info'] == 'gespeichert') {
            echo '<p>Der Kommentar wurde gespeichert</p>';
        }
        echo '</div>';
    }
?>
    <h1>Vielen Dank für das beantworten der Fragen</h1>
    <p> Wenn Sie möchten, können Sie noch einen Kommentar darlassen</p>
    <form method="post" action="">
        <textarea id="text" name="text" cols="35" rows="4"></textarea>
        </br>
        <button type="submit" name="action" value="back">Zurück zur letzten Frage</button>
        <button type="submit" name="action" value="speichern">Fragebogen kommentieren</button>
        <button type="submit" name="action" value="abschliessen">Fragebogen abschliessen</button>
        
    </form>
<?php
    if (isset($_POST['action'])){
        if ($_POST['action'] == 'speichern'){
            $studentController->fragebogenKommentieren($_GET['Fragebogen'],$_POST['text']);
        }
    }
    if (isset($_POST['action'])){
        if ($_POST['action'] == 'abschliessen'){
            $studentController->fragebogenAbschliessen($_GET['Fragebogen']);
        }
    }
    if (isset($_POST['action'])){
        if ($_POST['action'] == 'back'){
            $studentController->goToLastQuestion($_GET['Fragebogen']);
        }
    }
?>

</body>

</html>


