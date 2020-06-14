<?php

require_once 'AbstractSQLWrapper.php';
class TblKommentiert extends AbstractSQLWrapper
{
    /**
     * @author Johannes Scheffold
     * Liefert einzelnen Datensatz der Tabelle kommentiert
     * @param $fbnr (Fragebogennummer)
     * @param $matrikelnummer 
     * 
     * @return object
     */
    function selectUniqueRecord($fbnr,$matrikelnummer)
    {
        $fbnr = $this->escapeString($fbnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $sql = "SELECT * FROM tbl_kommentiert where FbNr='$fbnr' and Matrikelnummer='$matrikelnummer'";
        return $this->globalSelectUniqueRecord($sql);
    }


    /**
     * @author Johannes Scheffold
     * aktualisiert Datensatz der Tabelle Kommentiert
     * @param $fbnr (Fragebogennummer)
     * @param $matrikelnummer 
     * @param $kommentar
     * 
     * @return string
     */
    function updateRecord($fbnr,$matrikelnummer,$kommentar)
    {
        $fbnr = $this->escapeString($fbnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $kommentar = $this->escapeString($kommentar);
        $sql = "UPDATE tbl_kommentiert SET Kommentar = '$kommentar' WHERE FbNr = '$fbnr' AND Matrikelnummer = '$matrikelnummer'";
        return $this->globalUpdateRecord($sql);
    }

     /**
     * @author Johannes Scheffold
     * fügt einen Datensatz in die Tabelle Kommentiert
     * @param $fbnr (Fragebogennummer)
     * @param $matrikelnummer 
     * @param $kommentar
     * 
     * @return string
     */
    function insertRecord($fbnr,$matrikelnummer,$kommentar)
    {
        $fbnr = $this->escapeString($fbnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $kommentar = $this->escapeString($kommentar);
        $sql = "INSERT INTO tbl_kommentiert(FbNr, Matrikelnummer, Kommentar) VALUES ('$fbnr','$matrikelnummer','$kommentar')";
        return $this->globalInsertRecord($sql);
    }
}
?>