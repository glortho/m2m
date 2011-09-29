<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */
include_once('functions.php');
$waplString = get_wapl_header();
$wapl = new WordPressWapl;

$waplString .= get_wapl_element('search_box');

if(!$text = get_option('architect_page_linktemplatetitle'))
{
	$text = 'Links:';	
}
$waplString .= $wapl->chunk('words', array('class' => 'entry_row linksTitle', 'display_as' => 'h2', 'quick_text' => $text));

$links =  preg_split('/<li(.*?)>/', wp_list_bookmarks('echo=0'));

foreach($links as $val)
{
	preg_match_all('/<a(.*?)href=["|\'](.*?)["|\'](.*?)>(.*?)<\/a>/is', $val, $matches);
	
	if(isset($matches[2][0]) && $matches[2][0] != '')
	{
		$waplString .= $wapl->link(array('class' => 'entry_row archiveMonth', 'url' => htmlspecialchars($matches[2][0]), 'label' => stripslashes(architectCharsOther($matches[4][0]))));
	}
}

$waplString .= get_wapl_footer();
process_wapl($waplString);
?>