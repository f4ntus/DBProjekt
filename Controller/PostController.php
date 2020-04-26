<?php
require 'SqlWrapper.php';
class PostController extends GlobalFunctions
{
    private $sqlWrapper;
    public function __construct()
    {
        $this->sqlWrapper = new SqlWrapper();
    }

    


   
    

    public function createInnerTable()
    {

        $sqlObject = $this->sqlWrapper->selectFreigeschaltet($_SESSION['kurs']);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . '<tr> <td>' . $row->FbNr . '</td><td>' . $row->Titel . '</td></tr>';
        }
        return $tableString;
    }

    
    public function __destruct()
    {
        $this->sqlWrapper = NULL;
    }
}
