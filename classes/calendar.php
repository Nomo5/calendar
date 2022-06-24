<?php

class Calendar {

    private $year;
    private $month;

    public function __construct($y, $m){
        
        if ($m > 12) {
            $this->year = $y + 1;
            $this->month = 1;
        } else if ($m < 1) {
            $this->year = $y - 1;
            $this->month = 12;
        } else {
            $this->year = $y;
            $this->month = $m;
        }
    }

    public function get_year() {
        return $this->year;
    }

    public function get_month() {
        return $this->month;
    }

    public function get_first_day_of_week() {   //月始めの曜日
        return date("w", mktime(0, 0, 0, $this->month, 1, $this->year));
    }

    public function get_last_day_of_week() {    //月終わりの曜日
        return date("w", mktime(0, 0, 0, $this->month + 1, 0, $this->year));
    }

    public function get_last_month_date() {
        return date("j", mktime(0, 0, 0, $this->month, 0, $this->year));
    }

    public function create_rows() {
        $last_day = date("j", mktime(0, 0, 0, $this->month + 1, 0, $this->year));   //今月の最終日
        
        $rows = array();
        $row = self::init_row();

        for( $i = 1; $i <= $last_day; $i++ ) {
            $date = date("w", mktime(0, 0, 0, $this->month, $i, $this->year));  //曜日取得

            $row[$date] = $i;

            if ( $date == 6 || $i == $last_day ) {
                $rows[] = $row;
                $row = self::init_row();
            }
        }

        return $rows;
    }

    private static function init_row() {
        $ary = array();
        for ( $i = 0; $i <= 6; $i++ ) {
            $ary[] = '.';
        }
        return $ary;
    }
}

?>