<?php
require '../Model/SqlWrapper.php';
require '../Model/TblAbschliessen.php';
require '../Model/TblBeantwortet.php';
require '../Model/TblBefrager.php';
require '../Model/TblFrage.php';
require '../Model/TblFragebogen.php';
require '../Model/TblKommentiert.php';
require '../Model/TblKurs.php';
require '../Model/TblStudent.php';
require '../Model/TblFreigeschaltet.php';
class GlobalFunctions
{
    protected $sqlWrapper;
    protected $tblAbschliessen;
    protected $tblBeantwortet;
    protected $tblBefrager;
    protected $tblFrage;
    protected $tblFragebogen;
    protected $tblKommentiert;
    protected $tblKurs;
    protected $tblStudent;
    protected $tblFreigeschaltet;
    public function __construct()
    {
        $this->sqlWrapper = new SqlWrapper();
        $this->tblAbschliessen = new TblAbschliessen();
        $this->tblBeantwortet = new TblBeantwortet();
        $this->tblBefrager = new TblBefrager();
        $this->tblFrage = new TblFrage();
        $this->tblFragebogen = new TblFragebogen();
        $this->tblKommentiert = new TblKommentiert();
        $this->tblKurs = new TblKurs();
        $this->tblStudent = new TblStudent();
        $this->tblFreigeschaltet = new TblFreigeschaltet();

    }
    protected function handleError($moveTo, $errorCode)
    {
        switch ($moveTo) {
            case 'anmeldungBefrager':
                $GETString = '?befrager=Befrager&error=' . $errorCode;
                $this->moveToPage('index.php', $GETString);
                break;

            case 'anmeldungStudent':
                $GETString = '?student=Student&error=' . $errorCode;
                $this->moveToPage('index.php', $GETString);
                break;

            case 'neuerFragebogen':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('neuerFragebogen.php', $GETString);
                break;

            case 'fragenErstellen':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('FragenErstellen.php', $GETString);
                break;

            case 'kurseFreischalten':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('FreischaltungKurs.php', $GETString);
                break;
            
            case 'fragebogenKopieren':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('FragebogenKopieren.php', $GETString);
                break;
            
            case 'neuerKurs':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('neuerKurs.php', $GETString);
                break;
            
            case 'neueMatrikelnummer':
                    $GETString = '?error=' . $errorCode;
                    $this->moveToPage('neuerStudent.php', $GETString);
                    break;  
            
            case 'fragebogenLoeschen':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('FragebogenLoeschen.php', $GETString);
                break;
        }
    }

    protected function handleInfo($moveTo, $infoCode)
    {
        switch ($moveTo) {
            case "fragebogenErstellt":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;
            
            case "kurseFreischalten":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('FreischaltungKurs.php', $GETString);
                break;
            
            case "fragebogenKopieren":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;
            
            case "neuerKurs":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;
            
            case "neuerStudent":
                 $GETString = '?info=' . $infoCode;
                 $this->moveToPage('menuBefrager.php', $GETString);
                 break;

            case "fragebogenLoeschen":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;

        }
    }
    protected function moveToPage($pageName, $suffix = '')
    {
        // Redirect auf eine andere Seite im aktuell angeforderten Verzeichnis 
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$pageName$suffix");
    }
}
