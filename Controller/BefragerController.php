<?php
require 'GlobalFunctions.php';
class BefragerController extends GlobalFunctions
{
    public function __construct()
    {
        parent::__construct();
    }
    /* @Author: Chris
        Hier stehen alle relevanten Funktionen für das Menü des Befragers.*/
    public function createInnerTableBefrager($recentUser)
    {

        $sqlObject = $this->tblFragebogen->selectRecords($recentUser);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . '<tr> <td>' . $row->FbNr . '</td><td>' . $row->Titel . '</td></tr>';
        }
        return $tableString;
    }

    public function createFrageFelder($anzFragen)
    {

        $frageString = '';

        for ($i = 1; $i <= $anzFragen; $i++) {
            $frageString = $frageString . $i . " " . "<input type ='text' name ='fragetext" . $i . "'>" . "</br> </br>";
        }

        return $frageString;
    }


    // noch in Bearbeitung --> @JOSC
    // Fragen müssen noch geprüft werden --> @JOSC
    public function createFragen($fbnr, $anzFragen, $post, $titel)
    {

        for ($fnr = 1; $fnr <= $anzFragen; $fnr++) {
            $postArrayName = 'fragetext' . $fnr;
            $fragetext = $post[$postArrayName];

            for ($fnr1 = 1; $fnr1 < $anzFragen; $fnr1++) {

                if ($fnr == $fnr1) {
                    $fnr1++;
                }
                $postArrayName1 = 'fragetext' . $fnr1;
                $fragetext1 = $post[$postArrayName1];
                if ($fragetext == $fragetext1) {
                    $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $fbnr . '&Titel=' . $titel . '&error=gleicheFrage';
                    $this->handleError('fragenErstellen', $suffixString);
                    exit;
                }
            }
            if ($fragetext == '') {
                $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $fbnr . '&Titel=' . $titel . '&error=leereFrage';
                $this->handleError('fragenErstellen', $suffixString);
                exit;
            }

            $this->tblFrage->insertRecord($fbnr, $fnr, $fragetext);
            //keine "success" sql Error abfrage da "DUPLICATE ENTRY PRIMARY" kommt, hat aber keinen Einfluss auf die funktionsweise, ist auch komischerweise kein Duplikat zu finden.
        }
        $this->handleInfo('fragebogenErstellt', 'fb_erstellt');
    }

    public function controllTitelFragebogen($titel, $benutzername, $anzFragen)
    {
        $sqlObject = $this->tblFragebogen->selectUniqueRecordByTitel($titel);
        if($titel == '') {
            $this->handleError('neuerFragebogen', 'leererTitel');
            exit;
        }
        if (is_null($sqlObject)) {
            if ($anzFragen <= 0) {
                $this->handleError('neuerFragebogen', 'keineFragen');
                exit;
            } else {
                $sqlResult = $this->tblFragebogen->insertRecord($titel, $benutzername);
                if ($sqlResult != 'error') {
                    $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $sqlResult . '&Titel=' . $titel;
                    $this->moveToPage('FragenErstellen.php', $suffixString);
                } else {
                    $this->handleError('neuerFragebogen', 'sqlError');
                }
            }
        } else {
            $this->handleError('neuerFragebogen', 'titleInUse');
        }
    }

    public function createKursFelder()
    {

        $kurse = $this->tblKurs->selectRecords();
        while ($kurs = $kurse->fetch_object()) {
            echo "<input type='checkbox' name='" . $kurs->Name . "'><label for='" . $kurs->Name . "'>" . $kurs->Name . "</label></br>";
            echo "</br>";
        }
    }

    public function freischaltenKurs($fragebogen, $kurs)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($fragebogen)->FbNr;
        $sqlObject = $this->tblFreigeschaltet->insertRecord($fbnr, $kurs);
        if ($sqlObject != 'success') {
            $this->handleError('kurseFreischalten', 'sqlError');
        } else $this->handleInfo('kurseFreischalten', 'freigeschalten');
    }

    public function showBereitsFreigeschaltet($fragebogen)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($fragebogen)->FbNr;
        $sqlObject = $this->sqlWrapper->selectBereitsFreigeschaltet($fbnr);
        $freigeschaltetString = '';
        while ($row = $sqlObject->fetch_object()) {
            $freigeschaltetString = $freigeschaltetString . $row->Name . "</br>";
        }
        if ($freigeschaltetString == '') {
            $freigeschaltetString = 'Es wurden noch keine Kurse freigeschalten.';
        }
        return "<br> <p>Liste der bereits freigegebenen Kurse für den Fragebogen " . $fragebogen . ":</p>" . $freigeschaltetString;
    }


    public function createDropdownFragebogen($recentUser)
    {

        $sqlObject = $this->tblFragebogen->selectRecords($recentUser);
        $dropdownString = '';

        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Titel . "</option>";
        }

        return $dropdownString;
    }

    public function createDropdownKurs()
    {
        $sqlObject = $this->tblKurs->selectRecords();
        $dropdownString = '';

        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Name . "</option>";
        }

        return $dropdownString;
    }

    public function fragebogenKopieren($recentUser, $oldTitle, $copyTitle)
    {
        $oldFbNr = $this->tblFragebogen->selectUniqueRecordByTitel($oldTitle)->FbNr;
        $checkTitle = $this->tblFragebogen->selectUniqueRecordByTitel($copyTitle);
        if (is_null($checkTitle)) {
            $newFbNr = $this->tblFragebogen->insertRecord($copyTitle, $recentUser);
            $sqlObject1 = $this->tblFrage->selectRecords($oldFbNr);
            $fnr = 1;
            while ($frage = $sqlObject1->fetch_object()) {
                $fragetext = $frage->Fragetext;
                $sqlObject = $this->tblFrage->insertRecord($newFbNr, $fnr, $fragetext);
                if ($sqlObject != 'success') {
                    $this->handleError('fragenKopieren', 'sqlError');
                    exit;
                }
                $fnr++;
            }
            $this->handleInfo('fragebogenKopieren', 'kopiert');
        } else {
            $this->handleError('fragebogenKopieren', 'titleInUse');
        }
    }
    public function controllNameKurs()
    {

        $name = $_POST["kursname"];
        $sqlObject = $this->tblKurs->selectUniqueRecord($name);
        if (is_null($sqlObject)) {
            $neuerKurs = $this->tblKurs->insertRecord($name);
            // ToDo: mit $neuerKurs wird nichts gemacht, Fehlerbehandlung ?
            $this->handleInfo('neuerKurs', 'kursErstellt');
        } else {
            $this->handleError('neuerKurs', 'nameInUse');
        }
    }

    public function fragebogenLoeschen($titel)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($titel)->FbNr;
        $sqlObject = $this->tblFragebogen->deleteRecord($fbnr);
        if ($sqlObject != 'success') {
            $this->handleError('fragebogenLoeschen', 'sqlError');
        } else {
            $this->handleInfo('fragebogenLoeschen', 'geloescht');
        }
    }

    public function fragebogenBearbeiten($titel)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($titel)->FbNr;
        $suffixString = '?fbnr=' . $fbnr;
        $this->moveToPage('FragebogenBearbeiten.php', $suffixString);
    }

    public function fragenAnzeigenBearbeiten($fbnr)
    {

        $sqlObject = $this->tblFrage->selectRecords($fbnr);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . "<tr> 
            <td>" . $row->FNr . "</td>
            <td>" . $row->Fragetext . "</td>
            <td> <button type='submit' name='frage_loeschen' value='" . $row->FNr . "'>Löschen</button></td>
            </tr>";
        }
        return $tableString;
    }

    public function einzelneFrageLoeschen($fnr, $fbnr)
    {
        $sqlObject = $this->tblFrage->deleteRecord($fnr, $fbnr);
        if ($sqlObject == "success") {
            $this->sortFragen($fbnr, $fnr);
            //$suffixString = '?fbnr=' . $fbnr . '&info=frage_geloescht'; 
            //$this->handleInfo('einzelneFrageLoeschen', $suffixString);
        } else {
            $suffixString = '?fbnr=' . $fbnr . '&error=sqlError';
            $this->handleError('einzelneFrageLoeschen', $suffixString);
        }
    }

    public function sortFragen($fbnr, $fnr)
    {
        $sqlObject = $this->tblFrage->selectRecords($fbnr, "FNr > '$fnr'");
        while ($row = $sqlObject->fetch_object()) {
            $fragetext = $row->Fragetext;
            $update = $this->tblFrage->updateRecord($fbnr, $fnr, $fragetext);
            if ($update !== "success") {
                $suffixString = '?fbnr=' . $fbnr . '&error=sqlError';
                $this->handleError('einzelneFrageLoeschen', $suffixString);
                exit;
            } else {
                $suffixString = '?fbnr=' . $fbnr . '&info=frage_geloescht';
                $this->handleInfo('einzelneFrageLoeschen', $suffixString);
            }
            $fnr++;
        }
    }

    public function einzelneFrageHinzufügen($fbnr, $fragetext)
    {
        $maxFnr = $this->tblFrage->maxRecord($fbnr)->maxFnr;
        $neueFnr = $maxFnr + 1;
        for ($fnr1 = 1; $fnr1 <= $maxFnr; $fnr1++) {
            $fragetext1 = $this->tblFrage->selectUniqueRecord($fbnr, $fnr1)->Fragetext;
            if ($fragetext == $fragetext1) {
                $suffixString = $suffixString = '?fbnr=' . $fbnr . '&error=gleicheFrage';
                $this->handleError('einzelneFrageHinzufügen', $suffixString);
                exit;
            }
        }
        if ($fragetext == '') {
            $suffixString = $suffixString = $suffixString = '?fbnr=' . $fbnr . '&error=leereFrage';
            $this->handleError('einzelneFrageHinzufügen', $suffixString);
            exit;
        }
        $sqlObject = $this->tblFrage->insertRecord($fbnr, $neueFnr, $fragetext);
        if ($sqlObject == "success") {
            $suffixString = '?fbnr=' . $fbnr . '&info=frage_hinzugefügt';
            $this->handleInfo('einzelneFrageHinzufügen', $suffixString);
        } else {
            $suffixString = '?fbnr=' . $fbnr . '&error=sqlError';
            $this->handleError('einzelneFrageHinzufügen', $suffixString);
        }
    }



    public function controllMatrikelnummer()
    {

        $matrikelnummer = $_POST["matrikelnummer"];
        $sqlObject = $this->tblStudent->selectUniqueRecord($matrikelnummer);
        if (is_null($sqlObject)) {
            $name = $_POST["Kurs"];
            $neuerStudent = $this->tblStudent->insertRecord($matrikelnummer, $name);
            $this->handleInfo('neuerStudent', 'studentErstellt');
        } else {
            $this->handleError('neueMatrikelnummer', 'matrikelnummerInUse');
        }
    }

    public function createDropdownFreigeschaltet($recentUser)
    {

        $sqlObject = $this->tblFreigeschaltet->selectRecordsFreigeschaltet($recentUser);
        $dropdownString = '';
        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Titel . "</option>";
        }
        return $dropdownString;
    }

    public function selectKurseZuFragebogen($fbnr)
    {

        $sqlObject = $this->tblFreigeschaltet->selectRecordsByFragebogenNr($fbnr);


        $dropdownString = "";
        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Name . "</option>";
        }
        return $dropdownString;
    }

    public function fragebogenAuswählen($titel)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($titel)->FbNr;
        $suffixString = '?fbnr=' . $fbnr;
        $this->moveToPage('Auswertung.php', $suffixString);
    }

    /*public function fragebogenAuswerten($fbnr, $kurs)
    {
        $name = $this->tblFreigeschaltet->selectUniqueRecord($kurs)->Name;
        $suffixString = '?fbnr=' . $fbnr . '&name=' . $name;   
        $this->moveToPage('Auswertung.php', $suffixString); 
    }*/

    public function auswertungAnzeigen($fbnr, $kurs)
    {
        $sqlObject = $this->tblAuswertung->selectRecordsAuswertung($fbnr, $kurs);
        if ($sqlObject->num_rows != 0) {
            $tableString = '';
            while ($row = $sqlObject->fetch_object()) {
                $tableString = $tableString . "<tr> 
                <td>" . $row->FNr . "</td>
                <td>" . $row->Fragetext . "</td>
                <td>" . $row->Durchschnitt . "</td>
                <td>" . $row->Maximal . "</td>
                <td>" . $row->Minimal . "</td>
                <td>" . $this->auswertungStandardabweichung($fbnr, $kurs, $row->FNr) . "</td>
                </tr>";
            }
            return $tableString;
        } else {
            $suffixString = '?fbnr=' . $fbnr . '&error=noValues';
            $this->handleError('auswertung',$suffixString);
        }
    }

    public function kommentareAnzeigen($fbnr, $kurs)
    {
        $sqlObject = $this->tblAuswertung->selectRecordsKommentare($fbnr, $kurs);

        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . $row->Kommentar . "</br></br>";
        }
        return $tableString;
    }

    public function auswertungStandardabweichung($fbnr, $kurs, $fnr)
    {
        $values = array();
        $sqlObject = $this->tblAuswertung->SW($fbnr, $kurs, $fnr);
        while ($row = $sqlObject->fetch_object()) {
            array_push($values, $row->BewertungSW);
        }
        if (!empty($values)) {
            return $this->standardabweichung($values);
        } else {
            return '';
        }
    }


    function standardabweichung($values)
    {
        $mean = array_sum($values) / count($values);

        $sum = 0;
        foreach ($values as $value) {
            $sum += pow($value - $mean, 2);
        }

        $stddev = sqrt($sum / count($values));

        return Round($stddev, 2);
    }

    public function pruefeBefrager($fbnr = '') {
        if (!isset($_SESSION['befrager']))
        {
            $this->handleError('anmeldungBefrager', 'notLoggedIn');
        }
        if ($fbnr != ''){
            $benutzername = $this->tblFragebogen->selectUniqueRecordByFbNr($fbnr)->Benutzername;
            if ($benutzername != $_SESSION['befrager'])
            $this->handleError('andererBefrager', 'andererBefrager');
        };
    }
}
