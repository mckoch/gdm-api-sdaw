<?php
/**
 * @name calendartest.php
 * @package SDAW_Classes
 * @author mckoch - 13.07.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * SDAW Classes:calendartest
 *
 *
 */
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Test GDM Terminmodul</title>
        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
        <link type="text/css" href="js/fullcalendar.css" rel="stylesheet" />
        <!--        <link type="text/css" href="js/fullcalendar.print.css" rel="stylesheet" media="print"/>-->
        <link type="text/css" href="js/jquery.datatables.css" rel="stylesheet"/>

        <style type="text/css">
            .loading {
                background: #FFC129;
                color: black;
                font-weight: bold;
                padding: 3px;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
            }
            button, #quickkw input {width: 300px}
            .blockA, .A{padding: .1em; background-color: #ffff99}
            .blockB, .B{padding: .1em; background-color: #B6ECEC}
            .blockC, .C{padding: .1em; background-color: #CFF5A8}

            #results th, #results p {margin-top: .1em; background: silver}
            #results th, #results td, #results p {padding:.1em}

            table.KW {float: left;}

            table th {font-size: 10px}

            .fc-cell-overlay {
                background: none repeat scroll 0 0 #990244;
                opacity: 0.2;
            }
            #monatskalender .ui-state-active {padding: 2em;}
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


        </style>

        <script type="text/javascript" src="js/date.de-DE.js"></script>
        <script type="text/javascript" src="js/jquery-1.6.4.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.loading.1.6.3.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.clearfield.js"></script>
        <script type="text/javascript" src="js/jquery.taconite.js"></script>
        <script type="text/javascript" src="js/fullcalendar.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.js"></script>

        <script type="text/javascript" src="js/jquery.Storage.js"></script>
        <script type="text/javascript" src="js/jquery.json-2.2.js"></script>

        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/additional-methods.js"></script>
        <script type="text/javascript" src="js/messages_de.js"></script>

        <script type="text/javascript" src="js/jquery.tinysort.js"></script>

        <link rel="stylesheet" href="/api/js/colorbox.css" type="text/css"></link>
        <script src="/api/js/jquery.colorbox.js" type="text/javascript"></script>

        <script type="text/javascript">
            
            var KWLIST = Array();
            var DEKALIST = Array();
            var IDLIST = Array();
            var FREI = Array();
            var dataTable;
            
            function showCalendarAllBlocks(){
                $('input[name=block]').attr('checked', true);
                $('.blockA:hidden, .blockB:hidden, .blockC:hidden').toggle();
            }
            
            function saveKwList(){
                $.Storage.set('KWLIST', $.toJSON(KWLIST));
            }
            function saveDekaList(){
                $.Storage.set('DEKALIST', $.toJSON(DEKALIST));
            }
            
            function gfzcallback(data){
                FREI = $.evalJSON(data);
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
                    dataTable.fnAddData([data.id, data.Stellenart, data.PLZ, data.Rechnungstage,
                        data.Tagespreis/100, data.Leistungswert1, data.Zeitraum, 
                        '<input class="'+
                            data.Belegdauerart
                            +'" type="checkbox" name="tagged" value="'+data.id+'"/> '+data.Belegdauerart], false);
                });
                dataTable.fnDraw();
            }
            function getFreizahlenFromKwList(){
                $.post('termine.php?kwdata=1', {
                    kwdata: $.toJSON(KWLIST),
                    ids: $.Storage.get('lastrepository')
                }, gfzcallback);
            }
            
            function updateCalendarSelection(){
                showCalendarAllBlocks();
                try {
                    var start = new Date(Date.parse($('#start').val()).toString('yyyy-MM-dd'));
                    var end = new Date(Date.parse($('#end').val()).toString('yyyy-MM-dd'));
                    
                    $('#monatskalender').fullCalendar( 'unselect' );
                    $('#monatskalender').fullCalendar('select', start,end);
                    
                    $("#results table").tsort("thead");
                    
                } catch (e){
                    // console.log(e); 
                }
            }
            function updateDateSelection(){  
                /*
                 * var start / var end:
                 * müssen doppelt: Eintrag fullcalendar + $.get-Format!!
                 */
                var start = new Date(Date.parse($('#startdatum').val())).toString('yyyy-MM-dd');
                console.log(start);
                var end = new Date(Date.parse($('#enddatum').val())).toString('yyyy-MM-dd');
                console.log(start);
                $('#monatskalender').fullCalendar('addEventSource',[{
                        start: start,
                        end: end,
                        title: $('#startdatum').val() +' - '+$('#enddatum').val(),
                        className: 'ui-state-active'
                    }]);
                /* s.o. */
                var start = Date.parse($('#start').val()).toString('dd.MM.yyyy');
                var end = Date.parse($('#end').val()).toString('dd.MM.yyyy');
                $.getJSON('termine.php?daterange='+start+','+ end, function(data){
                    clearCalendar();
                    var i = data['startdeka'];
                    while (i <= data['enddeka']){
                        $.get('termine.php?Dekade='+ i);
                        i++;
                    }                    
                    var j = data['kwmin'];
                    while ( j <= data['kwmax']){                        
                        KWLIST.push(j);
                        $.unique(KWLIST);
                        $.get('termine.php?KW='+j);                        
                        j++;
                    }
                    // newTimeline();
                    $('#forms').tabs('option','disabled',[]);
                    $('#forms').tabs('select',2);
                    $('#forms').tabs('option','disabled',[0]);
                    
                    getFreizahlenFromKwList();
                });
            }
            
            function clearCalendar(){
                $('#results, #kwsmalltables').html(''); 
                $('#monatskalender').fullCalendar('removeEvents');
                $('#monatskalender').fullCalendar( 'unselect' );
                dataTable.fnClearTable();
                KWLIST = new Array();
                DEKALIST = new Array();
                showCalendarAllBlocks();
            }
            
            $(document).ready(function(){  
                 
                $.loading.classname = 'loading';
                $.loading({onAjax:true, text: 'Lade...', pulse: 'working fade', 
                    mask:true, working: {text:'Auftrag ist in Bearbeitung...'} });
                
                jQuery(function($){
                    $.datepicker.regional['de'] = {
                        closeText: 'schlie�en',
                        prevText: '&#x3c;zur�ck',
                        nextText: 'Vor&#x3e;',
                        currentText: 'heute',
                        monthNames: ['Januar','Februar','M�rz','April','Mai','Juni',
                            'Juli','August','September','Oktober','November','Dezember'],
                        monthNamesShort: ['Jan','Feb','M�r','Apr','Mai','Jun',
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
                $('.datepicker').not('#kwauswahlnachdatum').datepicker({defaultDate: "+2w",
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
                        
                    }});
                $('#kwauswahlnachdatum').datepicker({defaultDate: "+2w",
                    changeMonth: false,
                    numberOfMonths: 3,
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    showWeek: true,
                    onSelect: function(data){
                        var date = new Date(Date.parse(data).toString('yyyy-MM-dd'));
                        // var kwstart = date.sunday().toString('dd.MM.yyyy');
                        $('#start').val(date.sunday().addDays(-7).toString('dd.MM.yyyy'));
                        $('#end').val(date.sunday().addDays(-1).toString('dd.MM.yyyy'));
                        // console.log(kwstart);
                        $('#monatskalender').fullCalendar('gotoDate', date);
                        $('#monatskalender').fullCalendar('select', date);
                        updateCalendarSelection();  
                        
                        $(this).parent('form').submit();
                        updateDateSelection();
                        
                        
                    }});
                
                $("#daterange").validate({
                    rules: {
                        startdatum: {
                            required: true,
                            date: true
                        },
                        enddatum: {
                            required: true,
                            date: true
                        }
                    }
                });
                $('input, button, .button').not(':radio,:checkbox').button();
                $('input:text').clearField();
                
                var formoptions = {  
                    url:       'termine.php', 
                    type:      'get' 
                }; 
                $('form').not('form#Dekade, form#daterange').ajaxForm(formoptions);
                $('form#Dekade').ajaxForm({
                    url: 'termine.php',
                    type: 'get'
                });
                
                // Calendar
//                $.get('termine.php?full=1', function(data){
//                    z = eval(data);
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
                        height: 120,
                        weekMode: 'fixed',
                        // events: z,
                        viewDisplay: updateCalendarSelection,
                        eventAfterRender : updateCalendarSelection
                    });
                //});
                             
                $('#forms').tabs({
                    select: 0,
                    disabled: [2]
                });
                
                dataTable = $('#resultsTable').dataTable({
                    "bJQueryUI": true,
                    "fnDrawCallback": function(){
                        $('input.A').parents('td').addClass('blockA');
                        $('input.B').parents('td').addClass('blockB');
                        $('input.C').parents('td').addClass('blockC');
                        
                    }   
                });
                $('#resultsTable tbody tr').live('click', function () {
                    var nTds = $('td', this);
                    // $.each(markerClusterer.getMarkers(), function(index, marker){
                    if ($(nTds[0]).text()){
                        // console.log($(nTds[0]).text());   
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
                /**
                 * test loader!
                 */
                // $.Storage.set('tagged','[{"id":16000},{"id":15999},{"id":16001},{"id":15998},{"id":15999},{"id":16001},{"id":16012},{"id":16013},{"id":16019},{"id":16017},{"id":16015},{"id":16029},{"id":28034},{"id":16686},{"id":16695},{"id":16695}]');
            });
        </script>

    </head>
    <body class="ui-widget-content">

        <h2 class="ui-widget-header">Freizahlen Abfrageeditor</h2>

        <div id="monatskalender" class="ui-widget-content" style="width: 48%; float:left;"></div>
        <div id="forms"  style="width: 48%; float:right;">
            <ul>
                <li style="float:right;"><a  href="#maindaterange">M</a></li>
                <li style="float:right;"><a href="#utilities">U</a></li>
                <li style="float:right;"><a href="#blank">*</a></li>
            </ul>


            <div id="maindaterange">
                <form class="ui-widget ui-widget-content" id="daterange">
                    <input style="float:left;"  type="text" id="start" name="startdatum" class="datepicker" value="Startdatum"/>
                    <label for="startdatum"></label>
                    <input  style="float:left;" type="text" id="end" name="enddatum" class="datepicker" value="Enddatum"/>
                    <label for="enddatum"></label>
<!--                    <input style="float:right;" type ="checkbox" id="auto" name="autoabdeckung" title="Autoabdeckung: Dekaden bei Auswahl im Kalender einzeichnen"
                           onclick="$('#forms form').not($(this).parent()).toggle();">-->
                    <button onclick="updateDateSelection();return false;">Freizahlen abfragen</button>
    <!--                <input type="text" name="id" value="Ortskzf./Tafel/ID/PLZ"/>
                    <span id="qoptions">
                        <input type="radio" name="dopt" value="SDAWID" checked="checked"/>SDAWID
                        <input type="radio" name="dopt" value="STANDORTNR" checked="checked"/>STANDORTNR
                        <input type="radio" name="dopt" value="CLMID"/>CLMID
                        <input type="radio" name="dopt" value="ORTSKZF"/>ORTSKZF
                        <input type="radio" name="dopt" value="PLZ"/>PLZ
                    </span>
                    -->

                </form>
                <!--                <button id="submit" title="Freizahlen f�r gew�hlten Zeitraum und bestehende Ortsauswahl abfragen">
                                    Freizahlen abfragen</button>-->
                <form id="quickkw" class="ui-widget ui-widget-content">
                    <input type="text" id="kwauswahlnachdatum" name="DatumKW" class="datepicker" value="Schnellauswahl Kalenderwoche"/> 
                </form>

                <form id="quickdeka" class="ui-widget ui-widget-content">
                    <select name="Dekade" size="1">
                        <option>Bitte auswählen</option>
                        <option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option>
                        <option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option>
                        <option>21</option><option>22</option><option>23</option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option>
                        <option>31</option><option>32</option><option>33</option><option>34</option>
                    </select>
                    <button>Dekade abfragen</button>
                </form>
            </div>
            <div id="utilities">

                <form class="ui-widget ui-widget-content">

                    <input type="text" name="KW" class="" value="Kalenderwoche"/> 
                    <button id="submit">In welchen Dekaden liegt diese Kalenderwoche?</button>


                </form>

                <form id="Dekade" class="ui-widget ui-widget-content">

                    <input type="text" name="Dekade" class="" value="Dekade"/>
                    <button id="submit">Terminplan f�r diese Dekade?</button>
<!--                    <input type ="checkbox" name="draw" title="im Kalender einzeichnen">-->


                </form>

                <form class="ui-widget ui-widget-content">

                    <input type="text" name="DatumKW" class="datepicker" value="Datum"/> 
                    <button id="submit">Kalenderwoche f�r Datum hinzuf�gen</button>


                </form>

                <form class="ui-widget ui-widget-content">

                    <input type="text" name="DatumDeka" class="datepicker" value="Datum"/> 
                    <button id="submit">In welchen Dekaden liegt dieses Datum?</button>


                </form>
                <div id="submitters" style="" class="ui-widget-content">



                    <button id="savethis" onclick="getFreizahlenFromKwList();" title="Aktuelle Kalenderwochen-Auswahl abfragen.">Freizahlen f�r KWs abfragen</button>
                    <button id="clearcal" title="Reset" onclick="clearCalendar();">Reset</button>

                </div>
            </div>
            <div id="blank">
                <span style="float: right" id="switchblocks" class="button">
                    Anzeigefilter 
                    <input name="block" type="checkbox" checked="checked" title="Block A anzeigen/verbergen" class="blockAtoggle" 
                           rel="blockA" onclick="$('.blockA').toggle();"/>
                    <input name="block" type="checkbox" checked="checked" title="Block B anzeigen/verbergen" class="blockBtoggle" 
                           rel="blockB" onclick="$('.blockB').toggle();"/>
                    <input name="block" type="checkbox" checked="checked" title="Block C anzeigen/verbergen" class="blockCtoggle" 
                           rel="blockC" onclick="$('.blockC').toggle();"/>
                </span>
                <button onclick="return false;" 
                        style="float: right; width: 100px;">In Karte anzeigen</button>
                <button onclick="clearCalendar();$('#forms').tabs('option','disabled',[]);$('#forms').tabs('select',0);$('#forms').tabs('option','disabled',[2]);updateCalendarSelection();" 
                        style="float: right; width: 100px;">Neue Abfrage</button>

            </div>
        </div>

        <div id="resultstablecontainer" class="ui-widget ui-widget-content" style="width: 48%; float: right; clear: right;">
            <table id="resultsTable" style="width:100%">
                <thead>
                <th>ID</th><th>Art</th><th>PLZ</th>
                <th>Rtg.</th><th>€/Tg</th><th>Lw</th><th>D/KW</th>
                <th><input type="checkbox" style="float:right;"/></th>
                </thead>
            </table>
        </div>

        <div id="kwsmalltables" style="width: 48%; float: left; clear: left;"></div>

        <div id="results" class="ui-widget ui-widget-content" style="width:48%; float: right;"> </div>


        <style>
            div#timelinecontainer{ height: 120px; }
            div#mapcontainer{ height: 340px; }
        </style>
        <!--    <div id="timemap">
                <div id="timelinecontainer">
                    <div id="timeline"></div>
                </div>
                <div id="mapcontainer">
                    <div id="map"></div>
                </div>
            </div>-->
        <!--    <iframe src="maptype-styled-simple.html" style="width: 100%; height: 480px; float: right; clear: right"></iframe>-->
        <script type="text/javascript">
            var tm;
            function newTimeline() {
    
                tm = TimeMap.init({
                    mapId: "map",               // Id of map div element (required)
                    timelineId: "timeline",     // Id of timeline div element (required) 
                    options: {
                        eventIconPath: "../images/"
                    },
                    datasets: [
                        {
                            title: "Progressive Dataset",
                            theme: "green",
                            type: "progressive",
                            options: {
                                // Data to be loaded in JSON from a remote URL
                                type: "json", 
                                // url with start/end placeholders
                                url: "termine.php?wochensummen=[start]",
                                start: "2010-07-15",
                                // lower cutoff date for data
                                dataMinDate: "2009-12-31",
                                //  in milliseconds
                                interval: 604800000,   
                                // function to turn date into string appropriate for service
                                formatDate: function(d) {
                                    return TimeMap.util.formatDate(d, 1);
                                }
                            }
                        }
                    ],
                    bandIntervals: "wk"
                });
    
                // set the map to our custom style
                var gmap = tm.getNativeMap();
            
            }
        </script>
        <script type="text/javascript">
            var pkBaseURL = (("https:" == document.location.protocol) ? "https://www.joean-doe-media.de/api/tracker/" : "http://www.joean-doe-media.de/api/tracker/");
            document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
        </script><script type="text/javascript">
            try {
                var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
                piwikTracker.trackPageView();
                piwikTracker.enableLinkTracking();
            } catch( err ) {}
        </script><noscript><p><img src="http://www.joean-doe-media.de/api/tracker/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>

    </body>
</html>
