<?php
/**
 * @name index.php
 * @package SDAW_Classes
 * @author mckoch - 25.04.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * SDAW Classes:index
 *
 *
 */
//print $_SESSION['__default']['user']->usertype . "<hr>";
if ($_SESSION['__default']['user']->usertype != "Super Administrator") {
    header('Location: /_ng/index.php');
    exit;
}

//include('/srv/www/miniblog/includes/miniblog.php');
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>GeoDataMapper Development Intro</title>

        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.loading.1.6.3.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#about').tabs({cache: true});
                $('a').not('ul a').button();
                $.loading.classname = 'loading';
                $.loading({onAjax:true, text: 'Lade...', pulse: 'working fade', mask:true});
                
                $('div#ui-tabs-1 a:not([rel="slb"])').live('click', function(){
                    $('div#ui-tabs-1').load($(this).attr('href'));
                    return false;
                });
                
                $('div#ui-tabs-3 a').live('click', function(){
                    $('div#ui-tabs-3').load($(this).attr('href'));
                    return false;
                });
                
                $('div#wrapper form#searchform, form#searchform-no-results').live('submit', function(){
                    $('div#ui-tabs-1').load(
                    $(this).attr('action')+ '?' +$(this).serialize());
                    return false;
                });


            });
        </script>
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


    </head>
    <body style="_background: url('1939.jpg'); background-attachment: fixed ;background-repeat: no-repeat; background-position: top center;">
        <div id="about" style="width:90%; margin-top: 5%; margin-bottom: 5%;margin-left: auto;margin-right: auto;" class="ui-widget">
            <div style ="float:right;" class="ui-widget vtip" title="Klicken Sie hier um direkten Kontakt mit ihrem Berater aufzunehmen oder eine Nachricht zu hinterlassen."><!-- LiveZilla Chat Button Link Code (ALWAYS PLACE IN BODY ELEMENT) --><a href="javascript:void(window.open('http://raderthalmedien.de/support/chat.php','','width=590,height=610,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))"><img src="http://raderthalmedien.de/support/image.php?id=01&amp;type=inlay" width="120" height="30" border="0" alt="LiveZilla Live Help"></a><!-- http://www.LiveZilla.net Chat Button Link Code --><!-- LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">
                var script = document.createElement("script");script.type="text/javascript";var src = "http://raderthalmedien.de/support/server.php?request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><noscript><img src="http://raderthalmedien.de/support/server.php?request=track&amp;output=nojcrpt" width="0" height="0" style="visibility:hidden;" alt=""></noscript><!-- http://www.LiveZilla.net Tracking Code -->
            </div>

            <h2 style="float: left; background: #FFFFFF; padding: 1em;" class="ui-corner-all">GeoDataMapper Version 0.4</h2>
            <!--                            -->

            <ul style="float:right;">
                <!--                <li><a href="#start">GDM 0.3</a></li>-->
                <li><a href="admin.php">Utilities</a></li>
                <!--                <li><a href="../joomla/">Login / Test 2</a></li>-->
            </ul>

            <div id="utilities"> </div>
        </div>
    </body>
</html>
