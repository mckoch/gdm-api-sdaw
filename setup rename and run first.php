<?php

//require_once('include/geoip.inc.php');
//print "<pre>";
//print_r($vsrc);
//die;
ini_set('display_errors', 1);
error_reporting(E_ALL);
print '<hr/>';
require_once('application.ini.php');
require_once('include/CALENDAR.inc_1.php');



$cal = new CALENDAR;

// $strfmt = 'Y/m/d';

function dateToKw($date) {
    if (strlen($date) > 2) {
        $d = newDate($date, 0);
        return array('week' => (int) date('W', strtotime($date)), 'bow' => $d->BOW(), 'eow' => $d->EOW());
    } else {
        // $d = $this->newDate($date, 0);
        return false;
    }
}

function newDate($date, $adjust) {
    $newDate = new DateClass($date);
    return $newDate->Add('days', $adjust);
}

$date = '2012/01/02';
$res = dateToKw($date, 0);

print '<pre>';
print_r($res);
print $res . '<hr>';

die(print_r(GH::getVisitorInfo()));
if ($_GET['adminkey'] != $GLOBALS['validadminkey']) {
    print "Kein g&uuml;ltiger Schl&uuml;ssel. ";
    die;
}

try {
    $d = new DISP;

    $newtable = $d->exec('newtable');
    $newtable->getXmlFile(DEFSDIR . 'Gemeindezuordnung.xml');
    $newtable->writeNewTable();

    $newtable->getXmlFile(DEFSDIR . 'NielsengebietePLZ.xml');
    $newtable->writeNewTable();


    unset($newtable);
    trigger_error("Hilfstabellen Gemeindezuordung und Nielsengebiete erfolgreich angelegt.", E_USER_NOTICE);
} catch (Exception $e) {
    echo "<pre>" . $e . "</pre>";
}
/**
 * var $csvfile
 *
 * Erster Durchlauf: PLZ, Einwohnerzahl, Gemeindekennzahl, Klebeblock...
 */
$csvfile = DEFSDIR . "Gemeindezuordnung.csv";

try {
    $table = "GEMEINDE_ZUORDNUNG";
    $handle = fopen($csvfile, 'r');
    if ($handle) {
        set_time_limit(0);

        //the top line is the field names
        $fields = fgetcsv($handle, 4096, ',', "\"");

        //loop through one row at a time
        $i = 0;
        while (($data = fgetcsv($handle, 4096, ',')) !== FALSE) {
            $i++;
            $data = array_combine($fields, $data);
            $sql = "INSERT INTO " . $table . " VALUES (" . $data['BL'] . "," . $data['RGB'] . "," . $data['Kreis'] . "," . $data['Gkz'] . "," . $data['Wirtschaftsraum'] . ","
                    . $data['Ort'] . "," . $data['Einwohner'] . "," . $data['Plz'] . "," . $data['Block neu'] . ")";
            if ($i < 10)
                print $sql . "<br/>";
        }

        fclose($handle);
    } trigger_error("$csvfile in $table importiert.", E_USER_NOTICE);
} catch (Exception $e) {
    echo "<pre>" . $e . "</pre>";
}

/**
 * zweiter Durchlauf: PLZ und Nielsenzuordnung
 */
try {
    $csvfile = "definitionfiles/NielsengebietePLZ.csv";
    $table = "NIELSEN_PLZ";

    $handle = fopen($csvfile, 'r');
    if ($handle) {
        set_time_limit(0);

        //the top line is the field names
        $fields = fgetcsv($handle, 4096, ',', "\"");

        //loop through one row at a time
        $i = 0;
        while (($data = fgetcsv($handle, 4096, ',')) !== FALSE) {
            $i++;
            $data = array_combine($fields, $data);
            $sql = "INSERT INTO " . $table . " VALUES (" . $data['nielsen'] . "," . $data['plz'] . "," . $data['ort'] . ")";
            if ($i < 10)
                print $sql . "<br/>";
        }

        fclose($handle);
    }
    trigger_error("$csvfile in $table importiert.", E_USER_NOTICE);
} catch (Exception $e) {
    echo "<pre>" . $e . "</pre>";
}
