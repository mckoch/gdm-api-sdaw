<?php
/**
 * @name userLoadTagged.plugin.php
 * @package GDM_joean-doe_media
 * @author mckoch - 16.12.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * GDM_joean-doe_media:userLoadTagged
 *
 * 
 */
?>
<div id="test"></div>
<script type="text/javascript">
    var tagged;
    var checkOuts = 0;
    var umkreis = 500;
    var gfkrange = [0,500];
    var pricerange =[0,100000];
    var stafilter ='B,U,AL,VI,GZ,SZ,GF,PB,SB,SO,GV,SG,SP,K4,K6,EM,PF';
    var ustafilter ='ST,BU,BS,BX,WH,BF,WR,AR,PR,PH,EK,PO,FH,IN,PW,QA,SE,ES,EM,CI,US,G8,GL,SL,ZZ'; 
    
    var dataTableLanguage = {
        "sProcessing":   "Bitte warten...",
        "sLengthMenu":   "_MENU_ Flächen anzeigen",
        "sZeroRecords":  "Ihre Merkliste ist noch leer..",
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
    
    function doTheCheckoutSubmit(){
        var lng = $('#checkOutForm').serialize();
                
        $.ajax({
            type: 'POST',
            url: '/api/api.php?command=checkout',
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
    
    function printTagged(){
        ///dataTable.fnClearTable();
        var items = $.evalJSON($.Storage.get('tagged'));
        tagged = new Array();
        $.each(items, function (){
            if (this.id){
                // console.log(this.id);
                tagged.push({'id': this.id});
            }
        });
    
        $('#pastedata').val($.toJSON(tagged));
        //$('#submitpastedata').trigger('click');
        var api = '/api/api.php?command=print&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter+'&usta='+ustafilter;
        // alert (api+lng);
        // $.post(api,lng,apiCallBack);
        var postdata = $('#formtools').serialize();
        $.ajax({
            type: 'POST',
            url: api,
            data: postdata,
            // success: apiCallBack,
            dataType: 'json'
        });
        
//       $('#formtools').attr('action', api);
//       $('#formtools').attr('method', 'POST');
//       $('#formtools').submit();
        $.Storage.set('tagged_changed_from_map', 'no changes');
    }
    function loadTagged(){
        ///dataTable.fnClearTable();
        var items = $.evalJSON($.Storage.get('tagged'));
        tagged = new Array();
        $.each(items, function (){
            if (this.id){
                // console.log(this.id);
                tagged.push({'id': this.id});
            }
        });
    
        $('#pastedata').val($.toJSON(tagged));
        //$('#submitpastedata').trigger('click');
        var api = '/api/api.php?command=8&umkreis='+ umkreis+'&gfk='+gfkrange+'&prc='+pricerange+'&sta='+stafilter+'&usta='+ustafilter;
        // alert (api+lng);
        // $.post(api,lng,apiCallBack);
        var postdata = $('#formtools').serialize();
        $.ajax({
            type: 'POST',
            url: api,
            data: postdata,
            success: apiCallBack,
            dataType: 'json'
        });
        $.Storage.set('tagged_changed_from_map', 'no changes');
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
                    // data[i].description,
                    '<img class="smallimage iconimage" src="/api/img/240x240/'+data[i].id+'.jpg"/>&nbsp;'+data[i].description,  
                    data[i].plz,
                    data[i].leistungswert1,
                    // '<img class="iconimage" src="/api/img/240x240/'+data[i].id+'.jpg"/>'+
                    '<img class="smallimage iconimage" src="/api/images/markers/marker_' + data[i].stellenart.toLowerCase() +'.png"/>'+ data[i].stellenart,
                    // data[i].stellenart,
                    data[i].preis/100,
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
        $.each($('#markersRepository').data(), function(key, value) {
            // alert(key + ': ' + value);
            data.push(key);

        });
        $('#tmp').data('sysids',data);
        data = $.toJSON($('#tmp').data('sysids'));
        $.Storage.set('lastrepository', data);
        $('body').scrollTo( $('#taggedRepositoryTable'), 1000);
        
        //$('.toggleimages').trigger('click');
    } 
    //// 
    //EO apiCallBack
            
            
            
    $(document).ready(function(){
        dataTable = $('#taggedRepositoryTable').dataTable({
            "oLanguage": dataTableLanguage,
            "bJQueryUI": true,
            "aoColumnDefs": [ 
                // { "bSearchable": true, "bVisible": false, "aTargets": [ 1 ] },
                {  "bSearchable": false, "bVisible": false, "aTargets": [ 8,9,10,11,12 ] }
            ],
            "bPaginate": false,
            "sDom": '<"top"i>t',
            "fnDrawCallback": function() {
                        
                //$('#map-side-bar-container').jScrollPane({showArrows: true});                        
            }
        });
        
        $('#taggedRepositoryTable tbody tr').live('click', function () {
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
        
        //dataTable.fnDraw();
        
        try {
            
            //tagged = $.Storage.get('tagged');
            
            loadTagged();
            
        } catch(e) {
            console.log(e);
        }
        
        
        $('.button').button();
        
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
            $(this).valid();
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
        
        $('.clearfield') .clearField();
        $.datepicker.setDefaults($.datepicker.regional['de']);
        $( ".datum" ).datepicker({
            defaultDate: "+2w",
            changeMonth: true,
            numberOfMonths: 3,
            onClose: function (){$(this).valid();}
        }).button();
        
        
        try{
            if(!$.Storage.get('tagged')>0){{
                    return false;
                }} else {
                $.each($('#checkOutForm #kontaktdaten input'), function(){
                    var test;
                    if (test = $.Storage.get($(this).attr('name'))){ 
                        $(this).val(test);}
                });
                $('#taggedtmp').val($.Storage.get('tagged'));
            }
        } catch (e) {console.log(e);}
        
       
        $('#formtoolsouter').hide();
        $('#loadwrapper').css('visibility','visible');
    });


</script>
<div id="loadwrapper" style="visibility:hidden">
    <div id="merkzetteltableouter" class="ui-widget ui-widget-content" style="width:100%;">
        <table id="taggedRepositoryTable" style="width: 100%;">
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


    </div>
    <div class="buttonbar">
    <!--    <span id="taggedCheckOut" class="button" onclick="taggedCheckOut();"><span class=" ui-icon fff-icon-tick" style="float:left"></span> Merkliste anfragen</span>-->
        <a id="taggedLoad" class="button" href="/api/standorte_2.php?merkliste=1&maponly=0&nosearch=1&intro=1">Auf Karte anzeigen</a>
    <!--    <span id="taggedClear" class="button"><span class=" ui-icon fff-icon-cancel" style="float:left"></span>Merkliste leeren</span>-->

        <span class ="button"><input name="toggleimages"  class="toggleimages" type="checkbox" style="margin-top: 10px;" onclick="$('#taggedRepositoryTable td .smallimage').toggleClass('iconimage');"/>große Bilder anzeigen<span id="merkzettelouter_icon" class="ui-icon fff-icon-cart" style="float:left"></span></span>
        <span id="taggedReload" onclick="loadTagged();" class="button"><span class=" ui-icon fff-icon-cancel" style="float:left"></span>Aktualiseren</span>
        <span id="printThis" onclick="printTagged();return false;" class="button"><span class=" ui-icon fff-icon-cancel" style="float:left"></span>Druckversion</span>

    </div>

    <form id="checkOutForm" style="width: 50%; float: right">

        <input type="hidden" id="taggedtmp" name="merkliste"/>

        <div id="kalenderplanung" class="ui-widget-content" style="margin-top: 10px; margin-bottom:10px;">

            <input type="text" class="datum clearfield" value="Startdatum"  title="Startdatum" id="startdatum" name="Startdatum" style="width: 80px;"/><label for="Startdatum"></label>
            <input type="text" class="datum clearfield"  value="Enddatum" title="Enddatum"  id="enddatum" name="Enddatum" style="width: 80px;"/><label for="Enddatum"></label>
        </div>


        <div id="kontaktdaten" class="ui-widget ui-widget-content">

            <input class="input_field_12em button clearfield" name="IhrName" value="Name"/><label for="IhrName"></label><br/>

            <input class="input_field_12em button clearfield" name="Firma" value="Firma"/><label for="Firma"></label><br/>

            <input class="input_field_12em button clearfield" name="Email" value="Emailadresse"/><label for="Email"></label><br/>

            <input class="input_field_12em button clearfield" name="Telefon" value="Telefonnummer"/><label for="Telefon"></label><br/>
            <button class="button" name="doTheCheckoutSubmit"  id="doTheCheckoutSubmit" style="margin-top: 10px;"> Bitte informieren Sie mich unverbindlich über die gewählten Tafeln im angegebenen Zeitraum.<span id="merkzettelouter_icon" class="ui-icon fff-icon-cart" style="float:left"></span><span class=" ui-icon fff-icon-tick" style="float:left"></span></button>

            <div id="alreadyCheckedOut" style="width: 100%; overflow: auto"></div>
        </div>

    </form>

    <div id="formtoolsouter" class="ui-hidden-accesssible">
        <form id="formtools" class="ui-hidden-accessible" style="opacity: .91; margin-top: 14px" rel="Datasets">

            <textarea class="vtip" title="Kopieren / Einf&uuml;gen von Datasets (Format: JSON)." name="pastedata" id="pastedata" style="width: 100%; height:100px; float: none" cols="18" rows="4">
            </textarea>
            <button class="vtip button" id="submitpastedata" title="Dataset einlesen / erzeugen. Aktuelle Filter werden bei Suche ber&uuml;cksichtigt." value="submitpastedata" onclick="return false;" style="float:right">Submit</button>
            <div id ="formtoolsdatatype" style="float: none">
                <input type="radio" name="pastedatatype" id="Merkliste" value="cartitems" checked="checked" />
                <label class="vtip" title="Datentyp: markierte Stellen / Merkliste" for="Merkliste">Merkliste</label>
            </div>
        </form>
        <div id="userstorage">
        </div>
    </div>
</div>