<?php

/**
 * @name application.ini.php
 * @package SDAW
 * @author mckoch
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 *
 * Konfiguration für SDAW Klassenbibliothek
 *
 * beinhaltet Includes, Konstanten und globale Variablen
 * für Pfadangaben, Datenbank und Konfigurationsdateien
 * der SDAW-Klassen.
 *
 */

/**
 * Diagnostik: Laufzeit
 */
if (!isset($_SESSION['sessiontime'])) {$_SESSION['sessiontime'] = 0;}
$_SESSION['fullscriptstart'] = microtime(true); 

/*
 *  Pfade
 */
define('INCLUDEDIR', '/srv/www/vhosts/gdm.joean-doe-media.de/httpdocs/sdaw/include/');
define('DEFSDIR', '/srv/www/vhosts/gdm.joean-doe-media.de/httpdocs/sdaw/definitionfiles/');
define('SDAWDIR', '/srv/www/vhosts/gdm.joean-doe-media.de/httpdocs/sdaw/sdawfiles/');
define('ARCHIVEDIR', '/srv/www/vhosts/gdm.joean-doe-media.de/httpdocs/sdaw/.archiv/');
define('OUTPUTDIR', '/srv/www/vhosts/gdm.joean-doe-media.de/httpdocs/sdaw/.outfiles/');


/*
 * Logindaten für Datenbank
 */
$GLOBALS['dbhost'] = 'localhost';
$GLOBALS['dbuname'] = 'mckoch';
$GLOBALS['dbpass'] = 'luau+cia';
$GLOBALS['dbname'] = 'SDAWTEST';

/*
 * Includes
 */
require_once (INCLUDEDIR . 'ADODB/adodb.inc.php');
require_once (INCLUDEDIR . 'DBI.inc.php');
require_once(INCLUDEDIR . 'DISP.inc.php');
require_once(INCLUDEDIR . 'generalHelper.inc.php');
require_once(INCLUDEDIR . 'INIT.inc.php');
require_once (INCLUDEDIR . 'exceptionErrorGeneric.inc.php');
$oErr = new exceptionErrorHandler(false);

/*
 * Defs für Hilfstabellen
 */
$GLOBALS['StellenArtenFile'] = DEFSDIR . 'Stellenarten.xml';
?>