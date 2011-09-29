<?php
/*
Plugin Name: WP-Slimbox2
Plugin URI: http://transientmonkey.com/wp-slimbox2
Description: A Wordpress implementation of the Slimbox2 javascript, utilizing jQuery, originally written by Christophe Beyls. Requires WP 2.6+
Author: Greg Yingling (malcalevak)
Version: 1.0.3.2
Author URI: http://transientmonkey.com/

Copyright 2010 Transient Monkey, LLC

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( !class_exists('WPlize') ) {
	require_once('WPlize/WPlize.php');
}

load_plugin_textdomain ('wp-slimbox2', WP_PLUGIN_DIR.'/wp-slimbox2/languages', '/wp-slimbox2/languages');
add_action('wp_print_scripts', 'wp_slimbox_scripts');
add_action('wp_print_styles', 'wp_slimbox_styles');
register_activation_hook( __FILE__, 'wp_slimbox_activate' );

function wp_slimbox_activate() {
	$options = new WPlize('wp_slimbox');
	require('initialize.php');
	if(file_exists( WP_PLUGIN_DIR.'/wp-slimbox2/statTrack.php')){
		require_once('statTrack.php');
		statTrack();
	}
}



function wp_slimbox_styles() {
	$options = new WPlize('wp_slimbox');
	wp_register_style('slimbox2', WP_PLUGIN_URL.'/wp-slimbox2/slimbox2.css','','1.1','screen');
	wp_enqueue_style('slimbox2');
	if(__('LTR', 'wp-slimbox2')=='RTL') {
		wp_register_style('slimbox2-RTL', WP_PLUGIN_URL.'/wp-slimbox2/slimbox2-rtl.css','','1.0','screen');
		wp_enqueue_style('slimbox2-RTL');
	}
	wp_register_script('slimbox2', WP_PLUGIN_URL.'/wp-slimbox2/javascript/slimbox2.js',array('jquery'), '2.04');
	wp_register_script('slimbox2_autoload', WP_PLUGIN_URL.'/wp-slimbox2/javascript/slimbox2_autoload.js',array('slimbox2'),$options->get_option('cache'));//add option for version number, update with each save
	wp_register_script('jquery_easing', WP_PLUGIN_URL.'/wp-slimbox2/javascript/jquery.easing.1.3.js',array('jquery'), '1.3');
}
function wp_slimbox_scripts() {
	$options = new WPlize('wp_slimbox');
	if (!is_admin())
	{
		if($options->get_option('maintenance') == 'on') {
			if (isset($_REQUEST['slimbox'])) setcookie('slimboxC',$_REQUEST['slimbox'],0,'/');
			if ($_REQUEST['slimbox'] == 'off' OR (!isset($_REQUEST['slimbox']) AND $_COOKIE['slimboxC'] != 'on')) return;
		}
		if($options->get_option('resizeEasing') != 'swing') wp_enqueue_script('jquery_easing');
		wp_enqueue_script('slimbox2_autoload');
		$captions = $options->get_option('caption');
		$caption = '';
		for ($i = 0; $i<4; $i++) {
			switch ($captions[$i]) {
				case 'a-title':
					$caption .= 'el.title';
					break;
				case 'img-alt':
					$caption .= 'el.firstChild.alt';
					break;
				case 'img-title':
					$caption .= 'el.firstChild.title';
					break;
				case 'href':
					$caption .= 'el.href';
					break;
				default:
					$caption .= "' '";
			}
			$caption .= ' || ';
		}
		$caption .= 'el.href';
		wp_localize_script( 'slimbox2_autoload', 'slimbox2_options', array(
			'autoload' => (($options->get_option('autoload') == 'on')?true:false),
			'overlayColor' => $options->get_option('overlayColor'),
			'loop' => (($options->get_option('loop') == 'on')?true:false),
			'overlayOpacity' => $options->get_option('overlayOpacity'),
			'overlayFadeDuration' => $options->get_option('overlayFadeDuration'),
			'resizeDuration' => $options->get_option('resizeDuration'),
			'resizeEasing' => $options->get_option('resizeEasing'),
			'initialWidth' => $options->get_option('initialWidth'),
			'initialHeight' => $options->get_option('initialHeight'),
			'imageFadeDuration' => $options->get_option('imageFadeDuration'),
			'captionAnimationDuration' => $options->get_option('captionAnimationDuration'),
			'caption' => $caption,
			'url' => (($options->get_option('url') == 'on')?true:false),
			'selector' => $options->get_option('selector'),
			'counterText' => $options->get_option('counterText'),
			'closeKeys' => $options->get_option('closeKeys'),
			'previousKeys' => $options->get_option('previousKeys'),
			'nextKeys' => $options->get_option('nextKeys'),
			'prev' => WP_PLUGIN_URL.'/wp-slimbox2/images/'.__('default/prevlabel.gif', 'wp-slimbox2'),
			'next' => WP_PLUGIN_URL.'/wp-slimbox2/images/'.__('default/nextlabel.gif', 'wp-slimbox2'),
			'close' => WP_PLUGIN_URL.'/wp-slimbox2/images/'.__('default/closelabel.gif', 'wp-slimbox2'),
			'picasaweb' => (($options->get_option('picasaweb') == 'on')?true:false),
			'flickr' => (($options->get_option('flickr') == 'on')?true:false),
			'mobile' => (($options->get_option('mobile') == 'on')?true:false)
		));
	}
}

add_action('admin_menu', 'show_slimbox_options');
add_action('admin_init', 'slimbox_admin_init');

function show_slimbox_options() {
	$page = add_options_page('WP-Slimbox2 Options', 'WP-Slimbox2', 8, 'slimbox2options', 'slimbox_options');
	add_action( "admin_print_scripts-$page", 'slimbox_adminhead' );
	add_action( "admin_print_styles-$page", 'slimbox_admin_styles' );
}

function slimbox_options() {
	$options = new WPlize('wp_slimbox');
	require('adminpage.php');
}

function slimbox_admin_init() {
	wp_register_style('farbtastic', WP_PLUGIN_URL.'/wp-slimbox2/javascript/farbtastic/farbtastic.css','','1.0','screen');
	wp_register_script('jquery_farbtastic', WP_PLUGIN_URL.'/wp-slimbox2/javascript/farbtastic/farbtastic.js',array('jquery'), '1.2');
	wp_register_script('load_farbtastic', WP_PLUGIN_URL.'/wp-slimbox2/javascript/farbtastic/load_farbtastic.js',array('jquery_farbtastic'), '1.0');
	wp_register_script('load_keypress', WP_PLUGIN_URL.'/wp-slimbox2/javascript/keypress.js',array('jquery'), '1.1');
}

function slimbox_admin_styles() {
	wp_enqueue_style('farbtastic');
}

function slimbox_adminhead() {
	wp_enqueue_script('load_farbtastic');
	wp_enqueue_script('load_keypress');
}
?>