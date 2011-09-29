<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */
include_once('functions.php');
$waplString = get_wapl_header();
$wapl = new WordPressWapl;

if(is_front_page() AND get_option('architect_home_bycat'))
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
	if(have_posts())
	{
		while(have_posts())
		{
			the_post();
			$waplString .= $wapl->chunk('words', array('class' => 'entry_row header page', 'display_as' => 'h2', 'quick_text' => $wapl->format_text(get_the_title())));
			
			$pagescale = ARCHITECT_PAGE_IMAGESCALE;
			$getVal = get_option('architect_page_imagescale');
			if($getVal)
			{
				$pagescale = $getVal;
			}
			$pagequality = ARCHITECT_PAGE_IMAGEQUALITY;
			$getVal = get_option('architect_page_imagequality');
			if($getVal)
			{
				$pagequality = $getVal;
			}
			
			$content = get_the_content();
			$content = apply_filters('the_content', $content);
			
			$text = $wapl->format_text($content, $pagescale, $pagequality, 'entry_row page', null, get_option('architect_page_transcol'));
			$waplString .= $wapl->chunk('words', array('class' => 'entry_row', 'quick_text' => $text));
			$themeoption = get_option('architect_theme');
			if($themeoption == 'iphoneLight' OR $themeoption == 'iphoneDark')
			{
				$waplString .= $wapl->chunk('words', array('class' => 'last entry_row page', 'quick_text' => '&#160;'));
			}
		}
	}
}

$waplString .= get_wapl_footer();

process_wapl($waplString);
?>