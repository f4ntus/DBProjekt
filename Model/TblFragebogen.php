<?php

require_once 'AbstractSQLWrapper.php';
class TblFragebogen extends AbstractSQLWrapper
{
    function selectUniqueRecordByTitel($titel)
    {
        $titel = $this->escapeString($titel);
        $sql = "SELECT FbNr FROM tbl_fragebogen WHERE Titel ='$titel'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectUniqueRecordByFbNr($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "SELECT Benutzername FROM tbl_fragebogen WHERE FbNr ='$fbnr'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords($recentUser = '')
    {
        $recentUser = $this->escapeString($recentUser);
        $sql = "SELECT * FROM tbl_fragebogen WHERE Benutzername = '$recentUser'";;
        return $this->globalSelectRecords($sql);
    }
    function insertRecord($titel, $benutzername)
    {
        $titel = $this->escapeString($titel);
        $benutzername = $this->escapeString($benutzername);
        $sql = "INSERT INTO tbl_fragebogen (Titel, Benutzername) VALUES ('$titel', '$benutzername')";
        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        } else {
            return 'error';
        }
    }
    function deleteRecord($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "DELETE FROM tbl_fragebogen WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
