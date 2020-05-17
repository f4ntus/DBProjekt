<?php

require_once 'AbstractSQLWrapper.php';
class TblAbschliessen extends AbstractSQLWrapper
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
    function insertRecord()
    {
        $sql = '';
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fbnr)
    {
        $sql = "DELETE FROM tbl_abschliessen WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
?>