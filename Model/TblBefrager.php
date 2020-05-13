<?php
class TblBefrager extends AbstractSQLWrapper {
    
    function selectUniqueRecord($benutzername){
        $sql = "SELECT * FROM tbl_befrager WHERE Benutzername = '$benutzername'";
       return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords(){

    }
    function updateRecord(){

    }
    function insertRecord($benutzername,$kennwort){
        $sql = "INSERT INTO tbl_befrager (Benutzername, Kennwort) VALUES ('$benutzername', '$kennwort')";
        return $this->globalInsertRecord($sql);
      
    }
    function deleteRecord(){

    }

}

?>