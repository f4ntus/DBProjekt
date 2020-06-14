<?php

/** 
 * @author Christoph Böhringer
 * Diese Klasse beinhaltet alle SQL-Aufrufe innerhalb der Tabelle Fragebogen.
 */
require_once 'AbstractSQLWrapper.php';
class TblFragebogen extends AbstractSQLWrapper
{
    /**
     * @author Christoph Böhringer
     * Liefert einzelnen Datensatz der Tabelle Fragebogen über den Titel.
     * @param $titel (Fragebogentitel)
     * 
     * @return object
     */
    function selectUniqueRecordByTitel($titel)
    {
        $titel = $this->escapeString($titel);
        $sql = "SELECT FbNr FROM tbl_fragebogen WHERE Titel ='$titel'";
        return $this->globalSelectUniqueRecord($sql);
    }

    /**
     * @author Christoph Böhringer
     * Liefert einzelnen Datensatz der Tabelle Fragebogen über die Fragebogennummer.
     * @param $fbnr (Fragebogenummer)
     * 
     * @return object
     */
    function selectUniqueRecordByFbNr($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "SELECT Benutzername FROM tbl_fragebogen WHERE FbNr ='$fbnr'";
        return $this->globalSelectUniqueRecord($sql);
    }

    /**
     * @author Christoph Böhringer
     * Liefert mehrere Datensätze der Tabelle Fragebogen
     * @param $recentUser (akuteller Befrager in der Session)
     * 
     * @return list
     */
    function selectRecords($recentUser = '')
    {
        $recentUser = $this->escapeString($recentUser);
        $sql = "SELECT * FROM tbl_fragebogen WHERE Benutzername = '$recentUser'";;
        return $this->globalSelectRecords($sql);
    }

    /**
     * @author Christoph Böhringer
     * fügt einen Datensatz in die Tabelle Fragebogen
     * @param $titel (Fragebogentitel)
     * @param $benutzername (Benutzername des aktuellen Befragers)
     * 
     * @return string
     */
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

    /**
     * @author Christoph Böhringer
     * löscht einen Datensatz in der Tabelle Fragebogen
     * @param $fbnr (Fragebogennummer)
     * 
     * @return string
     */
    function deleteRecord($fbnr)
    {
        $fbnr = $this->escapeString($fbnr);
        $sql = "DELETE FROM tbl_fragebogen WHERE FbNr = '$fbnr'";
        return $this->globalDeleteRecord($sql);
    }
}
