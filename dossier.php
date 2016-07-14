<?php
/**
 * @name dossier.php
 * @package SDAW_Classes
 * @author mckoch - 30.06.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * SDAW Classes:dossier
 *
 *
 */
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>Dossier GISAW</title>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

        <script type="text/javascript">
            var dossiermap;
            var dossierMarkerClusterer;
            var mgr;
            function dossiermap() {
                var myLatlng = new google.maps.LatLng(-34.397, 150.644);
                var myOptions = {
                    zoom: 8,
                    center: myLatlng, 
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true
                }
                dossier_map = new google.maps.Map(document.getElementById("dossier_map_canvas"), myOptions);

                
            }

        </script>
    </head>
    <body>

        <?php

        function curPageURL() {
            $pageURL = 'http';
            if ($_SERVER["HTTPS"] == "on") {
                $pageURL .= "s";
            }
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            }
            return $pageURL;
        }

        ////////////////////////////////////////////////////////////////
        print "<hr/>REPORT<hr/>";
        //print "<hr/>POST<hr/>";
        //print_r($_POST);
        //print "<hr/>GET<hr/>";
        //var_dump($_GET);

        foreach ($_GET as $segment) {
            print "<h2>$segment</h2>";
            print '<div class="'.$segment.'">';
            switch ($segment) {
                case ('printmap'):

                    print '<div id="dossier_map_canvas" style =" width: 400px; height:300px; background: silver"></div>';
                    print "
                <script type='text/javascript'>
                    $(document).ready(function(){
                        $('#dossier_map_canvas').width($('#history').innerWidth());
                        $('#dossier_map_canvas').height($('#map_canvas').height());
                        dossiermap();
                        dossier_map.fitBounds(map.getBounds());
                        dossierMarkerClusterer = new MarkerClusterer(dossier_map, markerClusterer.getMarkers());
                        dossierMarkerClusterer.setMaxZoom(clusterzoom);
                        
                    });
                </script>";
                    break;

                case 'printrepository':
                    // http://maps.google.com/maps/api/staticmap?center=Williamsburg,Brooklyn,NY
                    // &zoom=13&size=400x400&markers=color:blue|label:S|11211|11206|11222
                    // &sensor=true_or_false
                    // . "&icon:http://cm.inextsolutions.net/sdaw/"
                    // 'images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png',
                    //
                    // . "&icon:http://cm.inextsolutions.net/sdaw/images/markers/marker_".strtolower($marker['stellenart']).".png".
error_reporting(E_ALL);
                    $markers = json_decode($_POST['markersFormData'], true);
                    //print_r($markers);
                    foreach ($markers as $marker) {
                        if (@$_GET['printdetailmaps']) {

                            $mapurl = "http://maps.google.com/maps/api/staticmap?center=" . $marker['latitude'] . ","
                                    . $marker['longitude'] . "&size=200x200&markers=" . $marker['latitude'] . ","
                                    . $marker['longitude'] . "&icon:" . urlencode("http://cm.inextsolutions.net/sdaw/images/markers/marker_" . strtolower($marker['stellenart'])
                                            . ".png") . "&sensor=false";

                            //print "<hr/>";
                            print '<img src="'.$mapurl.'"/>';
                            
                        }
                        //print "<hr/>";
                        //print($marker['id']);
                        print '<img src="http://cm.inextsolutions.net/sdaw/img/240x240/'.$marker['id'].'.png"/>';
                        print '<img src="http://cm.inextsolutions.net/sdaw/images/markers/marker_' . strtolower($marker['stellenart']).'.png"/>';
                        foreach ($marker as $i) print $i.' | ';

                            print "<hr/>";
                    }
                    break;
            }
            print '</div>';
        }
        print "Dossier URL: " . curPageURL();
        print "<hr/>ENDE REPORT<hr/>";
        ?>
    </body>
</html>
