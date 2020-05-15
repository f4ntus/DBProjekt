<?php

require_once 'AbstractSQLWrapper.php';
class TblKurs extends AbstractSQLWrapper
{
    function selectUniqueRecord($name)
    {
        $sql = "SELECT Name FROM tbl_kurs WHERE Name = '$name'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords()
    {
        $sql = "SELECT * FROM tbl_kurs";
        return $this->globalSelectRecords($sql);
    }
    function updateRecord()
    {
        $sql = '';
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($name)
    {
        $sql = "INSERT INTO tbl_kurs (Name) VALUES ('$name')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord()
    {
        $sql = '';
        return $this->globalDeleteRecord($sql);
    }
}
?>