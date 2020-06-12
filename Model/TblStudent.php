<?php

require_once 'AbstractSQLWrapper.php';
class TblStudent extends AbstractSQLWrapper
{
    function selectUniqueRecord($matrikelnummer)
    {
        $matrikelnummer = $this->escapeString($matrikelnummer);
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
    function insertRecord($matrikelnummer,$name)
    {
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $name = $this->escapeString($name);
        $sql = "INSERT INTO tbl_student (Matrikelnummer, Name) VALUES ('$matrikelnummer', '$name')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord()
    {
        $sql = '';
        return $this->globalDeleteRecord($sql);
    }
}
?>