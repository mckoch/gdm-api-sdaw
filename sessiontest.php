<?php

/**
 * @name sessiontest.php
 * @package GDM_joean-doe_media
 * @author mckoch - 11.11.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * GDM_joean-doe_media:sessiontest
 *
 * 
 */
/*
 *     Options +FollowSymlinks
    RewriteEngine On
    RewriteCond %{QUERY_STRING} foo=(.+)
    RewriteRule ^grab/(.*) /%1/index.php?file=$1 [QSA]

*******************
 * ///RewriteCond %{QUERY_STRING} !Itemid=6
 * RewriteRule ^api.php api.php?Itemid=6 [QSA]
 * 
*******************
So a request for..

http://domain.com/grab/foobar.zip?level=5&foo=bar

is translated, server-side, into..

http://domain.com/bar/index.php?file=foobar.zip&level=5&foo=bar
 */


define('included_from_api','included');
require_once('/var/www/vhosts/default/htdocs/_ng/index.php');
error_reporting(E_ALL);
print "<pre>";
//var_dump($_SESSION);
//print_r($_SESSION);
print 'included_from_api = ' . included_from_api;
print "<hr>";
print($_SESSION['__default']['user']->username)."<br>";
print($_SESSION['__default']['user']->usertype)."<br>";
//print($_SESSION['__default']['user']->getParameters())."<br>";

//print_r(error_get_last());
print "<hr> \$_SESSION['__default']['user'] <br/>";
print_r($_SESSION['__default']['user']);
//print_r(get_class_methods('JUser'));
//print "<hr>";
//print_r(get_class_vars('JUser'));
//print "<hr>";
//print $JUser->username;
print_r(error_get_last());
print "<hr>";
print_r($_GET);

?>
