<?php
require_once 'AbstractSQLWrapper.php';
class TblBefrager extends AbstractSQLWrapper {
    
    function selectUniqueRecord($benutzername = ''){
        $benutzername = $this->escapeString($benutzername);
        $sql = "SELECT * FROM tbl_befrager WHERE Benutzername = '$benutzername'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function insertRecord($benutzername,$kennwort){
        $benutzername = $this->escapeString($benutzername);
        // Kennwort wird nicht escaped da breits verschlüsselt
        $sql = "INSERT INTO tbl_befrager (Benutzername, Kennwort) VALUES ('$benutzername', '$kennwort')";
        return $this->globalInsertRecord($sql);
      
    }

}

?>