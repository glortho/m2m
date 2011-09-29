<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */
include_once('functions.php');
$waplString = get_wapl_header();
$wapl = new WordPressWapl;

$waplString .= get_wapl_element('search_box');

if(!$text = get_option('architect_archive_monthtext'))
{
	$text = 'Archives by Month:';	
}
$waplString .= $wapl->chunk('words', array('class' => 'entry_row archiveTitle', 'display_as' => 'h2', 'quick_text' => $text));

$archives =  preg_split('/<li(.*?)>/', wp_get_archives('type=monthly&echo=0'));

foreach($archives as $val)
{
	preg_match_all('/<a(.*?)href=["|\'](.*?)["|\'](.*?)>(.*?)<\/a>/is', $val, $matches);
	
	if(isset($matches[2][0]) && $matches[2][0] != '')
	{
		$waplString .= $wapl->link(array('class' => 'entry_row archiveMonth', 'url' => htmlspecialchars($matches[2][0]), 'label' => stripslashes(architectCharsOther($matches[4][0]))));
	}
}

if(!$text = get_option('architect_archive_subjecttext'))
{
	$text = 'Archives by Subject:';	
}

$waplString .= $wapl->chunk('words', array('class' => 'entry_row archiveTitle', 'display_as' => 'h2', 'quick_text' => $text));
$cats = get_categories(array('echo' => 0));
if(!empty($cats))
{
	foreach($cats as $cat)
	{
		$waplString .= $wapl->link(array('class' => 'entry_row archiveCategory', 'label' => $cat->name, 'url' => htmlspecialchars(get_category_link( $cat->term_id ))));
	}
}

$waplString .= get_wapl_footer();
process_wapl($waplString);
?>