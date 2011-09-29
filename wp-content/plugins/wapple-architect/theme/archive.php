<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */
include_once('functions.php');
$waplString = get_wapl_header();
$wapl = new WordPressWapl;

// Posts per page
$posts_per_page = get_option('posts_per_page');
$option_posts_per_page = get_option('architect_home_posts_per_page');
if($option_posts_per_page)
{
	$posts_per_page = $option_posts_per_page;
}

if(is_category())
{
	if($archiveText = get_option('architect_archive_cattext'))
	{
		$text = architect_replace_tag('<category>', single_cat_title('', false), stripslashes($archiveText));
	} else
	{
		$text = 'Archive for the &#8216;'.single_cat_title('', false).'&#8217; Category';
	}
} else if(is_tag())
{
	if($archiveText = get_option('architect_archive_tagtext'))
	{
		$text = architect_replace_tag('<tag>', single_tag_title('', false), stripslashes($archiveText));
	} else
	{
		$text = 'Posts Tagged &#8216;'.single_tag_title('', false).'&#8217;';
	}
} else if(is_day())
{
	if($archiveText = get_option('architect_archive_datetext'))
	{
		$text = stripslashes($archiveText).' '.get_the_time('F jS, Y');
	} else
	{
		$text = 'Archive for '.get_the_time('F jS, Y');
	}
} else if(is_month())
{
	if($archiveText = get_option('architect_archive_datetext'))
	{
		$text = stripslashes($archiveText).' '.get_the_time('F, Y');
	} else
	{
		$text = 'Archive for '.get_the_time('F, Y');
	}
} else if(is_year())
{
	if($archiveText = get_option('architect_archive_datetext'))
	{
		$text = stripslashes($archiveText).' '.get_the_time('Y');
	} else
	{
		$text = 'Archive for '.get_the_time('Y');
	}
} else if(is_author())
{
	if($archiveText = get_option('architect_archive_authortext'))
	{
		$text = stripslashes($archiveText);
	} else
	{
		$text = 'Author Archive';
	}
} else if(isset($_GET['paged']) && !empty($_GET['paged']))
{
	if($archiveText = get_option('architect_archive_blogarchivetext'))
	{
		$text = stripslashes($archiveText);
	} else
	{
		$text = 'Blog Archives';
	}
} else
{
	$text = '';
}
$waplString .= $wapl->chunk('words', array('class' => 'entry_row pagetitle', 'display_as' => 'h2', 'quick_text' => $text));

// get older post link
if($older = get_option('architect_archive_olderentriestext'))
{
	$older = stripslashes($older);
} else
{
	$older = 'Older Posts';
}
// get newer post link
if($newer = get_option('architect_archive_newerentriestext'))
{
	$newer = stripslashes($newer);
} else
{
	$newer = 'Newer Posts';
}
	
global $wp_query;
$waplString .= get_wapl_element('theloop', array(
	'query_posts' => array_merge(array('showposts' => $posts_per_page),$wp_query->query),
	'showNav' => true,
	'olderText' => $older,
	'newerText' => $newer,
	'showFirstImage' => get_option('architect_home_firstimage'),
	'removeCaptions' => get_option('architect_home_removecaptions'),
	'showErrors' => false
));

if(!have_posts())
{
	if ( is_category() ) 
	{ 
		// If this is a category archive
		if($notext = get_option('architect_archive_nocattext'))
		{
			$notext = architect_replace_tag('<category>', single_cat_title('', false), stripslashes($notext));
		} else
		{
			$notext = 'Sorry, but there aren\'t any posts in the '.single_cat_title('',false).' category yet.';
		} 
		$waplString .= $wapl->chunk('words', array('class' => 'entry_row noData', 'display_as' => 'h3', 'quick_text' => stripslashes($notext)));
	} else if ( is_date() ) 
	{ 
		// If this is a date archive
		if(!$notext = get_option('architect_archive_nodatetext'))
		{
			$notext = 'Sorry, but there aren\'t any posts with this date.';
		}
		$waplString .= $wapl->chunk('words', array('class' => 'entry_row noData', 'display_as' => 'h3', 'quick_text' => stripslashes($notext)));
	} else if ( is_author() ) 
	{ 
		// If this is a category archive
		$userdata = get_userdatabylogin(get_query_var('author_name'));
		if($notext = get_option('architect_archive_noauthortext'))
		{
			$notext = architect_replace_tag('<author>', $userdata->display_name, stripslashes($notext));
		} else
		{
			$notext = 'Sorry, but there aren\'t any posts by '.$userdata->display_name.' yet.';
		}
		$waplString .= $wapl->chunk('words', array('class' => 'entry_row noData', 'display_as' => 'h3', 'quick_text' => $notext));
	} else 
	{
		if(!$notext = get_option('architect_archive_nopoststext'))
		{
			$notext = 'No posts found';
		}
		$waplString .= $wapl->chunk('words', array('class' => 'entry_row noData', 'display_as' => 'h3', 'quick_text' => stripslashes($notext)));
	}
}

$waplString .= get_wapl_footer();
process_wapl($waplString);
?>