<?php 
$wapl = new WordPressWapl;
if(!$searchtitle = get_option('architect_search_boxtitletext'))
{
	$searchtitle = 'Search';
}
$waplString = $wapl->chunk('words', array('class' => 'search', 'display_as' => 'h3', 'quick_text' => stripslashes($searchtitle)));

if(!$submittitle = get_option('architect_search_boxsubmittext'))
{
	$submittitle = 'submit';
}
$waplString .= $wapl->form(array('class' => 'search', 'action' => get_settings('home'), 
	'children' => array
	(
		's' => array('tag' => 'formItem', 'options' => array('item_type' => 'text', 'name' => 's')),
		'search' => array('tag' => 'formItem', 'options' => array('item_type' => 'submit', 'name' => 'search', 'label' => $submittitle))
	)
));
return $waplString;
?>