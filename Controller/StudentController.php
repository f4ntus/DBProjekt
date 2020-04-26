<?php
class PostController extends GlobalFunctions
{
    public function __construct()
    {
        parent::__construct();
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

}