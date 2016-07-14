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
// require_once('/var/www/vhosts/default/htdocs/_ng/index.php');
//print_r($_SESSION['__default']['user']);


require_once('include/html.pagecompressor.php');
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>



        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Copyright" content="joean-doe Media GmbH, Bonn">
        <meta http-equiv="web_author" content="Markus C. Koch, emcekah@gmail.com ">
        <meta name="generator" content="GeoDataMapper V0.5">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <meta name="Description" content="Aus über 250.000 Werbetafeln an Standorten in ganz Deutschland auswählen und buchen. Werbung wo sie hingehört.">

        <title>Standortverzeichnis Au&szlig;enwerbung</title>


        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
        <link type="text/css" href="js/jquery.layout-default-latest.css" rel="stylesheet"/>
        <link type="text/css" href="css/ui-icon/css/fff.icon.core.css" rel="stylesheet" />
        <link type="text/css" href="css/ui-icon/css/fff.icon.icons.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" media="screen" href="js/ui.multiselect.css" />
        <link type="text/css" href="js/jquery.datatables.css" rel="stylesheet"/>
        <link type="text/css" href="js/colorbox.css" rel="stylesheet"/>
        <link type="text/css" href="js/jquery.jscrollpane.css" rel="stylesheet" media="all" />


        <!--               <link type="text/css" href="min/g=public_css" rel="stylesheet"/>-->


        <style type="text/css">

            body {overflow:  hidden;}

            p#vtip { display: none; position: absolute; padding: 10px; left: 5px; font-family:Tahoma, Arial, sans-serif;font-size: 0.8em; background-color: white; border: 1px solid #a6c9e2; -moz-border-radius: 5px; -webkit-border-radius: 5px; z-index: 999999 }
            p#vtip #vtipArrow { position: absolute; top: -10px; left: 5px }

            ul.ui-multiselect-checkboxes {overflow-y: scroll;}
            #Placesfilter select option img {height: 12px;}
            #common select {width:340px;z-index: 10000}

            .loading {
                background: #FFC129;
                color: black;
                font-weight: bold;
                padding: 3px;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
            }

            #repositoryTable td, #taggedRepositoryTable td { white-space: nowrap; }
            td img {height: 12px}

            div.infobubble a.ui-widget {padding: 3px; margin-top: 12px;}


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

            ul#tablist li{float:right;}

        </style>

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=places&sensor=false"></script>
        <script type="text/javascript">var SessionUser='<?php print $_SESSION['__default']['user']->username; ?>';var SessionUserRole = '<?php print $_SESSION['__default']['user']->usertype; ?>';var SessionUserEmail = '<?php print $_SESSION['__default']['user']->email; ?>';var SessionUserPass = '<?php print $_SESSION['__default']['user']->password; ?>';</script>


        <!--        
                <script type="text/javascript" src="js/markerClusterer.js"></script>
                <script type="text/javascript" src="js/progressBar.js"></script>
                <script type="text/javascript" src="js/infobubble.js"></script>
                <script type="text/javascript" src="js/maplabel.js"></script>
        
                <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
                <script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
        
                <script type="text/javascript" src="js/jquery.layout-latest.js"></script>
                <script type="text/javascript" src="js/jquery.json-2.2.js"></script>
                <script type="text/javascript" src="js/jquery.dataTables.js"></script>
                <script type="text/javascript" src="js/jquery.pulse.js"></script>
                <script type="text/javascript" src="js/jquery.clearfield.js"></script>
        
                <script type="text/javascript" src="js/jquery.vtip.js"></script>
                
                <script type="text/javascript" src="js/jquery.jscrollpane.js"></script>
                <script type="text/javascript" src="js/jquery.multiselect.js"></script>
                <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
                <script type="text/javascript" src="js/jquery.tinysort.js"></script>
                <script type="text/javascript" src="js/jquery.Storage.js"></script>
                <script type="text/javascript" src="js/jquery.loading.1.6.3.js"></script>
                <script type="text/javascript" src="js/jquery.colorbox.js"></script>
        
                <script type="text/javascript" src="js/jquery.validate.js"></script>
                <script type="text/javascript" src="js/additional-methods.js"></script>
        
        -->

        <script type="text/javascript" src="min/g=public_js"></script>
    <!--    <script type="text/javascript">
        <?php
        //include('include/javascript.onload.php');
        ?>
            </script>
        -->
    </head>
    <body>
        <div id="loader" style="width: 100%; height: 100%; z-index: 100000000; position: absolute; top:0; left:0; background: #ffffff; background-image: url('http://www.joean-doe-media.de/images/pic_impressum.jpg'); background-position: center;background-repeat: no-repeat;text-align: center;">
            <!--<div id="innerloader" style="z-index: 100000000; background: url('headerbox.png'); 
            position: absolute; top: 0; left:0; width:100%;height: 240px; margin-left: auto;margin-right: auto; opacity: .73; background-position: center top; background-repeat: no-repeat;">                
            </div>-->
            <div id="gdmlogo" class="ui-widget ui-widget-content" style="width:30%; margin-top: 22%;margin-left: auto;margin-right: auto; opacity: .8">
                <img src="ui-anim_basic_16x16.gif" style="float: right"/>
                <!--<img style="float: none; margin:0;border:0;" src="banner.png"/> -->
                <h2 style ="text-align: center;  padding: 1em; border: 0 solid silver">Werbung wo sie hingeh&ouml;rt - aus über 255.000 Werbetafeln in ganz Deutschland auswählen.</h2>
                <em>GDM GeoDataMapper - das Expertentool f&uuml;r Geomarketing &amp; Au&szlig;enwerbung</em>
                <p>lade Anwendung...</p>
            </div>
        </div>
        <!--        <div class="ui-layout-north">
                    <img src="banner.png" style ="float: none; margin:0;border:0; height: 18px; "/> GDM 0.4 - &ouml;ffentliches Standortverzeichnis
                </div>-->
        <div class="ui-layout-center"  style="padding:0; margin:0;">
            <div id="map_canvas" style="width: 100%; height: 100%; margin:0;">
            </div>
        </div>
        <div class="ui-layout-east" style="background: url(text54269679.png)">
            <img src="headerbox109x113.gif" style="height:60px; float: right; margin: 5px"/>
            <div id="headermessage" class="ui-widget" style="text-align:right"><h2 class="ui-widget ui-widget-content ui-widget-header">Werbetafeln suchen & auswählen</h2></div>
            <div id="suchdialog" class="ui-widget ui-widget-content ui-corner-all" style="padding: 5px;">
                <input class="vtip button" title="Anzahl geladener Stellen. Klick l&ouml;scht den aktuellen Speicher." type="button" id="markercounter" value="0" onclick="clearClusterer();"/>

                <input id="append" type="checkbox" name="append" value="append"/>
                <label class="vtip ui-icon fff-icon-image-add" title="Append-Modus: wenn aktiv weren die Ergebnisse neuer Suchen hinzugef&uuml;gt. Wenn deaktiviert werden vorhandene Ergebnisse gel&ouml;scht." for="append">APP</label>

                <input type="checkbox" id="addressUmkreisSuche" value="" class="button" checked="checked"  />
                <label class="vtip ui-icon fff-icon-arrow-refresh"  title="Sofort nach erfolreicher Geokodierung eine Umkreissuche mit eigestelltem Radius durchf&uuml;hren" 
                       for="addressUmkreisSuche">U</label>


                <input id="applyplaces" type="checkbox" name="applyplaces" value="applyplaces" />
                <label class="vtip ui-icon fff-icon-photos" title="Places anzeigen und in n&auml;chste Suche einbeziehen" for="applyplaces">PLC</label>


                <input type="checkbox" id="visibleMarkers" value="" class="button" checked="checked" />
                <label class="vtip ui-icon fff-icon-table-relationship"  title="Tabelle mit Ausschnitt in der Hauptkarte synchronisieren." 
                       for="visibleMarkers">VM</label>

                <input class="vtip button" title="Anzahl sichtbarer Stellen. Klick zoomt in die Übersicht aller geladenen Stellen." type="button" id="visibleMarkersCounter" value="0" onclick="google.maps.event.trigger(map, 'bounds_changed');"/>

                <input type="button" value="0" class="vtip button" title="Umkreissuche relativ zum aktuellen Mittelpunkt der Hauptkarte mit gew&auml;hltem Radius durchf&uuml;hren und anzeigen (Haptkarte)." id="zoom" class="ui-state-default" style="width:70px; color: lightgreen"/>


                <input type="text" id="address" value="Umkreissuche: bitte einen Standort eingeben" class="vtip ui-state-default clearfield" style="width: 100%"
                       title="Geokodierung und Umkreissuche: Adresse, Bezeichnung oder Koordinaten eingeben.<br/>Zeigt nach Verschieben der Hauptkarte den Kartenmittelpunkt."/>

                <div title="Radius der Umkreissusche einstellen" id="umkreis" class="vtip ui-widget" style="height:8px; width: 100%;"></div>


            </div>


            <div id="maindialog">
                <div id="tabs" style="float: right; width: 100%;" class="ui-widget">
                    <ul id="tablist">
                        <li class="vtip" title="Suchen / Auswahl"><a href="#common"><span id="geo_icon" class="ui-icon fff-icon-zoom" style="float:left"></span></a></li> 
                        <li class="vtip" title="gefundene Tafeln"><a href="#masterlist"><span class="ui-icon fff-icon-arrow-refresh" style="float:left"></span> Tafeln</a></li>
                        <li class="vtip" title="Merkzettel (leer)"><a href="#merkzettelouter"><span id="merkzettelouter_icon" class="ui-icon fff-icon-cart" style="float:left"></span> Merkliste</a></li>
                        <li class="vtip" title="TEMPORÄR SICHTBAR"><a href="#formtoolsouter"></a></li>
                        <li class="vtip" title="Checkout: markierte Tafeln anfragen"><a href="#CHECKOUT"><span class=" ui-icon fff-icon-tick" style="float:left"></span></a></li>
                    </ul>

                    <div id="common">
                        <!--                        <h2>Tab 0</h2>
                                                <ul>
                                                    <li>Combo-Dropdown Standorte Typen</li>-->
                        <div class="ui-widget-content" style="padding: 5px;">
                            <form id="Stellenartenfilter" name="Stellenartenfilter"  >
                                <select name="stellenarten-optgroup" multiple="multiple">
                                    <optgroup label="Beleuchtung">
                                        <option selected value="B" >Beleuchtet</option>
                                        <option selected value="U">Unbeleuchtet</option>
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
                            <!--                            <li>Eingabefeld GeoCoder Umkreissuche</li>-->

                            <br />
                            <!--                            <li>Slider Umkreis</li>
                                                        <li>Slider Clusterzoom</li>
                                                        <li>Button Ausschnittssuche</li>
                                                        <li>Checkbox + Button (?) Common Places</li>
                            
                            
                                                        <li>Combo Places Typen</li>-->

                            <form id="Placesfilter">
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
<!--                            <script type="text/javascript"
                                    src="http://jqueryui.com/themeroller/themeswitchertool/">
                            </script>
                            <div id="switcher"  onclick="$(this).themeswitcher().loadTheme('smoothness');">Themes</div>-->
                        </div>
                        <!--                        <br />-->
                        <!--                            <li>Checkbox Append-Modus</li>-->

<!--                        <input class="button" type="checkbox" name="drawplz" id="drawplz"/>
<label class="vtip" title="aktuelle Postleitzahlen in Hauptkarte einzeichnen." for="drawplz">Postleitzahlen anzeigen</label>
                        -->




<!--                        <span class="vtip button" title="Aktuellen Ausschnitt nach Stellen durchsuchen" id ="RECTSRCH" onclick="apiRequest('bounds',map.getBounds());" style="width:70px;">Ausschnitt</span>-->
                        <!--                        </ul>-->   



                    </div>
                    <div id="masterlist">

                        <div id="map-side-bar-container"  rel="Tabelle" class="ui-widget ui-widget-content"  style="overflow: scroll; width:100%; height:60%">

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
                        <div id="merkzetteltableouter" class="ui-widget ui-widget-content" style="overflow: scroll; width:100%; height:50%;">
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
                            <span id="taggedCheckOut" class="button" onclick="taggedCheckOut();"><span class=" ui-icon fff-icon-tick" style="float:left"></span> Merkliste anfragen</span>
                            <span id="taggedLoad" class="button" onclick="loadTaggedToMap();">Auf Karte anzeigen</span>
                            <span id="taggedClear" class="button"><span class=" ui-icon fff-icon-cancel" style="float:left"></span>Merkliste leeren</span>
                        </div>



                    </div>
                    <div id="formtoolsouter">
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
                    <div id="CHECKOUT">
                        <style type="text/css">#checkout .input_field_12em {width: 50%}</style>

                        <form id="checkOutForm">

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
                            </div>
                        </form>

                        <div id="alreadyCheckedOut" style="width: 100%; height: 100px; overflow: auto"></div>
                        <div class="buttonbar">
                            <div id="checkoutCancel" class="button" onclick="checkoutCancel();"><span class=" ui-icon fff-icon-arrow-undo" style="float:left"></span> Zurück zur Suche</div>
                            <div id="taggedZoom" class="button" onclick="map.fitBounds(getClustererBounds(markerClusterer));"><span class=" ui-icon fff-icon-arrow-refresh" style="float:left"></span> Alles anzeigen</div>
                        </div>

                    </div>


                </div>
                <div id="footerslogan" class="ui-widget ui-widget-content" style="width: 80%; padding: 5px;text-align:right; position: absolute; bottom:0px;">Aus über 255.000 Werbeflächen in ganz Deutschland auswählen und buchen <br/>- sehen wo Werbung wirklich wirkt!</div>

            </div>
        </div>
        <!--        <div class="ui-layout-south">
        
                </div>-->
        <!--        <div class="ui-layout-west">
        
                </div>-->

        <div id="markersRepository" class="ui-hidden-accessible">

        </div>
        <div id="placesRepository" class="ui-hidden-accessible">

        </div>
        <div id="taggedRepository" class="ui-hidden-accessible">

        </div>
        <div id="tmp" class="ui-hidden-accessible">

        </div>
        
        <!-- LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">
var script = document.createElement("script");script.type="text/javascript";var src = "http://joean-doe-media.de/support/server.php?request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><noscript><img src="http://joean-doe-media.de/support/server.php?request=track&amp;output=nojcrpt" width="0" height="0" style="visibility:hidden;" alt=""></noscript><!-- http://www.LiveZilla.net Tracking Code -->

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
