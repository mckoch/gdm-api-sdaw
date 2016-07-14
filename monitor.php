<?php

/**
 * @name monitor.php
 * @package GDM_joean-doe_media
 * @author mckoch - 15.12.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * GDM_joean-doe_media:monitor
 *
 * 
 */
define('included_from_api', 'included');
require_once('/var/www/vhosts/default/htdocs/_ng/index.php');
if (!$_SESSION['__default']['user']->username || !$_SESSION['__default']['user']->usertype){
    die;
}
?><html>
<head>
<script type="text/JavaScript">
<!--
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
//   -->
</script>
</head><body><pre>
<?php	
	error_reporting('E_ALL');
	/* general profilig code  */
	$dat = getrusage();
	$utime_before = $dat["ru_utime.tv_sec"].$dat["ru_utime.tv_usec"];
	$stime_before = $dat["ru_stime.tv_sec"].$dat["ru_stime.tv_usec"];
	///////////////////////////
	$refreshrate = 30000; //msec
	$noprocesses = 1;
	$topdelay = 0.1; //sec.msec
	$pid = getmypid();
	print '<body onload="JavaScript:timedRefresh('.$refreshrate.');">';

	//error_reporting(E_ALL);
	$vmversion = shell_exec('cat /proc/version');
	$loadavg = shell_exec('cat /proc/loadavg');
	// $mpuload = shell_exec('mpstat -P ALL');
	// $iostat = shell_exec('iostat');
	$netstat = shell_exec('netstat -i');
	$df = shell_exec('df -l');
        // $wwwlastlog = shell_exec('tail /var/log/apache2/error.log');
	print "<h3>system status ".$refreshrate." msec |".$noprocesses."| PID: ".$pid."</h3>load avg: ".$loadavg." || ";
	print shell_exec('top -b -n 1 | grep Cpu');
        $memory = shell_exec('free');
	print "<pre>".$memory.$mpuload.$iostat.$df.'<hr/>'.$netstat."</pre>";
	
	print "<hr>";		
	$wwwrundata = shell_exec('top -b -n '.$noprocesses.' -d '.$topdelay.' | grep www-data');
        // print $wwwrundata;
	// $wwwrundata = preg_replace('/\s\s+/', ' ', $wwwrundata);
	foreach( explode("\n",$wwwrundata) as $line) {print preg_replace('/\s\s+/', ' ', $line)."<br/>";}
	
	print "<hr>"; 
//        print $wwwlastlog;
//        print "<hr>"; 
	
	$mysqldata = shell_exec('top -b -n '.$noprocesses.' -d '.$topdelay.'| grep mysqld');
	//$mysqldata = preg_replace('/\s\s+/', ' ', $mysqldata);
	foreach( explode("\n",$mysqldata) as $line) {print preg_replace('/\s\s+/', ' ', $line)."<br/>";}
	$arraymysqldata = explode("\n",$mysqldata);
	foreach($arraymysqldata as $line){
		$mysqlrunlines[]=preg_replace('/\s\s+/', ' ', $line);
		}
	$mysqlrunlinescount = count($mysqlrunlines);
	//	print_r($arraymysqldata);
	//print "<hr>load avg: ";
	//print $loadavg;
	print "<hr>";
	
	$vmstat = shell_exec('cat /proc/vmstat'); 
	//$vmstat = preg_replace('/\s\s+/', ' ', $vmstat);
	foreach( explode("\n",$vmstat) as $line) {print preg_replace('/\s\s+/', ' ', $line)."; ";}
	//print "<hr>";
	print "<hr>";
	print $vmversion."<hr>PHP version: ".phpversion().", peak ".memory_get_peak_usage()." byte used. ";
	////////////////////////////////////////
	/* end profiling */
	$dat = getrusage();
	$utime_after = $dat["ru_utime.tv_sec"].$dat["ru_utime.tv_usec"];
	$stime_after = $dat["ru_stime.tv_sec"].$dat["ru_stime.tv_usec"];
	$utime_elapsed = ($utime_after - $utime_before);
	$stime_elapsed = ($stime_after - $stime_before);
	echo "Elapsed user time: $utime_elapsed µseconds";
	echo "Elapsed system time: $stime_elapsed µseconds";
	////////////////////////////////////////
	//phpinfo();	
	//print_r(getpidinfo(getmypid()));
	
	print "<hr>"; 
	 /* require_once('dev/DestillerV05/includes/sysinfo/linuxstats.class.php');
	 $status = new linuxstat;
	 print_r( $status->getCpuInfo());print "<hr>";
	 print_r( $status->getMemStat());print "<hr>";
	 print_r( $status->getProcesses());print "<hr>";
	 print_r($status->getProcessDetail(1)); */
 
?>
</body></html>