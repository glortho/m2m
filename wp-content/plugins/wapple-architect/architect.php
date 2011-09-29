<?php
/*
Plugin Name: Wapple Architect
Plugin URI: http://mobilewebjunkie.com/wordpress-mobile-plugin-install-guide-and-faq/
Description: Wapple Architect Mobile Plugin for Wordpress is a plugin that allows you to mobilize your blog in minutes. After activating this plugin visit <a href="admin.php?page=architect-basic">the settings page</a> and enter your Wapple Architect Dev Key | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9077801" target="_blank">Donate</a>
Author: Rich Gubby
Version: 3.9.3
Author URI: http://mobilewebjunkie.com/author/richg
Latest Changes: <span class="new">New! Compatibility with SmartPhone Location Lookup</span>|Sidebar functionality|Mobile Stats|Brand new mobile iphone themes added|Turn your mobile blog into a money making opportunity with Mobile Advertising
Coming Soon: Support for Google Analytics|Support for All in One SEO Pack|Support for Google Maps
*/

// Added support for WP Super Cache
if(function_exists('add_cacheaction'))
{
	add_cacheaction('add_cacheaction', 'architectWPSuperCache');
	if(!function_exists('architectWPSuperCache'))
	{
		function architectWPSuperCache($string)
		{
			global $cache_rejected_uri;
			$cache_rejected_uri[] = $_SERVER["REQUEST_URI"];
		}
	}
}

// Start output buffering
ob_start();

// Debug level
if(!defined('ARCHITECT_DEBUG'))
	define('ARCHITECT_DEBUG', false);

if(!function_exists('get_wapl_plugin_base'))
{
	/**
	 * Get the name of the plugin folder - different on whichever way you install
	 * Must be in this file so it returns the right value
	 * @access public
	 * @return string
	 */
	function get_wapl_plugin_base()
	{
		return $base = substr(dirname(__FILE__), (strrpos(dirname(__FILE__), DIRECTORY_SEPARATOR)+1), strlen(dirname(__FILE__)));
	}
}

if(!defined('ARCHITECT_URL'))
	define('ARCHITECT_URL', WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/');
if(!defined('ARCHITECT_DIR'))
	define('ARCHITECT_DIR', WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base());
	
if(!function_exists('add_architect_options_page'))
{
	function add_architect_options_page()
	{
		if(get_bloginfo('version') < '2.3')
		{
			add_options_page('Wapple Architect Settings', 'Wapple Architect', 8, basename(__FILE__), 'architect_options_page');
		} else
		{
			add_menu_page('Wapple Architect', 'Architect', 'administrator', 'architect-status', 'architect_options_status', WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/admin/architect.png');
			
			add_submenu_page('architect-status', 'Wapple Architect Status', 'Status', 'administrator', 'architect-status', 'architect_options_status');
			add_submenu_page('architect-status', 'Wapple Architect Basic Settings', 'Basic', 'administrator', 'architect-basic', 'architect_options_basic');
			add_submenu_page('architect-status', 'Wapple Architect Advanced Settings', 'Advanced', 'administrator', 'architect-advanced', 'architect_options_advanced');
			add_submenu_page('architect-status', 'Wapple Architect Advertising Settings', 'Mobile Advertising', 'administrator', 'architect-advertising', 'architect_options_advertising');
			add_submenu_page('architect-status', 'Wapple Architect Home Page Settings', 'Home Page', 'administrator', 'architect-home', 'architect_options_home');
			add_submenu_page('architect-status', 'Wapple Architect Home Page by Category Settings', 'Home Page by Category', 'administrator', 'architect-homebycat', 'architect_options_homebycat');
			add_submenu_page('architect-status', 'Wapple Architect Posts Settings', 'Posts Page', 'administrator', 'architect-posts', 'architect_options_posts');
			add_submenu_page('architect-status', 'Wapple Architect Pages Settings', 'Pages', 'administrator', 'architect-pages', 'architect_options_pages');
			add_submenu_page('architect-status', 'Wapple Architect Archives Page Settings', 'Archives Pages', 'administrator', 'architect-archives', 'architect_options_archives');
			add_submenu_page('architect-status', 'Wapple Architect Search Page Settings', 'Search', 'administrator', 'architect-search', 'architect_options_search');
			add_submenu_page('architect-status', 'Wapple Architect Sidebar Settings', 'Sidebar', 'administrator', 'architect-sidebar', 'architect_options_sidebar');
			add_submenu_page('architect-status', 'Wapple Architect Theme Settings', 'Mobile Theme', 'administrator', 'architect-theme', 'architect_options_theme');
		}
	}
}
if(!function_exists('architect_register_head'))
{
	function architect_register_head()
	{
		$url = WP_PLUGIN_URL.'/'.get_wapl_plugin_base() . '/admin/architect.css';
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$url."\" />\n";	
	}
}

// Load some functions
require_once('admin'.DIRECTORY_SEPARATOR.'globalfunctions.php');
if(is_admin())
{
	require_once('admin'.DIRECTORY_SEPARATOR.'functions.php');
	if(!function_exists('simplexml_load_string') || (get_option('architect_devkey') == '' OR !get_option('architect_devkey')))
	{
		if(!function_exists('ArchitectInitError'))
		{
			function ArchitectInitError()
			{
				if(!isset($_REQUEST['page']) OR (isset($_REQUEST['page']) AND $_REQUEST['page'] != 'architect.php'))
				{
					echo '<div class="updated architectInitError"><p>There was a problem initializing the Wapple Architect mobile plugin, please check <a href="admin.php?page=architect-status">the Wapple Architect settings page</a> for more information</p></div>';
				}
			}
		}
	}
} else if(!isset($wappleArchitectLoadOverride) || $wappleArchitectLoadOverride == false)
{
	require_once('admin'.DIRECTORY_SEPARATOR.'mobilefunctions.php');
	require_once('theme'.DIRECTORY_SEPARATOR.'functions.php');
}

// Register some hooks
if(is_admin())
{
	// Add architect options to admin menu
	add_action('admin_menu', 'add_architect_options_page');
	// Add notice to WordPress if we have an architect error
	if(function_exists('ArchitectInitError'))
	{
		add_action('admin_head','ArchitectInitError');
	}
	
	// Register activation
	register_activation_hook(__FILE__, 'architect_install');
	
	// Add link to settings page
	add_filter('plugin_row_meta', 'architect_filter_plugin_links', 10, 2);
	
	// Load architect admin CSS style sheet
	add_action('admin_head', 'architect_register_head');
	
	// Add additional links to plugin page
	add_filter('plugin_action_links', 'architect_plugin_action_links', 10, 2 );
} else
{
	// Add the deviceDetection function to the template_redirect filter
	add_action('template_redirect', 'deviceDetection');
	
	// Add switcher to the bottom of web pages
	if(get_option('architect_showswitchtodesktop'))
	{
		add_action('wp_footer', 'architect_web_footer');
	}
}

?>
