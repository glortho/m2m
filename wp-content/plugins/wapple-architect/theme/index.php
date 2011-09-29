<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */

include_once('functions.php');
$waplString = get_wapl_header();
$wapl = new WordPressWapl;

// Setup any theme specific functions
architect_theme_functions();

if(get_option('architect_home_bycat'))
{
	// Build home page by category
	$total = get_option('architect_home_categories_total');
	if($total && $total > 0)
	{
		for($i = 1; $i <= $total; $i++)
		{
			// Get the category
			$catId = get_option('architect_home_category_'.$i);
			$catTotal = get_option('architect_home_category_'.$i.'_total');
			$cat = get_category($catId);
			
			// Category name
			$waplString .= $wapl->link(array('rowClass' => 'entry_row h2 category', 'display_as' => 'h2', 'label' => architectCharsOther($cat->cat_name), 'url' => get_category_link($catId)));
			
			// Destroy existing query and start a new one
			wp_reset_query();
			
			// Category posts
			$waplString .= get_wapl_element('theloop', array(
				'queryString' => 'cat='.$catId.'&showposts='.$catTotal,
				'showNav' => false,
				'showFirstImage' => get_option('architect_home_firstimage'),
				'removeCaptions' => get_option('architect_home_removecaptions')
			));
		}
	}
} else
{
	// Show latest posts
	
	// Posts per page
	$posts_per_page = get_option('posts_per_page');
	$option_posts_per_page = get_option('architect_home_posts_per_page');
	if($option_posts_per_page)
	{
		$posts_per_page = $option_posts_per_page;
	}
	
	// Offset paging
	$offset = 0;
	global $paged;
	if($paged > 1)
	{
		$offset = $posts_per_page * ($paged - 1);  
	}
	
	// get older post link
	if($older = get_option('architect_home_olderposts'))
	{
		$older = stripslashes($older);
	} else
	{
		$older = 'Older Posts';
	}
	// get newer post link
	if($newer = get_option('architect_home_newerposts'))
	{
		$newer = stripslashes($newer);
	} else
	{
		$newer = 'Newer Posts';
	}
	$waplString .= get_wapl_element('theloop', array(
		'queryString' => 'showposts='.$posts_per_page.'&offset='.$offset,
		'showNav' => true,
		'olderText' => $older,
		'newerText' => $newer,
		'showFirstImage' => get_option('architect_home_firstimage'),
		'removeCaptions' => get_option('architect_home_removecaptions')
	));
}

if(get_option('architect_home_showsearch'))
{
	$waplString .= get_wapl_element('search_box');
}

if(get_option('architect_home_showcategories'))
{
	$cats = get_categories(array('echo' => 0));
	if(!empty($cats))
	{
		$waplString .= $wapl->chunk('words', array('class' => 'homeCategoryHeader', 'display_as' => 'h3', 'quick_text' => 'Categories'));
		
		$waplString .= '<row><cell class="homeCategories">';
		foreach($cats as $cat)
		{
			$waplString .= $wapl->link(array('row' => false, 'cell' => false, 'prefix' => ' ', 'label' => $cat->name, 'url' => htmlspecialchars(get_category_link( $cat->term_id ))));
		}
		$waplString .= '</cell></row>';
	}
}

$waplString .= get_wapl_footer();
process_wapl($waplString);
?>