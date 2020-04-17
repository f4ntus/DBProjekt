<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Befragungstool</title>
</head>

<body>
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
        <form method="post" action="index.php">
            <h1>Login</h1>
            <!-- Für Befrager Benutzername -->
            <?php
            if (isset($_GET['befrager'])) { 
                echo 'Benutzername:
                <input type="text" name="benutzername">';
            }
            ?>
            <!-- Für Student Matrikelnummer -->
            <?php
            if (isset($_GET['student'])) { 
                echo 'Matrikelnummer:
                <input type="text" name="matrikelnummer">';
            }
            ?>
            </br>
            </br>
            Passwort:
            <input type="password" name="kennwort" required>
            </br>
            </br>
            <input type="submit" name="anmelden" value="Anmelden" />
            <input type="submit" name="registrieren" value="Registrieren" />
            </br>
            </br>
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