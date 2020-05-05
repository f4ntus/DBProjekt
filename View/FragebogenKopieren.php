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

    <h1>Fragebogen kopieren:</h1>


    <form method="post">
        <?php
        $dropdown = $befragerController->createDropdownFragebogen($recentUser);
        echo "<label>Welchen Fragebogen möchten Sie kopieren?</br></br><select name='Fragbogen'>" . $dropdown . "</select></label>";
        ?>
        </br></br>
        <p>Neuer Fragebogentitel (Titel muss abweichen):</p>
        <input type="text" name="title_copy">
        </br></br>
        <button type="submit" name="kopieren">kopieren</button>

    </form>

<?php
/*if (isset($_POST['kopieren'])){
    $result = $befragerController->fragebogenKopieren($_POST['Fragebogen'],$_POST['kopieren']);
    echo $result;
}*/
?>

</body>

</html>