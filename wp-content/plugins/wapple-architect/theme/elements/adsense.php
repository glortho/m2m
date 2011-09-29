<?php

$channelId = get_option('architect_advertising_adsense_channel_id');
$clientId = get_option('architect_advertising_adsense_client_id');

if($channelId && $clientId)
{
	$string .= '<adsenseChunk class="entry_row mobileAdvert adsense">';
	$string .= '<channel_id>'.$channelId.'</channel_id>';
	$string .= '<client_id>'.$clientId.'</client_id>';
	
	if($items = get_option('architect_advertising_adsense_items_per_page')) $string .= '<items_per_page>'.$items.'</items_per_page>';
	if($colBorder = get_option('architect_advertising_adsense_col_border')) $string .= '<col_border>'.$colBorder.'</col_border>';
	if($colBg = get_option('architect_advertising_adsense_col_bg')) $string .= '<col_bg>'.$colBg.'</col_bg>';
	if($colLink = get_option('architect_advertising_adsense_col_link')) $string .= '<col_link>'.$colLink.'</col_link>';
	if($colText = get_option('architect_advertising_adsense_col_text')) $string .= '<col_text>'.$colText.'</col_text>';
	if($colUrl = get_option('architect_advertising_adsense_col_url')) $string .= '<col_url>'.$colUrl.'</col_url>';
	
	$string .= '</adsenseChunk>';
}
?>