<?php

/**
 * @name savethis.php
 * @package GDM_joean-doe_media
 * @author mckoch - 20.12.2011
 * @copyright emcekah@gmail.com 2011
 * @version 1.1.1.1
 * @license No GPL, no CC. Property of author.
 * 
 * GDM_joean-doe_media:savethis
 * simple utility to create save dialog for user export
 *
 * 
 */ 

header('Content-type: application/text');
header('Content-Disposition: attachment; filename="joean-doe24-'.$_POST['pastedatatype'].'-dataset.txt"');
print $_POST['pastedata'];
?>
