<?php 
/**
 * Wapple Architect WAPL Builder class
 * 
 * This class allows you to build WAPL ensuring that it's always valid and
 * always is in line with the schema at http://wapl.wapple.net/wapl.xsd
 * 
 * @author Rich Gubby
 * @link http://mobilewebjunkie.com
 * @version 1.0
 * @package WappleArchitect
 */
class waplBuilder
{
	/**
	 * Any universal attributes that apply to all elements
	 * @access public
	 * @var array
	 */
	var $universalAttributes = array('class', 'id');
	
	/**
	 * The current tag we're building
	 * @access public
	 * @var string
	 */
	var $tag;
	
	/**
	 * Tag prefix - used when a "link" becomes an "externalLink"
	 * @access public
	 * @var string
	 */
	var $tagPrefix;
	
	/**
	 * Parent tag
	 * @access public
	 * @var string
	 */
	var $parentTag;
	
	/**
	 * WAPL schema
	 * @access public
	 * @var array
	 * @todo Make sure it's up to date!
	 */
	var $schema = array(
		'head' => array(
			'children' => array('title')
		),
		'title' => array(
			'direct' => true,
			'parent' => 'head'
		),
		'meta' => array(
			'attributes' => array('name', 'content'),
			'parent' => 'head',
			'selfClosing' => true
		),
		'css' => array(
			'children' => array('url'),
			'parent' => 'head'
		),
		'link' => array(
			'children' => array('url', 'label', 'prefix', 'linkVars', 'insertion', 'suffix', 'prefix', 'externalImage')
		),
		'chars' => array(
			'attributes' => array('make_safe'),
			'children' => array('value')
		),
		'linkVars' => array(
			'parent' => 'link',
			'children' => array('var')
		),
		'var' => array(
			'children' => array('name', 'value'),
			'parent' => 'linkVars'
		),
		'externalLink' => array(
			'children' => array('url', 'label', 'prefix', 'suffix', 'externalImage', 'accessKey')
		),
		'externalImage' => array(
			'attributes' => array('filetype', 'scale', 'quality'),
			'children' => array('url', 'transcol', 'safe_mode', 'alt', 'safe_width', 'border_styles')
		),
		'form' => array(
			'children' => array('action', 'input', 'formItem', 'url')
		),
		'formItem' => array(
			'parent' => 'form',
			'attributes' => array('item_type', 'default'),
			'children' => array('name', 'label', 'value', 'possibility')
		),
		'possibility' => array(
			'parent' => 'formItem',
			'children' => array('label', 'value')
		),
		'rule' => array(
			'attributes' => array('type', 'criteria', 'condition')
		),
		'phonecallChunk' => array(
			'children' => array('phone_number', 'show_label')
		),
		'phonebookChunk' => array(
			'children' => array('phone_number', 'contact_name', 'show_label')
		),
		'rssChunk' => array(
			'children' => array('url', 'max_items', 'items_per_page', 'graphic_scale', 'icon_scale', 'tease_length', 'show_no_tease',
				'do_channel_title', 'do_channel_image', 'do_channel_link', 'do_channel_description', 'do_channel_language',
				'do_channel_copyright', 'do_channel_managing_editor', 'do_channel_webmaster', 'do_channel_publish_date',
				'do_channel_last_build_date', 'do_channel_category', 'do_channel_generator', 'do_channel_documentation', 
				'do_channel_cloud', 'do_channel_ttl', 'do_channel_rating', 'do_channel_text_input', 'do_channel_skip_hours',
				'do_channel_skip_days', 'do_item_title', 'do_item_link', 'do_item_description', 'do_item_author', 
				'do_item_category', 'do_item_comment', 'do_item_comments', 'do_item_enclosure', 'do_item_guid', 
				'do_item_publish_date', 'do_item_source' 
			)
		),
		'rubberduckChunk' => array(
			'children' => array('rubberduck_client_id', 'rubberduck_set_id', 'graphic_scale', 'delivery_performance',
				'display_mode')
		),
		'jumpChunk' => array(
			'children' => array('destination_page', 'url')
		),
		'waplChunk' => array(
			'children' => array('url')
		),
		'wordsChunk' => array(
			'children' => array('display_as', 'quick_text')
		),
		'spacemakerChunk' => array(
			'children' => array('scale')
		),
		'hrChunk' => array(),
		'admobChunk' => array(
			'children' => array('mobile_site_id', 'iphone_site_id', 'iphone_background_color', 'iphone_text_color')
		),
		'decktradeChunk' => array(
			'children' => array('decktrade_siteid')
		),
		'adsenseChunk' => array(
			'children' => array('channel_id', 'client_id', 'items_per_page', 'col_border', 'col_bg', 'col_link', 'col_text', 'col_url')
		),
		'mbrandChunk' => array(
			'children' => array('mbrand_placement_id', 'mbrand_ad_server')
		),
		'mkhojChunk' => array(
			'children' => array('mkhoj_site_id')
		),
		'mobilecommercemmsChunk' => array(
			'children' => array('client_id', 'items_per_page', 'backfill', 'filter_out_adult', 'use_page_keywords', 
				'ad_keyword', 'do_search', 'test_mode'
			)
		),
		'mpressionChunk' => array(
			'children' => array('adslot_id', 'ad_category', 'ad_keyword')
		),
		'nokiaadsChunk' => array(
			'children' => array('nokiaads_spot_name', 'nokiaads_ad_server')
		),
		'stampChunk' => array(
			'children' => array('stamp_si', 'stamp_al', 'stamp_mode', 'items_per_page', 'graphic_scale')
		),
		'zestadzChunk' => array(
			'children' => array('zestadz_cid', 'zestadz_meta')
		),
		'settings' => array(
			'children' => array('name', 'default_page_header', 'bangoPageTrackingId', 'iphoneTextSizeAdjust', 'iphoneUserScaleable', 
			'iphoneInitalScale', 'iphoneMinScale', 'iphoneMaxScale', 'iphoneMagicWidth')
		)
	);
	
	/**
	 * List of tags that don't have rows or cells
	 * @access public
	 * @var array
	 */
	var $noRowTags = array(
		'head', 'title', 'meta', 'css', 'linkVars', 'var', 'formItem', 'possibility', 
		'rule', 'phonecallChunk', 'phonebookChunk', 'rssChunk', 'rubberduckChunk', 
		'jumpChunk', 'waplChunk', 'wordsChunk', 'spacemakerChunk', 'hrChunk', 'admobChunk',
		'decktradeChunk', 'adsenseChunk', 'mbrandChunk', 'mkhojChunk', 'mobilecommercemmsChunk',
		'mpressionChunk', 'nokiaadsChunk', 'stampChunk', 'zestadzChunk', 'settings', 'row', 'cell'
	);
	
	/**
	 * Number of pages in an article
	 * @access public
	 * @var array
	 */
	var $pages = array();
	
	/**
	 * The current page we're on
	 * @access public
	 * @var integer
	 */
	var $currentPage;
	
	/**
	 * Any other tag for php5 only
	 * @param string $name
	 * @param array $arguments
	 * @access public
	 * @return string
	 */
	function __call($name, $options)
	{
		$this->tag = $name;
		$this->__doExternal($options);
		return $this->__do_tag($options[0]);
	}
	
	/**
	 * Build a WAPL head element
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function head($options = array())
	{
		$this->tag = 'head';
		$this->tagPrefix = null;
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a META element
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function meta($options = array())
	{
		$this->tag = 'meta';
		$this->tagPrefix = null;
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a CSS element
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function css($options = array())
	{
		$this->tag = 'css';
		$this->tagPrefix = null;
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a WAPL link element
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function link($options = array())
	{
		$this->tag = 'link';
		$this->__doExternal($options);
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a WAPL image element
	 * 
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function image($options = array())
	{
		$this->tag = 'image';
		$this->__doExternal($options);
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a WAPL chars element
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function chars($options = array())
	{
		$this->tag = 'chars';
		$this->tagPrefix = null;
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a WAPL chunk element
	 * @param string $type
	 * @param array $options
	 * @return string
	 */
	function chunk($type, $options)
	{
		$this->tag = $type.'Chunk';
		$this->tagPrefix = null;
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a WAPL form element (includes all form item elements)
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function form($options = array())
	{
		$this->tag = 'form';
		$this->tagPrefix = null;
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a WAPL rule
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function rule($options)
	{
		$this->tag = 'rule';
		return $this->__do_tag($options);
	}
	
	/**
	 * Build any page settings
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function settings($options)
	{
		$this->tag = 'settings';
		$this->tagPrefix = null;
		return $this->__do_tag($options);
	}
	
	/**
	 * Build a row start tag
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function rowStart($options = array())
	{
		$this->tag = 'row';
		$this->tagPrefix = null;
		return $this->__do_tag_start($options);
	}
	
	/**
	 * Build a row end tag
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function rowEnd($options = array())
	{
		$this->tag = 'row';
		$this->tagPrefix = null;
		return $this->__do_tag_end($options);
	}
	
	/**
	 * Build a cell start tag
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function cellStart($options = array())
	{
		$this->tag = 'cell';
		return $this->__do_tag_start($options);
	}
	
	/**
	 * Build a cell end tag
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function cellEnd($options = array())
	{
		$this->tag = 'cell';
		return $this->__do_tag_end($options);
	}
	
	/**
	 * Format content into WAPL readable format
	 * @param string $content
	 * @param integer $imagescale
	 * @param integer $imagequality
	 * @param string $class
	 * @param integer $length
	 * @param string $transcol
	 * @access public
	 * @return string
	 */
	function format_text($content, $imagescale = 95, $imagequality = 90, $class = '', $length = null, $transcol = '')
	{
		require_once('simple_html_dom.php');
		$html = architect_str_get_html($content);
		
		if(get_option('architect_doform'))
		{
			$text = '';
			
			// Do a bit of cleanup on select boxes that dont have </option> elements
			$cleanup = false;
			preg_match_all('/<select(.*?)<\/select>/is', $content, $matches);
			$innerContent = $content;
			foreach($matches[1] as $key => $val)
			{
				if(strpos($val, '</option>') === false)
				{
					$cleanup = true;
					$innerContent = str_replace($val, str_replace(array('<br>', '<br />'), '</option>', $val), $innerContent);
				}
			}
			
			if($cleanup == true)
			{
				$content = $innerContent;
				$html = architect_str_get_html($content);
			}
			
			// Forms - doing my best but so many ways of doing forms!
			foreach($html->find('form') as $element)
			{
				$text = '</quick_text></wordsChunk><row class="'.$class.'"><cell><form>';
				$text .= '<action>'.$element->action.'</action>';
				
				// Get input
				foreach($element->find('input, textarea, select') as $input)
				{
					$text .= '<formItem item_type="';
					if($input->tag == 'textarea')
					{
						$text .= 'textarea';
						$value = $input->innertext;
					} else if($input->tag == 'input')
					{
						if(!isset($input->type) OR $input->type == '') 
						{
							$text.= 'text';
						} else if($input->type == 'radio')
						{
							$text .= 'checkbox';
						} else if($input->type == 'button')
						{
							$text .= 'submit';
						} else
						{
							$text .= $input->type;
						}
						$value = $input->value;
					} else if($input->tag == 'select')
					{
						$text .= 'select';
					}
					
					$text .= '">';
					
					// Get the label
					if($input->type != 'hidden' && $input->type != 'submit')
					{
						if($input->prev_sibling())
						{
							$sibling = $input->prev_sibling();
							if($sibling->tag == 'label')
							{
								$text .= '<label>'.strip_tags($sibling->innertext).'</label>';
							} else if($siblingBackup = $sibling->prev_sibling())
							{
								if($siblingBackup->tag == 'label')
								{
									$text .= '<label>'.strip_tags($siblingBackup->innertext).'</label>';
								}
							}
						} else
						{
							$text .= '<label>'.strip_tags(str_replace($input->parent, '', $input->parent->parent)).'</label>';
						}
					}
					
					// Get the name
					if(isset($input->name) && $input->name != '')
					{
						$text .= '<name>'.$input->name.'</name>';
					}
					
					// Get the value
					if(isset($value) && $value != '')
					{
						$text .= '<value>'.$value.'</value>';
					}
					
					// Get possibilities
					if($input->tag == 'select')
					{
						foreach($input->find('option') as $option)
						{
							$text .= '<possibility>';
							$text .= '<label>'.strip_tags($option->innertext).'</label>';
							$text .= '<value>'.$option->value.'</value>';
							$text .= '</possibility>';
						}
					}
				
					$text .= '</formItem>';
				}
				
				$text .= '</form></cell></row><wordsChunk class="'.$class.'"><quick_text>';
				
				if(isset($element))
				{
					$content = str_ireplace($element->outertext, $text, $content);
				}
			}
		} else
		{
			foreach($html->find('form') as $element)
			{
				$content = str_ireplace(trim($element->outertext()), '', $content);
			}
		}
		
		// Replace p tags with a new wordsChunk element
		foreach($html->find('p') as $element)
		{
			$content = str_ireplace(trim($element->outertext()), '</quick_text></wordsChunk><wordsChunk class="'.$class.'"><quick_text>'.$element->innertext.'</quick_text></wordsChunk><wordsChunk class="'.$class.'"><quick_text>', $content);
		}
		
		// Sort out captions first
		foreach($html->find('caption') as $element)
		{
			$text = '</quick_text></wordsChunk>';
			
			// find image in element
			foreach($element->find('img') as $img)
			{
				$transcoltext = '';
				if($transcol != '')
				{
					$transcoltext = '<transcol>'.$transcol.'</transcol>'; 
				}
				
				if(strpos($img->src, site_url()) !== 0 AND strpos($img->src, 'http://') !== 0)
				{
					$imageSrc = site_url().$img->src;
				} else
				{
					$imageSrc = $img->src;
				}
				
				$imageSrc = str_replace(array('&amp;amp;'), array('&'), $imageSrc);
				
				$imageExtension = substr($img->src,(strrpos($img->src,'.')+1));
				if($imageExtension == 'jpeg')
				{
					$imageExtension = 'jpg';
				}
				global $allowedImageExtensions;
				if(!in_array($imageExtension, $allowedImageExtensions))
				{
					$imageExtension = $this->_getImageType($imageSrc);
				}
				$text .= '<row><cell class="postCaptionImg"><externalImage filetype="'.$imageExtension.'" scale="'.$imagescale.'" quality="'.$imagequality.'"><safe_width>0</safe_width><url>'.htmlspecialchars($imageSrc).'</url>'.$transcoltext.'</externalImage></cell></row>';
			}
			
			if($element->caption && $element->caption != '')
			{
				$text .= '<wordsChunk class="'.$class.' postCaption"><quick_text>'.$element->caption.'</quick_text></wordsChunk>';
			}
			$text .= '<wordsChunk class="'.$class.'"><quick_text>';
			
			$content = str_ireplace($element->outertext, $text, $content);
		}
		
		// Replace images with WAPL versions
		foreach($html->find('img') as $element)
		{
			if(strpos($element->src, 'file://') === 0)
			{
				$content = str_ireplace(trim($element->outertext()), '', $content);
			} else
			{
				$alt = '';
				if(isset($element->alt) && $element->alt != '')
				{
					$alt = $element->alt;
				} else if(isset($element->title) && $element->title != '')
				{
					$alt = $element->title;
				}
				
				// don't scale icons or smiley images
				if(!doScaleImage($element->class, $element))
				{
					$thisimagescale = 0;
				} else
				{
					$thisimagescale = $imagescale;
				}
				
				if(!doScaleImageParent($element))
				//if((isset($element->parent->class) AND $element->parent->class == 'share') || (isset($element->parent->parent->class) AND $element->parent->parent->class == 'share') || (isset($element->parent->parent->parent->class) AND $element->parent->parent->parent->class == 'share'))
				{
					$thisimagescale = 0;
				}
				
				$transcoltext = '';
				if($transcol != '')
				{
					$transcoltext = '<transcol>'.$transcol.'</transcol>'; 
				}
				
				if((strpos($element->src, site_url()) !== 0) AND (strpos($element->src, 'http://') !== 0))
				{
					$imageSrc = site_url().$element->src;
				} else
				{
					$imageSrc = $element->src;
				}
				$imageSrc = str_replace(array('&amp;amp;'), array('&'), $imageSrc);
				
				$imageExtension = substr($element->src,(strrpos($element->src,'.')+1));
				if($imageExtension == 'jpeg')
				{
					$imageExtension = 'jpg';
				}
				
				global $allowedImageExtensions;
				if(!in_array($imageExtension, $allowedImageExtensions))
				{
					$imageExtension = $this->_getImageType($imageSrc);
				}
				
				$innerText = '<externalImage filetype="'.$imageExtension.'" scale="'.$thisimagescale.'" quality="'.$imagequality.'"><safe_width>0</safe_width><url>'.htmlspecialchars($imageSrc).'</url>'.$transcoltext.'<alt>"'.$alt.'"</alt></externalImage>';
				
				if($element->parent->tag == 'a')
				{
					if($thisimagescale == 0)
					{
						$text = '[url='.htmlspecialchars($element->parent->href).'][img=0]'.htmlspecialchars($element->src).'[/img][/url]';
						$content = str_ireplace(trim($element->parent->outertext()), $text, $content);
					} else
					{
						$innerText = '<externalLink><url>'.htmlspecialchars($element->parent->href).'</url>'.$innerText.'</externalLink>';
						$text = '</quick_text></wordsChunk><row><cell>'.$innerText.'</cell></row><wordsChunk class="'.$class.'"><quick_text>';
						$content = str_ireplace(trim($element->parent->outertext()), $text, $content);
					}
				} else
				{
					if($thisimagescale == 0)
					{
						$text = '[img=0]'.htmlspecialchars($element->src).'[/img]';
					} else
					{
						$text = '</quick_text></wordsChunk><row class="postimagerow"><cell class="postimage">'.$innerText.'</cell></row><wordsChunk class="'.$class.'"><quick_text>';
					} 

					$content = str_ireplace(trim($element->outertext()), $text, $content);
				}
			}
		}
		
		// Any other combos
		foreach($html->find('span') as $element)
		{
			if($element->style == 'font-weight: bold;')
			{
				$content = str_ireplace(trim($element->outertext()), '[b]'.$element->innertext.'[/b]', $content);
			} else if($element->style == 'font-style: italic;')
			{
				$content = str_ireplace(trim($element->outertext()), '[i]'.$element->innertext.'[/i]', $content);
			} else if($element->style == 'text-decoration: underline;')
			{
				$content = str_ireplace(trim($element->outertext()), '[u]'.$element->innertext.'[/u]', $content);
			} else if($element->style == 'font-weight: bold; font-style: italic;')
			{
				$content = str_ireplace(trim($element->outertext()), '[i][b]'.$element->innertext.'[/b][/i]', $content);
			} else if($element->style == 'text-decoration: line-through;')
			{
				$content = str_ireplace(trim($element->outertext()), '[s]'.$element->innertext.'[/s]', $content);
			}
		}
		
		// Sometimes WP puts strong/em tags in different orders...
		//$content = str_replace(array('<strong><em>', '</em></strong>'), array('[b][i]', '[/i][/b]'), $content);

		// Replace any em tags with WTF [i] tags
		foreach($html->find('em') as $element)
		{
			$content = str_ireplace(trim($element->outertext()), '[i]'.$element->innertext.'[/i]', $content);
		}
		
		// Replace any strong tags with WTF [b] tags
		foreach($html->find('strong') as $element)
		{
			$content = str_ireplace(trim($element->outertext()), '[b]'.$element->innertext.'[/b]', $content);
		}
		
		// H* tags
		foreach($html->find('h1,h2,h3,h4,h5,h6') as $element)
		{
			$content = str_ireplace(trim($element->outertext()), '</quick_text></wordsChunk><wordsChunk class="'.$class.'"><display_as>'.$element->tag.'</display_as><quick_text>'.$element->innertext.'</quick_text></wordsChunk><wordsChunk class="'.$class.'"><quick_text>', $content);
		}
		
		// Links
		foreach($html->find('a') as $element)
		{
			// handle elements that just have newlines in them
			if(trim($element->innertext) == '<br />')
			{
				continue;
			}
			$elementparent = $element->parent();
			if(isset($element->href) && $element->href != '' && $elementparent->tag != 'caption')
			{
				$content = str_ireplace(trim($element->outertext()), '[url='.htmlspecialchars($element->href).']'.$element->innertext.'[/url]', $content);
			}
		}
		
		// Lists 
		foreach($html->find('ul, ol') as $element)
		{
			$text = '</quick_text></wordsChunk><wordsChunk class="'.$class.' list"><display_as>'.$element->tag.'</display_as><quick_text>';
			foreach($element->children as $child)
			{
				if($child->tag == 'li')
				{
					$text .= $child->innertext.'
					';
				}
			}
			$text .= '</quick_text></wordsChunk><wordsChunk class="'.$class.'"><quick_text>';
			
			$content = str_ireplace(trim($element->outertext()), $text, $content);
		}
		
		// Replace any rogue wordsChunk chars
		$content = str_replace('</quick_text></wordsChunk></quick_text></wordsChunk>', '</quick_text></wordsChunk>', $content);
		$content = preg_replace('/<\/wordsChunk><quick_text>(.*?)<\/quick_text><\/wordsChunk>/i', '', $content);
		$content = preg_replace('/<\/wordsChunk><quick_text>(.*?)<\/quick_text><\/wordsChunk>/i', '', $content);
		$content = preg_replace('/<wordsChunk><quick_text>([\s\t])+<\/quick_text><\/wordsChunk>/i', '', $content);
		$content = str_replace('</wordsChunk><quick_text>', '', $content);
		$content = str_replace('</externalLink></quick_text></wordsChunk>', '', $content);
		
		// Lastly strip any other tags
		$stripTagExclude = array();
		foreach($this->schema as $key => $val)
		{
			$stripTagExclude[$key] = $key;
			if(isset($val['children']))
			{
				foreach($val['children'] as $child)
				{
					$stripTagExclude[$child] = $child;
				}
			}
		}
		$stripTagExcludeString = '';
		foreach($stripTagExclude as $tag)
		{
			$stripTagExcludeString .= '<'.$tag.'>';
		}
		$stripTagExcludeString.= '<row><cell><object><param><embed><cdata>';
		
		// Strip any remaining html (leaving CDATA intact
		$content = str_replace(array('<![CDATA[', ']]>'), array('<cdata>', '</cdata>'), $content);
		$content = strip_tags($content, $stripTagExcludeString);
		$content = str_replace(array('<cdata>', '</cdata>'), array('<![CDATA[', ']]>'), $content);

		// Convert new lines to BR
		$content = nl2br($content);
		
		// Remove all tabs and spaces to a newline
		$content = preg_replace('/\s\s+/', "\n", $content);
		
		// Fix some dodgy WP code
		$content = str_replace('<<br />', '<br />', $content);
		// Remove multiple BR and make a new wordschunk
		$content = preg_replace('/(<br \/>\s){2,}/', '[span=textSpacer] [/span]', $content);
		
		// Clean up any empty wordsChunk elements
		$empty = architect_str_get_html($content);
		foreach($empty->find('wordsChunk') as $quick)
		{
			if($quick->innertext == '<quick_text></quick_text>')
			{
				$content = str_ireplace($quick->outertext, '', $content);
			}
		}
		
		// Replace all BR with newline (all done to make it nice and tidy)
		$content = preg_replace('/(<br\s*\/?>\s*){1,}/', "\n", $content);
		
		// Clean up "&nbsp;"
		$content = str_replace('&nbsp;', '', $content);
		$content = str_replace('<</quick_text>', '</quick_text>', $content);

		// Clean up a weird error with a lowercase wordschunk
		$content = str_replace('<wordschunk', '<wordsChunk', $content);
		
		if($length)
		{
			// Reset pages array
			$this->pages = array();
			
			$this->getPages($content, $length);
			
			$tidyContent = $this->pages[($this->currentPage - 1)];
			
			if((strpos($tidyContent, '<row') === 0) OR (strpos($tidyContent, '<wordsChunk') === 0))
			{
				$tidyContent = '</quick_text></wordsChunk>'.$tidyContent;
			}
			
			if(strrpos($tidyContent, '</quick_text></wordsChunk>') === (strlen($tidyContent) - strlen('</quick_text></wordsChunk>')))
			{
				$tidyContent = substr($tidyContent, 0, strrpos($tidyContent, '</quick_text></wordsChunk'));
			}
			
			// Tidy up any BB code undone by splitting
			$bbhtml = architect_str_get_html($tidyContent);
			$bbcode = array('i', 'b', 'u', 's');
			
			foreach($bbhtml->find('quick_text ') as $element)
			{
				foreach($bbcode as $code)
				{
					$bbreplacements = array();
					
					if(((strpos($element->innertext, '['.$code.']') !== false) && (strpos($element->innertext, '[/'.$code.']') === false)))
					{
						$bbreplacements[trim($element->innertext)] = $element->innertext.'[/'.$code.']';
					} else if(((strpos($element->innertext, '['.$code.']') === false) && (strpos($element->innertext, '[/'.$code.']') !== false)))
					{
						$bbreplacements[trim($element->innertext)] = '['.$code.']'.$element->innertext;
					}
					
					foreach($bbreplacements as $key => $val)
					{
						$tidyContent = str_ireplace(trim($key), $val, $tidyContent);
					}
			
				}
			}
			
			// Fix if page fold ends with a </quick_text></wordsChunk>
			if(substr($tidyContent,-26) == '</quick_text></wordsChunk>')
			{
				$tidyContent = substr($tidyContent,0,(strlen($tidyContent)-26));
			}
			
			return $tidyContent;
		} else
		{
			$this->pages = array('page');
			$this->currentPage = 1;
			
			return $content;
		}
	}
	
	/**
	 * Get the number of pages
	 * @param string $content
	 * @access public
	 * @return unknown_type
	 */
	function getPages($content, $length)
	{
		$chunks = preg_split('/<\/quick_text><\/wordsChunk>/', $content, -1);

		$r = 0;
		$tmpPages = array();
		for($i = 0; $i < count($chunks); $i++)
		{
			if(!isset($tmpPages[$r])){ $tmpPages[$r] = '';}
			
			if (strlen($tmpPages[$r] . $chunks[$i].' ') < $length)
			{
				$tmpPages[$r] .= $chunks[$i] . '</quick_text></wordsChunk>';
			} else
			{
				$r++;
				if(!isset($tmpPages[$r])){ $tmpPages[$r] = '';}
				$tmpPages[$r] .= $chunks[$i] . '</quick_text></wordsChunk>';
			}
		}
		
		// Order pages correctly
		foreach($tmpPages as $val)
		{
			if(!empty($val) && $val != '' && $val != '</quick_text></wordsChunk>')
			{
				if(strpos(trim($val), '<rule') === 0)
				{
					$val = '</quick_text></wordsChunk>'.$val;
				}
				$this->pages[] = $val;
			}
		}

		// which page are we on?
		if(isset($_GET['page']))
		{
			$this->currentPage = $_GET['page'];
		} else
		{
			$this->currentPage = 1;
		}
	}
	
	/**
	 * Get image extension
	 * @param string $src
	 * @access public
	 * @return string
	 */
	function _getImageType($src)
	{
		$imageExtension = 'png';
		if(function_exists('getimagesize'))
		{
			$imageData = getimagesize($src);
			switch($imageData['mime'])
			{
				case 'image/png' : $imageExtension = 'png';break;
				case 'image/jpeg' :
				case 'image/jpg' : 
					$imageExtension = 'jpg';break;
				case 'image/gif' :
					$imageExtension = 'gif';break;
				case 'image/bmp' :
					$imageExtension = 'bmp';break;
			}
		}
		return $imageExtension;
	}
	
	/**
	 * Main function to build a tag
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function __do_tag($options)
	{
		if(in_array($this->__getTag(), $this->noRowTags))
		{
			$options['row'] = false;
			$options['cell'] = false;
		}
		
		$string = '';
		$string .= $this->__do_tag_start($options);
		$string .= $this->__do_tag_contents($options);
		$string .= $this->__do_tag_end($options);
		return $string;
	}
	
	/**
	 * Start an element off by building a row and cell if needed and setting up a tag prefix
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function __do_tag_start($options)
	{
		if(isset($options['start']) AND $options['start'] == false) 
		{
			return;
		}
		
		$string = null;
		
		if(!isset($options['row']) OR $options['row'] !== false)
		{
			$string .= $this->__do_tag_row_start($options);
		}
		if(!isset($options['cell']) OR $options['cell'] !== false)
		{
			$string .= $this->__do_tag_cell_start($options);
		}
		
		$string .= '<'.$this->tagPrefix;
		
		if($this->tagPrefix)
		{
			$tag = $this->tagPrefix.ucwords($this->tag);
			$string .= ucwords($this->tag);
		} else
		{
			$tag = $this->tag;
			$string .= $this->tag;
		}
		foreach($this->universalAttributes as $val)
		{
			if(isset($options[$val]))
			{
				$string .= ' '.$val.'="'.$options[$val].'"';
			}
		}
		
		if(isset($this->schema[$tag]['attributes']))
		{
			foreach($this->schema[$tag]['attributes'] as $val)
			{
				if(isset($options[trim($val)]))
				{
					$string .= ' '.trim($val).'="'.$options[trim($val)].'"';
				}
			}
		}
		
		if(!isset($this->schema[$tag]['selfClosing']) OR $this->schema[$tag]['selfClosing'] == false)
		{ 
			$string .= '>';
		}
		
		return $string;
	}
	
	/**
	 * Build the internal contents of an element
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function __do_tag_contents($options)
	{
		if(isset($options['contents']) AND $options['contents'] == false) 
		{
			return;
		}
		
		$string = null;
	
		$tag = $this->__getTag();
		
		if(isset($this->schema[$tag]['children']) AND !empty($this->schema[$tag]['children']))
		{
			foreach($this->schema[$tag]['children'] as $val)
			{
				if((isset($this->schema[$val]['parent']) AND ($this->schema[$val]['parent'] == $this->__getTag())) OR !isset($this->schema[$val]['parent']))
				{
					if(isset($options[$val]))
					{
						$string .= '<'.$val.'>'.$options[$val].'</'.$val.'>';
					}
				}
			}
		}
		if(isset($options['children']) AND !empty($options['children']) AND is_array($options['children']))
		{
			$childString = null;
			$this->parentTag = $this->tag;
			$tmpTagPrefix = $this->tagPrefix;
			
			foreach($options['children'] as $child)
			{
				if(isset($child['tag']))
				{
					$this->tag = $child['tag'];
					
					$options = array();
					
					// Build up any attributes
					if(isset($this->schema[$this->tag]['attributes']))
					{
						foreach($this->schema[$this->tag]['attributes'] as $attVal)
						{
							if(isset($child[$attVal]))
							{
								$options[$attVal] = $child[$attVal];
							}
						}
					}
					
					if(isset($child['options']))
					{
						$options = array_merge($options, $child['options']);
					}
					
					if(method_exists($this, $this->tag))
					{
						$childString .= $this->{$this->tag}($options);
					} else
					{
						$childString .= $this->__do_tag($options);
					}
				}
			}
			
			$this->tagPrefix = $tmpTagPrefix;
			$this->tag = $this->parentTag;
			$string .= $childString;
		}

		// Set a direct value into a tag
		if(isset($this->schema[$tag]['direct']) AND $this->schema[$tag]['direct'] == true)
		{
			$string .= $options['value'];
		}
		return $string;
	}
	
	/**
	 * Close elements properly
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function __do_tag_end($options)
	{
		if(isset($options['end']) AND $options['end'] == false) 
		{
			return;
		}
		
		$string = '';
		
		if(isset($this->schema[$this->tag]['selfClosing']) AND $this->schema[$this->tag]['selfClosing'] == true)
		{ 
			$string .= ' />';
		} else
		{
			$string .= '</'.$this->tagPrefix;
			if($this->tagPrefix)
			{
				$string .= ucwords($this->tag);
			} else
			{
				$string .= $this->tag;
			}
			$string .= '>';
	
			if(!isset($options['cell']) OR $options['cell'] !== false)
			{
				$string .= $this->__do_tag_cell_end($options);
			}
			if(!isset($options['row']) OR $options['row'] !== false)
			{
				$string .= $this->__do_tag_row_end($options);
			}
		}
		
		return $string;
	}
	
	/**
	 * Open an elements row
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function __do_tag_row_start($options)
	{
		$string = '<row';
		
		if(isset($options['rowClass']))
		{
			$string .= ' class="'.$options['rowClass'].'"';
		}
		if(isset($options['rowId']))
		{
			$string .= ' id="'.$options['rowId'].'"';
		}
		$string .= '>';
		return $string;
	}
	
	/**
	 * Close a row
	 * @access public
	 * @return string
	 */
	function __do_tag_row_end()
	{
		return '</row>';
	}
	
	/**
	 * Open an elements cell
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function __do_tag_cell_start($options)
	{
		$string = '<cell';
		
		if(isset($options['cellClass']))
		{
			$string .= ' class="'.$options['cellClass'].'"';
		}
		if(isset($options['cellId']))
		{
			$string .= ' id="'.$options['cellId'].'"';
		}
		$string .= '>';
		return $string;
	}
	
	/**
	 * Close a cell
	 * @param array $options
	 * @access public
	 * @return string
	 */
	function __do_tag_cell_end($options)
	{
		return '</cell>';
	}
	
	/**
	 * Get proper tag
	 * @access public
	 * @return string
	 */
	function __getTag()
	{
		if($this->tagPrefix)
		{
			return $this->tagPrefix.ucwords($this->tag);
		} else
		{
			return $this->tag;
		}
	}
	
	/**
	 * Work out external link
	 * @param array $options
	 * @access public
	 * @return void
	 */
	function __doExternal($options)
	{
		$this->tagPrefix = null;
		
		if(!isset($options['external']) || $options['external'] == true)
		{
			$this->tagPrefix = 'external';
		}
	}
}
?>