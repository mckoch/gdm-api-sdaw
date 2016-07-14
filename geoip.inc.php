<?php

// This code demonstrates how to lookup the country, region, city,
// postal code, latitude, and longitude by IP Address.
// It is designed to work with GeoIP/GeoLite City

// Note that you must download the New Format of GeoIP City (GEO-133).
// The old format (GEO-132) will not work.

include("/srv/www/GeoIP/geoipcity.inc");
include("/srv/www/GeoIP/geoipregionvars.php");

// uncomment for Shared Memory support
// geoip_load_shared_mem("/usr/local/share/GeoIP/GeoIPCity.dat");
// $gi = geoip_open("/usr/local/share/GeoIP/GeoIPCity.dat",GEOIP_SHARED_MEMORY);

$gi = geoip_open("/srv/www/GeoIP/GeoLiteCity.dat",GEOIP_STANDARD);
$ip = $_SERVER[REMOTE_ADDR];
$record = geoip_record_by_addr($gi,$ip);

$vsrc = '';
$vsrc['ip'] = $ip;
$vsrc['country'] = $record->country_code;
$vsrc['region'] = $GEOIP_REGION_NAME[$record->country_code][$record->region];
$vsrc['city'] = $record->city;
$vsrc['lat'] = $record->latitude; 
$vsrc['lng'] = $record->longitude;
/*
print $record->country_code . " " . $record->country_code3 . " " . $record->country_name . "<br/>";
print $record->region . " " . $GEOIP_REGION_NAME[$record->country_code][$record->region] . "<br/>";
print $record->city . "<br/>";
print $record->postal_code . "<br/>";
print $record->latitude . "<br/>";
print $record->longitude . "<br/>";
print $record->metro_code . "<br/>";
print $record->area_code . "<br/>";
print $record->continent_code . "<br/>";
*/
geoip_close($gi);
?>
