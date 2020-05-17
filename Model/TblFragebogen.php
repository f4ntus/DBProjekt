<?php

require_once 'AbstractSQLWrapper.php';
class TblFragebogen extends AbstractSQLWrapper
{
    function selectUniqueRecordByTitel($titel)
    {
        $sql = "SELECT FbNr FROM tbl_fragebogen WHERE Titel ='$titel'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectUniqueRecordByNr($fnr)
    {
        $sql = "SELECT FbNr FROM tbl_fragebogen WHERE FNr ='$fnr'";
        return $this->globalSelectUniqueRecord($sql);
    }
    function selectRecords($recentUser = '')
    {
        $sql = "SELECT * FROM tbl_fragebogen WHERE Benutzername = '$recentUser'";;
        return $this->globalSelectRecords($sql);
    }
    function updateRecord()
    {
        $sql = '';
        return $this->globalUpdateRecord($sql);
    }
    function insertRecord($titel, $benutzername)
    {
        $sql = "INSERT INTO tbl_fragebogen (Titel, Benutzername) VALUES ('$titel', '$benutzername')";
        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        } else {
            return 'error';
        }
    }
    function deleteRecord($fbnr)
    {
        //ToDo Chris: Alle abhängigkeiten löschen
        $sql = "DELETE FROM tbl_fragebogen WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
