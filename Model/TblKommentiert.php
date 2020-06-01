<?php

require_once 'AbstractSQLWrapper.php';
class TblKommentiert extends AbstractSQLWrapper
{
    function selectUniqueRecord($fbnr,$matrikelnummer)
    {
        $sql = "SELECT * FROM tbl_kommentiert where $fbnr='$fbnr' and $matrikelnummer='$matrikelnummer'";
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
    function insertRecord($fbnr,$matrikelnummer,$kommentar)
    {
        $sql = "INSERT INTO tbl_kommentiert ('FbNr','Matrikelnummer',Kommentar') VALUES ('$fbnr','$matrikelnummer','$kommentar')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fbnr)
    {
        $sql = "DELETE FROM tbl_kommentiert WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
?>