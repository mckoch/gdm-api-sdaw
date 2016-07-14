<?php
/**
 * @name frontslides.php
 * @package GDM_joean-doe_media
 * @author mckoch - 18.07.2012
 * @copyright emcekah@gmail.com 2012
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * GDM_joean-doe_media:frontslides
 *
 *
 */
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>

    </head>
    <body style="background: #3d4897; width:100%; height: 100%;">
        <?php
        // put your code here
        ?>
        <div  class="contentarea">
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#slides").slides({
                        preload: true,
                        play: 5000,
                        crossfade: true,
                        effect: 'slide',
                        generateNextPrev: false,
                        generatePagination: false
                    });
                });
    
            </script>
            <div id="slides">
                <div class="slides_container">
                    <div>
                        <img src="/api/images/slides/Klappfenster_Grossflaeche.jpg">
                    </div>
                    <div>
                        <img src="/api/images/slides/Klappfenster_Kampagnengebiet.jpg">
                    </div>
                    <div>
                        <img src="/api/images/slides/Klappfenster_Rabatte.jpg">
                    </div>
                    <div>
                        <img src="/api/images/slides/Klappfenster_buchen.jpg">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
