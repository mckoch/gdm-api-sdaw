<?php

class DISP {

    function __construct() {
        
    }

    protected $params = '';

    public function exec($exec, $params='') {
        try {
            switch ($exec) {
                case 'plzlist':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    return $f->getPlzList(substr($this->params['term'], 0, 8));
                    //print_r($this->params); die;
                    break;
                case 'okzflist':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    return $f->getOkzfList(substr($this->params['term'], 0, 8));
                    break;
                /**
                 * POST data per Email versenden
                 */
                case 'checkout':

                    require_once(INCLUDEDIR . 'mail.inc.php');
                    $myid = uniqid('GDM-R');

                    $vendor = "info@joean-doe-media.de";
                    // $vendor = "mckoch@freew3.org";
                    $customer = $_POST['Email'];

                    $mail = new eMail('joean-doe Media', $vendor);

                    //require_once (INCLUDEDIR . 'FINDER.inc.php');
                    //$f = new Finder;
                    //$cart = json_decode($_POST['merkliste']);
                    //foreach ($cart as $i) {
                    //    $cartdata[] = $i->id;
                    //}
                    //print var_dump($cartdata);
                    //return $f->sysidsearch($cartdata);


                    $mailtext = 'Folgende Daten wurden als unverbindliche Anfrage via http://joean-doe-media.de übermittelt: 
                        
';
                    
                    $mailtext .= $_POST['merkliste']
                            . ' ' . $_POST['Startdatum'] . ' ' . $_POST['Enddatum'] . ' ' . $_POST['IhrName']
                            . ' ' . $_POST['Firma'] . ' ' . $_POST['Telefon'] . ' ' . $_POST['Email'];
                    
                    if(isset ($_POST['terminliste'])) {
                        $mailtext .= ' 
                            ' .$_POST['terminliste'];
                    }

                    $mailfooter = '

Für Rückfragen antworten Sie einfach auf diese Email.

Mit freundlichen Grüßen,
Ihr joean-doe-Team
                        
------------------------------------
joean-doe Media GmbH&Co.KG
Römerstraße 213, 53117 Bonn
Tel: 0228.3361 683
Fax: 0228.3361.682



Sitz der Gesellschaft: Bonn
Amtsgericht Bonn: HRA 7655 
Geschäftsführer: O.Kimminus, H.Ramon Jones 
www.joean-doe-media.de';



                    /**
                     * Bestaetigung an Kunden versenden
                     */
//                    $mail->subject('Anfrage ' . $myid);
//                    $mail->to($customer);
//                    $mail->bcc('ticketbot@joean-doe-media.de');
//                    $mail->cc($vendor);
//                    $mail->text($mailtext . $mailfooter);
//                    $mail->send();

                    /**
                     * Anfrage an Anbieter versenden
                     * erweiterte Datasets -> items Anfrage
                     * alternative Methode , Vorr: gültige Emailadresse
                     * (ansonsten loopt die Fehlermeldung!!)
                     */
                    $mail = new eMail($_POST['IhrName'], $customer);
                    $mail->subject('Anfrage ' . $myid);
                    $mail->to('ticketbot@joean-doe-media.de');
                    $mail->cc($vendor);
                    $mail->text($mailtext);
                    $mail->send();
                    /**
                     * return an Browser etc.
                     */
                    return 'Anfrage ' . $myid . ' erfolgreich. Eine Bestätigung wurde an ' . $customer . ' versendet.';
                    break;
                case 'info':
                    $db = new DBI;
                    /**
                     * schauderhaftes Return (screen only)!!!
                     * @todo korrektes Objekt erzeugen
                     */
                    return $db->countRecords() . '<br/>' . $db->listTables() . '<br/>';
                    break;
                case 'plzarea':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    $f->setparams($this->params);
                    return $f->plzAreaSearch();
                    break;
                case 'gkzfarea':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    $f->setparams($this->params);
                    return $f->gkzfAreaSearch();
                    break;
                /**
                 * aus GET: PLZ Polygone suchen.
                 * _keine_ Suche im SDAW-Bestand!
                 */
                case 'plzpolygons':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    //$f->setparams($this->params);
                    //print_r($this->params);
                    return $f->plz2polygons(json_decode($_GET['pastedata']));
                    break;
                /**
                 * aus POST: Eingabe von GDM datasets
                 * das ist extrem unsauber: $_POST durch this->params ersetzen.
                 */
                case 'userdata':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    $f->setparams($this->params);

                    switch ($_POST['pastedatatype']) {
                        case 'cartitems':
                            $cart = json_decode($_POST['pastedata']);
                            //$cartdata = [];
                            foreach ($cart as $i) {
                                $cartdata[] = $i->id;
                            }
                            //print var_dump($cartdata);
                            return $f->sysidsearch($cartdata);
                            break;
                        case 'postcodes':
                            return $f->plzsearch(json_decode($_POST['pastedata']));
                            break;
                        case 'sdawids':
                            return $f->sdawidsearch(json_decode($_POST['pastedata']));
                            break;
                        case 'sysids':
                            return $f->sysidsearch(json_decode($_POST['pastedata']));
                            break;
                        case 'coords':
                            return $f->coordsearch(json_decode($_POST['pastedata']));
                            break;
                        case 'gdmdata':
                            break;
                    }

                    break;
                case 'polygon':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    $f->setparams(json_decode($this->params));
                    return $f->polygonSearch();
                    break;
                case 'rectangle':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    $f->setparams($this->params);
                    return $f->rectangleSearch();
                    break;
                case 'gpos':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    $f->setparams($this->params);
                    return $f->gposAreaSearch();
                    break;
                case 'dynamicsearch':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    $f->setparams($this->params);
                    return $f->doDynamicSearch();
                    break;

                case 'find':
                    require_once (INCLUDEDIR . 'FINDER.inc.php');
                    $f = new FINDER;
                    $f->setparams($this->params);
                    return $f->doSearch();
                    break;

                case 'init':
                    return new INIT;
                    break;

                case 'newtable':
                    require_once (INCLUDEDIR . 'XmlTableStructureImport.inc.php');
                    return new XmlTableStructureImport;
                    break;

                case 'insert':
                    require_once (INCLUDEDIR . 'TextFileImport.inc.php');
                    return new TextFileImport;
                    break;

                case 'export':
                    require_once (INCLUDEDIR . 'TextFileExport.inc.php');
                    return new TextFileExport;
                    break;
            }
            return false;
        } catch (Exception $e) {
            if (GH::checkIfAdmin() === true) {
                echo "<pre>" . $e . "</pre>";
            }
            else
                echo 'noop.';
        }
    }

    public function setparams($params) {
        $this->params = $params;
        return;
    }

}

?> 