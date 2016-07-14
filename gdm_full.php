<?php
/**
 * @name gdm_full.php
 * @package GDM_joean-doe_media
 * @author mckoch - 13.12.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * GDM_joean-doe_media:gdm_full
 *
 *
 */
define('included_from_api', 'included');
require_once('/var/www/vhosts/default/htdocs/_ng/index.php');
if (!$_SESSION['__default']['user']->username || !$_SESSION['__default']['user']->usertype){
    
   // header('Location: /api');
    require_once('standorte_1.php');
    die;
    
}
//require_once('include/html.pagecompressor.php');
//print_r($_SESSION['__default']['user']);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Map Interface Generic V.3.3</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Copyright" content="joean-doe Media GmbH, Bonn">
        <meta http-equiv="web_author" content="Markus C. Koch, emcekah@gmail.com ">
        <meta name="generator" content="GeoDataMapper V0.5">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <meta name="Description" content="Aus über 250.000 Werbetafeln an Standorten in ganz Deutschland auswählen und buchen. Werbung wo sie hingehört.">

        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
        <link type="text/css" href="css/ui-icon/css/fff.icon.core.css" rel="stylesheet" />
        <link type="text/css" href="css/ui-icon/css/fff.icon.icons.css" rel="stylesheet" />
        <link type="text/css" href="js/jquery.layout-default-latest.css" rel="stylesheet"/>
        <link type="text/css" href="js/jquery.datatables.css" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="js/jquery.jqplot.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="js/ui.multiselect.css" />
        <link type="text/css" href="js/jquery.jscrollpane.css" rel="stylesheet" media="all" />

        <script type="text/javascript">var SessionUser='<?php print $_SESSION['__default']['user']->username; ?>';var SessionUserRole = '<?php print $_SESSION['__default']['user']->usertype; ?>';var SessionUserEmail = '<?php print $_SESSION['__default']['user']->email; ?>';var SessionUserPass = '<?php print $_SESSION['__default']['user']->password; ?>';</script>

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=panoramio"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=places&sensor=false"></script>

        <script type="text/javascript" src="js/RouteBoxer.js"></script>
        <script type="text/javascript" src="js/markerClusterer.js"></script>

        <script type="text/javascript" src="js/keydragzoom.js"></script>
        <script type="text/javascript" src="js/infobubble.js"></script>
        <script type="text/javascript" src="js/progressBar.js"></script>
        <script type="text/javascript" src="js/maplabel.js"></script>


        <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>

        <script type="text/javascript" src="js/jquery.json-2.2.js"></script>
        <script type="text/javascript" src="js/jquery.clearfield.js"></script>
        <script type="text/javascript" src="js/jquery.vtip.js"></script>

        <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <script type="text/javascript" src="js/jquery.jqplot.js"></script>
        <script type="text/javascript" src="js/jqplot.barRenderer.js"></script>
        <script type="text/javascript" src="js/jqplot.highlighter.js"></script>
        <script type="text/javascript" src="js/jqplot.categoryAxisRenderer.js"></script> 
        <script type="text/javascript" src="js/jqplot.lgxisRenderer.js"></script>

        <script type="text/javascript" src="js/jquery.dialogextend.js"></script>
        <script type="text/javascript" src="js/jquery.layout-latest.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/jquery.loading.1.6.3.js"></script>
        <script type="text/javascript" src="js/jquery.multiselect.js"></script>
        <script type="text/javascript" src="js/jquery.tinysort.js"></script>

        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/jquery.jscrollpane.js"></script>
        <script type="text/javascript" src="js/jquery.Storage.js"></script>


        <style type="text/css">
            .loading {
                background: #FFC129;
                color: black;
                font-weight: bold;
                padding: 3px;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
            }
        </style>
        <style type="text/css">
            .contextmenu{
                visibility:hidden;
                background:#ffffff;
                border:1px solid #8888FF;
                z-index: 10;
                position: relative;
                width: 140px;
            }
            .contextmenu div{
                padding-left: 5px
            }
            .contextmenu a:link {
                color: #6699cc;
            }
            .contextmenu a:visited {
                color: #666699;
            }
            .contextmenu a:hover {
                color: #693;
            }
            .contextmenu a:active {
                color: #cc3333;
                text-decoration: none;
            }
            p#vtip { display: none; position: absolute; padding: 10px; left: 5px; font-family:Tahoma, Arial, sans-serif;font-size: 0.8em; background-color: white; border: 1px solid #a6c9e2; -moz-border-radius: 5px; -webkit-border-radius: 5px; z-index: 999999 }
            p#vtip #vtipArrow { position: absolute; top: -10px; left: 5px }

            .dataTables_length {width: 40%; float:left}
            .dataTables_filter {width: 60%; float: right}

            #repositoryTable tbody tr img {height: 18px}

            ul.ui-multiselect-checkboxes {overflow-y: scroll;}

            #Placesfilter select option img {height: 12px;}

        </style>

        <script type="text/javascript">
            

            var map;
            var minimap;
            //var earth;
            
            //google.load('earth','1');
            var geocoder = new google.maps.Geocoder();
            var mapcenter = new google.maps.LatLng(50.931696775155274,6.971980590820294);
            var umkreis = 2000;

            //            var clickcenter;

            //var markersRepository = [];
            //var placesRepository = [];

            var tplTable = "<tr><td>${label}</td><td>${description}</td></tr>";
            var appLayout;


            var circle = new google.maps.Circle({
                fillOpacity : .1,
                fillColor:'#ffccaa',
                strokeColor:'#00ff00',
                strokeOpacity: .77,
                strokeWeight: 2,
                clickable: false
            });

            var markerClusterer = null;
            var markerPlacesClusterer = null;
            var markerPlacesClustererTmp = null;
            var merklisteClusterer = null;

            var markerlensmapClusterer = null;

            var clusterzoom = 15;
            var gfkrange = null;
            //var placestypes = ['store','department_store','electronics_store'];

            var infoBubble = new InfoBubble();
            var infowindow = new google.maps.InfoWindow();

            
            var markerimage = new google.maps.MarkerImage('css/ui-icon/ico/arrow_refresh.png');
            var centermarker = new google.maps.Marker({
                draggable: true,
                title: 'Umkreis!',
                icon: markerimage
            });
            circle.bindTo('center', centermarker, 'position');
            google.maps.event.addListener(centermarker, 'dragend', function() {
                mapcenter = centermarker.getPosition();
                geocoder.geocode( {'latLng': mapcenter},
                function(results, status) {
                    $('#address').val(results[0].formatted_address);
                });
            });
            
            var rightclickimage = new google.maps.MarkerImage('images/mapicons/point_of_interest.png');
            var rightclickmarker = new google.maps.Marker({
                draggable: false,
                title: '',
                icon: rightclickimage
            });

            var poly = new google.maps.Polyline({ map: map, path: [], strokeColor: "#00ff00", strokeOpacity: 0.8, strokeWeight: 2 });
            //                    var isClosed;
            //                    var markerIndex;
            //

            var directionsService = new google.maps.DirectionsService();
            var directionsDisplay = new google.maps.DirectionsRenderer();
            var boxpolys = null;
            var routeBoxer = new RouteBoxer();
            var distance = null; // km
            
            /** 
             * nicht vollst�ndig ausgef�hrt!!!!
             * BAUSTELLE
             **/
            var sv = new google.maps.StreetViewService();
            var streetviewpanorama;
            var panorama;

            var MAPTYPE_01 = 'candy';
            var MAPTYPE_02 = 'morecandy';
            var MAPTYPE_03 = 'muchmorecandy';
            var MAPTYPE_04 = 'almost_blank';
            var MAPTYPE_05 = 'blank';
            
            /// Stats
            
            var markersTotal = 0;
            var markersTotalVisible = 0;
            var gfkSumTotal = 0;
            var gfkSumVisible = 0;
            var gfkAvg = 0;
            var gfkAvgVisible = 0;
            var priceSumTotal = 0;
            var priceSumVisible = 0;
            var priceAvg = 0;
            var priceAvgVisible = 0;

            /** 
             *BAUSTELLE
             */
            var plot1ticks = ['GFKSUM', 'GFKAVG', 'PRCSUM', 'PRCAVG'];
            var plot2ticks = ['TOT/VIS','TGD/VIS','PLC/VIS'];
            var plot1options = {
                seriesDefaults:{
                    renderer:$.jqplot.BarRenderer,
                    pointLabels: { show: true }
                },
                seriesColors: ["#cccccc", "#4bb2c5"],
                stackSeries: false,
                legend: {
                    show: true,
                    location: 'ne'
                },
                series:[
                    {label: 'gesamt'},{label: 'sichtbar'}],
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: plot1ticks
                    },
                    yaxis:{renderer: $.jqplot.LogAxisRenderer, tickDistribution:'power'} 
                },
                highlighter: { show: true }
            };
            var plot2options = {                
                seriesDefaults:{
                    renderer:$.jqplot.BarRenderer,
                    pointLabels: { show: true },
                    rendererOptions: {barPadding: 1,barMargin: 0}
                },
                seriesColors: [ "#cccccc","#4bb2c5"],
                
                axes: {                        
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        showTicks: true,
                        ticks: plot2ticks
                    },
                    yaxis:{renderer: $.jqplot.LogAxisRenderer, showTicks: true, tickDistribution:'power'} 
                },
                highlighter: { show: true }
            };
            function createQuickGraph(){
                //var markers = markerClusterer.getMarkers();
                //var cnt = 0;
                gfkSumTotal = 0;
                priceSumTotal = 0;
                markersTotalVisible = 0;
                gfkSumVisible = 0;
                priceSumVisible = 0;
                
                   
                $.each(markerClusterer.getMarkers(), function(index, value){
                    gfkSumTotal = parseFloat(gfkSumTotal) + parseFloat(value.markerData['leistungswert1']);
                    priceSumTotal = parseFloat(priceSumTotal) + parseFloat(value.markerData['preis']);
                    markersTotal = index + 1;
                    if (map.getBounds().contains(value.getPosition())){
                        markersTotalVisible++;
                        gfkSumVisible = parseFloat(gfkSumVisible)+ parseFloat(value.markerData['leistungswert1']);
                        priceSumVisible = parseFloat(priceSumVisible) + parseFloat(value.markerData['preis']);
                    };
                });
                //     avoid division by zero!!!!!!!! 
                if (markersTotal > 0){
                    var plot1data = [gfkSumTotal, gfkSumTotal/markersTotal, priceSumTotal/100, priceSumTotal/markersTotal/100];
                    var plot2data = [markersTotal];  
                } 
                else {
                    var plot1data = [];
                    var plot2data = [];
                };
                if (markersTotalVisible > 0){
                    var plot1visible = [gfkSumVisible, gfkSumVisible/markersTotalVisible, priceSumVisible/100, priceSumVisible/markersTotalVisible/100];
                    var plot2visible = [markersTotalVisible];
                }
                else {
                    var plot1visible = [];
                    var plot2visible = [];
                };
                plot1.destroy();
                plot2.destroy();
                
                plot1 = $.jqplot('graphics', [plot1data, plot1visible], plot1options);
                plot2 = $.jqplot('total_counter_graphics', [plot2data, plot2visible], plot2options);
            };
            
            /////// KML layer
            var kmlLayerDE = null;
            function toggleKmlLayerDE(){
                if (!kmlLayerDE){
                    kmlLayerDE = new google.maps.KmlLayer('http://cm.inextsolutions.net/kml/01DEU_adm0.DE.kmz',{preserveViewport: false, suppressInfoWindows: true});
                    kmlLayerDE.setMap(map);
                } else if (kmlLayerDE.getMap()=== null ) {kmlLayerDE.setMap(map);} else {kmlLayerDE.setMap(null);};              
            };
            var kmlLayerBL = null;
            function toggleKmlLayerBL(){
                if (!kmlLayerBL){
                    kmlLayerBL = new google.maps.KmlLayer('http://cm.inextsolutions.net/kml/DEU_adm1.BL.kmz',{preserveViewport: true, suppressInfoWindows: true});
                    kmlLayerBL.setMap(map);
                    google.maps.event.addListener(kmlLayerBL, "click",function(event){showContextMenu(event.latLng);});
                } else if (kmlLayerBL.getMap()=== null ) {kmlLayerBL.setMap(map);} else {kmlLayerBL.setMap(null);};              
            };
            var kmlLayerRBZ = null;
            function toggleKmlLayerRBZ(){
                if (!kmlLayerRBZ){
                    kmlLayerRBZ = new google.maps.KmlLayer('http://cm.inextsolutions.net/kml/DEU_adm2.RBZ.kmz',{preserveViewport: true, suppressInfoWindows: false});
                    kmlLayerRBZ.setMap(map);
                    google.maps.event.addListener(kmlLayerRBZ, "click",function(event){showContextMenu(event.latLng);});
                } else if (kmlLayerRBZ.getMap()=== null ) {kmlLayerRBZ.setMap(map);} else {kmlLayerRBZ.setMap(null);};              
            };
            var kmlLayerSTADT = null;
            function toggleKmlLayerSTADT(){
                if (!kmlLayerSTADT){
                    kmlLayerSTADT = new google.maps.KmlLayer('http://cm.inextsolutions.net/kml/DEU_adm3.STADT.kmz',{preserveViewport: true, suppressInfoWindows: false});
                    kmlLayerSTADT.setMap(map);
                    google.maps.event.addListener(kmlLayerSTADT, "click",function(event){showContextMenu(event.latLng);});
                } else if (kmlLayerSTADT.getMap()=== null ) {kmlLayerSTADT.setMap(map);} else {kmlLayerSTADT.setMap(null);};              
            };
            var kmlLayerURL = null;
            function toggleKmlLayerURL(){
                if (!kmlLayerURL){
                    kmlLayerURL = new google.maps.KmlLayer($('#userkmlurl').val(),{preserveViewport: true, suppressInfoWindows: false});
                    kmlLayerURL.setMap(map);
                    google.maps.event.addListener(kmlLayerURL, "click",function(event){showContextMenu(event.latLng);});
                } else if (kmlLayerURL.getMap()=== null ) {kmlLayerURL.setMap(map);} else {kmlLayerURL.setMap(null);};              
            };
            
            ///////////// INIT gmaps et al

            //google.maps.event.addDomListener(window, 'load', initialize);
            function initialize() {

                var stylez01 = [
                    {
                        featureType: "transit",
                        elementType: "geometry",
                        stylers: [
                            { hue: '#0000cc' },
                            { saturation: 90 },
                            {lightness: 10}
                        ]
                    },{
                        featureType: "transit.station",
                        elementType: "all",
                        stylers: [
                            { hue: '#0000FF' },
                            { saturation: 90 },
                            {lightness: 0}
                        ]
                    },{
                        featureType: "road.highway",
                        elementType: "geometry",
                        stylers: [
                            { hue: '#000000'},
                            { saturation: 0 },
                            { gamma: -90 }
                        ]
                    },{
                        featureType: "road.arterial",
                        elementType: "geometry",
                        stylers: [
                            { hue: '#FF0000'},
                            { saturation: 100 },
                            { gamma: 60 }
                        ]
                    },{
                        featureType: "road.local",
                        elementType: "geometry",
                        stylers: [
                            { hue: '#0000ff' },
                            { saturation: 10 },
                            { gamma: 40 }
                        ]
                    },
                    {
                        featureType: "landscape",
                        elementType: "geometry",
                        stylers: [
                            { hue: "#00ff00" },
                            { saturation: 35 },
                            { lightness: -70}
                        ]
                    },
                    {
                        featureType: "poi",
                        elementType: "all",
                        stylers: [
                            { hue: "#FF0000" },
                            { saturation: 95 },
                            { lightness: 0}
                        ]
                    }

                ];

                var stylez02 = [
                    {
                        featureType: "road",
                        elementType: "geometry",
                        stylers: [
                            { hue: -45 },
                            { saturation: 100 }
                        ]
                    },{
                        featureType: "all",
                        elementType: "labels",
                        stylers: [
                            { visibility: "off" }
                        ]
                    },{
                        featureType: "poi",
                        elementType: "all",
                        stylers: [
                            { visibility: "off" }
                        ]
                    },{
                        featureType: "administrative",
                        elementType: "all",
                        stylers: [
                            { visibility: "off" }
                        ]
                    },
                    {
                        featureType: "landscape",
                        elementType: "geometry",
                        stylers: [
                            { hue: "#000000" },
                            { saturation: 75 },
                            { lightness: -100}
                        ]
                    }
                ];

                var stylez03 = [
                    {
                        featureType: "road",
                        elementType: "geometry",
                        stylers: [
                            { hue: 45 },
                            { saturation: 100 }
                        ]
                    },
                    {
                        featureType: "landscape",
                        elementType: "geometry",
                        stylers: [
                            { hue: "#CCCCCC" },
                            { saturation: -75 },
                            { lightness: 100}
                        ]
                    },
                    {
                        featureType: "landscape.man_made",
                        elementType: "geometry",
                        stylers: [
                            { hue: "#CCCC00" },
                            { saturation: 75 },
                            { lightness: 100}
                        ]
                    },{
                        featureType: "road.highway",
                        elementType: "labels",
                        stylers: [
                            { visibility: 'off'}
                        ]
                    },{
                        featureType: "road.arterial",
                        elementType: "geometry",
                        stylers: [
                            { saturation: -75}
                        ]
                    }
                ];
                
                var stylez04 = [ { featureType: "all", elementType: "all", stylers: [ { visibility: "off" } ] },{ featureType: "administrative.country", elementType: "all", stylers: [ { visibility: "on" } ] },{ featureType: "administrative.province", elementType: "all", stylers: [ { visibility: "on" } ] },{ featureType: "transit.line", elementType: "all", stylers: [ { visibility: "on" } ] },{ featureType: "transit.station", elementType: "all", stylers: [ ] },{ featureType: "water", elementType: "geometry", stylers: [ { visibility: "on" }, { gamma: 2.93 } ] },{ featureType: "road.arterial", elementType: "geometry", stylers: [ { visibility: "on" }, { lightness: 14 } ] },{ featureType: "poi", elementType: "geometry", stylers: [ { visibility: "on" }, { saturation: -79 }, { lightness: 71 } ] },{ featureType: "landscape", elementType: "geometry", stylers: [ { visibility: "on" }, { lightness: 96 } ] } ];
                var stylez05 = [ { featureType: "all", elementType: "all", stylers: [ { visibility: "off" } ] },{ featureType: "landscape", elementType: "geometry", stylers: [ { visibility: "on" }, { lightness: 96 } ] } ];


                var mapOptions = {

                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoom: 8,
                    center: mapcenter,
                    mapTypeControl: true,
                    backgroundColor: '#ffffff',
                    mapTypeControlOptions: {
                        scaleControl: true,
                        scaleControlOptions: {
                            position: google.maps.ControlPosition.BOTTOM_LEFT
                        },
                        mapTypeIds: [google.maps.MapTypeId.ROADMAP,google.maps.MapTypeId.TERRAIN,google.maps.MapTypeId.SATELLITE,google.maps.MapTypeId.HYBRID, MAPTYPE_01, MAPTYPE_02,MAPTYPE_03,MAPTYPE_04,MAPTYPE_05],
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                    }

                };

                
                map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                circle.setMap(map);
                directionsDisplay.setMap(map);
                
                var lensmapOptions = {
                    zoom: map.getZoom(),
                    mapTypeId: google.maps.MapTypeId.TERRAIN,
                    center: mapcenter,
                    disableDefaultUI: true,
                    scrollwheel: false,
                    keyboardShortcuts: false,
                    disableDoubleClickZoom: true,
                    draggable: false

                }
                lensmap = new google.maps.Map(document.getElementById("lensmap"), lensmapOptions);
                var lensrectangle = new google.maps.Rectangle();
                var lensrectangleoptions = {
                    strokeColor: "#FF0000",
                    strokeOpacity: 0.8,
                    strokeWeight: 1,
                    fillColor: "#FF0000",
                    fillOpacity: 0.1,
                    map: lensmap,
                    bounds: map.getBounds()
                };
                lensrectangle.setOptions(lensrectangleoptions);

                markerlensmapClusterer = new MarkerClusterer(lensmap, []);


                function updateLensmapCenter() {

                    //var currentZoom = map.getZoom();
                    if (lensmap.getCenter() !== map.getCenter()) {
                        lensmap.setCenter(map.getCenter());
                    };
                    if (lensmap.getZoom() !== map.getZoom()) {
                        lensmap.setZoom(map.getZoom()-4);
                    };
                    lensrectangle.setBounds(map.getBounds());

                }

                google.maps.event.addListener(map, 'bounds_changed', function () {

                    mapcenter = map.getCenter();
                    //$("#bestandssuche").val('Bestandssuche') .clearfield();
                    
                    if( $('#syncstreetview').is(':checked')){
                        panorama.setPosition(mapcenter);
                    };
                    if( $('#visibleMarkers').is(':checked')){
                        allmarkers = markerClusterer.getMarkers();
                        repositoryTable.fnClearTable();
                        visibleMarkers = [];
                        $.each(markerClusterer.getMarkers(),function(index, marker){
                            if (map.getBounds().contains(marker.getPosition())){
                                // console.log(value.position);
                                //console.log(index);
                                visibleMarkers.push(marker);
                                
                                repositoryTable.fnAddData(  [
                                    marker.markerData['id'],
                                    marker.markerData['label'],
                                    marker.markerData['description'],
                                    marker.markerData['plz'],
                                    marker.markerData['leistungswert1'],
                                    
                                    '<img src="images/markers/marker_' + marker.markerData['stellenart'].toLowerCase() +'.png"/>'+ marker.markerData['stellenart'],
                                    
                                    //marker.markerData['stellenart'],
                                    marker.markerData['preis'],
                                    marker.markerData['beleuchtung'],
                                    marker.markerData['standortnr'],
                                    marker.markerData['belegdauerart'],
                                    marker.markerData['bauart'],
                                    marker.markerData['hoehe'],
                                    marker.markerData['breite']

                                ], false );
                                
                            };
                        });
                        repositoryTable.fnDraw();
                        console.log(visibleMarkers.length);
                        $('#visibleMarkers').button( "option", "label", visibleMarkers.length);
                        
                    };
                    updateLensmapCenter();
                    if (markerClusterer) createQuickGraph();
                    // $('#visibbleMarkers').removeData();
                    // allMarkers = markerClusterer.getMarkers();
                    
                });



                pb = new progressBar();
                map.controls[google.maps.ControlPosition.TOP].push(pb.getDiv());
                pservice = new google.maps.places.PlacesService(map);
                

                var centerListener = new google.maps.event.addListener(map,'bounds_changed', function(){
                    mapcenter = map.getCenter();
                    geocoder.geocode( {'latLng': mapcenter},
                    function(results, status) {
                        $('#address').val(results[0].formatted_address);

                    });
                });


                map.enableKeyDragZoom({
                    visualEnabled: true,
                    visualPosition: google.maps.ControlPosition.LEFT,
                    visualPositionOffset: new google.maps.Size(35, 0),
                    visualPositionIndex: null,
                    visualSprite: "http://maps.gstatic.com/mapfiles/ftr/controls/dragzoom_btn.png",
                    visualSize: new google.maps.Size(20, 20),
                    visualClass: 'zoomControl',
                    visualTips: {
                        off: "Zoom Rechteck",
                        on: "Aus"
                    },
                    boxStyle: {border: "2px solid #00FF00"}
                });
                var dz = map.getDragZoomObject();
                google.maps.event.addListener(dz, 'dragend', function (bnds) {

                    if($('#RECTZOOM').is(':checked')){
                        //alalert('KeyDragZoom Ended: ' + bnds);
                        apiRequest('bounds', bnds);
                    };
                });

                var styledMapOptions01 = {
                    name: "Duopoly"
                };

                var styledMapOptions02 = {
                    name: "Arterien"
                };
                var styledMapOptions03 = {
                    name: "Verkehrsdichte"
                };
                var styledMapOptions04 = {
                    name: "Umrisse"
                };
                var styledMapOptions05 = {
                    name: "Blanko"
                };



                var mapType01 = new google.maps.StyledMapType(stylez01, styledMapOptions01);
                var mapType02 = new google.maps.StyledMapType(stylez02, styledMapOptions02);
                var mapType03 = new google.maps.StyledMapType(stylez03, styledMapOptions03);
                var mapType04 = new google.maps.StyledMapType(stylez04, styledMapOptions04);
                var mapType05 = new google.maps.StyledMapType(stylez05, styledMapOptions05);

                map.mapTypes.set(MAPTYPE_01, mapType01);
                map.mapTypes.set(MAPTYPE_02, mapType02);
                map.mapTypes.set(MAPTYPE_03, mapType03);
                map.mapTypes.set(MAPTYPE_04, mapType04);
                map.mapTypes.set(MAPTYPE_05, mapType05);
                
                streetviewpanorama = new google.maps.StreetViewPanorama(document.getElementById("streetview"));
                map.setStreetView(streetviewpanorama);
                panorama = map.getStreetView();
                panorama.setPosition(map.getCenter());
                panorama.setPov({
                    heading: 0,
                    zoom:1,
                    pitch:0
                });
                google.maps.event.addListener(map, "rightclick",function(event){showContextMenu(event.latLng);});
                google.maps.event.addListener(map, "click", function(event) {
                    $('.contextmenu').remove();
                    rightclickmarker.setMap(null);
                });
    
                //apiRequest(startlat, startlng, startsize);
                //var markers =[];
                //var markerClusterer = new MarkerClusterer(map, markers);
                //earth = new GoogleEarth(map);
                //apiRequest('init','init');

            }
            // EO initfunction
            //////////////////////////////////////////////////////////////////////////
            
            function stafilter(){
                var stafilter = encodeURI($("form#Stellenartenfilter select")
                .multiselect("getChecked")
                .map(function(){
                    return this.value;	
                }).get().join(","));
                return stafilter;
            }
            
            function ustafilter(){
                var ustafilter = encodeURI($("form#Unterstellenartenfilter select")
                .multiselect("getChecked")
                .map(function(){
                    return this.value;	
                }).get().join(","));
                return ustafilter;
            }
            
            function placesfilter(){
                var placesfilter = $("form#Placesfilter select")
                .multiselect("getChecked")
                .map(function(){
                    return this.value;	
                }).get();
                return placesfilter;
                //.join("','"));
                //console.log(placesfilter);
                //return "'"+ustafilter+"'";
                //return ("'"+placesfilter+"'");
            }


            function apiRequest(lat,lng){
                console.log(lat + ' ' + lng);
        
                if (lat == 'init'){
                    var api = 'api.php?command=5';
                    //var latlng = mapcenter;
                } else if(lat=='bestandssuche'){
                    var api='api.php?command=2&'+ $.param(lng)+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                    console.log(api);
                    if (lng.latitude >0 && lng.longitude > 0) {
                        mapcenter = new google.maps.LatLng(lng.latitude, lng.longitude);
                        console.log(mapcenter);
                    } else {
                        geocoder.geocode( { 'address': lng.label}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                mapcenter = (results[0].geometry.location);
                                console.log(mapcenter);
                            } else {
                                alert("Geocode was not successful for the following reason: " + status);
                            }
                        });
                    }

                }
                
                else if (lat == 'bounds'){
                    //Zeichenkette der Form "lat_lo,lng_lo,lat_hi,lng_hi"
                    var api = 'api.php?command=6&bounds='+lng.toUrlValue()+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                } else if (lat == 'polygon'){
                    //Zeichenkette der Form "lat_lo,lng_lo,lat_hi,lng_hi"
                    //var api = 'api.php?command=7&bounds='+lng.toUrlValue(); 
                    var api = 'api.php?command=7&bounds=' + encodeURI($.toJSON(lng))+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                    //bounds = poly.getBounds();
                    //alert(api);

                } else if (lat=='geonotes'){
                    console.log(lng);
                    return;
                } else if (lat=='merkliste'){
                    console.log(lng);
                    return;
                }
                
                else if (lat=='gdmload'){
                    /**
                     * @todo: fix arrays -> JSON, make apiCallBack() public available!
                     */
                    alert(apiCallBack(lng));

                }else if(lat =='postdata'){

                    var api = 'api.php?command=8&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                    //alert (api+lng);
                    //$.post(api,lng,apiCallBack);
                    $.ajax({
                        type: 'POST',
                        url: api,
                        data: lng,
                        success: apiCallBack,
                        dataType: 'json'
                    });
                    if ($('#drawplz').is(':checked')){
                        $.getJSON('api.php?command=graphics&'+lng, function(data){
                            //console.log(data);
                            var latlngBounds = new google.maps.LatLngBounds();
                            $.each(data, function(index, value){
                                var plzpoly = new google.maps.Polygon({
                                    //path: latlngs,
                                    strokeColor: "#0000ff",
                                    strokeOpacity: 1.0,
                                    strokeWeight: 1,
                                    fillColor: "#0000ff",
                                    fillOpacity: 0.03,
                                    clickable: false,
                                    geodesic: true
                                });
                                var polydata = value.poly;
                                var mybounds = new google.maps.LatLngBounds();
                                polydata = polydata.split(',');
                                $.each(polydata, function(idx, val){
                                    var coords = val.split(' ');
                                    //console.log(coords[0] +' '+coords[1]);
                                    var latlng = new google.maps.LatLng(coords[1],coords[0]);
                                    latlngBounds.extend(latlng);
                                    mybounds.extend(latlng);
                                    var path = plzpoly.getPath();
                                    path.push(latlng);
                                });
                                plzpoly.setMap(map);  
                                var polycenter = mybounds.getCenter();
                                console.log(polycenter);
                                new MapLabel({
                                    map: map,
                                    text: value.plz,
                                    position: polycenter,
                                    fontColor: '#0000ff',
                                    minZoom: 10
                                });
                            });
                            map.fitBounds(latlngBounds);
                        });
                    };
                    return;
                } else {
                    var api = 'api.php?command=4&latitude='+lat+'&longitude='+lng+'&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                    mapcenter = new google.maps.LatLng(lat,lng);
                }
                
                $.getJSON(api, apiCallBack);
                if (lat!= 'polygon' && lat!='bounds'){
                    map.panTo(mapcenter);
                    centermarker.setPosition(mapcenter);
                    centermarker.setMap(map);
                    circle.setRadius(umkreis);
                    circle.setCenter(mapcenter);
                    map.fitBounds(circle.getBounds());
                }
                function apiCallBack(data){
                    pb.hide();
                    var markers= [];
                    var maxNum = data.length;
                    //var searchnode = $('#address').val();
                    //                    $('#tree-control').dynatree('getTree') .getNodeByKey('search-history').addChild({
                    //                        title: searchnode,
                    //                        key: searchnode,
                    //                        isFolder: true
                    //                    });


                    pb.start(maxNum);

                    //                    var styleIcon = new StyledIcon(StyledIconTypes.BUBBLE,{
                    //                                color:'ffffec',text:'!', fore:'1234ff'});
                    //                    var markerimage = new google.maps.MarkerImage(
                    //                    'images/marker-image.png',
                    //                    new google.maps.Size(53,52),
                    //                    new google.maps.Point(0,0),
                    //                    new google.maps.Point(27,52)
                    //                );

                    /**
                     * to be fixed!
                     */
                    var markershadow = new google.maps.MarkerImage(
                    'images/markers/shadow.png',
                    new google.maps.Size(53,39),
                    new google.maps.Point(0,0),
                    new google.maps.Point(15,39)

                );
                    /**
                     * to be fixed!
                     */
                    var markershape = {
                        coord: [19,0,22,1,23,2,24,3,25,4,26,5,27,6,27,7,28,8,28,9,28,10,28,11,28,12,28,13,28,14,28,15,28,16,28,17,28,18,27,19,27,20,26,21,25,22,25,23,24,24,23,25,22,26,21,27,21,28,20,29,19,30,19,31,18,32,17,33,17,34,16,35,16,36,16,37,15,38,13,38,12,37,12,36,11,35,11,34,10,33,10,32,9,31,9,30,8,29,7,28,6,27,6,26,5,25,4,24,3,23,3,22,2,21,1,20,1,19,0,18,0,17,0,16,0,15,0,14,0,13,0,12,0,11,0,10,0,9,0,8,1,7,1,6,2,5,3,4,4,3,5,2,6,1,8,0,19,0],
                        type: 'poly'
                    };

                    if (!markerClusterer){
                        markerClusterer = new MarkerClusterer(map, markers);
                        markerClusterer.setMaxZoom(clusterzoom);
                    };

                    if(!$('#append').is(':checked')){
                        //alert ('no append!');
                        if (markerClusterer) {markerClusterer.clearMarkers();};
                        $('#markersRepository').removeData();
                        repositoryTable.fnClearTable();
                        if(markerPlacesClusterer){markerPlacesClusterer.clearMarkers();};
                        //$('#tree-control').dynatree('getTree').getNodeByKey('search-history') .removeChildren();
                    };
                    
                    tagged = $.evalJSON($.Storage.get('tagged'));


                    for (var i = 0; i < maxNum; ++i) {
                        if (!$('#markersRepository').data(data[i].id+'')){
                            //                            $('#tree-control').dynatree('getTree') .getNodeByKey(searchnode).addChild({
                            //                                title: data[i].id
                            //                            });
                            latlng = new google.maps.LatLng(data[i].latitude,data[i].longitude);
                            markertext = data[i].id;
                            markerimage = new google.maps.MarkerImage(
                            'images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png',
                            new google.maps.Size(29,39),
                            new google.maps.Point(0,0),
                            new google.maps.Point(15,39)

                        );

                            //var marker = new MarkerWithLabel({
                            var markerdata = {
                                id: data[i].id,
                                latitude:data[i].latitude,
                                longitude:data[i].longitude,
                                label:data[i].label,
                                description: data[i].description,
                                plz: data[i].plz,
                                stellenart: data[i].stellenart,
                                leistungswert1: data[i].leistungswert1,
                                ortskennziffer: data[i].ortskennziffer,
                                preis: data[i].preis,
                                beleuchtung: data[i].beleuchtung,
                                standortnr: data[i].standortnr,
                                belegdauerart: data[i].belegdauerart,
                                bauart: data[i].bauart,
                                hoehe: data[i].hoehe,
                                breite: data[i].breite,
                                aktiverstatus: data[i].aktiverstatus};
                            
                            var marker = new google.maps.Marker ({
                                position: latlng,
                                draggable: false,
                                icon: markerimage,
                                shadow: markershadow,
                                shape: markershape,
                                title: markertext,
                                labelContent: markertext,
                                labelAnchor: new google.maps.Point(10, 30),
                                labelClass: "ui-state-highlight",
                                labelStyle: {opacity: 0.75},
                                markerData: markerdata,
                                tagged: 'untagged',
                                oimage: 'images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png'
                            });
                            attachInfoBubble(marker,data[i]);
                            //tagged = $.evalJSON($.Storage.get('tagged'));
                            if (tagged){
                                $.each(tagged, function(){
                                    if (this.id == data[i].id){
                                        console.log('tagged new marker');
                                        marker.set('tagged', 'tagged');
                                        markerimage = new google.maps.MarkerImage('images/mapicons/database.png');
                                        marker.setIcon(markerimage);
                                    };
                                });
                            }
                            //var markerid = data[i].id;
                            markerRightClickMenu = new google.maps.event.addListener(marker,'rightclick', function(e,marker){
                                //                                //console.log(e);
                                showMarkerContextMenu(e.latLng, this.get('markerData').id);
                    
                            });
                                
                            markerClusterer.addMarker(marker);
                            setTimeout('pb.updateBar(1)',3000);
                            
                            
                            $('#markersRepository').data(data[i].id, markerdata);
                            repositoryTable.fnAddData( [
                                data[i].id,
                                data[i].label,
                                data[i].description,
                                data[i].plz,
                                data[i].leistungswert1,
                                '<img src="images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png"/>'+ data[i].stellenart,
                                //data[i].stellenart,
                                data[i].preis,
                                data[i].beleuchtung,
                                data[i].standortnr,
                                data[i].belegdauerart,
                                data[i].bauart,
                                data[i].hoehe,
                                data[i].breite

                            ], false );
                        }
                    }
                    $('#markercounter').val(markerClusterer.getTotalMarkers());
                    setTimeout('pb.hide()',5000);
                    repositoryTable.fnDraw();
                    createQuickGraph();

                    if($('#applyplaces').is(':checked')){
                        //alert('finding places now');
                        getPlacesByRadius(umkreis, map.getCenter());
                    };
                    

                }
            }

            function getPlacesByBounds(bounds){
                //var bounds = map.getBounds();
                var placestypes = placesfilter();
                //console.log(placestypes);
                var request = {bounds: bounds,types: placestypes };
                pservice.search(request, showPlaces);
            }
            
            function getPlacesByRadius(umkreis, latlng){
                //var bounds = map.getBounds();
                var placestypes = placesfilter();
                //console.log(placestypes);
                var request = {radius: umkreis,types: placestypes,location: latlng };
                pservice.search(request, showPlaces);
            }

            function showPlaces(results, status){
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    for (var i = 0; i < results.length; i++) {
                        var place = results[i];
                        /**
                         * place.name durch ID ersetzen!
                         */
                        if(!$('#placesRepository').data(place.name)){
                            createPlaceMarker(place);
                            //                            $('#tree-control').dynatree('getTree') .getNodeByKey('places') .addChild({
                            //                                title: place.name
                            //                            });
                            /**
                             * erg�nzen!
                             */
                            $('#placesRepository').data(place.name, {
                                latitude:place.geometry.location.lat(),
                                longitude:place.geometry.location.lng()
                            });
                        }
                    }
                }
            }

            function createPlaceMarker(place) {
                var placeLoc = place.geometry.location;
                var category = place.types;
                //console.log(category[0]);
                var icon = new google.maps.MarkerImage('images/mapicons/'+category[0]+'.png');
                var marker = new google.maps.Marker({
                    //map: map,
                    position: new google.maps.LatLng(placeLoc.lat(), placeLoc.lng()),
                    icon: icon
                });
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent(place.name + ' ' +place.types + ' '+place.vicinity);
                    infowindow.open(map, this);
                });
                if (!markerPlacesClusterer){
                    markerPlacesClusterer = new MarkerClusterer(map);
                    style=[{
                            url: 'images/conv30.png',
                            height: 27,
                            width: 30,
                            anchor: [3, 0],
                            textColor: '#ff00ff',
                            opt_textSize: 10
                        }, {
                            url: 'images/conv40.png',
                            height: 36,
                            width: 40,
                            opt_anchor: [6, 0],
                            opt_textColor: '#ff0000',
                            opt_textSize: 11
                        }, {
                            url: 'images/conv50.png',
                            width: 50,
                            height: 45,
                            opt_anchor: [8, 0],
                            opt_textSize: 12
                        }];
                    markerPlacesClusterer.setStyles(style);
                    markerPlacesClusterer.setMaxZoom(clusterzoom);
                    markerPlacesClusterer.addMarker(marker);
                } else {
                    markerPlacesClusterer.addMarker(marker);
                }
            }

            function attachInfoBubble(marker,data){
                google.maps.event.addListener(marker, 'click', function(){
                    if(infoBubble.isOpen()){
                        infoBubble.close();
                    };
                    
                    showInfoBubble(marker,data);
                    if( $('#syncstreetview').is(':checked')){
                        map.setCenter(marker.getPosition());
                        
                        infoBubble.open(streetviewpanorama, marker);
                    };
                    //                    $('#tree-control').dynatree('getTree') .getNodeByKey('details-history') .addChild({
                    //                        title: data.id, marker: marker
                    //                    });
                });

            }

            function showInfoBubble(marker,data){
                //clearInstanceListeners(marker);
                infoBubble = new InfoBubble({
                    minWidth: 100,
                    maxWidth: 300,
                    minHeight: 100,
                    maxHeight: 400,
                    content: data.label,
                    draggable: true,
                    shadowStyle: 1,
                    arrowStyle: 1,
                    arrowSize: 12,
                    arrowPosition: 50,
                    disableAutoPan: true
                });
                infoBubbleTab1 = '<img src="img/240x240/'+data.id+'.png"/>'+ data.ortskennziffer +': '
                    +data.description + data.standortnr +' '+data.stellenart + ' ' + data.beleuchtung + ' '
                    + data.bauart + ' '+data.aktiverstatus+ ' '+data.preis;
                infoBubble.addTab(data.id, infoBubbleTab1);

                //                infoBubble.addTab('Info', data.standortnr +' '+data.stellenart + ' ' + data.beleuchtung + ' '
                //                    + data.bauart + ' '+data.aktiverstatus+ ' '+data.preis); ///dummy
                //
                //                var notizString = '<textarea rows = "2" cols ="20">'+data.id+'</textarea>';
                //                infoBubble.addTab('Notiz', notizString);
                if (!infoBubble.isOpen()){infoBubble.open(map,marker);}



            }

            function toggleStreetView() {
                var toggle = panorama.getVisible();
                if (toggle == false) {
                    panorama.setPosition(map.getCenter());
                    panorama.setVisible(true);
                } else {
                    panorama.setVisible(false);
                }
            }

            function panoramioToggle() {
                if (pLtoggle == 0){

                    panoramioLayer.setMap(map);
                    pLtoggle = 1;
                } else {
                    panoramioLayer.setMap();
                    pLtoggle = 0;
                }}

            function clearClusterer(){
                if (markerClusterer) markerClusterer.clearMarkers();
                if (markerPlacesClusterer) markerPlacesClusterer.clearMarkers();
                createQuickGraph();
                $('#markersRepository').removeData();
                repositoryTable.fnClearTable();
                $('#placesRepository').removeData();
                
                $('#markercounter').val(markerClusterer.getTotalMarkers());
                $('#address').val('');
                infoBubble.close();
                //                $('#tree-control').dynatree('getTree').getNodeByKey('search-history') .removeChildren();
                //                $('#tree-control').dynatree('getTree').getNodeByKey('details-history') .removeChildren();
                //                $('#tree-control').dynatree('getTree').getNodeByKey('places') .removeChildren();
            }

            //////////////////////////////////////////////////////////////////////////

            function calcRoute() {
                var start = $('#startlatitude').val() +','+ $('#startlongitude').val();
                var end = $('#ziellatitude').val() +','+ $('#ziellongitude').val();
                // alert (start +'   '+end)
                var waypts = [];

                var request = {
                    origin: start,
                    destination: end,
                    waypoints: waypts,
                    avoidHighways: true,
                    optimizeWaypoints: true,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING

                };
                directionsDisplay.setMap(map);
                distance = parseFloat(umkreis) / 1000; // m -> km

                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                        var coords = response.routes[0].overview_path;
                        //alert(coords);
                        var route = response.routes[0];
                        //var path = response.routes[0].overview_path;
                        clearBoxes();
                        var boxes = routeBoxer.box(coords, distance);
                        drawBoxes(boxes);

                        var summaryPanel = document.getElementById("directions_panel");
                        var text ='';
                        summaryPanel.innerHTML = "";
                        // For each route, display summary information.
                        for (var i = 0; i < route.legs.length; i++) {
                            var routeSegment = i + 1;
                            text += '<input id="streckenkoordinaten" type="hidden" value="'+coords+'"/>';
                            text += '<a href="api.php?command=4&'+$('#geocoder').serialize()+'">';

                            text += '<div class="ui-icon fff-icon-zoom" style="float:left"></div>';
                            text += 'Segment '  + routeSegment + ": ";
                            text += $("#startadresse").val() + " -> ";
                            text += $("#zieladresse").val() + " | ";
                            text += route.legs[i].distance.text + '</a>';

                            summaryPanel.innerHTML = text;
                        }
                        $('#zwischenstop').val('');
                        //$('#zwischenstopliste').html('');
                        $('#directions_panel a').button();
                    }
                });
            }

            function drawBoxes(boxes) {
                boxpolys = new Array(boxes.length);
                for (var i = 0; i < boxes.length; i++) {
                    boxpolys[i] = new google.maps.Rectangle({
                        bounds: boxes[i],
                        fillOpacity: 0,
                        strokeOpacity: 1.0,
                        strokeColor: '#00FF00',
                        strokeWeight: 1,
                        clickable: false,
                        map: map
                    });
                    /**
                     * lookup rectangle bounds: boxes[i]
                     * from API & create markers:
                     * apiRequest(lat, lng): modify to bounds: boxes[i] !!!!
                     */
                    getPlacesByBounds(boxes[i]);
                    apiRequest('bounds', boxes[i]);
                }
            }

            function clearBoxes() {
                if (boxpolys != null) {
                    for (var i = 0; i < boxpolys.length; i++) {
                        boxpolys[i].setMap(null);
                    }
                }
                boxpolys = null;
            }

            function getCanvasXY(currentLatLng){
                var scale = Math.pow(2, map.getZoom());
                var nw = new google.maps.LatLng(
                map.getBounds().getNorthEast().lat(),
                map.getBounds().getSouthWest().lng()
            );
                var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
                var worldCoordinate = map.getProjection().fromLatLngToPoint(currentLatLng);
                var currentLatLngOffset = new google.maps.Point(
                Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
                Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
            );
                return currentLatLngOffset;
            }
            function setMenuXY(currentLatLng){
                var mapWidth = $('#map_canvas').width();
                var mapHeight = $('#map_canvas').height();
                var menuWidth = $('.contextmenu').width();
                var menuHeight = $('.contextmenu').height();
                var clickedPosition = getCanvasXY(currentLatLng);
                var x = clickedPosition.x ;
                var y = clickedPosition.y ;

                if((mapWidth - x ) < menuWidth)
                    x = x - menuWidth;
                if((mapHeight - y ) < menuHeight)
                    y = y - menuHeight;

                $('.contextmenu').css('left',x  );
                $('.contextmenu').css('top',y );
            };
            function showContextMenu(currentLatLng  ) {
                var contextmenuDir;
                rightclickmarker.setPosition(currentLatLng);//
                rightclickmarker.setMap(map);
                mapcenter = currentLatLng;
                $('.contextmenu').remove();
                contextmenuDir = document.createElement("div");
                contextmenuDir.className  = 'contextmenu ui-widget ui-widget-content ui-corner-all';
                contextmenuDir.innerHTML = "Mapfunktionen<hr/><a id='mapcontextmenu2' class='ui-hover' onclick='setCenterMarker(mapcenter)'><div class=context>Hier zentrieren</div></a>"
                    + "<a id='mapcontextmenu3' class='ui-hover' onclick='newGeoNote(mapcenter)'><div class=context>Geo-Notiz</div></a>"
                    + "<a id='mapcontextmenu4' class='ui-hover' onclick='newDbEntry(mapcenter)'><div class=context>Neuer Eintrag</div></a>"
                    + "<hr/><a id='mapcontextmenuexit' class='ui-hover' onclick=\"$('.contextmenu').remove();\"><div class=context>Menue schliessen</div></a>";
                $(map.getDiv()).append(contextmenuDir);
                setMenuXY(currentLatLng);
                contextmenuDir.style.visibility = "visible";
            }
            
            
            
            //var geoNotes = new Array();
            var myLocalStorage = new Array();
            var geoNoteMarkers = new Array();
            
            var tagged = new Array();
            
            function newGeoNote(latlng){
                geocoder.geocode( {'latLng': latlng},
                function(results, status) {
                    $('#address').val(results[0].formatted_address);
                });
                $('#geoNoteEdit').dialog('option', 'title', $('#address').val());
                $('#geoNoteEdit').dialog('open');
                $('#geoNoteEdit').data('latlng', latlng);
            }
            
            function saveGeoNote(latlng){
                var geoNote = new Object();
                geoNote = {'lat': latlng.lat(),'lng':latlng.lng(), 
                    'location':$('#address').val(), 'geoNote': $('#geoNoteEdit textarea').val()};
                myLocalStorage.push(geoNote);
                //console.log(myLocalStorage.length);
                $.Storage.set('myGeoNotes', $.toJSON(myLocalStorage));
                var icon = new google.maps.MarkerImage('images/mapicons/point_of_interest.png');
                var geoNoteMarker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: geoNote.location,
                    icon: icon,
                    draggable: false
                });
                var thisnote = geoNote.geoNote;
                var thistitle = geoNote.location;
                new google.maps.event.addListener(geoNoteMarker,'click', function(){
                    var foo = "<div title='"+ thistitle +"'>" + ': ' + thisnote +"</div>";
                    $(foo).dialog();
                    
                });
                geoNoteMarkers.push(geoNoteMarker);
            }
            function clearGeoNoteMarkers(){
                $.Storage.remove('myGeoNotes');
                myLocalStorage = [];
                $.each(geoNoteMarkers, function(){
                    this.setMap(null);              
                });
                geoNoteMarkers = [];
            }
            function clearTaggedMarkers(){
                $.Storage.remove('tagged');
                tagged = new Array();
                $.each(markerClusterer.getMarkers(), function(){
                    
                    if(this.get('tagged')== 'tagged'){
                        this.set('tagged', 'untagged');
                        // retrieve old marker image!!!
                        var markerimage = new google.maps.MarkerImage(this.get('oimage'));
                        this.setIcon(markerimage);
                    }
                    
                });
            }
            
            function showMarkerContextMenu(currentLatLng, markerid) {
                console.log(markerid);
                var contextmenuDir;
                $('.contextmenu').remove();
                contextmenuDir = document.createElement("div");
                contextmenuDir.className  = 'contextmenu ui-widget ui-widget-content ui-corner-all';
                contextmenuDir.innerHTML = "Markerfunktionen #"+markerid+"<hr/><a id='markercontextmenu2' class='ui-hover' onclick='cartAdd("+markerid+")'><div class=context>auf Merkliste</div></a>"
                    + "<a id='markercontextmenu3' class='ui-hover' onclick='cartRemove("+markerid+")'><div class=context>Von Merkliste entfernen</div></a>"
                    + "<a id='markercontextmenu4' class='ui-hover' onclick='editDbEntry("+markerid+")'><div class=context>Eintrag bearbeiten</div></a>"
                    + "<hr/><a id='markercontextmenuexit' class='ui-hover' onclick=\"$('.contextmenu').remove();\"><div class=context>Menue schliessen</div></a>";
                //dbedit/index.php?-table=STA&-action=edit&-cursor=2&-skip=0&-limit=50&-mode=list&-recordid=STA%3Fcount=5464
                $(map.getDiv()).append(contextmenuDir);
                setMenuXY(currentLatLng);
                contextmenuDir.style.visibility = "visible";
            }
            
            
            
            function cartAdd(markerid){
                console.log(markerid+' cartAdd');
                $('.contextmenu').remove();
                tagged = $.evalJSON($.Storage.get('tagged'));
                
                $.each(markerClusterer.getMarkers(), function(){
                    if (this.get('markerData').id== markerid)
                    {
                        if(this.get('tagged')!= 'tagged'){
                            this.set('tagged', 'tagged');
                            markerimage = new google.maps.MarkerImage('images/mapicons/database.png');
                            this.setIcon(markerimage);
                            if(!tagged){tagged = new Array()};
                            tagged.push({'id': markerid});
                            console.log(markerid + ' tagged.');
                            $.Storage.set('tagged', $.toJSON(tagged));
                        }
                    }
                });
            }
            function cartRemove(markerid){
                console.log(markerid+' cartRemove');
                tagged = $.evalJSON($.Storage.get('tagged'));
                $.each(markerClusterer.getMarkers(), function(){
                    if (this.get('markerData').id== markerid)
                    {
                        if(this.get('tagged')== 'tagged'){
                            this.set('tagged', 'untagged');
                            markerimage = new google.maps.MarkerImage(this.get('oimage'));
                            this.setIcon(markerimage);
                            
                            tagged.pop({'id': markerid});
                            
                            console.log(markerid + ' untagged.');
                            $.Storage.set('tagged', $.toJSON(tagged));
                        }
                    }
                });
                
                $('.contextmenu').remove();
            }
            function editDbEntry(markerid){
                console.log(markerid+' editDbEntry');
                $('.contextmenu').remove();
            }


            function setCenterMarker(mapcenter){
                //alert (mapcenter);
                map.panTo(mapcenter);
                centermarker.setPosition(mapcenter);
                $('.contextmenu').remove();
                google.maps.event.trigger(map, 'dragend');
            }





        </script>
        <?php
        // include('include/googletracking.inc.php');
        ?>

    </head>
    <body style="overflow:hidden;">
        <div id="loader" style="width: 100%; height: 100%; z-index: 100000000; position: absolute; top:0; left:0; background: #ffffff; background-image: url('headerbox.png'); background-position: center;background-repeat: no-repeat;text-align: center;">
            <!--<div id="innerloader" style="z-index: 100000000; background: url('headerbox.png'); 
            position: absolute; top: 0; left:0; width:100%;height: 240px; margin-left: auto;margin-right: auto; opacity: .73; background-position: center top; background-repeat: no-repeat;">                
            </div>-->
            <div id="gdmlogo" class="ui-widget ui-widget-content" style="width:30%; margin-top: 22%;margin-left: auto;margin-right: auto; opacity: .8">
                <img src="ui-anim_basic_16x16.gif" style="float: right"/>
                <!--<img style="float: none; margin:0;border:0;" src="banner.png"/> -->
                <h2 style ="text-align: center;  padding: 1em; border: 0 solid silver">GeoDataMapper V0.3dev</h2>
                <em>Expertentool f�r Geomarketing &amp; Au&szlig;enwerbung</em>
                <p>lade Interface...</p>
            </div>
        </div>
        <div class="ui-layout-north">
            <img src="banner.png" style ="float: none; margin:0;border:0; height: 18px; "/> GDM 0.3
            <span id="switcher" style="position: absolute; top:0;right:0"></span>
            <div style ="float:right;" class="ui-widget vtip" title="Klicken Sie hier um direkten Kontakt mit ihrem Berater aufzunehmen oder eine Nachricht zu hinterlassen."><!-- LiveZilla Chat Button Link Code (ALWAYS PLACE IN BODY ELEMENT) --><a href="javascript:void(window.open('http://raderthalmedien.de/support/chat.php','','width=590,height=610,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))"><img src="http://raderthalmedien.de/support/image.php?id=01&amp;type=inlay" width="120" height="30" border="0" alt="LiveZilla Live Help"></a><!-- http://www.LiveZilla.net Chat Button Link Code --><!-- LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">
                var script = document.createElement("script");script.type="text/javascript";var src = "http://raderthalmedien.de/support/server.php?request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><noscript><img src="http://raderthalmedien.de/support/server.php?request=track&amp;output=nojcrpt" width="0" height="0" style="visibility:hidden;" alt=""></noscript><!-- http://www.LiveZilla.net Tracking Code -->
            </div>
        </div>
        <div class="ui-layout-center"  style="padding:0; margin:0;">
            <div id="map_canvas" style="width: 100%; height: 100%; margin:0;">

            </div>

        </div>
        <div class="ui-layout-east">
            <div id="tabs" style="float: right; width: 100%;" class="ui-widget">


                <ul id="tablist">
                    <li class="vtip" title="Tabelle mit allen Stellen"><a href="#geo"><span id="geo_icon" class="ui-icon fff-icon-zoom" style="float:left"></span></a></li>
                    <li class="vtip" title="Dossier-Generator"><a href="#historyouter"><span class="ui-icon fff-icon-arrow-refresh" style="float:left"></span></a></li>
                    <li class="vtip" title="Merkzettel (leer)"><a href="#merkzettelouter"><span id="merkzettelouter_icon" class="ui-icon fff-icon-folder" style="float:left"></span></a></li>
                    <li class="vtip" title="Kalenderplaner"><a href="#kalenderplanung"><span class="ui-icon fff-icon-time-add" style="float:left"></span></a></li>
                    <li class="vtip" title="Routen- und Streckenplaner"><a href="#routenplanung"><span class="ui-icon fff-icon-flag-blue" style="float:left"></span></a></li>
                    <li class="vtip" title="Hilfsprogramme und Verwaltung"><a href="admin.php"><span class="ui-icon fff-icon-information" style="float:left"></span></a></li>
                </ul>

                <div id="geo">


                    <div id="map-side-bar-container"  rel="Tabelle" style="overflow: scroll; width: 380px; height:380px;">

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
                                    -->
                                    <th style="width: 25px;">ID</th><th style="width: 150px;">Kurzbezeichnung</th><th>Beschreibung</th>
                                    <th style="width: 25px;">PLZ</th><th style="width: 25px;">GFK</th><th style="width: 25px;">Stellenart</th><th>Preis</th>
                                    <th style="width: 10px;">B/U</th><th style="width: 50px;">StandortNr</th><th style="width: 50px;">BD</th>
                                    <th>Bauart</th><th>H</th><th>B</th>
                                </tr>

                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th><th>Kurzbezeichnung</th><th>Beschreibung</th>
                                    <th>PLZ</th><th>GFK</th><th>Stellenart</th><th>Preis</th>
                                    <th>B/U</th><th>StandortNr</th><th>BD</th><th>Bauart</th>
                                    <th>H</th><th>B</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div id="historyouter">
                    <div id="history" class="ui-widget-content" style="float: none; clear: both;"></div>
                    <div id="dossier" class="ui-widget ui-widget-content" style="width: 340px; right:10px; top: 10px" rel="Dossier">
                        <form id="dossierconfig">
                            <input type ="checkbox" checked name="printmap" value="printmap" id="printmap"/>
                            <label class="vtip" title="&Uuml;versichtskarte zeichnen" for="printmap">Hauptkarte</label>
                            <input type ="checkbox" name="printdetailmaps" value="printdetailmaps" id="printdetailmaps"/>
                            <label class="vtip" title="Detailkarten pro Standort zeichnen" for="printdetailmaps">Detailkarten</label>
                            <input type ="checkbox" name="printrepository" value="printrepository" id="printrepository"/>
                            <label class="vtip" title="Tabelle aller Stellen" for="printrepository">alle Stellen</label>
                            <input type ="checkbox" checked name="printplaces" value="printplaces" id="printplaces"/>
                            <label class="vtip" title="alle markierten POIs ausgeben" for="printplaces">Places</label>
                            <input type ="checkbox" name="printallplaces" value="printallplaces" id="printallplaces"/>
                            <label class="vtip" title="alle gefundenen POIs ausgeben" for="printallplaces">alle Places</label>

                            <input type ="checkbox" checked name="printmerkliste" value="printmerkliste" id="printmerkliste"/>
                            <label class="vtip" title="markierte Stellen ausgeben" for="printmerkliste">Merkliste</label>
                            <input type ="checkbox" name="printoid" value="printoid" id="printoid"/>
                            <label class="vtip" title="SDAW IDs mit ausgeben" for="printoid">SDAW-ID</label>
                            <input type ="checkbox" checked name="printprice" value="printprice" id="printprice"/>
                            <label class="vtip" title="Preise mit ausgeben" for="printprice">Preisangabe</label>

                            <input type="hidden" id="markersFormData" name="markersFormData" value=""/>
                            <input type="hidden" id="placesFormData" name="placesFormData" />
                            <input type="hidden" id="taggedFormData" name="taggedFormData" />



                            <br/><input class="vtip" title="generiert das Dossier" type ="button" id="createdossier" value="Dossier erzeugen" style="clear: left; margin-top: 1em;" />
                            <input class="vtip" title="SDAW ANG-Datei erzeugen (Angebot)" type ="button" id="ANG" value="ANG" style="float: right; margin-top: 1em;" />
                            <input class="vtip" title="SDAW AUF-Datei erzeugen (Auftrag)" type ="button" id="AUF" value="AUF" style="float: right; margin-top: 1em;" />
                            <span class="vtip" title="angezeigtes Dossier l&ouml;schen" id="resetmap" onclick="$('#history').html('');"><span  class="ui-icon fff-icon-cross" style="float:right">Reset</span></span>

                        </form>
                    </div>


                </div>

                <div id="merkzettelouter">
                    <form id="formtools" class="ui-widget ui-widget-content" style="opacity: .91; margin-top: 14px" rel="Datasets">
                        <textarea class="vtip" title="Kopieren / Einf&uuml;gen von Datasets (Format: JSON)." name="pastedata" id="pastedata" style="width: 280px; height:100px; float: none" cols="18" rows="4"></textarea>
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
                <div id="kalenderplanung"><div class="ui-icon ui-icon-calendar" style="float:left"></div>
                    <input class="vtip datum" title="Startdatum eingeben" id="startdatum"/><label for="startdatum">Start</label>
                    <input class="vtip datum" title="Enddatum eingeben"  id="enddatum"/><label for="enddatum">Ende</label>
                </div>
                <div id="routenplanung" class="ui-widget ui-widget-content" rel="Streckenplaner" style="width: 100%;height: 100%; overflow: scroll;">
                    <form>
                        <input title="Startadresse eingeben" type="text" id="startadresse" class="vtip ui-state-default clearfield" style="width: 180px;" value="Startadresse"/>
                        <span id="zwischenstopliste" class="ui-widget-content"></span>
                        <input title="Zieladresse eingeben" type="text" id="zieladresse" class="vtip ui-state-default clearfield" style="width: 180px;" value="Zieladresse"/>
                        <input type="hidden" id="startlongitude"/><input type="hidden" id="ziellongitude"/>
                        <input type="hidden" id="startlatitude"/><input type="hidden" id="ziellatitude"/>

                    </form>

                    <div id="mini_map_canvas_outer" class="ui-widget" style="padding:12px;">
                        <div class="ui-widget-content">
                            <div id="mini_map_canvas" style="width: width; height: 180px;"></div>
                        </div>
                        <div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div>
                        <input title="Ein oder mehrere Zwischenstopps hinzuf&uuml;gen" type="text" id="zwischenstop" class="vtip clearfield" style="width: 180px;" value="Zwischenstop hinzuf&uuml;gen"/>


                    </div>
                    <div title="Route l&ouml;schen" id="reset_route"  class="vtip ui-state-default" style="float:right">
                        <div class="ui-icon fff-icon-cross"></div>
                    </div>
                    <div title="Umkreissuche entlang Route durchf&uuml;hren und in Hauptkarte einzeichnen" id="suche_route"  class="vtip ui-state-default" style="float:right">
                        <div class="ui-icon fff-icon-flag-blue"></div>
                    </div>
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

                </div>
                <div id="appinfo">

                </div>

            </div>

        </div>
        <div class="ui-layout-south">
            <span id="geoNotesClear" class="button">GeoNotizen l&ouml;schen</span>
            <span id="taggedClear" class="button">Merkliste l&ouml;schen</span>
            <div id="minimized-dialog-container"></div>            
        </div>
        <div class="ui-layout-west">
            <div id="streetviewcontainer" class="ui-widget ui-widget-content" style="width: 320px; height:330px; padding-top: 10px" rel="StreetView">
                <div id="streetview"  style="width: 320px; height: 320px; margin:0; padding:0"> </div>
            </div>
        </div>
        <div id="markersRepository" class="ui-hidden-accessible">

        </div>
        <div id="placesRepository" class="ui-hidden-accessible">

        </div>
        <div id="taggedRepository" class="ui-hidden-accessible">

        </div>
        <div id="tmp" class="ui-hidden-accessible">

        </div>


        <script type="text/javascript">
            function redrawMap(){google.maps.event.trigger(map, 'resize');$('#map-side-bar-container').jScrollPane({showArrows: true});}
            $(document).ready(function(){
                //initialize();$('body').layout().resizeAll();
                //$("body").css("overflow", "hidden");
                $('#loader p').html('Initialisiere das Layout...');
                appLayout = $('body').layout({
                    applyDefaultStyles: true,
                    east: {initClosed: false, size: 380, onopen_end: redrawMap, onclose_end: redrawMap, onresize_end: redrawMap},
                    south: {initClosed: false, size: 190, onopen_end: redrawMap, onclose_end: redrawMap, onresize_end: redrawMap},
                    west: {initClosed: false, size: 380, onopen_end: redrawMap, onclose_end: redrawMap, onresize_end: redrawMap},
                    north: {initClosed: false, size: 38, onopen_end: redrawMap, onclose_end: redrawMap, onresize_end: redrawMap}
                });
                appLayout.allowOverflow('center'); 
                
                
                $.loading.classname = 'loading';
                $.loading({onAjax:true, text: 'Lade vom Server...', pulse: 'working fade', mask:true,max: 3000});
                $('#loader p').html('<span class="ui-state-active">Initialisiere Komponenten...</span>');
                initialize();
                
                
                
                $("#address").autocomplete({
                    source: function(request, response) {
                        geocoder.geocode( {'address': request.term , 'region':'DE', 'language':'de'},
                        function(results, status) {
                            response($.map(results, function(item) { 
                                //alert(item.types+' '+item.address_components[0].long_name+' '+item.address_components[1].long_name+' '+item.address_components[2].long_name);
                                val = item.address_components[0].long_name
                                    +' ('+item.address_components[1].long_name
                                    +', '+item.address_components[2].long_name
                                    +', '+item.address_components[3].long_name+')';
                                return { 
                                    label:  val,
                                    value: val,
                                    latitude: item.geometry.location.lat(),
                                    longitude: item.geometry.location.lng()
                                }
                            }));
                        });
                    },
                    select: function(event, ui) {
                        lat = ui.item.latitude;
                        lng = ui.item.longitude;
                        mapcenter = new google.maps.LatLng(lat, lng);
                        if ($('#addressUmkreisSuche').is(':checked')){
                            apiRequest(lat, lng);
                        } else {
                            map.panTo(mapcenter);
                            centermarker.setPosition(mapcenter);
                            centermarker.setMap(map);
                            circle.setCenter(mapcenter);
                        };
                    }
                });
                $('#address, .clearfield') .clearField() .button();
                $('#markercounter, #zoom, #append, #applyfilter, #applyschedule, #applyplaces, #gfkcounter,#pricecounter, #RECTPLCS .datum, #dossier input, .button') .button();
                $( ".datum" ).datepicker();
                //$('#address-container').dialog({position: 'bottom', minWidth: 360}) ;
                //$('.ui-dialog-titlebar').hide();
                //$('#draggable').css({'background': 'silver'});

                $( "#umkreis" ).slider({
                    orientation: "vertical",
                    range: "min",
                    value: umkreis,
                    min: 5,
                    max: 30000,
                    step: 5,
                    animate: true,
                    slide: function( event, ui ) {
                        centermarker.setPosition(mapcenter);
                        umkreis = ui.value;
                        $( "#zoom" ).html( umkreis +'m' );
                        circle.setRadius(umkreis);
                    }
                });
                $( "#zoom" ).html( umkreis +'m' );
                $('#zoom').live('click', function(){
                    apiRequest(mapcenter.lat(), mapcenter.lng());
                });

                $( "#clusterzoom" ).slider({
                    orientation: "vertical",
                    range: "min",
                    value: clusterzoom,
                    min: 1,
                    max: 22,
                    step: 1,
                    animate: true,
                    stop: function( event, ui ) {

                        clusterzoom = ui.value;
                        if (markerPlacesClusterer) {markerPlacesClusterer.setMaxZoom(clusterzoom); 
                            markerPlacesClusterer.resetViewport();
                            markerPlacesClusterer.redraw();
                        }
                        if (markerClusterer) {markerClusterer.setMaxZoom(clusterzoom);
                            markerClusterer.resetViewport();
                            markerClusterer.redraw();
                        }
                    }
                });
                $('#gfkzoom').slider({
                    orientation: "vertical",
                    range: true,
                    min: 0,
                    max: 500,
                    values: [ 75, 300 ],
                    step: 1,
                    animate: true,
                    slide: function( event, ui ) {
                        gfkrange = ui.values;
                        $('#gfkcounter').val(gfkrange);
                        $( "#bestandssuche" ).autocomplete( "option" , {source: 'api.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()} );
                    }
                });
                gfkrange = $('#gfkzoom').slider('values');
                $('#gfkcounter').val(gfkrange);

                $('#pricezoom').slider({
                    orientation: "vertical",
                    range: true,
                    min: 0,
                    max: 20000,
                    values: [ 1000, 10000 ],
                    step: 1,
                    animate: true,
                    slide: function( event, ui ) {
                        pricerange = ui.values;
                        $('#pricecounter').val(pricerange);
                        $( "#bestandssuche" ).autocomplete( "option" , {source: 'api.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()} );
                    }
                });
                pricerange = $('#pricezoom').slider('values');
                $('#pricecounter').val(pricerange);
                
                $( "#bestandssuche" ).autocomplete({
                    autoFocus: true,
                    source: 'api.php',
                    minLength: 3,
                    delay: 600,
                    select: function( event, ui ) {
                        console.log($.param(ui.item));
                        apiRequest('bestandssuche', ui.item);
                    }
                });
                $( "#bestandssuche" ).autocomplete( "option" , {source: 'api.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()} );

                $('#tabs').tabs();
                
                ////////////////////////////////////////////////////////////////////
                /**
                 * Controls f�r Routenplaner
                 */

                $("#startadresse").autocomplete({
                    //This bit uses the geocoder to fetch address values
                    source: function(request, response) {
                        geocoder.geocode( {'address': request.term , 'region':'de', 'language':'de'}, function(results, status) {
                            response($.map(results, function(item) {
                                return {
                                    label:  item.formatted_address,
                                    value: item.formatted_address,
                                    latitude: item.geometry.location.lat(),
                                    longitude: item.geometry.location.lng()
                                }
                            }));
                        })
                    },
                    select: function(event,ui) {
                        //directionsDisplay = new google.maps.DirectionsRenderer();
                        var standort = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
                        var myOptions = {
                            zoom: 15,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            center: standort
                        }
                        minimap = new google.maps.Map(document.getElementById("mini_map_canvas"), myOptions);
                        //directionsDisplay.setMap(minimap);
                        var marker = new google.maps.Marker({
                            position: standort,
                            map: minimap,
                            title: ui.item.value
                        });
                        $("#startlatitude").val(ui.item.latitude);
                        $("#startlongitude").val(ui.item.longitude);
                    }
                });

                $("#zieladresse").autocomplete({
                    //This bit uses the geocoder to fetch address values
                    source: function(request, response) {
                        geocoder.geocode( {'address': request.term , 'region':'de', 'language':'de'}, function(results, status) {
                            response($.map(results, function(item) {
                                return {
                                    label:  item.formatted_address,
                                    value: item.formatted_address,
                                    latitude: item.geometry.location.lat(),
                                    longitude: item.geometry.location.lng()
                                }
                            }));
                        })
                    },
                    //This bit is executed upon selection of an address
                    select: function(event, ui) {
                        //alert(ui.item.latitude);
                        //directionsDisplay = new google.maps.DirectionsRenderer();
                        var standort = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
                        var myOptions = {
                            zoom: 15,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            center: standort
                        }
                        minimap = new google.maps.Map(document.getElementById("mini_map_canvas"), myOptions);
                        //directionsDisplay.setMap(minimap);
                        var marker = new google.maps.Marker({
                            position: standort,
                            map: minimap,
                            title: ui.item.value
                        });
                        $("#ziellatitude").val(ui.item.latitude);
                        $("#ziellongitude").val(ui.item.longitude);

                    }
                });

                $("#zwischenstop").autocomplete({
                    //This bit uses the geocoder to fetch address values
                    source: function(request, response) {
                        geocoder.geocode( {'address': request.term , 'region':'de', 'language':'de'}, function(results, status) {
                            response($.map(results, function(item) {
                                return {
                                    label:  item.formatted_address,
                                    value: item.formatted_address,
                                    latitude: item.geometry.location.lat(),
                                    longitude: item.geometry.location.lng()
                                }
                            }));
                        })
                    },
                    //This bit is executed upon selection of an address
                    select: function(event, ui) {
                        //directionsDisplay = new google.maps.DirectionsRenderer();
                        var standort = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
                        var myOptions = {
                            zoom: 15,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            center: standort
                        }
                        minimap = new google.maps.Map(document.getElementById("mini_map_canvas"), myOptions);
                        //directionsDisplay.setMap(minimap);
                        var marker = new google.maps.Marker({
                            position: standort,
                            map: minimap,
                            title: ui.item.value
                        });

                        $('#zwischenstopliste').append('<span class="zwischenstop styledbutton" style="width:180px; float: right">via '+ui.item.label+"</span>");
                        $('#zwischenstopliste .zwischenstop').button();
                        $('#zwischenstop').val('');

                    }
                });

                $('#suche_route').live('click',function(){calcRoute()});
                $('#reset_route').live('click',function(){
                    $('#directions_panel, #zwischenstopliste').html('');
                    $('#startadresse,#zieladresse, #zwischenstop').val('');
                    clearBoxes();
                });
                $( "#fortbewegungsart, #pointertype, #clustertype, #formtoolsdatatype, .buttonset" ).buttonset();
                $('#RECTZOOM').bind('click', function(){
                    $('.zoomControl').trigger('click');
                });
                $('#CIRCLEDRAW').bind('click', function(){
                    circle.setMap(map);
                    poly.setMap(null);
                });
                $('#applyfilter').bind('click', function(){
                    $('#gfkzoom, #pricezoom, #extendedfilter, #gfkcounter, #pricecounter, #Stellenartenfilter, #Unterstellenartenfilter').toggle('slow');
                });
                $('#applyplaces').bind('click', function(){
                    $('#RECTPLCS, #Placesfilter').toggle('slow');

                    if (markerPlacesClusterer.getMarkers().length > 0) {
                        markerPlacesClustererTmp=markerPlacesClusterer.getMarkers();
                        markerPlacesClusterer.clearMarkers();
                        
                        //alert(markerPlacesClusterer.getMarkers().length);
                    }
                    else {

                        markerPlacesClusterer.addMarkers(markerPlacesClustererTmp);
                        markerPlacesClustererTmp = [];
                        
                    };
                });
                /**
                 * buggy buggy buggy
                 * man sollte die marker .setMappen()........
                 */

                $('#TAGGED').bind('click', function(){
                    //markerlensmapPlacesClusterer.setMap(lensmap);
                    markerlensmapClusterer.setMap(lensmap);
                    markerlensmapClusterer.clearMarkers();
                    var data = mapClusterer.getMarkers();
                    markerlensmapClusterer.addMarkers(data);
                });
                
                //////// dynamische Tables
                repositoryTable = $('#repositoryTable').dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "aoColumnDefs": [ 
                        { "bSearchable": true, "bVisible": false, "aTargets": [ 1 ] },
                        {  "bSearchable": false, "bVisible": false, "aTargets": [ 8,10,11,12 ] }
                    ],
                    "fnDrawCallback": function() {
                        //$(this).parent().data('jsp').reinitialise();;
                        $('#map-side-bar-container').jScrollPane({showArrows: true});
                    }
                });
                
                $('#repositoryTable tbody tr').live('click', function () {
                    var nTds = $('td', this);
                    $.each(markerClusterer.getMarkers(), function(index, marker){
                        if ($(nTds[0]).text()==marker.markerData['id']){
                            map.panTo(marker.getPosition());
                            centermarker.setPosition(marker.getPosition());
                        };
                    });
                    $(repositoryTable.fnSettings().aoData).each(function (){
                        $(this.nTr).removeClass('ui-state-highlight');
                    });
                    $(this).addClass('ui-state-highlight');
                });
                
                ////////////////////////////////////////////// POLYGON MARKER
                var polyi = 0;
                $('#POLYDRAW').bind('click', function(){
                    if(poly){
                        poly.setMap(null);
                    };
                    circle.setMap(null);
                    poly = new google.maps.Polyline({ map: map, path: [], strokeColor: "#00ff00", 
                        strokeOpacity: 0.8, strokeWeight: 2, clickable: false, geodesic: true });
                    polyi++;
                    var isClosed;
                    var markerIndex;

                    google.maps.event.addListener(map, 'click', function (clickEvent) {
                        if (isClosed){

                            return;
                        }
                        
                        var isFirstMarker = poly.getPath().length === 0;
                        var icon = new google.maps.MarkerImage('css/ui-icon/ico/pencil_add.png');
                        var marker = new google.maps.Marker({ map: map, position: clickEvent.latLng, draggable: false, visible: false, icon: icon });
                        if (isFirstMarker) {
                            marker.setVisible(true);
                            marker .setTitle('Polygon #'+polyi);
                            $('#address').val('Polygon #'+polyi);
                            google.maps.event.addListener(marker, 'click', function () {
                                if (isClosed)
                                    return;
                                var path = poly.getPath();
                                poly.setMap(null);
                                poly = new google.maps.Polygon({ map: map, path: path,
                                    strokeColor: "#00ff00", strokeOpacity: 0.8, strokeWeight: 2,
                                    fillColor: "#ffccaa", fillOpacity: 0.1, clickable: false, geodesic: true });
                                isClosed = true;
                                //marker.setVisible(false);
                                google.maps.event.clearListeners(marker, 'click');
                                var i = polyi;
                                google.maps.event.addListener(marker, 'click', function(){
                                    circle.setMap(null);
                                    poly.setPath(path);
                                    poly.setMap(map);
                                    $('#address').val('Polygon #'+i);
                                });
                                
                                
                                google.maps.event.addListener(marker, 'dblclick', function(){
                                    //alert(path);

                                    apiRequest('polygon',path);
                                });

                                //call api.php here: load polygon's markers'

                            });
                        }
                        google.maps.event.addListener(marker, 'drag', function (dragEvent) {
                            poly.getPath().setAt(markerIndex, dragEvent.latLng);
                        });
                        poly.getPath().push(clickEvent.latLng);
                    });
                });
                google.maps.event.addListener(centermarker,'click', function(){
                    circle.setMap(map);
                    poly.setMap(null);
                    google.maps.event.trigger(centermarker, 'dragend');
                });
                google.maps.event.addListener(centermarker,'dblclick', function(){
                    apiRequest(mapcenter.lat(), mapcenter.lng())
                });

                //$('#dossierconfig input').sortable();
                $('#createdossier').bind('click', function(){
                    var urlappend = $('#dossierconfig input').not(':hidden').serialize();
                    if($('#printrepository').is(':checked')){
                        $('#markersFormData').val('');
                        $('#markersFormData').val($.toJSON($('#markersRepository').data()));
                    };
                    if($('#printallplaces').is(':checked')){
                        $('#placesFormData').val('');
                        $('#placesFormData').val($.toJSON($('#placesRepository').data()));
                    };
                    if($('#printmerkliste').is(':checked')){
                        $('#taggedFormData').val('');
                        $('#taggedFormData').val($.toJSON($('#taggedRepository').data()));
                    };
                    $.post('dossier.php?'+urlappend,
                    $('#dossierconfig').serialize() ,
                    function(data) {
                        $('#history').html(data);
                        $('#markersFormData, #placesFormData, #tagedFormData').val('');
                    });
                    
                });

                $('#submitpastedata').bind('click', function(){
                    if (!$('#savedata').is(':checked')){
                        if($('#GDMdata').is(':checked')){

                            data = $('#formtools textarea').val();
                            data = $.evalJSON(data);
                            //alert('not implemented yet: '+ $.toJSON(data));
                            apiRequest('gdmload', data);


                        } else {
                            postdata = $('#formtools').serialize();
                            apiRequest('postdata', postdata);
                        }
                    } else {
                        var d=new Date();
                        var data = [];
                        if ($('#GDMdata').is(':checked')){
                            $('#tmp').data('version','GDM dev');
                            $('#tmp').data('timestamp',d);
                            $('#tmp').data('markers',$('#markersRepository').data());
                            $('#tmp').data('places',$('#placesRepository').data());
                            $('#tmp').data('tagged',$('#taggedRepository').data());
                            data = $('#tmp').data();
                            data = $.toJSON(data);
                        } else if ($('#SysIDs').is(':checked')){
                            $.each($('#markersRepository').data(), function(key, value) {
                                //alert(key + ': ' + value);
                                data.push(key);

                            });
                            $('#tmp').data('sysids',data);
                            data = $.toJSON($('#tmp').data('sysids'));
                        }else if ($('#SdawIDs').is(':checked')){
                            $.each($('#markersRepository').data(), function(key, value) {
                                //alert(key + ': ' + value);
                                data.push(value.standortnr);

                            });
                            data = $('#tmp').data('sdawids',data);
                            data = $.toJSON($('#tmp').data('sdawids'));
                        }else if ($('#GeoNotizen').is(':checked')){
                            data = $.Storage.get('myGeoNotes');
                        }else if ($('#Merkliste').is(':checked')){
                            data = $.Storage.get('tagged');
                        
                        } else if ($('#Coords').is(':checked')){
                            $.each($('#markersRepository').data(), function(key, value) {
                                //alert(key + ': ' + value);
                                data.push(''+value.latitude+' '+value.longitude);

                            });
                            data = $('#tmp').data('coords',data);
                            data = $.toJSON($('#tmp').data('coords'));
                        } else if ($('#Postleitzahlen').is(':checked')){
                            $.each($('#markersRepository').data(), function(key, value) {
                                //alert(key + ': ' + value);
                                var val = value.plz;
                                if ($.inArray(val,data)< 0){
                                    data.push(val);
                                };

                            });
                            data = $('#tmp').data('plz',data);
                            data = $.toJSON($('#tmp').data('plz'));
                        };
                        
                        $('#pastedata').val(data);
                        data = [];
                        $('#tmp').removeData();
                    };
                });

                //???$('body').layout().resizeAll();
                //$('#formtools, #RECTPLCS, #Placesfilter').toggle('slow');
                $('#dossier, #formtools, #streetviewcontainer, #map-side-bar-container, #routenplanung').live('dblclick', 
                function(){
                    //$(this).die('dblclick');
                    var pos = $(this).offset();
                    pos = [parseInt(pos.top), parseInt(pos.left)];
                    var myparent = $(this).parent();
                    var mycontent = $(this);
                    var dialog = null;
                    dialog = $(this).dialog({ closeOnEscape: false, 
                        position: pos,
                        hide: 'clip',
                        show: 'clip',
                        title: $(this).attr('rel'),
                        beforeClose: function(){
                            console.log('closing... a buggy thing!');
                            return false;
                            //myparent.append(mycontent);
                        },
                        resize: function(){
                            $(this).data('jsp').reinitialise();
                        }
                    })
                        
                    .dialogExtend({
                        "maximize" : true,
                        "minimize" : false,
                        "dblclick" : "collapse",
                        "titlebar" : "transparent",
                        "events": {"restore": function(){
                                $('#map-side-bar-container').jScrollPane({showArrows: true});
                            }},
                        "icons" : {
                            "maximize" : "ui-icon-circle-plus",
                            "minimize" : "ui-icon-circle-minus",
                            "restore" : "ui-icon-bullet"
                        }});
                    dialog.jScrollPane({showArrows: true})
                    //$('.ui-draggable .ui-dialog-titlebar').css('opacity','.7');
                });
                
                $('#streetviewcontainer').bind('dialogresize', function(){
                    //alert('epp');
                    $('#streetview').height($(this).height());
                    $('#streetview').width($(this).width());
                    google.maps.event.trigger(panorama, 'resize');
                });
                
                plot1 = $.jqplot('graphics', [[0, 0, 0, 0]], plot1options);
                plot2 = $.jqplot('total_counter_graphics', [[0,0,0]], plot2options);
                //var oImgPNG = Canvas2Image.saveAsPNG(document.getElementById('total_counter_graphics'), true, 240,240);
                
                $('form select optgroup option ').tsort();
                /*
                $.each($('#Placesfilter select optgroup option'),function(){
                    $(this).append('<img style="float:left; height: 12px;" src="images/mapicons/'+$(this).val()+'.png"/>');
                });
                 */
                var filtercontrols = $("form#extendedfilter select, form#Stellenartenfilter select, form#Unterstellenartenfilter select, form#Placesfilter select").multiselect({
                    position: {
                        my: 'bottom',
                        at: 'top'
                    }, 
                    header: false, minWidth: 'auto', height: '240', selectedList: 10, selectedText: '# / #', 
                    show: ['slide', 500], open: function(){
                        $('.ui-multiselect-checkboxes') .jScrollPane({showArrows: true});}
                });
                
                $.each($('#Placesfilter .ui-multiselect-checkboxes label'),function(){
                    $(this).append('<img style="float:left; height: 12px;" src="images/mapicons/'+$('input', this).val()+'.png"/>');
                });
                
                filtercontrols.bind("multiselectclick", function(event, ui){
                    $( "#bestandssuche" ).autocomplete( "option" , {source: 'api.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()} );
                });
                filtercontrols.bind("multiselectoptgrouptoggle", function(){
                    $( "#bestandssuche" ).autocomplete( "option" , {source: 'api.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()} );
                });
                
                $('#loader p').html('<span class="ui-state-active">R&auml;ume auf...</span>');
                filtercontrols.multiselect('close');
                $( "#bestandssuche" ).autocomplete( "option" , {source: 'api.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()} );
                
                $('#umkreis,#clusterzoom').css({'position':'absolute','left':'18px', 'top':'150px','margin':'5px'});
                $('#clusterzoom').position({my:'left',at:'right',of:$('#umkreis'), offset: '0'});
                $('#gfkzoom,#pricezoom').css({'position':'absolute','left':'80px', 'top':'150px','margin':'5px'});
                $('#pricezoom').position({my:'left',at:'right',of:$('#gfkzoom'), offset: '0'});
                $('#minitoolbar').css({'position':'absolute','left':'120px', 'top':'40px'});
                $('#address-container').css({'position':'absolute','left':'180px', 'top':'150px'});
                $('#address-container').position({my:'left top',at:'right top',of:$('#minitoolbar'), offset: '0'});
                
                
                
                $('#Stellenartenfilter').position({my:'left top ',at:'left bottom',of:$('#address-container'), offset: '0'});
                $('#Unterstellenartenfilter').position({my:'left',at:'right',of:$('#Stellenartenfilter'), offset: '0'});
                $('#extendedfilter').position({my:'left bottom',at:'right bottom',of:$('#Unterstellenartenfilter'), offset: '0'});
                $('#Placesfilter').position({my:'top',at:'bottom',of:$('#RECTPLCS'), offset: '0'});
                
                $('#gfkcounter').position({my:'left bottom',at:'left top',of:$('#address-container'), offset: '0'});
                $('#pricecounter').position({my:'left',at:'right',of:$('#gfkcounter'), offset: '0'});
                
                
                $('#total_counter_graphics').position({my:'left top',at:'left bottom',of:$('#umkreis'), offset: '5px'}).draggable();
                $('#graphics').position({my:'left',at:'right',of:$('#total_counter_graphics'), offset: '0'}).draggable();
                
                $('.ui-slider-handle').addClass('ui-icon fff-icon-bullet-blue');
                $('#lensmapcontainer').draggable();
                
                //unused yet
                //$('.scroll-pane').jScrollPane({showArrows: true});
                
                // user local storage!
                //if ($.Storage.get('myGeoNotes'))console.log($.Storage.get('myGeoNotes'));
                
                $('#geoNoteEdit').dialog({buttons: { "Ok": function() { 
                            saveGeoNote($('#geoNoteEdit').data('latlng'));
                            $(this).dialog("close"); 
                            $('.contextmenu').remove();
                        }}});
                $('#geoNoteEdit').dialog('close');
                $('#geoNotesClear').bind('click', function(e){
                    console.log(e);
                    clearGeoNoteMarkers();
                });
                if ($.Storage.get('myGeoNotes')) {myLocalStorage = $.evalJSON($.Storage.get('myGeoNotes'));
                    $.each(myLocalStorage, function(){
                        //console.log(this['geoNote']);
                        var latlng = new google.maps.LatLng(this['lat'], this['lng']);
                        // console.log(this['lat']+' '+ this['lng']);
                        //console.log(latlng);
                        var icon = new google.maps.MarkerImage('images/mapicons/point_of_interest.png');
                        var geoNoteMarker = new google.maps.Marker({
                            position: latlng,
                            map: map,
                            title: this['location'],
                            icon: icon,
                            draggable: false
                        });
                        var note = this['geoNote'];
                        var title = this['location'];
                        new google.maps.event.addListener(geoNoteMarker,'click', function(){
                            var foo = "<div title='"+ title +"' class='geonotiz'><img src='images/mapicons/point_of_interest.png' style='float:left; margin: 10px;'/>"+note+"</div>";
                            $(foo).dialog();
                        });
                        geoNoteMarkers.push(geoNoteMarker);
                    })};
                tagged = $.evalJSON($.Storage.get('tagged'));
                $('#pastedata').val($.Storage.get('tagged'));
                $('#taggedClear').bind('click', function(e){
                    //console.log(e);
                    clearTaggedMarkers();
                });
                //$('#submitpastedata').trigger('click');
            
                
                    
                    
                //////////////////////////////////////////////////
                // Interface freigeben
                appLayout.close('west');appLayout.close('east');appLayout.close('south');appLayout.close('north');     
                $('#formtools, #RECTPLCS, #Placesfilter, #userkmlurl').toggle('slow');
                $('#gfkzoom, #pricezoom, #extendedfilter, #gfkcounter, #pricecounter, #Stellenartenfilter, #Unterstellenartenfilter').toggle('slow');
                toggleStreetView();
                $('#loader p').html('Lade Karte...');
                if (apiRequest('init','init')!=false) {$('#loader').delay(3800).hide('puff',1200);
                }
                else{$('#loader').append('<p class="ui-state-error">Ein Fehler ist aufgetreten.')};
                $('#submitpastedata').trigger('click');
                //////////////////////////////////////////////////
            });
        </script>
        <div id="minitoolbar" style="z-index:10000">
            <input id="append" type="checkbox" name="append" value="append"/>
            <label class="vtip ui-icon fff-icon-image-add" title="Append-Modus: wenn aktiv weren die Ergebnisse neuer Suchen hinzugef&uuml;gt. Wenn deaktiviert werden vorhandene Ergebnisse gel&ouml;scht." for="append">APP</label>
            <input id="applyfilter" type="checkbox" name="applyfilter" value="applyfilter" />
            <label class="vtip ui-icon fff-icon-image-edit" title="Filter anzeigen (auch aktiv wenn ausgeblendet)" for="applyfilter">FLT</label>
            <input id="applyschedule" type="checkbox" name="applyschedule" value="applyschedule" />
            <label class="vtip ui-icon fff-icon-calendar-edit" title="Kalender-Auswahl anwenden" for="applyschedule">CAL</label>
            <input id="applyplaces" type="checkbox" name="applyplaces" value="applyplaces" />
            <label class="vtip ui-icon fff-icon-photos" title="Places anzeigen und in n&auml;chste Suche einbeziehen" for="applyplaces">PLC</label>
            <input type="checkbox" id="visibleMarkers" value="" class="button"/>
            <label class="vtip ui-icon fff-icon-table-relationship"  title="Tabelle mit Ausschnitt in der Hauptkarte synchronisieren. Wenn aktiv: zeigt Anzahl der sichtbaren Stellen-Markierungen." 
                   for="visibleMarkers">VM</label>


            <input class="button" type ="checkbox" name="syncstreetview" value="syncstreetview" id="syncstreetview"/>
            <label class="vtip  ui-icon fff-icon-arrow-in" title="Streetview mit Mittelpunkt der Hauptkarte synchronisieren. Infos werden im Streetview-Fenstr angezeigt. Klicks auf Marker zentrieren die Hauptkarte neu." for="syncstreetview">SYNC</label>
            <span id="checksv" title="Streetview aktivieren / deaktivieren" class="button vtip ui-icon fff-icon-eye" onclick="toggleStreetView();"></span>

            <div id="clustertype" style="float: left">
                <input type="radio" id="REPOSITORY" name="clustertype" checked="checked"/>
                <label class="vtip ui-icon fff-icon-page-refresh" title="alle geladenen Stellen auf Hauptkarte anzeigen" for="REPOSITORY">R</label>
                <input type="radio" id="TAGGED" name="clustertype"/>
                <label class="vtip ui-icon fff-icon-page-save" title="nur markierte Stellen anzeigen" for="TAGGED">L</label>

            </div>
            <br/>

            <span class="vtip button" title="Aktuellen Ausschnitt nach Stellen durchsuchen" id ="RECTSRCH" onclick="apiRequest('bounds',map.getBounds());">Ausschnitt</span>

            <span class="vtip" title="Umkreissuche relativ zum aktuellen Mittelpunkt der Hauptkarte mit gew&auml;hltem Radius durchf&uuml;hren und anzeigen (Haptkarte)." id="zoom" class="ui-state-default" style="width:60px; float: right;"></span>
            <br/>


            <div id="pointertype">
                <input class="ui-state-default" type="radio" id="RECTZOOM" name="pointertype"/>
                <label class="vtip ui-icon fff-icon-shape-handles" title="Rechteck in Hauptkarte ausw&auml;hlen und durchsuchen" for="RECTZOOM">RZ</label>
                <input type="radio" id="POLYDRAW" name="pointertype"/>
                <label class="vtip ui-icon fff-icon-pencil-add" title="Polygon auf Hauptkarte zeichnen. Doppelklick auf den Polygonmarker startet Suche." for="POLYDRAW">PD</label>
                <input type="radio" id="CIRCLEDRAW" name="pointertype"  checked="checked"/>
                <label class="vtip ui-icon fff-icon-arrow-refresh-small" title="Umkreisanzeige aktivieren" for="CIRCLEDRAW">CD</label>
                <input title="Info im Kartenfenster schliessen" type="button" class="vtip button ui-icon fff-icon-comment-delete" value="Close InfoBubble" onclick="infoBubble.close();"/>
                <input class="vtip button" title="Aktuellen Kartenausschnitt mit Places durchsuchen und markieren" type="button" style="float:right;" id="RECTPLCS" value="Places" onclick="getPlacesByBounds(map.getBounds());"/>
                <br/>
                <input type="checkbox" id="KML-DE" value="" class="button" onclick="toggleKmlLayerDE();"/>
                <label class="vtip ui-icon fff-icon-map-add"  title="Umrisse DE in Hauptkarte umschalten" 
                       for="KML-DE">DE</label>
                <input type="checkbox" id="KML-BL" value="" class="button" onclick="toggleKmlLayerBL();"/>
                <label class="vtip ui-icon fff-icon-map-add"  title="Umrisse Bundesl&auml;nder in Hauptkarte umschalten" 
                       for="KML-BL">BL</label>
                <input type="checkbox" id="KML-RBZ" value="" class="button" onclick="toggleKmlLayerRBZ();"/>
                <label class="vtip ui-icon fff-icon-map-add"  title="Umrisse Regierungsbezirke in Hauptkarte umschalten" 
                       for="KML-RBZ">RBZ</label>
                <input type="checkbox" id="KML-STADT" value="" class="button" onclick="toggleKmlLayerSTADT();"/>
                <label class="vtip ui-icon fff-icon-map-add"  title="Umrisse der Kommunen in Hauptkarte umschalten" 
                       for="KML-STADT">STADT</label>
                <input type="checkbox" id="KML-URL" value="" class="button" onclick="toggleKmlLayerURL();"/>
                <label class="vtip ui-icon fff-icon-map-add"  title="benutzerdefinierten KML-URL anzeigen" 
                       for="KML-URL">URL</label>
                <input type="checkbox" id="KML-HTTP" value="" class="button" onclick="$('#userkmlurl').toggle('slow');"/>
                <label class="vtip ui-icon fff-icon-map-go"  title=" URL der KML-Datei. Diese muss auf einem &ouml;ffentlichen Webserver liegen." 
                       for="KML-HTTP">HTTP</label><input type="text" class="clearfield" value="URL" id="userkmlurl"/>

            </div>
        </div>

        <div title="Radius der Umkreissusche einstellen" id="umkreis" class="vtip ui-widget" style="height:240px; width: 8px;float: none; z-index:1000;"></div>
        <div title ="Cluster-Zoomstufe einstellen" id="clusterzoom" class="vtip ui-widget" style="height:240px; width: 8px;float: none;z-index: 1000;"></div>

        <div title="Filter GFK Werte Min,Max einstellen" id="gfkzoom" class="vtip ui-widget" style="height: 240px; width: 8px;float: none;z-index: 1000;"></div>
        <div title="Filter Preisspanne Min,Max einstellen" id="pricezoom" class="vtip ui-widget" style="height: 240px; width: 8px;float: none;z-index: 1000;"></div>

        <form id="extendedfilter" style="float:right; z-index: 110000" >
            <select name="example-optgroup" multiple="multiple" style="float: right;">
                <optgroup label="Nielsen">
                    <option value="1" selected>1</option>
                    <option value="2" selected>2</option>
                    <option value="3a" selected>3a</option>
                    <option value="3b" selected>3b</option>
                    <option value="4" selected>4</option>
                    <option value="5" selected>5</option>
                    <option value="6" selected>6</option>
                    <option value="7" selected>7</option>
                </optgroup>
                <optgroup label="Zeitplanung">
                    <option value="all" selected>Kalenderfilter</option>
                </optgroup>
            </select>
        </form>

        <form id="Stellenartenfilter" name="Stellenartenfilter" style="float:right; z-index: 110000" >
            <select name="stellenarten-optgroup" multiple="multiple" style="float: right; display: none">
                <optgroup label="Beleuchtung">
                    <option value="B" >Beleuchtet</option>
                    <option selected value="U">Unbeleuchtet</option>
                </optgroup>

                <optgroup label="Hauptstellenarten">
                    <option value="AL" >AL,Allgemeiner Anschlag</option>
                    <option value="VI" >VI,joean-doeposter</option>
                    <option value="GZ" >GZ,Ganzstellen</option>
                    <option value="SZ" >SZ,StretchS�ule</option>
                    <option selected value="GF" >GF,Gro�fl�chen</option>
                    <option value="PB" >PB,Premium Billboard</option>
                    <option value="SB" >SB,StretchBoard</option>
                    <option value="SO" selected>SO,Sonstiges</option>
                    <option value="GV" >GV,18/1 Vitrinen</option>
                    <option value="SG" >SG,Sondergro�fl�chen</option>
                    <option value="SP" >SP,Superposter</option>
                    <option value="K4" >K4,Kleinfl�chen (4/1)</option>
                    <option value="K6" >K6,Kleinfl�chen (6/1)</option>
                    <option value="EM" >EM,Elektronische Medien</option>
                    <option value="PF" >PF,Panoramafl�chen (36/1)</option>
                </optgroup>
            </select>
        </form>
        <form id="Unterstellenartenfilter" name="Unterstellenartenfilter" style="float:right; z-index: 110000" >
            <select name="unterstellenarten-optgroup" multiple="multiple" style="float: right; display:none; max-height: 200px;">
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
                    <option value="QA" >Qualit�ts-GF QA</option>
                    <option value="SE" >Standard, die auf EKZ-M�rkte wirken SE</option>
                    <option value="ES" >EKZ, die als Standardstellen wirken ES</option>
                    <option value="EM" >Elektronische Medien EM</option>
                    <option value="CI" >Citystar CI</option>
                    <option value="US" >Uhrens�ulen US</option>
                    <option value="G8" >Ganzstelle 8/1 (hinterleuchtet) G8</option>
                    <option value="GL" >Ganzstelle Lichts�ule GL</option>
                    <option value="SL" >StretchS�ule (hinterleuchtet) SL</option>
                    <option value="ZZ" >Nicht zugeordnet ZZ</option>
                </optgroup>
            </select>
        </form>

        <form id="Placesfilter" style="float:right; z-index: 110000">
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
                    <option value="hardware_store">Eisenwarengesch�ft</option>
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
                    <option value="shopping_mall">Einkaufszentrum</option>
                    <option value="spa">Bad</option>
                    <option value="stadium">Stadion</option>
                    <option value="storage">Lagerung</option>
                    <option value="store">Gesch&auml;ft</option>
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
                    <option value="neighborhood">Nachbarschfaft</option>
                    <option value="political">Politisch</option>
                    <option value="point_of_interest">POI</option>
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


        <input class="vtip" title="Filter: GFK Werte Min,Max" type="button" id="gfkcounter" value="GFK" style="z-index:10000"/>
        <input class="vtip" title="Filter: Preise Min,Max" type="button" id="pricecounter" value="GFK" style="z-index:10000"/>
        <div id="address-container" class="ui-widget" style="z-index: 120000;">
            <input class="vtip" title="Anzahl geladener Stellen. Klick l&ouml;scht den aktuellen Speicher." type="button" id="markercounter" value="0" onclick="clearClusterer();"/>
            <input type="text" id="address" value="Umkreissuche" class="vtip ui-state-default clearfield"
                   title="Geokodierung und Umkreissuche: Adresse, Bezeichnung oder Koordinaten eingeben.<br/>Zeigt nach Verschieben der Hauptkarte den Kartenmittelpunkt."/>
            <input type="checkbox" id="addressUmkreisSuche" value="" class="button"/>
            <label class="vtip ui-icon fff-icon-arrow-refresh"  title="Sofort nach erfolreicher Geokodierung eine Umkreissuche mit eigestelltem Radius durchf&uuml;hren" 
                   for="addressUmkreisSuche">U</label>
            <input id="bestandssuche" type="text" class="ui-state-default vtip clearfield" style="width: 180px;"
                   value="Bestandssuche"  title="Suche im SDAW Bestand nach Standort, PLZ, Anbieter-ID, Nielsen, Schlagworten in Standortbeschreibung"/>

        </div>

        <div id="graphics" style="width: 260px; height: 100px; background: transparent none; 
             position: absolute; bottom: 10px; right:10px; z-index: 10000" 
             class="ui-widget ui-widget-content"></div>
        <div id="total_counter_graphics" style="width: 100px; height: 100px; background: transparent none; 
             position: absolute; top: 10px; right: 10px; z-index: 10000" 
             class="ui-widget ui-widget-content"></div>
        <div id="lensmapcontainer" style="width: 100px; height: 100px; position: absolute; right:10px; bottom: 10px; padding: 5px; z-index:10000; border: 1px solid silver">
            <div id="lensmap" style="width: 90px; height: 90px; margin: 0">
            </div>
        </div>
        <div id="geoNoteEdit" title="Geo Notiz">
            <textarea name="geoNoteEdit" class="clearfield">enter a note...</textarea>
        </div>


    </body>
</html> 