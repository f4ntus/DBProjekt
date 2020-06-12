<?php

require_once 'AbstractSQLWrapper.php';
class TblAuswertung extends AbstractSQLWrapper
{
    
    function selectRecordsAuswertung($fbnr, $kurs)
    {
        $fbnr = $this->escapeString($fbnr);
        $kurs = $this->escapeString($kurs);

        $sql ="SELECT tbl_beantwortet.FNr, tbl_frage.Fragetext, ROUND(AVG(Bewertung),2) AS Durchschnitt, MAX(Bewertung) AS Maximal, MIN(Bewertung) AS Minimal 
        FROM tbl_beantwortet, tbl_abschliessen, tbl_student, tbl_frage
        where tbl_beantwortet.FbNr = tbl_abschliessen.FbNr and tbl_beantwortet.Matrikelnummer = tbl_abschliessen.Matrikelnummer and 
        tbl_abschliessen.Matrikelnummer = tbl_student.Matrikelnummer and tbl_beantwortet.FNr = tbl_frage.FNr and tbl_beantwortet.FbNr = tbl_frage.FbNr and 
        tbl_beantwortet.FbNr = '$fbnr' and tbl_student.Name = '$kurs' GROUP BY tbl_beantwortet.FNr";
        return $this->globalSelectRecords($sql);  
    }

    function selectRecordsKommentare($fbnr, $kurs)
    {
        $fbnr = $this->escapeString($fbnr);
        $kurs = $this->escapeString($kurs);
        $sql ="SELECT tbl_kommentiert.Kommentar From tbl_kommentiert, tbl_student, tbl_abschliessen 
        where tbl_student.Matrikelnummer = tbl_abschliessen.Matrikelnummer and tbl_kommentiert.FbNr = tbl_abschliessen.FbNr and tbl_kommentiert.Matrikelnummer = tbl_abschliessen.Matrikelnummer 
        and tbl_abschliessen.FbNr = '$fbnr' and tbl_student.Name = '$kurs'";
        return $this->globalSelectRecords($sql);  
    }

    function selectRecordsStandardabweichung($fbnr, $kurs, $fnr)
    {
        $fbnr = $this->escapeString($kurs);
        $kurs = $this->escapeString($kurs);
        $fnr = $this->escapeString($fnr);
        $sql ="SELECT tbl_beantwortet.Bewertung AS BewertungSW FROM tbl_beantwortet, tbl_abschliessen, tbl_student, tbl_frage
        where tbl_beantwortet.FbNr = tbl_abschliessen.FbNr and tbl_beantwortet.Matrikelnummer = tbl_abschliessen.Matrikelnummer and 
        tbl_abschliessen.Matrikelnummer = tbl_student.Matrikelnummer and tbl_beantwortet.FNr = tbl_frage.FNr and tbl_beantwortet.FbNr = tbl_frage.FbNr and 
        tbl_beantwortet.FbNr = '$fbnr' and tbl_student.Name = '$kurs'and tbl_frage.FNr = '$fnr'";
        return $this->globalSelectRecords($sql);  
    }
    
}
?>