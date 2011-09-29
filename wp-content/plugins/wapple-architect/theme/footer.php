<?php 
$waplString = '';

$waplString .= architect_adverts('belowposts');

// Show sidebar elements
if((is_home() AND get_option('architect_sidebar_home')) OR (!is_home() AND get_option('architect_sidebar_other')))
{
	// Get any content in the buffer, clean it out and re-start the buffer
	$content_so_far = ob_get_clean();
	unset($content_so_far);
	ob_start();
	
	// Clean up sidebar items
	$sidebaritems = explode('|', get_option('architect_sidebar_items'));
	if($sidebaritems)
	{
		global $wp_registered_sidebars, $wp_registered_widgets;
		foreach($wp_registered_widgets as $key => $val)
		{
			if(!in_array($key, $sidebaritems))
			{
				unset($wp_registered_widgets[$key]);
			}
		}  
	}
	// Get the sidebar - based on whatever widgets we've specified
	get_sidebar();
	
	$wapl = new WordPressWapl;
	if(is_home())
	{
		$imagescale = get_option('architect_home_imagescale');
		$imagequality = get_option('architect_home_imagequality');
	} else if(is_single())
	{
		$imagescale = get_option('architect_single_imagescale');
        $imagequality = get_option('architect_single_imagequality');
	} else
	{
		$imagescale = get_option('architect_page_imagescale');
        $imagequality = get_option('architect_page_imagequality');
	}
	// Send it through the WAPL format_text parser
	if(!$sidebarheader = get_option('architect_sidebar_header'))
	{
		$sidebarheader = '&#160;';
	}
	$waplString .= '<wordsChunk class="sidebarheader"><display_as>h2</display_as><quick_text>'.$sidebarheader.'</quick_text></wordsChunk><wordsChunk class="sidebar"><quick_text>'.$wapl->format_text(ob_get_clean(), $imagescale, $imagequality, 'sidebar').'</quick_text></wordsChunk><wordsChunk class="sidebarfooter"><quick_text>&#160;</quick_text></wordsChunk>';
}

if(get_option('architect_showmenuatbottom'))
{
	$waplString .= get_wapl_element('menu');
}

if(get_option('architect_use_footerimage'))
{
	$src = false;
	$architect_footerimage = get_option('architect_footerimage');
	
	if(file_exists(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'footer'.DIRECTORY_SEPARATOR.$architect_footerimage))
	{
		$src =  WP_CONTENT_URL.'/uploads/'.get_wapl_plugin_base().'/images/footer/'.$architect_footerimage;
	} else if(file_exists(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'footer'.DIRECTORY_SEPARATOR.$architect_footerimage))
	{
		$src =  WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/theme/images/footer/'.$architect_footerimage;
	}
	if($src)
	{
		$filetype = substr($architect_footerimage, (strpos($architect_footerimage, '.') + 1), strlen($architect_footerimage));
		
		$waplString .= '<row class="footerImage"><cell><externalImage filetype="'.$filetype.'" scale="100"><url>'.htmlspecialchars($src).'</url>';
		
		$footer_image_transcol = get_option('architect_footerimage_transparency_colour');
		if(get_option('architect_footerimage_transparency_colour') AND $footer_image_transcol != '')
		{
			$waplString .= '<transcol>'.$footer_image_transcol.'</transcol>';
		}
		$waplString .= '</externalImage></cell></row>';
	}
}

if(get_option('architect_showfootertext'))
{
	$footerText = get_option('architect_footertext');
	
	$waplString .= '<wordsChunk id="footer"><quick_text>'.architectCharsOther(architectCharsAmp(stripslashes($footerText))).'</quick_text></wordsChunk>';
}

if(get_option('architect_showswitchtodesktop'))
{

	$parsedUrl = architect_buildUrl(architect_curPageURL(), array('mobile' => 0));
	
	$waplString .= '<row class="" id="switchToDesktop">
	<cell><chars><value>Mobile | </value></chars><externalLink><prefix> </prefix><label>Standard</label><url>'.htmlspecialchars($parsedUrl).'</url></externalLink></cell>
	</row>'; 
}

if(!get_option('architect_use_footerimage') AND !get_option('architect_showfootertext'))
{
	$waplString .= '<row class=""><cell id="footer"><chars><value> </value></chars></cell></row>';
}

$waplString .= architect_adverts('bottom');

if(function_exists('smartPhoneLocationLookupJS'))
{
	$waplString .= '<rule type="activation" criteria="javascript_enabled" condition="1">';
	$waplString .= '<row><cell><chars><value><![CDATA['.smartPhoneLocationLookupJS(true).']]></value></chars></cell></row>';
	$waplString .= '</rule>';
}
$waplString .= '</layout></wapl>';
return $waplString;
?>