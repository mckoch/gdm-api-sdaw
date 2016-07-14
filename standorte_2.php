<?php
/**
 * @name standorte.php
 * @package GDM_joean-doe_media
 * @author mckoch - 25.11.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * GDM_joean-doe_media:standorte
 *
 *
 */
//if(!eregi($_SERVER["HTTP_HOST"], str_replace("www.", "", strtolower($_SERVER["HTTP_REFERER"])))) header("Location: http://www.joean-doe-media.de");
define('included_from_api', 'included');
ini_set("memory_limit", "512M");
require_once('/var/www/vhosts/default/htdocs/_ng/index.php');
// print_r($_SESSION['__default']['user']);
//require_once('include/html.pagecompressor.php');
?><!DOCTYPE HTML><html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Script-Type" content="text/javascript"/>

        <meta http-equiv="Copyright" content="joean-doe Media GmbH & Co. KG, Bonn"/>        
        <meta name="Description" content="Aus über 250.000 Werbetafeln an Standorten in ganz Deutschland auswählen und buchen. Werbung wo sie hingehört."/>        
        <meta name="keywords" content="Aussenwerbung, Buchen, Buchung, Plakate, Werbung, SDAW, GDM, joean-doe, Werbeflächen" />

        <meta http-equiv="web_author" content="Markus C. Koch, emcekah@gmail.com "/>
        <meta name="generator" content="GeoDataMapper V0.5"/>


        <title>Standortverzeichnis Au&szlig;enwerbung</title>


        <!--        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />-->
        <link type="text/css" href="css/gdm/custom.css" rel="stylesheet" />
        <link type="text/css" href="js/jquery.layout-default-latest.css" rel="stylesheet"/>
        <link type="text/css" href="css/ui-icon/css/fff.icon.core.css" rel="stylesheet" />
        <link type="text/css" href="css/ui-icon/css/fff.icon.icons.application_2.css" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" media="screen" href="js/ui.multiselect.css" />
        <link type="text/css" href="js/jquery.datatables.css" rel="stylesheet"/>
        <!--        <link type="text/css" href="js/jquery.dataTables_themeroller.css" rel="stylesheet"/>-->
        <link type="text/css" href="js/colorbox.css" rel="stylesheet"/>
        <link type="text/css" href="js/jquery.jscrollpane.css" rel="stylesheet" media="all" />
        <link type="text/css" href="js/fullcalendar.css" rel="stylesheet" />
        <link type="text/css" href="js/ColVis.css" rel="stylesheet"/>
        <link type="text/css" href="js/jquery.qtip.css" rel="stylesheet"/>
        <link type="text/css" href="js/jquery.message.css" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="js/jquery.jqplot.css" />



        <!--        <link type="text/css" href="min/g=public_css_2" rel="stylesheet"/>-->


        <style type="text/css">

            body {overflow:  hidden; background: #3d4897;}

            p#vtip { display: none; position: absolute; padding: 10px; right: 5px; font-family:Tahoma, Arial, sans-serif;font-size: 0.9em; background-color: white; border: 1px solid #a6c9e2; -moz-border-radius: 5px; -webkit-border-radius: 5px; z-index: 999999; max-width: 222px; }
            p#vtip #vtipArrow { position: absolute; top: -10px; left: 5px }

            ul.ui-multiselect-checkboxes {overflow-y: scroll;}
            #Placesfilter select option img {height: 12px;}
            #common select {width:340px;z-index: 10000}

            .loading {
                background: #FFC129;
                background-image: url('/templates/joean-doe/img/navi_active_bg.png');
                color: #333333;
                font-weight: normal;
                padding: 3px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                font-family: TrebuchetMS,Tahoma,Verdana,Arial,sans-serif;
            }

            #repositoryTable td, #taggedRepositoryTable, #timeResultsTable td td { white-space: nowrap; }
            #repositoryTable td img,  #taggedRepositoryTable td img, #timeResultsTable td td img {height: 12px}

            div.infobubble a.ui-widget {padding: 3px; margin-top: 12px;}


            .contextmenu{
                visibility:hidden;
                background:#ffffff;
                border:0px solid #8888FF;
                z-index: 10;
                position: relative;
                width: 250px;
            }
            .contextmenu a{
                padding: 0px;
                width: 250px;
                font-size: 10px;
            }
            /*
            .contextmenu a:link {
                color: #6699cc;
            }
            .contextmenu a:visited {
                color: #666699;
            }
            .contextmenu a:hover {
                color: #693;
                cursor: pointer;
            }
            .contextmenu a:active {
                color: #cc3333;
                text-decoration: none;
            }*/

            .dataTables_filter {
                float: right;
                text-align: right;
            }

            #checkOutForm label.error {
                margin-left: 10px;
                width: auto;
                display: inline;
                float: none;
                color: lightcoral;
            }

            .buttonbar{padding: 5px; text-align: right;}

            ul#tablist li, ul#kalendertabslist li, ul#filtertabslist li {float:right;}

            .ui-dialog .ui-dialog-titlebar {
                padding: 0 0;
                position: relative;
            }

            .opaque {opacity: .9}

            #repositoryTable tbody tr.even:hover, #repositoryTable tbody tr.even td.highlighted {
                background-color: #ECFFB3;
            }

            #repositoryTable tbody tr.odd:hover, #repositoryTable tbody tr.odd td.highlighted {
                background-color: #E6FF99;
            }

            _row #repositoryTable tr.even:hover {
                background-color: #ECFFB3;
            }

            _row #repositoryTable tr.even:hover td.sorting_1 {
                background-color: #DDFF75;
            }

            _row #repositoryTable tr.even:hover td.sorting_2 {
                background-color: #E7FF9E;
            }

            _row #repositoryTable tr.even:hover td.sorting_3 {
                background-color: #E2FF89;
            }

            _row #repositoryTable tr.odd:hover {
                background-color: #E6FF99;
            }

            _row #repositoryTable tr.odd:hover td.sorting_1 {
                background-color: #D6FF5C;
            }

            _row #repositoryTable tr.odd:hover td.sorting_2 {
                background-color: #E0FF84;
            }

            _row #repositoryTable tr.odd:hover td.sorting_3 {
                background-color: #DBFF70;
            }

            #taggedRepositoryTable tbody tr.even:hover, #taggedRepositoryTable tbody tr.even td.highlighted {
                background-color: #ECFFB3;
            }

            #taggedRepositoryTable tbody tr.odd:hover, #taggedRepositoryTable tbody tr.odd td.highlighted {
                background-color: #E6FF99;
            }

            _row #taggedRepositoryTable tr.even:hover {
                background-color: #ECFFB3;
            }

            _row #taggedRepositoryTable tr.even:hover td.sorting_1 {
                background-color: #DDFF75;
            }

            _row #taggedRepositoryTable tr.even:hover td.sorting_2 {
                background-color: #E7FF9E;
            }

            _row #taggedRepositoryTable tr.even:hover td.sorting_3 {
                background-color: #E2FF89;
            }

            _row #taggedRepositoryTable tr.odd:hover {
                background-color: #E6FF99;
            }

            _row #taggedRepositoryTable tr.odd:hover td.sorting_1 {
                background-color: #D6FF5C;
            }

            _row #taggedRepositoryTable tr.odd:hover td.sorting_2 {
                background-color: #E0FF84;
            }

            _row #taggedRepositoryTable tr.odd:hover td.sorting_3 {
                background-color: #DBFF70;
            }

            #timeResultsTable tbody tr.even:hover, #timeResultsTable tbody tr.even td.highlighted {
                background-color: #ECFFB3;
            }

            #timeResultsTable tbody tr.odd:hover, #timeResultsTable tbody tr.odd td.highlighted {
                background-color: #E6FF99;
            }

            _row #timeResultsTable tr.even:hover {
                background-color: #ECFFB3;
            }

            _row #timeResultsTable tr.even:hover td.sorting_1 {
                background-color: #DDFF75;
            }

            _row #timeResultsTable tr.even:hover td.sorting_2 {
                background-color: #E7FF9E;
            }

            _row #timeResultsTable tr.even:hover td.sorting_3 {
                background-color: #E2FF89;
            }

            _row #timeResultsTable tr.odd:hover {
                background-color: #E6FF99;
            }

            _row #timeResultsTable tr.odd:hover td.sorting_1 {
                background-color: #D6FF5C;
            }

            _row #timeResultsTable tr.odd:hover td.sorting_2 {
                background-color: #E0FF84;
            }

            _row #timeResultsTable tr.odd:hover td.sorting_3 {
                background-color: #DBFF70;
            }


            .blockA, .A{padding: .1em; background-color: #ffff99}
            .blockB, .B{padding: .1em; background-color: #B6ECEC}
            .blockC, .C{padding: .1em; background-color: #CFF5A8}
            .fc-cell-overlay {
                background: none repeat scroll 0 0 #990244;
                opacity: 0.2;
            }
            #monatskalender .ui-state-active {padding: 0.1em;}
            .fc-grid .fc-day-number {
                background: none repeat scroll 0 0 silver;
                float: left;
                padding: 0 2px;
            }
            .fc-grid .fc-day-content {
                clear: both;
                margin-bottom: 2em;
                padding: 2px 2px 1px;
            }

            .ui-dialog-titlebar {
                height: 10px;
                padding: 0;
                position: relative;
            }

            #maindialog.ui-dialog {
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 98%;
                margin-top: 55px;
            }
            #gdmlogo.ui-dialog {
                overflow: hidden;
                padding: 0;
                position: relative;
            }

            div#timeinputs form {padding: 5px;}
            div#timeinputs form input {margin: 5px;}

            .ui-layout-toggler-east{
                width:	38px !important;
                height:	135px !important; 
                background: url(button-east-pane.png);

                position: absolute !important;
                left: -25px !important;
                z-index: 2222 !important;
                opacity: 1 !important;
            }

            .ui-layout-resizer-east{
                /*		width:	38px !important;*/
                /*		height:	135px; 
                                background: blueviolet;*/
                overflow: visible !important;
                z-index: 22 !important;
                background: #3d4897;
            }

            .ui-layout-toggler-south{
                background: blue !important;   
            }
            .ui-layout-resizer-south{
                background: #3d4897 !important;   
            }
            .ui-layout-south {
                background: #3d4897;
            }

            #maindialog_center .jspContainer {width: 530px !important;}
            #maindialog_center_scroller img {margin-left: -208px; margin-top: -2px;}
            .content_right, .content_left, .boxes_bg, .contentarea {background:#3d4897; color: #ffffee;}

            .slides_container {
                width:520px;
                height:480px;
                overflow: hidden
            }
            .slides_container div {
                width:520px;
                height:480px;
                display:block;
                overflow: hidden
            }

            .jspArrowUp {
                background-image: url('css/ui-icon/ico/bullet_arrow_up.png') !important;
            }

            .jspArrowDown {
                background-image: url('css/ui-icon/ico/bullet_arrow_down.png') !important;
            }
            .jspArrowLeft {
                background-image: url('css/ui-icon/ico/bullet_arrow_left.png') !important;
            }
            .jspArrowRight {
                background-image: url('css/ui-icon/ico/bullet_arrow_right.png') !important;
            }




        </style>

<!--        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=places&sensor=false"></script>
        <script type="text/javascript">var SessionUser='<?php print $_SESSION['__default']['user']->username; ?>';var SessionUserRole = '<?php print $_SESSION['__default']['user']->usertype; ?>';var SessionUserEmail = '<?php print $_SESSION['__default']['user']->email; ?>';var SessionUserPass = '<?php print $_SESSION['__default']['user']->password; ?>';</script>


        <script type="text/javascript" src="js/markerClusterer.js"></script>
        <script type="text/javascript" src="js/progressBar.js"></script>
        <script type="text/javascript" src="js/infobubble.js"></script>
        <script type="text/javascript" src="js/maplabel.js"></script>
        <script type="text/javascript" src="js/RouteBoxer.js"></script>
        <script type="text/javascript" src="js/keydragzoom.js"></script>

        <script type="text/javascript" src="js/date.de-DE.js"></script>
        <script type="text/javascript" src="js/jquery-1.5.2.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>

        <script type="text/javascript" src="js/jquery.layout-latest.js"></script>
        <script type="text/javascript" src="js/jquery.json-2.2.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.js"></script>
<!--        <script type="text/javascript" src="js/TableTools.js"></script>-->
        <script type="text/javascript" src="js/ColVis.js"></script>

        <script type="text/javascript" src="js/jquery.clearfield.js"></script>

        <script type="text/javascript" src="js/jquery.qtip.js"></script>
        <script type="text/javascript" src="js/jquery.dialogextend.js"></script>
        <script type="text/javascript" src="js/jquery.pulse.js"></script>
        <script type="text/javascript" src="js/jquery.color.js"></script>


        <script type="text/javascript" src="js/jquery.jscrollpane.js"></script>
        <script type="text/javascript" src="js/jquery.multiselect.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/jquery.tinysort.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.Storage.js"></script>
        <script type="text/javascript" src="js/jquery.loading.1.6.3.js"></script>
        <script type="text/javascript" src="js/jquery.colorbox.js"></script>
        <script type="text/javascript" src="js/jquery.taconite.js"></script>
        <script type="text/javascript" src="js/jquery.message.js"></script>

        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/additional-methods.js"></script>
        <script type="text/javascript" src="js/fullcalendar.js"></script>

        <script type="text/javascript" src="js/jquery.jqplot.js"></script>
        <script type="text/javascript" src="js/jqplot.barRenderer.js"></script>
        <script type="text/javascript" src="js/jqplot.highlighter.js"></script>
        <script type="text/javascript" src="js/jqplot.categoryAxisRenderer.js"></script> 
        <script type="text/javascript" src="js/jqplot.lgxisRenderer.js"></script>

        <script type="text/javascript" src="js/slides.jquery.js"></script>
        <script type="text/javascript" src="js/jquery.timer.js"></script>
        <script type="text/javascript" src="js/jquery.colorize-1.7.0.js"></script>


        <style>
            /*#tabs { height: 200px; } */
            .tabs-bottom { position: relative; } 
            .tabs-bottom .ui-tabs-panel { height: 140px; overflow: auto; } 
            .tabs-bottom .ui-tabs-nav { position: absolute !important; left: 0; bottom: 0; right:0; padding: 0 0.2em 0.2em 0; } 
            .tabs-bottom .ui-tabs-nav li { margin-top: -2px !important; margin-bottom: 1px !important; border-top: none; border-bottom-width: 1px; }
            .ui-tabs-selected { margin-top: -3px !important; }
            .ui-layout-east {background: none repeat scroll 0 0 #3d4897}
            div#slides, div#slides_container{padding: 0; margin: 0;}
            .ui-dialog .ui-dialog-content {padding: 0}
        </style>
        <?php
        require_once('database.ini.php');
        $vsrc = GH::getVisitorInfo();
        $mylat = $vsrc['lat'];
        $mylng = $vsrc['lng'];
        $mycity = $vsrc['city'];
        $mycountry = $vsrc['country'];
        // $dbinfo = new DBI();
        // $stacount = $dbinfo->checkNumberOfRecords('STA');
        // $frecount = $dbinfo->checkNumberOfRecords('FRE_FREIE_TAFELN');
        ?>
        <script type="text/javascript">
            var startLat = <?php print $mylat ?>;
            var startLng = <?php print $mylng ?>;    
            var startCity = '<?php print $mycity ?>';  
            var startCountry = '<?php print $mycountry ?>';  
        </script>
        <script type="text/javascript">
<?php
include('include/javascript.onload_2.js');
?>
        </script>

<!--         <script type="text/javascript" src="min/g=public_js_2"></script>-->

        <?php
        include('include/googletracking.inc.php');
        ?>


    </head>
    <body>
        <div id="loader" style="width: 100%; height: 100%; z-index: 100000; position: absolute; top:0; left:0; text-align: center; background: #3d4897 !important"  class="ui-state-active">
            <!--<div id="innerloader" style="z-index: 100000000; background: url('headerbox.png'); 
            position: absolute; top: 0; left:0; width:100%;height: 240px; margin-left: auto;margin-right: auto; opacity: .73; background-position: center top; background-repeat: no-repeat;">                
            </div>-->
            <div id="gdmlogo" class="ui-corner-all ui-dialog ui-widget ui-widget-content" style="text-align: center;  width:60%; margin-top: 22%;margin-left: auto;margin-right: auto; opacity: .8; color: #ffffee;background: #3d4897 !important">
<!--                <img src="ui-anim_basic_16x16.gif" style="float: right"/> -->
                <img style="float: none; margin:5px;border:0;  margin-left: auto; margin-right: auto;" src="gisa_clm.jpg"/>
                <div id="loaderProgressBar" style="width: 100%; float: none;"></div>

<!--<img style="float: none; margin:0;border:0;" src="banner.png"/> -->
<!--                <h2 style ="padding: 1em; border: 0 solid silver; color: #ffffee;">Werbung wo sie hingeh&ouml;rt - aus <?php print $stacount; ?> Werbetafeln und <?php print $frecount; ?> freien Terminen in ganz Deutschland auswählen.</h2>-->
                <img style="float: left; margin:5px;border:0;" src="geova_logo.jpg"/>
                <img style="float: right; margin:5px;border:0;" src="gdmlogo01.png"/>
                <em>GDM GeoDataMapper - das Expertentool f&uuml;r Geomarketing &amp; Au&szlig;enwerbung</em>
                <h3 style="text-align: center;">Version 0.9 beta 1</h3>
                <p>Standort ihres Internetzugangs: <?php print $mycountry . ' ' . $mycity; ?><br/>lade Anwendung...</p>

            </div>
        </div>
        <!--        <div class="ui-layout-north">
                    <img src="banner.png" style ="float: none; margin:0;border:0; height: 18px; "/> GDM 0.4 - &ouml;ffentliches Standortverzeichnis
                </div>-->
        <div class="ui-layout-center"  style="padding:0; margin:0;">
            <div id="map_canvas" style="width: 100%; height: 100%; margin:0; background:#3d4897;"  class="ui-state-default">
            </div>
        </div>
        <div class="ui-layout-east" style="no_background: url(text54269679.png)">
            <img src="joean-doe-media-minilogo.png" style="height:60px; float: left; margin: 0"/>
            <!--            <div id="headermessage" class="ui-widget" style="text-align:left"><h2 class="ui-widget ui-widget-content ui-widget-header">Werbetafeln suchen</h2></div>-->
            <div id="suchdialog" class="ui-corner ui-corner-all ui-widget ui-widget-content ui-corner-all" style="padding: 5px; overflow: hidden;">

                <input class="vtip button" title="Anzahl geladener Stellen. Klick l&ouml;scht den aktuellen Speicher." type="button" id="markercounter" value="0" onclick="clearClusterer();"/>
                <span id="mapoptions" class="ui-corner ui-corner-all ui-widget ui-widget-content ui-corner-all" style="width: 280px; overflow:hidden;">
                    <input id="append" type="checkbox" name="append" value="append" checked="checked"/>
                    <label id="labelforappend" class="vtip ui-icon fff-icon-image-add" title="Append-Modus: wenn aktiv weren die Ergebnisse neuer Suchen hinzugef&uuml;gt. Wenn deaktiviert werden vorhandene Ergebnisse gel&ouml;scht." for="append">APP</label>

                    <input type="checkbox" id="addressUmkreisSuche" value="" class="button" checked="checked"  />
                    <label id="labelforaddressUmkreisSuche" class="vtip ui-icon fff-icon-arrow-refresh"  title="Sofort nach erfolreicher Geokodierung eine Umkreissuche mit eigestelltem Radius durchf&uuml;hren" 
                           for="addressUmkreisSuche">U</label>


                    <input id="applyplaces" type="checkbox" name="applyplaces" value="applyplaces" />
                    <label id="labelforapplyplaces" class="vtip ui-icon fff-icon-photos" title="Places anzeigen und in n&auml;chste Suche einbeziehen" for="applyplaces">PLC</label>


                    <input type="checkbox" id="visibleMarkers" value="" class="button"/>
                    <label id="labelforvisiblemarkers" class="vtip ui-icon fff-icon-table-relationship"  title="Tabelle mit Ausschnitt in der Hauptkarte synchronisieren." 
                           for="visibleMarkers">VM</label>

                    <input type="checkbox" id="timeFilterActive" value="" class="button" />
                    <label id="labelfortimeFilterActive" class="vtip ui-icon fff-icon-time-add"  title="Zeitfilter für  Standortsuchen aktivieren / deaktivieren." 
                           for="timeFilterActive">TF</label>

                    <input type="checkbox" id="tablesVisible" value="" class="button" />
                    <label class="vtip ui-icon fff-icon-application-view-list"  title="Tabellenfenster anzeigen / verbergen." 
                           for="tablesVisible" id="tablesVisibleLabel">TF</label>

                    <input type="checkbox" id="showGeoVa" checked value="" class="button" />
                    <label class="vtip ui-icon fff-icon-geova"  title="GeoVA - klicken für mehr Information!<br/><img src='geova_logo.jpg' style='width: '/>" 
                           for="showGeoVa" id="tablesVisibleLabel">GeoVA</label>

                    <input type="checkbox" id="showStats" checked value="" class="button" />
                    <label class="vtip ui-icon fff-icon-shape-align-bottom"  title="Statitistikfenster anzeigen / verbergen." 
                           for="showStats" id="showStatsLabel">Statistik</label>
                </span>
                <input class="vtip button" title="Anzahl sichtbarer Stellen. Klick zoomt in die Übersicht aller geladenen Stellen." type="button" id="visibleMarkersCounter" value="0" onclick="google.maps.event.trigger(map, 'bounds_changed');"/>

                <input type="button" value="0" class="vtip button" title="Umkreissuche relativ zum aktuellen Mittelpunkt der Hauptkarte mit gew&auml;hltem Radius durchf&uuml;hren und anzeigen (Haptkarte)." id="zoom" class="ui-state-default" style="width:70px; "/>

                <span id="taggedReload" onclick="loadLastRepositoryToMap();" class="button"><span class=" ui-icon fff-icon-cancel"></span>Aktualiseren</span>
<!--                        <input class="vtip button" title="Zur Kalender-Auswahl" type="button" id="openCalendar" value="Freizahlen-Modul öffnen" 
                       onclick="$.colorbox({href: 'http://www.joean-doe-media.de/api/freizahlen.php', iframe: true, opacity: 0.65, width:'100%', height:'100%', title: 'Freizahlen 2013', close: 'Schließen', onClosed: updateMapFromStorage});return false;"
                       style="width: 190px;"/>-->

                <span id="taggedCheckOut" class="vtip button" title="
                      <span class='ui-icon fff-icon-cart' style='float:left;margin:1em;'></span>
                      markierte Tafeln zu gewählten Zeiträumen buchen (Checkout)."
                      style="height: 28px;" onclick="angebotBerechnen();">
                    <span id="taggedCheckOutLabel" class=" ui-icon fff-icon-tick" ></span>
                    <span class="taggedcounter"> </span>

                </span>


                <!--                
                                <a href="javascript:void(window.open('http://joean-doe-media.de/support/chat.php','','width=590,height=610,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))"><img src="http://joean-doe-media.de/support/image.php?id=06&amp;type=inlay" height="14" border="0" alt="LiveZilla Live Help" title="Persönliche Unterstützung anfordern oder eine Frage stellen / Kontakt aufnehmen." class="vtip button"></a> http://www.LiveZilla.net Chat Button Link Code  LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) <div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">
                                    var script = document.createElement("script");script.type="text/javascript";var src = "http://joean-doe-media.de/support/server.php?request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><noscript><img src="http://joean-doe-media.de/support/server.php?request=track&amp;output=nojcrpt" width="0" height="0" style="visibility:hidden;" alt=""></noscript> http://www.LiveZilla.net Tracking Code 
                -->


                <input type="text" id="address" value="Umkreissuche: bitte einen Standort eingeben" class="vtip ui-state-default clearfield" style="width: 240px; float: right;"
                       title="Geokodierung und Umkreissuche: Adresse, Bezeichnung oder Koordinaten eingeben.<br/>Zeigt nach Verschieben der Hauptkarte den Kartenmittelpunkt."/>


            </div>


            <div id="maindialog" class="ui-corner ui-corner-all ui-widget ui-widget-content" style="height:85%; width: 95%; overflow:hidden; background: #3d4897">
                <div id="maindialog_center" class="ui-layout-center"  class="ui-corner ui-corner-all" style="width: 100%; height: 100%; overflow:hidden; background: #3d4897; border: 0px; ">
                    <div id="maindialog_center_scroller"  style="height:100%;width: 100%; background: #3d4897" class="ui-widget-content">

                    </div>
                </div>
                <div id="maindialog_south" class="ui-layout-south" style="overflow:hidden; background: #3d4897; border: 0px !important">
                    <img src="gdmlogo01.png" id="gdmcopyrightlogostart" class="vtip"title="GDM GeoDataMapper - &copy; 2013 Markus Christian Koch emcekah@gmail.com. Lizensiert f&uuml;r http://joean-doe-media.de." style="float: right; width: 40px; border:0px; margin: 0px"/>
                    <!--                    <a class="doclink button vtip" title="NEU: Video-Tutorial: der 5-Minuten Schnelleinstieg in GeoDataMapper im Geoinformationssystem Außenwerbung!" href="/_ng/index.php?option=com_content&view=article&id=19&Itemid=17">Tutorial</a>
                                        <a class="doclink button" href="/_ng/index.php?option=com_content&view=category&layout=blog&id=1&Itemid=17">GDM Hilfe</a>
                                        <a class="doclink button" href="/werbetraeger-formate.html">Formate</a>
                                        <a class="doclink button" href="/hilfe.html">Lexikon</a>-->
                    <a class="doclink button" href="/kontakt.html">Kontakt</a>
                    <!--                    <a class="doclink button" href="/api/images/slides/frontslides.php">?</a>-->
                    <a class="doclink button" href="/_ng/index.php?option=com_content&view=article&id=21&Itemid=17">Info</a>
                    <!--                    <a class="doclink button" href="/impressum.html">Impressum</a>-->
                </div>
                <span id="tabsouter">
                    <div id="tabs" style="float: right; width: 100%; height: 100%; background: #ffffff;" class="ui-widget">
                        <ul id="tablist">
                            <li class="vtip" title="Suchen / Auswahl"><a href="#common"><span id="geo_icon" class="ui-icon fff-icon-zoom" style="float:left"></span></a></li> 
                            <li class="vtip" title="gefundene Tafeln"><a href="#masterlist"><span id="masterlist_icon" class="ui-icon fff-icon-arrow-refresh" style="float:left"></span> Tafeln</a></li>
                            <li class="vtip" title="Merkzettel"><a href="#merkzettelouter"><span id="merkzettelouter_icon" class="ui-icon fff-icon-cart" style="float:left"></span> Merkliste (<span class="taggedcounter"> </span>)</a></li>
                            <!--                        <li class="vtip" title="TEMPORÄR SICHTBAR"><a href="#formtoolsouter"></a></li>-->
<!--                            <li class="vtip" title="Checkout: markierte Tafeln anfragen"><a href="#CHECKOUT"><span class=" ui-icon fff-icon-tick" style="float:left"></span></a></li>-->
                            <li class="vtip" title="Freizahlen für gefundene Tafeln abfragen, Datumsfilter erstellen"><a href="#kalenderplanung"><span class="ui-icon fff-icon-time-add" style="float:left"></span></a></li>
                        </ul>

                        <div id="common">
                            <!--                        <h2>Tab 0</h2>
                                                    <ul>
                                                        <li>Combo-Dropdown Standorte Typen</li>-->
                            <!-- START INNER TAB -->
                            <div id="filtertabs">
                                <ul id="filtertabslist">
                                    <li><a href="#setfilters" class="vtip" title="Erweiterte Sucheinstellungen (Stellenarten, Placeskategorien) und zusätzliche Suchen">Suchoptionen</a></li>
                                    <li><a href="#routenplanung" class="vtip" title="Werberoutenplaner: Tafeln entlang einer Route suchen">Routenplaner</a></li>
                                </ul>
                                <div id="setfilters">
                                    <div class="ui-widget-content" style="padding: 5px;">
                                        <form id="Stellenartenfilter" name="Stellenartenfilter"  class="vtip" title="Eine oder mehrere Stellenarten und/oder Kennzeichen auswählen" >
                                            <input class="vtip button" title="Aktuellen Ausschnitt nach Stellen durchsuchen" type="button" style="float:right;"
                                                   id="RECTSRCH" onclick="apiRequest('bounds',map.getBounds());" value="Ausschnittssuche"/>

                                            <label for="stellenarten-optgroup">Stellen-/Werbeträgerarten auswählen</label>
                                            <br/>
                                            <select name="stellenarten-optgroup" multiple="multiple">
                                                <optgroup label="Beleuchtung">
                                                    <option selected value="B" >Beleuchtet</option>
                                                    <option selected value="U">Unbeleuchtet</option>
                                                    <option selected value="H">Hintergrund beleuchtet</option>
                                                    <option selected value="R">Rahmen beleuchtet</option>
                                                </optgroup>

                                                <optgroup label="Hauptstellenarten">
                                                    <option selected value="AL" >AL,Allgemeiner Anschlag</option>
                                                    <option selected value="VI" >VI,joean-doeposter</option>
                                                    <option selected value="GZ" >GZ,Ganzstellen</option>
                                                    <option selected value="SZ" >SZ,Stretchsäule</option>
                                                    <option selected value="GF" >GF,Großflächen</option>
                                                    <option selected value="PB" >PB,Premium Billboard</option>
                                                    <option selected value="SB" >SB,StretchBoard</option>
                                                    <option selected value="SO" >SO,Sonstiges</option>
                                                    <option selected value="GV" >GV,18/1 Vitrinen</option>
                                                    <option selected value="SG" >SG,Sondergroßflächen</option>
                                                    <option selected value="SP" >SP,Superposter</option>
                                                    <option selected value="K4" >K4,Kleinflächen (4/1)</option>
                                                    <option selected value="K6" >K6,Kleinflächen (6/1)</option>
                                                    <option selected value="EM" >EM,Elektronische Medien</option>
                                                    <option selected value="PF" >PF,Panoramaflächen (36/1)</option>
                                                </optgroup>
                                            </select>
                                        </form>

                                        <form id="Unterstellenartenfilter" name="Unterstellenartenfilter"  >
                                            <select name="unterstellenarten-optgroup" multiple="multiple" >
                                                <optgroup label="Unterstellenarten">
                                                    <option selected value="ST" >Standard ST</option>
                                                    <option value="BU" >U-Bahn BU</option>
                                                    <option value="BS" >S-Bahn BS</option>
                                                    <option value="BX" >Bahn-Sonstige BX</option>
                                                    <option value="WH" >Wartehalle WH</option>
                                                    <option value="BF" >Bahnhof BF</option>
                                                    <option value="WR" >Wechselrahmen WR</option>
                                                    <option value="AR" >Wechselrahmen Rolltreppe AR</option>
                                                    <option value="PR" >Wechsler PR</option>
                                                    <option value="PH" >Parkhaus PH</option>
                                                    <option value="EK" >EKZ EK</option>
                                                    <option value="PO" >Point of Sale (auch Kino) PO</option>
                                                    <option value="FH" >Flughafen FH</option>
                                                    <option value="IN" >Stadtinformationsanlagen IN</option>
                                                    <option value="PW" >Prismenwender PW</option>
                                                    <option value="QA" >Qualitäts-GF QA</option>
                                                    <option value="SE" >Standard, die auf EKZ-Märkte wirken SE</option>
                                                    <option value="ES" >EKZ, die als Standardstellen wirken ES</option>
                                                    <option value="EM" >Elektronische Medien EM</option>
                                                    <option value="CI" >Citystar CI</option>
                                                    <option value="US" >Uhrensäulen US</option>
                                                    <option value="G8" >Ganzstelle 8/1 (hinterleuchtet) G8</option>
                                                    <option value="GL" >Ganzstelle Lichtsäule GL</option>
                                                    <option value="SL" >StretchSäule (hinterleuchtet) SL</option>
                                                    <option value="ZZ" >Nicht zugeordnet ZZ</option>
                                                </optgroup>
                                            </select>
                                        </form>


                                        <!--                            <li>Eingabefeld GeoCoder Umkreissuche</li>-->

                                        <br />
                                        <!--                            <li>Slider Umkreis</li>
                                                                    <li>Slider Clusterzoom</li>
                                                                    <li>Button Ausschnittssuche</li>
                                                                    <li>Checkbox + Button (?) Common Places</li>
                                        
                                        
                                                                    <li>Combo Places Typen</li>-->

                                        <form id="Placesfilter" class="vtip" title="Kategorien für Places auswählen (maximal 3 empfohlen)">
                                            <input class="vtip button" title="Aktuellen Kartenausschnitt mit Places durchsuchen und markieren" type="button" 
                                                   style="float:right;" id="RECTPLCS" value="Ausschnittssuche" onclick="getPlacesByBounds(map.getBounds());"/>
                                            <label for="placesfilter-optgroup">Places-Kategorien (max. 3 auswählen)</label>
                                            <br/>
                                            <select name="placesfilter-optgroup" multiple="multiple">
                                                <optgroup label="Kategorien">
                                                    <option value="accounting">Buchhaltung</option>
                                                    <option value="airport">Flughafen</option>
                                                    <option value="amusement_park">Freizeitpark</option>
                                                    <option value="aquarium">Aquarium</option>
                                                    <option value="art_gallery">Galerie</option>
                                                    <option value="atm">Geldautomat</option>
                                                    <option value="bakery">B&auml;ckerei</option>
                                                    <option value="bank">Bank</option>
                                                    <option value="bar">Gastst&auml;tte</option>
                                                    <option value="beauty_salon">Kosmetiksalon</option>
                                                    <option value="bicycle_store">Fahrradhandel</option>
                                                    <option value="book_store">Buchhandel</option>
                                                    <option value="bowling_alley">Bowling-Bahn</option>
                                                    <option value="bus_station">Bushaltestelle</option>
                                                    <option value="cafe">Cafe</option>
                                                    <option value="campground">Camping</option>
                                                    <option value="car_dealer">Autohandel</option>
                                                    <option value="car_rental">Autovermietung</option>
                                                    <option value="car_repair">Autoreparatur</option>
                                                    <option value="car_wash">Waschanlage</option>
                                                    <option value="casino">Casino</option>
                                                    <option value="cemetery">Friedhof</option>
                                                    <option value="church">Kirche</option>
                                                    <option value="city_hall">Rathaus</option>
                                                    <option value="clothing_store">Bekleidung</option>
                                                    <option value="convenience_store">Convenience-Store</option>
                                                    <option value="courthouse">Gericht</option>
                                                    <option value="dentist">Zahnarzt</option>
                                                    <option value="department_store">Kaufhaus</option>
                                                    <option value="doctor">Arzt</option>
                                                    <option value="electrician">Elektriker</option>
                                                    <option value="electronics_store">Elektronik-Handel</option>
                                                    <option value="embassy">Botschaft</option>
                                                    <option disabled value="establishment">Unternehmen (leer)</option>
                                                    <option value="finance">Finanzen</option>
                                                    <option value="fire_station">Feuerwehr</option>
                                                    <option value="florist">Florist</option>
                                                    <option value="food">Essen</option>
                                                    <option value="funeral_home">Bestattungsinstitut</option>
                                                    <option value="furniture_store">M&ouml;belhandel</option>
                                                    <option value="gas_station">Tankstelle</option>
                                                    <option value="general_contractor">Generalunternehmen(??)</option>
                                                    <option value="geocode">Geocode</option>
                                                    <option value="grocery_or_supermarket">Lebensmittel</option>
                                                    <option value="gym">Sport</option>
                                                    <option value="hair_care">Friseur</option>
                                                    <option value="hardware_store">Eisenwarengeschäft</option>
                                                    <option value="health">Gesundheit</option>
                                                    <option value="hindu_temple">Hindu-Tempel</option>
                                                    <option value="home_goods_store">Haushaltswaren</option>
                                                    <option value="hospital">Krankenhaus</option>
                                                    <option value="insurance_agency">Versicherungsagentur</option>
                                                    <option value="jewelry_store">Juwelier</option>
                                                    <option value="laundry">W&auml;scherei</option>
                                                    <option value="lawyer">Rechtsanwalt</option>
                                                    <option value="library">Bibliothek</option>
                                                    <option value="liquor_store">Getr&auml;nkehandel</option>
                                                    <option value="local_government_office">lokale Verwaltung</option>
                                                    <option value="locksmith">Schlosser</option>
                                                    <option value="lodging">Unterkunft</option>
                                                    <option value="meal_delivery">Essenslieferung</option>
                                                    <option value="meal_takeaway">Essensmitnahme</option>
                                                    <option value="mosque">Moschee</option>
                                                    <option value="movie_rental">Videoverleih</option>
                                                    <option value="movie_theater">Kino</option>
                                                    <option value="moving_company">Umzugsunternehmen</option>
                                                    <option value="museum">Museum</option>
                                                    <option value="night_club">Nachtclub</option>
                                                    <option value="painter">Anstreicher</option>
                                                    <option value="park">Park</option>
                                                    <option value="parking">Parken</option>
                                                    <option value="pet_store">Kleintierhandel</option>
                                                    <option value="pharmacy">Apotheke</option>
                                                    <option value="physiotherapist">Physiotherapie</option>
                                                    <option value="place_of_worship">Kultst&auml;tte</option>
                                                    <option value="plumber">Klempner</option>
                                                    <option value="police">Polizei</option>
                                                    <option value="post_office">Post</option>
                                                    <option value="real_estate_agency">Immobilienmakler</option>
                                                    <option value="restaurant">Restaurant / Gastst&auml;tte</option>
                                                    <option value="roofing_contractor">Dachdecker</option>
                                                    <option value="rv_park">RV Park(??)</option>
                                                    <option value="school">Schule</option>
                                                    <option value="shoe_store">Schuhgesch&auml;ft</option>
                                                    <option selected value="shopping_mall">Einkaufszentrum</option>
                                                    <option value="spa">Bad</option>
                                                    <option value="stadium">Stadion</option>
                                                    <option value="storage">Lagerung</option>
                                                    <option selected value="store">Gesch&auml;ft</option>
                                                    <option value="subway_station">U-Bahn Station</option>
                                                    <option value="synagogue">Synagoge</option>
                                                    <option value="taxi_stand">Taxistand</option>
                                                    <option value="train_station">Bahnhof</option>
                                                    <option value="travel_agency">Reiseagentur</option>
                                                    <option value="university">Universit&auml;t/Hochschule</option>
                                                    <option value="veterinary_care">Tierazt</option>
                                                    <option value="zoo">Zoo</option>
                                                    <option value="administrative_area_level_1">Verwaltung Bund</option>
                                                    <option value="administrative_area_level_2">Verwaltung Land</option>
                                                    <option value="administrative_area_level_3">Verwaltung Kreis</option>
                                                    <option value="colloquial_area">lokale Bezeichnung</option>
                                                    <option value="locality">Gegend</option>
                                                    <option value="natural_feature">Sehensw&uuml;rdigkeit Natur</option>
                                                    <option value="neighborhood">Nachbarschaft</option>
                                                    <option value="political">Politisch</option>
                                                    <option selected value="point_of_interest">POI</option>
                                                    <option value="route">Route</option>
                                                    <option value="sublocality">sublocality</option>
                                                    <option value="sublocality_level_4">sublocality_level_4</option>
                                                    <option value="sublocality_level_5">sublocality_level_5</option>
                                                    <option value="sublocality_level_3">sublocality_level_3</option>
                                                    <option value="sublocality_level_2">sublocality_level_2</option>
                                                    <option value="sublocality_level_1">sublocality_level_1</option>
                                                    <option value="transit_station">Bahnstation</option>
                                                </optgroup>

                                            </select>
                                        </form>
                                        <br/> <label for="nachPLZ">nach Postleitzahl suchen</label><br/>
                                        <input type="text" id="nachPLZ" name="nachPLZ" value="PLZ" class="vtip button clearfield" title="Auswahl nach Postleitzahl:  Postleitzahl oder Ortsname eingeben und aus Liste auswählen, um Tafeln im PLZ-Bereich anzuzeigen (Filter aktiv)."/>
                                        <input type="checkbox" id="plzdraw" name="plzdraw" checked="checked" class="_button vtip" title="Umrisse der Postleitzahl in Karte einzeichnen"/><label for="plzdraw">Umrisse einzeichnen</label>
                                        <br/>
                                        <label for="nachOKZf">nach statistischer Ortskennziffer suchen</label><br/>
                                        <input type="text" id="nachOKZf" name="nachOKZf" value="Kennziffer" class="vtip button clearfield" title="Auswahl nach Orts-/Gemeindekennziffer: Kennziffer, Postleitzahl oder Ortsname eingeben, um Tafeln im Bereich der Orts-/Gemeindenkennziffer anzuzeigen (Filter aktiv)"/>
                                        <input type="checkbox" id="okzfdraw" name="okzfdraw" checked="checked" class="vtip _button" title="Kennziffer auf Karte eintragen (Label)"/><label for="okzfdraw">Label anzeigen</label>
                                        <br/>
                                        <label for="bestandssuche">Bestandssuche (Freitext)</label><br/>
                                        <input id="bestandssuche" name="bestandssuche"type="text" class="ui-state-default vtip clearfield" style="width: 180px;"
                                               value="Bestandssuche"  title="kombinierte Suche im Bestand nach Standort, PLZ, Anbieter-ID, Nielsen, Schlagworten in Standortbeschreibung"/>
                                        <br/>

                                    </div>
                                    <!--                            <div id="ROUTING" style="margin-top: 5px;" class="ui-dialog ui-widget ui-widget-content" style="height:333px">-->
                                </div>
                                <div id="routenplanung" class="ui-widget ui-widget-content" rel="Streckenplaner" style="width: 90%; overflow:hidden; margin-top: 12px">
                                    <div id="mini_map_canvas_outer" class="ui-widget" style="padding:5px; width: 190px; height: 190px; float: right;">
                                        <div class="ui-widget-content ui-dialog" style="width:180px; height:180px;padding:0;">
                                            <div id="mini_map_canvas" style="width: 180px; height: 180px;"></div>
                                        </div>
                                        <!--                                        <div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div>-->
                                    </div>
                                    <form>
                                        <input title="Startadresse eingeben" type="text" id="startadresse" class="vtip ui-state-default clearfield" style="width: 180px; float: left;" value="Startadresse"/>
                                        <br/>
    <!--                                    <span id="zwischenstopliste" class="ui-widget-content"></span>-->
                                        <div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div>

                                        <br/>
                                        <input title="Zieladresse eingeben" type="text" id="zieladresse" class="vtip ui-state-default clearfield" style="width: 180px;" value="Zieladresse"/>
                                        <br/>
    <!--                                    <input title="Ein oder mehrere Zwischenstopps hinzuf&uuml;gen" type="text" id="zwischenstop" class="vtip clearfield" style="width: 180px;" value="Zwischenstop hinzuf&uuml;gen"/>-->
                                        <input type="hidden" id="startlongitude"/><input type="hidden" id="ziellongitude"/>
                                        <input type="hidden" id="startlatitude"/><input type="hidden" id="ziellatitude"/>

                                    </form>
                                    <div>
                                        Fortbewegungsart f&uuml;r Routensuche: Laufen, Bundesstrasse, Autobahn, Fahrrad
                                        <div id="fortbewegungsart">
                                            <input type="radio"  class="ui-state-default" id="WALKING" name="radio"/>
                                            <label class="vtip" title="Fusswege ermitteln" for="WALKING">L</label>
                                            <input type="radio" id="DRIVING" name="radio" checked="checked"/>
                                            <label class="vtip" title="Autobahnen vermeiden" for="DRIVING">B</label>
                                            <input type="radio" id="HIGHWAY" name="radio"/>
                                            <label class="vtip" title="Autobahnen bevorzugen" for="HIGHWAY">A</label>
                                            <input type="radio" id="BICYCLING" name="radio"/>
                                            <label class="vtip" title="Fahrradroute" for="BICYCLING">F</label>
                                        </div>
                                    </div>


                                    <div title="Route l&ouml;schen" id="reset_route"  class="vtip ui-state-default" style="float:right">
                                        Reset
                                        <div class="ui-icon fff-icon-cross"></div>
                                    </div>
                                    <div title="Umkreissuche entlang Route durchf&uuml;hren und in Hauptkarte einzeichnen" id="suche_route"  class="button vtip ui-state-default" style="float:left">
                                        Routensuche durchführen
                                        <div class="ui-icon fff-icon-flag-blue"></div>
                                    </div>


                                </div>

                                <!--                            </div>-->
                                <!-- END INNER TAB -->
                            </div>

                        </div>
                        <div id="masterlist">

                            <div id="map-side-bar-container"  rel="Tabelle" class="ui-widget ui-widget-content"  style="overflow: scroll; width:90%; height:300px;">
                                <button id="print_repository" class="button" style="float:left" onclick="htmlDrucken(repositoryTable.colorize({banDataClick:true}).parent().html());">Drucken</button>

                                <table id="repositoryTable" style="width: 100%; height: 100%;">
                                    <thead style="">
                                        <tr>
                                            <!--
                                            data[i].id,
                                        data[i].label,
                                        data[i].description,
                                        data[i].plz,
                                        data[i].leistungswert1,
                                        data[i].stellenart,
                                        data[i].preis,
                                        data[i].beleuchtung,
                                        data[i].standortnr,
                                        data[i].belegdauerart,
                                        data[i].bauart,
                                        data[i].hoehe,
                                        data[i].breite
                                            <img src="img/240x240/'+data.id+'.png"/>
                                            -->
                                            <th style="width: 25px;">ID</th><th style="width: 150px;">Kurzbezeichnung</th><th>Beschreibung</th>
                                            <th style="width: 25px;">PLZ</th><th style="width: 25px;">GFK</th><th style="width: 25px;">Stellenart</th><th>€/Tag</th>
                                            <th style="width: 10px;">B/U</th><th style="width: 50px;">StandortNr</th><th style="width: 50px;">BD</th>
                                            <th>Bauart</th><th>H</th><th>B</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                    </tbody>
        <!--                                <tfoot>
                                        <tr>
                                            <th>ID</th><th>Kurzbezeichnung</th><th>Beschreibung</th>
                                            <th>PLZ</th><th>GFK</th><th>Stellenart</th><th>Preis</th>
                                            <th>B/U</th><th>StandortNr</th><th>BD</th><th>Bauart</th>
                                            <th>H</th><th>B</th>
                                        </tr>
                                    </tfoot>-->
                                </table>
                            </div>
                        </div>
                        <div id="merkzettelouter">
                            <!--                        <h2>Tab 2</h2>-->




                            <!--                        <ul>
                                                        <li>Tabelle ausgewählter Tafeln, clickable</li>
                                                                                    <li>Button Auswahl anfragen (Checkout)</li>
                                                    </ul>-->
                            <div id="merkzetteltableouter" class="ui-widget ui-widget-content" style="overflow: scroll; width:90%; height:300px;">
                                <button id="print_merkzettel" class="button" style="float:left" onclick="htmlDrucken(taggedRepositoryTable.colorize({banDataClick:true}).parent().html());">Drucken</button>
                                <table id="taggedRepositoryTable" style="width: 100%; height: 100%;">
                                    <thead style="">
                                        <tr>
                                            <!--
                                            data[i].id,
                                        data[i].label,
                                        data[i].description,
                                        data[i].plz,
                                        data[i].leistungswert1,
                                        data[i].stellenart,
                                        data[i].preis,
                                        data[i].beleuchtung,
                                        data[i].standortnr,
                                        data[i].belegdauerart,
                                        data[i].bauart,
                                        data[i].hoehe,
                                        data[i].breite
                                            <img src="img/240x240/'+data.id+'.png"/>
                                            -->
                                            <th style="width: 25px;">ID</th><th style="width: 150px;">Kurzbezeichnung</th><th>Beschreibung</th>
                                            <th style="width: 25px;">PLZ</th><th style="width: 25px;">GFK</th><th style="width: 25px;">Stellenart</th><th>€/Tag</th>
                                            <th style="width: 10px;">B/U</th><th style="width: 50px;">StandortNr</th><th style="width: 50px;">BD</th>
                                            <th>Bauart</th><th>H</th><th>B</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                    </tbody>
        <!--                                <tfoot>
                                        <tr>
                                            <th>ID</th><th>Kurzbezeichnung</th><th>Beschreibung</th>
                                            <th>PLZ</th><th>GFK</th><th>Stellenart</th><th>Preis</th>
                                            <th>B/U</th><th>StandortNr</th><th>BD</th><th>Bauart</th>
                                            <th>H</th><th>B</th>
                                        </tr>
                                    </tfoot>-->
                                </table>


                            </div>
                            <div class="buttonbar">
<!--                                <span id="taggedCheckOut" class="button" onclick="taggedCheckOut();"><span class=" ui-icon fff-icon-tick" style="float:left"></span> Merkliste anfragen</span>-->
                                <span id="taggedLoad" class="button" onclick="loadTaggedToMap();">Auf Karte anzeigen</span>
                                <span id="taggedClear" class="button"><span class=" ui-icon fff-icon-cancel" style="float:left"></span>Merkliste leeren</span>
                            </div>
                        </div>


                        <div id="kalenderplanung"  class="ui-widget ui-widget-content" style="height: 100%">
                            <!--                        <div id="kalendertabs">-->
                            <ul id="kalendertabslist">
                                <li><a href="#timeinputs" title="Terminauswahl: einen Datumsfilter zusammenstellen" class="vtip">Termine auswählen</a></li>
                                <li><a href="#timeresultstablecontainer" title="Freizahlen anzeigen: Klicken um Liste der verfügbaren Tafeln unter Anwendung des Datumsfilter zu zeigen." class="vtip" id="sucheFreieTafeln">Freizahlen anzeigen</a></li>
                            </ul>
                            <div id="timeinputs" class="ui-widget ui-widget-content">
                                <div id="timeInputsScroller" style="overflow: hidden; height: auto; width:100%; 
                                     margin:0;padding:0; max-height: 55%" >
                                    <div style="width: 40%; float:left; background: url(text54269679.png)">
                                        <div id="monatskalender" style="width:180px; height:auto">
                                        </div>
                                        <div id="kwsmalltables">

                                        </div>
                                    </div>


                                    <div style="width: 55%; float: left;">
                                        <form id="daterangeuser" name="daterangeuser"class="ui-widget ui-widget-content">
                                            <input type="text" class="datum datepicker clearfield vtip" value="Startdatum"  title="Startdatum auswählen" id="startdatum" name="Startdatum" style="width: 60px;max-width:60px"/><label for="Startdatum"></label>
                                            <input type="text" class="datum datepicker clearfield vtip"  value="Enddatum" title="Enddatum auswählen"  id="enddatum" name="Enddatum" style="width: 60px;max-width:60px"/><label for="Enddatum"></label>
                                            <button onclick="updateDateSelection(); return false;" class="button vtip" title="Datunsspanne zum Filter hinzufügen" style="float:right;">+</button>
                                        </form>

                                        <div class="ui-widget-content" style="width: 100%;">
                                            <form id="quickkw" class="ui-widget ui-widget-content">
                                                <input type="text" style="width:140px;" id="kwauswahlnachdatum" name="DatumKW" class="datepicker button clearfield" value="Datum/Woche"/> 
                                                <button type="submit" class="button" style="float:right;">+</button>
                                            </form>
                                        </div>
                                        <div class="ui-widget-content" style="width: 100%;">
                                            <form id="quickdeka" name="quickdeka">
                                                <select id="dekadata" name="dekadata" multiple="multiple" style="width: 160px;">
                                                    <optgroup label="Schnellauswahl Dekaden">

                                                        <option value="01">01</option><option value="02">02</option>
                                                        <option value="03">03</option><option value="04">04</option>
                                                        <option value="05">05</option><option value="06">06</option>
                                                        <option value="07">07</option><option value="08">08</option>
                                                        <option value="09">09</option><option value="10">10</option>
                                                        <option value="11">11</option><option value="12">12</option>
                                                        <option value="13">13</option><option value="14">14</option>
                                                        <option value="15">15</option><option value="16">16</option>
                                                        <option value="17">17</option><option value="18">18</option>
                                                        <option value="19">19</option><option value="20">20</option>
                                                        <option value="21">21</option><option value="22">22</option>
                                                        <option value="23">23</option><option value="24">24</option>
                                                        <option value="25">25</option><option value="26">26</option>
                                                        <option value="27">27</option><option value="28">28</option>
                                                        <option value="29">29</option><option value="30">30</option>
                                                        <option value="31">31</option><option value="32">32</option>
                                                        <option value="33">33</option><option value="34">34</option>
                                                    </optgroup>
                                                </select>
                                                <button class="button" style="float:right;" onclick="updateDekaSelection();return false;">+</button>
                                            </form>
                                            <button id="clearcal" title="Reset"  class="button" style="float:right;" onclick="clearCalendar();">Reset</button>
                                        </div>
                                    </div>

                                    <div id="results" style="width:48%; float: right; ">

                                    </div>
                                </div>

                            </div>
                            <div id="timeresultstablecontainer" class="ui-widget ui-widget-content">
                                <!--                                class="ui-widget ui-widget-content" style="width: 48%; float: right; clear: right;"-->

                                <div id="timeResultsTableScroller" class="ui-widget ui-widget-content" style="overflow: scroll; width:300px; height:300px;">
                                    <button id="print_timedresults" class="button" style="float:left"  onclick="htmlDrucken(timeResultsTable.colorize({banDataClick:true}).parent().html());">Drucken</button>
                                    <table id="timeResultsTable" style="width: 100%; height: 100%; min-width: 420px;">
                                        <thead>
                                        <th>ID</th><th>Art</th><th>PLZ</th>
                                        <th>Rtg.</th><th>€/Tg</th><th>Lw</th><th>D/KW</th>
                                        <th><input type="checkbox" style="float:right;"/></th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!--                        </div>-->
                        </div>


                    </div>
                </span>
                <!--            <div id="footerslogan" class="ui-widget ui-widget-content" style="width: 90%; padding: 5px;text-align:right; position: absolute; bottom:0px; right: 1
                                 0px;">Aus über 255.000 Werbeflächen in ganz Deutschland auswählen und buchen <br/>- sehen wo Werbung wirklich wirkt!</div>
                -->

            </div>
        </div>
        <div class="ui-layout-south">
            <div id="graphicscontainer" class="no_vtip" style="width: 380px; padding: 0; margin: 0;">
                <div id="graphicsinnercontainer" style="background: #ffffff !important; height:210px;" class="vtip" title="Zustandsanzeige: <ul><li>TOTAL: Anzahl aktuell geladener Stellen</li><li>DATA: Anzahl aktuell geladener Stellen mit Angabe Leistungswert</li></ul>
                     Statistikanzeige: <ul><li>LW1SUM: Summe aller Leistungswerte</li><li>LW1AVG: durchschnittlicher Leistungswert</li>
                     <li>€ SUM: Summe Tagespreis in Euro</li><li>€ AVG: durchschnittlicher Tagespreis</li><li>EWK /1000: Erinnerungswirksame Werbemittelkontakte pro Tag (in Tausend)</li><li>€ TKP: durchschnittlicher Tausender-Kontaktpreis in Euro</li></ul><p>Leistungswerte werden nur im System angemeldeten Benutzern angezeigt (Anzeige 'NaN' oder fehlende Grafik).</p>">
                    <div id="graphics" style="width: 370px; height: 100px; background: white none; 
                         z-index: 10;">

                    </div>
                    <div id="total_counter_graphics" style="width: 190px; height: 100px; background: white none; 
                         z-index: 10; float:left">

                    </div>
                    <style type="text/css">
                        table#GROBKALKULATION td {height: 10px; padding: 0; margin:0;}
                    </style>
                    <table id="GROBKALKULATION" class="ui-widget ui-widget-content" style="font-size: 9px; width: 180px;" >
                        <thead>
                            <tr><td colspan="2">Details Merkliste</td></tr>
                        </thead>
                        <tr><td class="vtip" title="Erinnerungswirksame Webemittelkontakte aller gewählten Tafeln">EWK</td><td class="taggedewksum">taggedewksum</td></tr>
                        <tr><td class="vtip" title="Tausenderkontaktpreis aller gewählten Tafeln">TKP €</td><td class="taggedtkpavg">taggedtkpavg</td></tr>
                        <tr><td class="vtip" title="kumulierterTagespreis aller gewählten Tafeln">€/Tag</td><td class="taggedpricesum">taggedpricesum</td></tr>
                        <tr><td class="vtip" title="Anzahl gewählter Tafeln">Tafeln</td><td class="taggedcount">NA</td></tr>
                        <tr><td class="vtip" title="Anzahl gewählter Termine/Perioden">Termine</td><td class="idlistcount">NA</td></tr>
                        <tr><td class="vtip" title="maximale Anzahl vorraussichtlicher Rechnungstage">max. Rechnungstage</td><td class="rechnungstagecount">NA</td></tr>
                        <tr><td class="vtip" title="Angebotspreis maximal ca. <h3>Bitte kalkulieren Sie das genaue Angebot im Checkout!</h3>">Angebotspreis ca. €</td><td class="angebot_ca">NA</td></tr>
                    </table>

<!--                    <span style="float: none;" >Hilfe</span>-->
                </div>
            </div>


        </div>
        <!--        <div class="ui-layout-west">
        
                </div>-->

        <div id="formtoolsouter" class="ui-hidden-accesssible">
            <form id="formtools" class="ui-widget ui-widget-content ui-hidden-accessible" style="opacity: .91; margin-top: 14px" rel="Datasets">
                <textarea class="vtip" title="Kopieren / Einf&uuml;gen von Datasets (Format: JSON)." name="pastedata" id="pastedata" style="width: 100%; height:100px; float: none" cols="18" rows="4"></textarea>
                <button class="vtip button" id="submitpastedata" title="Dataset einlesen / erzeugen. Aktuelle Filter werden bei Suche ber&uuml;cksichtigt." value="submitpastedata" onclick="return false;" style="float:right">Submit</button>
                <input class="button" type="checkbox" name="savedata" id="savedata"/>
                <label class="vtip" title="Wenn aktiv: Dataset zum Kopieren/Speichern erzeugen.<br/>Inaktiv: aktuelles Dataset einlesen." for="savedata">Dataset generieren</label>
                <input class="button" type="checkbox" name="drawplz" id="drawplz"/>
                <label class="vtip" title="aktuelle Postleitzahlen in Hauptkarte einzeichnen (nur mit Dataset von Typ PLZ/Postleitzahlen)." for="drawplz">drawplz</label>
                <div id ="formtoolsdatatype" style="float: none">
                    <input type="radio" name="pastedatatype" id="SysIDs" value="sysids"/>
                    <label class="vtip" title="Datentyp: GeoDataMapper interne IDs" for="SysIDs">SysIDs</label>
                    <input type="radio" name="pastedatatype" id="SdawIDs" value="sdawids"/>
                    <label class="vtip" title="Datentyp: SDAW IDs" for="SdawIDs">SdawIDs</label>
                    <input type="radio" name="pastedatatype" id="Coords" value="coords"/>
                    <label class="vtip" title="Datentyp: Koordinaten (Lat Lng). Sucht Stellen mit exakt den angegebenen Koordinaten." for="Coords">Coords</label>
                    <input type="radio" name="pastedatatype" id="Postleitzahlen" value="postcodes" />
                    <label class="vtip" title="Datentyp: Postleitzahlen. Durchsucht Datenbank nach allen Stellen mit angegebener PLZ." for="Postleitzahlen">PLZ</label>
                    <!--
                    <input type="radio" name="pastedatatype" id="Addressen" value="addresses"/><label for="Addressen">Addressen</label>
                    <input type="radio" name="pastedatatype" id="Stichworte" value="keywords"/><label for="Stichworte">Stichworte</label>
                    --> 
                    <input type="radio" name="pastedatatype" id="Merkliste" value="cartitems" checked="checked"  />
                    <label class="vtip" title="Datentyp: markierte Stellen / Merkliste" for="Merkliste">Merkliste</label>

                    <input type="radio" name="pastedatatype" id="GeoNotizen" value="geonotes" />
                    <label class="vtip" title="Datentyp: eigene Geonotizen." for="GeoNotizen">GeoNotizen</label>

                    <input type="radio" name="pastedatatype" id="GDMdata" value="gdmdata" />
                    <label class="vtip" title="erweitertes GeoDataMapper-Format: beinhaltet Fiter und weitere Einstellungen der aktuellen Auswahl." for="GDMdata">GDM</label>
                </div>
            </form>

            <div id="userstorage"></div>
        </div>
        <div id="CHECKOUT" style="background: #ffffff !important" class="ui-hidden-accessible">
            <style type="text/css">#checkoutSummary input {width: 2em}</style>
            <form id="checkoutSummary" name="checkoutSummary" style="float: right; max-width: 50%;">
                <input type="text" id="StellenGesamt" name="StellenGesamt" value="0" disabled="disabled"/><label for="StellenGesamt">Stellen Gesamt</label>
                <br/>
                <input type="text" id="TermineGesamt"  name="TermineGesamt" value="0" disabled="disabled"/><label for="TermineGesamt">Termine Gesamt</label>
                <br/>
                <input type="text" id="RechnungstageGesamt" name="RechnungstageGesamt" value="NA" disabled="disabled"/><label for="">Rechnungstage Gesamt</label>
                <br/>
                <input type="text" id="RechnungsbetragGesamt" name="RechnungsbetragGesamt" value="NA" disabled="disabled"/><label for="RechnungsbetragGesamt">Rechnungsbetrag Gesamt</label>
            </form>


            <form id="checkOutForm" style="max-width:85%; float: left;">

                <input type="hidden" id="taggedtmp" name="merkliste"/>
                <input type="hidden" id="terminetmp" name="terminliste"/>
                <input type="hidden" id="startdatumtmp" name="Startdatum" value="0"/>
                <input type="hidden" id="enddatumtmp" name="Enddatum" value="0"/>

                <!--                            <div id="kalenderplanung" class="ui-widget-content" style="margin-top: 10px; margin-bottom:10px;">
                
                                                <input type="text" class="datum clearfield" value="Startdatum"  title="Startdatum" id="startdatum" name="Startdatum" style="width: 80px;"/><label for="Startdatum"></label>
                                                <input type="text" class="datum clearfield"  value="Enddatum" title="Enddatum"  id="enddatum" name="Enddatum" style="width: 80px;"/><label for="Enddatum"></label>
                                            </div>-->


                <div id="kontaktdaten" class="ui-widget ui-widget-content">

                    <input disabled class="input_field_12em button" name="IhrName" value="<? try {print $_SESSION['__default']['user']->name; } catch (Exception $e){print 'NA';} ?>"/><label for="IhrName"></label><br/>

                    <input disabled class="input_field_12em button" name="Firma" value="<? try {print $_SESSION['__default']['user']->firma;} catch (Exception $e){print 'NA';}  ?>"/><label for="Firma"></label><br/>

                    <input disabled class="input_field_12em button" name="Email" value="<? try {print $_SESSION['__default']['user']->email;} catch (Exception $e){print 'NA';}  ?>"/><label for="Email"></label><br/>

                    <input disabled class="input_field_12em button" name="Telefon" value="<? try {print $_SESSION['__default']['user']->telefon;} catch (Exception $e){print 'NA';}  ?>"/><label for="Telefon"></label><br/>
<!--                                    <input type="checkbox" name="agbchecker" id="agbchecker" style="float:left;"/><label for="agbchecker"><a class="ajax" href="/_ng/index.php?option=com_content&view=article&id=20&Itemid=17 .content_right">AGB</a> akzeptiert</label><br/>

                    <input type="checkbox" name="widerrufschecker" id="widerrufschecker" style="float:left;" class="vtip" title="Verzicht auf mein Widerrufsrecht, warum?
                           Als Verbraucher steht Ihnen ein gesetzliches Widerrufsrecht von 14 Tagen zu. Das würde bedeuten, dass wir nach Eingang Ihres Auftrages erst zwei Wochen abwarten müssen, bevor wir mit der Abwicklung Ihres Auftrags beginnen können. Die Zeit besteht in den meisten Fällen nicht, da sich die Verfügbarkeiten der Werbeträger stündlich ändern können. Deshalb bitten wir, dass Sie auf Ihr Widerrufsrecht verzichten, damit wir sofort mit unserer Arbeit beginnen können und Ihre Plakate pünktlich einschalten können. "/><label for="widerrufschecker">Ich verzichte auf mein Widerrufsrecht.</label><br/>-->

                </div>


<!--                                <button class="button" name="doTheCheckoutSubmit"  id="doTheCheckoutSubmit" style="margin-top: 10px;">Hiermit bestelle ich die Buchung der ausgewählten Werbeträgerstandorte im ausgewählten Zeitraum.<span id="merkzettelouter_icon" class="ui-icon fff-icon-cart" style="float:left"></span><span class=" ui-icon fff-icon-tick" style="float:left"></span></button>-->


                <div id="alreadyCheckedOut" style="width: 100%; height: 100px; overflow: auto"></div>
                <div class="buttonbar">
                    <!--                                    <div id="loadAngebotsrechner" class="button" onclick="">Angebot berechnen</div>-->
                    <button class="button" type="submit">Angebot berechnen</button> 
                    <div class="loginlink button" onclick="showLoginBox();">Anmelden</div>
                    <!--                                    <div id="gELoader" class="button" onclick="loadTaggedToGoogleEarth();">gELoad</div> -->

                    <div id="taggedZoom" class="button" onclick="map.fitBounds(getClustererBounds(markerClusterer));"><span class=" ui-icon fff-icon-arrow-refresh" style="float:left"></span> Alles anzeigen</div>

<!--                                    <div id="checkoutCancel" class="button" onclick="checkoutCancel();"><span class=" ui-icon fff-icon-arrow-undo" style="float:left"></span> Zurück zur Suche</div>-->
                </div>
            </form>

        </div>
        <div id="zoomerbackground" class="vtip ui-dialog" style="width:34px; height: 280px;" title="Einstellungen für die Karte und Filter: Cluster-Zoom, Radius der Umkreissuche einstellen, Preisspanne und Leistungswert (GFK) einstellen.">
            <img src="gdmlogo01help.png" class="vtip gdmhelp ui-dialog" title="GeoDataMapper Version 0.9 beta 1<br/>&copy; 2013. <br/><h3>Klicken um Hilfe anzuzeigen.</h3>" style="position: absolute; bottom:2px; left: 6px; width: 22px; opacity: .8;"/>
        </div>
        <div title ="Cluster-Zoomstufe einstellen" id="clusterzoom" class="vtip ui-widget ui-corner-all" style="height:120px; width: 10px;float: none;z-index: 1000;"></div>
        <div title="Radius der Umkreissusche einstellen" id="umkreis" class="vtip ui-widget ui-corner-all" style="height:120px; width: 10px;float: none;z-index: 1000;"></div>
        <div title="Filter Preisspanne Min,Max einstellen" id="pricezoom" class="vtip ui-widget" style="height: 120px; width: 10px;float: none;z-index: 1000;"></div>
        <div title="Filter GFK Werte Min,Max einstellen" id="gfkzoom" class="vtip ui-widget" style="height: 120px; width: 10px;float: none;z-index: 1000;"></div>

        <div id="lensmapcontainer" style="width: 95px; height: 100px; position: absolute; right:10px; bottom: 40px; padding: 5px 5px 5px 0px; z-index:10; border: 0px solid silver" class="ui-widget ui-dialog">
            <div id="lensmap" style="width: 90px; height: 90px; margin: 0">
            </div>
        </div>
        <!--         <div id="graphics" style="width: 260px; height: 100px; background: white none; 
                     position: absolute; bottom: 10px; right:10px; z-index: 10" 
                     class="ui-widget ui-widget-content"></div>
                <div id="total_counter_graphics" style="width: 100px; height: 100px; background: white none; 
                     position: absolute; top: 10px; right: 10px; z-index: 10" 
                     class="ui-widget ui-widget-content"></div>-->

        <div id="markersRepository" class="ui-hidden-accessible">

        </div>
        <div id="placesRepository" class="ui-hidden-accessible">

        </div>
        <div id="taggedRepository" class="ui-hidden-accessible">

        </div>
        <div id="tmp" class="ui-hidden-accessible">

        </div>
        <div id="loginbox"> </div>
        <script type="text/javascript">
            $(document).ready(function(){
                
                $('.ajax').colorbox({ajax:true, width:'80%', height:'80%'});
                $('#loadAngebotsrechner').colorbox({href:'buchen.php',width:'90%', height:'90%', close:'ZURÜCK ZUR MERKLISTE'});
                $('.ui-slider .ui-slider-handle').css({'border':'1px solid grey', 'width':'15px'});
                
//                $('#clusterzoom, #gfkzoom, #pricezoom, #umkreis')
//                .addClass('ui-dialog')
//                .hover(function(){
//                    $(this).removeClass('ui-dialog').css('z-index','1001').animate({width: '25px', height: '280px'}, 100);
//                },
//                function(){
//                    $(this).addClass('ui-dialog').css('z-index','1000').animate({width: '10px', height: '120px'},100);
//                });  
                
                $('.ui-dialog').css('background','#3d4798')
                .hover(function(){
                    // $(this).css('background','none');
                    // $(this).css('background','#cecece');
                    $(this).animate({
                        //backgroundColor: "#3d4798"
                        opacity: 1
                    }, 330, 'swing' );
                },
                function(){
                    //$(this).css({'background':'none', 'backgroundColor': 'none'});
                    $(this).css('opacity','.8');
                    // $(this).css('background','silver');
                });  
                $('#angebotDrucken').live('click', function(){angebotDrucken()});
                
            });
        </script>

    </body>
</html>
