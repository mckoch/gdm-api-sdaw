/*!
 * GeoDataMapper V0.5 public 
 * Interface Script
 * 
 * version 12/2011
 * licensed for http://joean-doe-media.de
 * copyright Markus C. Koch < emcekah@gmail.com >
 * 
 */

HTTP_GET_VARS=new Array();
strGET=document.location.search.substr(1,document.location.search.length);
if(strGET!='')
{
    gArr=strGET.split('&');
    for(i=0;i<gArr.length;++i)
    {
        v='';
        vArr=gArr[i].split('=');
        if(vArr.length>1){
            v=vArr[1];
        }
        HTTP_GET_VARS[unescape(vArr[0])]=unescape(v);
    }
}
 
function GET(v)
{
    if(!HTTP_GET_VARS[v]){
        return 'undefined';
    }
    return HTTP_GET_VARS[v];
}
 
//document.writeln ('Erste Var:' + GET('text') + ' du');
//document.writeln ('Zweite Var:' + GET('text2') + ' da draussen');

jQuery(function($){
    $.datepicker.regional['de'] = {
        closeText: 'schließen',
        prevText: '&#x3c;zurück',
        nextText: 'Vor&#x3e;',
        currentText: 'heute',
        monthNames: ['Januar','Februar','März','April','Mai','Juni',
        'Juli','August','September','Oktober','November','Dezember'],
        monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dez'],
        dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
        dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
        dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
        weekHeader: 'Woche',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        minDate: +14,
        maxDate: '15.01.2013'
    };
    $.datepicker.setDefaults($.datepicker.regional['de']);
});     

$(function() {
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    });
}); 


function htmlDrucken(t){
    w =window.open();
    w.document.write(t);
    w.print();
    w.close();
}


var dummy = 'ooo dummy... just for now..... oooohoooo duuummmmmmyyyyyy......';


            
var appLayout;
var mainDialogLayout;
var map;
var geocoder;
var mapcenter;
var centermarker;
var circle;
var markerimage;
var pb;
var pservice;
var umkreis = 500;
// var mapOptions;
var gfkrange = [0,300];
var pricerange =[0,10000];

var MAPTYPE_01 = 'candy';
var MAPTYPE_02 = 'morecandy';
var MAPTYPE_03 = 'muchmorecandy';
var MAPTYPE_04 = 'almost_blank';
var MAPTYPE_05 = 'blank';
            
var markerClusterer;
var markerPlacesClusterer;
var clusterzoom = 17;
var visibleMarkers = new Array();
            
var repositoryTable;
var taggedRepositoryTable;
var checkOuts = 0;
var timeResultsTable;
            
var infoBubble;
var infowindow;
            
var sv;
var svdisplay;
var svpos;
            
var rightclickimage;
var rightclickmarker;

var lensmap;
var lensrectangle;
var lensrectangleoptions;
            
var myLocalStorage = new Array();

var KWLIST = Array();
var DEKALIST = Array();
var IDLIST = Array();
var FREI = Array();

var outputformat = 'application';
// ALWAYS reset the trigger IMMEDIATELY.            
            
var dataTableLanguage = {
    "sProcessing":   "Bitte warten...",
    "sLengthMenu":   "_MENU_ Flächen anzeigen",
    "sZeroRecords":  "Keine Werbeflächen anzuzeigen.",
    "sInfo":         "_START_ bis _END_ von _TOTAL_ Flächen",
    "sInfoEmpty":    "0 bis 0 von 0 Flächen",
    "sInfoFiltered": "(gefiltert von _MAX_  Flächen)",
    "sInfoPostFix":  "",
    "sSearch":       "Liste filtern",
    "sUrl":          "",
    "oPaginate": {
        "sFirst":    "Erste",
        "sPrevious": "Zurück",
        "sNext":     "Nächste",
        "sLast":     "Letzte"
    }
};

var directionsService;
var directionsDisplay;
var boxpolys = null;
var routeBoxer;
var distance = null; // km
            
var gfkSumTotal = 0;
var gfkSumVisible = 0;
var gfkAvg = 0;
var gfkAvgVisible = 0;
var priceSumTotal = 0;
var priceSumVisible = 0;
var priceAvg = 0;
var priceAvgVisible = 0;
var markersTotal = 0;
var markersTotalVisible = 0; 
var elementsNoData = 0;
var elementsWithData = 0;
var elementsWithDataVisible = 0;
var taggedWithData = 0;

var taggedlwsum = 0;
var taggedlwavg = 0;
var taggedpricesum = 0;
var taggedpriceavg = 0;
var taggedewksum = 0;
var taggedewkavg = 0;
var taggedtkpavg = 0;

var plot1;
var plot2;

var plot1ticks = ['LW1SUM', 'LW1AVG', '€ SUM', '€ AVG', 'EWK/1000', '€ TKP'];
var plot2ticks = ['TOTAL','DATA'];
var plot1options = {
    // title: 'Statistik', 
    seriesDefaults:{
        renderer:$.jqplot.BarRenderer,
        pointLabels: {
            show: false
        },
        rendererOptions: {
            barPadding: 0,
            barMargin: 5
        }
    },
    seriesColors: ["#00ff00","#4bb2c5", '#0000ff'],
    stackSeries: false,
    drawGridlines: true,
    
    series:[
    {
        label: 'gesamt'
    },{
        label: 'sichtbar'
    },{
        label: 'markiert'
    }],
    legend: {
        show: false
        
    },
    
    axes: {
        xaxis: {
            renderer: $.jqplot.CategoryAxisRenderer,
            ticks: plot1ticks
        },
        yaxis:{
            renderer: $.jqplot.LogAxisRenderer, 
            showTicks: true, 
            base: 10,
            tickDistribution:'power'
        } 
    },
    highlighter: {
        show: true
    }
};
var plot2options = {
    // title: 'Ladezustand', 
    
    seriesDefaults:{
        renderer:$.jqplot.BarRenderer,
        
        pointLabels: {
            show: false,
            stackedValue: false
        },
        rendererOptions: {
            barPadding: 0,
            barMargin: 5
        }
    },
    seriesColors: [ "#00ff00","#4bb2c5", '#0000ff'],
    stackSeries: false, 
    series:[
    {
        label: 'gesamt'
    },{
        label: 'sichtbar'
    },{
        label: 'markiert'
    }],
    legend: {
        show: true,
        placement: 'outsideGrid',
        location: 'e'
    },  
       
    axes: {                        
        xaxis: {
            renderer: $.jqplot.CategoryAxisRenderer,
            showTicks: true,
            ticks: plot2ticks
        },
        yaxis:{
            renderer: $.jqplot.LogAxisRenderer, 
            showTicks: true, 
            base: 10,
            tickDistribution:'power'
        } 
    },
    highlighter: {
        show: true
    }
};

/**
 *Zwei Schritte. Zunächst müssen die erinnerungswirksamen Werbemittelkontakte (EWK) ermittelt werden:
EWK :  G-Wert x 14 (Faktor Stunden/Tag) x 9 (Dekadenfaktor) x 3,99 (GfK-Faktor)
TKP : Tausender Kontaktpreis (TKP):  Tagespreis * 10,5 * 1000 / EWK
**/
function convertGfkToEwk(gwert){
    var ewk = gwert * 14 *9*3.99;
    return ewk;
}

function makeTkp(price, ewk) {
    var tkp = price * 10.5 * 1000/ewk;
    return tkp;
}

function createQuickGraph(){
    //var markers = markerClusterer.getMarkers();
    //var cnt = 0;
    gfkSumTotal = 0;
    priceSumTotal = 0;
    markersTotalVisible = 0;
    gfkSumVisible = 0;
    priceSumVisible = 0;
    elementsNoData = 0;
    elementsWithData = 0;
    elementsWithDataVisible = 0;
    taggedWithData = 0;
    
    taggedlwsum = 0;
    taggedlwavg = 0;
    taggedpricesum = 0;
    taggedpriceavg = 0;
    taggedewksum = 0;
    taggedewkavg = 0;
    taggedtkpavg = 0;
    
    var plot1data;
    var plot2data;
    var plot1visible;
    var plot2visible;
    var plot1tagged;
    var plot2tagged;
                
                   
    $.each(markerClusterer.getMarkers(), function(index, value){
        if (value.markerData['leistungswert1'] != 'NA') {
            gfkSumTotal = parseFloat(gfkSumTotal) + parseFloat(value.markerData['leistungswert1']);
            elementsWithData++;
            
        } else {
            elementsNoData++;
        //console.log(elementsNoData);
        }
        
        if (value.get('tagged')=='tagged'){
            taggedWithData++;  
            taggedlwsum = parseFloat(taggedlwsum) + parseFloat(value.markerData['leistungswert1']);
            taggedpricesum = parseFloat(taggedpricesum) + parseFloat(value.markerData['preis']);
        }
        
        priceSumTotal = parseFloat(priceSumTotal) + parseFloat(value.markerData['preis']);
        markersTotal = index + 1;
        if (map.getBounds().contains(value.getPosition())){
            markersTotalVisible++;
            if (value.markerData['leistungswert1'] != 'NA') {
                gfkSumVisible = parseFloat(gfkSumVisible)+ parseFloat(value.markerData['leistungswert1']);
                elementsWithDataVisible++;
            } else {
            // console.log('noop.');
            }
            priceSumVisible = parseFloat(priceSumVisible) + parseFloat(value.markerData['preis']);
        }
    });
    //     avoid division by zero!!!!!!!! 
    if (markersTotal > 0){
        var ewktotal = convertGfkToEwk(gfkSumTotal);
        var tkpavg = makeTkp(priceSumTotal, ewktotal);
        
        taggedewksum = convertGfkToEwk(taggedlwsum);
        taggedtkpavg = makeTkp(taggedpricesum, taggedewksum);
        
        plot1data = [gfkSumTotal, gfkSumTotal/elementsWithData, priceSumTotal/100, priceSumTotal/markersTotal/100,ewktotal/1000/9,tkpavg/100];
        
        if (taggedWithData >0){
            plot2data = [markersTotal,elementsWithData]; 
            plot2tagged = [tagged.length,taggedWithData];
            plot1tagged = [taggedlwsum,taggedlwsum/taggedWithData,taggedpricesum/100,taggedpricesum/taggedWithData/100,taggedewksum/1000/9,taggedtkpavg/100];
        } else {
            plot2data = [markersTotal];
            plot1tagged = [];
            if (tagged.length > 0){
                plot2tagged = [tagged.length];
            } else {
                plot2tagged = [];
            }
        }
         
        
    } 
    else {
        plot1data = [];
        plot1tagged=[];
        plot2data = [];
        plot2tagged =[];
    }
    if (markersTotalVisible > 0){
        var ewkvisible = convertGfkToEwk(gfkSumVisible);
        var tkpavgvisible = makeTkp(priceSumVisible, ewkvisible);
        
        plot1visible = [gfkSumVisible, gfkSumVisible/markersTotalVisible, priceSumVisible/100, priceSumVisible/markersTotalVisible/100, ewkvisible/1000/9, tkpavgvisible/100];
        plot2visible = [markersTotalVisible,elementsWithDataVisible];
    }
    else {
        plot1visible = [];
        plot2visible = [];
    }
    plot1.destroy();
    plot2.destroy();
                
    plot1 = $.jqplot('graphics', [plot1data, plot1visible, plot1tagged], plot1options);
    plot2 = $.jqplot('total_counter_graphics', [plot2data, plot2visible, plot2tagged], plot2options);
    
    $('.taggedewksum').html(Math.round(taggedewksum).toFixed(0));
    var tkptmp = Math.round(taggedtkpavg).toFixed(2);
    $('.taggedtkpavg').html(tkptmp/100);
    $('.taggedpricesum').html(taggedpricesum/100); 
    $('.taggedcount').html(tagged.length);
    $('.idlistcount').html(IDLIST.length);
    $('.rechnungstagecount').html(IDLIST.length*11);
    $('.angebot_ca').html(IDLIST.length*11*taggedpricesum/100);
}
            
                
function redrawMap(){
    google.maps.event.trigger(map, 'resize');
    $('#map-side-bar-container').jScrollPane({
        showArrows: true
    });
}
            
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
            
function attachInfoBubble(marker,data){
    google.maps.event.addListener(marker, 'click', function(){
        if (infoBubble.isOpen()==true){
            infoBubble.setMap(null);
        }
        showInfoBubble(marker,data);
    });
}
            
function showInfoBubble(marker,data){
    // clearInstanceListeners(marker);
    mypos = marker.getPosition();
    var disableAutoPan = true;
    if( $('#visibleMarkers').is(':checked')){
        disableAutoPan = false;
    };
    infoBubble = new InfoBubble({
        minWidth: 280,
        maxWidth: 280,
        minHeight: 380,
        maxHeight: 480,
        content: data.label,
        draggable: true,
        shadowStyle: 1,
        arrowStyle: 2,
        arrowSize: 12,
        arrowPosition: 50,
        position: mypos,
        hideCloseButton: false,
        disableAutoPan: disableAutoPan
    });
    infoBubbleTab1 = '<a class="lightbox" description="Anklicken um großes Bild anzuzeigen..." href="img/800x600/'+data.id+'.jpg" onclick="$.colorbox({href: this.href, opacity: 0.65, maxWidth:\'100%\', maxHeight:\'100%\', title: \''+data.description +'\', close: \'Schließen\'});return false;"><img src="img/240x240/'+data.id+'.png"/></a><div class="ui-widget">'
    +data.description +'<br/> '+data.stellenart + ' ' + data.beleuchtung + ' ' + data.leistungswert1 + ' '
    +data.preis/100 + ' ' + data.belegdauerart +"</div>"
    + "<div id='infobubble_main_"+data.id+"' class='ui-widget infobubble infobubble_main'><!--<a class='ui-widget ui-widget-content ui-corner-all ui-hover' onclick='cartAdd("+parseFloat(data.id)+")'>auf Merkliste setzen</a>||"
    + "<a class='ui-widget ui-widget-content ui-corner-all ui-hover' onclick='cartRemove("+parseFloat(data.id)+")'>von Merkliste entfernen</a>--><h3>Buchungsart: "+ data.belegdauerart +"</h3></div>";
    infoBubble.addTab(data.id, infoBubbleTab1);
    getFreizahlenForInfoBubble(data.id);
                
                
    if( svdisplay.getVisible() == true){
                    
        svpos = marker.getPosition();
        map.setCenter(svpos);
        svdisplay.setPosition(svpos);
        infoBubble.open(svdisplay, marker);
                    
    } else  {
        infoBubble.open(map,marker);
    }
// };
                
}
            
function getPlacesByRadius(umkreis, latlng){
    // var bounds = map.getBounds();
    $().message('Durchsuche Places...');
    var placestypes = placesfilter();
    // console.log(placestypes);
    var request = {
        radius: umkreis,
        types: placestypes,
        location: latlng
    };
    pservice.search(request, showPlaces);
}

function getPlacesByBounds(bounds){
    //var bounds = map.getBounds();
    $().message('Durchsuche Places...');
    var placestypes = placesfilter();
    //console.log(placestypes);
    var request = {
        bounds: bounds,
        types: placestypes
    };
    pservice.search(request, showPlaces);
}
            
function placesfilter(){
    var placesfilter = $("form#Placesfilter select")
    .multiselect("getChecked")
    .map(function(){
        return this.value;	
    }).get();
    return placesfilter;
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
                //                             $('#tree-control').dynatree('getTree') .getNodeByKey('places') .addChild({
                //                                 title: place.name
                //                             });
                /**
                 * erg�nzen!
                 */
                $('#placesRepository').data(place.name, {
                    latitude:place.geometry.location.lat(),
                    longitude:place.geometry.location.lng()
                });
            }
        }
        
        $('#labelforapplyplaces').pulse({
            opacity: [.4,1]
        }, {
            duration: 900, // duration of EACH individual animation
            times: 4, // Will go three times through the pulse array [0,1]
            easing: 'linear' // easing function for each individual animation
            
        });
        
    }
}
            
function createPlaceMarker(place) {
    var placeLoc = place.geometry.location;
    var category = place.types;
    // console.log(category[0]);
    var icon = new google.maps.MarkerImage('images/mapicons/'+category[0]+'.png');
    var marker = new google.maps.Marker({
        // map: map,
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
}
            
function showContextMenu(currentLatLng  ) {
    var contextmenuDir;
    rightclickmarker.setPosition(currentLatLng);// 
    rightclickmarker.setMap(map);
    mapcenter = currentLatLng;
    $('.contextmenu').remove();
    contextmenuDir = document.createElement("div");
    contextmenuDir.className  = 'ui-widget ui-dialog ui-corner-all ui-widget-content contextmenu';
    contextmenuDir.innerHTML = "<a id='mapcontextmenu2' class='' onclick='setCenterMarker(mapcenter); map.fitBounds(circle.getBounds());'><div class=context>Hier zentrieren</div></a>\n\
<br/><a id='mapcontextmenu3' class='' onclick='apiRequest(\"bounds\",map.getBounds());'><div class=context>Aktuellen Kartenausschnitt nach Stellen durchsuchen</div></a>\n\
<br/><a id='mapcontextmenu7' class='' onclick='getPlacesByBounds(map.getBounds());;'><div class=context>Aktuellen Kartenausschnitt mit Places durchsuchen</div></a>\n\
<br/><a id='mapcontextmenu4' class='' onclick='map.fitBounds(getClustererBounds(markerClusterer));'><div class=context>Alle geladenen Stellen auf Hauptkarte anzeigen</div></a>\n\
<br/><a id='mapcontextmenu5' class='' onclick='$(\"#tablesVisible\").trigger(\"click\");'><div class=context>Tabellenfenster anzeigen/verbergen</div></a>\n\
<br/><a id='mapcontextmenu6' class='' onclick='angebotBerechnen();'><div class=context>Checkout: Markierte Tafeln anfragen und buchen</div></a>\n\
<br/><a id='mapcontextmenu8' class='' onclick='taggAllVisible();'><div class=context>Sichtbare Tafeln zur Merkliste hinzufügen</div></a>\n\
<br/><a id='mapcontextmenu7' class='' onclick='clustererRemoveVisible();'><div class=context>Sichtbare Tafeln von Karte entfernen</div></a>";
    $(map.getDiv()).append(contextmenuDir);
    setMenuXY(currentLatLng);
    $('.contextmenu a').button();
    contextmenuDir.style.visibility = "visible";
}
            
function showMarkerContextMenu(currentLatLng, markerid) {
    // console.log(markerid);
    var contextmenuDir;
    $('.contextmenu').remove();
    contextmenuDir = document.createElement("div");
    contextmenuDir.className  = 'contextmenu ui-widget ui-widget-content ui-dialog ui-corner-all';
    contextmenuDir.innerHTML = "<!-- <h3>#"+markerid+"</h3>--><a id='markercontextmenu2' class='button' onclick='cartAdd("+markerid+");'><div class=context>Auf Merkliste setzen</div></a>"
    + "<a id='markercontextmenu3' class='button' onclick='cartRemove("+markerid+");'><div class=context>Von Merkliste entfernen</div></a>"
    + "<a id='markercontextmenu4' class='button' onclick='clustererRemove("+markerid+");'><div class=context>Aus Suchergebnis entfernen</div></a>";
    $(map.getDiv()).append(contextmenuDir);
    
    setMenuXY(currentLatLng);
    $('.contextmenu .button').button();
    contextmenuDir.style.visibility = "visible";
}
function clustererRemove(markerid){
    // NN. check4 'tagged'!!!
    $.each(markerClusterer.getMarkers(), function(){
        if (this.get('markerData').id==  markerid) {
            $('.contextmenu').remove();
            
            this.setMap(null);
            markerClusterer.removeMarker(this);
            $('#markercounter').val(markerClusterer.getTotalMarkers());
            
            google.maps.event.trigger(map, 'idle');
            $().message('Tafel '+ markerid +' von Karte entfernt.');
            // update tables!!!
            createQuickGraph();
            return;
        }
    });    
}       

function clustererRemoveVisible(){
    $('.contextmenu').remove();
    var cnt = 0;

    $.each(markerClusterer.getMarkers(), function(index, data){
        if (map.getBounds().contains(data.getPosition())){
            
            
            data.setMap(null);
            markerClusterer.removeMarker(data);
            cnt++;
        }
    });
    $('#markercounter').val(markerClusterer.getTotalMarkers());
    
    google.maps.event.trigger(map, 'idle');
    $().message(' ' + cnt + ' Tafeln von Karte entfernt.');
    // update tables!!!
    createQuickGraph();
    
}    

function taggAllVisible(){
    var cnt=0;
    $.each(markerClusterer.getMarkers(), function(index, data){
        if (map.getBounds().contains(data.getPosition())){
            cartAdd(data.get('markerData').id);
            cnt++;
        }
        
    });
    $().message(' ' + cnt + ' aktuell sichtbare Tafeln auf Merkliste.');
}

function cartAdd(markerid){
    // console.log(markerid+' cartAdd');
    $('.contextmenu').remove();
    tagged = $.evalJSON($.Storage.get('tagged'));
    // $('#tabs').tabs('select',2);
                
    $.each(markerClusterer.getMarkers(), function(){
        if (this.get('markerData').id==  markerid)
        {
            if(this.get('tagged')!= 'tagged'){
                this.set('tagged', 'tagged');
                markerimage = new google.maps.MarkerImage('images/mapicons/tropfen_gruen.png');
                this.setIcon(markerimage);
                if(!tagged){
                    tagged = new Array()
                }
                tagged.push({
                    'id': markerid
                });
                // console.log(markerid + ' tagged.');
                $.Storage.set('tagged', $.toJSON(tagged));
                $.Storage.set('tagged_changed_from_map', 'changed');
                updateTaggedRepositoryTable();
            }
        }
    });
    createQuickGraph();
    
    var table = repositoryTable.fnSettings().aoData;
    for (var i = 0; i < table.length; i++) 
    {
        var item = table[i];
        var checkme = Number(item._aData[0]);
        var nTr = item.nTr;
        checkIfTagged(checkme, function(data){
            if (data > 0 ) {
                $(nTr).addClass('ui-state-active');
                repositoryTable.fnDraw();
                
            }
        });
        
    }
    
    
    $('.taggedcounter').html(tagged.length);
    $('#taggedCheckOutLabel, #merkzettelouter_icon').pulse({
        opacity: [.4,1]
    }, {
        duration: 700, // duration of EACH individual animation
        times: 2, // Will go three times through the pulse array [0,1]
        easing: 'linear' // easing function for each individual animation
            
    });
}
function cartRemove(markerid){
    // console.log(markerid+' cartRemove');
    // tagged = new Array();
    tagged = $.evalJSON($.Storage.get('tagged'));
    // $('#tabs').tabs('select',2);
    $.each(markerClusterer.getMarkers(), function(index){
        if (this.get('markerData').id== markerid)
        {
            if(this.get('tagged')== 'tagged'){
                this.set('tagged', 'untagged');
                markerimage = new google.maps.MarkerImage(this.get('oimage'));
                this.setIcon(markerimage);
                // console.log('index:' + index);
                // // console.log(index);
                // tagged.splice(markerid ,1);
                $.each(tagged, function(index){
                    if (this['id'] == markerid){
                        tagged.splice(index ,1);
                        
                    }
                });
                $.each(IDLIST, function(index,data){
                    //var str = data.id;
                    // console.log(data);
                    if (data.substring(0, data.length - 3) == markerid){
                        IDLIST.splice(index ,1);
                    }
                }
                );
                // console.log(markerid + ' untagged.');
                $.Storage.set('tagged', $.toJSON(tagged));
                $.Storage.set('tagged_changed_from_map', 'changed');
                createQuickGraph();
                updateTaggedRepositoryTable();
                $('.taggedcounter').html(tagged.length);
            }
        }
    });
                
    $('.contextmenu').remove();
    
    var table = repositoryTable.fnSettings().aoData;
    for (var i = 0; i < table.length; i++) 
    {
        var item = table[i];
        var checkme = Number(item._aData[0]);
        var nTr = item.nTr;
        checkIfTagged(checkme, function(data){
            if (!data > 0 ) {
                $(nTr).removeClass('ui-state-active');
                repositoryTable.fnDraw();
            }
        });
    }
    
}
            
function clearTaggedMarkers(){
    $.Storage.set('tagged', '[]');
    $.Storage.set('termine', '[]');
    
    tagged = new Array();
    IDLIST = new Array();
    $.each(markerClusterer.getMarkers(), function(){   
        if(this.get('tagged')== 'tagged'){
            this.set('tagged', 'untagged');
            //  retrieve old marker image!!!
            var markerimage = new google.maps.MarkerImage(this.get('oimage'));
            this.setIcon(markerimage);
        }
    });
    $.Storage.set('tagged_changed_from_map', 'changed');
    createQuickGraph();
    updateTaggedRepositoryTable();
    $('.taggedcounter').html(tagged.length);
}
            
function setCenterMarker(mapcenter){
    // alert (mapcenter);
    map.panTo(mapcenter);
    centermarker.setPosition(mapcenter);
    $('.contextmenu').remove();
    rightclickmarker.setMap(null);
    google.maps.event.trigger(centermarker, 'dragend');
}
            
            
function clearClusterer(){
    if (markerClusterer) markerClusterer.clearMarkers();
    if (markerPlacesClusterer) markerPlacesClusterer.clearMarkers();
    // 
    $('#markersRepository').removeData();
    repositoryTable.fnClearTable();
    $('#placesRepository').removeData();
    $.Storage.set('lastrepository','');
    $.Storage.set('lastrepository_changed_from_map', 'changed');
    $('#markercounter').val(markerClusterer.getTotalMarkers());
    $('#visibleMarkersCounter').button( "option", "label", "0");
    $('#address').val('');
    $().message('Keine Stellen geladen.');
    //infoBubble.close();
    infoBubble.setMap(null);
    createQuickGraph();
//                 $('#tree-control').dynatree('getTree').getNodeByKey('search-history') .removeChildren();
//                 $('#tree-control').dynatree('getTree').getNodeByKey('details-history') .removeChildren();
//                 $('#tree-control').dynatree('getTree').getNodeByKey('places') .removeChildren();
}
            
function updateRepositoryTable() {
                    
    mapcenter = map.getCenter();
    updateLensmapCenter();
    allmarkers = markerClusterer.getMarkers();
    var el = $('#map-side-bar-container').jScrollPane({
        showArrows: true
    });    
    var api = el.data('jsp');
    var pos = api.getContentPositionY();
    repositoryTable.fnClearTable();
                    
    visibleMarkers = new Array(); 
    if( $('#visibleMarkers').is(':checked')){ 
                    
        $.each(markerClusterer.getMarkers(),function(index, marker){
            if (map.getBounds().contains(marker.getPosition())){
                visibleMarkers.push(marker);
                repositoryTable.fnAddData(  [
                    marker.markerData['id'],
                    marker.markerData['label'],
                    marker.markerData['description'],
                    marker.markerData['plz'],
                    marker.markerData['leistungswert1'],
                    '<img src="images/markers/marker_' + marker.markerData['stellenart'].toLowerCase() +'.png"/>'+ marker.markerData['stellenart'],
                    marker.markerData['preis']/100,
                    marker.markerData['beleuchtung'],
                    marker.markerData['standortnr'],
                    marker.markerData['belegdauerart'],
                    marker.markerData['bauart'],
                    marker.markerData['hoehe'],
                    marker.markerData['breite']
                    ], false );
            }
        });
        $('#labelforvisiblemarkers, #visibleMarkersCounter').pulse({
            opacity: [.4,1]
        }, {
            duration: 700, // duration of EACH individual animation
            times: 3, // Will go three times through the pulse array [0,1]
            easing: 'linear' // easing function for each individual animation
            
        });
  
    } else {
        $.each(markerClusterer.getMarkers(),function(index, marker){
            if (map.getBounds().contains(marker.getPosition())){
                visibleMarkers.push(marker);
                            
            }
            repositoryTable.fnAddData(  [
                marker.markerData['id'],
                marker.markerData['label'],
                marker.markerData['description'],
                marker.markerData['plz'],
                marker.markerData['leistungswert1'],
                '<img src="images/markers/marker_' + marker.markerData['stellenart'].toLowerCase() +'.png"/>'+ marker.markerData['stellenart'],
                marker.markerData['preis']/100,
                marker.markerData['beleuchtung'],
                marker.markerData['standortnr'],
                marker.markerData['belegdauerart'],
                marker.markerData['bauart'],
                marker.markerData['hoehe'],
                marker.markerData['breite']
                ], false );
        });
                    
    }
                
    repositoryTable.fnDraw();
    api.scrollToY(pos);
    taggedRepositoryTable.fnDraw();
    try {
        createQuickGraph();
    }
    catch (e) {}
    // console.log('visible: ' + visibleMarkers.length);
    $('#visibleMarkersCounter').button( "option", "label", visibleMarkers.length);
    $('.dataTables_filter input').clearField() .button();
    $( "#fortbewegungsart, .buttonset" ).buttonset();
    
    $('#masterlist_icon').pulse({
        opacity: [.4,1]
    }, {
        duration: 700, // duration of EACH individual animation
        times: 3, // Will go three times through the pulse array [0,1]
        easing: 'linear' // easing function for each individual animation
            
    });
                    
}
//function ifUpdateRepositoryTable(){
//    if( $('#visibleMarkers').is(':checked')){
//        updateRepositoryTable();
//    } else {
//        visibleMarkers = new Array(); 
//         $.each(markerClusterer.getMarkers(),function(index, marker){
//            if (map.getBounds().contains(marker.getPosition())){
//                visibleMarkers.push(marker);                      
//            };
//         });
//         $('#visibleMarkersCounter').button( "option", "label", visibleMarkers.length);
//    }
//}
            
function getClustererBounds(clusterer){
    var latlngBounds = new google.maps.LatLngBounds();
    $.each(clusterer.getMarkers(), function(index, marker){
        var mypos = marker.getPosition();
        // mypos = new google.maps.LatLng(mypos);
        latlngBounds.extend(mypos);
    });
    // console.log(latlngBounds);
    // map.fitBounds(latlngBounds);
    return latlngBounds;
}
            
            
function loadTaggedToMap(){
    try {
        tagged = $.evalJSON($.Storage.get('tagged'));
        $('#pastedata').val($.Storage.get('tagged'));
        $('#submitpastedata').trigger('click');
        $().message('Tafeln von Merkliste geladen.');
        $('#loaderProgressBar').progressbar('value', 70);
        $('.taggedcounter').html(tagged.length);
    } catch (e) { }
                
}
function loadTaggedToGoogleEarth(){
    try {
        tagged = $.evalJSON($.Storage.get('tagged'));
        $('#pastedata').val($.Storage.get('tagged'));
        outputformat = 'kml';
        $('#submitpastedata').trigger('click');
        $().message('KML Merkliste in Earth geladen.');
    } catch (e) {
        outputformat = 'application';
    }
                
}

function loadLastRepositoryToMap(){
    try {
        //tagged = $.evalJSON($.Storage.get('lastrepository'));
        var items = $.evalJSON($.Storage.get('lastrepository'));
        tagged = new Array();
        $.each(items, function (){
            if (this.id){
                // console.log(this.id);
                tagged.push({
                    'id': this.id
                });
            }
        });
    
        $('#pastedata').val($.toJSON(tagged));
        $('#loaderProgressBar').progressbar('value', 85);
        $('#submitpastedata').trigger('click');
    } catch (e){}
}
            
function taggedCheckOut(){
                
    // console.log('CheckOut started.');
    try{
        if($.Storage.get('tagged')== '[]'){
        {
            // console.log('No tagged - no checkout.');
            $().message('Keine Termine markiert.');
            return false;
        }
        } else {
            appLayout.close('east');
            $().message('Beginne Checkout...');
            try {
                $('#tabsouter').dialogExtend('restore');
            }
            catch (e) {
                
            }
            try {
                $('#graphicscontainer').dialogExtend('restore');
            }
            catch (e) {
                
            }
            $('#tabs').tabs('select',2);
            /* $.each($('#checkOutForm #kontaktdaten input'), function(){
                var test;
                if (test = $.Storage.get($(this).attr('name'))){ 
                    // console.log(test);
                    $(this).val(test);
                }
            }); */
                
            markerClusterer.clearMarkers();
            $('#markersRepository').removeData();
            $('#suchdialog, #mapoptions, #pricezoom, #umkreis, #gfkzoom, #mapcontextmenu2,#mapcontextmenu3,#mapcontextmenu6').hide('slow');
            loadTaggedToMap();
            $('#taggedtmp').val($.Storage.get('tagged'));
            $('#terminetmp').val($.Storage.get('termine'));
                
            /// temp $('#tabs').tabs('option','disabled',[0,1,4]);
            $('#tabs').tabs('select',3);
            $('#headermessage').html('<h2 class="ui-widget ui-widget-content ui-widget-header">Tafeln anfragen</h2>'); 
            // 
            $('#doTheCheckoutSubmit').pulse({
                opacity: [.2,1]
            }, {
                duration: 700, // duration of EACH individual animation
                times: 5, // Will go three times through the pulse array [0,1]
                easing: 'linear' // easing function for each individual animation
            
            });
        }
    } catch (e) {
    // console.log(e);
    }
                
                
}
            
function updateTaggedRepositoryTable(){
    taggedRepositoryTable.fnClearTable();
    var id;
    var tdata;
                 
    try {
        $.each($.evalJSON($.Storage.get('tagged')), function(index, data){
            id = String(data.id);
            // console.log('ID: '+ id);
            tdata = $('#taggedRepository').data(id);
            // console.log('tdata: '+tdata);
            // tdata;
            // console.log('from #taggedRepository: ' + id);
            if (tdata)
            {
                var checkboxes ='';
                $.each(IDLIST, function(){
                    if (id==this.substring(0, this.length - 3)){
                        // console.log(id+':'+this);
                        checkboxes = checkboxes + '<span><input type="checkbox" class="reptblchk" value="'+this+'" checked="checked"/>'+this+'</span> ';
                    }
                });
                taggedRepositoryTable.fnAddData( [
                        
                    tdata.id,
                    tdata.label,
                    '<img src="img/240x240/'+data.id+'.png"/>&nbsp;'+tdata.description+'<span style="float: right;" id="termine_'+data.id+'">'+checkboxes+'</span>',  
                    tdata.plz,
                    tdata.leistungswert1,
                    '<img class="marker" src="images/markers/marker_' + tdata.stellenart.toLowerCase() +'.png"/>'+ tdata.stellenart,
                        
                    tdata.preis/100,
                    tdata.beleuchtung,
                    tdata.standortnr,
                    tdata.belegdauerart,
                    tdata.bauart,
                    tdata.hoehe,
                    tdata.breite
                         
                    // this.id,2,index,4,5,6,7,8,9,10,11,12,13
                    ], false );
            }
        });
        $('#taggedtmp').val($.Storage.get('tagged'));
        $('#StellenGesamt').val(tagged.length);
        $('#TermineGesamt').val(IDLIST.length);
        
        $('#taggedCheckOutLabel').pulse({
            opacity: [.4,1]
        }, {
            duration: 700, // duration of EACH individual animation
            times: 2, // Will go three times through the pulse array [0,1]
            easing: 'linear' // easing function for each individual animation
            
        });
        
        taggedRepositoryTable.fnDraw();
        $('.taggedcounter').html(tagged.length);
    //    $.each ($(':checkbox.reptblchk'), function(){
    //        bind('click', function(){
    //        terminRemove(this.val());});
    //    });
    } catch(e){}
    
}
         
//function checkIfTagged(id, tagged){
//    // tagged =$.evalJSON($.Storage.get('tagged'));
//    $.each(tagged, function(){
//        if(this.id== id) {
//            // console.log('match:' + id);
//            return true;
//        } else return false;
//    });
//}         

function showLoginBox(){
    $('#loginbox').dialog();
    $('#loginbox').load('/_ng/index.php?option=com_user&view=login .contentarea');
    $().message('Bitte beachten: nach An-/Abmeldung wird die Karte neu geladen! Bestehende Auswahlen bleiben erhalten.');
//$('loginbox').dialog('open');
}

function angebotBerechnen(){
    //$().message(dummy);
    if (IDLIST.length < 1){
        $().message('Keine Termine markiert!');
        return;
    }
    $.colorbox({
        width:'100%', 
        height:'100%',
        close: '<span class="loginlink button" onclick="showLoginBox();">Anmelden</span><span class="button">< Zurück zur Karte ></span>',
        html: '<div id="AngebotOuter"> </div>',
        onComplete: function(){
            $('.button').button();
            // $('#AngebotOuter').load('buchen.php');
            var formdata;
            prepareTheCheckOutSubmit();
            formdata = $('#checkOutForm').serialize();
            $.ajax({
                type: 'POST',
                url: '/api/buchen.php',
                data: formdata,
                success: function(data){
                    $('#AngebotOuter').html(data);
                    $('#cboxLoadedContent').jScrollPane({
                        showArrows: true
                    });
                },
                dataType: 'html',
                ajaxStart: $.loading({
                    mask: true,
                    text: 'Lade Daten...', 
                    pulse: 'working fade'
                }),
                ajaxComplete: $.loading(false)
            });
        }
    });
    
}
         
function prepareTheCheckOutSubmit(){
    $('#terminetmp').val(IDLIST); 
    
}      
function doTheCheckoutSubmit(){
    
    if (IDLIST.length < 1){
        $().message('Keine Termine markiert!');
        return;
    }
    prepareTheCheckOutSubmit();
    lng = $('#BUCHUNG').serialize();
    $().message('Übermittele Anfrage...');
    $.ajax({
        type: 'POST',
        url: 'buchen.php?command=checkout',
        data: lng,
        success: checkoutSubmitCallback,
        dataType: 'html',
        ajaxStart: $.loading({
            mask: true,
            text: 'Lade Daten...', 
            pulse: 'working fade'
        }),
        ajaxComplete: $.loading(false)
    });
}
            
function checkoutSubmitCallback(data){
               
    // alert(data);
    
    checkOuts++;
    // $('#alreadyCheckedOut').prepend(' '+ checkOuts + data);
    //$('#alreadyCheckedOut').html('<span class=" ui-icon fff-icon-tick" style="float:right"></span>'+ data + '<hr/>');
    $.each($('input.datum'), function(){
        $(this).val($(this).attr('title'));
    });
    $('#checkOutForm').valid();
    clearTaggedMarkers();
    $('#taggedtmp').val($.Storage.get('tagged'));
    $('#terminetmp').val($.Storage.get('termine'));
    $(document).remove($('#doTheCheckoutSubmit'));
    $('#BUCHUNG :input').attr('disabled', true);
    $('.buchung_status').html('BUCHUNGSBESTÄTIGUNG');
    $().message('Ihre Anfrage '+ checkOuts + ' wurde erfolgreich übermittelt. ');
}
            
            
            
function checkoutCancel(){
    $().message('Checkout abgebrochen.');
    $('#suchdialog, #mapoptions, #pricezoom, #umkreis, #gfkzoom, #mapcontextmenu2,#mapcontextmenu3,#mapcontextmenu6').show('slow');
    // console.log('CheckOut canceled.');
    $('#tabs').tabs('option','disabled',[]);
                
    $('#tabs').tabs('select',2);
    $('#tabs').tabs('option','disabled',[3]);
    $('#headermessage').html('<h2 class="ui-widget ui-widget-content ui-widget-header">Werbetafeln suchen</h2>');
                
}

function checkIfTagged(id, callback){
    tagged =$.evalJSON($.Storage.get('tagged'));
    //console.log('id: '+id);
    $.each(tagged, function(){
        //console.log('this.id: '+id);
        if(Number(this.id)=== Number(id)) {
            // console.log('checkIfTagged: ' + id);
            callback(id);
        } 
    // else return false;
    });
} 

            
function apiRequest(lat,lng){
    // console.log(lat + ' ' + lng);
    var api;
    if(infoBubble.isOpen()){
        // infoBubble.close();
        infoBubble.setMap(null);
    }
        
    if (lat == 'init'){
        api = 'api_2.php?command=5';
    // var latlng = mapcenter;
    } 
    else if (lat == 'plzsuche'){
        // api = 'api_2.php?command=plzsuche';
        api='api_2.php?command=plzsuche&'+ $.param(lng)+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
        // alert(api);
        geocoder.geocode( {
            'address': lng.label
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                mapcenter = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                // alert(mapcenter.toString());
                centermarker.setPosition(mapcenter);
                centermarker.setMap(map);
                circle.setCenter(mapcenter);
                map.panTo(mapcenter);
                $('#address').val(results[0].formatted_address);
            // console.log(mapcenter);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
        $().message('Postleitzahlensuche: ' + lng.label + ' ' ); 
        if ($('#plzdraw').is(':checked')){
            $.getJSON('api_2.php?command=graphics&pastedata=['+ lng.value +']', function(data){
                // console.log(data);
                var latlngBounds = new google.maps.LatLngBounds();
                $.each(data, function(index, value){
                    var plzpoly = new google.maps.Polygon({
                        // path: latlngs,
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
                        // console.log(coords[0] +' '+coords[1]);
                        var latlng = new google.maps.LatLng(coords[1],coords[0]);
                        latlngBounds.extend(latlng);
                        mybounds.extend(latlng);
                        var path = plzpoly.getPath();
                        path.push(latlng);
                    });
                    plzpoly.setMap(map);  
                    var polycenter = mybounds.getCenter();
                    // console.log(polycenter);
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
        }
    // return;
    }
    else if (lat =='gkzfsuche'){
        // api = 'api_2.php?command=gkzfsuche';
        api='api_2.php?command=gkzfsuche&'+ $.param(lng)+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
        //alert(api);
        geocoder.geocode( {
            'address': lng.label
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                mapcenter = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                // alert(mapcenter.toString());
                centermarker.setPosition(mapcenter);
                centermarker.setMap(map);
                circle.setCenter(mapcenter);
                map.panTo(mapcenter);
                $('#address').val(results[0].formatted_address);
                if ($('#okzfdraw').is(':checked')){
                    new MapLabel({
                        map: map,
                        text: lng.value,
                        position: mapcenter,
                        fontColor: '#ff0000',
                        minZoom: 6
                    });
                }
            // console.log(mapcenter);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
        $().message('Gemeindekennziffernsuche: ' + lng.label);
    //return;
    }
    else if(lat=='bestandssuche'){
        $().message('Bestandssuche...');
        // $.pa
        api='api_2.php?command=2&'+ $.param(lng)+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
        // console.log(api);
        if (lng.latitude >0 && lng.longitude > 0) {
            mapcenter = new google.maps.LatLng(lng.latitude, lng.longitude);
        // console.log(mapcenter);
        } else {
            geocoder.geocode( {
                'address': lng.label
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    mapcenter = (results[0].geometry.location);
                // console.log(mapcenter);
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }

    }
                
    else if (lat == 'bounds'){
        // Zeichenkette der Form "lat_lo,lng_lo,lat_hi,lng_hi"
        $().message('Ausschnittssuche...');
        api = 'api_2.php?command=6&bounds='+lng.toUrlValue()+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
    } else if (lat == 'polygon'){
        // Zeichenkette der Form "lat_lo,lng_lo,lat_hi,lng_hi"
        // var api = 'api_2.php?command=7&bounds='+lng.toUrlValue(); 
        api = 'api_2.php?command=7&bounds=' + encodeURI($.toJSON(lng))+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
    // bounds = poly.getBounds();
    // alert(api);

    } else if (lat=='geonotes'){
        // console.log(lng);
        return;
    } else if (lat=='merkliste'){ 
        // console.log(lng);
        return;
    }
                
    else if (lat=='gdmload'){
        /**
         * @todo: fix arrays -> JSON, make apiCallBack() public available!
         */
        alert(apiCallBack(lng));

    }else if(lat =='postdata'){

        api = 'api_2.php?command=8&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()+'&output='+ outputformat;
        outputformat = 'application'; // ALWAYS reset the trigger IMMEDIATELY. 
        // alert (api+lng);
        // $.post(api,lng,apiCallBack);
        $.ajax({
            type: 'POST',
            url: api,
            data: lng,
            success: apiCallBack,
            dataType: 'json',
            ajaxStart: $.loading({
                mask: true,
                text: 'Lade Daten...', 
                pulse: 'working fade'
            }),
            ajaxComplete: $.loading(false)
        });
        if ($('#drawplz').is(':checked')){
            $.getJSON('api_2.php?command=graphics&'+lng, function(data){
                // console.log(data);
                var latlngBounds = new google.maps.LatLngBounds();
                $.each(data, function(index, value){
                    var plzpoly = new google.maps.Polygon({
                        // path: latlngs,
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
                        // console.log(coords[0] +' '+coords[1]);
                        var latlng = new google.maps.LatLng(coords[1],coords[0]);
                        latlngBounds.extend(latlng);
                        mybounds.extend(latlng);
                        var path = plzpoly.getPath();
                        path.push(latlng);
                    });
                    plzpoly.setMap(map);  
                    var polycenter = mybounds.getCenter();
                    // console.log(polycenter);
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
        }
        return;
    } else {
        $().message('Umkreissuche...');
        api = 'api_2.php?command=4&latitude='+lat+'&longitude='+lng+'&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
        mapcenter = new google.maps.LatLng(lat,lng);
    }
                
    // $.getJSON(api, apiCallBack);
    
    $.ajax({
        url: api,
        success: apiCallBack,
        dataType: 'json',
        ajaxStart: $.loading({
            mask: true,
            text: 'Lade Daten...', 
            pulse: 'working fade'
        }),
        ajaxComplete: $.loading(false)
    });
    
    if (lat!= 'polygon' && lat!='bounds'){
        // map.panTo(mapcenter);
        //alert(mapcenter.toString());
        centermarker.setPosition(mapcenter);
        centermarker.setMap(map);
        circle.setRadius(umkreis);
        circle.setCenter(mapcenter);
        map.fitBounds(circle.getBounds());
        if (svdisplay.getVisible() == true){
            // svpos = marker.getPosition();
            // console.log('SV DISPLAY VISIBLE.');
            svdisplay.setPosition(mapcenter);
        }
    }
    $('#taggedtmp').val($.Storage.get('tagged'));
    function apiCallBack(data){
        pb.hide();
        var markers= [];
        var maxNum = data.length;
        if (maxNum < 1) {
            $().message('Keine passenden Tafeln gefunden.');
        }
        // var searchnode = $('#address').val();
        //                     $('#tree-control').dynatree('getTree') .getNodeByKey('search-history').addChild({
        //                         title: searchnode,
        //                         key: searchnode,
        //                         isFolder: true
        //                     });


        pb.start(maxNum);

        //                     var styleIcon = new StyledIcon(StyledIconTypes.BUBBLE,{
        //                                 color:'ffffec',text:'!', fore:'1234ff'});
        //                     var markerimage = new google.maps.MarkerImage(
        //                     'images/marker-image.png',
        //                     new google.maps.Size(53,52),
        //                     new google.maps.Point(0,0),
        //                     new google.maps.Point(27,52)
        //                 );

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
        }

        if(!$('#append').is(':checked')){
            // alert ('no append!');
            if (markerClusterer) {
                markerClusterer.clearMarkers();
            }
            $('#markersRepository').removeData();
            repositoryTable.fnClearTable();
            if(markerPlacesClusterer){
                markerPlacesClusterer.clearMarkers();
            }
        // $('#tree-control').dynatree('getTree').getNodeByKey('search-history') .removeChildren();
        } else {
            $('#labelforappend, #markercounter').pulse({
                opacity: [.4,1], 
                outlineColor: ['red', 'yellow']
            }, {
                duration: 700, // duration of EACH individual animation
                times: 3, // Will go three times through the pulse array [0,1]
                easing: 'linear' // easing function for each individual animation
            
            });
        }
                    
        tagged = $.evalJSON($.Storage.get('tagged'));


        for (var i = 0; i < maxNum; ++i) {
            if (!$('#markersRepository').data(data[i].id+'')){
                //                             $('#tree-control').dynatree('getTree') .getNodeByKey(searchnode).addChild({
                //                                 title: data[i].id
                //                             });
                latlng = new google.maps.LatLng(data[i].latitude,data[i].longitude);
                markertext = data[i].id;
                markerimage = new google.maps.MarkerImage(
                    'images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png',
                    new google.maps.Size(29,39),
                    new google.maps.Point(0,0),
                    new google.maps.Point(15,39)

                    );

                // var marker = new MarkerWithLabel({
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
                    aktiverstatus: data[i].aktiverstatus
                };
                            
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
                    labelStyle: {
                        opacity: 0.75
                    },
                    markerData: markerdata,
                    tagged: 'untagged',
                    oimage: 'images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png'
                });
                attachInfoBubble(marker,data[i]);
                // tagged = $.evalJSON($.Storage.get('tagged'));
                if (tagged){
                    $.each(tagged, function(){
                        if (this.id == data[i].id){
                            // console.log('tagged new marker');
                            marker.set('tagged', 'tagged');
                            markerimage = new google.maps.MarkerImage('images/mapicons/tropfen_gruen.png');
                            marker.setIcon(markerimage);
                        }
                    });
                }
                // var markerid = data[i].id;
                markerRightClickMenu = new google.maps.event.addListener(marker,'rightclick', function(e,marker){
                    //                                 // console.log(e);
                    showMarkerContextMenu(e.latLng, this.get('markerData').id);
                    
                });
                                
                markerClusterer.addMarker(marker);
                setTimeout('pb.updateBar(1)',3000);
                            
                            
                $('#markersRepository').data(data[i].id, markerdata);
                $('#taggedRepository').data(data[i].id, markerdata);
                            
                            
                repositoryTable.fnAddData( [
                    data[i].id,
                    data[i].label,
                    data[i].description,
                    data[i].plz,
                    data[i].leistungswert1,
                    '<img class="marker" src="images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png"/>'+ data[i].stellenart,
                    // data[i].stellenart,
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
        $().message(' '+ maxNum + ' Tafeln gefunden.');
        setTimeout('pb.hide()',5000);
        // repositoryTable.fnDraw();
        updateRepositoryTable();
        
                 
        // better to function updateRepositoryStorage
        var data = Array();
        $.each($('#markersRepository').data(), function(key, value) {
            // alert(key + ': ' + value);
            data.push({
                id: value.id,
                latitude:value.latitude,
                longitude:value.longitude,
                label:value.label,
                description: value.description,
                plz: value.plz,
                stellenart: value.stellenart,
                leistungswert1: value.leistungswert1,
                ortskennziffer: value.ortskennziffer,
                preis: value.preis,
                beleuchtung: value.beleuchtung,
                standortnr: value.standortnr,
                belegdauerart: value.belegdauerart,
                bauart: value.bauart,
                hoehe: value.hoehe,
                breite: value.breite,
                aktiverstatus: value.aktiverstatus
                
            
            });

        });
        //$('#tmp').data('sysids',data);
        data = $.toJSON(data);
        $.Storage.set('lastrepository', data);
        $.Storage.set('lastrepository_changed_from_map', 'changed');
        // EO updateRepositoryStorage

        if($('#applyplaces').is(':checked')){
            // alert('finding places now');
            getPlacesByRadius(umkreis, map.getCenter());
        }
        
        if($('#timeFilterActive').is(':checked')){
            // alert('finding places now');
            $('#tabs').tabs('select',4);
            $('#kalenderplanung').tabs('select',1);
            
            
            
            sucheFreieTafeln();
        }
        
    }
}
//  Ende API request +  callback
function updateMapFromStorage(){
    $().message('Lade Benutzerdaten...');
    loadLastRepositoryToMap();
    loadTaggedToMap();
}

function updateCalendarSelection(){
    // showCalendarAllBocks();
    try {
        var start = new Date(Date.parse($('#startdatum').val()).toString('yyyy-MM-dd'));
        var end = new Date(Date.parse($('#enddatum').val()).toString('yyyy-MM-dd'));
                    
        $('#monatskalender').fullCalendar( 'unselect' );
        $('#monatskalender').fullCalendar('select', start,end);
                    
        $("#timeResultsTable table").tsort("thead");
                     
    } catch (e){
    //console.log(e); 
    }
    $("#timeResultsTable table").tsort("thead");
    $('#timeInputsScroller').jScrollPane({
        showArrows: true
    });
}
function clearCalendar(){
    $('#results, #kwsmalltables').html(''); 
    $('#monatskalender').fullCalendar('removeEvents');
    $('#monatskalender').fullCalendar( 'unselect' );
    $('#timeResultsTable').dataTable().fnClearTable();
    $('#timeinputs form').resetForm();
    KWLIST = new Array();
    DEKALIST = new Array();
    // showCalendarAllBlocks();
    updateCalendarSelection();
    $().message('Kalender / Datumsfilter gelöscht.');
    
}

function updateDateSelection(){              
    /*
                 * var start / var end:
                 * müssen doppelt: Eintrag fullcalendar + $.get-Format!!
                 */
    $().message('Füge Datumsfilter hinzu');
    var start = new Date(Date.parse($('#startdatum').val())).toString('yyyy-MM-dd');
    // console.log(start);
    var end = new Date(Date.parse($('#enddatum').val())).toString('yyyy-MM-dd');
    // console.log(start);
    $('#monatskalender').fullCalendar('addEventSource',[{
        start: start,
        end: end,
        title: $('#startdatum').val() +' - '+$('#enddatum').val(),
        className: 'ui-state-selected'
    }]);
    /* s.o. */
    start = Date.parse($('#startdatum').val()).toString('dd.MM.yyyy');
    end = Date.parse($('#enddatum').val()).toString('dd.MM.yyyy');
    $.getJSON('termine.php?daterange='+start+','+ end, function(data){
        var i = data['startdeka'];
        while (i <= data['enddeka']){
            $.get('termine.php?Dekade='+ i);
            DEKALIST.push(parseFloat (i));
            $.unique(DEKALIST);
            i++;
        }                    
        var j = data['kwmin'];
        while ( j <= data['kwmax']){                        
            KWLIST.push(j);
            $.unique(KWLIST);
            $.get('termine.php?KW='+j);                        
            j++;
        }
    });
}

function updateDekaSelection(){
    var dekalist=
    $("#dekadata").multiselect("getChecked").map(function(){
        return this.value;	
    }).get();
    
    $.each(dekalist, function(i,data){
        var d = parseFloat (data);
        DEKALIST.push(d);
        $.unique(DEKALIST);
        $().message('Füge Dekade '+d+' hinzu.');
        $.get('termine.php?Dekade='+ d);
    });
}

function sucheFreieTafeln(){
    //return true;
    var l = $('#monatskalender').fullCalendar('clientEvents');
    $().message('Hole Freizahlen für geladene Tafeln im gewünschten Zeitraum...');
    
    $('#labelfortimeFilterActive').pulse({
        opacity: [.4,1]
    }, {
        duration: 700, // duration of EACH individual animation
        times: 4, // Will go three times through the pulse array [0,1]
        easing: 'linear' // easing function for each individual animation
            
    });
    
    getFreizahlenFromKwList();
// l = toJSON(l);
// alert(l + '\n ' + KWLIST + '\n ' + DEKALIST);
//$('#timeResultsTable').dataTable().fnDraw();
}

function getFreizahlenFromKwList(){
    
    
    
    $.loading({
        mask: true,
        text: 'Lade Daten...', 
        pulse: 'working fade',
        max: 30000
    });
    $.post('termine.php?kwdata=1', {
        kwdata: $.toJSON(KWLIST),
        ids: $.Storage.get('lastrepository')
        
    }, gfzcallback);
}
function gfzcallback(data){
    FREI = $.evalJSON(data);
    timeResultsTable.fnClearTable();
    /*
                 * 
                 * 
                    data.Belegdauerart
                    data.Beleuchtung
                    data.Fotoname
                    data.Leistungsklasse1
                    data.Leistungswert1
                    data.PLZ
                    data.Rechnungstage
                    data.Standortbezeichnung
                    data.StatOrtskz
                    data.Stellenart
                    data.Tagespreis
                    data.Zeitraum
                    data.id
                    data.latitude
                    data.longitude
                 */
    $.each(FREI, function(index,data){
        timeResultsTable.fnAddData([data.id, data.Stellenart, data.PLZ, data.Rechnungstage,
            data.Tagespreis/100, data.Leistungswert1, data.Zeitraum, 
            '<input class="'+
            data.Belegdauerart
            +'" type="checkbox" name="tagged" value="'+data.id+'"/> '+data.Belegdauerart], false);
    });
    timeResultsTable.fnDraw();
    $.loading(false);
}

function showCalendarAllBlocks(){
    $('input[name=block]').attr('checked', true);
    $('.blockA:hidden, .blockB:hidden, .blockC:hidden').toggle();
}

function getFreizahlenForInfoBubble(id){
    $.getJSON('termine.php?belegung='+id, function(data) {
        var items = [];
        

        $.each(data, function(key, val) {
            var checkstring;
            $.each(IDLIST, function(data){
                if (val.count+'-'+val.Zeitraum == this){
                    checkstring = ' checked="checked" ';
                }
            });
            
            items.push('<input type="checkbox" value="' 
                + val.count + 
                '-'+val.Zeitraum+'" '+checkstring+' id="checkbox_'+
                
                + val.count + 
                '-'+val.Zeitraum +
                '"/>' + val.Zeitraum + ' ');
        });

        $('<form/>', {
            'class': 'my-new-list',
            html: items.join('')
        }).appendTo('#infobubble_main_'+id);
        
        $('.infobubble_main input').bind('click',
            function(){
                
                var $this = $(this); 
                
                
                
                if ($this.is(':checked')) {
                    // action checked 
                    cartAdd($this.val().substring(0, $this.val().length - 3));
                    terminAdd($this.val());
                // alert('unchecked '+$(this).val());
                } else {
                    // actionunchecked
                    // noop! cartRemove($this.val().substring(0, $this.val().length - 3));
                    terminRemove($this.val());
            
                }

            });
    });
}
function terminAdd(id){
    IDLIST.push(id); 
    IDLIST.unique;
    $.Storage.set('termine',$.toJSON(IDLIST));
    $('#termine_'+id.substring(0, id.length - 3))   
    .append('<span id="check_'+id+'"><input type="checkbox"  checked="checked" value="' + id + '"/>' + id +'</span>');
    $('#check_'+id).bind('click', function(){
        terminRemove(id);
    });
    $().message('Termin hinzugefügt');
}
function terminRemove(id){
    for(var i=0; i<IDLIST.length;i++ )
    { 
        if(IDLIST[i]==id){
            IDLIST.splice(i,1); 
            $.Storage.set('termine',$.toJSON(IDLIST));
        }
    } 
    $('#check_'+id).remove();  
    $('#checkbox_'+id).attr('checked', false);
    $().message('Termin entfernt');
}

function checkIfTermin(id, tagged){
    // tagged =$.evalJSON($.Storage.get('tagged'));
    $.each(tagged, function(){
        if(this.id== id) {
            // console.log('match:' + id);
            return true;
        } else return false;
    });
}    

function calcRoute() {
    $().message('Berechne und durchsuche Route...');
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

        //            var summaryPanel = document.getElementById("directions_panel");
        //            var text ='';
        //            summaryPanel.innerHTML = "";
        //            // For each route, display summary information.
        //            for (var i = 0; i < route.legs.length; i++) {
        //                var routeSegment = i + 1;
        //                text += '<input id="streckenkoordinaten" type="hidden" value="'+coords+'"/>';
        //                text += '<a href="api.php?command=4&'+$('#geocoder').serialize()+'">';
        //
        //                text += '<div class="ui-icon fff-icon-zoom" style="float:left"></div>';
        //                text += 'Segment '  + routeSegment + ": ";
        //                text += $("#startadresse").val() + " -> ";
        //                text += $("#zieladresse").val() + " | ";
        //                text += route.legs[i].distance.text + '</a>';
        //
        //                summaryPanel.innerHTML = text;
        //            }
        //            $('#zwischenstop').val('');
        //            //$('#zwischenstopliste').html('');
        //            $('#directions_panel a').button();
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
        if( $('#applyplaces').is(':checked')){
            getPlacesByBounds(boxes[i]);
        }
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

function updateLensmapCenter() {

    //var currentZoom = map.getZoom();
    if (lensmap.getCenter() !== map.getCenter()) {
        lensmap.setCenter(map.getCenter());
    }
    if (lensmap.getZoom() !== map.getZoom()) {
        lensmap.setZoom(map.getZoom()-4);
    }
    lensrectangle.setBounds(map.getBounds());

}


$(document).ready(function(){
    $('#loader p').html('Initialisiere Komponenten...');
    $('#loaderProgressBar').progressbar({
        value: 0
    });
    var loadstate = 0;
    var timer = $.timer(function(){
        if (loadstate < 100){
            loadstate++;
            $('#loaderProgressBar').progressbar('value', loadstate);
        } else {
            timer.stop;
            $('#loaderProgressBar').hide(1000);
            $('#loader').hide('fade',2800) ;
        }
    });
    timer.set({
        time: 40, 
        autostart: true
    }); 
    
    
    if(GET('init')==1){
        $.Storage.set('lastrepository', '[]');
    }
               
    try {
        tagged = $.evalJSON($.Storage.get('tagged'))
    } catch (e){};
               
    geocoder = new google.maps.Geocoder();
    mapcenter = new google.maps.LatLng(startLat,startLng);
    
    plot1 = $.jqplot('graphics', [[0, 0, 0, 0]], plot1options);
    plot2 = $.jqplot('total_counter_graphics', [[0,0,0]], plot2options);
    

    
                
    var stylez01 = [
    {
        featureType: "transit",
        elementType: "geometry",
        stylers: [
        {
            hue: '#0000cc'
        },
        {
            saturation: 90
        },
        {
            lightness: 10
        }
        ]
    },{
        featureType: "transit.station",
        elementType: "all",
        stylers: [
        {
            hue: '#0000FF'
        },
        {
            saturation: 90
        },
        {
            lightness: 0
        }
        ]
    },{
        featureType: "road.highway",
        elementType: "geometry",
        stylers: [
        {
            hue: '#000000'
        },

        {
            saturation: 0
        },
        {
            gamma: -90
        }
        ]
    },{
        featureType: "road.arterial",
        elementType: "geometry",
        stylers: [
        {
            hue: '#FF0000'
        },

        {
            saturation: 100
        },
        {
            gamma: 60
        }
        ]
    },{
        featureType: "road.local",
        elementType: "geometry",
        stylers: [
        {
            hue: '#0000ff'
        },
        {
            saturation: 10
        },
        {
            gamma: 40
        }
        ]
    },
    {
        featureType: "landscape",
        elementType: "geometry",
        stylers: [
        {
            hue: "#00ff00"
        },
        {
            saturation: 35
        },
        {
            lightness: -70
        }
        ]
    },
    {
        featureType: "poi",
        elementType: "all",
        stylers: [
        {
            hue: "#FF0000"
        },
        {
            saturation: 95
        },
        {
            lightness: 0
        }
        ]
    }

    ];

    var stylez02 = [
    {
        featureType: "road",
        elementType: "geometry",
        stylers: [
        {
            hue: -45
        },
        {
            saturation: 100
        }
        ]
    },{
        featureType: "all",
        elementType: "labels",
        stylers: [
        {
            visibility: "off"
        }
        ]
    },{
        featureType: "poi",
        elementType: "all",
        stylers: [
        {
            visibility: "off"
        }
        ]
    },{
        featureType: "administrative",
        elementType: "all",
        stylers: [
        {
            visibility: "off"
        }
        ]
    },
    {
        featureType: "landscape",
        elementType: "geometry",
        stylers: [
        {
            hue: "#000000"
        },
        {
            saturation: 75
        },
        {
            lightness: -100
        }
        ]
    }
    ];

    var stylez03 = [
    {
        featureType: "road",
        elementType: "geometry",
        stylers: [
        {
            hue: 45
        },
        {
            saturation: 100
        }
        ]
    },
    {
        featureType: "landscape",
        elementType: "geometry",
        stylers: [
        {
            hue: "#CCCCCC"
        },
        {
            saturation: -75
        },
        {
            lightness: 100
        }
        ]
    },
    {
        featureType: "landscape.man_made",
        elementType: "geometry",
        stylers: [
        {
            hue: "#CCCC00"
        },
        {
            saturation: 75
        },
        {
            lightness: 100
        }
        ]
    },{
        featureType: "road.highway",
        elementType: "labels",
        stylers: [
        {
            visibility: 'off'
        }
        ]
    },{
        featureType: "road.arterial",
        elementType: "geometry",
        stylers: [
        {
            saturation: -75
        }
        ]
    }
    ];
                
    var stylez04 = [ {
        featureType: "all", 
        elementType: "all", 
        stylers: [ {
            visibility: "off"
        } ]
    },{
        featureType: "administrative.country", 
        elementType: "all", 
        stylers: [ {
            visibility: "on"
        } ]
    },{
        featureType: "administrative.province", 
        elementType: "all", 
        stylers: [ {
            visibility: "on"
        } ]
    },{
        featureType: "transit.line", 
        elementType: "all", 
        stylers: [ {
            visibility: "on"
        } ]
    },{
        featureType: "transit.station", 
        elementType: "all", 
        stylers: [ ]
    },{
        featureType: "water", 
        elementType: "geometry", 
        stylers: [ {
            visibility: "on"
        }, {
            gamma: 2.93
        } ]
    },{
        featureType: "road.arterial", 
        elementType: "geometry", 
        stylers: [ {
            visibility: "on"
        }, {
            lightness: 14
        } ]
    },{
        featureType: "poi", 
        elementType: "geometry", 
        stylers: [ {
            visibility: "on"
        }, {
            saturation: -79
        }, {
            lightness: 71
        } ]
    },{
        featureType: "landscape", 
        elementType: "geometry", 
        stylers: [ {
            visibility: "on"
        }, {
            lightness: 96
        } ]
    } ];
    var stylez05 = [ {
        featureType: "all", 
        elementType: "all", 
        stylers: [ {
            visibility: "off"
        } ]
    },{
        featureType: "landscape", 
        elementType: "geometry", 
        stylers: [ {
            visibility: "on"
        }, {
            lightness: 96
        } ]
    } ];


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
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            position: google.maps.ControlPosition.TOP_LEFT
        }

    };

    circle = new google.maps.Circle({
        fillOpacity : .1,
        fillColor:'#ffccaa',
        strokeColor:'#00ff00',
        strokeOpacity: .77,
        strokeWeight: 2,
        clickable: false
    });
    markerimage = new google.maps.MarkerImage('css/ui-icon/ico/arrow_refresh.png');
    centermarker = new google.maps.Marker({
        draggable: true,
        title: 'Umkreis!',
        icon: markerimage
    });
    //    centermarker.setPosition(mapcenter);
    //    centermarker.setMap(map);
    //    circle.setRadius(umkreis);
    circle.bindTo('center', centermarker, 'position');
    
    
    google.maps.event.addListener(centermarker, 'dragend', function() {
        mapcenter = centermarker.getPosition();
        geocoder.geocode( {
            'latLng': mapcenter
        },
        function(results, status) {
            $('#address').val(results[0].formatted_address);
        });
    });
    google.maps.event.addListener(centermarker,'dblclick', function(){
        $('#tabs').tabs('select',1);
        apiRequest(mapcenter.lat(), mapcenter.lng());
    });
    
    
    
                
    rightclickimage = new google.maps.MarkerImage('images/mapicons/point_of_interest.png');
    rightclickmarker = new google.maps.Marker({
        draggable: false,
        title: '',
        icon: rightclickimage
    });
                
                
    infoBubble = new InfoBubble();
    infowindow = new google.maps.InfoWindow();

    $('#tabs, #filtertabs').tabs();
                
    appLayout = $('body').layout({
        applyDefaultStyles: false,
        east: {
            initClosed: false, 
            size: 580, 
            onopen_end: redrawMap, 
            onclose_end: redrawMap, 
            onresize_end: redrawMap,
            resizable: false,
            togglerTip_open: 'Klicken um die Anzeige der Infofläche umzuschalten',
            togglerTip_closed: 'Klicken um die Infofläche anzuzeigen'
        },
        south: {
            initClosed: true, 
            size: 120, 
            onopen_end: redrawMap, 
            onclose_end: redrawMap, 
            onresize_end: redrawMap,
            resizable: false,
            initHidden: true
        },
        west: {
            initClosed: true, 
            size: 480, 
            onopen_end: redrawMap, 
            onclose_end: redrawMap, 
            onresize_end: redrawMap
        },
        north: {
            initClosed: true, 
            size: 52, 
            onopen_end: redrawMap, 
            onclose_end: redrawMap, 
            onresize_end: redrawMap
        }
    });
    appLayout.allowOverflow('center'); 
    // appLayout.allowOverflow('south'); 
    $.loading.classname = 'loading';
    $.loading({
        onAjax:true, 
        text: 'Lade Daten...', 
        pulse: 'working fade', 
        mask:true,
        max: 15000
    });
    //$('#loaderProgressBar').progressbar('value', 20);                         
    $("#address").autocomplete({
        source: function(request, response) {
            geocoder.geocode( {
                'address': request.term , 
                'region':'DE', 
                'language':'de'
            },
            function(results, status) {
                response($.map(results, function(item) { 
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
                $('#labelforaddressUmkreisSuche').pulse({
                    opacity: [.4,1]
                }, {
                    duration: 700, // duration of EACH individual animation
                    times: 4, // Will go three times through the pulse array [0,1]
                    easing: 'linear' // easing function for each individual animation
            
                });
                apiRequest(lat, lng);
            } else {
                            
                centermarker.setPosition(mapcenter);
                centermarker.setMap(map);
                circle.setCenter(mapcenter);
                map.panTo(mapcenter);
            }
            $('#tabs').tabs('select',1);
        }
    });
    $('#address, .clearfield') .clearField() .button();
    $('.button, #append, #applyplaces, #addressUmkreisSuche, .datum').button();
    $( "#formtoolsdatatype, .buttonset" ).buttonset();
    $.datepicker.setDefaults($.datepicker.regional['de']);
    /* $( ".datum" ).datepicker({
        onClose: function (){
            $('#checkOutForm').valid();
        }
    }).button(); */
    $('.datepicker').not('#kwauswahlnachdatum').datepicker({
        defaultDate: "+2w",
        changeMonth: false,
        numberOfMonths: 3,
        showOtherMonths: true,
        selectOtherMonths: true,
        showWeek: true,
        onSelect: function(data){
            var date = new Date(Date.parse(data).toString('yyyy-MM-dd'));
            $('#monatskalender').fullCalendar('gotoDate', date);
            $('#monatskalender').fullCalendar('select', date);
            updateCalendarSelection();      
                        
        }
    });
    $('#kwauswahlnachdatum').datepicker({
        defaultDate: "+2w",
        changeMonth: false,
        numberOfMonths: 3,
        showOtherMonths: true,
        selectOtherMonths: true,
        showWeek: true,
        onSelect: function(data){
            var date = new Date(Date.parse(data).toString('yyyy-MM-dd'));
            // var kwstart = date.sunday().toString('dd.MM.yyyy');
            $('#startdatum').val(date.sunday().addDays(-7).toString('dd.MM.yyyy'));
            $('#enddatum').val(date.sunday().addDays(-1).toString('dd.MM.yyyy'));
            // console.log(kwstart);
            $('#monatskalender').fullCalendar('gotoDate', date);
            $('#monatskalender').fullCalendar('select', date);
            updateCalendarSelection();  
                        
        //$(this).parent('form').submit();
        //updateDateSelection();
                        
                        
        }
    });
         
         
    //$('#loaderProgressBar').delay(3000).progressbar('value', 40);     
         
         
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    circle.setMap(map);
    pb = new progressBar();
    map.controls[google.maps.ControlPosition.TOP].push(pb.getDiv());
    pservice = new google.maps.places.PlacesService(map);
    markers = [];
    markerClusterer = new MarkerClusterer(map, markers);
    markerClusterer.setMaxZoom(clusterzoom);
    sv = new google.maps.StreetViewService();
    svdisplay = map.getStreetView();
    
    centermarker.setPosition(mapcenter);
    centermarker.setMap(map);
    circle.setRadius(umkreis);
    circle.setCenter(mapcenter);
                
    google.maps.event.addListener(map, 'idle', updateRepositoryTable);
    // google.maps.event.addListener(map, 'bounds_changed', updateLensmapCenter);
    google.maps.event.addListener(map, "rightclick",function(event){
        showContextMenu(event.latLng);
    });
    google.maps.event.addListener(map, "click", function(event) {
        $('.contextmenu').remove();
        rightclickmarker.setMap(null);
        if(infoBubble.isOpen()){
            // infoBubble.close();
            infoBubble.setMap(null);
        }
    });
    
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
    lensrectangle = new google.maps.Rectangle();
    lensrectangleoptions = {
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: "#FF0000",
        fillOpacity: 0.1,
        map: lensmap,
        bounds: map.getBounds()
    };
    lensrectangle.setOptions(lensrectangleoptions);

    // markerlensmapClusterer = new MarkerClusterer(lensmap, []);


   

    
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
        boxStyle: {
            border: "2px solid #00FF00"
        }
    });
    var dz = map.getDragZoomObject();
    google.maps.event.addListener(dz, 'dragend', function (bnds) {

        if($('#addressUmkreisSuche').is(':checked')){
            //alalert('KeyDragZoom Ended: ' + bnds);
            apiRequest('bounds', bnds);
        }
    });
    
    
    
    var styledMapOptions01 = {
        name: "Duopoly"
    };

    var styledMapOptions02 = {
        name: "Arterien"
    };
    var styledMapOptions03 = {
        name: "Verkehr"
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

    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer();
    boxpolys = null;
    routeBoxer = new RouteBoxer();
    distance = null; // km
            
    //$('#loaderProgressBar').progressbar('value', 50);
                
    $( "#umkreis" ).slider({
        orientation: "vertical",
        range: "min",
        value: umkreis,
        min: 10,
        max: 5000,
        step: 10,
        animate: true,
        slide: function( event, ui ) {
            centermarker.setPosition(mapcenter);
            umkreis = ui.value;
            $().message('neuer Radius:'+ umkreis + 'm');
            $( "#zoom" ).val( umkreis +'m' );
            circle.setRadius(umkreis);
        },
        stop: function( event, ui ) {
            
            centermarker.setPosition(mapcenter);
            umkreis = ui.value;
            $( "#zoom" ).val( umkreis +'m' );
            circle.setRadius(umkreis);
            map.fitBounds(circle.getBounds());
            $('#zoom').pulse({
                opacity: [.4,1]
            }, {
                duration: 700, // duration of EACH individual animation
                times: 3, // Will go three times through the pulse array [0,1]
                easing: 'linear' // easing function for each individual animation
            
            });
        }
    })
    .bind('mouseover', function(event, ui){
        $().message('Radius der Umkreissuche:'+ umkreis + 'm');
        
    });
    $( "#zoom" ).val( umkreis +'m' );
    $('#zoom').live('click', function(){
        $('#tabs').tabs('select',1);
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
        slide: function(event, ui){
            $().message('Clusterzoom: ' + ui.value);
        },
        stop: function( event, ui ) {

            clusterzoom = ui.value;
            
            if (markerPlacesClusterer) {
                markerPlacesClusterer.setMaxZoom(clusterzoom); 
                markerPlacesClusterer.resetViewport();
                markerPlacesClusterer.redraw();
            }
            if (markerClusterer) {
                markerClusterer.setMaxZoom(clusterzoom);
                markerClusterer.resetViewport();
                markerClusterer.redraw();
            }
        }
    })
    .bind('mouseover', function(event, ui){
        $().message('Clustern bis Zoomstufe '+ clusterzoom + ' ');
    });
    
    $('#pricezoom').slider({
        orientation: "vertical",
        range: true,
        min: 0,
        max: 20000,
        values: [ 700, 10000 ],
        step: 1,
        animate: true,
        slide: function( event, ui ) {
            pricerange = ui.values;
            $().message('Preisspanne: ' + pricerange);
            $('#pricecounter').val(pricerange);
            $( "#bestandssuche" ).autocomplete( "option" , {
                source: 'api_2.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()
            } );
        }
    })
    .bind('mouseover', function(event, ui){
        $().message('Preisspanne [von,bis]:'+ pricerange + ' (in €/100)');
    });
    pricerange = $('#pricezoom').slider('values');
    
    $('#gfkzoom').slider({
        orientation: "vertical",
        range: true,
        min: 0,
        max: 500,
        values: [ 0, 300 ],
        step: 1,
        animate: true,
        slide: function( event, ui ) {
            gfkrange = ui.values;
            $().message('Leistungswert (GFK): ' + gfkrange);
            $('#gfkcounter').val(gfkrange);
            $( "#bestandssuche" ).autocomplete( "option" , {
                source: 'api.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()
            } );
        }
    })
    .bind('mouseover', function(event, ui){
        $().message('Leistungswert (GFK) [von,bis]:'+ gfkrange + ' ');
    });
    gfkrange = $('#gfkzoom').slider('values');
    $('#gfkcounter').val(gfkrange);
    
    
    
    $('form select optgroup option ').tsort();
    $("form#extendedfilter select, form#Stellenartenfilter select, form#Unterstellenartenfilter select, form#Placesfilter select, #dekadata").multiselect({
        position: {
            my: 'top',
            at: 'bottom'
        }, 
        header: false, 
        minWidth: 'auto', 
        height: '180', 
        selectedList: 10, 
        selectedText: '# / #', 
        show: ['slide', 500], 
        open: function(){
            $('.ui-multiselect-checkboxes') .jScrollPane({
                showArrows: true
            });
        }
    });
                
    $.each($('#Placesfilter .ui-multiselect-checkboxes label'),function(){
        $(this).append('<img style="float:left; height: 12px;" src="images/mapicons/'+$('input', this).val()+'.png"/>');
    });
                
    $("form#extendedfilter select, form#Stellenartenfilter select, form#Unterstellenartenfilter select, form#Placesfilter select, #dekadata").multiselect('close');
    $('#Unterstellenartenfilter select').multiselect('checkAll');
    $('#Unterstellenartenfilter').hide();
    // $('#loaderProgressBar').progressbar('value', 60);
    repositoryTable = $('#repositoryTable').dataTable({
        "oLanguage": dataTableLanguage,
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        "aoColumnDefs": [ 
        {
            "bSearchable": true, 
            "bVisible": false, 
            "aTargets": [ 1 ]
        },
        {
            "bSearchable": false, 
            "bVisible": false, 
            "aTargets": [ 8,9,10,11,12 ]
        }
        ],
        // "sScrollY": "200px",
        "bPaginate": false,
        "sDom": 'TC<"top">t',
        "oColVis": {
            "buttonText": "Spalten..."
        },
        "fnDrawCallback": function() {
            //function() { NOT WORKING????!!!!!
            var table = this.fnSettings().aoData;
            for (var i = 0; i < table.length; i++) 
            {
                var item = table[i];
                var checkme = Number(item._aData[0]);
                var nTr = item.nTr;
                checkIfTagged(checkme, function(data){
                    if (data > 0 ) {
                        $(nTr).addClass('ui-state-active');
                    }
                });
            }
            //}
                        
            $('#map-side-bar-container').jScrollPane({
                showArrows: true
            });                        
        }
    });
    taggedRepositoryTable = $('#taggedRepositoryTable').dataTable({
        "oLanguage": dataTableLanguage,
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        "aoColumnDefs": [ 
        {
            "bSearchable": true, 
            "bVisible": false, 
            "aTargets": [ 1 ]
        },
        {
            "bSearchable": false, 
            "bVisible": false, 
            "aTargets": [ 8,9,10,11,12 ]
        }
        ],
        // "sScrollY": "200px",
        "bPaginate": false,
        "sDom": 'TC<"top">t',
        "oColVis": {
            "buttonText": "Spalten..."
        },
        "fnDrawCallback": function() {
                        
            
            $.each ($(':checkbox.reptblchk'), function(){
                $(this).bind('click', function(){
                    terminRemove($(this).val());
                    $(this).parent().remove();
                });
            });
            $('#merkzetteltableouter').jScrollPane({
                showArrows: true
            });  
        }
    });
                
    $('#repositoryTable tbody tr, #taggedRepositoryTable tbody tr, #timeResultsTable tbody tr').live('click', function () {
        var nTds = $('td', this);
        $.each(markerClusterer.getMarkers(), function(index, marker){
            if ($(nTds[0]).text()==marker.markerData['id']){
                //  map.panTo(marker.getPosition());
                mapcenter = marker.getPosition();
                google.maps.event.trigger(marker, 'click');
            // centermarker.setPosition(marker.getPosition());
                            
            }
        });
        $(repositoryTable.fnSettings().aoData).each(function (){
            $(this.nTr).removeClass('ui-state-highlight');
        });
        $(taggedRepositoryTable.fnSettings().aoData).each(function (){
            $(this.nTr).removeClass('ui-state-highlight');
        });
        $(this).addClass('ui-state-highlight');
    });
                
    $('#no_checkOutForm').validate(
    {

        submitHandler: function(form) {
            //doTheCheckoutSubmit();
            angebotBerechnen();
            $().message('Lade Angebotsberechnung');
            return false;
        },
                    
        validClass: 'ui-state-default',
        rules: {
            IhrName: {
                required: true,
                minlength: 6
            },
            Firma: {
                required: true,
                minlength: 6
            },
            Email: {
                required: true,
                email: true
            },
            Telefon: {
                required: true,
                digits: true,
                minlength: 9
            }
        },
        messages: {
            IhrName: {
                required: "Bitte geben Sie Ihren Namen ein.",
                minlength: "Name: min. 6 Zeichen"
            },
            Firma: {
                required: "Bitte Firmennamen eingeben.",
                minlength: "Firma: min. 6 Zeichen"
            },
            Email: {
                required: "Ihre Emailadresse.",
                email: "Bitte eine gültige Emailadresse eingeben."
            },
            Telefon: {
                required: "Ihre Telefonnummer.",
                digits: "Telefon: nur Zahlen",
                minlength: "Telefon: min. 9 Zeichen"
            }
        }
    });
                
    $('#checkOutForm input').blur(function() {
        $('#checkOutForm').valid();
    });
    $('#checkOutForm').keyup(function() {
        $(this).valid();
    });
    $('#checkOutForm input').change(function() {
                    
        $('#alreadyCheckedOut').html('');
                    
    /*$.each($('#checkOutForm #kontaktdaten input'), function(){
            $.Storage.set($(this).attr('name'),$(this).val()); 
        });*/
                    
    });
    
    //$.get('termine.php?full=1', function(data){
    //  z = eval(data);
    $('#monatskalender').fullCalendar({
        theme: true,
        header: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
        editable: false,
        selectable: false,
        unselectAuto: false,
        height: 100,
        weekMode: 'liquid',
        // events: z
        
        viewDisplay: updateCalendarSelection,
        eventAfterRender : updateCalendarSelection
            
    });
        
    //});
    timeResultsTable = $('#timeResultsTable').dataTable({
        "oLanguage": dataTableLanguage,
        "bJQueryUI": true,
        "bPaginate": false,
        "sDom": 'TC<"top">t',
        "oColVis": {
            "buttonText": "Spalten..."
        },
        
        "fnDrawCallback": function(){
            $('input.A').parents('td').addClass('blockA');
            $('input.B').parents('td').addClass('blockB');
            $('input.C').parents('td').addClass('blockC');
            $('#timeResultsTableScroller').jScrollPane({
                showArrows: true
            });
                        
        }   
    });
    
    var formoptions = {  
        url:       'termine.php', 
        type:      'get' 
    }; 
    $('#quickkw, #quickdeka, #daterangeuser').ajaxForm(formoptions);
    
                
    // $('#tabs').tabs();
    $('#tabs').bind('tabsshow', updateRepositoryTable);
    $('#tabs').bind('tabsshow', updateTaggedRepositoryTable);
    // $('#tabs').bind('tabsshow', timeResultsTable.fnDraw());
    // new FixedHeader( repositoryTable );
    // $('#Placesfilter').toggle('slow');
    $('#applyplaces').bind('click', function(){
        // $('#RECTPLCS, #Placesfilter').toggle('slow');
        });
    $('#taggedClear').bind('click', function(e){
        // console.log(e);
        clearTaggedMarkers();
    });
    // $('#loaderProgressBar').delay(25000).progressbar('value', 70);
    //$('#visibleMarkers').bind('click', function(){
    // $('#visibleMarkersCounter').button().toggle();
    // google.maps.event.trigger(map, 'bounds_changed');
    //});
    // $('#visibleMarkersCounter').button().toggle();
    $('#visibleMarkersCounter').bind('click', function () {
        map.fitBounds(getClustererBounds(markerClusterer));  
    });
                
    $('#submitpastedata').bind('click', function(){
        if (!$('#savedata').is(':checked')){
            if($('#GDMdata').is(':checked')){

                data = $('#formtools textarea').val();
                data = $.evalJSON(data);
                // alert('not implemented yet: '+ $.toJSON(data));
                apiRequest('gdmload', data);


            } else {
                postdata = $('#formtools').serialize();
                apiRequest('postdata', postdata);
            // console.log('apiRequest!')
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
            }
            else if ($('#SysIDs').is(':checked')){
                $.each($('#markersRepository').data(), function(key, value) {
                    // alert(key + ': ' + value);
                    data.push(key);

                });
                $('#tmp').data('sysids',data);
                data = $.toJSON($('#tmp').data('sysids'));
            }else if ($('#SdawIDs').is(':checked')){
                $.each($('#markersRepository').data(), function(key, value) {
                    // alert(key + ': ' + value);
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
                    // alert(key + ': ' + value);
                    data.push(''+value.latitude+' '+value.longitude);

                });
                data = $('#tmp').data('coords',data);
                data = $.toJSON($('#tmp').data('coords'));
            } else if ($('#Postleitzahlen').is(':checked')){
                $.each($('#markersRepository').data(), function(key, value) {
                    // alert(key + ': ' + value);
                    var val = value.plz;
                    if ($.inArray(val,data)< 0){
                        data.push(val);
                    }

                });
                data = $('#tmp').data('plz',data);
                data = $.toJSON($('#tmp').data('plz'));
            }
                        
            $('#pastedata').val(data);
            data = [];
            $('#tmp').removeData();
        }
    });
    
    $('#sucheFreieTafeln').bind('click', sucheFreieTafeln);
    //$('#monatskalender').fullCalendar( 'render' );
                
    
    
                
    //    temp $('#tabs').tabs( "option", "disabled", [3]);
    $('#kalenderplanung').tabs({
        show: function(){
            $('#timeResultsTable').dataTable().fnDraw();
            $('#monatskalender').fullCalendar( 'render' );
            timeResultsTable.fnDraw();
        }
    });
    $( ".tabs-bottom .ui-tabs-nav, .tabs-bottom .ui-tabs-nav > *" )
    .removeClass( "ui-corner-all ui-corner-top" )
    .addClass( "ui-corner-bottom" );
    
    $("#startadresse").autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function(request, response) {
            geocoder.geocode( {
                'address': request.term , 
                'region':'de', 
                'language':'de'
            }, function(results, status) {
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
            geocoder.geocode( {
                'address': request.term , 
                'region':'de', 
                'language':'de'
            }, function(results, status) {
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
    
    $('#suche_route').live('click',function(){
        calcRoute()
    });
    $('#reset_route').live('click',function(){
        
        $('#directions_panel, #zwischenstopliste').html('');
        $('#startadresse,#zieladresse, #zwischenstop').val('');
        clearBoxes();
        $().message('Route entfernt.');
    });
    
    $( "#bestandssuche" ).autocomplete({
        autoFocus: true,
        source: 'api_2.php',
        minLength: 3,
        delay: 600,
        select: function( event, ui ) {
            // console.log($.param(ui.item));
            apiRequest('bestandssuche', ui.item);
        }
    });
    $( "#bestandssuche" ).autocomplete( "option" , {
        source: 'api_2.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()
    });
    
    $( "#nachPLZ" ).autocomplete({
        autoFocus: true,
        source: 'api_2.php?command=getplzlist',
        minLength: 2,
        delay: 600,
        select: function( event, ui ) {
            // console.log($.param(ui.item));
            apiRequest('plzsuche', ui.item);
        }
    });
    $( "#nachOKZf" ).autocomplete({
        autoFocus: true,
        source: 'api_2.php?command=getokzflist',
        minLength: 3,
        delay: 600,
        select: function( event, ui ) {
            // console.log($.param(ui.item));
            apiRequest('gkzfsuche', ui.item);
        }
    });

    //$('#loaderProgressBar').progressbar('value', 80);
    
    
    //$('.vtip').
    var buttonhelpright = {
        position: {
            my: 'right top', 
            at: 'left center',
            viewport: $(window)
        },  
        style: {
            tip: true,
            classes: 'ui-tooltip-cluetip ui-tooltip-shadow',
            widget: true,
            width: 200
        }
    };
    //    $.each($('.vtip').not($('#pricezoom, #umkreis, #clusterzoom, #gfkzoom, #gdmcopyrightlogo')),function(){
    $.each($('.vtip, .ui-layout-toggler'),function(){
        $(this).qtip( $.extend({}, buttonhelpright, { 
            content: {
                text: $(this).attr('title')
            }
        }))
    });
    //    var buttonhelpleft = {
    //        position: {
    //            my: 'center left', 
    //            at: 'right center',
    //            viewport: $(window)
    //        },  
    //        style: {
    //            tip: true,
    //            classes: 'ui-tooltip-jtools',
    //            widget: true
    //        }
    //    };
    //    $.each($('#pricezoom, #umkreis, #clusterzoom, #gfkzoom, .ui-layout-toggler'),function(){
    //        $(this).qtip( $.extend({}, buttonhelpleft, { 
    //            content: {
    //                text: $(this).attr('title')
    //            }
    //        }))
    //    });
    
    var copyrights= '<img src="gdmlogo01.png" style="float: left; border: 0px;"/><h1>GDM - GeoDataMapper</h1>Version 0.8b <br/>&copy; 2013 Markus Christian Koch<br/>< emcekah@gmail.com ><br/>Lizensiert f&uuml;r <br/>http://joean-doe-media.de<br/><a href="http://cm.inextsolutions.net/wordpress/?page_id=198" target="gdminfo">Info &amp; Dokumentation</a>';    
    var copyrightshelp = {
        position: {
            my: 'bottom right', 
            at: 'left center'
        },  
        style: {
            tip: true
        }
    };
    $('#gdmcopyrightlogo, #gdmcopyrightlogostart').qtip( $.extend({}, copyrightshelp, { 
        content: {
            text: copyrights
        },
        style: {
            classes: 'ui-tooltip-light ui-tooltip-shadow',
            widget: true,
            width: 190
        },
        hide: {
            delay: 5000
        }
    }));
    
    
    //$('#pricezoom, #umkreis, #clusterzoom').qtip('option', 'options.position', {
    //            my: 'top left', 
    //            at: 'bottom center'
    //        });
    
                
    
    $('#suchdialog').dialog({
        resizable: false, 
        draggable: true,
        closeOnEscape:false, 
        position:[100, 35],
        minHeight: 50, 
        maxHeight: 50,
        minWidth: 520,
        maxWidth: 680,
        beforeClose: function(){
            return false;
        }
    })
    .dialogExtend({
        "maximize" : false,
        "minimize" : false,
        "dblclick" : false,
        "titlebar" : 'none'
        
    });
    $('#suchdialog').dialog('option','position','right top');
    $( "#suchdialog" ).dialog( "option", "dialogClass", "opaque");
    
    
    $('#mapoptions').dialog({
        draggable: true,
        resizable:false,
        width: 230,
        minHeight: 50,
        maxHeight: 50,
        position: [200,0],
        closeOnEscape: false,
        beforeClose: function(){
            return false;
        }
    })
    .dialogExtend({
        "maximize" : false,
        "minimize" : false,
        "dblclick" : false,
        "titlebar" : 'none'
        
    });
    $( "#mapoptions" ).dialog( "option", "dialogClass", "opaque");
    
    //    
    //    $('#suchdialog, #mapoptions').css({
    //        "opacity":"0.91"
    //    });
    
    
    $('#tabsouter').dialog({
        draggable: true,
        resizable:true,
        closeOnEscape: false,
        minWidth: 520,
        minHeight: 440,
        position: 'center',
        beforeClose: function(){
            return false;
        },
        resize: function(){
            updateTaggedRepositoryTable();
            updateRepositoryTable();
            timeResultsTable.fnDraw();
        // $(this).data('jsp').reinitialise();
        }

    })
    .dialogExtend({
        "maximize" : false,
        "minimize" : false, 
        "dblclick" : "collapse",
        "titlebar" : "transparent",
        "events": {
            "restore": function(){
                updateTaggedRepositoryTable();
                updateRepositoryTable();
                timeResultsTable.fnDraw();
                $('#tablesVisible').removeAttr('checked').toggleClass('ui-state-active');
                $('#tablesVisibleLabel').toggleClass('ui-state-active');
            },
            "maximize": function(){
                updateTaggedRepositoryTable();
                updateRepositoryTable();
                timeResultsTable.fnDraw();
            },
            "minimize": function(){
                $('#tablesVisible').attr('checked', 'checked');
                $('#tablesVisibleLabel').toggleClass('ui-state-active');
            },
            "collapse": function(){
                $('#tablesVisible').attr('checked', 'checked');
                $('#tablesVisibleLabel').toggleClass('ui-state-active');
            }
        },
        "icons" : {
            "maximize" : "ui-icon-circle-plus",
            "minimize" : "ui-icon-circle-minus",
            "restore" : "ui-icon-bullet"
        }
    });
    $('#tabsouter').dialog('option','position','right center');
    // $( "#tabsouter" ).dialog( "option", "dialogClass", "opaque");
    // $('#tabsouter').dialog('widget').position({my:'top center',at:'bottom center',of:$('#suchdialog'), offset: '0'});
    // appLayout.hide('east');
    
    $('#tablesVisible').bind('click', function(){
        if($(this).is(':checked')){
            $("#tabsouter").dialogExtend("minimize");
        } else {
            $("#tabsouter").dialogExtend("restore");
        }
    });
    
    $('#showGeoVa').bind('click', function(){
        $.colorbox({
            title: '<h3>mehr Informationen: info@joean-doe-media.de</h3>',
            href: 'geovainfo.php',
            opacity: 0.6,
            width: '100%',
            height: '100%',
            close: '<span class="button">< Zurück zur Karte ></span>',
            onComplete: function(){
                $.colorbox('resize');
                $('.button').button();
            }
        });      
    });
    
    $('#clusterzoom,#pricezoom,#umkreis,#gfkzoom').css({
        'position':'absolute',
        'left':'3px', 
        'top':'100px',
        'margin':'1px'
    });
    $('#pricezoom').css({
        'left':'3x',
        'top':'230px'
    });
    $('#gfkzoom').css({
        'left':'18px',
        'top':'230px'
    });
    $('#umkreis').css({
        'left':'18px'
    });
    
    $('#zoomerbackground').css({
        'position':'absolute',
        'top':'95px',
        'left':'-1px',
        'z-index':'999',
        'opacity':'.9'
    });
    //$('#kalenderplanung').tabs('select',0);
    // $('#suchdialog').dialog();
    // $('#suchdialog').draggable();
    $('.gdmhelp').live('click', function(){
        try{
            appLayout.open('east');
        } catch (e) {}
        try{
            $("#tabsouter").dialogExtend("minimize");
        }
        catch (e) {}
    });
    
    // $('#maindialog').load('/werbetraeger-formate.html .content_right');
    $('#maindialog_center_scroller').load('/api/images/slides/frontslides.php',
        function(){
        //            $("#slides").slides({
        //                preload: true,
        //                play: 5000,
        //                crossfade: true,
        //                effect: 'slide',
        //                generateNextPrev: false,
        //                generatePagination: false
        //            });
        //            $('#maindialog_center').jScrollPane({
        //                showArrows: true
        //            });
        });
      
    //$('#maindialog').load('/_ng/index.php?option=com_fsf&view=faq .contentarea');
    $('#maindialog a').live('click', function(){
        $('#maindialog_center_scroller').load($(this).attr('href')+' .contentarea', function(){
            $('#maindialog_center').jScrollPane({
                showArrows: true
            });
        });
        
        return false;
    });
        
        
    mainDialogLayout = $('#maindialog').layout({
        applyDefaultStyles: true,
        south: {
            initClosed: false, 
            size: 55,
            resizable: false,
            closable: false
        }
    });
    // DialogLayout.allowOverflow('center');    
        
    $('#graphicscontainer').dialog({
        autoOpen: true,
        closeOnEscape: false,
        height: 240,
        width: 400,
        title: '',
        resizable: false,
        position: [100,100],
        beforeClose: function(){
            return false;
        }
    })
    .dialogExtend({
        "maximize" : false,
        "minimize" : false,
        "dblclick" : false,
        "titlebar" : 'none'
    });
                
    $('#showStats').bind('click', function(){
        if ($(this).is(':checked')){
            $('#graphicscontainer').dialogExtend('minimize');   
                        
        } else {
            $('#graphicscontainer').dialogExtend('restore');
            google.maps.event.trigger(map, 'bounds_changed');
        }
    });
    
    //$('#angebotDrucken').live('click', angebotDrucken());
    
    // graphicsdialog.hide();
    $('#graphicscontainer').dialogExtend('minimize');
                


    $("#tabsouter").dialogExtend("minimize");
    
    //    $('#total_counter_graphics').position({
    //        my:'left center',
    //        at:'left center',
    //        of:$('#lensmapcontainer'), 
    //        offset: '25px'
    //    }).draggable();
    //    $('#graphics').position({
    //        my:'left',
    //        at:'right',
    //        of:$('#total_counter_graphics'), 
    //        offset: '0'
    //    }).draggable();
    //                
    $('#lensmapcontainer').draggable();
    $('#loader p').html('Lade Karten...');
                
    $('#loaderProgressBar').progressbar('value', 50);
    
    /*try {
        $.each($('#checkOutForm #kontaktdaten input'), function(){
            var test;
            if (test = $.Storage.get($(this).attr('name'))){ 
                // console.log(test);
                $(this).val(test);
            }
        });
    } catch (e) {} */
    
    if(GET('repository')!=1){
        try {
            if ($.evalJSON($.Storage.get('tagged')).length > 0){
                loadTaggedToMap();
                //$('#loader p').html('<div class="ui-state-highlight"> '+$.evalJSON($.Storage.get('tagged')).length+' markierte Tafeln aus voriger Sitzung geladen.</div>');
                $().message(' '+$.evalJSON($.Storage.get('tagged')).length+' markierte Tafeln aus voriger Sitzung geladen.');
            //$().message("Hello world!");
            }
        }
        catch(e) {
            //console.log(e);
            $.Storage.set('tagged', '[]');
        }
    }
    if(GET('merkliste')!=1){
        try {
            if ($.evalJSON($.Storage.get('lastrepository')).length > 0){
                loadLastRepositoryToMap();
                //function(){$('#loaderProgressBar').progressbar('value', 80);}
                
                //$('#loader p').append('<div class="ui-state-highlight"> '+$.evalJSON($.Storage.get('lastrepository')).length+' markierte Tafeln aus Zwischenablage geladen.</div>');
                $().message(' '+$.evalJSON($.Storage.get('tagged')).length+' markierte Tafeln aus voriger Sitzung geladen.');
            //map.fitBounds(getClustererBounds(markerClusterer));  
            }
        } catch(e) {
            //console.log(e);
            $.Storage.set('lastrepository', '[]');
        }
        
        try {
            if ($.evalJSON($.Storage.get('termine')).length > 0){
                IDLIST = $.evalJSON($.Storage.get('termine'));
            }
        } catch(e) {
            //console.log(e);
            $.Storage.set('termine', '[]');
        }
        
    }
    
    //$('#loaderProgressBar').delay(1500).progressbar('value', 90);
    if (GET('update')!=1){
        $('#taggedReload').hide();
    }
    //    if(GET('dialog')==1){
    //        $('#suchdialog').dialog();
    //            
    //    }
    
    if(GET('eastshow')!=1){
        //appLayout.close('east');
        appLayout.hide('east');
    } 
    
    if(GET('showgraphics')!=1){
        appLayout.hide('south');
        
    }
    
    if (GET('nosearch')==1){
        if(!GET('dialog')==1){
            centermarker.setMap();
            circle.setMap();
            $('#suchdialog').hide();
        }
    }
    
    $('#tabs').tabs('select',1);
    if(GET('nodialog')!=1){
        $('#suchdialog').show();
        $('#suchdialog').dialog();
        $( "#suchdialog" ).dialog( "option", "minHeight", 0 );
        $( "#suchdialog" ).dialog( "option", "minWidth", 0 );
        if (GET('dialogposition')=='top'){
            ///var position = GET('dialogposition');
            $( "#suchdialog" ).dialog( "option", "position", [45, 8] );
        }
        else {
            $( "#suchdialog" ).dialog( "option", "position", ['center'] );
        }
        // $( "#suchdialog" ).dialog( "option", "position", [45, 8] );
        
        
        $( "#suchdialog" ).dialog( "option", "dialogClass", "opaque");
        
        
    }
    
    if(GET('intro')!=1) {
        
        $('#loader').delay(9000).hide('fade',4800);
    //$('#loaderProgressBar').progressbar('value', 90);
    }
    else $('#loader').hide('fade',4800) ;                
                
    repositoryTable.fnDraw();
                
});
