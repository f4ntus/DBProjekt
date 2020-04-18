<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Befragungstool</title>
</head>

<body>

    <!-- Platzhalter, hier werden potentzielle Fehler angezeigt -->
    <?php 
        if (isset($_GET['error'])) {
            echo '<div class="errorKasten">';
            if ($_GET['error'] == 'StudentNotFound'){
                echo '<p>Die Matrikelnummer ist nicht im System vorhanden, 
                bitte überprüfen Sie Ihre Eingabe oder wenden sich and den Administrator </p>';
            }
            if ($_GET['error'] == 'BefragerNotFound'){
                echo '<p>Der Benutzername wurde nicht gefunden</p>';
            }
            if ($_GET['error'] == 'wrongPassword'){
                echo '<p>Das Passwort ist falsch, geben Sie das Passwort erneut ein</p>';
            } 
            echo '</div>';
        }
    ?>
    
    <h1> Herzlich willkommen im Befragungstool der DHBW </h1>
    <!-- Abfrage ob Student oder Befrager -->
    <?php
    // Formular wird nur angezeigt, wenn weder befrager noch student ausgewählt ist
    if (!((isset($_GET['befrager']))||(isset($_GET['student'])))){
        echo '<div>';
    } else {
        echo '<div hidden>';
    }
    ?>
        <h2> Bitte wähle aus ob du ein Student oder ein Befrager bist </h2>
        <form methode="get" action="index.php">
            <input type="submit" name="befrager" value="Befrager" />
            <input type="submit" name="student" value="Student" />
        </form>'
    </div>
    
    <!-- Formular für Anmeldung oder Registrieren -->
    
    <?php
    // Formular wird nur angezeigt, wenn Befrager oder Student ausgewählt ist
    if (((isset($_GET['befrager']))||(isset($_GET['student'])))){
        echo '<div>';
    } else {
        echo '<div hidden>';
    } ?>
        <form id="login" method="post" action="index.php">
            <label form="login" class="lableHeadline">Login</label>
            </br>
            
            <!-- Für den Student wird nur die Matrikelnummer angezeigt -->
            <?php
            if (isset($_GET['student'])) { 
                echo '<label for="matirkelnummer">Matrikelnummer</label></br>
                <input type="text" name="matrikelnummer" id="matirkelnummer"> </br>';
                echo '<div hidden>';
            } else {
                echo '<div>';
            } ?>
            
            <!-- Für den Befrager wird Benutzername und Passwort angezeigt -->
            <label for="benutzername">Benutzername:</label> </br>
            <input type="text" name="benutzername" id="benutzername"> </br>

            <label for="passwort">Passwort</label> </br>
            <input type="password" name="password" id="password"> </br>
            <input type="submit" name="registrieren" value="Registrieren" /> 
        </div>
        <input type="submit" name="anmelden" value="Anmelden" />
        </form>
    </div>
    <?php
    if (isset($_POST['anmelden'])) {
        require 'PostController.php';
        $postController = new PostController();
        $response = $postController->controllAnmeldung($_POST);

        if ($response == 'success') {
            // weiterleitung zum Hauptmenü
            echo "<p> Du hast dich erfolgreich angemeldet </p>";
        } else {
            echo $response;
        }
        $postController = NULL;
    }
    ?>

</body>

</html>