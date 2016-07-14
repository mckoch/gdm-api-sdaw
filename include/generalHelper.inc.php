<?php

class GH {

    static function appendToAngebotsLogfile($string) {
        $auftragslogfile = fopen($GLOBALS['auftragslogfile'], 'a');
        if (flock($auftragslogfile, LOCK_EX | LOCK_NB)) {
            fseek($auftragslogfile, 0, SEEK_END);
            fwrite($auftragslogfile, $_SESSION['myid'] . $string . microtime(true) . PHP_EOL);
        }
        return true; //dummy
    }

    static function printToKml($rs) {
        require_once(INCLUDEDIR . 'class.kml.php');
        $kml = new kml('Auswahl');
        $alt = 0;
        foreach ($rs as $data) {
            // $kml->addPoint($lon, $lat, $alt, $tit, $des)
            $kml->addPoint($data['latitude'], $data['longitude'], $alt, $data['count'], $data['Standortbezeichnung']);
        }
        $kml->export();
    }

    static function printDocListe($rs) {

        require_once (INCLUDEDIR . 'ODF/odf.php');
        $cfg = array('PATH_TO_TMP' => '/tmp',
            'ZIP_PROXY' => 'PhpZipProxy');

        $doc = new odf('/var/www/vhosts/joean-doe-bonn.de/web_users/sdaw-upload/STA-DATEIEN/Vorlagen/Anschreiben_Vorlage.odt', $cfg);
        // $doc = new odf('/var/www/vhosts/default/htdocs/_ng/templates/test.odt', $cfg);
        $doc->setVars('type', 'ANGEBOT');
        $tabelle = $doc->setSegment('Tabelle');
        // print_r($rs);
        foreach ($rs as $tafel) {
            $id = $tafel['count'];
            $tabelle->PLZ($tafel['PLZ']);
            $tabelle->ID($id);
            $tabelle->Standortbezeichnung($tafel['Standortbezeichnung']);
            $s = $tafel['Stellenart'];
            $tabelle->Stellenart($s);
            $b = $tafel['Beleuchtung'];
            $tabelle->Beleuchtung($b);
            ///$tabelle->Tagespreis($tafel['Preis']);
            //$tabelle->Verbrauchermarktnummer($tafel['Verbrauchermarktnummer']);
            //$tabelle->Leistungswert1($tafel['Leistungswert1']);
            $tabelle->Foto($id);
            if (file_exists('/srv/www/phpThumb/240x240/' . $id . '.jpg')) {
                $tabelle->setImage('Foto', '/srv/www/phpThumb/240x240/' . $id . '.jpg');
                //$tabelle->Foto('Kein Foto vorhanden. ');
            } else
                $tabelle->Foto('Kein Foto vorhanden. ');


            $tabelle->merge();
        }
        // print_r($tabelle);
        $doc->mergeSegment($tabelle);
//       $doc->setVars('MainContent', $rs);
        return $doc;
    }

    /**
     * function getVisitorInfo()
     * @return type Array 
      (
      [ip] => 81.169.177.115
      [country] => DE
      [region] => Berlin
      [city] => Berlin
      [lat] => 52.5167
      [lng] => 13.4
      )
     */
    static function getVisitorInfo() {
        require_once( INCLUDEDIR . 'geoip.inc.php');
        return $vsrc;
    }

    static function makePlzPolyPointData($rs) {
        foreach ($rs as $data) {
            $js[] = array('label' => htmlentities($data['plzort99']), 'plz' => $data['plz99'], 'poly' => $data['the_geom']);
        }
        return json_encode($js);
    }

    static function makePlzSearchJSON($rs) {
        $result = '';
        foreach ($rs as $data) {
            /* @var $data <type> */
            /**
             * return {
              label:  item.formatted_address,
              value: item.formatted_address
              }
             */
            $js[] = array('label' => $data['plz99'] . " " . utf8_encode($data['plzort99']),
                'value' => $data['plz99']
            );
        }
        return json_encode($js);
    }

    static function makeGkzfSearchJSON($rs) {
        $result = '';
        foreach ($rs as $data) {
            /* @var $data <type> */
            /**
             * return {
              label:  item.formatted_address,
              value: item.formatted_address
              }
             */
            $js[] = array('label' => $data['Gemeindekennziffer'] . " " . utf8_encode($data['Ort']),
                'value' => $data['Gemeindekennziffer']
            );
        }
        return json_encode($js);
    }

    //makeDynamicSearchInputFieldJSON

    static function makeDynamicSearchInputFieldJSON($rs) {
        $result = '';
        foreach ($rs as $data) {
            /* @var $data <type> */
            /**
             * return {
              label:  item.formatted_address,
              value: item.formatted_address,
              latitude: item.geometry.location.lat(),
              longitude: item.geometry.location.lng()
              }
             */
            $js[] = array('label' => $data['PLZ'] . " " . utf8_encode($data['Ortsteil']),
                'value' => $data['PLZ'] . " " . utf8_encode($data['Ortsteil']),
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude']
            );
        }
        return json_encode($js);
    }

    static function makeDynamicSearchJSON($rs) {
        $result = '';
        if (GH::checkIfAdmin() == true) {
            foreach ($rs as $data) {
                /* @var $data <type> */
                /**
                 * 
                 * admin template
                  }
                 */
                if ($data['Leistungswert1'] == 0) {
                    $leistungswert1 = 'NA';
                } else {
                    $leistungswert1 = $data['Leistungswert1'];
                }
                $js[] = array('label' => $data['PLZ'] . " " . utf8_encode($data['Ortsteil']),
                    'value' => $data['PLZ'] . " " . utf8_encode($data['Ortsteil']),
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'id' => $data['count'],
                    'description' => utf8_encode($data['Standortbezeichnung']),
                    'plz' => $data['PLZ'],
                    'stellenart' => $data['Stellenart'],
                    'leistungswert1' => $leistungswert1,
                    'ortskennziffer' => $data['StatOrtskz'],
                    'preis' => $data['Preis'],
                    'beleuchtung' => $data['Beleuchtung'],
                    'standortnr' => $data['Standortnr'],
                    'belegdauerart' => $data['Belegdauerart'],
                    'bauart' => $data['Bauart'],
                    'hoehe' => $data['AbmessungenH'],
                    'breite' => $data['AbmessungenB'],
                    'aktiverstatus' => $data['AktiverStatus']
                );
            }
            //$js[] =  htmlentities($data['PLZ']." ".$data['Ortsteil'] );
        } else {
            foreach ($rs as $data) {
                /* @var $data <type> */
                /**
                 * user template
                 * hide certain values for anonymous/simple user
                 */
                if ($data['Leistungswert1'] == 0) {
                    $leistungswert1 = 'NA';
                } else {
                    $leistungswert1 = $data['Leistungswert1'];
                }
                if (GH::checkIfUser() != true)
                    $leistungswert1 = 'NA';
                $js[] = array('label' => $data['PLZ'] . " " . utf8_encode($data['Ortsteil']),
                    'value' => $data['PLZ'] . " " . utf8_encode($data['Ortsteil']),
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'id' => $data['count'],
                    'description' => utf8_encode($data['Standortbezeichnung']),
                    'plz' => $data['PLZ'],
                    'stellenart' => $data['Stellenart'],
                    'leistungswert1' => $leistungswert1,
                    'ortskennziffer' => 'NA',
                    'preis' => $data['Preis'],
                    'beleuchtung' => $data['Beleuchtung'],
                    'standortnr' => 'NA',
                    'belegdauerart' => $data['Belegdauerart'],
                    'bauart' => $data['Bauart'],
                    'hoehe' => $data['AbmessungenH'],
                    'breite' => $data['AbmessungenB'],
                    'aktiverstatus' => $data['AktiverStatus']
                );
            }
        }
        //print_r($js);
        return json_encode($js);
    }

    static function makeMapResultsDiv($rs) {
        $result = '';
        foreach ($rs as $data) {
            //$result .= ". ";

            /**
             * <div class="map-location" data-jmapping="{id: 1, point: {lng: -122.2678847, lat: 37.8574888}, category: 'market'}">
              <a href="#" class="map-link">Berkeley Bowl</a>
              <div class="info-box">
              <p>A great place to get all your groceries, especially fresh fruits and vegetables. <a href="#">Merkzettel</a></p>
              </div>
              </div>
             */
            $result .= "<div class=\"map-location " . $data['count'] . "\" s-class=\"" . $data['count'] . "\" data-jmapping=\"{id: " . $data['count']
                    . ", point: {lng: " . $data['longitude'] . ", lat: " . $data['latitude'] . "}, category: '" . $data['Beleuchtung'] . "'}\">"
                    . "<span class=\"ui-icon fff-icon-folder-add\" style=\"float: left\"></span>"
                    . "<span class=\"ui-icon fff-icon-" . substr($data['Stellenart'], 0, 2) . "\" style=\"float: left\"></span>"
                    . "<span class=\"ui-icon fff-icon-bullet-yellow\" style=\"float: left\" rel=\"" . $data['Preis'] . "\"></span>"
                    . "<span class=\"ui-icon fff-icon-tag-green\" style=\"float: left\" rel=\"" . $data['Leistungswert1'] . "\"></span>"
                    . "<span class=\"ui-icon fff-icon-arrow-refresh-small\" style=\"float: left\"" . " longitude=\"" . $data['longitude'] . "\" latitude=\"" . $data['latitude'] . "\"></span>"
                    . "<a href=\"#\" class=\"map-link " . $data['count'] . " " . $data['Beleuchtung'] . "\" PLZ=\"" . $data['PLZ']
                    . "\" description=\"" . $data['Standortbezeichnung'] . "\" "
                    . " longitude=\"" . $data['longitude'] . "\" latitude=\"" . $data['latitude'] . "\">"
                    . "<span class=\"ui-icon fff-icon-comment\" style=\"float: left\"></span>"
                    . $data['PLZ'] . " " . $data['Ortsteil'] . "</a>"
                    . "<div class=\"info-box " . $data['Beleuchtung'] . "\"><img src=\"img/120x120/" . $data['count'] . ".png\""
                    . " rel=\"" . $data['count'] . "\"/>"
                    . $data['PLZ'] . " " . $data['Ortsteil'] . " | " . $data['Beleuchtung'] . " | " . $data['Standortbezeichnung'] . " | " . $data['count'] . " | " . $data['Stellenart']
                    . "</div></div>";

            //$result .= $data['Standortnr'];
            //print_r($data);
        }
        //return $result;
        return 'noop.'; // since noone needs this result....
    }

    static function getXmlFile($file) {

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($file);
        $errors = libxml_get_errors();
        foreach ($errors as $error) {
            echo "<pre>" . self::display_xml_error($error, $xml) . "</pre>";
        }
        libxml_clear_errors();
        return $xml;
        ;
    }

    /*
     *
     * Helper f�r SimpleXML Fehlermeldungen .
     *
     */

    static function display_xml_error($error, $xml) {
        $return = "<div class='warning'>" . $xml[$error->line - 1] . "\n";
        $return .= str_repeat('-', $error->column) . "^\n";

        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "Warning $error->code: ";
                break;
            case LIBXML_ERR_ERROR:
                $return .= "Error $error->code: ";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "Fatal Error $error->code: ";
                break;
        }

        $return .= trim($error->message) .
                "\n  Line: $error->line" .
                "\n  Column: $error->column";

        if ($error->file) {
            $return .= "\n  File: $error->file";
        }

        return "$return\n\n--------------------------------------------\n\n</div>";
    }

    static function dumpObject($object) {
        var_dump(get_object_vars($object));
        var_dump(get_class_methods($object));
    }

    static function checkIfAdmin() {
        //var $role;
        try {
            if ($_SESSION['__default']['user']->usertype) {
                $role = $_SESSION['__default']['user']->usertype;

                switch ($role) {
                    case 'Super Administrator':
                        return true;
                        break;
                    case 'Administrator':
                        return true;
                        break;
                    case 'Manager':
                        return true;
                        break;
                }
            } else
                return false;
        } catch (Exception $exc) {
            // echo $exc->getTraceAsString();
            return false;
        }
    }

    static function checkIfUser() {
        //var $role;
        try {
            if ($_SESSION['__default']['user']->usertype) {
                $role = $_SESSION['__default']['user']->usertype;

                switch ($role) {
                    case 'User':
                        return true;
                        break;
                }
            } else
                return false;
        } catch (Exception $exc) {
            // echo $exc->getTraceAsString();
            return false;
        }
    }

}

?>