<!DOCTYPE html>
<html> 
<head>
        <title>Matrikelnummer</title>
</head>
<body>

<form method="POST" action="">    
        
Matrikelnummer:
        <input type="text" name="matrikelnummer">
        <input type="submit" name="absenden" value="absenden">
</form>
</br>

</body>

</html>


<?php
require 'SqlWrapper.php';
$sqlWrapper = new SqlWrapper();
$sqlWrapper->__construct();

if(isset($_POST['absenden'])){
$Matrikelnummer = $_POST["matrikelnummer"]; 
$sqlWrapper->student($Matrikelnummer);
}


/*if(isset($_POST["absenden"])) {
    $test = $sqlWrapper->student($Matrikelnummer);
    echo $test;
}
*/

    
    /*$q = "SELECT * FROM tbl_student, tbl_kurs where tbl_student.Matrikelnummer = '$Matrikelnummer'";

    echo $q;
    */


    /*if ($this->db->query($q)) {
        echo $q;
    } else {
        return "Fehler";
        
    }
    */




?>