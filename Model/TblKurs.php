<?php

require_once 'AbstractSQLWrapper.php';
class TblKurs extends AbstractSQLWrapper
{
    function selectUniqueRecord($name)
    {
        $name = $this->escapeString($name);
        $sql = "SELECT Name FROM tbl_kurs WHERE Name = '$name'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords()
    {
        $sql = "SELECT * FROM tbl_kurs";
        return $this->globalSelectRecords($sql);
    }
    function insertRecord($name)
    {
        $name = $this->escapeString($name);
        $sql = "INSERT INTO tbl_kurs (Name) VALUES ('$name')";
        return $this->globalInsertRecord($sql);
    }
}
?>