<?php

/**
 * @name apidispatcher.inc.php
 * @package SDAW_Classes
 * @author mckoch - 14.04.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.2
 * @license No GPL, no CC. Property of author.
 * 
 * SDAW Classes:apidispatcher
 * HTTP Request Dispatcher f�r SADW API Abfragen.
 * Erzeugt Anwendungs Dispatcher aus DISP:: und formatiert Ausgabe
 * (z.Zt. nur HTML aus GH::)
 *
 * @todo XML und JSON Ausgabe zus�tzlich
 */
try {
    /**
     * var $command
     */
    if (isset($_GET['command'])) {
        $do = $_GET['command'];
    } else
        $do='default';

    /**
     * neuen Dispatcher erzeugen
     */
    $d = new DISP;

    /**
     * Auswahl der Aktion f�r Dispatcher $d
     */
    switch ($do) {
        case 'plzsuche':
            $d->setparams($_GET);
            return print GH::makeDynamicSearchJSON($d->exec('plzarea'));  
            
            break;
        case 'gkzfsuche':
            $d->setparams($_GET);
            return print GH::makeDynamicSearchJSON($d->exec('gkzfarea'));  
            
            
            break;
        /**
         * getplzlist: Hilfsfunktion zum Bestimmen einer PLZ (autocomplete9
         */
        case 'getplzlist':
            $d->setparams($_GET);
            // print_r($_GET);die;
             return print GH::makePlzSearchJSON( $d->exec('plzlist') );
            break;
        /**
         * getokzflist: Hilfsfunktion Ortskennziffern (autocomplete)
         */
        case 'getokzflist':
            $d->setparams($_GET);
            return print GH::makeGkzfSearchJSON( $d->exec('okzflist') );
            break;
        /**
         * print is same as  case '8' !!!!
         * execept results encodig
         * 
         * EXPERIMENTAL: REPLACE DOC CLASS!!!!!
         */
        case 'print':
            // $d->setparams($_POST);
            $d->setparams($_GET);
            $doc = GH::printDocListe($d->exec('userdata'));
            //$doc->exportAsAttachedFile();
            //return print $d->exec('userdata');
            $doc->saveToDisk('./gen_docs/mytest.odt');
            break;
            
        /**
         * plugin Frontend
         * lädt Merkliste 
         */
        case 'show_tagged':
            $d->setparams($_POST);
            return "tagged";
            break;
        /**
         * plugin Frontend
         * lädt Daten der letzten Abfrage(n)
         */
        case 'show_repository':
            $d->setparams($_POST);
            return "repository";
            break;
        
        /**
         * Checkout gewählter Tafeln
         */
        case 'checkout':
            //return print_r($_POST);
            return print($d->exec('checkout')); 
            break;
        /**
         * PLZ Polygone 
         * 
         */
        case 'graphics':
            //print_r($_GET);
            $d->setparams($_GET);
            //return print $d->exec('plzpolygons');
            return print GH::makePlzPolyPointData($d->exec('plzpolygons'));

            break;
        /**
         * Initialisierung wenn keine weiteren Parameter (Suchauswahl) gegeben.
         * 1: explizite Initialisierung - l�dt Standardauswahl
         */
        case '1':
            $d->setparams('default');
            //return

            return print GH::makeMapResultsDiv($d->exec('find'));
            break;
        /**
         * Aufruf mit Suchparametern aus $_GET
         * AUS _BESTANDSSSUCHE_ IN ALLEN FELDERN!!
         * Pr�fung �bernimmt von var $d erzeugtes object FIND
         * 2: Suchparameter werden verarbeitet
         */
        case '2':
            $d->setparams($_GET);

            return print GH::makeDynamicSearchJSON($d->exec('find'));
            break;
        /**
         * Aufruf mit longitude und latitude:
         * Umkreissuche var distance in METERN!
         * /deprecated!/
         */
        case '3':
            $d->setparams($_GET);
            return print GH::makeMapResultsDiv($d->exec('gpos'));
            break;
        /**
         * Siehe 3, returns JSON encoded
         */
        case '4':
            $d->setparams($_GET);
            return print GH::makeDynamicSearchJSON($d->exec('gpos'));
            break;
        /**
         * JSON Initialisierung
         */
        case '5':
            $d->setparams('default');
            return print GH::makeDynamicSearchJSON($d->exec('find'));
            break;
        /**
         * Rechtecksuche
         */
        case '6':
            $d->setparams($_GET['bounds']);
            return print GH::makeDynamicSearchJSON($d->exec('rectangle'));
            break;
        /**
         * Polygonsuche
         */
        case '7':
            $d->setparams($_GET['bounds']);
            //return print ($_GET['bounds']);
            return print GH::makeDynamicSearchJSON($d->exec('polygon'));
            break;
        /**
         * erweiterte Suche aus CSV oder JSON Array
         * - Rendern von Benutzerdaten
         */
        case '8':
            $d->setparams($_GET);
            if ($_GET['output']=='kml'){
                GH::printToKml($d->exec('userdata'));
            } else {return print GH::makeDynamicSearchJSON($d->exec('userdata'));}
            //return print $d->exec('userdata');
            break;
        /**
         * default: leerer Aufruf
         * gibt Standardauswahl zur�ck
         */
        default:
            /**
             * Pr�fung auf dynamische Suche
             */
            if (isset($_GET['term'])) {
                $d->setparams($_GET['term']);
                return print GH::makeDynamicSearchInputFieldJSON($d->exec('dynamicsearch'));
            } else {
                /**
                 * Standardausgabe ohne Parameter = Initialisierung.
                 * Keine HTTP-Header Ausgabe!!!!!!
                 *
                 */
                $d->setparams('default');
                return print GH::makeMapResultsDiv($d->exec('find'));
            }
            break;
    }
} catch (Exception $e) {
    if (GH::checkIfAdmin()===true){
    echo "<pre>" . $e . "</pre>";}
    else echo 'noop.';
}
?>
