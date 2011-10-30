<?php

class DateService {

    private $monthArray;

    public function __construct() {
        $this->monthArray = array(
            '01_ua' => 'січень', '01_en' => 'january',
            '02_ua' => 'лютий', '02_en' => 'fabruary',
            '03_ua' => 'березень', '03_en' => 'march',
            '04_ua' => 'квітень', '04_en' => 'april',
            '05_ua' => 'травень', '05_en' => 'may',
            '06_ua' => 'червень', '06_en' => 'june',
            '07_ua' => 'липень', '07_en' => 'july',
            '08_ua' => 'серпень', '08_en' => 'august',
            '09_ua' => 'вересень', '09_en' => 'september',
            '10_ua' => 'жовтень', '10_en' => 'october',
            '11_ua' => 'листопад', '11_en' => 'november',
            '12_ua' => 'грудень', '12_en' => 'december'
        );
    }

    public function transrormDate($date, $lang) {
        
        $dateArray = explode('-', $date);
        $year = "'" . substr($dateArray[0], 2);
        $month = $this->monthArray[$dateArray[1] . '_' . $lang];
        $day = $dateArray[2];
        
        return array(
            'day' => $day,
            'month' => $month,
            'year' => $year
        );
    }
    
    public function getDate(){
        
    }

}

?>
