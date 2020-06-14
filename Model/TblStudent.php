<?php

require_once 'AbstractSQLWrapper.php';
class TblStudent extends AbstractSQLWrapper
{
     /**
     * @author Lukas Schick
     * Liefert einzelnen Datensatz von Tabelle Student
     * @param $matrikelnummer
     * @return object
     */
    function selectUniqueRecord($matrikelnummer)
    {
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $sql = "SELECT * FROM tbl_student WHERE Matrikelnummer = '$matrikelnummer'";
        return $this->globalSelectUniqueRecord($sql);
    }

    /**
     * @author Lukas Schick
     * Fügt Datensatz in Tabelle Student ein
     * @param $matrikelnummer
     * @param $name
     * @return object
     */
    function insertRecord($matrikelnummer,$name)
    {
        $matrikelnummer = $this->escapeString($matrikelnummer);
        $name = $this->escapeString($name);
        $sql = "INSERT INTO tbl_student (Matrikelnummer, Name) VALUES ('$matrikelnummer', '$name')";
        return $this->globalInsertRecord($sql);
    }
}
?>