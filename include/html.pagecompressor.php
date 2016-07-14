<?php

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
//	easy page compression & adjustments for obj_start('method')
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
//	taken from / to Destiller Tool Set DTS classes 05/2010
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
//	THIS CODE IS PROPERTY OF mckoch@mckoch.de
//	AND _not_ IN THE PUBLIC DOMAIN.
////////////////////////////////////////////////////////
////////////// METHODS 1
////////////////////////////////////////////////////////
function stripwhitespace($bff) {
    $pzcr = 0;
    $pzed = strlen($bff) - 1;
    $rst = "";
    while ($pzcr < $pzed) {
        $t_poz_start = stripos($bff, "<script", $pzcr);
        if ($t_poz_start === false) {
            $bffstp = substr($bff, $pzcr);
            $temp = stripBuffer($bffstp);
            $rst.=$temp;
            $pzcr = $pzed;
        } else {
            $bffstp = substr($bff, $pzcr, $t_poz_start - $pzcr);
            $temp = stripBuffer($bffstp);
            $rst.=$temp;
            $t_poz_end = stripos($bff, "</script>", $t_poz_start);
            $temp = substr($bff, $t_poz_start, $t_poz_end - $t_poz_start);
            // strip out JS comments; 3 steps
//            $temp = preg_replace('!/\*.*?\*/!s', '', $temp);
//            $temp = preg_replace('/\n\s*\n/', "\n", $temp);
//            $temp = preg_replace('(// .+)', '', $temp);
            $rst.=$temp;
            $pzcr = $t_poz_end;
        }
    }
    // delete JavaScript comments -> move to $temp!!!
    //$rst = preg_replace('!/\*.*?\*/!s', '', $rst);
    //$rst = preg_replace('/\n\s*\n/', "\n", $rst);
    //$rst = preg_replace('(// .+)', '', $rst);
    // delete HTML comments
    return preg_replace('/<!--(.*)-->/Uis', '', $rst);
    //return $rst;
}

// WALKING METHOD: select every incident by example.
function stripBuffer($bff) {
    $turbo = 1;

    if ($turbo === 1) {
        $bff = str_replace(array("\n", "\r", "\t"), '', $bff);
    } else {

        /* carriage returns, new lines */ // turbo: (("\n","\r","\t").'', $bff)
        $bff = str_replace(array("\r\r\r", "\r\r", "\r\n", "\n\r", "\n\n\n", "\n\n"), "", $bff);
        /* tabs */
        $bff = str_replace(array("\t\t\t\t\t", "\t\t\t\t", "\t\t\t", "\t\t", "\t\n", "\n\t"), "", $bff);
        /* opening HTML tags */
        $bff = str_replace(array(">\r<a", ">\r <a", ">\r\r <a", "> \r<a", ">\n<a", "> \n<a", "> \n<a", ">\n\n <a"), "><a", $bff);
        $bff = str_replace(array(">\r<b", ">\n<b"), "><b", $bff);
        $bff = str_replace(array(">\r<d", ">\n<d", "> \n<d", ">\n <d", ">\r <d", ">\n\n<d"), "><d", $bff);
        $bff = str_replace(array(">\r<f", ">\n<f", ">\n <f"), "><f", $bff);
        $bff = str_replace(array(">\r<h", ">\n<h", ">\t<h", "> \n\n<h"), "><h", $bff);
        $bff = str_replace(array(">\r<i", ">\n<i", ">\n <i"), "><i", $bff);
        $bff = str_replace(array(">\r<i", ">\n<i"), "><i", $bff);
        $bff = str_replace(array(">\r<l", "> \r<l", ">\n<l", "> \n<l", ">  \n<l", "/>\n<l", "/>\r<l"), "><l", $bff);
        $bff = str_replace(array(">\t<l", ">\t\t<l"), "><l", $bff);
        $bff = str_replace(array(">\r<m", ">\n<m"), "><m", $bff);
        $bff = str_replace(array(">\r<n", ">\n<n"), "><n", $bff);
        $bff = str_replace(array(">\r<p", ">\n<p", ">\n\n<p", "> \n<p", "> \n <p"), "><p", $bff);
        $bff = str_replace(array(">\r<s", ">\n<s"), "><s", $bff);
        $bff = str_replace(array(">\r<t", ">\n<t"), "><t", $bff);
        /* closing HTML tags */
        $bff = str_replace(array(">\r</a", ">\n</a"), "></a", $bff);
        $bff = str_replace(array(">\r</b", ">\n</b"), "></b", $bff);
        $bff = str_replace(array(">\r</u", ">\n</u"), "></u", $bff);
        $bff = str_replace(array(">\r</d", ">\n</d", ">\n </d"), "></d", $bff);
        $bff = str_replace(array(">\r</f", ">\n</f"), "></f", $bff);
        $bff = str_replace(array(">\r</l", ">\n</l"), "></l", $bff);
        $bff = str_replace(array(">\r</n", ">\n</n"), "></n", $bff);
        $bff = str_replace(array(">\r</p", ">\n</p"), "></p", $bff);
        $bff = str_replace(array(">\r</s", ">\n</s"), "></s", $bff);
        /* other */
        $bff = str_replace(array(">\r<!", ">\n<!"), "><!", $bff);
        $bff = str_replace(array("\n<div"), " <div", $bff);
        $bff = str_replace(array(">\r\r \r<"), "><", $bff);
        $bff = str_replace(array("> \n \n <"), "><", $bff);
        $bff = str_replace(array(">\r</h", ">\n</h"), "></h", $bff);
        $bff = str_replace(array("\r<u", "\n<u"), "<u", $bff);
        $bff = str_replace(array("/>\r", "/>\n", "/>\t"), "/>", $bff);
    };

    /* common cases: whitespace */
    $bff = ereg_replace(" {2,}", ' ', $bff);
    $bff = ereg_replace("  {3,}", '  ', $bff);
    $bff = str_replace("> <", "><", $bff);
    $bff = str_replace("  <", "<", $bff);
    /* non-breaking spaces */
    $bff = str_replace(" &nbsp;", "&nbsp;", $bff);
    $bff = str_replace("&nbsp; ", "&nbsp;", $bff);

    // individual adjustments
    $bff = str_replace(array("name=\"select\" /><input"), "name=\"select\" /> <input", $bff);


    return $bff;
}

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////// METHODS 2
////////////////////////////////////////////////////////
// Function to seperate multiple tags one line
function fix_newlines_for_clean_html($fixthistext) { //neede for clean_html_code($uncleanhtml) 
    $fixthistext_array = explode("\n", $fixthistext);
    foreach ($fixthistext_array as $unfixedtextkey => $unfixedtextvalue) {
        //Makes sure empty lines are ignores
        if (!preg_match("/^(\s)*$/", $unfixedtextvalue)) {
            $fixedtextvalue = preg_replace("/>(\s|\t)*</U", ">\n<", $unfixedtextvalue);
            $fixedtext_array[$unfixedtextkey] = $fixedtextvalue;
        }
    }
    return implode("\n", $fixedtext_array);
}

function clean_html_code($uncleanhtml) {
    //Set wanted indentation
    $indent = " ";
    $uncleanhtml = stripwhitespace($uncleanhtml);

    //Uses previous function to seperate tags
    $fixed_uncleanhtml = fix_newlines_for_clean_html($uncleanhtml);
    $uncleanhtml_array = explode("\n", $fixed_uncleanhtml);
    //Sets no indentation
    $indentlevel = 0;
    foreach ($uncleanhtml_array as $uncleanhtml_key => $currentuncleanhtml) {
        //Removes all indentation
        $currentuncleanhtml = preg_replace("/\t+/", "", $currentuncleanhtml);
        $currentuncleanhtml = preg_replace("/^\s+/", "", $currentuncleanhtml);

        $replaceindent = "";

        //Sets the indentation from current indentlevel
        for ($o = 0; $o < $indentlevel; $o++) {
            $replaceindent .= $indent;
        }

        //If self-closing tag, simply apply indent
        if (preg_match("/<(.+)\/>/", $currentuncleanhtml)) {
            $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
        }
        //If doctype declaration, simply apply indent
        else if (preg_match("/<!(.*)>/", $currentuncleanhtml)) {
            $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
        }
        //If opening AND closing tag on same line, simply apply indent
        else if (preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && preg_match("/<\/(.*)>/", $currentuncleanhtml)) {
            $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
        }
        //If closing HTML tag or closing JavaScript clams, decrease indentation and then apply the new level
        else if (preg_match("/<\/(.*)>/", $currentuncleanhtml) || preg_match("/^(\s|\t)*\}{1}(\s|\t)*$/", $currentuncleanhtml)) {
            $indentlevel--;
            $replaceindent = "";
            for ($o = 0; $o < $indentlevel; $o++) {
                $replaceindent .= $indent;
            }

            $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
        }
        //If opening HTML tag AND not a stand-alone tag, or opening JavaScript clams, increase indentation and then apply new level
        else if ((preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && !preg_match("/<(link|meta|base|br|img|hr)(.*)>/", $currentuncleanhtml)) || preg_match("/^(\s|\t)*\{{1}(\s|\t)*$/", $currentuncleanhtml)) {
            $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;

            $indentlevel++;
            $replaceindent = "";
            for ($o = 0; $o < $indentlevel; $o++) {
                $replaceindent .= $indent;
            }
        } else {
            //Else, only apply indentation
            $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
        }
    }
    //Return single string seperated by newline
    return implode("\n", $cleanhtml_array);
}

////////////////////////////////////////////////////////
////////////// METHODS SELECT
////////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// simple but effective,  this file required  if require() ;)
//ob_start('stripwhitespace'); // METHOD 1
///////////////////////////////////////////////////////
// ALTERNATE FUNCTIONS
ob_start('clean_html_code'); // METHOD 2
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// METHOD 3
// requires package HTMLPurifier
////////////////////////////////////////////////////////

function page_finish($dirty_html) {
    //require_once('lib/htmlpurifier-4.1.0/HTMLPurifier.auto.php');
    $config = HTMLPurifier_Config::createDefault();
    $config->set('Core.Encoding', 'utf-8'); // replace with your encoding
    $config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype
    $purifier = new HTMLPurifier($config);
    $html = $purifier->purify($dirty_html);
    return $html;
}

//ob_start('page_finish'); 
///////////////////////////////////////////////////////
// Tidy
function htmlrepair($html) {
    // HTML Tidy Specify configuration
    $config = array(
        'indent' => true,
        'output-xhtml' => true,
        'wrap' => 200,
        'language' => 'de',
        'add-xml-decl' => true,
        'doctype' => 'transitional',
        'preserve-entities' => true
    );
    error_reporting(E_ALL);
    $tidy = new tidy;
    $tidy->parseString($html, $config, 'utf8');
    $tidy->cleanRepair();
    //echo $tidy->errorBuffer;
    return $tidy . "<code>" . $tidy->errorBuffer;
}

//ob_start('htmlrepair');
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////

