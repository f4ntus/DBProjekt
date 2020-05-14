<?php

require_once 'AbstractSQLWrapper.php';
class TblStudent extends AbstractSQLWrapper
{
    function selectUniqueRecord($matrikelnummer)
    {
        $sql = "SELECT * FROM tbl_student WHERE Matrikelnummer = '$matrikelnummer'";
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
    function deleteRecord()
    {
        $sql = '';
        return $this->globalDeleteRecord($sql);
    }
}
?>