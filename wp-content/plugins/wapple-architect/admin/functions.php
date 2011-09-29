<?php
function architect_save_option($option, $options = array())
{
	// Strip tags out
	if(isset($options['stripTags']) && $options['stripTags'] == true)
	{
		$tagAllow = '';
		if(!empty($options['tagAllow']))
		{
			$tagAllow .= '<';
			$tagAllow .= implode('><', $options['tagAllow']);
			$tagAllow .= '>';
		}
		$_POST[$option] = strip_tags($_POST[$option], $tagAllow);
	} 
	
	if($_POST[$option] != get_option($option))
	{
		update_option($option, $_POST[$option]);
		return true;
	}
}

function architect_add_headerimage()
{
	echo '<input type="file" name="architect_add_headerimage" id="architect_add_headerimage" />';
}

if(!function_exists('architect_admin_header'))
{
	function architect_admin_header($h, $value)
	{
		return '<tr><td colspan="2" class="architectHeader"><h'.$h.'><img src="'.WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/admin/architect32.png" alt="Wapple Architect" class="architectHeaderImage" />'.$value.'</h'.$h.'></td></tr>';
	}
}
if(!function_exists('architect_table_start'))
{
	function architect_table_start()
	{
		return '<table class="form-table architectTable" cellspacing="2" cellpadding="5">';
	}
}
if(!function_exists('architect_admin_option'))
{
	function architect_admin_option($type, $options = array())
	{
		$string  = '<tr>';
		if($type != 'text')
		{
			$string .= '<th width="30%" valign="top" class="architectCell"';
			if(isset($options['hidden']) AND $options['hidden'] == true)
			{
				$string .= ' style="display:none;"';
			}
			$string .= '>';
			
			if(isset($options['name']))
			{
				$string .= '<label for="'.$options['name'].'">'.$options['label'].': </label>';
			}
			$string .= '</th>';
			$string .= '<td';
			if(isset($options['hidden']) AND $options['hidden'] == true)
			{
				$string .= ' style="display:none;"';
			}
			
			$string .= '>';
		}  else
		{
			$string .= '<td colspan="2"';
			if(isset($options['hidden']) AND $options['hidden'] == true)
			{
				$string .= ' style="display:none;"';
			}
			$string .= '>';
		}
		
		switch($type)
		{
			case 'input' : 
				if(!isset($options['size']))
				{
					$options['size'] = 40;
				}
				if(isset($options['before']) AND $options['before'] != '')
				{
					$string .= $options['before'];
				}
				$string .= '<input';
				
				if($options['size'] == 40)
				{
					$string .= ' class="regular-text architectInput"';
				}
				$string .= ' size="'.$options['size'].'" type="text" name="'.$options['name'].'" id="'.$options['name'].'" value="'.$options['value'].'" />';
				
				if(isset($options['after']) AND $options['after'] != '')
				{
					$string .= $options['after'];
				}
				break;
			case 'select' :
				$string .= '<select name="'.$options['name'].'" class="architectSelect';
				
				if(isset($options['multiple']) && $options['multiple'] == true)
				{
					$string .= ' architectMultiple" multiple size="5"';
				} else
				{
					$string .= '"';
				}
				
				$string .= '>';
				if(isset($options['multiple']) && $options['multiple'] == true)
				{
					$values = explode('|', $options['value']);
					
					foreach($values as $key => $val)
					{
						$val = preg_replace('/(?!&#)&/', '&amp;', $val);
						$values[$key] = stripslashes($val);
					}

					foreach($options['options'] as $key => $val)
					{
						$originalKey = stripslashes($key);
						$originalVal = stripslashes($val);
						$string .= '<option value="'.$originalKey.'"';
						$val = preg_replace('/(?!&#)&/', '&', $originalVal);
						
						if(in_array($key, $values))
						{
							$string .= ' selected="selected"';
						}
						$string .= '>'.$originalVal.'</option>';
					}
				} else
				{
					foreach($options['options'] as $key => $val)
					{
						$string .= '<option value="'.$key.'"';
					
						if($key == $options['value'])
						{
							$string .= ' selected="selected"';
						}
						
						$string .= '>'.$val.'</option>';
					}
				}
				$string .= '</select>';
				break;
			case 'file' :
				$string .= '<input type="file" name="'.$options['name'].'" id="'.$options['name'].'" class="architectInput" />';
				break;
			case 'image' :
				$string .= '<img src="'.$options['src'].'" alt="'.$options['alt'].'" class="architectImage" />';
				break;
			case 'textarea' :
				if(!isset($options['rows']))
				{
					$options['rows'] = 25;
				}
				if(!isset($options['cols']))
				{
					$options['cols'] = 70;
				}
				$string .= '<textarea class="architectTextarea" id="'.$options['name'].'" name="'.$options['name'].'" rows="'.$options['rows'].'" cols="'.$options['cols'].'">'.$options['value'].'</textarea>';
				break;
			case 'text' :
				$string .= '<p>';
				if(isset($options['bold'])) $string .= '<strong>';
				if(isset($options['italic'])) $string .= '<em>';
				
				$string .= $options['value'];
				
				if(isset($options['italic'])) $string .= '</em>';
				if(isset($options['bold'])) $string .= '</strong>';
				$string .= '</p>';
				break;
			
		}
		
		if(isset($options['description']) && $type != 'text')
		{
			$string .= '<span class="description"><br />'.$options['description'].'</span>';
		}
		
		$string .= '</td></tr>';
		return $string;
	}
}

function architect_check_path($path)
{
	$path = str_replace(WP_UPLOAD_DIR, '', $path);
	
	$dirExplode = explode(DIRECTORY_SEPARATOR, $path);
	$pathToCheck = WP_UPLOAD_DIR;
	foreach($dirExplode as $key => $val)
	{
		if(!file_exists($pathToCheck))
		{
			if(@mkdir($pathToCheck))
			{
				chmod($pathToCheck, 0777);
			}
		}
		$pathToCheck .= $val.DIRECTORY_SEPARATOR;
	}
}

function architect_filter_plugin_links($links, $file)
{
	if ( $file == plugin_basename(__FILE__) )
	{
		$links[] = '<a href="admin.php?page=architect-basic">' . __('Settings') . '</a>';
	}
	
	return $links;
}

function architect_plugin_action_links($links, $file)
{
	if(basename($file) != 'architect.php')
		return $links;
	$url = "admin.php?page=architect-status";

	$settings_link = '<a href="'.esc_attr($url).'">'.esc_html(__('Settings', 'wapple-architect')).'</a>';
	array_unshift( $links, $settings_link );
	return $links;
}

function architect_options_status()
{
	require_once('options-status.php');
}
function architect_options_basic()
{
	require_once('options-basic.php');
}
function architect_options_advanced()
{
	require_once('options-advanced.php');
}
function architect_options_home()
{
	require_once('options-home.php');
}
function architect_options_homebycat()
{
	require_once('options-homecat.php');
}
function architect_options_posts()
{
	require_once('options-posts.php');
}
function architect_options_pages()
{
	require_once('options-pages.php');
}
function architect_options_archives()
{
	require_once('options-archives.php');
}
function architect_options_search()
{
	require_once('options-search.php');
}
function architect_options_sidebar()
{
    require_once('options-sidebar.php');
}
function architect_options_theme()
{
	require_once('options-theme.php');
}
function architect_options_advertising()
{
	require_once('options-advertising.php');
}
function architect_options_page()
{
	require_once('options-old.php');
}

if (!function_exists('file_put_contents'))
{
	function file_put_contents($filename, $data)
	{
		$f = @fopen($filename, 'w');
		if (!$f)
		{
			return false;
		} else 
		{
			$bytes = fwrite($f, $data);
			fclose($f);
			return $bytes;
		}
	}
}

// Architect install script 
function architect_install()
{
	if(!get_option('architect_install'))
	{
		if(!$blog_id = get_option('blog_id'))
		{
			$blog_id = 0;
		}
		
		global $wpdb;
		
		$sql = '
		INSERT INTO `'.$wpdb->prefix.'options` 
		(`blog_id`, `option_name`, `option_value`, `autoload`) 
		VALUES
		('.$blog_id.', \'architect_headerimagelinktohome\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_home_showdate\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_show_blogtitle\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_use_meta\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_doform\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_accesskeys\', \'0\', \'yes\'),
		('.$blog_id.', \'architect_home_removecaptions\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_home_showexcerpt\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_home_imagescale\', \'35\', \'yes\'),
		('.$blog_id.', \'architect_home_imagequality\', \'95\', \'yes\'),
		('.$blog_id.', \'architect_home_olderposts\', \'older posts\', \'yes\'),
		('.$blog_id.', \'architect_home_readmore\', \'read more\', \'yes\'),
		('.$blog_id.', \'architect_single_imagescale\', \'50\', \'yes\'),
		('.$blog_id.', \'architect_single_imagequality\', \'95\', \'yes\'),
		('.$blog_id.', \'architect_page_imagescale\', \'50\', \'yes\'),
		('.$blog_id.', \'architect_page_imagequality\', \'95\', \'yes\'),
		('.$blog_id.', \'architect_single_paginglength\', \'2000\', \'yes\'),
		('.$blog_id.', \'architect_single_allowcomments\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_single_showcomments\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_single_dopaging\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_showfootertext\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_single_showhome\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_single_nextpage\', \'more\', \'yes\'),
		('.$blog_id.', \'architect_single_prevpage\', \'back\', \'yes\'),
		('.$blog_id.', \'architect_single_previouspost\', \'previous post\', \'yes\'),
		('.$blog_id.', \'architect_single_nextpost\', \'next post\', \'yes\'),
		('.$blog_id.', \'architect_single_homepost\', \'home\', \'yes\'),
		('.$blog_id.', \'architect_single_shownext\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_single_showtags\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_single_gravatarsupport\', \'1\', \'yes\'),
		('.$blog_id.', \'architect_single_tagtext\', \'Tag\', \'yes\'),
		('.$blog_id.', \'architect_single_metadatatext\', \'This entry was posted on <date> at <time> and is filed under <category>\', \'yes\'),
		('.$blog_id.', \'architect_single_commentsaystext\', \'says\', \'yes\'),
		('.$blog_id.', \'architect_single_commentsingletext\', \'comment\', \'yes\'),
		('.$blog_id.', \'architect_single_commentpluraltext\', \'comments\', \'yes\'),
		('.$blog_id.', \'architect_single_leaveareplytext\', \'Leave a Reply\', \'yes\'),
		('.$blog_id.', \'architect_single_leaveareplynametext\', \'Name\', \'yes\'),
		('.$blog_id.', \'architect_single_leaveareplyemailtext\', \'Email\', \'yes\'),
		('.$blog_id.', \'architect_single_leaveareplywebsitetext\', \'Website\', \'yes\'),
		('.$blog_id.', \'architect_single_leaveareplycommenttext\', \'Comment\', \'yes\'),
		('.$blog_id.', \'architect_single_leaveareplysubmittext\', \'Submit\', \'yes\'),
		('.$blog_id.', \'architect_single_passwordtext\', \'Enter post password\', \'yes\'),
		('.$blog_id.', \'architect_single_passwordbuttontext\', \'Submit\', \'yes\'),
		('.$blog_id.', \'architect_archive_cattext\', \'Archive for the \"<category>\" Category\', \'yes\'),
		('.$blog_id.', \'architect_archive_tagtext\', \'Posts tagged \"<tag>\"\', \'yes\'),
		('.$blog_id.', \'architect_archive_datetext\', \'Archive for\', \'yes\'),
		('.$blog_id.', \'architect_archive_authortext\', \'Author Archive\', \'yes\'),
		('.$blog_id.', \'architect_archive_blogarchivetext\', \'Blog Archives\', \'yes\'),
		('.$blog_id.', \'architect_archive_hometext\', \'Home\', \'yes\'),
		('.$blog_id.', \'architect_archive_olderentriestext\', \'Older Entries\', \'yes\'),
		('.$blog_id.', \'architect_archive_newerentriestext\', \'Newer Entries\', \'yes\'),
		('.$blog_id.', \'architect_archive_nocattext\', "Sorry, there aren\'t any posts in the <category> category yet.", \'yes\'),
		('.$blog_id.', \'architect_archive_nodatetext\', "Sorry, but there aren\'t any posts with this date.", \'yes\'),
		('.$blog_id.', \'architect_archive_noauthortext\', "Sorry, but there aren\'t any posts by <author> yet.", \'yes\'),
		('.$blog_id.', \'architect_archive_nopoststext\', "No posts found", \'yes\'),
		('.$blog_id.', \'architect_advanced_404text\', "Error 404 - Not Found", \'yes\'),
		('.$blog_id.', \'architect_home_posts_per_page\', \''.get_option('posts_per_page').'\', \'yes\'),
		('.$blog_id.', \'architect_home_excerpt_override\', \'300\', \'yes\'),
		('.$blog_id.', \'architect_search_title\', \'Search Results\', \'yes\'),
		('.$blog_id.', \'architect_search_hometext\', \'Home\', \'yes\'),
		('.$blog_id.', \'architect_search_olderentriestext\', \'Older Entries\', \'yes\'),
		('.$blog_id.', \'architect_search_newerentriestext\', \'Newer Entries\', \'yes\'),
		('.$blog_id.', \'architect_search_writtenbytext\', \'Written by\', \'yes\'),
		('.$blog_id.', \'architect_search_tagstext\', \'Tags\', \'yes\'),
		('.$blog_id.', \'architect_search_postedintext\', \'Posted in\', \'yes\'),
		('.$blog_id.', \'architect_search_notext\', \'No posts found. Try a different search?\', \'yes\'),
		('.$blog_id.', \'architect_search_boxtitletext\', \'Search\', \'yes\'),
		('.$blog_id.', \'architect_search_boxsubmittext\', \'Submit\', \'yes\'),
		('.$blog_id.', \'architect_theme\', \'iphoneLight\', \'yes\'),
		('.$blog_id.', \'architect_showfootertext\', \'Powered by [url=http://http://mobilewebjunkie.com/wordpress-mobile-plugin-install-guide-and-faq/]Wapple Architect Mobile Plugin[/url]\', \'yes\')';
		$result = $wpdb->query($sql);
		
		// Check a few paths exist
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'header'.DIRECTORY_SEPARATOR;
		architect_check_path($file);
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'footer'.DIRECTORY_SEPARATOR;
		architect_check_path($file);
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'postHeader'.DIRECTORY_SEPARATOR;
		architect_check_path($file);
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR;
		architect_check_path($file);
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css';
		architect_check_path($file);
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'custom_style.css';
		architect_check_path($file);
		
		// Copy stylesheet to default location
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css';
		
		if(!file_exists($file))
		{
			@file_put_contents($file, "");
			if(is_writable($file))
			{
				file_put_contents($file, file_get_contents(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'style.css'));
			}
		}
		
		// Copy custom stylesheet to default location
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'custom_style.css';
		if(!file_exists($file))
		{
			@file_put_contents($file, "");
			if(is_writable($file))
			{
				file_put_contents($file, file_get_contents(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'custom_style.css'));
			}
		}
		update_option('architect_install', "1");
	}
}
?>