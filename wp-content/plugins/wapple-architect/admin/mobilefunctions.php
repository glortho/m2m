<?php
/**
 * Main device detection kick off function
 * - Sets up a few global variables that we're going to use later and initiates a check for mobile.
 * - If the check for mobile comes back true, amend the path to the theme
 * @param array $options
 * @access public
 * @return void
 */
function deviceDetection($options = array())
{
	// Only do this if we're on a non-admin page (for now!)
	if(!is_admin())
	{
		// Setup a global SOAP client so we can use the same one in the theme
		global $waplSoapClient;
		// Setup global headers so we don't have to get them twice
		global $waplHeaders;
		
		// Which communication method do we want to use?
		if(function_exists('curl_init'))
		{
			// Communicating via REST
			define('ARCHITECT_DO_SOAP', false);
			define('ARCHITECT_DO_REST', true);
		} else if(class_exists('SoapClient'))
		{
			if(ini_get('allow_url_fopen'))
			{
				// Check if the SOAP client is up
				if(!@file_get_contents('http://webservices.wapple.net/info.txt'))
				{
					define('ARCHITECT_DO_SOAP', false);
					define('ARCHITECT_DO_REST', false);
					return false;
				} else
				{
					// Communicating via SOAP
					define('ARCHITECT_DO_SOAP', true);
					define('ARCHITECT_DO_REST', false);
				}
			} else
			{
				define('ARCHITECT_DO_SOAP', true);
				define('ARCHITECT_DO_REST', false);
			}
		} else
		{
			return false;
		}
		if(!function_exists('simplexml_load_string'))
		{
			return false;
		}
		
		// Create the SOAP client
		if(ARCHITECT_DO_SOAP)
		{
			$waplSoapClient = __getSoapClient();
		} else
		{
			$waplSoapClient = null;
		}
		// Get device / browser header information 
		$waplHeaders = __getHeaders();

		// If __testForMobile() comes back true, amend template path
		if(__testForMobile())
		{
			if(get_option('architect_redirect'))
			{
				$url = get_option('architect_redirect_url');
				if($url && (strpos($url, 'http://') === 0))
				{
					header('Location:'.$url);
				}
			}
			
			// Load the correct file depending on the URL (copied from template-loader.php)
			$template = __templateLoader();
			
			$file = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$template;
			if(file_exists($file))
			{
				include($file);
				exit(0);
			}
		}
	}
}

/**
 * Work out which theme file to use
 * @return string
 */
function __templateLoader()
{
	if ( is_404()) 
	{
		return '404.php';
	} else if ( is_search()) 
	{
		return 'search.php';
	} else if ( is_home()) 
	{
		return 'index.php';
	} else if ( is_single()) 
	{
		return 'single.php';
	} else if ( is_page()) 
	{
		global $wp_query;
		switch(get_post_meta( $wp_query->post->ID, '_wp_page_template', true ))
		{
			case 'template-blog.php': // PrimePress blog template
				return 'index.php';
				break;
		}
		return 'page.php';
	} else if ( is_archive()) 
	{
		return 'archive.php';
	} else if (file_exists(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'index.php' )) 
	{
		return 'index.php';
	} else
	{
		return 'index.php';
	}
}

/**
 * Perform a device detection check
 * @return boolean
 */
function __testForMobile()
{
	global $waplSoapClient;
	global $waplHeaders;
	
	if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] == 0)
	{
		setcookie('isMobile', "", time()-3600, '/');
		setcookie('isMobile', "0", time()+3600, '/');
		return false;
	} else if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] == 1)
	{
		setcookie('isMobile', "", time()-3600, '/');
		setcookie('isMobile', "1", time()+3600, '/');
		return true;
	}
	
	if(!get_option('architect_devkey'))
	{
		return false;
	}
	
	// Check for existence of a cookie
	if(isset($_COOKIE['isMobile']) AND $_COOKIE['isMobile'] == true)
	{
		return true;
	} else if(isset($_COOKIE['isMobile']) AND $_COOKIE['isMobile'] == false)
	{
		return false;
	} else
	{
		if(ARCHITECT_DEBUG)
		{
			return true;
		}
		if(ARCHITECT_DO_SOAP)
		{
			// Test for mobile
			$params = array(
				'devKey' => get_option('architect_devkey'),
				'deviceHeaders' => $waplHeaders
			);
		
			$result = @$waplSoapClient->isMobileDevice($params);
			if(is_soap_fault($result))
			{
				// There is a SOAP error! probably a dev key error
				return false;
			}  else
			{
				if($result)
				{
					// Set a cookie to remember the outcome!
					setcookie('isMobile', true, time()+3600, '/');
					return true;
				} else
				{
					setcookie('isMobile', false, time()+3600, '/');
					return false;
				}
			}
		} else if(ARCHITECT_DO_REST)
		{
			$postfields = array(
				'devKey' => get_option('architect_devkey'),
				'headers' => $waplHeaders
			);
			
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, 'http://webservices.wapple.net/isMobileDevice.php');
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_POSTFIELDS, $postfields);
			
			$result = curl_exec($c);
			
			curl_close($c);
			if($result == 1)
			{
				setcookie('isMobile', true, time()+3600, '/');
				return true;
			} else
			{
				setcookie('isMobile', $result, time()+3600, '/');
				return false;
			}
		}
	}
}

/**
 * Get a SOAP client
 * @return mixed
 */
function __getSoapClient()
{
	if(ARCHITECT_DEBUG)
	{
		return false;
	}
	if(ARCHITECT_DO_SOAP)
	{
		return new SoapClient('http://webservices.wapple.net/wapl.wsdl', array('exceptions' => 0));
	} else
	{
		return false;
	}	
}

/**
 * Build device header array that SOAP can use
 * @return array
 */
function __getHeaders()
{
	$_SERVER['ARCHITECT_SIGNATURE'] = 'WappleArchitectMobilePlugin'; 
	if(ARCHITECT_DO_SOAP)
	{
		$headers = array();
		foreach($_SERVER as $key => $val)
		{
			$headers[] = array('name' => $key, 'value' => $val);
		}
		return $headers;
	} else
	{
		$headers = '';
		foreach($_SERVER as $key => $val)
		{
			$headers .= $key.':'.$val.'|';
		}
		return $headers;
	}
}

if(!function_exists('architect_curPageURL'))
{
	function architect_curPageURL() 
	{
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) AND $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else 
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
}

if(!function_exists('architect_buildUrl'))
{
	function architect_buildUrl($url, $options = array())
	{
		unset($_GET['mobile']);
		
		if(!isset($options['mobile']))
		{
			$options['mobile'] = 1;
		}
		$parsedUrl = parse_url($url);
		
		$return = $parsedUrl['scheme'].'://'.$parsedUrl['host'].$parsedUrl['path'];
		
		$i = 0;
		foreach($_GET as $key => $val)
		{
			if($i == 0)
			{
				$return .= '?';
			} else
			{
				$return .= '&';
			}
			
			$return .= $key.'='.$val;
			$i++;
		}
		foreach($options as $key => $val)
		{
			if($i == 0)
			{
				$return .= '?';
			} else
			{
				$return .= '&';
			}
			
			$return .= $key.'='.$val;
			$i++;
		}

		return htmlspecialchars($return);
	}
}

if(!function_exists('architect_web_footer'))
{
	function architect_web_footer()
	{
		echo '<div id="deviceSwitcher">View in: <a href="'.architect_buildUrl(architect_curPageURL(), array('mobile' => 1)).'">Mobile</a> | Standard</div>';
	}
}

if(!function_exists('architect_replace_tag'))
{
	function architect_replace_tag($tag, $replacement, $string)
	{
		$string = str_replace($tag, $replacement, $string);
		return strip_tags($string);
		
	}	
}
?>