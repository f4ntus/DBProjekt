<?php
session_start();
?>

<!DOCTYPE html>


<html>

<?php

$recentUser = $_SESSION['befrager'];
echo "<h1>Willkommen zurück, $recentUser!</h1>";
echo "<h2>Was möchten Sie tun?</h2>"
?>

<h1></h1>
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


</html>