<!DOCTYPE html>
<html> 
<head>
        <title>Matrikelnummer</title>
</head>
<body>

<form method="POST" action="postHandler.php">    
        
Matrikelnummer:
        <input type="text" name="EingabeMatr">
        <input type="submit" name="absenden" value="absenden">
</form>
</br>

</body>

</html>


<?php






    
    
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