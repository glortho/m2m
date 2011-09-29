<?php
echo '<div class="wrap">';
architect_table_start();
echo architect_admin_header('2', 'Wapple Architect Plugin Status');

// Architect Errors
$errors = false;

// How many mobile page views
$devkey = get_option('architect_devkey');
if($devkey == '' OR !$devkey)
{
	$errors = true;
	echo '<div class="updated architectInitError"><p><strong>You haven\'t saved your free Wapple Architect Dev Key, get one from here: <a href="http://wapple.net/register/plugins-signup.htm" target="_blank">http://wapple.net/register/plugins-signup.htm</a></strong>. Once you have it, enter it in the <a href="admin.php?page=architect-basic">Wapple Architect Basic Settings page</a></p></div>';
}
if(!function_exists('simplexml_load_string'))
{
	$errors = true;
	echo '<div class="updated architectInitError"><p>You do not have simpleXML installed, this plugin needs simpleXML in order to parse XML returned from Wapple\'s web services</p></div>';
}

$c = curl_init();
$url = 'http://webservices.wapple.net/getMobileUsage.php?devKey='.$devkey.'&start='.date("Y-m-d", strtotime("-1 month")).'&end='.date("Y-m-d");
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$statsresult = simplexml_load_string(curl_exec($c));
curl_close($c);
	
if(isset($statsresult->exceeded) AND $statsresult->exceeded == 2)
{
	echo '<div class="updated fade"><p>You have exceeded the max number of API requests this month, please <a href="http://dashboard.wapple.net/account/upgrade" target="_blank">upgrade your account</a> to continue.</p></div>';
}

if(isset($_COOKIE['architectError']))
{
	$errors = true;
	echo '<div class="updated architectInitError"><p>Error initializing mobile version: '.$_COOKIE['architectError'].'</p></div>';
}
	
if(!$errors)
{
	echo '<div class="updated fade"><p>The Wapple Architect Plugin is working correctly!</p></div>'; 
}

$twitterLink = 'http://twitter.com/mobilewebjunkie';
echo '
<div class="architectclearfix">
	<div class="architectArea">
		<h3>Donate</h3>
		<p>If you like this plugin and use it to mobilize your blog, keep it Ad free and in a constant state of development by clicking the <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9077801" target="_blank">donate</a> button.<p>  
		<p>We\'re on twitter too, so don\'t forget to <a href="'.$twitterLink.'">follow us</a> on there!</p>
		<a target="_blank" title="Donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9077801">
			<img class="small" src="'.ARCHITECT_URL.'admin/donate.png" alt="Donate with Paypal" />
		</a>
		<a title="Follow us on Twitter" href="'.$twitterLink.'">
			<img class="small" src="'.ARCHITECT_URL.'admin/follow.png" alt="Follow Us on Twitter" />
		</a>
	</div>
	<div class="architectArea">
		<h3>WordPress Mobile Admin</h3>
		<a href="plugin-install.php?tab=search&type=term&s=wordpress+mobile+admin+wapple"><img class="title" src="'.ARCHITECT_URL.'admin/WMA.png" alt="WordPress Mobile Admin" title="WordPress Mobile Admin" /></a>
		<p>Did you know that you can use your Wapple dev key to mobilize your WordPress control panel? By doing so you can write posts from your 
		mobile as well as moderating comments and performing basic post/page/comment management.</p>
		<p>Download it from <a href="http://wordpress.org/extend/plugins/wordpress-mobile-admin/">http://wordpress.org/extend/plugins/wordpress-mobile-admin/</a> or
		jump straight to the <a href="plugin-install.php?tab=search&type=term&s=wordpress+mobile+admin+wapple">Plugin Install Page</a>
	</div>
</div>';

// Link to pre-built mobile themes if using a custom theme
if(get_option('architect_theme') == 'custom')
{
    echo '<div class="architectNotice">Looks like you\'re using a custom theme - did you know you can use one of our pre-built themes? Head to the <a href="admin.php?page=architect-theme">Mobile Theme</a> page to check them out!</div>';
}

// How many mobile page views
if($devkey)
{
	echo '<h3>Statistics</h3>';

	echo '<p>Mobile Page Impressions</p>';
	
	
	
	echo '<p><strong>Last month:</strong> '.number_format(trim($statsresult->getMarkupFromUrl)+trim($statsresult->getMarkupFromWapl)).'</p>';
	        
	$c = curl_init();
	$url = 'http://webservices.wapple.net/getMobileUsage.php?devKey='.$devkey.'&start='.date("Y-m-d", strtotime("-1 year")).'&end='.date("Y-m-d");
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	$result = simplexml_load_string(curl_exec($c));
	curl_close($c);

	echo '<p><strong>Last year:</strong> '.number_format(trim($result->getMarkupFromUrl)+trim($result->getMarkupFromWapl)).'</p>';
	
	echo '<p>Note that statistics are not real time and get updated once a day - some time around midnight GMT</p>';
}

echo '<h3>Information</h3>';

$fp = fopen(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'architect.php', 'r');
// Pull only the first 8kiB of the file in.
$plugin_data = fread($fp, 8192);
// PHP will close file handle, but we are good citizens.
fclose($fp);

preg_match('|Version:(.*)|i', $plugin_data, $architectVersion);
preg_match('|Latest Changes:(.*)$|mi', $plugin_data, $architectChanges);
preg_match('|Coming Soon:(.*)$|mi', $plugin_data, $architectComingSoon);

echo '<p><strong>Plugin</strong>: Wapple Architect</p>';
echo '<p><strong>Version</strong>: '.$architectVersion[1].'</p>';
echo '<p><strong>Latest Changes</strong>: ';
echo '<ul class="architectList">';

foreach(explode('|', $architectChanges[1]) as $val)
{
	if($val && trim($val) != '') echo '<li>'.$val.'</li>';
}

echo '</ul></p>';
echo '<p><strong>Coming Soon</strong>: ';
echo '<ul class="architectList">';

foreach(explode('|', $architectComingSoon[1]) as $val)
{
	if($val && trim($val) != '') echo '<li>'.$val.'</li>';
}
echo '</ul>';
echo '<p>Read more at the official <a href="http://wordpress.org/extend/plugins/wapple-architect/">Wapple Architect WordPress Home Page</a></p>';

echo '<h3>Credits</h3>';
echo '<p>Without the following people, this plugin wouldn\'t function, or look as nice, or do much really, so a big thankyou to you all!';
echo '<ul class="architectList credits">';
echo '<li><label>Graphics and Themes:</label> <a href="http://ryandc.co.uk">Ryan DC</a> <a href="http://ryandc.co.uk"><img src="'.ARCHITECT_URL.'/admin/ryandc.jpg" alt="http://ryandc.co.uk" title="http://ryandc.co.uk" style="position:relative;top:10px;" /></a></li>';
echo '<li><label>HTML Parsing: </label><a href="http://sourceforge.net/projects/simplehtmldom/">Simple HTML DOM Parser</a> by S.C. Chen</li>';
echo '<li><label>Compatibility: </label><a href="http://phpclasses.2by2host.com/browse/package/4484.html">SimpleXML for PHP4</a> by Taha Paksu</li>';
echo '<li><label>Themes: </label><a href="http://erikshosting.com">Erik Petterson</a></li>';
echo '</ul>';
echo '<p>&nbsp;</p>';
echo '</table></div>';
?>
