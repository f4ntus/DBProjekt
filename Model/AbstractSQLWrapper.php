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

    abstract protected function selectUniqueRecord();
    abstract protected function selectRecords();
    abstract protected function updateRecord();
    abstract protected function insertRecord();
    abstract protected function deleteRecord();

    protected function globalSelectUniqueRecord($sql){
        $result = $this->db->query($sql);
        return $result->fetch_object(); 
    }
    protected function globalSelectRecords($sql){

    }
    protected function globalUpdateRecord($sql){

    }
    protected function globalInsertRecord($sql){

    }
    protected function globalDeleteRecord($sql){
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }



    
}
?>