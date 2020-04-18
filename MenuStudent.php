<!DOCTYPE html>
<html> 
<head>
        <title>MenüStudent</title>
</head>
<body>
<h1>Hallo 2596940</h1>
<form method="POST" action="">    
        
    <select name="Auswahl">
        <option value="WWI118">WWI118</option>
        <option value="WWI218">WWI218</option>
        <option value="WWI318">WWI318</option>
    </select> </br>

    <input type="submit" name="anzeigen" value="anzeigen" />
</form>

</body>
</html>







<?php


require 'SqlWrapper.php';
$sqlWrapper = new SqlWrapper();

/*$dbergebnis = $sqlWrapper->select118();
echo $dbergebnis;
*/

/*if(isset($_POST["anzeigen"])) {
        echo $sqlWrapper->select118();
       
    }

*/


/*if (isset($_POST["anzeigen"])){
    if ($_POST["Auswahl"]=="WWI118"){
               echo $sqlWrapper->select118();
       
    }
*/

    
    if (isset($_POST["anzeigen"])){
         if ($_POST['Auswahl']=="WWI118"){
            echo $sqlWrapper->select118();
        }
        if ($_POST['Auswahl']=="WWI218"){
            echo $sqlWrapper->select218();
         }
        if ($_POST['Auswahl']=="WWI318"){
            echo $sqlWrapper->select318();
         }
    }
    
/*   
    
    
    
    if (isset($_POST["anzeigen"])){
        if ($_POST["Auswahl"]=="WWI218"){
                   echo $sqlWrapper->select218();
           
        }
        if (isset($_POST["anzeigen"])){
            if ($_POST["Auswahl"]=="WWI318"){
                       echo $sqlWrapper->select318();
               
            }
        }
   } 
}

*/



?>






