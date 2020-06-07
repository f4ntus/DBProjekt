<?php

require_once 'AbstractSQLWrapper.php';
class TblFreigeschaltet extends AbstractSQLWrapper
{
    function selectUniqueRecord($kurs, $fbnr)
    {
        $sql ="SELECT * FROM tbl_freigeschaltet where Name='$kurs' and FbNr='$fbnr' ";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords($kurs)
    {
        $sql ="SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
        where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = '$kurs'";
        return $this->globalSelectRecords($sql);
    }
    
    function selectRecordsFreigeschaltet($recentUser) {

        $sql ="SELECT DISTINCT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet, tbl_befrager
        where tbl_befrager.Benutzername = tbl_fragebogen.Benutzername and tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_befrager.Benutzername = '$recentUser'";
        return $this->globalSelectRecords($sql);
    }

    function selectRecordsByFragebogenNr($fbnr)
    {
        $sql ="SELECT tbl_freigeschaltet.Name FROM tbl_freigeschaltet 
        where tbl_freigeschaltet.FbNr = '$fbnr'";
        return $this->globalSelectRecords($sql);
    }
    
    function updateRecord()
    {
        $sql = '';
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($fbnr,$kurs)
    {
        $sql = "INSERT INTO tbl_freigeschaltet (FbNr, Name) VALUES ('$fbnr', '$kurs')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fbnr)
    {
        $sql = "DELETE FROM tbl_freigeschaltet WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
?>