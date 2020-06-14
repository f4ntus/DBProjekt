<?php

require_once 'AbstractSQLWrapper.php';
class TblKurs extends AbstractSQLWrapper
{
    /**
     * @author Lukas Schick
     * Liefert einzelnen Datensatz für Kurs
     * @param $name
     * @return object
     */
    function selectUniqueRecord($name)
    {
        $name = $this->escapeString($name);
        $sql = "SELECT Name FROM tbl_kurs WHERE Name = '$name'";
        return $this->globalSelectUniqueRecord($sql);
    }
    /**
     * @author Lukas Schick
     * Liefert alle Datensätze für Kurs
     * @return object
     */
    function selectRecords()
    {
        $sql = "SELECT * FROM tbl_kurs";
        return $this->globalSelectRecords($sql);
    }
     /**
     * @author Lukas Schick
     * Fügt Datensatz in Tabelle Kurs ein
     * @param $name
     * @return object
     */
    function insertRecord($name)
    {
        $name = $this->escapeString($name);
        $sql = "INSERT INTO tbl_kurs (Name) VALUES ('$name')";
        return $this->globalInsertRecord($sql);
    }
}
?>