<?php

require_once 'AbstractSQLWrapper.php';
class TblFrage extends AbstractSQLWrapper
{
    function selectUniqueRecord($fbnr, $fnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr' and fnr ='$fnr'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords($fbnr, $filter='')
    {
        $fbnr = $this->escapeString($fbnr);
        $filter = $this->escapeString($filter);

        if ($filter == ''){
            $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr'";
        } else {
            $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr' AND $filter";
        } 
        return $this->globalSelectRecords($sql);
    }
    function updateRecord($fbnr, $fnr, $fragetext)
    {
        
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $fragetext = $this->escapeString($fragetext);
        $sql = "UPDATE tbl_frage SET FNr = '$fnr' WHERE FbNr = '$fbnr' AND Fragetext = '$fragetext'";
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($fbnr, $fnr, $fragetext)
    {
        $fbnr = $this->escapeString($fbnr);
        $fnr = $this->escapeString($fnr);
        $fragetext = $this->escapeString($fragetext);
        $sql = "INSERT INTO tbl_frage (FNr, FbNr, Fragetext) VALUES ('$fnr', '$fbnr', '$fragetext')";
        return $this->globalInsertRecord($sql);
    }
    function deleteRecord($fnr, $fbnr)
    {
        $fnr = $this->escapeString($fnr);
        $fbnr = $this->escapeString($fbnr);
        $sql = "DELETE FROM tbl_frage WHERE FbNr = '$fbnr' AND FNr = '$fnr'";
        return $this->globalDeleteRecord($sql);
    }
    
    function maxRecord($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "SELECT max(FNr) AS maxFnr FROM tbl_frage WHERE FbNr = '$fbnr'";
        return $this->globalSelectUniqueRecord($sql);
    }
}
?>