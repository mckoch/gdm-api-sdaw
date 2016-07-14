<?php
/**
 * @name userSaveRestore.plugin.php
 * @package GDM_joean-doe_media
 * @author mckoch - 16.12.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * GDM_joean-doe_media:userSaveRestire
 *
 * 
 */
?>
<div id="formtoolsouter" class="ui-hidden-accesssible">
    <form id="formtools" class="ui-widget ui-widget-content ui-hidden-accessible" style="width: 50%; float:right; opacity: .91; margin-top: 14px" rel="Datasets"method="POST" action="/api/savethis.php">

        <textarea class="clearfield" title="Kopieren / Einf&uuml;gen von Datasets (Format: JSON)." name="pastedata" id="pastedata" style="width: 100%; height:100px; float: right" cols="18" rows="4" value="Aktuelle Suchauswahl und Merkliste generieren">
        </textarea>
        <button class="vtip button" id="submitpastedata" title="Dataset einlesen / erzeugen. Aktuelle Filter werden bei Suche ber&uuml;cksichtigt." value="submitpastedata" onclick="return false;" style="float:right">Ausführen</button>
        <button class="vtip button" id="savepastedata" title="Dataset lokal abspeichern." value="savepastedata" onclick="return false;" style="float:left">Download</button>
<!--        <input class="button" type="checkbox" name="savedata" id="savedata"/>-->
        <!--        <label class="vtip" title="Wenn aktiv: Dataset zum Kopieren/Speichern erzeugen.<br/>Inaktiv: aktuelles Dataset einlesen." for="savedata">Dataset generieren</label>-->
        <div id ="formtoolsdatatype" style="float: right">
            <table>
                <tr><td><input type="radio" name="actiontype" id="readfromapp" value="readfromapp"  checked="checked"/>
                        <label class="vtip" title="Datentyp: GeoDataMapper interne IDs" for="readfromapp">generieren</label>
                    </td><td><input type="radio" name="actiontype" id="writetoapp" value="writetoapp" />
                        <label class="vtip" title="Datentyp: markierte Stellen / Merkliste" for="writetoapp">einlesen</label>
                    </td></tr>
                <tr><td><input type="radio" name="pastedatatype" id="SysIDs" value="lastrepository"/>
                        <label class="vtip" title="Datentyp: GeoDataMapper interne IDs" for="SysIDs">Auswahl</label></td>
                    <td><input type="radio" name="pastedatatype" id="Merkliste" value="tagged" checked="checked" />
                        <label class="vtip" title="Datentyp: markierte Stellen / Merkliste" for="Merkliste">Merkliste</label></td></tr>
            </table>            
        </div>
    </form>
    <div id="userstorage">
    </div>
</div>
<script type="text/javascript">
    var tagged;
    
    
    
    $(document).ready(function(){
        try {
            
            tagged = $.Storage.get('tagged');
            
            //alert (tagged);
            
        } catch(e) {
            console.log(e);
        }
        $('.clearfield').clearField();
        $('#submitpastedata').bind('click', function(){    
            
            var act = $('input:radio[name=actiontype]:checked').val();
            var dat = $('input:radio[name=pastedatatype]:checked').val();
            
            switch (act){
                case 'readfromapp':
                    $('#pastedata').val($.base64.encode($.Storage.get(dat)));
                    break;
                case 'writetoapp':
                    try {$.base64.decode($('#pastedata').val());
                        var decrypt = $.base64.decode($('#pastedata').val());
                        $.Storage.set(dat, decrypt);
                        $('#pastedata').val(act + ' ' + dat);
                    } catch(e) {
                        $.Storage.set(dat, $('#pastedata').val());
                        $('#pastedata').val(act + ' ' + dat);
                    }
                    break;
            }
            return false; 
        });
        
        $('#savepastedata').bind('click', function(){
            $('#formtools').submit();
        });
    });


</script>