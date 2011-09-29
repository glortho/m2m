<?php
/**
 * @package Wapple_Architect
 * @subpackage WAPL Theme
 */
include_once('functions.php');
$waplString = get_wapl_header('single');
$wapl = new WordPressWapl;

// Setup any theme specific functions
architect_theme_functions();

if(have_posts())
{
	while(have_posts())
	{
		the_post();
		
		//Open the row
		$navString = '';
		$themeoption = get_option('architect_theme');
		
		if(get_option('architect_single_showhome'))
		{
			
			$home = stripslashes(get_option('architect_single_homepost'));
			if(!$home)
			{
				$home = 'Home';
			}
			$homeString = '[span=home][url='.htmlspecialchars(get_option('home')).']'.$home.'[/url][/span]';
			if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
			{
				$homeString .= '| ';
				$navString .= $homeString;
			}
		}
		
		if(get_option('architect_single_shownext'))
		{
			// Get next and previous posts
			$prevlink = '';
			$nextlink = '';
			if(function_exists('get_adjacent_post'))
			{
				$prevlink = get_permalink(get_adjacent_post(false, '', true));
				$nextlink = get_permalink(get_adjacent_post(false, '', false));
			} else if(function_exists('get_previous_post'))
			{
				$prevlink = get_permalink(get_previous_post(false, ''));
				$nextlink = get_permalink(get_next_post(false, ''));
			}
			
			// previous post link
			if($prevlink != get_permalink())
			{
				$previouspost = get_option('architect_single_previouspost');
				if(!$previouspost)
				{
					$previouspost = 'previous post';
				}
				$navString .= '[span=previous][url='.htmlspecialchars($prevlink).']'.stripslashes($previouspost).'[/url][/span]';
				if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
				{
					$navString .= '| ';
				}
			}
			
			if($themeoption == 'iphoneLight' OR $themeoption == 'iphoneDark')
			{
				$navString .= $homeString;
			}
			
			// next post link
			if($nextlink != get_permalink())
			{
				$nextpost = get_option('architect_single_nextpost');
				if(!$nextpost)
				{
					$nextpost = 'next post';
				}
				
				$navString .= '[span=next][url='.htmlspecialchars($nextlink).']'.stripslashes($nextpost).'[/url][/span]';
				if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
				{
					$navString .= '| ';
				}
			}
		}
		
		if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
		{
			$navString = substr($navString, 0, (strlen($navString) - 2));
		}
		$waplString .= $wapl->chunk('words', array('class' => 'navigation', 'quick_text' => $navString));
		
		$waplString .= $wapl->chunk('words', array('class' => 'postTitle', 'display_as' => 'h2', 'quick_text' => $wapl->format_text(get_the_title())));
		
		// Any theme specific stuff
		$waplString .= architect_theme_header($wapl);
		
		// Show the author
		if(get_option('architect_showauthor'))
		{
			$authorUrl = get_author_posts_url(get_the_author_ID());
			$waplString .= $wapl->link(array('cellClass' => 'author singlepost', 'rowClass' => 'authorRow singlepost_row', 'prefix' => 'Written by: ', 'label' => get_the_author(), 'url' => htmlspecialchars($authorUrl)));
		} else if($themeoption == 'iphoneLight' OR $themeoption == 'iphoneDark')
		{
			$waplString .= $wapl->chunk('words', array('class' => 'postTop', 'quick_text' => '&#160;'));
		}
				
		// Sanity checking on content
		$singlepagescale = ARCHITECT_SINGLE_IMAGESCALE;
		$getVal = get_option('architect_single_imagescale');
		if($getVal)
		{
			$singlepagescale = $getVal;
		}
		$singlepagequality = ARCHITECT_SINGLE_IMAGEQUALITY;
		$getVal = get_option('architect_single_imagequality');
		if($getVal)
		{
			$singlepagequality = $getVal;
		}
		
		if(get_option('architect_single_dopaging'))
		{
			if(!$length = get_option('architect_single_paginglength'))
			{
				$length = null;
			}
		} else
		{
			$length = null; 
		}
		
		// Is the post password protected
		$protected = false;
		$post = get_post($id);
		if(post_password_required($post)) 
		{
			$protected = true;
			if(!$label = get_option('architect_single_passwordtext'))
			{
				$label = 'Enter post password';
			}
			$waplString .= '<row><cell><form><action>/wp-pass.php</action>';
			$waplString .= '<formItem item_type="password"><label>'.stripslashes($label).'</label><name>post_password</name></formItem>';
			
			if(!$label = get_option('architect_single_passwordbuttontext'))
			{
				$label = 'Submit';
			}
			$waplString .= '<formItem item_type="submit"><name>post_submit</name><label>'.stripslashes($label).'</label></formItem>'; 
			$waplString .= '</form></cell></row>';
		}
		
		if(!$protected)
		{
			$content = get_the_content();
			$content = do_shortcode($content);

			$content = $wapl->format_text($content, $singlepagescale, $singlepagequality, 'entry_row singlepost', $length, get_option('architect_single_transcol'));
			
			$totalPages = count($wapl->pages);
			if($wapl->currentPage > $totalPages)
			{
				$waplString .= $wapl->chunk('words', array('class' => 'entry_row singlepost', 'quick_text' => 'This page could not be found'));
			} else
			{
				$waplString .= $wapl->chunk('words', array('class' => 'entry_row singlepost', 'quick_text' => $content));
			}
		}
		
		if($wapl->currentPage >= $totalPages)
		{
			if($wapl->currentPage > 1)
			{
				$link = 'page='.($wapl->currentPage - 1);
				if(isset($_GET) AND !empty($_GET) AND (count($_GET) > 1 OR ((count($_GET) == 1) AND (!isset($_GET['page']) OR $_GET['page'] == ''))))
				{
					$link = '&amp;'.$link;
				}  else
				{
					$link = '?'.$link;
				}
				
				$back = get_option('architect_single_prevpage');
				if(!$back)
				{
					$back = 'back';
				}
				$waplString .= $wapl->link(array('rowClass' => 'postBackRow', 'cellClass' => 'postBack', 'label' => htmlspecialchars($back), 'url' => htmlspecialchars(get_permalink().$link)));
			}
			
			// Show tags
			if(get_option('architect_single_showtags') AND !$protected)
			{
				$tags = apply_filters( 'the_tags', get_the_term_list( 0, 'post_tag', '', '', '' ), '', '', '');
				
				require_once('simple_html_dom.php');
				$html = architect_str_get_html($tags);
				
				$linkString = '';
				foreach($html->find('a') as $tag)
				{
					$linkString .= '[url='.$tag->href.']'.$tag->innertext.'[/url] | ';
				}
				
				if(!$tagtext = get_option('architect_single_tagtext'))
				{
					$tagtext = 'Tags';
				}
				$waplString .= $wapl->chunk('words', array('class' => 'postTags', 'quick_text' => stripslashes($tagtext).': '.substr($linkString,0, (strlen($linkString) -2))));
			}
			
			// Details about post
			if(function_exists('get_the_ID'))
			{
				$categories = get_the_category(get_the_ID());
			} else
			{
				global $id;
				$categories = get_the_category($id);
			}
			$catString = '';
			foreach($categories as $cat)
			{
				if(isset($cat->name))
				{
					$catString .= $cat->name.',';
				} else if(isset($cat->cat_name))
				{
					$catString .= $cat->cat_name.',';
				}
			}
			$catString = rtrim($catString,',');
	
			if(!$protected)
			{
				if($metadatatext = get_option('architect_single_metadatatext'))
				{
					$metadatatext = str_replace(
						array('<date>', '<time>', '<category>'),
						array(get_the_time('l, F jS, Y'), get_the_time(), $catString),
						stripslashes($metadatatext)
					);
				} else
				{
					$metadatatext = 'This entry was posted on '.get_the_time('l, F jS, Y').' at '.get_the_time().' and is filed under '.$catString;
				}
				
				$waplString .= $wapl->chunk('words', array('class' => 'postmetadata alt', 'quick_text' => $metadatatext));
			}
			
			if(get_option('architect_single_showcomments') && !$protected)
			{
				// Comments
				global $wpdb;
				if(method_exists($wpdb, 'prepare'))
				{
					$comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d AND  comment_approved = '1' ORDER BY comment_date", get_the_ID()));
				} else
				{
					global $post;
					$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = '$post->ID' AND comment_approved = '1' ORDER BY comment_date");
				}
				
				// number of comments
				$waplString .= $wapl->chunk('words', array('class' => 'postmetadata commentCount'.count($comments).' commentsTitle', 'display_as' => 'h3', 'quick_text' => get_wapl_response_string(get_option('architect_single_responseformat'), count($comments), $wapl->format_text(get_the_title()))));
				if(isset($comments) AND !empty($comments))
				{
					$i = 0;
					$totalI = 1;
					$totalComments = count($comments);
					foreach($comments as $comment)
					{
						$i++;
						if($i == 2)
						{
							$i = 0;
							$commentClass = ' odd';
						} else
						{
							$commentClass = ' even';
						}
						if($totalComments == $totalI)
						{
							$commentClass .= ' last';
						}
						// display all comments
						if($saystext = get_option('architect_single_commentsaystext'))
						{
							$saystext = stripslashes($saystext);
						} else
						{
							$saystext = 'says';
						}
						if(get_option('architect_single_gravatarsupport'))
						{
							preg_match('/\<img(.*?)src=[\"\'](.*?)[\"\'](.*?)\/\>/', get_avatar( $comment->comment_author_email, 16 ), $src);
							
							$gravatartext = '[img=0]'.htmlspecialchars($src[2]).'[/img] ';
						} else
						{
							$gravatartext = '';
						}
						$waplString .= $wapl->chunk('words', array('class' => 'postmetadata waplsmall commentlist'.$commentClass.' commentAuthor', 'quick_text' => $gravatartext.'[b]'.architectCharsAmp(architectCharsOther($comment->comment_author)).' '.$saystext.' :[/b]'));
						$waplString .= $wapl->chunk('words', array('class' => 'postmetadata waplsmall commentlist'.$commentClass.' commentDate', 'quick_text' => get_the_time('l, F jS, Y', $comment->comment_ID)));
						$waplString .= $wapl->chunk('words', array('class' => 'postmetadata waplsmall commentlist'.$commentClass.' commentContent', 'quick_text' => $wapl->format_text($wapl->foreignChars($comment->comment_content))));
						
						if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
						{
							$waplString .= $wapl->chunk('spacemaker', array('scale' => 2));
						}
						
						$totalI++;
					}
				}
				
				if(get_option('architect_single_allowcomments'))
				{
					$waplString .= get_wapl_comments();
				}
			}
		} else if($wapl->currentPage < $totalPages)
		{
			$waplString .= '<row class="postNextPrev">';
			if($wapl->currentPage > 1)
			{
				$link = 'page='.($wapl->currentPage - 1);
				if(isset($_GET) AND !empty($_GET) AND (count($_GET) > 1 OR ((count($_GET) == 1) AND (!isset($_GET['page']) OR $_GET['page'] == ''))))
				{
					$link = '&amp;'.$link;
				}  else
				{
					$link = '?'.$link;
				}
				$back = get_option('architect_single_prevpage');
				if(!$back)
				{
					$back = 'back';
				}
				$waplString .= $wapl->link(array('row' => false, 'cellClass' => 'postPrev', 'label' => $back, 'url' => htmlspecialchars(get_permalink().$link)));
			}
			if($wapl->currentPage < $totalPages)
			{
				$link = 'page='.($wapl->currentPage + 1);
				if(isset($_GET) AND !empty($_GET) AND (count($_GET) > 1 OR ((count($_GET) == 1) AND (!isset($_GET['page']) OR $_GET['page'] == ''))))
				{
					$link = '&amp;'.$link;
				}  else
				{
					$link = '?'.$link;
				}
				$more = get_option('architect_single_nextpage');
				if(!$more)
				{
					$more = 'more';
				}
				$waplString .= $wapl->link(array('row' => false, 'label' => $more, 'cellClass' => 'postNext', 'url' => htmlspecialchars(get_permalink().$link)));
			}
			$waplString .= '</row>';
		}
		
		// Add nav string to bottom
		if(get_option('architect_single_shownext'))
		{
			$waplString .= $wapl->chunk('words', array('class' => 'navigation', 'quick_text' => $navString));
		}
	}
} else
{
	$waplString .= $wapl->chunk('words', array('quick_text' => 'Sorry, no posts matched your criteria.'));
}

$waplString .= get_wapl_footer();

process_wapl($waplString);
?>