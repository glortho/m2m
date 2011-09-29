<?php
/*
Plugin Name: Transpose Email
Version: 1.3
Plugin URI: http://ajaydsouza.com/wordpress/plugins/transpose-email-plugin/
Description: Keeps your email safe from spammers when you want to use mailto: links.
Author: Ajay D'Souza 
Author URI: http://ajaydsouza.com/
*/

if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");

// Pre-2.6 compatibility
if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
// Guess the location
$transpose_path = WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__));
$transpose_url = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__));

function ald_transpose_email()
{
	global $transpose_url;
?>

<script type="text/javascript" src="<?php echo $transpose_url?>/ald-transpose-email.js"></script>

<?php
}


//add action when the head is written
add_action('wp_head', 'ald_transpose_email');

?>