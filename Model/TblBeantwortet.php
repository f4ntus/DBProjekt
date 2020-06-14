<?php

require_once 'AbstractSQLWrapper.php';
class TblBeantwortet extends AbstractSQLWrapper
{
    /**
     * @author Johannes Scheffold
     * Liefert einzelnen Datensatz der Tabelle Beantwortet
     * @param $fbnr (Fragebogennummer)
     * @param $fnr (Fragenummer)
     * @param $matrikelnummer 
     * 
     * @return object
     */
    function selectUniqueRecord($fbnr,$fnr,$matrikelnummer)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $sql = "SELECT * FROM tbl_beantwortet where FbNr = '$fbnr' and FNr = '$fnr' and Matrikelnummer = '$matrikelnummer'";
        return $this->globalSelectUniqueRecord($sql);
    }
    
    /**
     * @author Johannes Scheffold
     * Liefert mehrere Datensätze der Tabelle Beantwortet
     * @param $fbnr (Fragebogennummer)
     * @param $matrikelnummer 
     * 
     * @return list
     */
    function selectRecords($fbnr, $matrikelnummer)
    {
        $fbnr = $this->escapeString($fbnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $sql = "SELECT * FROM tbl_beantwortet where FbNr = '$fbnr' and matrikelnummer = '$matrikelnummer'";
        return $this->globalSelectRecords($sql);
    }

    /**
     * @author Johannes Scheffold
     * aktualisiert Datensatz der Tabelle Beantwortet
     * @param $fbnr (Fragebogennummer)
     * @param $fnr (Fragenummer)
     * @param $matrikelnummer 
     * @param $bewertung 
     * 
     * @return string
     */
    function updateRecord($fbnr, $fnr, $matrikelnummer, $bewertung)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $bewertung = $this->escapeString($bewertung);
        $sql = "UPDATE tbl_beantwortet SET Bewertung = '$bewertung' where FbNr = '$fbnr' and FNr = '$fnr' and Matrikelnummer = '$matrikelnummer' ";
        return $this->globalUpdateRecord($sql);
    }

    /**
     * @author Johannes Scheffold
     * fügt einen Datensatz in die Tabelle Beantwortet
     * @param $fbnr (Fragebogennummer)
     * @param $fnr (Fragenummer)
     * @param $matrikelnummer 
     * @param $bewertung 
     * 
     * @return string
     */
    function insertRecord($fbnr, $fnr, $matrikelnummer, $bewertung)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $bewertung = $this->escapeString($bewertung);
        $sql = "INSERT INTO tbl_beantwortet (FNr, FbNr, Matrikelnummer, Bewertung) VALUES ('$fnr', '$fbnr', '$matrikelnummer', '$bewertung')";
        return $this->globalInsertRecord($sql);
    }
}
?>