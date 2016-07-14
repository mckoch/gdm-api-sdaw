<?php
/**
 * @name screenshots.php
 * @package SDAW_Classes
 * @author mckoch - 04.07.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 *
 * SDAW Classes:screenshots
 *
 *
 */
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title></title>
    </head>
    <body>
       <?php
                if ($handle = opendir('screenshots')) {
                    while (false !== ($file = readdir($handle))) {
                        if ($file != "." && $file != "..") {
                            echo '<img src="screenshots/'.$file.'"/>'.$file.'<br/><br/><hr/>';
                        }
                    }
                    closedir($handle);
                }
        ?>
    </body>
</html>
