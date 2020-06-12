<?php

require_once 'AbstractSQLWrapper.php';
class TblKommentiert extends AbstractSQLWrapper
{
    function selectUniqueRecord($fbnr,$matrikelnummer)
    {
        $fbnr = $this->escapeString($fbnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $sql = "SELECT * FROM tbl_kommentiert where FbNr='$fbnr' and Matrikelnummer='$matrikelnummer'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords()
    {
        $sql = '';
        return $this->globalSelectRecords($sql);
    }
    function updateRecord($fbnr,$matrikelnummer,$kommentar)
    {
        $fbnr = $this->escapeString($fbnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $kommentar = $this->escapeString($kommentar);
        $sql = "UPDATE tbl_kommentiert SET Kommentar = '$kommentar' WHERE FbNr = '$fbnr' AND Matrikelnummer = '$matrikelnummer'";
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($fbnr,$matrikelnummer,$kommentar)
    {
        $fbnr = $this->escapeString($fbnr);
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $kommentar = $this->escapeString($kommentar);
        $sql = "INSERT INTO tbl_kommentiert(FbNr, Matrikelnummer, Kommentar) VALUES ('$fbnr','$matrikelnummer','$kommentar')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "DELETE FROM tbl_kommentiert WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
?>