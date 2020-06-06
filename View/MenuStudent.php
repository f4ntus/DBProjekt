	<?php
    session_start();
    require '../Controller/StudentController.php';
    $studentController = new StudentController();
    ?>
	<!DOCTYPE html>
	<html>

	<head>
	    <meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	    <link rel="stylesheet" href="style.css" />
	    <title>MenuStudent</title>
	</head>

	<body>
	    <?php
        if (isset($_GET['error'])) {
            echo '<div class="errorKasten">';
            if ($_GET['error'] == 'notFreigegeben') {
                echo '<p>Der Fragebogen ist nicht für Sie freigegeben, bitte wenden Sie sich an den Systemadminstrator</p>';
            }
            echo '</div>';
        } 
        
        if (isset($_GET['info'])) {
            echo '<div class="infoKasten">';
            if ($_GET['info'] == 'abgeschlossen') {
                echo '<p>Vielen Dank! Sie haben die Befragung abgeschlossen, Sie können diesen Fragebogen nun nicht mehr ausfüllen oder verändern </p>';
            }
            echo '</div>';
        }
        
        ?>

	    <h1><?php echo "Hallo" . " " . $_SESSION['matrikelnummer']; ?></h1>

	    <p>Diese Fragebögen sind für Sie freigeschaltet:</p>
	    <form method="POST" action="">
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
	    <?php
        if (isset($_POST['Fragebogen'])) {
            $studentController->navigateToFirstNotAnswerdQuestion($_POST['Fragebogen']);
        }
        ?>
	</body>

	</html>
    