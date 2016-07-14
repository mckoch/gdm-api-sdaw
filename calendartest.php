<?php
/**
 * @name calendartest.php
 * @package SDAW_Classes
 * @author mckoch - 13.07.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * SDAW Classes:calendartest
 *
 *
 */
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title></title>
    </head>
    <body>
        <?php
        require_once('include/CALENDAR.inc.php');
        $cal = new CALENDAR;
        print_r($cal->blocks);
        print var_dump($cal->renderDekaPlan());
        ?>
    </body>
</html>
