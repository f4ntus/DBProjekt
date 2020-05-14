<?php

require_once 'AbstractSQLWrapper.php';
class TblFrage extends AbstractSQLWrapper
{
    function selectUniqueRecord()
    {
        $sql = '';
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
    function insertRecord($fbnr, $fnr, $fragetext)
    {
        $sql = "INSERT INTO tbl_frage (FNr, FbNr, Fragetext) VALUES ('$fnr', '$fbnr', '$fragetext')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord()
    {
        $sql = '';
        return $this->globalDeleteRecord($sql);
    }
}
?>