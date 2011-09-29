<?php 
class architect_smart_youtube
{
	function format($content, $class)
	{
		preg_match_all("/http(v|vh|vhd):\/\/([a-zA-Z0-9\-\_]+\.|)youtube\.com\/watch(\?v\=|\/v\/)([a-zA-Z0-9\-\_]{11})([^<\s]*)/", $content, $url, PREG_SET_ORDER);
		
		foreach($url as $match)
		{
			list($url1, $url2) = explode('/watch?v=', $match[0]);
			if(strpos($url1, 'youtube') !== false)
			{
				$src = htmlentities(str_replace(array('httpv', 'httpvh', 'httpvhd'), 'http', $url1.'/v/'.$url2));
			}
			$imageThumbnail = 'http://i.ytimg.com/vi/'.$url2.'/1.jpg';
			
			$iphonevid = '
			<rule type="activation" criteria="iphone" condition="1">
				<row><cell>
				<chars make_safe="0"><value><![CDATA[<object width="310">
					<param name="movie" value="'.$src.'"></param>
					<param name="wmode" value="transparent"></param>
					<embed src="'.$src.'" type="application/x-shockwave-flash" wmode="transparent" width="310"></embed></object>]]>
				</value></chars></cell></row>
			</rule>
			<rule type="activation" criteria="iphone" condition="0">
				<row><cell><externalLink><url>'.$src.'</url><label>'.$src.'</label>
				<externalImage filetype="jpg" scale="90">
					<url>'.$imageThumbnail.'</url>
				</externalImage>
				</externalLink></cell></row>
			</rule>
			';
	
			$content = str_replace($match[0], $this->start($class).$iphonevid.$this->end($class), $content);
		}

		return $content;
	}
	
	// *******************************************************************************
	// ** You shouldn't need to amend any of these functions - but they are required! **
	// *******************************************************************************
	
	function start($class)
	{
		return '</quick_text></wordsChunk>';
	}
	function end($class)
	{
		return '<wordsChunk class="'.$class.'"><quick_text>';
	}
}
?>