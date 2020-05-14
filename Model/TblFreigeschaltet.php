<?php

require_once 'AbstractSQLWrapper.php';
class TblFreigeschaltet extends AbstractSQLWrapper
{
    function selectUniqueRecord($kurs)
    {
        $sql ="SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
        where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = '$kurs'";
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