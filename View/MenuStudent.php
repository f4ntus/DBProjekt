<!DOCTYPE html>
<html>

<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />
        <title>MenuStudent</title>
</head>

<body>
        height:

</body>

</html>


<?php
session_start();
require '../Controller/StudentController.php';
$studentController = new StudentController();
?>

<h1><?php echo "Hallo" . " " . $_SESSION['matrikelnummer']; ?></h1>

<p>Diese Fragebögen sind für Sie freigeschaltet:</p>
<form method="GET" action="Fragen.php">   
        <table border='8' cellpadding='20'>
                <tr>
                        <th>FragebogenNr</th>
                        <th>Titel</th>
                </tr>

                <?php
                echo $studentController->createInnerTable();
                ?>
        </table>
</form>