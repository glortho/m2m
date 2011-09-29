<?php
$wapl = new WordPressWapl;
 
$string = '<' . '?xml version="1.0" encoding="utf-8" ?'.'>';
$string .= '<wapl xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://wapl.wapple.net/wapl.xsd">
<settings>
	<iphoneUserScaleable>0</iphoneUserScaleable>
	<iphoneMinScale>1</iphoneMinScale>
	<iphoneMaxScale>1</iphoneMaxScale>
</settings>
<head>
<title>';
$title = get_bloginfo('title');
$getVar = get_option('architect_mobile_blogtitle');
if($getVar AND $getVar != '')
{
	$getVar = architect_remove_wtf($getVar);
	$title = stripslashes($getVar);
	$title = str_replace('&', '&amp;', $title);
}
if(isset($headerOptions['titleOverride']))
{
	$string .= $title.str_replace($headerOptions['titleOriginal'], $headerOptions['titleOverride'], $wapl->format_text(wp_title('&raquo;', false)));
} else
{
	$string .= $title.$wapl->format_text(wp_title('&raquo;', false));
}
$string .= '</title>';

if(function_exists('smartPhoneLocationLookupHead'))
{
	$string .= '<javascript><url>'.smartPhoneLocationLookupHead(true).'</url></javascript>';
}

if(!$themeoption = get_option('architect_theme'))
{
	$themeoption = 'custom';
}

if($themeoption == 'custom')
{
	$string .= '<css><url>'.WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/theme/style.php</url></css>';
	
	$src = '';
	if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css'))
	{
		$src =  WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/css/style.css';
	} else if(file_exists(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'style.css'))
	{
		$src =  WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/theme/style.css';
	}
	
	if($blogid =get_option('blog_id'))
	{
		if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'style.css'))
		{
			$src = WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/css/blogs.dir/'.$blogid.'/style.css';
		}
	}
	
	$string .= '<css><url>'.htmlspecialchars($src).'</url></css>';

	$custom_src = '';
	if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'custom_style.css'))
	{
		$custom_src =  WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/css/custom_style.css';
	} else if(file_exists(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'custom_style.css'))
	{
		$custom_src =  WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/theme/custom_style.css';
	}
	
	if($blogid =get_option('blog_id'))
	{
		if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'custom_style.css'))
		{
			$custom_src = WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/css/blogs.dir/'.$blogid.'/custom_style.css';
		}
	}
	
	$string .= '<css><url>'.htmlspecialchars($custom_src).'</url></css>';
	
	
} else
{
	$src = '';
	if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css'))
	{
		$src =  WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/css/style.css';
	} else if(file_exists(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'style.css'))
	{
		$src =  WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/theme/style.css';
	}
	
	if($blogid =get_option('blog_id'))
	{
		if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'style.css'))
		{
			$src = WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/css/blogs.dir/'.$blogid.'/style.css';
		}
	}
	$string .= '<css><url>'.htmlspecialchars($src).'</url></css>';

	$string .= '<css><url>'.WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/theme/color.php</url></css>';
}

if(get_option('architect_use_meta'))
{
	// meta description
	$description = get_bloginfo('description');
	$getVar = get_option('architect_mobile_blogdesc');
	if($getVar AND $getVar != '')
	{
		$description = $getVar;
	}
	
	if(substr($description, 0, 1) == '"'){ $description = substr($description, 1, strlen($description));}
	if(substr($description, -1) == '"'){ $description = substr($description, 0, (strlen($description)-1));}
	
	$string .= '<meta name="description" content="'.htmlentities($wapl->foreignChars(architectCharsAmp($description))).'" />';
	
	// meta keywords
	$keywords = get_option('architect_meta_keywords');
	if($keywords)
	{
		$string .= '<meta name="keywords" content="'.htmlentities($wapl->foreignChars(architectCharsAmp($keywords))).'" />';
	}
}

$string .= '</head>';

if(get_option('architect_layout_mode') == 'div')
{
	$string .= '<layout start_stack="div">';
} else if($themeoption == 'custom')
{
	$string .= '<layout>';
} else
{
	$string .= '<layout start_stack="div">';
}

$string .= architect_adverts('top');

if(get_option('architect_use_headerimage'))
{
	$src = false;
	$architect_single_use_headerimage = get_option('architect_single_use_headerimage');
	$architect_single_headerimage = get_option('architect_single_headerimage');
	$architect_headerimage = get_option('architect_headerimage');
	
	if($architect_single_use_headerimage AND $type == 'single' AND ($architect_single_headerimage != $architect_headerimage))
	{
		if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'postHeader'.DIRECTORY_SEPARATOR.$architect_single_headerimage))
		{
			$src =  WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/images/postHeader/'.$architect_single_headerimage;
		}
	} else
	{
		if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'header'.DIRECTORY_SEPARATOR.$architect_headerimage))
		{
			$src =  WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/images/header/'.$architect_headerimage;
		} else if(file_exists(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'header'.DIRECTORY_SEPARATOR.$architect_headerimage))
		{
			$src =  WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/theme/images/header/'.$architect_headerimage;
		}
	}
	
	if($src)
	{
		// Get filetype
		$filetype = substr($architect_headerimage, (strpos($architect_headerimage, '.') + 1), strlen($architect_headerimage));
		$string .= '<row class="headerImage"><cell id="header">';
		
		if(get_option('architect_headerimagelinktohome'))
		{
			$string .= '<externalLink><url>'.htmlspecialchars(get_option('home')).'</url>';
		}
		
		$string .= '
		<externalImage filetype="'.$filetype.'" scale="100">
		<url>'.htmlspecialchars($src).'</url>
		<alt>'.get_bloginfo('title').'</alt>';
		
		$architect_headerimage_transcol = get_option('architect_headerimage_transparency_colour');
		if($architect_headerimage_transcol AND $architect_headerimage_transcol != '')
		{
			$string .= '<transcol>'.$architect_headerimage_transcol.'</transcol>';
		}
		$string .= '</externalImage>';
		
		if(get_option('architect_headerimagelinktohome'))
		{
			$string .= '</externalLink>';
		}
		
		$string .= '</cell></row>';
	}
}

if(get_option('architect_show_blogtitle'))
{
	if(get_option('architect_headerimagelinktohome'))
	{
		$title = get_bloginfo('title');
		$getVar = get_option('architect_mobile_blogtitle');
		if($getVar AND $getVar != '')
		{
			$title = $getVar;
		}
		
		if(get_option('architect_accesskeys'))
		{
			$accessKey = '<accessKey>1</accessKey>';
		} else
		{
			$accessKey = '';
		}
		$string .= '<row class=""><cell id="header"><externalLink>'.$accessKey.'<label>'.stripslashes(architectCharsAmp($title)).'</label><url>'.htmlspecialchars(get_option('home')).'</url></externalLink></cell></row>';
	} else
	{
		$title = get_bloginfo('title');
		$getVar = get_option('architect_mobile_blogtitle');
		if($getVar AND $getVar != '')
		{
			$title = $getVar;
		}
		$string .= '<wordsChunk id="header"><display_as>h1</display_as><quick_text>'.stripslashes(architectCharsAmp($title)).'</quick_text></wordsChunk>';
	}
}

$string .= architect_adverts('belowheader');

if(get_option('architect_show_blogdesc'))
{
	$description = get_bloginfo('description');
	$getVar = get_option('architect_mobile_blogdesc');
	if($getVar AND $getVar != '')
	{
		$description = stripslashes($getVar);
	}
	
	$string .= '<row class=""><cell class="description"><chars><value>'.htmlentities($wapl->foreignChars(architectCharsAmp($description))).'</value></chars></cell></row>';
}
if(get_option('architect_showmenuattop'))
{
	$string .= get_wapl_element('menu');
}

$string .= architect_adverts('belowmenu');

return $string;
?>