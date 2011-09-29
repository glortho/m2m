<?php
// Setup any theme specific functions
architect_theme_functions();

$wapl = new WordPressWapl;
$waplString = '';

if(isset($queryStringOptions['query_posts']))
{
	query_posts($queryStringOptions['query_posts']);
} else
{
	query_posts($queryStringOptions['queryString']);
}

if(!isset($queryStringOptions['showFirstImage'])) $queryStringOptions['showFirstImage'] = false;
if(!isset($queryStringOptions['showNavHome'])) $queryStringOptions['showNavHome'] = false;
if(!isset($queryStringOptions['homeText'])) $queryStringOptions['homeText'] = '';

$showAll = false;

if(get_current_theme() == 'eBusiness')
{
	global $ebusiness_color, $ebusiness_scroller_number, $ebusiness_home_page_1, $ebusiness_home_page_2, $ebusiness_home_page_3, $ebusiness_home_page_4, $ebusiness_homepage_posts, $ebusiness_rss, $ebusiness_slider_1_button, $ebusiness_slider_1_title, $ebusiness_slider_1_image, $ebusiness_slider_1_video, $ebusiness_slider_1_content, $ebusiness_slider_1_readmore_url, $ebusiness_slider_2_button, $ebusiness_slider_2_title, $ebusiness_slider_2_image, $ebusiness_slider_2_video, $ebusiness_slider_2_content, $ebusiness_slider_2_readmore_url, $ebusiness_thumbnail_size, $ebusiness_thumbnail_quality, $ebusiness_thumbnail_size_index, $ebusiness_content_limit, $ebusiness_sort_cat, $ebusiness_order_cat, $include_cats, $strdepth2, $ebusiness_banner_468_url, $ebusiness_banner_468, $ebusiness_grab_image, $ebusiness_blogstyle_homeposts, $ebusiness_catnum_posts;

	$ebusiness_home_page_1 = str_replace('&amp;','&',$ebusiness_home_page_1);
	$ebusiness_home_page_2 = str_replace('&amp;','&',$ebusiness_home_page_2);
	$ebusiness_home_page_3 = str_replace('&amp;','&',$ebusiness_home_page_3); 
	$ebusiness_home_page_4 = str_replace('&amp;','&',$ebusiness_home_page_4); 

	require_once(TEMPLATEPATH . '/includes/functions/custom_functions.php'); 
	
	$showAll = true;
	$pageArr = array();

	for($i = 1; $i <= get_option('ebusiness_home_page_number'); $i++)
	{
		$page = 'ebusiness_home_page_'.$i;
		$pageArr[] = get_pageId($$page);
	}

	wp_reset_query();
	query_posts(array('order' => 'ASC', 'post_type' =>'page', 'post__in' => $pageArr));
}

if(have_posts())
{
	$i = 2;

	// Get access key value
	$accessKey = get_option('architect_accesskeys');
	
	// Set image scale and quality
	$homepagescale = ARCHITECT_HOME_IMAGESCALE;
	$getVal = get_option('architect_home_imagescale');
	if($getVal)
	{
		$homepagescale = $getVal;
	}
	$homepagequality = ARCHITECT_HOME_IMAGEQUALITY;
	$getVal = get_option('architect_home_imagequality');
	if($getVal)
	{
		$homepagequality = $getVal;
	}
	
	// Get show author value
	$getShowAuthor = get_option('architect_showauthor');
	// Get show date value
	$getShowDate = get_option('architect_home_showdate');
	// Get show excerpt value
	$getShowExcerpt = get_option('architect_home_showexcerpt');
	// Get read more
	$getReadMore = get_option('architect_home_showmore');
	// Get read more text
	if(!$getReadMoreText = get_option('architect_home_readmore'))
	{
		$getReadMoreText = 'read more...';
	}
	
	while(have_posts())
	{
		the_post();
		
		$architect_home_showfirstimage = $queryStringOptions['showFirstImage'];
		
		// Title
		if($accessKey && $i < 10)
		{
			$accessKeyVal = $i;
		} else
		{
			$accessKeyVal = false;
		}
		
		$excerptOrig = get_the_excerpt();
		
		if(isset($queryStringOptions['removeCaptions']) && $queryStringOptions['removeCaptions'] == true)
		{
			$excerptOrig = preg_replace('/\[caption(.*?)\[\/caption\]/', '', $excerptOrig);
		}
		if($architect_home_showfirstimage)
		{
			global $more;
			$more = 1;
			$excerptImg = get_the_content();
		
			// Get first image in post
			$src = architect_str_get_html($excerptImg);
			$firstImageAll = $src->find("img");
			$firstImage = false;
			foreach($firstImageAll as $val)
			{
				if(!doScaleImageParent($val))
				{
					continue;
				}
				if(doScaleImage($val->class, $val))
				{
					$firstImage = $val;
					break;
				}
			}
			
			if(empty($firstImageAll) AND get_current_theme() == 'AutoFocus')
			{
				$firstImage->src = architect_the_post_image_url();
			}
			
			if($firstImage)
			{
				$doRow = false;
				$doCell = true;
				$waplString .= '<row class="entry_row h2">';
				
				if($getShowDate)
				{
					$doCell = false;
					$waplString .= '<cell class="entry_row h2 imagePreview">';
				}
				
				if(get_option('architect_showtitlelink') != -1)
				{
					$waplString .= $wapl->link(array('accessKey' => $accessKeyVal, 'row' => $doRow, 'cell' => $doCell, 'cellClass' => 'entry_row h2 imagePreview', 'rowClass' => 'entry_row h2 imagePreview', 'display_as' => 'h2', 'label' => $wapl->format_text(strip_tags(architectCharsOther(get_the_title()))), 'url' => htmlspecialchars(apply_filters('the_permalink', get_permalink()))));
				}
				
				if($getShowDate)
				{
					$waplString .= $wapl->chars(array('row' => false, 'cell' => false, 'class' => 'post-date', 'make_safe' => true, 'value' => apply_filters('the_time', get_the_time('F jS, Y'), 'F jS, Y')));
					$waplString .= '</cell>';
				}
				
				$fileType = substr($firstImage->src,(strrpos($firstImage->src,'.')+1));
				if($fileType == 'jpeg')
				{
					$fileType = 'jpg';
				}

				if(get_option('architect_firstimageaslink'))
				{
					$waplString .= $wapl->link(array(
						'children' => array(
							'img1' => array(
								'tag' => 'image', 
								'options' => array(
									'row' => false,
									'cell' => false,
									'safe_width' => 0,
									'border_styles' => 0,
									'url' => htmlspecialchars($firstImage->src), 
									'filetype' => $fileType, 
									'scale' => $homepagescale, 
									'quality' => $homepagequality, 
									'transcol' => get_option('architect_home_transcol')
								)
							)),
						'url' => htmlspecialchars(apply_filters('the_permalink', get_permalink())),
						'accessKey' => $accessKeyVal,
						'cellClass' => 'entry_row h2 homePageImage',
						'row' => false
					));
				} else
				{
					$waplString .= $wapl->image(array('row' => false, 'border_styles' => 0, 'safe_width' => 0, 'cellClass' => 'homePageImage', 'url' => htmlspecialchars($firstImage->src), 'filetype' => $fileType, 'scale' => $homepagescale, 'quality' => $homepagequality, 'transcol' => get_option('architect_home_transcol')));
				}
				
				$waplString .= '</row>';
			} else
			{
				if(get_option('architect_showtitlelink') != -1)
				{
					$waplString .= $wapl->link(array('accessKey' => $accessKeyVal, 'cellClass' => 'entry_row h2', 'display_as' => 'h2', 'label' => $wapl->format_text(strip_tags(architectCharsOther(get_the_title()))), 'url' => htmlspecialchars(apply_filters('the_permalink', get_permalink()))));
				}
				
				if($getShowDate)
				{
					$waplString .= $wapl->chunk('words', array('class' => 'post-date', 'quick_text' => apply_filters('the_time', get_the_time('F jS, Y'), 'F jS, Y')));
				}
			}
		} else
		{
			if(get_option('architect_showtitlelink') != -1)
			{
				$waplString .= $wapl->link(array('accessKey' => $accessKeyVal, 'rowClass' => 'entry_row_row h2_row', 'cellClass' => 'entry_row h2', 'display_as' => 'h2', 'label' => $wapl->format_text(strip_tags(architectCharsOther(get_the_title()))), 'url' => htmlspecialchars(apply_filters('the_permalink', get_permalink()))));
			}
			if($getShowDate)
			{
				$waplString .= $wapl->chunk('words', array('class' => 'post-date', 'quick_text' => apply_filters('the_time', get_the_time('F jS, Y'), 'F jS, Y')));
			}
		}
		
		// Show the author
		if($getShowAuthor)
		{
			$authorUrl = htmlspecialchars(get_author_posts_url(get_the_author_ID()));
			$waplString .= $wapl->link(array('rowClass' => 'author_row', 'cellClass' => 'author', 'prefix' => 'Written by: ', 'label' => get_the_author(), 'url' => $authorUrl));
		}
		
		if($getShowExcerpt)
		{
			if($showAll)
			{
				$excerpt = $excerptOrig = strip_tags(get_the_content());
			}
			if(!$excerptLength = get_option('architect_home_excerpt_override'))
			{
				$excerptLength = 300;
			}

			if(strlen($excerptOrig) > $excerptLength)
			{
				$excerpt = strip_tags(substr($excerptOrig, 0, $excerptLength)).'...';
				$excerpt = str_replace('&#...', '...', $excerpt);
			}  else
			{
				$excerpt = $excerptOrig;
			}
			$content = $wapl->format_text($excerpt, $homepagescale, $homepagequality, 'entry_row', null, get_option('architect_home_transcol'));

			$waplString .= $wapl->chunk('words', array('class' => 'entry_row excerpt', 'quick_text' => $content));
		}
		
		if($getReadMore)
		{
			$waplString .= $wapl->link(array('cellClass' => 'entry_row readmore', 'label' => $getReadMoreText, 'url' => htmlspecialchars(apply_filters('the_permalink', get_permalink()))));
		}
		$i++;	
	}
	
	// Get next posts page
	global $paged, $wp_query;
	$max_page = 0;

	if ( !$max_page ) 
	{
		$max_page = $wp_query->max_num_pages;
	}

	if ( !$paged )
	{
		$paged = 1;
	}
	$nextpage = intval($paged) + 1;

	if ( !is_single() && ( empty($paged) || $nextpage <= $max_page) ) {
		$nextUrl = next_posts( $max_page, false );
	}
	
	if(isset($queryStringOptions['showNav']) && $queryStringOptions['showNav'] == true)
	{
		$navString = '<wordsChunk class="navigation archiveNavigation"><quick_text>';
		$prevlink = '';
		$nextlink = '';
		$emptyCell = true;
		
		if($queryStringOptions['showNavHome'] == true)
		{
			$navString .= '[span=home][url='.htmlspecialchars(get_option('home')).']'.stripslashes($queryStringOptions['homeText']).'[/url][/span]';
			$emptyCell = false;
		}
	
		if(isset($nextUrl))
		{
			$themeoption = get_option('architect_theme');
			if($emptyCell == false AND $themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
			{
				$navString .= ' | ';
			}
			$navString .= '[span=previous][url='.htmlspecialchars(str_replace('&#038;', '&', $nextUrl)).']'.stripslashes($queryStringOptions['olderText']).'[/url][/span]';
			$emptyCell = false;
		}
		
		if ( !is_single() && $paged > 1 ) 
		{
			$prevUrl = previous_posts( false );
		}
		
		if(isset($prevUrl))
		{
			$themeoption = get_option('architect_theme');
			if($emptyCell == false AND $themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
			{
				$navString .= ' | ';
			}
			$navString .= '[span=next][url='.htmlspecialchars(str_replace('&#038;', '&', $prevUrl)).']'.stripslashes($queryStringOptions['newerText']).'[/url][/span]';
			$emptyCell = false;
			
		}
		
		$navString .= '</quick_text></wordsChunk>';
		
		$waplString .= $navString;
	}
} else
{
	if(!isset($queryStringOptions['showErrors']) OR $queryStringOptions['showErrors'] == true)
	{
		$waplString .= $wapl->chunk('words', array('display_as' => 'h2', 'quick_text' => 'Not Found'));
		$waplString .= $wapl->chunk('words', array('quick_text' => 'Sorry, but you are looking for something that isn\'t here.'));
	}
}

return $waplString;
?>