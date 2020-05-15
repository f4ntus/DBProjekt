<?php

require_once 'AbstractSQLWrapper.php';
class TblBeantwortet extends AbstractSQLWrapper
{
    function selectUniqueRecord()
    {
        $sql = '';
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords($fbnr, $matrikelnummer)
    {
        $sql = "SELECT * FROM tbl_beantwortet where FbNr = '$fbnr' and matrikelnummer = '$matrikelnummer'";
        return $this->globalSelectRecords($sql);
    }
    function updateRecord()
    {
        $sql = '';
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($fbnr, $fnr, $matrikelnummer, $bewertung)
    {
        if (!is_numeric($bewertung)) return false;
        $bewertung = (int) $bewertung;
        if ($bewertung < 1 || $bewertung > 5) return false;
        $sql = "INSERT INTO tbl_beantwortet (FNr, FbNr, Matrikelnummer, Bewertung) VALUES ('$fnr', '$fbnr', '$matrikelnummer', '$bewertung')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fbnr)
    {
        $sql = "DELETE FROM tbl_beantwortet WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
?>