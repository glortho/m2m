<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */
include_once('functions.php');
if($title = get_option('architect_search_title'))
{
	$title = stripslashes($title);
} else
{
	$title = 'Search Results';
}
$waplString = get_wapl_header('site', array('titleOverride' => $title, 'titleOriginal' => 'Search Results'));
$wapl = new WordPressWapl;

if(have_posts())
{
	$waplString .= $wapl->chunk('words', array('class' => 'search entry_row', 'display_as' => 'h2', 'quick_text' => $title));

	// display navigation
	$navString = '<row class="search navigation">';
	$doEmptyCell = true;
	
	if(get_option('architect_single_showhome'))
	{
		$doEmpty = false;
		if($text = get_option('architect_search_hometext'))
		{
			$text = stripslashes($text);
		} else
		{
			$text = 'Home'; 
		}
		$navString .= $wapl->link(array('row' => false, 'cellClass' => 'navHome', 'url' => htmlspecialchars(get_option('home')), 'label' => $text));
	}
	
	// Older entries
	if(function_exists('get_next_posts_link'))
	{
		if(get_next_posts_link())
		{
			$doEmptyCell = false;
			if($older = get_option('architect_search_olderentriestext'))
			{
				$older = stripslashes($older);
			} else
			{
				$older = 'Older Entries';
			}
			$navString .= $wapl->link(array('row' => false, 'cellClass' => 'older', 'url' => htmlspecialchars(next_posts(0, false)), 'label' => $older));
		}
	} else if(function_exists('get_next_posts_page_link'))
	{
		$doEmptyCell = false;
		if($older = get_option('architect_search_olderentriestext'))
		{
			$older = stripslashes($older);
		} else
		{
			$older = 'Older Entries';
		}
		$navString .= $wapl->link(array('row' => false, 'url' => htmlspecialchars(get_next_posts_page_link($max_page)), 'label' => $older));
	}

	// Newer entries
	if(function_exists('get_previous_posts_link'))
	{
		if(get_previous_posts_link())
		{
			$doEmptyCell = false;
			if($newer = get_option('architect_search_newerentriestext'))
			{
				$newer = stripslashes($older);
			} else
			{
				$newer = 'Newer Entries';
			}
			$navString .= $wapl->link(array('row' => false, 'cellClass' => 'newer', 'url' => htmlspecialchars(previous_posts(0, false)), 'label' => $newer));
		}
	} else if(function_exists('get_previous_posts_page_link'))
	{
		$doEmptyCell = false;
		if($newer = get_option('architect_search_newerentriestext'))
		{
			$newer = stripslashes($older);
		} else
		{
			$newer = 'Newer Entries';
		}
		$navString .= $wapl->link(array('row' => false, 'url' => htmlspecialchars(get_previous_posts_page_link()), 'label' => $newer));
	}

	if($doEmptyCell)
	{
		$navString .= '<cell></cell>';
	}
	
	$navString .= '</row>';
	
	$waplString .= $navString;
	
	while(have_posts())
	{
		the_post();
		
		$waplString .= $wapl->link(array('rowClass' => 'entry_row h2', 'label' => $wapl->format_text(get_the_title()), 'url' => htmlspecialchars(apply_filters('the_permalink', get_permalink()))));
		
		// Show the author
		if(get_option('architect_showauthor'))
		{
			$authorUrl = get_author_posts_url(get_the_author_ID());
			if($prefix = get_option('architect_search_writtenbytext'))
			{
				$prefix = stripslashes($prefix);
			} else
			{
				$prefix = 'Written by';
			}
			$waplString .= $wapl->link(array('rowClass' => 'author_row search', 'cellClass' => 'author', 'prefix' => $prefix.': ', 'label' => get_the_author(), 'url' => htmlspecialchars($authorUrl)));
		}
		
		$waplString .= $wapl->chunk('words', array('class' => 'search post-date', 'quick_text' => apply_filters('the_time', get_the_time('F jS, Y'), 'F jS, Y')));
		
		if(get_option('architect_search_showtags'))
		{
			if(function_exists('get_the_terms'))
			{
				if($tagVal = get_option('architect_search_tagstext'))
				{
					$tagString = stripslashes($tagVal).': ';
				} else
				{
					$tagString = 'Tags: ';
				}
				$tags = get_the_terms(0, 'post_tag');
				if(!empty($tags))
				{
					foreach($tags as $val)
					{
						$link = get_term_link($val, 'post_tag');
						$tagString .= '[url='.$link.']'.$val->name.'[/url], ';
					}
				}
				$tagString = rtrim($tagString, ',');
				
				$waplString .= $wapl->chunk('words', array('class' => 'postmetadata tags', 'quick_text' => $tagString));
			}
		}
		if(get_option('architect_search_showcategories'))
		{
			if($catVal = get_option('architect_search_postedintext'))
			{
				$catString = stripslashes($catVal).': ';
			} else
			{
				$catString = 'Posted in: ';
			}
			if(function_exists('get_the_ID'))
			{
				$categories = get_the_category(get_the_ID());
			} else
			{
				global $id;
				$categories = get_the_category($id);
			}
			foreach($categories as $category)
			{
				if(isset($category->name))
				{
					$catString .= '[url='.get_category_link($category->term_id).']'.$category->name.'[/url], ';
				} else if(isset($category->cat_name))
				{
					$catString .= '[url='.get_category_link($category->cat_ID).']'.$category->cat_name.'[/url], ';
				}
			}
			$catString = rtrim($catString,',');
			
			$waplString .= $wapl->chunk('words', array('class' => 'postmetadata categories', 'quick_text' => $catString));
		}
	}
	
	$waplString .= $navString;
	
} else
{
	if($notext = get_option('architect_search_notext'))
	{
		$notext = stripslashes($notext);
	} else
	{
		$notext = 'No posts found. Try a different search?';
	}
	$waplString .= $wapl->chunk('words', array('display_as' => 'h2', 'quick_text' => $notext));
	$waplString .= get_wapl_element('search_box');
}

$waplString .= get_wapl_footer();
process_wapl($waplString);
?>