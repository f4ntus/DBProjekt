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
    function escapeString($escapeString){
       return mysqli_real_escape_string($escapeString,$this->db);
    }

    function globalSelectUniqueRecord($sql){
        $result = $this->db->query($sql);
        return $result->fetch_object(); 
    }
    function globalSelectRecords($sql){
        return $this->db->query($sql);

    }
    function globalUpdateRecord($sql){
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }
    function globalInsertRecord($sql){
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }
   function globalDeleteRecord($sql){
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
        
    }



    
}
?>