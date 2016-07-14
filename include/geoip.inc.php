<?php

/**
 * @name geoip.inc.php
 * @package GDM_joean-doe_media
 * @author mckoch - 19.01.2012
 * @copyright emcekah@gmail.com 2012
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * GDM_joean-doe_media:geoip
 * include file to get basic IP info for visit
 * more examples in /srv/www/GeoIP
 * 
 */
include("/srv/www/GeoIP/geoipcity.inc");
include("/srv/www/GeoIP/geoipregionvars.php");

$gi = geoip_open("/srv/www/GeoIP/GeoLiteCity.dat", GEOIP_STANDARD);
$ip = $_SERVER['REMOTE_ADDR'];
$record = geoip_record_by_addr($gi, $ip);

$vsrc = '';
$vsrc['ip'] = $ip;
$vsrc['country'] = $record->country_code;
$vsrc['region'] = $GEOIP_REGION_NAME[$record->country_code][$record->region];
$vsrc['city'] = $record->city;
$vsrc['lat'] = $record->latitude;
$vsrc['lng'] = $record->longitude;
geoip_close($gi);
?>