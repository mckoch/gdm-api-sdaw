<?php

/**
 * @name CALENDAR.inc.php
 * @package SDAW_Classes
 * @author mckoch - 13.07.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * SDAW Classes:CALENDAR
 *
 *
 */
class CALENDAR {

    /**
     * Dekaden:
     * 1 -33. Jeweils 10 Tage
     * Ausnahmen: 1,33,34 je 14 Tage
     * */
    public $dekaEnum = 33;
    public $dekaStandardDuration = 10;
    
    public $blocks = array('A','B','C');
    public $dekaExceptions = array(1,33,34);
    public $dekaExceptionDuration = array(14,14,14);
    public $dekaStart = array('28.12.2010','31.12.2010','04.01.2011');
    

    public function renderDekaPlan() {
        $i = 0;
        foreach ($this->blocks as $deka) {
            $i++;
            $dekaPlan[$deka] = $i;
        }

        return $dekaPlan;
    }

    
    
    public function datesToDekas($block, $dates) {
        return array($dekas);
    }

    public function dateRangesToDekas($start, $end) {
        return array($start, $end);
    }

    public function dekasToDateRanges($dekas) {
        return array($dekas);
    }

}
