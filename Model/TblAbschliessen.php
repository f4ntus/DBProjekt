<?php

require_once 'AbstractSQLWrapper.php';
class TblAbschliessen extends AbstractSQLWrapper
{
    function selectUniqueRecord($matrikelnummer,$fbnr)
    {
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $fbnr = $this->escapeString($fbnr);
        $sql = "SELECT * FROM tbl_abschliessen where Matrikelnummer='$matrikelnummer' and FbNr='$fbnr' ";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords()
    {
        $sql = '';
        return $this->globalSelectRecords($sql);
    }
    function updateRecord()
    {
        $sql = '';
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($matrikelnummer,$fbnr)
    {
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $fbnr = $this->escapeString($fbnr);
        $sql = "INSERT INTO tbl_abschliessen (Matrikelnummer,FbNr) VALUES ('$matrikelnummer','$fbnr')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "DELETE FROM tbl_abschliessen WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
?>