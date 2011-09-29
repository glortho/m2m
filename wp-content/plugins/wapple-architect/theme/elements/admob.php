<?php
// Have we got a publisher ID
$publisherId = get_option('architect_advertising_admob_site_id');

if($publisherId)
{
	if(get_option('architect_advertising_admob_header'))
	{
		$string .= '<wordsChunk class="entry_row mobileAdvertHeader admob"><quick_text>Advert</quick_text></wordsChunk>';
	}
	$string .= '<admobChunk class="entry_row mobileAdvert admob">';
	$string .= '<mobile_site_id>'.$publisherId.'</mobile_site_id>';
	if($iphonePublisherId = get_option('architect_advertising_admob_iphone_site_id'))$string .= '<iphone_site_id>'.$iphonePublisherId.'</iphone_site_id>';
	if($iphoneBackgroundColour = get_option('architect_advertising_admob_iphone_bg_colour')) $string .= '<iphone_background_color>'.$iphoneBackgroundColour.'</iphone_background_color>';
	if($iphoneTextColour = get_option('architect_advertising_admob_iphone_text_colour')) $string .= '<iphone_text_color>'.$iphoneTextColour.'</iphone_text_color>';
	$string .= '</admobChunk>';
}
?>