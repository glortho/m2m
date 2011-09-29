<?php 
echo '<div class="wrap">';

// Architect Errors
if(get_option('architect_devkey') == '' OR !get_option('architect_devkey'))
{
	echo '<div class="updated architectInitError"><p><strong>You haven\'t saved your free Wapple Architect Dev Key, get one from here: <a href="http://wapple.net/register/free-developer-program-for-coding-mobile-web.htm">http://wapple.net/register/free-developer-program-for-coding-mobile-web.htm</a></strong></p></div>';
}
if(!function_exists('simplexml_load_string'))
{
	echo '<div class="updated architectInitError"><p>You do not have simpleXML installed, this plugin needs simpleXML in order to parse XML returned from Wapple\'s web services</p></div>';
}
if(isset($_COOKIE['architectError']))
{
	echo '<div class="updated architectInitError"><p>Error initializing mobile version: '.$_COOKIE['architectError'].'</p></div>';
}

echo '<form method="post" action="options-general.php?page=architect.php" enctype="multipart/form-data">';
echo architect_admin_header('2', 'Wapple Architect Settings Dashboard');

echo '<p><em>Wapple Architect WordPress plugin is brought to you by Rich Gubby - <a href="http://mobilewebjunkie.com">http://mobilewebjunkie.com</a></em></p>';

// Basic Settings
$oldVersion = true;
require_once('options-basic.php');

// Advanced Settings
require_once('options-advanced.php');

// Mobile Advertising
require_once('options-advertising.php');

// Home page settings
require_once('options-home.php');

// Build homepage by category settings
require_once('options-homecat.php');

// Posts Page Settings
require_once('options-posts.php');

// Pages Settings
require_once('options-pages.php');

// Archives Settings
require_once('options-archives.php');

// Search Results Settings
require_once('options-search.php');

// Sidebar Settings
require_once('options-sidebar.php');

// Mobile Theme Settings
require_once('options-theme.php');

echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
echo '</form></div>';
?>