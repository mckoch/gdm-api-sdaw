<?php
/**
 * @name checkout.php
 * @package GDM_joean-doe_media
 * @author mckoch - 27.09.2012
 * @copyright emcekah@gmail.com 2012
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * GDM_joean-doe_media:checkout
 *
 * 
 */
if (!$_POST)
    die('illegal page access.');
define('included_from_api', 'included');
ini_set("memory_limit", "512M");

require_once('/var/www/vhosts/default/htdocs/_ng/index.php');

if (!headers_sent()) {
    header('Content-Type: text/html;charset=utf-8');
}

if ($_SESSION['__default']['user']->usertype != 'Registered'
        && $_SESSION['__default']['user']->usertype != 'Administrator'
        && $_SESSION['__default']['user']->usertype != 'Super Administrator') {
    print "Bitte melden Sie sich zuerst im System an. Dies ist kostenlos und unverbindlich. Zudem haben Sie Zugriff auf zusätzliche Informationen (Leistungswerte) in der gesamten Anwendung.";
    die;
}

if ($_GET['command'] == 'checkout') {
    require_once('application_2.ini.php');
    ini_set('display_errors', E_ERROR);
    if ($_POST['AUFTRAGSID'] != $_SESSION['myid']) {
        GH::appendToAngebotsLogfile('#CRITICAL ERROR: ' . $_POST['AUFTRAGSID'] . '#');
        die('ID MISMATCH. ABORTING.');
    } else {
        GH::appendToAngebotsLogfile('#BOOKING RECEIVE: ' . $_POST['AUFTRAGSID'] . '#'
                . json_encode($_SESSION['terminliste']) . '#'
                . json_encode($_POST) . '#' . $_SESSION['Rechnungssumme'] . '#');

        require_once(INCLUDEDIR . 'mail.inc.php');
        $vendor = "info@joean-doe-media.de";
        $mail = new eMail($_SESSION['__default']['user']->name, $_SESSION['__default']['user']->email);
        $mail->subject('BUCHUNG: Anfrage ' . $_SESSION['myid']);
        $mail->to('ticketbot@joean-doe-media.de');
        //$mail->to('emcekah@gmail.com');
        // $mail->cc($vendor);
        $mail->text($_SESSION['print_tafeln']
                . $_SESSION['print_termine']
                . '<div><a id="DATASET" href="#' . json_encode($_SESSION['terminliste']) . '">Karte</a></div>'
                . '<div id="Rechnungsadresse"><h4>Rechnungsadresse</h4>' .$_SESSION['print_rechnungsadresse'] 
                . '</div><div id="Kontaktdaten"><h4>Kontaktdaten</h4>' . $_SESSION['print_kontaktdaten']. '</div>'
                . '<div id="System"><h4>' . $_SESSION['myid']. '</h4></div>'
        );
        $r = $mail->send();
        GH::appendToAngebotsLogfile('#BOOKING DONE: ' . $_SESSION['myid'] . '#'
                // . serialize($r) 
                . '#');
        //die($_SESSION['myid']);
        die($_SESSION['print_tafeln'] . $_SESSION['print_termine']);
    }
}

try {
    require_once('application_2.ini.php');
    $_SESSION['myid'] = uniqid('GISA-A');

    require_once(INCLUDEDIR . 'CALENDAR.inc_1.php');
    ini_set('display_errors', E_ERROR);
    $cal = new CALENDAR;
    $strfmt = 'd.m.Y';

    require_once (INCLUDEDIR . 'FINDER.inc.php');
    $f = new FINDER();
} catch (Exception $e) {
    if (GH::checkIfAdmin() === true) {
        echo "<pre>" . $e . "</pre>";
    } else {
        echo '1:noop.';
    }
    die;
}

try {
    GH::appendToAngebotsLogfile('#ANGEBOT START ' . $_SESSION['__default']['user']->email . '#');
} catch (Exception $e) {
    if (GH::checkIfAdmin() === true) {
        echo "<pre>" . $e . "</pre>";
    } else {
        echo '2:noop.';
    }
    die;
}

try {
    $_SESSION['terminliste'] = array_unique(explode(',', $_POST['terminliste']));
    $print_termine = '';
    $tafeln = "";
    GH::appendToAngebotsLogfile('#ANZAHL ZU  BUCHENDER TERMINE: ' . count($_SESSION['terminliste'])
            . '#' . json_encode($_SESSION['terminliste']) . '#');
    $_SESSION['Rechnungssumme'] = 0;
} catch (Exception $e) {
    GH::appendToAngebotsLogfile($e);
    if (GH::checkIfAdmin() === true) {
        echo "<pre>" . $e . "</pre>";
    }
    else
        echo '3:noop.';
}
$termini = 0;
foreach ($_SESSION['terminliste'] as $termin) {
    try {
        $termini = $termini + 1;
        $data = $cal->getDetailsForTerminId($termin);
        $data = $data[0];
        $data['Tagespreis'] = $data['Tagespreis'] / 100;
        $periode = $cal->getDekaNo($data['Zeitraum']);
        $_SESSION['Rechnungssumme'] =
                $_SESSION['Rechnungssumme'] + $data['Rechnungstage'] * $data['Tagespreis'];
        // print '<pre>';
        $start =
                $periode['dekaplan'][substr($data['Belegdauerart'], -1)]['start']->ToString($strfmt);
        $end =
                $periode['dekaplan'][substr($data['Belegdauerart'], -1)]['end']->ToString($strfmt);
        //$data = json_encode($data);
        $print_termine .=
                '<tr><td>' . $termini . '</td><td>' . $termin . '</td><td>' . $data['Belegdauerart'] . '</td><td style="text-align:center;">'
                . $data['Rechnungstage']
                . '</td><td  style="text-align:right;">' . number_format($data['Tagespreis'], 2, ',', '.')
                . '</td><td style="text-align:center;">' . $data['Zeitraum'] . ' ' . $data['Jahr'] . '</td><td>' . $start . '</td><td>'
                . $end . '</td><td style="text-align:right;">' . number_format($data['Rechnungstage'] * $data['Tagespreis'], 2, ',', '.') . '</td></tr>';
        // $print_termine .= 
        $_SESSION['print_termine'] = $print_termine;

        $tafel = explode('-', $termin);
        $tafeln[] = $tafel[0];
    } catch (Exception $e) {
        GH::appendToAngebotsLogfile($e);
        if (GH::checkIfAdmin() === true) {
            echo "<pre>" . $e . "</pre>";
        }
        else
            echo '4:noop.';
    }
}

$print_tafeln = '';
$tafeli = 0;
$_SESSION['tafeln'] = array_unique($tafeln);
foreach ($_SESSION['tafeln'] as $tafel) {
    try {
        $tafeli = $tafeli + 1;
        $print_tafeln .= '<tr id = "' . $tafel . '">'
                . '<td>' . $tafeli . '</td>';
        $data = $f->checkoutsinglesysidsearch($tafel);
        $data = $data[0];
        if ($data['Leistungswert1']==0) $data['Leistungswert1'] = 'NA';
        $print_tafeln .= '<td><img style="height:68px; float: none;" src="http://joean-doe-media.de/api/img/240x240/'
                . $tafel . '.png"/></td>'
                . '<td>' . $data['count'] . '</td>'
                . '<td>' . $data['Stellenart'] . '</td>'
                . '<td>' . $data['Stellennummer'] . '</td>'
                . '<td>' . $data['Belegdauerart'] . '</td>'
                . '<td>' . $data['StatOrtskz'] . '</td>'
                . '<td>' . $data['PLZ'] . '</td>'
                . '<td>' . utf8_encode($data['Ortsteil']) . '</td>'
                . '<td>' . utf8_encode($data['Standortbezeichnung']) . '</td>'
                . '<td style="text-align:center;">' . $data['Leistungswert1'] . '</td>'
                . '<td>' . number_format($data['Preis'] / 100, 2, ',', '.') . '</td>'
                . '</tr>';

        $_SESSION['print_tafeln'] = $print_tafeln;
    } catch (Exception $e) {
        GH::appendToAngebotsLogfile($e);
        if (GH::checkIfAdmin() === true) {
            echo "<pre>" . $e . "</pre>";
        }
        else
            echo '5:noop.';
    }
}

GH::appendToAngebotsLogfile('#ANZAHL ZU BUCHENDER TAFELN: ' . count($_SESSION['tafeln']) . '#');

$rechnungsadresse = $_SESSION['__default']['user']->firma . ' <br/>'
        . $_SESSION['__default']['user']->name . '<br/>'
        . $_SESSION['__default']['user']->strasse . '<br/>'
        . $_SESSION['__default']['user']->plz . ' '
        . $_SESSION['__default']['user']->ort . '<br/>';
$kontaktdaten = 'Email: ' . $_SESSION['__default']['user']->email . '<br/>'
        . 'Benutzername: ' . $_SESSION['__default']['user']->username . '<br/>'
        . 'Telefon: ' . $_SESSION['__default']['user']->telefon . '<br/>'
        . 'Fax: ' . $_SESSION['__default']['user']->fax . '<br/>'
        . 'Mobil: ' . $_SESSION['__default']['user']->mobil . '<br/>'
;

$_SESSION['print_rechnungsadresse'] = $rechnungsadresse;
$_SESSION['print_kontaktdaten'] = $kontaktdaten;
?>
<script type="text/javascript">
    function angebotDrucken(){
        w =window.open();
        w.document.write($('.print').html());
        w.print();
        w.close();
    }

    $(document).ready(function(){
          
        $().message('Bitte beachten: hier können keine Änderungen an der Auswahl mehr vorgenommen werden.');
        $('.ajax').colorbox({ajax:true, width:'80%', height:'80%'});
        $('#angebot_container table').colorize({banDataClick:true});
        
        
        $.each($('#Auftraggeber input'), function(){
            //            
            //            var test;
            //            if (test = $.Storage.get($(this).attr('name'))){ 
            //                // console.log(test);
            //                $(this).val(test);
            $(this).attr('disabled', 'disabled');
            
            //            }
        });
        $('.button').button();
        $.each($('#BUCHUNG .vtip'),function(){
            $(this).qtip( $.extend({}, {
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
            }, { 
                content: {
                    text: $(this).attr('title')
                }
            }))
        });
        
        //        function validBooking(){
        //            $().message(dummy);
        //        }
        
        $('#BUCHUNG').validate(
        {

            submitHandler: function(form) {
                doTheCheckoutSubmit();
                //validBooking();
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
                agbchecker: {
                    required: true
                },
                widerrufschecker: {
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
                agbchecker: {
                    required: "Bitte klicken um die AGB zu akzeptieren."
                },
                widerrufschecker: {
                    required: "Bitte klicken um das Widerrufsrecht zu akzeptieren."
                }
            }
        });
    
    });
</script>
<form id="BUCHUNG" style="width: 100%; float: none;">

    <div id="angebot_container" class="ui-widget ui-widget-content print">
        <img src="geoinfsys.png" style="float: right;"/>
        <h1 class="buchung_status">ANGEBOT</h1>
        <table>
            <tr>
                
                <td>Anzahl verwendeter Flächen: <? print $tafeli; ?> | </td>
                <td>Anzahl zu buchender Perioden: <? print $termini; ?> | </td>
                <td><? print $_SESSION['myid']; ?> |</td>
                
            </tr>
        </table>
        <div id="TafelnInfos" style="width: 100%; float: none; margin-bottom: 55px;">

            <?
            $tableheader_tafeln = '
    <table id="' . $_SESSION['myid'] . '"><thead><tr>
                        <td>lfd. Nr.</td>
                        <td>Foto</td>
                        <td>Tafel ID</td>
                        <td>Stellenart</td>
                        <td>Nr.</td>
                        <td>Buchungsart</td>
                        <td>Ortskennziffer</td>
                        <td>Postleitzahl</td>
                        <td>Stadtteil</td>
                        <td>Ortsbeschreibung</td>
                        <td style="text-align:center;">Leistungswert</td>
                        <td style="text-align:right;">€/Tag</td>
                    </tr></thead><tbody>
    ';

            $tableheader_termine = '
       <table id="AngebotTermineInfo">
            <thead>
                <tr>
                    <td>lfd.Nr.</td>
                    <td>ID</td>
                    <td>Buchungsart</td>
                    <td>Rechnungstage</td>
                    <td style="text-align:right;">€/Tag</td>
                    <td>Dekade/Woche</td>
                    <td>Beginn</td>
                    <td>Ende</td>
                    <td style="text-align:right;">Rechnungsbetrag €</td>
                </tr>
                </thead>
            <tbody>
    ';
            $tablefooter = '</tbody></table>';

            $_SESSION['print_tafeln'] = $tableheader_tafeln . $_SESSION['print_tafeln'] . $tablefooter;
            print $_SESSION['print_tafeln'];
            ?>

        </div>
        <input type="hidden" id="AUFTRAGSID" name="AUFTRAGSID" value="<? print $_SESSION['myid']; ?>">

        <?
        $tablefooter_rechnungssumme = '<tr><td colspan="8" style="text-align: right">Netto-Rechnungsbetrag €</td>
        <td style="text-align:right;">
                ' . number_format($_SESSION['Rechnungssumme'], 2, ',', '.')
                . '
            </td></tr>
        <tr><td colspan="8" style="text-align: right">Brutto-Rechnungsbetrag €</td><td style="text-align:right;">'
                . number_format($_SESSION['Rechnungssumme'] / 100 * 119, 2, ',', '.')
                . '
        </td></tr>
        <tr></tr></tbody></table>';
        $_SESSION['print_termine'] = $tableheader_termine . $_SESSION['print_termine'] . $tablefooter_rechnungssumme;

        print $_SESSION['print_termine'];
        ?>

        <div id="Rechnungsadresse" class="ui-widget ui-widget-content"><h4>Rechnungsadresse</h4><? print $_SESSION['print_rechnungsadresse']; ?></div>
        <div id="Kontaktdaten" class="ui-widget ui-widget-content"><h4>Kontaktdaten</h4><? print $_SESSION['print_kontaktdaten']; ?></div>
        <div id="Auftraggeber" class="ui-widget ui-widget-content ui-helper-hidden-accessible" style="width:100%; float: none;">
            <h4>Systembenutzer</h4>
            <input class="button" disabled name="IhrName" value="<? print $_SESSION['__default']['user']->name ?>"/><label for="IhrName"></label><br/>
            <input class="button" name="Firma" value="<? print $_SESSION['__default']['user']->firma ?>"/><label for="Firma"></label><br/>
            <input class="button" disabled name="Email" value="<? print $_SESSION['__default']['user']->email ?>"/><label for="Email"></label><br/>
            <input class="button" name="Telefon" value="<? print $_SESSION['__default']['user']->telefon ?>"/><label for="Telefon"></label><br/>
            <input class="button" disabled name="GISA-ID" value="<? print $_SESSION['myid']; ?>"/><label for="Angebotsnummer"></label><br/>
        </div>
    </div>

    <div id="Einverstaendnis"  class="ui-widget ui-widget-content">
        <h4>Einverständniserklärung</h4>
        <input class="vtip help" type="checkbox" name="agbchecker" id="agbchecker" title="Bitte bestätigen dass Sie die Allgemeinen Geschäftsbedingungen gelesen haben und akzeptieren."/><label for="agbchecker"><a class="ajax" href="/_ng/index.php?option=com_content&view=article&id=20&Itemid=17 .content_right">Allgemeine Gechäftsbedingungen</a> akzeptiert</label>
        <br/>
        <input class="vtip help" type="checkbox" name="widerrufschecker" id="widerrufschecker" title="Verzicht auf mein Widerrufsrecht, warum?
               Als Verbraucher steht Ihnen ein gesetzliches Widerrufsrecht von 14 Tagen zu. Das würde bedeuten, dass wir nach Eingang Ihres Auftrages erst zwei Wochen abwarten müssen, bevor wir mit der Abwicklung Ihres Auftrags beginnen können. Die Zeit besteht in den meisten Fällen nicht, da sich die Verfügbarkeiten der Werbeträger stündlich ändern können. Deshalb bitten wir, dass Sie auf Ihr Widerrufsrecht verzichten, damit wir sofort mit unserer Arbeit beginnen können und Ihre Plakate pünktlich einschalten können. "/><label for="widerrufschecker">Ich verzichte auf mein Widerrufsrecht.</label>
        <br/>
    </div>


    <button class="button" name="doTheCheckoutSubmit"  id="doTheCheckoutSubmit" style="margin-top: 10px; width: 280px;">Hiermit bestelle ich die Buchung der ausgewählten Werbeträgerstandorte im ausgewählten Zeitraum.<span id="merkzettelouter_icon" class="ui-icon fff-icon-cart" style="float:left"></span><span class=" ui-icon fff-icon-tick" style="float:left"></span></button>
    <br/>

</form>
<br/>
<button class="button" id="angebotDrucken" style="margin-bottom: 2em;">Drucken</button>
<br/>
<div style="height: 80px">&nbsp;</div>
<?
GH::appendToAngebotsLogfile('#ANGEBOT ENDE ' . $_SESSION['__default']['user']->email . '#');

die;
?>
