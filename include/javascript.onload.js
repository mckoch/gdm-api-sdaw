/*!
 * GeoDataMapper V0.5 public 
 * Interface Script
 * 
 * version 12/2011
 * licensed for http://joean-doe-media.de
 * copyright Markus C. Koch < emcekah@gmail.com >
 * 
 */

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
                    weekHeader: 'Wo',
                    dateFormat: 'dd.mm.yy',
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''};
                $.datepicker.setDefaults($.datepicker.regional['de']);
            });     





            
            var appLayout;
            var map;
            var geocoder;
            var mapcenter;
            var centermarker;
            var circle;
            var markerimage;
            var pb;
            var pservice;
            var umkreis = 500;
            var mapOptions;
            var gfkrange = [0,300];
            var pricerange =[0,10000];
            
            var markerClusterer;
            var markerPlacesClusterer;
            var clusterzoom = 17;
            var visibleMarkers = new Array();
            
            var repositoryTable;
            var taggedRepositoryTable;
            var checkOuts = 0;
            
            var infoBubble;
            var infowindow;
            
            var sv;
            var svdisplay;
            var svpos;
            
            var rightclickimage;
            var rightclickmarker;
            
            var myLocalStorage = new Array();
            
            
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

                
            function redrawMap(){google.maps.event.trigger(map, 'resize');$('#map-side-bar-container').jScrollPane({showArrows: true});}
            
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
                    if (infoBubble.isOpen()==true){infoBubble.setMap(null);};
                    showInfoBubble(marker,data);
                });
            }
            
            function showInfoBubble(marker,data){
                // clearInstanceListeners(marker);
                mypos = marker.getPosition();
                infoBubble = new InfoBubble({
                    minWidth: 240,
                    maxWidth: 240,
                    minHeight: 240,
                    maxHeight: 420,
                    content: data.label,
                    draggable: true,
                    shadowStyle: 1,
                    arrowStyle: 2,
                    arrowSize: 12,
                    arrowPosition: 50,
                    position: mypos,
                    disableAutoPan: false
                });
                infoBubbleTab1 = '<a class="lightbox" href="img/800x600/'+data.id+'.jpg" onclick="$.colorbox({href: this.href, opacity: 0.65, maxWidth:\'100%\', maxHeight:\'100%\', title: \''+data.description +'\', close: \'Schließen\'});return false;"><img src="img/240x240/'+data.id+'.png"/></a><div class="ui-widget">'
                    +data.description +'<br/> '+data.stellenart + ' ' + data.beleuchtung + ' ' + data.leistungswert1 + ' '
                    +data.preis/100 + "</div>"
                    + "<div class='ui-widget infobubble'><a class='ui-widget ui-widget-content ui-corner-all ui-hover' onclick='cartAdd("+data.id+")'>auf Merkliste setzen</a>||"
                    + "<a class='ui-widget ui-widget-content ui-corner-all ui-hover' onclick='cartRemove("+data.id+")'>von Merkliste entfernen</a></div>";
                infoBubble.addTab(data.id, infoBubbleTab1);
                
                
                if( svdisplay.getVisible() == true){
                    
                    svpos = marker.getPosition();
                    map.setCenter(svpos);
                    svdisplay.setPosition(svpos);
                    infoBubble.open(svdisplay, marker);
                    
                } else  {infoBubble.open(map,marker);}
                // };
                
            }
            
            function getPlacesByRadius(umkreis, latlng){
                // var bounds = map.getBounds();
                var placestypes = placesfilter();
                // console.log(placestypes);
                var request = {radius: umkreis,types: placestypes,location: latlng };
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
            };
            
            function showContextMenu(currentLatLng  ) {
                var contextmenuDir;
                rightclickmarker.setPosition(currentLatLng);// 
                rightclickmarker.setMap(map);
                mapcenter = currentLatLng;
                $('.contextmenu').remove();
                contextmenuDir = document.createElement("div");
                contextmenuDir.className  = 'contextmenu ui-widget ui-widget-content ui-corner-all';
                contextmenuDir.innerHTML = "<a id='mapcontextmenu2' class='ui-hover' onclick='setCenterMarker(mapcenter)'><div class=context>Hier zentrieren</div></a>";
                $(map.getDiv()).append(contextmenuDir);
                setMenuXY(currentLatLng);
                contextmenuDir.style.visibility = "visible";
            }
            
            function showMarkerContextMenu(currentLatLng, markerid) {
                // console.log(markerid);
                var contextmenuDir;
                $('.contextmenu').remove();
                contextmenuDir = document.createElement("div");
                contextmenuDir.className  = 'contextmenu ui-widget ui-widget-content ui-corner-all';
                contextmenuDir.innerHTML = "#"+markerid+"<br /><a id='markercontextmenu2' class='ui-hover' onclick='cartAdd("+markerid+")'><div class=context>auf Merkliste</div></a>"
                    + "<a id='markercontextmenu3' class='ui-hover' onclick='cartRemove("+markerid+")'><div class=context>Von Merkliste entfernen</div></a>";
                $(map.getDiv()).append(contextmenuDir);
                setMenuXY(currentLatLng);
                contextmenuDir.style.visibility = "visible";
            }
            
            function cartAdd(markerid){
                // console.log(markerid+' cartAdd');
                $('.contextmenu').remove();
                tagged = $.evalJSON($.Storage.get('tagged'));
                $('#tabs').tabs('select',2);
                
                $.each(markerClusterer.getMarkers(), function(){
                    if (this.get('markerData').id== markerid)
                    {
                        if(this.get('tagged')!= 'tagged'){
                            this.set('tagged', 'tagged');
                            markerimage = new google.maps.MarkerImage('images/mapicons/database.png');
                            this.setIcon(markerimage);
                            if(!tagged){tagged = new Array()};
                            tagged.push({'id': markerid});
                            // console.log(markerid + ' tagged.');
                            $.Storage.set('tagged', $.toJSON(tagged));
                            updateTaggedRepositoryTable();
                        }
                    }
                });
            }
            function cartRemove(markerid){
                // console.log(markerid+' cartRemove');
                // tagged = new Array();
                tagged = $.evalJSON($.Storage.get('tagged'));
                $('#tabs').tabs('select',2);
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
                                };
                            }
                        );
                            // console.log(markerid + ' untagged.');
                            $.Storage.set('tagged', $.toJSON(tagged));
                            updateTaggedRepositoryTable();
                        }
                    }
                });
                
                $('.contextmenu').remove();
            }
            
            function clearTaggedMarkers(){
                $.Storage.set('tagged', '[]');
                tagged = new Array();
                $.each(markerClusterer.getMarkers(), function(){   
                    if(this.get('tagged')== 'tagged'){
                        this.set('tagged', 'untagged');
                        //  retrieve old marker image!!!
                        var markerimage = new google.maps.MarkerImage(this.get('oimage'));
                        this.setIcon(markerimage);
                    }
                });
                updateTaggedRepositoryTable();
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
                // createQuickGraph();
                $('#markersRepository').removeData();
                repositoryTable.fnClearTable();
                $('#placesRepository').removeData();
                
                $('#markercounter').val(markerClusterer.getTotalMarkers());
                $('#visibleMarkersCounter').button( "option", "label", "0");
                $('#address').val('');
                infoBubble.close();
                //                 $('#tree-control').dynatree('getTree').getNodeByKey('search-history') .removeChildren();
                //                 $('#tree-control').dynatree('getTree').getNodeByKey('details-history') .removeChildren();
                //                 $('#tree-control').dynatree('getTree').getNodeByKey('places') .removeChildren();
            }
            
            function updateRepositoryTable() {
                    
                mapcenter = map.getCenter();
                allmarkers = markerClusterer.getMarkers();
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
                        };
                    });
                        
                } else {
                    $.each(markerClusterer.getMarkers(),function(index, marker){
                        if (map.getBounds().contains(marker.getPosition())){
                            visibleMarkers.push(marker);
                            
                        };
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
                    
                };
                
                repositoryTable.fnDraw();
                taggedRepositoryTable.fnDraw();
                // console.log('visible: ' + visibleMarkers.length);
                $('#visibleMarkersCounter').button( "option", "label", visibleMarkers.length);
                $('.dataTables_filter input').clearField() .button();
                    
            }
            
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
                tagged = $.evalJSON($.Storage.get('tagged'));
                $('#pastedata').val($.Storage.get('tagged'));
                $('#submitpastedata').trigger('click');
                
            }
            
            function taggedCheckOut(){
                
                // console.log('CheckOut started.');
                try{
                    if(!$.Storage.get('tagged')>0){{
                            // console.log('No tagged - no checkout.');
                            return false;
                        }} else {
                        $.each($('#checkOutForm #kontaktdaten input'), function(){
                            var test;
                            if (test = $.Storage.get($(this).attr('name'))){ 
                                // console.log(test);
                                $(this).val(test);}
                        });
                
                        markerClusterer.clearMarkers();
                        $('#markersRepository').removeData();
                        $('#suchdialog').hide();
                        loadTaggedToMap();
                        $('#taggedtmp').val($.Storage.get('tagged'));
                
                        $('#tabs').tabs('option','disabled',[0,1]);
                        $('#tabs').tabs('select',3);
                        $('#headermessage').html('<h2 class="ui-widget ui-widget-content ui-widget-header">Tafeln anfragen</h2>'); 
                    }
                } catch (e) {
                   // console.log(e);
                }
                
                
            }
            
            function updateTaggedRepositoryTable(){
                taggedRepositoryTable.fnClearTable();
                var id;
                var tdata;
                 
                $.each($.evalJSON($.Storage.get('tagged')), function(index, data){
                    id = String(data.id);
                    // console.log('ID: '+ id);
                    tdata = $('#taggedRepository').data(id);
                    // console.log('tdata: '+tdata);
                    tdata;
                    // console.log('from #taggedRepository: ' + id);
                    if (tdata)
                    {taggedRepositoryTable.fnAddData( [
                        
                            tdata.id,
                            tdata.label,
                            '<img src="img/240x240/'+data.id+'.png"/>&nbsp;'+tdata.description,  
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
                        ], false );}
                });
                $('#taggedtmp').val($.Storage.get('tagged'));
                taggedRepositoryTable.fnDraw();
            }
            
            function doTheCheckoutSubmit(){
                lng = $('#checkOutForm').serialize();
                
                $.ajax({
                    type: 'POST',
                    url: 'api.php?command=checkout',
                    data: lng,
                    success: checkoutSubmitCallback,
                    dataType: 'html'
                });
            }
            
            function checkoutSubmitCallback(data){
               
                // alert(data);
                checkOuts++;
                // $('#alreadyCheckedOut').prepend(' '+ checkOuts + data);
                $('#alreadyCheckedOut').html('<span class=" ui-icon fff-icon-tick" style="float:right"></span>'+ data + '<hr/>');
                $.each($('input.datum'), function(){
                    $(this).val($(this).attr('title'));
                });
                $('#checkOutForm').valid();
                alert('Ihre Anfrage '+ checkOuts + ' wurde erfolgreich übermittelt.');
            }
            
            
            
            function checkoutCancel(){
                $('#suchdialog').show();
                // console.log('CheckOut canceled.');
                $('#tabs').tabs('option','disabled',[]);
                
                $('#tabs').tabs('select',2);
                $('#tabs').tabs('option','disabled',[3]);
                $('#headermessage').html('<h2 class="ui-widget ui-widget-content ui-widget-header">Werbetafeln suchen & auswählen</h2>');
                
            }



            
            function apiRequest(lat,lng){
                // console.log(lat + ' ' + lng);
                if(infoBubble.isOpen()){
                    infoBubble.close();
                };
        
                if (lat == 'init'){
                    var api = 'api.php?command=5';
                    // var latlng = mapcenter;
                } else if(lat=='bestandssuche'){
                    var api='api.php?command=2&'+ $.param(lng)+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                    // console.log(api);
                    if (lng.latitude >0 && lng.longitude > 0) {
                        mapcenter = new google.maps.LatLng(lng.latitude, lng.longitude);
                        // console.log(mapcenter);
                    } else {
                        geocoder.geocode( { 'address': lng.label}, function(results, status) {
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
                    var api = 'api.php?command=6&bounds='+lng.toUrlValue()+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                } else if (lat == 'polygon'){
                    // Zeichenkette der Form "lat_lo,lng_lo,lat_hi,lng_hi"
                    // var api = 'api.php?command=7&bounds='+lng.toUrlValue(); 
                    var api = 'api.php?command=7&bounds=' + encodeURI($.toJSON(lng))+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
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

                    var api = 'api.php?command=8&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                    // alert (api+lng);
                    // $.post(api,lng,apiCallBack);
                    $.ajax({
                        type: 'POST',
                        url: api,
                        data: lng,
                        success: apiCallBack,
                        dataType: 'json'
                    });
                    if ($('#drawplz').is(':checked')){
                        $.getJSON('api.php?command=graphics&'+lng, function(data){
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
                    };
                    return;
                } else {
                    var api = 'api.php?command=4&latitude='+lat+'&longitude='+lng+'&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                    mapcenter = new google.maps.LatLng(lat,lng);
                }
                
                $.getJSON(api, apiCallBack);
                if (lat!= 'polygon' && lat!='bounds'){
                    // map.panTo(mapcenter);
                    centermarker.setPosition(mapcenter);
                    centermarker.setMap(map);
                    circle.setRadius(umkreis);
                    circle.setCenter(mapcenter);
                    map.fitBounds(circle.getBounds());
                    if (svdisplay.getVisible() == true){
                        // svpos = marker.getPosition();
                        // console.log('SV DISPLAY VISIBLE.');
                        svdisplay.setPosition(mapcenter);
                    };
                }
                $('#taggedtmp').val($.Storage.get('tagged'));
                function apiCallBack(data){
                    pb.hide();
                    var markers= [];
                    var maxNum = data.length;
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
                    };

                    if(!$('#append').is(':checked')){
                        // alert ('no append!');
                        if (markerClusterer) {markerClusterer.clearMarkers();};
                        $('#markersRepository').removeData();
                        repositoryTable.fnClearTable();
                        if(markerPlacesClusterer){markerPlacesClusterer.clearMarkers();};
                        // $('#tree-control').dynatree('getTree').getNodeByKey('search-history') .removeChildren();
                    };
                    
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
                            // tagged = $.evalJSON($.Storage.get('tagged'));
                            if (tagged){
                                $.each(tagged, function(){
                                    if (this.id == data[i].id){
                                        // console.log('tagged new marker');
                                        marker.set('tagged', 'tagged');
                                        markerimage = new google.maps.MarkerImage('images/mapicons/database.png');
                                        marker.setIcon(markerimage);
                                    };
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
                    setTimeout('pb.hide()',5000);
                    // repositoryTable.fnDraw();
                    updateRepositoryTable();
                    // createQuickGraph();

                    if($('#applyplaces').is(':checked')){
                        // alert('finding places now');
                        getPlacesByRadius(umkreis, map.getCenter());
                    };
                }
            }
            //  Ende API request +  callback

            
            $(document).ready(function(){
                $('#loader p').html('Initialisiere Komponenten...'); 
               
                tagged = $.evalJSON($.Storage.get('tagged'));
               
                geocoder = new google.maps.Geocoder();
                mapcenter = new google.maps.LatLng(50.81653901380063,9.049583493750042);
                
                mapOptions = {

                    mapTypeId: google.maps.MapTypeId.HYBRID,
                    zoom: 6,
                    center: mapcenter,
                    mapTypeControl: true,
                    backgroundColor: '#ffffff',
                    mapTypeControlOptions: {
                        scaleControl: true,
                        scaleControlOptions: {
                            position: google.maps.ControlPosition.BOTTOM_LEFT
                        },
                    
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
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
                circle.bindTo('center', centermarker, 'position');
                google.maps.event.addListener(centermarker, 'dragend', function() {
                    mapcenter = centermarker.getPosition();
                    geocoder.geocode( {'latLng': mapcenter},
                    function(results, status) {
                        $('#address').val(results[0].formatted_address);
                    });
                });
                google.maps.event.addListener(centermarker,'dblclick', function(){
                    $('#tabs').tabs('select',1);
                    apiRequest(mapcenter.lat(), mapcenter.lng());
                });
                circle.setRadius(umkreis);
                
                rightclickimage = new google.maps.MarkerImage('images/mapicons/point_of_interest.png');
                rightclickmarker = new google.maps.Marker({
                    draggable: false,
                    title: '',
                    icon: rightclickimage
                });
                
                
                infoBubble = new InfoBubble();
                // infowindow = new google.maps.InfoWindow();

                $('#tabs').tabs();
                
                appLayout = $('body').layout({
                    applyDefaultStyles: true,
                    east: {initClosed: false, size: 460, onopen_end: redrawMap, onclose_end: redrawMap, onresize_end: redrawMap},
                    south: {initClosed: true, size: 190, onopen_end: redrawMap, onclose_end: redrawMap, onresize_end: redrawMap},
                    west: {initClosed: true, size: 480, onopen_end: redrawMap, onclose_end: redrawMap, onresize_end: redrawMap},
                    north: {initClosed: true, size: 52, onopen_end: redrawMap, onclose_end: redrawMap, onresize_end: redrawMap}
                });
                appLayout.allowOverflow('center'); 
                $.loading.classname = 'loading';
                $.loading({onAjax:true, text: 'Lade vom Server...', pulse: 'working fade', mask:true,max: 3000});
                                
                $("#address").autocomplete({
                    source: function(request, response) {
                        geocoder.geocode( {'address': request.term , 'region':'DE', 'language':'de'},
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
                            apiRequest(lat, lng);
                        } else {
                            
                            centermarker.setPosition(mapcenter);
                            centermarker.setMap(map);
                            circle.setCenter(mapcenter);
                            map.panTo(mapcenter);
                        };
                        $('#tabs').tabs('select',1);
                    }
                });
                $('#address, .clearfield') .clearField() .button();
                $('.button, #append, #applyplaces, #addressUmkreisSuche, .datum').button();
                $( "#formtoolsdatatype, .buttonset" ).buttonset();
                $.datepicker.setDefaults($.datepicker.regional['de']);
                $( ".datum" ).datepicker({onClose: function (){$('#checkOutForm').valid();}});
                
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
                
                google.maps.event.addListener(map, 'bounds_changed', updateRepositoryTable);
                google.maps.event.addListener(map, "rightclick",function(event){showContextMenu(event.latLng);});
                google.maps.event.addListener(map, "click", function(event) {
                    $('.contextmenu').remove();
                    rightclickmarker.setMap(null);
                    if(infoBubble.isOpen()){
                        infoBubble.close();
                    };
                });


                
                $( "#umkreis" ).slider({
                    orientation: "horizontal",
                    range: "min",
                    value: umkreis,
                    min: 10,
                    max: 5000,
                    step: 10,
                    animate: true,
                    slide: function( event, ui ) {
                        centermarker.setPosition(mapcenter);
                        umkreis = ui.value;
                        $( "#zoom" ).val( umkreis +'m' );
                        circle.setRadius(umkreis);
                    },
                    stop: function( event, ui ) {
                        centermarker.setPosition(mapcenter);
                        umkreis = ui.value;
                        $( "#zoom" ).val( umkreis +'m' );
                        circle.setRadius(umkreis);
                        map.fitBounds(circle.getBounds());
                    }
                });
                $( "#zoom" ).val( umkreis +'m' );
                $('#zoom').live('click', function(){
                    $('#tabs').tabs('select',1);
                    apiRequest(mapcenter.lat(), mapcenter.lng());
                });
                $('form select optgroup option ').tsort();
                $("form#extendedfilter select, form#Stellenartenfilter select, form#Unterstellenartenfilter select, form#Placesfilter select").multiselect({
                    position: {
                        my: 'top',
                        at: 'bottom'
                    }, 
                    header: false, minWidth: 'auto', height: '180', selectedList: 10, selectedText: '# / #', 
                    show: ['slide', 500], open: function(){
                        $('.ui-multiselect-checkboxes') .jScrollPane({showArrows: true});}
                });
                
                $.each($('#Placesfilter .ui-multiselect-checkboxes label'),function(){
                    $(this).append('<img style="float:left; height: 12px;" src="images/mapicons/'+$('input', this).val()+'.png"/>');
                });
                
                $("form#extendedfilter select, form#Stellenartenfilter select, form#Unterstellenartenfilter select, form#Placesfilter select").multiselect('close');
                $('#Unterstellenartenfilter select').multiselect('checkAll');
                $('#Unterstellenartenfilter').hide();
                
                repositoryTable = $('#repositoryTable').dataTable({
                    "oLanguage": dataTableLanguage,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "aLengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
                    "aoColumnDefs": [ 
                        { "bSearchable": true, "bVisible": false, "aTargets": [ 1 ] },
                        {  "bSearchable": false, "bVisible": false, "aTargets": [ 8,9,10,11,12 ] }
                    ],
                    // "sScrollY": "200px",
                    "bPaginate": false,
                    "sDom": '<"top"fi>t',
                    "fnDrawCallback": function() {
                        
                        $('#map-side-bar-container').jScrollPane({showArrows: true});                        
                    }
                });
                taggedRepositoryTable = $('#taggedRepositoryTable').dataTable({
                    "oLanguage": dataTableLanguage,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "aLengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
                    "aoColumnDefs": [ 
                        { "bSearchable": true, "bVisible": false, "aTargets": [ 1 ] },
                        {  "bSearchable": false, "bVisible": false, "aTargets": [ 8,9,10,11,12 ] }
                    ],
                    // "sScrollY": "200px",
                    "bPaginate": false,
                    "sDom": 't',
                    "fnDrawCallback": function() {
                        
                        $('#merkzetteltableouter').jScrollPane({showArrows: true});                        
                    }
                });
                
                $('#repositoryTable tbody tr, #taggedRepositoryTable tbody tr').live('click', function () {
                    var nTds = $('td', this);
                    $.each(markerClusterer.getMarkers(), function(index, marker){
                        if ($(nTds[0]).text()==marker.markerData['id']){
                            //  map.panTo(marker.getPosition());
                            mapcenter = marker.getPosition();
                            google.maps.event.trigger(marker, 'click');
                            // centermarker.setPosition(marker.getPosition());
                            
                        };
                    });
                    $(repositoryTable.fnSettings().aoData).each(function (){
                        $(this.nTr).removeClass('ui-state-highlight');
                    });
                    $(taggedRepositoryTable.fnSettings().aoData).each(function (){
                        $(this.nTr).removeClass('ui-state-highlight');
                    });
                    $(this).addClass('ui-state-highlight');
                });
                
                $('#checkOutForm').validate(
                {

                    submitHandler: function(form) {
                        doTheCheckoutSubmit();
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
                        },
                        Startdatum: {
                            dateNL: true,
                            required: true
                        },
                        Enddatum: {
                            dateNL: true,
                            required: true
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
                        },
                        Startdatum: {
                            required: "Startdatum auswählen.",
                            dateNL: "Startdatum auswählen."
                        },
                        Enddatum: {
                            required:  "Enddatum auswählen.",
                            dateNL: "Enddatum auswählen."
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
                    
                    $.each($('#checkOutForm #kontaktdaten input'), function(){
                        $.Storage.set($(this).attr('name'),$(this).val()); 
                    });
                    
                });
                
                
                // $('#tabs').tabs();
                $('#tabs').bind('tabsshow', updateRepositoryTable);
                $('#tabs').bind('tabsshow', updateTaggedRepositoryTable);
                // new FixedHeader( repositoryTable );
                $('#Placesfilter').toggle('slow');
                $('#applyplaces').bind('click', function(){
                    $('#RECTPLCS, #Placesfilter').toggle('slow');
                });
                $('#taggedClear').bind('click', function(e){
                    // console.log(e);
                    clearTaggedMarkers();
                });
                
                $('#visibleMarkers').bind('click', function(){
                    // $('#visibleMarkersCounter').button().toggle();
                    google.maps.event.trigger(map, 'bounds_changed');
                });
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
                
                $('#loader p').html('Lade Karten...');
                
                $('#tabs').tabs( "option", "disabled", [3]);
                // $('#suchdialog').dialog();
                // $('#suchdialog').draggable();
                try {
                    if ($.evalJSON($.Storage.get('tagged')).length > 0){
                        loadTaggedToMap();
                        $('#loader p').html('<div class="ui-state-highlight"> '+$.evalJSON($.Storage.get('tagged')).length+' markierte Tafeln aus voriger Sitzung geladen.</div>');
                        // alert (' '+$.evalJSON($.Storage.get('tagged')).length+' markierte Tafeln aus voriger Sitzung geladen.');
                    }
                } catch(e) {
                    // console.log(e);
                }
                $('#loader').delay(9000).hide('fade',1800);
                // apiRequest('postdata', 50667);
                $('#tabs').tabs('select',1);
                
                
                // repositoryTable.fnDraw();
                
            });
