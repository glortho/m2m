<?php 
class architect_youtube
{
	function format($content, $class)
	{
		preg_match_all('/\[youtube=(.*?)\]/', $content, $urls);
		
		if(isset($url[1]))
		{
			if ( preg_match("/youtube\.com\/watch/i", $url[1]) ) {
				list($domain, $video_id) = split("v=", $url[1]);
				$video_id = esc_attr($video_id);
				$src = htmlspecialchars('http://www.youtube.com/v/' . $video_id);
	
			} elseif ( preg_match("/vimeo\.com\/[0-9]+/i", $url[1]) ) {
				list($domain, $video_id) = split(".com/", $url[1]);
				$video_id = esc_attr($video_id);
				$src = 'http://www.vimeo.com/moogaloop.swf?clip_id=' . $video_id . '&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1';
			}
			
			$imageThumbnail = 'http://i.ytimg.com/vi/'.$url[1].'/1.jpg';
			
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
	
			$content = preg_replace('/\[youtube=(.*?)\]/', $this->start($class).$iphonevid.$this->end($class), $content);
			return $content;
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