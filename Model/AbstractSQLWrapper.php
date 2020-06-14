<?php
abstract class AbstractSQLWrapper {
    const DBHOST = "localhost";
    const DBUSER = "root";
    const DBPASSWORD = "";
    const DATABASE = "befragungstool";
    protected $db;

    public function __construct()
    {
        $this->db = new MySQLi(self::DBHOST, self::DBUSER, self::DBPASSWORD, self::DATABASE);
    }

    /**
     * @author Johannes Scheffold
     * 
     * diese Funktion escaped alle Sonderzeichen, so dass SQL-Injection nicht mehr möglich ist
     * 
     * @param $escapeString
     * @return string
     */
    function escapeString($escapeString){
       return mysqli_real_escape_string($this->db,$escapeString);
    }

    /**
     * @author Johannes Scheffold
     * 
     * diese Funktion liest genau ein Datensatz aus der Datenbank
     * 
     * @param $sql (String der die SQL-Abfrage enthält)
     * @return object
     */
    function globalSelectUniqueRecord($sql){
        $result = $this->db->query($sql);
        return $result->fetch_object(); 
    }

    /**
     * @author Johannes Scheffold
     * 
     * diese Funktion liest mehrere Datensätze aus der Datenbank
     * 
     * @param $sql (String der die SQL-Abfrage enthält)
     * @return liste (gibt eine Liste der Datensätze zurück)
     */
    function globalSelectRecords($sql){
        return $this->db->query($sql);

    }

    /**
     * @author Johannes Scheffold
     * 
     * diese Funktion aktualisiert ein Datensatz in der Datenbank.
     * 
     * @param $sql (String der die SQL-Abfrage enthält)
     * @return string (entweder success oder der Fehler)
     */
    function globalUpdateRecord($sql){
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    /**
     * @author Johannes Scheffold
     * 
     * diese Funktion fügt einen neuen Datensatz ein.
     * 
     * @param $sql (String der die SQL-Abfrage enthält)
     * @return string (entweder success oder der Fehler)
     */
    function globalInsertRecord($sql){
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    /**
     * @author Johannes Scheffold
     * 
     * diese Funktion löscht einen Datensatz
     * 
     * @param $sql (String der die SQL-Abfrage enthält)
     * @return string (entweder success oder der Fehler)
     */ 
   function globalDeleteRecord($sql){
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
        
    }
}
?>