<?php
/*
Plugin Name: Nice Tooltips
Plugin URI: http://bueltge.de/wp-bubble-tooltips-plugin/142/
Description: Nice Tooltips for Links.
Version: 2.1
Author: Frank Bueltge
Author URI: http://bueltge.de/
*/

/*
------------------------------------------------------
 ACKNOWLEDGEMENTS
------------------------------------------------------
Javascript for Bubble Tooltips is from Alessandro Fulciniti - http://pro.html.it - http://web-graphics.com
More informations to the script - http://web-graphics.com/mtarchive/001717.php

Javascript for Sweet Titles is from Dustin Diaz - http://www.dustindiaz.com/
More informations to the script - http://www.dustindiaz.com/sweet-titles/
/*

/*
------------------------------------------------------
INSTRUCTION:
------------------------------------------------------
1. Define the tooltip, bubble or sweet in line 35
2. Copy the folder with the php-, gif-, css- and the js-file in your Plugin-Folder (/wp-content/plugins/)
3. Activate this Plugin in the Admin-area
4. [Optional] Edit in line 37 of this php-File. You can change the ID of function the tooltip or
without ID - example without ID, for the complate site: {enableTooltips()};
with ID - example with ID content: {enableTooltips(\"content\")}.
*/


// Edit here, Define tooltip, 1 for Bubble Tooltips, 0 for Sweet Titles
$fbtt_bubble = '0';


// addload for bubble
function BubbleTooltips_addLoad()
{
	echo "\t<script type=\"text/javascript\">
	<!--
		function addLoadEvent_fb() {
			var fboldonload = window.onload;
			if (typeof window.onload != 'function'){
				window.onload = function(){
					enableTooltips()
				};
			} else {
				window.onload = function(){
					fboldonload();
					func();
				}
			}
		}

	addLoadEvent_fb(); //BubbleTooltips bei onLoad hinzufuegen

	//-->
	</script>\n";
	echo '<!-- /BubbleTooltips Plugin -->' . "\n";
}

// function for include bubble_js
function BubbleTooltips_header() {
	$tooltips_pluginpath = get_settings('home')."/wp-content/plugins/tooltips/";
	
	$BubbleTooltipsHead = "\t\n<!-- BubbleTooltips Plugin -->\n";
	$BubbleTooltipsHead.= "\t" . '<link rel="stylesheet" href="' . $tooltips_pluginpath . 'css/bt.css" type="text/css" media="screen" />' . "\n";
	$BubbleTooltipsHead.= "\t" . '<script type="text/javascript" src="' . $tooltips_pluginpath . 'js/BubbleTooltips.js"></script>' . "\n";
	print($BubbleTooltipsHead);
}

// function for include sweet_js
function SweetTitles_header() {
	$tooltips_pluginpath = get_settings('home')."/wp-content/plugins/tooltips/";
	// get_settings('siteurl')
	
	$SweetTitlesHead = "\t\n<!-- SweetTitlesTooltips Plugin -->\n";
	$SweetTitlesHead.= "\t" . '<link rel="stylesheet" href="' . $tooltips_pluginpath . 'css/sweetTitles.css" type="text/css" media="screen" />' . "\n";
	$SweetTitlesHead.= "\t" . '<script type="text/javascript" src="' . $tooltips_pluginpath . 'js/addEvent.js"></script>' . "\n";
	$SweetTitlesHead.= "\t" . '<script type="text/javascript" src="' . $tooltips_pluginpath . 'js/sweetTitles.js"></script>' . "\n";
	print($SweetTitlesHead);
}

// Include js in the <head>-area
if($fbtt_bubble == '1') {
	add_action('wp_head', 'BubbleTooltips_header');
	add_action('wp_head', 'BubbleTooltips_addLoad');
} else {
	add_action('wp_head', 'SweetTitles_header');
}
?>