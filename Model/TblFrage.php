<?php

require_once 'AbstractSQLWrapper.php';
class TblFrage extends AbstractSQLWrapper
{
    function selectUniqueRecord($fbnr, $fnr)
    {
        $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr' and fnr ='$fnr'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords($fbnr,$filter='')
    {
        if ($filter == ''){
            $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr'";
        } else {
            $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr' AND $filter";
        } 
        return $this->globalSelectRecords($sql);
    }
    function updateRecord($fbnr, $fnr, $fragetext)
    {
        $sql = "UPDATE tbl_frage SET FNr = '$fnr' WHERE FbNr = '$fbnr' AND Fragetext = '$fragetext'";
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($fbnr, $fnr, $fragetext)
    {
        $sql = "INSERT INTO tbl_frage (FNr, FbNr, Fragetext) VALUES ('$fnr', '$fbnr', '$fragetext')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fnr, $fbnr)
    {
        $sql = "DELETE FROM tbl_frage WHERE FbNr = '$fbnr' AND FNr = '$fnr'";
        return $this->globalDeleteRecord($sql);
    }

    function maxRecord($fbnr)
    {
        $sql = "SELECT max(FNr) AS maxFnr FROM tbl_frage WHERE FbNr = '$fbnr'";
        return $this->globalSelectUniqueRecord($sql);
    }
}
?>