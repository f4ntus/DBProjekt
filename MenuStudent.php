<!DOCTYPE html>
<html> 
<head>
        <title>MenüStudent</title>
</head>
<body>
    <h1>Hallo 2596940</h1>
        <form method="POST" action="">    
        <input type="submit" name="anzeigen" value="anzeigen" />
        </form> </br>

</body>
</html>







<?php


require 'SqlWrapper.php';
$sqlWrapper = new SqlWrapper();

/*$dbergebnis = $sqlWrapper->select();
echo $dbergebnis;
*/
if(isset($_POST["anzeigen"])) {
        echo $sqlWrapper->select();
       
    }


?>






