<!DOCTYPE html>
<html> 
<head>
        <title>MenüStudent</title>
</head>
<body>
    <h1>Hallo 2596940</h1>
        <form method="post" action="MenuStudent.php">
        <input type="submit" name="anzeigen" value="Anzeigen" />
        </form>

</body>
</html>







<?php

require 'SqlWrapper.php';
$sqlWrapper = new SqlWrapper();
$dbergebnis = $sqlWrapper->select();
echo $dbergebnis;

?>






