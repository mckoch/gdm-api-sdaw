<?php

/**
 * @name api.php
 * @package SDAW_Classes
 * @author mckoch - 14.04.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * SDAW Classes:api
 *
 *
 */
/**
 * <html><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
  <title>Testpage GoogleMaps % SDAW Integration</title>
  </head>
  <body>
 * <?php
 */

/**
 * Header falls erforderlich: HTTP-Aufruf oder include()
 */
//if (!headers_sent()){header('Content-Type: text/html;charset=windows-1252');}
define('included_from_api','included');
ini_set("memory_limit","512M");
require_once('/var/www/vhosts/default/htdocs/_ng/index.php');
//print_r($_SESSION['__default']['user']);

require_once('/srv/www/piwiktracker/PiwikTracker.php');
//PiwikTracker::$URL = 'http://joean-doe-media.de/_ng/';
$t = new PiwikTracker( $idSite = 1, 'http://joean-doe-media.de/api/tracker');
$t->setUrl( $url = 'http://joean-doe-media.de/api/api.php' );
$t->doTrackPageView('API V1 - parametrisierter Request');
if (!headers_sent()){header('Content-Type: text/html;charset=utf-8');}
require_once('application_2.ini.php');
require_once(INCLUDEDIR . 'apidispatcher.inc.php');

/**
 * ?></body>
 */