<?php

/**
 * @author Christoph Böhringer
 * Diese Page dient als Basis für die Oberfläche der Freischalten-Kurs Funktion.
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
	if (isset($_GET['error'])) {
		echo '<div class="errorKasten">';
		if ($_GET['error'] == 'sqlError') {
			echo "<p>Ups, da ist etwas schiefgelaufen, wurde der Kurs schon freigeschalten?</p>";
		}
		echo '</div>';
	}

	if (isset($_GET['info'])) {
		echo '<div class="infoKasten">';
		if ($_GET['info'] == 'freigeschalten') {
			echo "<p>Ihr Fragebogen wurde für den ausgewählten Kurs erfolgreich freigeschalten.</p>";
		}
		echo '</div>';
	}
	?>


	<h1>Kurs freischalten:</h1>

	<?php
	if (!isset($_GET['fb_auswaehlen'])) {
		echo "<div>";
	} else {
		echo "<div hidden>";
	}
	?>
	<form method="post">
		<?php
		$dropdownFragebogen = $befragerController->createDropdownFragebogen($_SESSION['befrager']);
		echo "<label>Welchen Fragebogen möchten Sie freischalten?</br></br><select name='Fragebogen'>" . $dropdownFragebogen . "</select></label>";
		echo "</br></br>";

		$dropdownKurs = $befragerController->createDropdownKurs();
		echo "<label>Welchen Kurs möchten Sie freischalten?</br></br><select name='Kurs'>" . $dropdownKurs . "</select></label>";
		?>

		</br></br>
		<button type="submit" name="liste_bereits_freigeschaltet">Liste bereits freigeschaltet</button>
		</br></br>
		<button type="submit" name="freischalten">Kurs freischalten</button>
	</form>
	</div>

	<?php
	if (isset($_POST['freischalten'])) {
		$result = $befragerController->freischaltenKurs($_POST['Fragebogen'], $_POST['Kurs']);
		echo $result;
	}
	if (isset($_POST['liste_bereits_freigeschaltet'])) {
		$result = $befragerController->showBereitsFreigeschaltet($_POST['Fragebogen']);
		echo $result;
	}
	?>



</body>


</html>