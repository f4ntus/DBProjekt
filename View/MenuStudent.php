<!DOCTYPE html>
<html>

<head>
        <title>Matrikelnummer</title>
</head>

<body>


</body>

</html>


<?php
session_start();
require '../Controller/StudentController.php';
$studentController = new StudentController();
?>

<h1><?php echo "Hallo" . " " . $_SESSION['matrikelnummer']; ?></h1>

<p>Diese Fragebögen sind für Sie freigeschaltet:</p>
<table border='8' cellpadding='20'>
        <tr>
                <th>FragebogenNr</th>
                <th>Titel</th>
        </tr>

        <?php
        echo $studentController->createInnerTable();
        ?>

</table>

<?php

if (isset($_POST['anzeigenFragen'])) {
        header("Location: http://localhost/DBProjekt/Fragen.php/");
} 
?>