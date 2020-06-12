<?php

require_once 'AbstractSQLWrapper.php';
class TblBeantwortet extends AbstractSQLWrapper
{
    function selectUniqueRecord($fbnr,$fnr,$matrikelnummer)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $sql = "SELECT * FROM tbl_beantwortet where FbNr = '$fbnr' and FNr = '$fnr' and Matrikelnummer = '$matrikelnummer'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords($fbnr, $matrikelnummer)
    {
        $fbnr = $this->escapeString($fbnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $sql = "SELECT * FROM tbl_beantwortet where FbNr = '$fbnr' and matrikelnummer = '$matrikelnummer'";
        return $this->globalSelectRecords($sql);
    }
    function updateRecord($fbnr, $fnr, $matrikelnummer, $bewertung)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $bewertung = $this->escapeString($bewertung);
        $sql = "UPDATE tbl_beantwortet SET Bewertung = '$bewertung' where FbNr = '$fbnr' and FNr = '$fnr' and Matrikelnummer = '$matrikelnummer' ";
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($fbnr, $fnr, $matrikelnummer, $bewertung)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $bewertung = $this->escapeString($bewertung);
        if (!is_numeric($bewertung)) return false;
        $bewertung = (int) $bewertung;
        if ($bewertung < 1 || $bewertung > 5) return false;
        $sql = "INSERT INTO tbl_beantwortet (FNr, FbNr, Matrikelnummer, Bewertung) VALUES ('$fnr', '$fbnr', '$matrikelnummer', '$bewertung')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "DELETE FROM tbl_beantwortet WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
?>