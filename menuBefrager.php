<!DOCTYPE html>
<html>
                <h1>Hallo $benutzername</h1>
        <form action ="neuerFragebogen.php">
                <input type="submit" name="fb_neu" value=" + Neuen Fragebogen erstellen" />
        </form>

        <p>Übersicht Ihrer bereits erstellen Fragebögen:</p>
        <table>
                <tr>
                        <th>FragebogenNr</th>
                        <th>Fragebogentitel</th>
                </tr>
        </table>


<?php
require 'PostController.php';
$postController = new PostController();
$response = $postController->anzeigenFrageboegen();
    echo $response;
$postController = NULL;
?>

<form action ="Auswertung.php">
</br> <input type="submit" name="auswertung" value="Auswertung erstellen" />
</form>

</html>