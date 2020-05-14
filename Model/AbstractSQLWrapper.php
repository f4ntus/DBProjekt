<?php
abstract class AbstractSQLWrapper {
    const DBHOST = "localhost";
    const DBUSER = "root";
    const DBPASSWORD = "";
    const DATABASE = "befragungstool";
    private $db;

    public function __construct()
    {
        $this->db = new MySQLi(self::DBHOST, self::DBUSER, self::DBPASSWORD, self::DATABASE);
    }

    protected function globalSelectUniqueRecord($sql){
        $result = $this->db->query($sql);
        return $result->fetch_object(); 
    }
    protected function globalSelectRecords($sql){
        return $this->db->query($sql);

    }
    protected function globalUpdateRecord($sql){

    }
    protected function globalInsertRecord($sql){
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }
    protected function globalDeleteRecord($sql){
        
    }



    
}
?>