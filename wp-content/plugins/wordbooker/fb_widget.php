<?php

/*
Description: Facebook Fan Box Widget. Needs Wordbook installing to work.
Author: Stephen Atty
Author URI: http://canalplan.blogdns.com/steve
Version: 1.9.4
*/

/*
 * Copyright 2009 Steve Atty (email : posty@tty.org.uk)
 *
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 51
 * Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

global $wp_version;
if((float)$wp_version >= 2.8){

class FacebookWidget extends WP_Widget {
	
	/**
	 * constructor
	 */	 
	function FacebookWidget() {
		parent::WP_Widget('wordbookfb_widget', 'Wordbooker FB Like', array('description' => __('Allows you to have multiple Like/Fan boxes. Fan pages cane be picked from a dropdown list in the options. Each user gets the choice of all the FB Fan pages they administer','wordbooker') , 'class' => 'FacebookWidget'));	
	}
	
	/**
	 * display widget
	 */	 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		global  $wpdb, $user_ID,$table_prefix,$blog_id;
		$userid=$instance['snorl'];
		$wordbooker_settings = wordbooker_options(); 
		echo $before_widget;
         	if (strlen($instance['dname']) >0 ) $name=$instance['dname'];
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		$wplang="en_US";
		if (strlen(WPLANG) > 2) {$wplang=WPLANG;}
		echo "<p>";
		$height = $instance['height'];
		$width = $instance['width'];
		$connections=$instance['connections'];
		$stream="false";
		$header="false";
		if ($instance['stream']=='on') {
			$height = $height+300;
			$stream="true";
		} 
		if ($instance['header']=='on') {
			$height = $height + 35;
			$header="true";
		} else 

;
		if ( (!isset($wordbooker_settings['wordbooker_like_button_show']) && !isset($wordbooker_settings['wordbooker_like_share_too'])) || isset($wordbooker_settings['wordbooker_iframe'])) {
			echo'<iframe style="border: medium none; overflow: hidden; height: '.$height.'px; width: '.$width.'px;" src="http://www.facebook.com/plugins/fan.php?api_key=254577506873&amp;connections='.$connections.'&amp;height='.$height.'&amp;id='.$instance['pid'].'&amp;locale='.$wplang.'&amp;logobar='.$header.'&amp;header='.$header.'&amp;stream='.$stream.'&amp;width='.$width.'"></iframe>';
		}
		else {
			echo '<div id="fb-root"> <fb:fan profile_id="'.$instance['pid'].'" width="'.$width.'" height="'.$height.'" connections="'.$instance['connections'].'" stream="'.$stream.'" logobar="'.$header.'" header="'.$header.'" locale="'.$wplang.'" ></fb:fan> </div >';
		}	
		
	
		echo "</p>".$after_widget;
	}
	
	/**
	 *	update/save function
	 */	 	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['snorl'] = $new_instance['snorl'];
		$instance['dname'] = strip_tags($new_instance['dname']);
		$instance['pid'] = strip_tags($new_instance['pid']);
		$instance['stream'] = strip_tags($new_instance['stream']);
		$instance['connections'] = strip_tags($new_instance['connections']);
		$instance['header'] = strip_tags($new_instance['header']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['width'] = strip_tags($new_instance['width']);
		return $instance;
	}
	
	/**
	 *	admin control form
	 */	 	
	function form($instance) {
		global $user_ID,$wpdb,$table_prefix,$blog_id;
		$result = wordbooker_get_cache($user_ID,'pages');
		$fanpages=unserialize($result->pages);
		$xx=array('page_id'=>'254577506873','name'=>'Wordbooker');
		$fanpages[]=$xx;
		$default = array( 'title' => __('Fan Page','wordbooker'), 'snorl'=>$user_ID, 'dname'=>'', 'pid'=>'254577506873', 'stream'=>'false', 'connections'=>6, 'width'=>188, 'height'=>260, 'header'=>'false' );
		$instance = wp_parse_args( (array) $instance, $default );
		$title_id = $this->get_field_id('title');
		$title_name = $this->get_field_name('title');

		$snorl_id = $this->get_field_id('snorl');
		$snorl_name = $this->get_field_name('snorl');

		$dname_id = $this->get_field_id('dname');
		$dname_name = $this->get_field_name('dname');

		$df_id = $this->get_field_id('pid');
		$df_name = $this->get_field_name('pid');

		$stream_id = $this->get_field_id('stream');
		$stream_name = $this->get_field_name('stream');

		$connections_id = $this->get_field_id('connections');
		$connections_name = $this->get_field_name('connections');

		$header_id = $this->get_field_id('header');
		$header_name = $this->get_field_name('header');

		$width_id = $this->get_field_id('width');
		$width_name = $this->get_field_name('width');

		$height_id = $this->get_field_id('height');
		$height_name = $this->get_field_name('height');


		$checked_flag=array('on'=>'checked','off'=>'', 'true'=>'checked', 'false'=>'');
		if (!is_numeric($instance['width']) || $instance['width'] <0) {$instance['width']=188;}
		if (!is_numeric($instance['height']) || $instance['height'] <0) {$instance['height']=260;}
		if (!is_numeric($instance['connections']) || $instance['connections'] <0) {$instance['connections']=6;}

		echo '<input type="hidden" class="widefat" id="'.$snorl_id.'" name="'.$snorl_name.'" value="'.attribute_escape( $instance['snorl'] ).'" /></p>';

		echo '<p><label for="'.$title_id.'">'.__('Title of Widget','wordbooker').': </label> <input type="text" class="widefat" id="'.$title_id.'" name="'.$title_name.'" value="'.attribute_escape( $instance['title'] ).'" /></p>';
		


		echo "\r\n".'<p><label for="'.$df_id.'">'.__('Fan Page','wordbooker').':  </label>'; 
		echo '<select id=id="'.$df_id.'"  name="'.$df_name.'" >';
		foreach ($fanpages as $fan_page) {
			if ($fan_page[page_id]==attribute_escape( $instance['pid'])){ 
				print '<option selected="yes" value="'.$fan_page[page_id].'" >'.$fan_page[name].'</option>';}
			else {
				print '<option value="'.$fan_page[page_id].'" >'.$fan_page[name].'</option>';
			}
		}
		echo '</select></p>';

		echo '<p><label for="'.$stream_id.'">'.__("Include Stream ", 'wordbooker'). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX class="widefat"id="'.$stream_id.'" name="'.$stream_name.'" '.$checked_flag[attribute_escape( $instance['stream'])].' /></p>';

		echo '<p><label for="'.$stream_id.'">'.__("Include Header ", 'wordbooker'). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX class="widefat"id="'.$header_id.'" name="'.$header_name.'" '.$checked_flag[attribute_escape( $instance['header'])].' /></p>';
		
		echo '<p><label for="'.$connections_id.'">'.__('Number of Connections','wordbooker').': </label> <input type="text" size="4" id="'.$connections_id.'" name="'.$connections_name.'" value="'.attribute_escape( $instance['connections'] ).'" /></p>';

		echo '<p><label for="'.$width_id.'">'.__('Widget Width','wordbooker').': </label> <input type="text" size="7" id="'.$width_id.'" name="'.$width_name.'" value="'.attribute_escape( $instance['width'] ).'" /></p>';

		echo '<p><label for="'.$height_id.'">'.__('Widget Height','wordbooker').': </label> <input type="text" size="7" id="'.$height_id.'" name="'.$height_name.'" value="'.attribute_escape( $instance['height'] ).'" /></p>';

	}
}



/* register widget when loading the WP core */
add_action('widgets_init', fbwordbooker_widgets);
$plugin_dir = basename(dirname(__FILE__));
#load_plugin_textdomain( 'wordbook', 'wp-content/plugins/' . $plugin_dir, $plugin_dir );

function fbwordbooker_widgets(){
	register_widget('FacebookWidget');
}

}

?>
