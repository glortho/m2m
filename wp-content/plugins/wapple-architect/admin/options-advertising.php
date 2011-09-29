<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Show AdMob ad
	if(architect_save_option('architect_advertising_admob')) $updateOption = true;
	// AdMob Advert location
	if(architect_save_option('architect_advertising_admob_location')) $updateOption = true;
	// AdMob Advert header
	if(architect_save_option('architect_advertising_admob_header')) $updateOption = true;
	// Admob Site ID
	if(architect_save_option('architect_advertising_admob_site_id')) $updateOption = true;
	// Admob iPhone Site ID
	if(architect_save_option('architect_advertising_admob_iphone_site_id')) $updateOption = true;
	// Admob iPhone background colour
	if(architect_save_option('architect_advertising_admob_iphone_bg_colour')) $updateOption = true;
	// Admob iPhone text colour
	if(architect_save_option('architect_advertising_admob_iphone_text_colour')) $updateOption = true;
	// Show Google AdSense ad
	if(architect_save_option('architect_advertising_adsense')) $updateOption = true;
	// Google AdSense location
	if(architect_save_option('architect_advertising_adsense_location')) $updateOption = true;
	// Google AdSense Channel ID
	if(architect_save_option('architect_advertising_adsense_channel_id')) $updateOption = true;
	// Google AdSense Client ID
	if(architect_save_option('architect_advertising_adsense_client_id')) $updateOption = true;
	// Google AdSense Items Per Page
	if(architect_save_option('architect_advertising_adsense_items_per_page')) $updateOption = true;
	// Google AdSense Border Colour	
	if(architect_save_option('architect_advertising_adsense_col_border')) $updateOption = true;
	// Google AdSense Background Colour	
	if(architect_save_option('architect_advertising_adsense_col_bg')) $updateOption = true;
	// Google AdSense Link Colour
	if(architect_save_option('architect_advertising_adsense_col_link')) $updateOption = true;
	// Google AdSense Text Colour
	if(architect_save_option('architect_advertising_adsense_col_text')) $updateOption = true;
	// Google AdSense URL Colour
	if(architect_save_option('architect_advertising_adsense_col_url')) $updateOption = true;
}

if(isset($updateOption) && $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-advertising" enctype="multipart/form-data">';
	echo architect_admin_header('2', 'Wapple Architect Stats &amp; Advertising Settings');
} else
{	
	echo '<h3>Stats &amp; Advertising Settings</h3>';
}

echo architect_table_start();

// How many mobile page views
$devkey = get_option('architect_devkey');
if($devkey)
{
	/*
	$c = curl_init();
	$url = 'http://webservices.wapple.net/getMobileUsage.php?devKey='.$devkey.'&start='.date("Y-m-d").'&end='.date("Y-m-d", strtotime("-1 month"));
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	$result = simplexml_load_string(curl_exec($c));
	curl_close($c);
	
	echo architect_admin_header('4', 'Mobile Stats');
	echo '<p>In the past month, you have had '.(trim($result->getMarkupFromUrl)+trim($result->getMarkupFromWapl)).' mobile page impressions</p>';
	*/
}

$locationoptions = array(
	'0' => 'None',
	'top' => 'Top of site', 
	'belowheader' => 'Below header',
	'belowmenu' => 'Below menu',
	'belowposts' => 'After post (or posts on homepage)',
	'bottom' => 'Bottom of site'
);

echo '<p><img src="'.ARCHITECT_URL.'admin/ad_mob_logo_header.gif" alt="AdMob" /></p>';

// Show AdMob advert
echo architect_admin_option('select', array('label' => 'Show AdMob Ad', 'name' => 'architect_advertising_admob', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_advertising_admob'), 'description' => 'Show an AdMob advert'));
// AdMob location
echo architect_admin_option('select', array('label' => 'Admob Ad location', 'name' => 'architect_advertising_admob_location', 'options' => $locationoptions, 'value' => get_option('architect_advertising_admob_location'), 'description' => 'Where to place your AdMob advert'));
// Show AdMob "Advert" header
echo architect_admin_option('select', array('label' => 'Show AdMob Ad Header', 'name' => 'architect_advertising_admob_header', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_advertising_admob_header'), 'description' => 'Show "Advert" above your advert'));
// Admob Site ID
echo architect_admin_option('input', array('label' => 'AdMob Mobile Publisher ID', 'name' => 'architect_advertising_admob_site_id', 'value' => get_option('architect_advertising_admob_site_id'), 'description' => 'This is the Publisher ID supplied to you by Admob'));
// Admob iPhone Site ID
echo architect_admin_option('input', array('label' => 'AdMob Mobile iPhone Publisher ID', 'name' => 'architect_advertising_admob_iphone_site_id', 'value' => get_option('architect_advertising_admob_iphone_site_id'), 'description' => 'This is the Publisher ID for iPhone\'s supplied to you by Admob'));
// Admob iPhone background colour
echo architect_admin_option('input', array('label' => 'AdMob iPhone BG Colour', 'size' => 6, 'name' => 'architect_advertising_admob_iphone_bg_colour', 'value' => get_option('architect_advertising_admob_iphone_bg_colour'), 'before' => '#', 'description' => 'Specify a background color for adverts when displayed on an iPhone'));
// Admob iPhone text colour
echo architect_admin_option('input', array('label' => 'AdMob iPhone Text Colour', 'size' => 6, 'name' => 'architect_advertising_admob_iphone_text_colour', 'value' => get_option('architect_advertising_admob_iphone_text_colour'), 'before' => '#', 'description' => 'Specify a text color for adverts when displayed on an iPhone'));
echo '</table>';

echo '<p><img src="'.ARCHITECT_URL.'admin/adsense_logo.gif" alt="Google AdSense" /></p>';
echo architect_table_start();
// Show Google AdSense advert
echo architect_admin_option('select', array('label' => 'Show AdSense Ad', 'name' => 'architect_advertising_adsense', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_advertising_adsense'), 'description' => 'Show a Google AdSense advert'));
// Google AdSense location
echo architect_admin_option('select', array('label' => 'AdSense Ad location', 'name' => 'architect_advertising_adsense_location', 'options' => $locationoptions, 'value' => get_option('architect_advertising_adsense_location'), 'description' => 'Where to place your Google AdSense advert'));
// Google AdSense Channel ID
echo architect_admin_option('input', array('label' => 'AdSense Channel ID', 'name' => 'architect_advertising_adsense_channel_id', 'value' => get_option('architect_advertising_adsense_channel_id'), 'description' => 'The Google AdSense channel ID to serve ads from'));
// Google AdSense Client ID
echo architect_admin_option('input', array('label' => 'AdSense Client ID', 'name' => 'architect_advertising_adsense_client_id', 'value' => get_option('architect_advertising_adsense_client_id'), 'description' => 'Your Google AdSense client ID'));
// Google AdSense Items Per Page
echo architect_admin_option('input', array('label' => 'AdSense Items Per Page', 'name' => 'architect_advertising_adsense_items_per_page', 'value' => get_option('architect_advertising_adsense_items_per_page'), 'description' => 'The number of ads to display. Set to 1 for a single layout mode, or 2 for a double layout. No other values are accepted.'));
// Google AdSense Border Colour
echo architect_admin_option('input', array('label' => 'AdSense Border Colour', 'size' => 6, 'name' => 'architect_advertising_adsense_col_border', 'value' => get_option('architect_advertising_adsense_col_border'), 'before' => '#', 'description' => 'A hexidecimal colour code for the border colour of the ad'));
// Google AdSense Background Colour
echo architect_admin_option('input', array('label' => 'AdSense Background Colour', 'size' => 6, 'name' => 'architect_advertising_adsense_col_bg', 'value' => get_option('architect_advertising_adsense_col_bg'), 'before' => '#', 'description' => 'A hexidecimal colour code for the background colour of the ad'));
// Google AdSense Link Colour
echo architect_admin_option('input', array('label' => 'AdSense Link Colour', 'size' => 6, 'name' => 'architect_advertising_adsense_col_link', 'value' => get_option('architect_advertising_adsense_col_link'), 'before' => '#', 'description' => 'A hexidecimal colour code for the colour of links on the ad'));
// Google AdSense Text Colour
echo architect_admin_option('input', array('label' => 'AdSense Text Colour', 'size' => 6, 'name' => 'architect_advertising_adsense_col_text', 'value' => get_option('architect_advertising_adsense_col_text'), 'before' => '#', 'description' => 'A hexidecimal colour code for the colour of text on the ad'));
// Google AdSense URL Colour
echo architect_admin_option('input', array('label' => 'AdSense URL Colour', 'size' => 6, 'name' => 'architect_advertising_adsense_col_url', 'value' => get_option('architect_advertising_adsense_col_url'), 'before' => '#', 'description' => 'A hexidecimal colour code for the colour of urls on the ad'));

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}
?>