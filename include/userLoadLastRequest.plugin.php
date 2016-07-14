<?php
/**
 * @name userLoadLastRequest.plugin.php
 * @package GDM_joean-doe_media
 * @author mckoch - 16.12.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * GDM_joean-doe_media:userLoadLastRequest
 *
 * 
 */
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    var tagged;
    var umkreis = 500;
    var gfkrange = [0,500];
    var pricerange =[0,100000];
            
    var dataTableLanguage = {
        "sProcessing":   "Bitte warten...",
        "sLengthMenu":   "_MENU_ Flächen anzeigen",
        "sZeroRecords":  "Keine Werbeflächen im Zwischenspeicher.",
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
    
    var dataTable;
    var map;
    var mapcenter;
    var geocoder;
    
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
    function initLoadUserRepository(){
        
        tagged =  $.Storage.get('lastrepository');
        dataTable.fnClearTable();
        $.each($.evalJSON(tagged), function(index, data){
            //console.log(data);
            
            dataTable.fnAddData( [
                        
                data.id,
                data.label,
                data.description,  
                data.plz,
                data.leistungswert1,
                '<img class="marker iconimage" src="/api/images/markers/marker_' + data.stellenart.toLowerCase() +'.png"/>'+ data.stellenart,
                                            
                data.preis/100,
                data.beleuchtung,
                data.standortnr,
                data.belegdauerart,
                data.bauart,
                data.hoehe,
                data.breite
                         
                //this.id,2,3,index,5,6,7,8,9,10,11,12,13
            ], false );
        });
        //$('#taggedtmp').val($.Storage.get('tagged'));
        dataTable.fnDraw();
        $.Storage.set('lastrepository_changed_from_map', 'no changes');
        $.Storage.set('lastrepository_changed_from_site', 'no changes');
    }
    
    function checkIfTagged(id, callback){
        tagged =$.evalJSON($.Storage.get('tagged'));
        //console.log('id: '+id);
        $.each(tagged, function(){
            //console.log('this.id: '+id);
            if(Number(this.id)=== Number(id)) {
                console.log('checkIfTagged: ' + id);
                callback(id);
            } 
            // else return false;
        });
    }    
    
    function apiCallBack(data){
        console.log(data);
        console.log(tagged);
        if(!$('#append').is(':checked')){
            $('#markersRepository').removeData();
            dataTable.fnClearTable();
        };
        var maxNum = data.length;
        for (var i = 0; i < maxNum; ++i) {
            if (!$('#markersRepository').data(data[i].id+'')){
                //                             $('#tree-control').dynatree('getTree') .getNodeByKey(searchnode).addChild({
                //                                 title: data[i].id
                //                             });
                // markertext = data[i].id;

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
                            
                            
                            
                $('#markersRepository').data(data[i].id, markerdata);
                            
                            
                dataTable.fnAddData( [
                    data[i].id,
                    data[i].label,
                    data[i].description,
                    data[i].plz,
                    data[i].leistungswert1,
                    // '<img class="iconimage" src="/api/img/240x240/'+data[i].id+'.jpg"/>'+
                    '<img class="marker iconimage" src="/api/images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png"/>'+ data[i].stellenart,
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
        dataTable.fnDraw();
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
        $.Storage.set('lastrepository_changed_from_site', 'changed');
        
        $('body').scrollTo( $('#repositoryTable'), 1000);
    } 
    //// 
    //EO apiCallBack
          
          
    function loadUserRepositoryToTagged(){
        var sel = $.Storage.get('lastrepository');
        sel = $.evalJSON(sel);
        
        $.each(sel, function(i, data){
            cartAdd(data.id);
        });
        $.Storage.set('tagged', $.toJSON(tagged));
    }
    
    function cartAdd(markerid){                
        tagged.push({
            'id': markerid
        });                    
    }
    
    $(document).ready(function(){
        
        geocoder = new google.maps.Geocoder();
        
        $( "#umkreis" ).slider({
            orientation: "horizontal",
            range: "min",
            value: umkreis,
            min: 10,
            max: 5000,
            step: 10,
            animate: true,
            slide: function( event, ui ) {
                umkreis = ui.value;
                $( "#zoom" ).val( umkreis +'m' );
            },
            stop: function( event, ui ) {
                umkreis = ui.value;
                $( "#zoom" ).val( umkreis +'m' );
            }
        });
        $( "#zoom" ).val( umkreis +'m' );
        
        
        $('.clearfield') .clearField();
        $('.button, #append, #applyplaces, #addressUmkreisSuche, .datum').button();
        
        dataTable = $('#repositoryTable').dataTable({
            "oLanguage": dataTableLanguage,
            "bJQueryUI": true,
            "aoColumnDefs": [ 
                //{ "bSearchable": true, "bVisible": false, "aTargets": [ 1 ] },
                {  "bSearchable": false, "bVisible": false, "aTargets": [ 8,9,10,11,12 ] }
            ],
            "bPaginate": false,
            "sDom": '<"top"i>t',
            "fnDrawCallback": function() {
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
            }
        });
        
        $('#repositoryTable tbody tr').live('click', function () {
            var nTds = $('td', this);
            // $.each(markerClusterer.getMarkers(), function(index, marker){
            if ($(nTds[0]).text()){
                console.log($(nTds[0]).text());   
                var href='/api/img/800x600/'+$(nTds[0]).text()+'.jpg';
                var title = '#'+$(nTds[0]).text()+ ': '+$(nTds[1]).text() + ' ' 
                    + $(nTds[2]).text()+ ' ' + $(nTds[5]).html()+ ' ' 
                    + $(nTds[7]).text()+ ' ' + $(nTds[6]).text();
                $.colorbox({href: href,
                    opacity: 0.65, maxWidth:'100%', maxHeight:'100%', 
                    title: title, 
                    fixed: true,
                    overlayClose: true,
                    close: 'Schließen'});
                //return false;"><img src="img/240x240/'+data.id+'.png"/></a>
            };
            // });
            $(dataTable.fnSettings().aoData).each(function (){
                $(this.nTr).removeClass('ui-state-highlight');
            });
        
            $(this).addClass('ui-state-highlight');
        });
        
        try {
            initLoadUserRepository();
        } catch(e) {
            console.log(e);
        }

        //dataTable.fnDraw();
        
        $("form#Stellenartenfilter select, form#Unterstellenartenfilter select").multiselect({
            position: {
                my: 'center',
                at: 'center'
            }, 
            header: false, minWidth: 'auto', height: '180', selectedList: 10, selectedText: '# / #', 
            show: ['slide', 500], open: function(){
                // $('.ui-multiselect-checkboxes') .jScrollPane({showArrows: true});
            }
        });
        $("form#Stellenartenfilter select, form#Unterstellenartenfilter select").multiselect('close');
        $('#Unterstellenartenfilter select').multiselect('checkAll');
        $('#Unterstellenartenfilter').hide();
                
        
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
                var api = '/api/api.php?command=4&latitude='+lat+'&longitude='+lng+'&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                mapcenter = new google.maps.LatLng(lat,lng);
                
                $.getJSON(api, apiCallBack);
               
            }
        });
        
        $( "#bestandssuche" ).autocomplete({
            autoFocus: true,
            source: '/api/api.php',
            minLength: 3,
            delay: 600,
            select: function( event, ui ) {
                //                console.log($.param(ui.item));
                //apiRequest('bestandssuche', ui.item);
                var api='/api/api.php?command=2&'+ $.param(ui.item)+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter();
                console.log(api);
                
                
                $.getJSON(api, apiCallBack);
            }
        });
        $( "#bestandssuche" ).autocomplete( "option" , {source: '/api/api.php'+'?gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter()+'&usta='+ustafilter()} );
        
        $('#loadwrapper').css('visibility','visible');
        
        
 
    });


</script>
<div id="loadwrapper" style="visibility:hidden">
    <div id="repositorytableouter" class="ui-widget ui-widget-content" style="width:100%;">
        <table id="repositoryTable" style="width: 100%; height: 100%;">
            <thead style="">
                <tr>
                    <th style="width: 25px;">ID</th><th style="max-width: 100px;">Kurzbezeichnung</th><th style="min-width: 260px;">Beschreibung</th>
                    <th style="width: 25px;">PLZ</th><th style="width: 25px;">GFK</th><th style="width: 25px;">Stellenart</th><th>€/Tag</th>
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
        <div class="buttonbar">
        <!--    <span id="taggedCheckOut" class="button" onclick="taggedCheckOut();"><span class=" ui-icon fff-icon-tick" style="float:left"></span> Merkliste anfragen</span>-->
            <a href="/api/standorte_2.php?repository=1&maponly=0&nosearch=1&intro=1" id="taggedLoad" class="button">Auf Karte anzeigen</a>
            <span id="taggedReload" onclick="initLoadUserRepository();" class="button"><span class=" ui-icon fff-icon-cancel" style="float:left"></span>Aktualiseren</span>
            <span id="loadRepositoryToTagged" onclick="loadUserRepositoryToTagged();" class="button"><span class=" ui-icon fff-icon-cancel" style="float:left"></span>Alle auf Merkliste</span>

<!--    <span class ="button"><input name="toggleimages"  class="toggleimages" type="checkbox" style="margin-top: 10px;" checked="checked" onclick="$('#taggedRepositoryTable td .smallimage').toggleClass('iconimage');"/>große Bilder anzeigen<span id="merkzettelouter_icon" class="ui-icon fff-icon-cart" style="float:left"></span></span>-->


        </div>

    </div>
    <div id="suchdialog" class="ui-widget ui-widget-content ui-corner-all" style="padding: 5px; width: 45%; float: right;">
        <input class="vtip button" title="Anzahl geladener Stellen. Klick l&ouml;scht den aktuellen Speicher." type="button" id="markercounter" value="0" onclick="clearClusterer();"/>

        <input id="append" type="checkbox" name="append" value="append"/>
        <label class="vtip ui-icon fff-icon-image-add" title="Append-Modus: wenn aktiv weren die Ergebnisse neuer Suchen hinzugef&uuml;gt. Wenn deaktiviert werden vorhandene Ergebnisse gel&ouml;scht." for="append">APP</label>

        <input type="button" value="0" class="vtip button" title="Umkreissuche relativ zum aktuellen Mittelpunkt der Hauptkarte mit gew&auml;hltem Radius durchf&uuml;hren und anzeigen (Haptkarte)." id="zoom" class="ui-state-default" style="width:70px; color: lightgreen"/>

        <input id="bestandssuche" type="text" class="ui-state-default vtip clearfield button" style="width: 50%;"
               value="Bestandssuche"  title="Suche im SDAW Bestand nach Standort, PLZ, Anbieter-ID, Nielsen, Schlagworten in Standortbeschreibung"/>


        <input type="text" id="address" value="Umkreissuche: bitte einen Standort eingeben" class="vtip ui-state-default clearfield" style="width: 80%"
               title="Geokodierung und Umkreissuche: Adresse, Bezeichnung oder Koordinaten eingeben.<br/>Zeigt nach Verschieben der Hauptkarte den Kartenmittelpunkt."/>

        <div title="Radius der Umkreissusche einstellen" id="umkreis" class="vtip ui-widget" style="height:8px; width: 60%;"></div>

        <div class="ui-widget-content" style="padding: 5px;" float: right>
            <form id="Stellenartenfilter" name="Stellenartenfilter"  >
                <select name="stellenarten-optgroup" multiple="multiple">
                    <optgroup label="Beleuchtung">
                        <option selected value="B" >Beleuchtet</option>
                        <option selected value="U">Unbeleuchtet</option>
                        <option selected value="H">Hintergrund beleuchtet</option>
                        <option selected value="R">Rahmen beleuchtet</option>
                    </optgroup>

                    <optgroup label="Hauptstellenarten">
                        <option value="AL" >AL,Allgemeiner Anschlag</option>
                        <option value="VI" >VI,joean-doeposter</option>
                        <option value="GZ" >GZ,Ganzstellen</option>
                        <option value="SZ" >SZ,Stretchsäule</option>
                        <option selected value="GF" >GF,Großflächen</option>
                        <option value="PB" >PB,Premium Billboard</option>
                        <option value="SB" >SB,StretchBoard</option>
                        <option value="SO" >SO,Sonstiges</option>
                        <option value="GV" >GV,18/1 Vitrinen</option>
                        <option value="SG" >SG,Sondergroßflächen</option>
                        <option value="SP" >SP,Superposter</option>
                        <option value="K4" >K4,Kleinflächen (4/1)</option>
                        <option value="K6" >K6,Kleinflächen (6/1)</option>
                        <option value="EM" >EM,Elektronische Medien</option>
                        <option value="PF" >PF,Panoramaflächen (36/1)</option>
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
        </div>

    </div>
</div>
<div id="markersRepository" class="ui-hidden-accessible">

</div>
<div id="placesRepository" class="ui-hidden-accessible">

</div>
<div id="taggedRepository" class="ui-hidden-accessible">

</div>
<div id="tmp" class="ui-hidden-accessible">
