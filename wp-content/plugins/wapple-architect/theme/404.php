<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */
include_once('functions.php');
$waplString = get_wapl_header();
$wapl = new WordPressWapl;

if($text = get_option('architect_advanced_404text'))
{
	$text = stripslashes($text);
} else
{
	$text = 'Error 404 - Not Found';
}
$waplString .= $wapl->chunk('words', array('class' => 'wa404 entry_row', 'display_as' => 'h2', 'quick_text' => $text));
$waplString .= get_wapl_footer();

process_wapl($waplString);
?>