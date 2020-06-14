<?php
require_once 'AbstractSQLWrapper.php';
class TblBefrager extends AbstractSQLWrapper {
    
    /**
     * @author Johannes Scheffold
     * Liefert einzelnen Datensatz der Tabelle Befrager
     * @param $benutzername (Befrager)
     * @return object
     */
    function selectUniqueRecord($benutzername = ''){
        $benutzername = $this->escapeString($benutzername);
        $sql = "SELECT * FROM tbl_befrager WHERE Benutzername = '$benutzername'";
        return $this->globalSelectUniqueRecord($sql);
    }


    /**
     * @author Johannes Scheffold
     * fügt einlzelne Datensätze in die Tabelle Befrager ein
     * @param $benutername (Befrager)
     * @param $kennwort
     * @return string 
     */
    function insertRecord($benutzername,$kennwort){
        $benutzername = $this->escapeString($benutzername);
        // Kennwort wird nicht escaped da breits verschlüsselt
        $sql = "INSERT INTO tbl_befrager (Benutzername, Kennwort) VALUES ('$benutzername', '$kennwort')";
        return $this->globalInsertRecord($sql);
      
    }

}

?>