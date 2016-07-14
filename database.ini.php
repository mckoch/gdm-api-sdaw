<?php

/**
 * @name database.ini.php
 * @package SDAWSQL
 * @author mckoch - 23.12.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * SDAWSQL:database  
 *  initial file, contains user login for test environment*
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
define('SDAWDIR', '/var/www/vhosts/joean-doe-bonn.de/web_users/sdaw-upload/STA-DATEIEN/');
define('ARCHIVEDIR', '/srv/www/vhosts/gdm.joean-doe-media.de/httpdocs/sdaw/.archiv/');
define('OUTPUTDIR', '/srv/www/vhosts/gdm.joean-doe-media.de/httpdocs/sdaw/.outfiles/');
define('ORIGINAL_IMAGEPATH', '/var/www/vhosts/default/htdocs/sdaw.bilder/');

/*
 * Logindaten für Datenbank
 */
$GLOBALS['dbhost'] = '127.0.0.1';
$GLOBALS['dbuname'] = 'GDMMAINUPDATE';
$GLOBALS['dbpass'] = 'FsfVp7rIh493';
$GLOBALS['dbname'] = 'SDAWSQLdev';

/*
 * Includes
 */
require_once (INCLUDEDIR . 'ADODB/adodb.inc.php');
require_once (INCLUDEDIR . 'DBI.inc.php');
require_once(INCLUDEDIR . 'DISP.inc.php');
require_once(INCLUDEDIR . 'generalHelper.inc.php');
require_once(INCLUDEDIR . 'INIT.inc.php');
require_once(INCLUDEDIR . 'VERSION.inc.php');
require_once (INCLUDEDIR . 'exceptionErrorGeneric.inc.php');
?>
