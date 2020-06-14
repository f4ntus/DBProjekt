<?php
/** 
 * @author Christoph Böhringer
 * Diese Klasse beinhaltet alle SQL-Aufrufe innerhalb der Tabelle Frage.
 */
require_once 'AbstractSQLWrapper.php';
class TblFrage extends AbstractSQLWrapper
{
    /**
     * @author Christoph Böhringer
     * Liefert einzelnen Datensatz der Tabelle Frage
     * @param $fbnr (Fragebogennummer)
     * @param $fnr (Fragenummer)
     * 
     * @return object
     */
    function selectUniqueRecord($fbnr, $fnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr' and fnr ='$fnr'";
        return $this->globalSelectUniqueRecord($sql);
    }

    /**
     * @author Christoph Böhringer
     * Liefert mehrere Datensätze der Tabelle Frage
     * @param $fbnr (Fragebogennummer)
     * @param $largerThanFNr (Fragenummer für die Bedingung Größer) 
     * 
     * @return list
     */
    function selectRecords($fbnr, $largerThanFNr = '')
    {
        $fbnr = $this->escapeString($fbnr);
        $largerThanFNr = $this->escapeString($largerThanFNr);

        if ($largerThanFNr == '') {
            $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr'";
        } else {
            $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr' AND FNr > $largerThanFNr";
        }
        return $this->globalSelectRecords($sql);
    }

    /**
     * @author Christoph Böhringer
     * aktualisiert Datensatz der Tabelle Frage (für das Sortieren der Funktion einzelne Fragen löschen)
     * @param $fbnr (Fragebogennummer)
     * @param $fnr (Fragenummer)
     * @param $fragetext (Fragetext) 
     * 
     * @return string
     */
    function updateRecord($fbnr, $fnr, $fragetext)
    {

        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $fragetext = $this->escapeString($fragetext);
        $sql = "UPDATE tbl_frage SET FNr = '$fnr' WHERE FbNr = '$fbnr' AND Fragetext = '$fragetext'";
        return $this->globalUpdateRecord($sql);
    }

    /**
     * @author Christoph Böhringer
     * fügt einen Datensatz in die Tabelle Frage
     * @param $fbnr (Fragebogennummer)
     * @param $fnr (Fragenummer)
     * @param $fragetext (Fragetext) 
     * 
     * @return string
     */
    function insertRecord($fbnr, $fnr, $fragetext)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $fragetext = $this->escapeString($fragetext);
        $sql = "INSERT INTO tbl_frage (FNr, FbNr, Fragetext) VALUES ('$fnr', '$fbnr', '$fragetext')";
        return $this->globalInsertRecord($sql);
    }

    /**
     * @author Christoph Böhringer
     * löscht einen Datensatz in der Tabelle Frage
     * @param $fbnr (Fragebogennummer)
     * @param $fnr (Fragenummer)
     * 
     * @return string
     */
    function deleteRecord($fnr, $fbnr)
    {
        $fnr = $this->escapeString($fnr);
        $fbnr = $this->escapeString($fbnr);
        $sql = "DELETE FROM tbl_frage WHERE FbNr = '$fbnr' AND FNr = '$fnr'";
        return $this->globalDeleteRecord($sql);
    }

    /**
     * @author Christoph Böhringer
     * Liefert einzelnen Datensatz der Tabelle Frage mit Aggregatsfunktion MAX
     * @param $fbnr (Fragebogennummer)
     * 
     * @return object
     */
    function maxRecord($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "SELECT max(FNr) AS maxFnr FROM tbl_frage WHERE FbNr = '$fbnr'";
        return $this->globalSelectUniqueRecord($sql);
    }
}
