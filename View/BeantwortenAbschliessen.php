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
    <h1>Vielen Dank für das beantworten der Fragen</h1>
    <p> Wenn Sie möchten, können Sie noch einen Kommentar darlassen</p>
    <form methode="post" action="">
        <textarea id="text" name="text" cols="35" rows="4"></textarea>
        </br>
        <button type="submit" name="action" value="speichern">Fragebogen kommentieren</button>
        <button type="submit" name="action" value="abschliessen">Kommentar speichern und Fragebogen abschließen</button>
    </form>
    
</body>

</html>


