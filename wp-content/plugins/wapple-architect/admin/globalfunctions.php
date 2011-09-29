<?php
/** 
 * Define some defaults - shouldn't need to change these
 * Defaults are now inserted into the DB at installation - these are left in for legacy versions
 */
// Width of images on the homepage
define('ARCHITECT_HOME_IMAGESCALE', 50);
// Quality of images on the homepage
define('ARCHITECT_HOME_IMAGEQUALITY', 95);
// Width of images on post pages
define('ARCHITECT_SINGLE_IMAGESCALE', 50);
// Quality of images on post pages
define('ARCHITECT_SINGLE_IMAGEQUALITY', 95);
// Width of images on designated pages
define('ARCHITECT_PAGE_IMAGESCALE', 50);
// Quality of images on designated pages
define('ARCHITECT_PAGE_IMAGEQUALITY', 95);
// Length of chars in post before a new page
define('ARCHITECT_SINGLE_PAGINGLENGTH', 2000);
// Force the mobile check to always return true
define('ARCHITECT_FORCE_MOBILE', false);
// List of non-scalable images
global $architectNoScaleImages;
$architectNoScaleImages = array('lightsocial_img', 'wp-smiley', 'sociable-hovers', 'rating_title', 'icon', 'rating', 'podcasticon', 'site-icon', 'sociable', 'sociablefirst');
// List of allowed image extensions
global $allowedImageExtensions; 
$allowedImageExtensions = array('jpg', 'bmp', 'gif', 'png');

if(ARCHITECT_DEBUG)
{
	error_reporting(E_ALL);
	ini_set('display_errors', true);
}

if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' ); // no trailing slash, full paths only - WP_CONTENT_URL is defined further down

if ( !defined('WP_PLUGIN_DIR') )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' ); // full path, no trailing slash

if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); // full url - WP_CONTENT_DIR is defined further up
	
if ( !defined('WP_PLUGIN_URL') )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' ); // full url, no trailing slash
	
if ( !defined('WP_UPLOAD_DIR') )
	define('WP_UPLOAD_DIR', WP_CONTENT_DIR . '/uploads' );
	
if(!function_exists('architectCharsAmp'))
{
	function architectCharsAmp($string)
	{
		return str_replace('&', '&#38;', $string);
	}
}

if(!function_exists('esc_attr'))
{
	function esc_attr($text)
	{
		$safe_text = wp_check_invalid_utf8( $text );
		$safe_text = _wp_specialchars( $safe_text, ENT_QUOTES );
		return apply_filters( 'attribute_escape', $safe_text, $text );
	}
}

if(!function_exists('_wp_specialchars'))
{
	function _wp_specialchars( $string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false ) {
		$string = (string) $string;
	
		if ( 0 === strlen( $string ) ) {
			return '';
		}
	
		// Don't bother if there are no specialchars - saves some processing
		if ( !preg_match( '/[&<>"\']/', $string ) ) {
			return $string;
		}
	
		// Account for the previous behaviour of the function when the $quote_style is not an accepted value
		if ( empty( $quote_style ) ) {
			$quote_style = ENT_NOQUOTES;
		} elseif ( !in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) ) {
			$quote_style = ENT_QUOTES;
		}
	
		// Store the site charset as a static to avoid multiple calls to wp_load_alloptions()
		if ( !$charset ) {
			static $_charset;
			if ( !isset( $_charset ) ) {
				$alloptions = wp_load_alloptions();
				$_charset = isset( $alloptions['blog_charset'] ) ? $alloptions['blog_charset'] : '';
			}
			$charset = $_charset;
		}
		if ( in_array( $charset, array( 'utf8', 'utf-8', 'UTF8' ) ) ) {
			$charset = 'UTF-8';
		}
	
		$_quote_style = $quote_style;
	
		if ( $quote_style === 'double' ) {
			$quote_style = ENT_COMPAT;
			$_quote_style = ENT_COMPAT;
		} elseif ( $quote_style === 'single' ) {
			$quote_style = ENT_NOQUOTES;
		}
	
		// Handle double encoding ourselves
		if ( !$double_encode ) {
			$string = wp_specialchars_decode( $string, $_quote_style );
			$string = preg_replace( '/&(#?x?[0-9a-z]+);/i', '|wp_entity|$1|/wp_entity|', $string );
		}
	
		$string = @htmlspecialchars( $string, $quote_style, $charset );
	
		// Handle double encoding ourselves
		if ( !$double_encode ) {
			$string = str_replace( array( '|wp_entity|', '|/wp_entity|' ), array( '&', ';' ), $string );
		}
	
		// Backwards compatibility
		if ( 'single' === $_quote_style ) {
			$string = str_replace( "'", '&#039;', $string );
		}
	
		return $string;
	}
}

if(!function_exists('wp_specialchars_decode'))
{
	function wp_specialchars_decode( $string, $quote_style = ENT_NOQUOTES ) {
		$string = (string) $string;
	
		if ( 0 === strlen( $string ) ) {
			return '';
		}
	
		// Don't bother if there are no entities - saves a lot of processing
		if ( strpos( $string, '&' ) === false ) {
			return $string;
		}
	
		// Match the previous behaviour of _wp_specialchars() when the $quote_style is not an accepted value
		if ( empty( $quote_style ) ) {
			$quote_style = ENT_NOQUOTES;
		} elseif ( !in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) ) {
			$quote_style = ENT_QUOTES;
		}
	
		// More complete than get_html_translation_table( HTML_SPECIALCHARS )
		$single = array( '&#039;'  => '\'', '&#x27;' => '\'' );
		$single_preg = array( '/&#0*39;/'  => '&#039;', '/&#x0*27;/i' => '&#x27;' );
		$double = array( '&quot;' => '"', '&#034;'  => '"', '&#x22;' => '"' );
		$double_preg = array( '/&#0*34;/'  => '&#034;', '/&#x0*22;/i' => '&#x22;' );
		$others = array( '&lt;'   => '<', '&#060;'  => '<', '&gt;'   => '>', '&#062;'  => '>', '&amp;'  => '&', '&#038;'  => '&', '&#x26;' => '&' );
		$others_preg = array( '/&#0*60;/'  => '&#060;', '/&#0*62;/'  => '&#062;', '/&#0*38;/'  => '&#038;', '/&#x0*26;/i' => '&#x26;' );
	
		if ( $quote_style === ENT_QUOTES ) {
			$translation = array_merge( $single, $double, $others );
			$translation_preg = array_merge( $single_preg, $double_preg, $others_preg );
		} elseif ( $quote_style === ENT_COMPAT || $quote_style === 'double' ) {
			$translation = array_merge( $double, $others );
			$translation_preg = array_merge( $double_preg, $others_preg );
		} elseif ( $quote_style === 'single' ) {
			$translation = array_merge( $single, $others );
			$translation_preg = array_merge( $single_preg, $others_preg );
		} elseif ( $quote_style === ENT_NOQUOTES ) {
			$translation = $others;
			$translation_preg = $others_preg;
		}
	
		// Remove zero padding on numeric entities
		$string = preg_replace( array_keys( $translation_preg ), array_values( $translation_preg ), $string );
	
		// Replace characters according to translation table
		return strtr( $string, $translation );
	}
}

if(!function_exists('wp_check_invalid_utf8'))
{
	function wp_check_invalid_utf8( $string, $strip = false ) {
		$string = (string) $string;
	
		if ( 0 === strlen( $string ) ) {
			return '';
		}
	
		// Store the site charset as a static to avoid multiple calls to get_option()
		static $is_utf8;
		if ( !isset( $is_utf8 ) ) {
			$is_utf8 = in_array( get_option( 'blog_charset' ), array( 'utf8', 'utf-8', 'UTF8', 'UTF-8' ) );
		}
		if ( !$is_utf8 ) {
			return $string;
		}
	
		// Check for support for utf8 in the installed PCRE library once and store the result in a static
		static $utf8_pcre;
		if ( !isset( $utf8_pcre ) ) {
			$utf8_pcre = @preg_match( '/^./u', 'a' );
		}
		// We can't demand utf8 in the PCRE installation, so just return the string in those cases
		if ( !$utf8_pcre ) {
			return $string;
		}
	
		// preg_match fails when it encounters invalid UTF8 in $string
		if ( 1 === @preg_match( '/^./us', $string ) ) {
			return $string;
		}
	
		// Attempt to strip the bad chars if requested (not recommended)
		if ( $strip && function_exists( 'iconv' ) ) {
			return iconv( 'utf-8', 'utf-8', $string );
		}
	
		return '';
	}
}

if(!function_exists('esc_html'))
{
	function esc_html( $text ) {
		$safe_text = wp_check_invalid_utf8( $text );
		$safe_text = _wp_specialchars( $safe_text, ENT_QUOTES );
		return apply_filters( 'esc_html', $safe_text, $text );
		return $text;
	}
}

if(!function_exists('is_front_page'))
{
	function is_front_page () {
		// most likely case
		if ( 'posts' == get_option('show_on_front') && is_home() )
			return true;
		elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') && is_page(get_option('page_on_front')) )
			return true;
		else
			return false;
	}
}

/**
 * Convert any other chars
 * 
 * @param string $string
 * @access public
 * @return string
 */
if(!function_exists('architectCharsOther'))
{
	function architectCharsOther($string)
	{
		$chars = array(
			'’' => '&#39;', '—' => '&#45;', '«' => '&#171;', '»' => '&#187;', '&laquo;' => '&#171;',
			'&raquo;' => '&#187;', '–' => '&#45;', '&hellip;' => '&#8230;'
		);
		return str_replace(array_keys($chars), array_values($chars), $string);
	}
}

if(!function_exists('architect_remove_wtf'))
{
	function architect_remove_wtf($string)
	{
		$string = preg_replace('|[[\/\!]*?[^\[\]]*?]|si', '', $string);
		return $string;
	}
}

/**
 * Are we going to scale the image or not
 * 
 * @param string $class
 * @param object $element
 * @access public
 * @return boolean
 */
if(!function_exists('doScaleImage'))
{
	function doScaleImage($class, $element)
	{
		if(isset($element->width) AND $element->width <= 75)
		{
			return false;
		}
		global $architectNoScaleImages;
		if(strpos($class, ' ') !== false)
		{
			foreach(explode(' ', $class) as $val)
			{
				if(in_array($val, $architectNoScaleImages))
				{
					return false;
				}
			}
		} else
		{
			if(in_array($class, $architectNoScaleImages))
			{
				return false;
			}
		}
		return true;
	}
}

/**
 * Are we going to scale the image or not
 * 
 * @param string $class
 * @access public
 * @return boolean
 */
if(!function_exists('doScaleImageParent'))
{
	function doScaleImageParent($element)
	{
		global $architectNoScaleImages;
		
		if(isset($element->parent->class) AND in_array($element->parent->class, $architectNoScaleImages))
		{
			return false;
		}

		if(isset($element->parent->parent->class) AND in_array($element->parent->parent->class, $architectNoScaleImages))
		{
			return false;
		}
	
		if(isset($element->parent->parent->parent->class) AND in_array($element->parent->parent->parent->class, $architectNoScaleImages))
		{
			return false;
		}
		
		if(isset($element->parent->parent->parent->parent->class) AND in_array($element->parent->parent->parent->parent->class, $architectNoScaleImages))
		{
			return false;
		}
		return true;
	}
}

if(!function_exists('simplexml_load_string'))
{
	function simplexml_load_string($string)
	{
		require_once('simplexml.class.php');
		$sx = new simplexml;
		return $sx->xml_load_string($string);
	}
}
?>