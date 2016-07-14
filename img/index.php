<?php

/**
 * Create a thumbnail
 *
 * @author Brett @ Mr PHP
 * adopted by mckoch@mckoch.de for use in citylight-media.de a.o.
 */
// define allowed image sizes
$sizes = array(
    '240x240','360x360','800x600'
);

// ensure there was a thumb in the URL
if (!$_GET['thumb']) {
    error('no thumb');
}

// get the thumbnail from the URL
$thumb = strip_tags(htmlspecialchars($_GET['thumb']));

// get the image and size
$format = substr($thumb, -3, 3);
$thumb_array = explode('/', $thumb);
//print_r($thumb_array);
$size = $thumb_array[0];
$fileid = $thumb_array[1];

list($width, $height) = explode('x', $size);
//print substr($thumb,0,-4);
// ensure the size is valid
if (!in_array($size, $sizes)) {
    error('invalid size');
}

/**
 * hook to database for GDM0.2
 */
require_once ('../application_2.ini.php');
$dbi = new DBI;
$sql = "SELECT Standortnr, Stellennummer, StatOrtskz, Fotoname, Stellenart, count FROM STA WHERE count =" . substr($fileid, 0, -4);
$rs = $dbi->rs($sql);
//print $sql.'<br/>';

foreach ($rs as $data) {
    /**
     * …\Ortsnummer\Bilder.PPP\Fotoname.jpg
      Beispiel: …\02000000\Bilder.368\0234.JPG
      Dieses Foto gehört zu einer Tafel der Fa. Ströer (Bilder.368) in Hamburg (02000000) mit dem Fotonamen „0234 „
      („0234 mit vier Leerzeichen“) im Feld Fotoname.
      Angaben zu Bilddaten werden auch in der Datei „BLD“ geliefert – dort in anderer Form und auch für andere Bild-
      Formate.
     */
    $ortsnummer = $data['StatOrtskz'];
    $anbieter = substr($data['Standortnr'], 0, 3);
    $bild = $data['Fotoname'];
    $id= $data['count'];
    $art= strtolower($data['Stellenart']);
    /**
     * CAVE: uppercase/lowercase
     * shell: find my_root_dir -depth -exec rename 's/(.*)\/([^\/]*)/$1\/\L$2/' {} \;
     */
    $image = strToLower($ortsnummer . '/' . 'bilder.' . $anbieter . '/' . $bild . '.JPG');
}
//print($image);
// missing: const ORIGINAL_IMAGEPATH
// ensure the image file exists
if (!file_exists(ORIGINAL_IMAGEPATH.$image)) {
    error('no source ' . substr($fileid, 0, -4));
}

// generate the thumbnail
require('/srv/www/phpThumb/phpThumb.config.php');
require('/srv/www/phpThumb/phpthumb.class.php');

$phpThumb = new phpThumb();
$phpThumb->setSourceFilename(ORIGINAL_IMAGEPATH.$image);
$phpThumb->setParameter('w', $width);
$phpThumb->setParameter('h', $height);
$phpThumb->setParameter('f', $format); // @changed: set the output format
//$phpThumb->setParameter('far','C'); // scale outside
$phpThumb->setParameter('bg', 'FFFFFF'); // scale outside
$phpThumb->setParameter('config_allow_src_above_docroot', true); 
//$phpThumb->setParameter('fltr', 'gam|1.2');
//$phpThumb->setParameter('fltr','wmi|/srv/www/vhosts/gdm.citylight-media.de/httpdocs/sdaw/images/markers/marker.png|C|75|20|20');
$phpThumb->setParameter('fltr', array('wmi|/srv/www/vhosts/gdm.citylight-media.de/httpdocs/sdaw/images/markers/marker.png|C|25|0|0|0', 'wmi|/srv/www/vhosts/gdm.citylight-media.de/httpdocs/sdaw/images/markers/marker_'.$art.'.png|BR|95|5|5|0', 'wmt|#'.$id.' citylight-media.de|10|TL|CCFFFF|Delicious_Roman.otf|85|5|0|222222|55|0'));
 //$phpThumb->setParameter('fltr', 'wmi|/srv/www/vhosts/gdm.citylight-media.de/httpdocs/sdaw/images/markers/marker_'.strtolower($art).'.png|BR|75|15|5|0');
 // $text, $size, $alignment, $hex_color, $ttffont, $opacity, $margin, $angle, $bg_color, $bg_opacity, $fillextend
//$phpThumb->fltr = array("wmi|/srv/www/vhosts/gdm.citylight-media.de/httpdocs/sdaw/images/heart50.png|BR|20|5");
// $phpThumb->setParameter('fltr', 'wmi|/srv/www/vhosts/gdm.citylight-media.de/httpdocs/sdaw/images/markers/marker.png|BR|75|5|5|0');
// 'wmt|hello|14|C|00FFFF|Delicious_Roman.otf'

//$phpThumb->setParameter('config_cache_directory', '/srv/www/phpThumb/cache/');
if (!$phpThumb->GenerateThumbnail()) {
	//print_r($phpThumb->debugmessages);
    error('cannot generate thumbnail');
}

// make the directory to put the image
if (!mkpath(dirname($thumb), true)) {
    error('cannot create directory');
}

// write the file
if (!$phpThumb->RenderToFile($thumb)) {
        print "<pre>";
	print_r($phpThumb->debugmessages);
	print "</pre>";
    error('cannot save thumbnail');
}

// redirect to the thumb
// note: you need the '?new' or IE wont do a redirect
  //    print "<pre>";
//	print_r($phpThumb->debugmessages);
//	print "</pre>";
header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/' . $thumb . '?new');

// basic error handling
function error($error) {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>Not Found</h1>';
    echo '<p>The image you requested could not be found.</p>';
    echo "<p>An error was triggered: <b>$error</b></p>";
    exit();
}

//recursive dir function
function mkpath($path, $mode) {
    is_dir(dirname($path)) || mkpath(dirname($path), $mode);
    return is_dir($path) || @mkdir($path, 0777, $mode);
}

?>
