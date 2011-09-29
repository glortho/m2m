<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */

/**
 * Get WAPL header
 * @param string $type
 * @param array $options
 * @return string
 */
if(!function_exists('get_wapl_header'))
{
	function get_wapl_header($type = 'site', $headerOptions = array())
	{
		$file = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'header.php';
		return include_once($file);
	}
}

/**
 * Get WAPL footer
 * @return string
 */
if(!function_exists('get_wapl_footer'))
{
	function get_wapl_footer()
	{
		$file = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'footer.php';
		return include_once($file);
	}
}
/**
 * Get comments code
 * @return string 
 */
if(!function_exists('get_wapl_comments'))
{
	function get_wapl_comments()
	{
		$file = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'comments.php';
		return include_once($file);
	}
}
/**
 * Process mobile adverts
 * @return string
 */
if(!function_exists('architect_adverts'))
{
	function architect_adverts($location)
	{
		$ads = array(
			'admob', 
			'adsense'
		);
		
		$string = '';
		foreach($ads as $ad)
		{
			if(get_option('architect_advertising_'.$ad) && get_option('architect_advertising_'.$ad.'_location') == $location)
			{
				$file = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'elements'.DIRECTORY_SEPARATOR.$ad.'.php';
				require_once($file);
			}
		}
		
		return $string;
	}
}
/**
 * Debug function
 * @param $debug mixed
 * @access public
 * @return void
 */
if(!function_exists('debug'))
{
	function debug($debug)
	{
		echo '<pre>'.print_r($debug,true).'</pre>';
	}
}

/**
 * Process WAPL into meaningful markup
 * @param $waplString string
 * @access public
 * @return void
 */
if(!function_exists('process_wapl'))
{
	function process_wapl($waplString)
	{
		if(ARCHITECT_DEBUG)
		{
			ob_end_clean();
			header('Content-type: application/xml');
			echo $waplString;
			die();
		}
		
		if(ARCHITECT_DO_SOAP)
		{
			global $waplHeaders;
			global $waplSoapClient;
			
			// Clean up any empty wordsChunk elements
			require_once('simple_html_dom.php');
			$empty = architect_str_get_html($waplString);
			foreach($empty->find('wordsChunk') as $quick)
			{
				if($quick->innertext == '<quick_text></quick_text>' OR $quick->innertext == '<quick_text> </quick_text>')
				{
					$waplString = str_ireplace($quick->outertext, '', $waplString);
				}
			}
			
			$params = array(
				'devKey' => get_option('architect_devkey'), 
				'wapl' => $waplString, 
				'deviceHeaders' => $waplHeaders
			);
			
			// Send markup to API and parse through simplexml
			$result = @$waplSoapClient->getMarkupFromWapl($params);
			
			if(is_soap_fault($result))
			{
				if(strpos($result->faultstring, 'Account API request limit reached') === 0)
				{
					setcookie('architectError', $result->faultstring, time()+1800, '/');
				}
				setcookie('isMobile', "0", time()+1800, '/');
				header('Location:'.get_permalink());
				exit();
			} else
			{
				setcookie('architectError', "", time()-3600, '/');
			}
			
			$xml = simplexml_load_string($result);
			
			foreach($xml->header->item as $val)
			{
				header($val);
			}
			
			// Flush output buffer - to clean up any other plugin mess!
			ob_end_clean();
			
			$markup = trim($xml->markup);
			$markup = str_replace('""http://www.wapforum.org', '" "http://www.wapforum.org', $markup);
			
			// Echo correct markup
			echo trim($markup);
			die();
		} else if(ARCHITECT_DO_REST)
		{
			global $waplHeaders;
			
			// Clean up any empty wordsChunk elements
			require_once('simple_html_dom.php');
			$empty = architect_str_get_html($waplString);
			foreach($empty->find('wordsChunk') as $quick)
			{
				if($quick->innertext == '<quick_text></quick_text>' OR preg_match('/<quick_text>([ \t\s])<\/quick_text>/i', $quick->innertext))
				{
					$waplString = str_ireplace($quick->outertext, '', $waplString);
				}
			}
			
			$postfields = array(
				'devKey' => get_option('architect_devkey'),
				'wapl' => $waplString,
				'headers' => $waplHeaders
			);
			
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, 'http://webservices.wapple.net/getMarkupFromWapl.php');
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_POSTFIELDS, $postfields);
			
			$result = curl_exec($c);
			if(strpos($result, 'Account API request limit reached')!== false)
			{
				setcookie('architectError', 'Account API request limit reached', time()+1800, '/');
				setcookie('isMobile', "0", time()+1800, '/');
				header('Location:'.get_permalink());
				exit();
			} else if(strpos($result, 'Developer key authentication error') !== false)
			{
				setcookie('architectError', 'Developer key authentication error', time()+1800, '/');
				setcookie('isMobile', "0", time()+1800, '/');
				header('Location:'.get_permalink());
				exit();
			} else
			{
				setcookie('architectError', "", time()-3600, '/');
			}
			curl_close($c);
	
			$xml = simplexml_load_string($result);
			foreach($xml->header->item as $val)
			{
				header($val);
			}
			
			// Flush output buffer - to clean up any other plugin mess!
			ob_end_clean();
	
			$markup = trim($xml->markup);
			$markup = str_replace('""http://www.wapforum.org', '" "http://www.wapforum.org', $markup);
			
			// Echo correct markup
			echo trim($markup);
			die();
			
		} else
		{
			header('Content-type: application/xml');
			echo $waplString;
		}
	}
}

require_once('wapl_builder.php');
/**
 * WordPress WAPL parser
 * 
 * Extends the waplBuilder class to build perfect markup
 * @author Rich Gubby
 */
class WordPressWapl extends waplBuilder
{
	/**
	 * Format content into WAPL readable format
	 * @param string $content
	 * @param integer $imagescale
	 * @param integer $imagequality
	 * @param string $class
	 * @param integer $length
	 * @param string $transcol
	 * @access public
	 * @return string
	 */
	function format_text($content, $imagescale = 95, $imagequality = 90, $class = 'entry', $length = null, $transcol = '')
	{
		// Remove comments
		$content = str_replace(
			array('&#8211;', '<strong><strong>', '&copy;', '&nbsp;'), 
			array('--', '<strong>', '&#169;', '&#160;'), 
			$content
		);

		$content = $this->foreignChars($content);

		// Ampersand cleanup
		$content = preg_replace('/(?!&#)&/', '&amp;', $content);
		preg_match_all('/&#[0-9]{1,}(;)?/', $content, $matches, PREG_OFFSET_CAPTURE);
		foreach($matches[0] as $key => $val)
		{
			if(substr($val[0], -1) != ';')
			{
				$content = substr_replace($content, str_replace('&#', '&amp;#', $val[0]), $val[1], strlen($val[0]));
			}
		}
		
		$replacements = array();
		require_once('simple_html_dom.php');
		
		$html = architect_str_get_html($content);
		
		// Remove comments
		foreach($html->find('comment') as $element)
		{
			$content = str_ireplace($element->outertext, '', $content);
		}
		
		// Remove script tags
		foreach($html->find('script') as $element)
		{
			$replacements[trim($element->outertext())] = '';
		}
		
		// Any special filters for other plugins
		$content = $this->__filters($content, $class);
		
		// Get rid of the "more" links - don't need these for mobile, they clutter things up
		if(!get_option('architect_home_showmore'))
		{
			foreach($html->find('a.more-link') as $element)
			{
				$replacements[trim($element->outertext())] = '';
			}
		}
		
		// Handle <object> values
		foreach($html->find('object') as $element)
		{
			$src = $element->find('param[name=movie]',0);
			if(!$src)
			{
				$src = $element->find('param[name=src]',0);
			}
			$srcVal = htmlentities($src->value);
			
			if(strpos($src->value, 'youtube') !== false)
			{
				preg_match_all("#http://www.youtube.com/v/([A-Za-z0-9\-_]+).+?#s", $src->value, $thumbnailMatch);
				
				if(isset($thumbnailMatch[1][0]))
				{
					$imageThumbnail = '<externalImage filetype="jpg" scale="90"><url>http://i.ytimg.com/vi/'.$thumbnailMatch[1][0].'/1.jpg</url></externalImage>';
				} else
				{
					$imageThumbnail = '';
				}
			} else
			{
				$imageThumbnail = '';
			}
			
			if(isset($srcVal) AND $srcVal != '')
			{
				$text = '<rule type="activation" criteria="iphone" condition="1">
					<row class="entry_row"><cell>
					<chars make_safe="0"><value><![CDATA[<object width="310">
						<param name="movie" value="'.$srcVal.'"></param>
						<param name="wmode" value="transparent"></param>
						<embed src="'.$srcVal.'" type="application/x-shockwave-flash" wmode="transparent" width="310"></embed></object>]]>
					</value></chars></cell></row>
				</rule>
				<rule type="activation" criteria="iphone" condition="0">
					<row class="entry_row"><cell><externalLink><url>'.$srcVal.'</url><label>'.$srcVal.'</label>'.$imageThumbnail.'</externalLink></cell></row>
				</rule>';
				
				$content = str_ireplace($element->outertext, '</quick_text></wordsChunk>'.$text.'<wordsChunk class="'.$class.'"><quick_text>', $content);
			} else
			{
				$content = str_ireplace($element->outertext, '', $content);
			}
		}
		
		// Replace [caption] with <caption>
		$content = preg_replace('/(\[caption(.*?)\])(.*?)(\[\/caption\])/i', '<caption ${2}>${3}</caption>', $content);
		
		foreach($replacements as $key => $val)
		{
			$content = str_ireplace(trim($key), $val, $content);
		}
		
		// Use parent format text
		$content = parent::format_text($content, $imagescale, $imagequality, $class, $length, $transcol);
		
		return utf8_encode(str_replace(array('& ', '&amp;amp;'), array('&amp; ', '&amp;'), $content));
	}
	
	/**
	 * Check if a string is UTF8 or not
	 * 
	 * @param string $string
	 * @access public
	 * @return string
	 */
	function is_utf8($string) 
	{
	    return (preg_match('/^([\x00-\x7f]|[\xc0-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xf7][\x80-\xbf]{3}|[\xf8-\xfb][\x80-\xbf]{4}|[\xfc-\xfd][\x80-\xbf]{5})*$/', $string) === 1);
	}
	
	/**
	 * Convert foreign characters to ascii alternatives
	 * 
	 * @param string $string
	 * @access public
	 * @return string
	 */
	function foreignChars($string)
	{
		// Add support for Japanese, Chinese, Korean, etc characters
		if(function_exists('mb_detect_encoding'))
		{
			$newString = '';
			for ($i=0; $i < mb_strlen($string, 'UTF-8'); $i++)
			{
				$ch = mb_substr($string, $i, 1, 'UTF-8');
				
				if($ch && trim($ch) != '')
				{
					$returnVal = $this->uniord($ch);
					if($returnVal['encode'] == true)
					{
						$newString .= '&#'.$returnVal['ud'].';';
					} else if(!$returnVal['die'])
					{
						$newString .= mb_substr($string, $i, 1, 'UTF-8');
					}
				} else
				{
					$newString .= mb_substr($string, $i, 1, 'UTF-8');
				}
			}
			
			$string = $newString;

			require_once('language.php');
			$chars = architectGetTranslation('chars');
			
			// Convert any other characters
			$string = str_replace(
				array_keys($chars), 
				array_values($chars), 
			$string);
		} else
		{
			// Check for dodgy chars
			for($i = 0; $i < strlen($string); $i++)
			{
				if(ord($string[$i]) == 26)
				{
					$string[$i] = '';
				}
			}

			require_once('language.php');
			$chars = architectGetTranslation('chars');
			$charsOriginal = architectGetTranslation('charsOriginal');
			
			// Convert characters manually
			$string = str_replace(
				array_keys(array_merge($chars, $charsOriginal)), 
				array_values(array_merge($chars, $charsOriginal)), 
				$string
			);
		}
		
		// Any other characters
		$string = architectCharsOther($string);

		return utf8_decode($string);
	}
	
	function uniord($c)
	{
		$ud = 0;
		$encode = true;
		$die = false;
		if (ord($c{0})>=0 && ord($c{0})<=127)
		{
			if(ord($c{0}) == 26)
			{
				$die = true;
			}
			$encode = false;
			$ud = $c{0};
		}
		if (ord($c{0})>=192 && ord($c{0})<=223)
		{
			$ud = (ord($c{0})-192)*64 + (ord($c{1})-128);
		}
		if (ord($c{0})>=224 && ord($c{0})<=239)
		{
			$ud = (ord($c{0})-224)*4096 + (ord($c{1})-128)*64 + (ord($c{2})-128);
		}
		if (ord($c{0})>=240 && ord($c{0})<=247)
		{
			$ud = (ord($c{0})-240)*262144 + (ord($c{1})-128)*4096 + (ord($c{2})-128)*64 + (ord($c{3})-128);
		}
		if (ord($c{0})>=248 && ord($c{0})<=251)
		{
			$ud = (ord($c{0})-248)*16777216 + (ord($c{1})-128)*262144 + (ord($c{2})-128)*4096 + (ord($c{3})-128)*64 + (ord($c{4})-128);
		}
		if (ord($c{0})>=252 && ord($c{0})<=253)
		{
			$ud = (ord($c{0})-252)*1073741824 + (ord($c{1})-128)*16777216 + (ord($c{2})-128)*262144 + (ord($c{3})-128)*4096 + (ord($c{4})-128)*64 + (ord($c{5})-128);
		}
		if (ord($c{0})>=254 && ord($c{0})<=255)
		{
			//error
			$ud = false;
		}
		// Further error reporting
		if(in_array($ud, array(56110)))
		{
			$encode = false;
		}
		return array('ud' => $ud, 'encode' => $encode, 'die' => $die);
	}

	/**
	 * Special filters written specifically for other plugins
	 * @param string $content
	 * @param string $class
	 * @access public
	 * @return string
	 */
	function __filters($content, $class)
	{
		// Path to extensions
		$path = '';
		if(defined('WP_PLUGIN_DIR'))
		{
			$path = WP_PLUGIN_DIR;
		} else if(defined('ABSPATH'))
		{
			$path = ABSPATH.'wp-content'.DIRECTORY_SEPARATOR.'plugins';
		}
		$path .= DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'extensions';
		
		if ($handle = opendir($path)) 
		{
			// List of disallowed files/dirs
			$disallowedFiles = array('.', '..', '.svn', 'php.ini');
			
			// Get all files in the extensions directory
			while (false !== ($file = readdir($handle))) 
			{
				if (!in_array($file, $disallowedFiles)) 
				{
					// Include the file
					include_once($path.DIRECTORY_SEPARATOR.$file);
					
					// Get class name - should match the filename
					$className = substr($file,0,strpos($file,'.'));
					
					// Create a new class
					if(class_exists($className))
					{
						$filterClass = new $className;
					
						if(method_exists($filterClass, 'format'))
						{
							// Return formatted text
							$content = $filterClass->format($content, $class);
						}
					} 
				}
			}
			closedir($handle);
		}
		return $content;
	}
}

/**
 * Load a WAPL element
 * @param $element string
 * @access public
 * @return void
 */
function get_wapl_element($element, $queryStringOptions = array())
{
	require_once('simple_html_dom.php');
	return require('elements/'.$element.'.php');
}

function get_wapl_response_string($type, $count, $title = '')
{
	if(!isset($type) OR $type == '')
	{
		$type = 1;
	}
	$text = array();
	
	$text[1] = array('format' => "%d %s", 'single' => 'response', 'plural' => 'responses');
	$text[2] = array('format' => "%d %s %s", 'single' => 'response to', 'plural' => 'responses to');
	$text[3] = array('format' => "%d %s", 'single' => 'comment', 'plural' => 'comments');
	$text[4] = array('format' => "%d %s %s", 'single' => 'comment to', 'plural' => 'comments to');

	$singletext = get_option('architect_single_commentsingletext');
	$pluraltext = get_option('architect_single_commentpluraltext');
	if($singletext && $pluraltext)
	{
		if($count == 0 || $count > 1)
		{
			return sprintf($text[$type]['format'], $count, stripslashes($pluraltext), $title);
		} else
		{
			return sprintf($text[$type]['format'], $count, stripslashes($singletext), $title);
		}
	} else
	{
		if($count == 0 || $count > 1)
		{
			return sprintf($text[$type]['format'], $count, $text[$type]['plural'], $title);
		} else
		{
			return sprintf($text[$type]['format'], $count, $text[$type]['single'], $title);
		}
	}
}

if(!function_exists('get_author_posts_url'))
{
	function get_author_posts_url($author_id, $author_nicename = '') {
		global $wp_rewrite;
		$auth_ID = (int) $author_id;
		$link = $wp_rewrite->get_author_permastruct();
	
		if ( empty($link) ) {
			$file = get_option('home') . '/';
			$link = $file . '?author=' . $auth_ID;
		} else {
			if ( '' == $author_nicename ) {
				$user = get_userdata($author_id);
				if ( !empty($user->user_nicename) )
					$author_nicename = $user->user_nicename;
			}
			$link = str_replace('%author%', $author_nicename, $link);
			$link = get_option('home') . trailingslashit($link);
		}
	
		$link = apply_filters('author_link', $link, $author_id, $author_nicename);
	
		return $link;
	}
}

if(!function_exists('post_password_required'))
{
	function post_password_required( $post = null ) {
		$post = get_post($post);
	
		if ( empty($post->post_password) )
			return false;
	
		if ( !isset($_COOKIE['wp-postpass_' . COOKIEHASH]) )
			return true;
	
		if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password )
			return true;
	
		return false;
	}
}

if(!function_exists('architect_theme_header'))
{
	function architect_theme_header($wapl)
	{
		$waplString = '';
		
		// Show top image if using AutoFocus theme
		switch(get_current_theme())
		{
			case 'AutoFocus':
				$imageSrc = architect_the_post_image_url();
				$waplString = $wapl->image(array(
					'url' => $imageSrc,
					'filetype' => $wapl->_getImageType($imageSrc),
					'quality' => 95,
					'scale' => 100,
					'transcol' => get_option('architect_single_transcol'),
					'class' => 'autoFocusTopImage'
				));
				break;
		}
		return $waplString;
	}
}

if(!function_exists('architect_theme_functions'))
{
	function architect_theme_functions()
	{
		switch(get_current_theme())
		{
			case 'AutoFocus':
			
				if(!function_exists('architect_the_post_image_url'))
				{
					function architect_the_post_image_url($size='large') 
					{
						global $post;
						$linkedimgurl = get_post_meta ($post->ID, 'image_url', true);
					
						if ( $images = get_children(array(
							'post_parent' => get_the_ID(),
							'post_type' => 'attachment',
							'numberposts' => 1,
							'post_mime_type' => 'image',)))
						{
							foreach( $images as $image ) {
								$attachmenturl=wp_get_attachment_image_src($image->ID, $size);
								$attachmenturl=$attachmenturl[0];
								$attachmentimage=wp_get_attachment_image( $image->ID, $size );
					
								return ''.$attachmenturl.'';
							}
							
						} elseif ( $linkedimgurl ) {
					
							return $linkedimgurl;
					
						} elseif ( $linkedimgurl && $images = get_children(array(
							'post_parent' => get_the_ID(),
							'post_type' => 'attachment',
							'numberposts' => 1,
							'post_mime_type' => 'image',)))
						{
							foreach( $images as $image ) {
								$attachmenturl=wp_get_attachment_image_src($image->ID, $size);
								$attachmenturl=$attachmenturl[0];
								$attachmentimage=wp_get_attachment_image( $image->ID, $size );
					
								return ''.$attachmenturl.'';
							}
							
						} else {
							return '' . get_bloginfo ( 'stylesheet_directory' ) . '/img/no-attachment.gif';
						}
					}
				}
				break;
		}
	}
}

if(!function_exists('get_home_url'))
{
	function get_home_url($blog_id = null, $path = '', $scheme = null)
	{
		$orig_scheme = $scheme;

		if ( !in_array( $scheme, array( 'http', 'https' ) ) )
			$scheme = is_ssl() && !is_admin() ? 'https' : 'http';
	
		if ( empty( $blog_id ) || !is_multisite() )
			$home = get_option( 'home' );
		else
			$home = get_blog_option( $blog_id, 'home' );
	
		$url = str_replace( 'http://', "$scheme://", $home );
	
		if ( !empty( $path ) && is_string( $path ) && strpos( $path, '..' ) === false )
			$url .= '/' . ltrim( $path, '/' );
	
		return apply_filters( 'home_url', $url, $path, $orig_scheme, $blog_id );
	}
}
?>