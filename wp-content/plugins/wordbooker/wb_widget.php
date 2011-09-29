<?php

/*
Description: Facebook Status Widget. Needs Wordbook installing to work.
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

class WordbookWidget extends WP_Widget {
	
	/**
	 * constructor
	 */	 
	function WordbookWidget() {
		parent::WP_Widget('wordbook_widget', 'Wordbooker FB Status ', array('description' => __('Allows you to have one or more Facebook Status widgets in your sidebar. The widget picks up the user id of the person who drags it onto the side bar','wordbooker') , 'class' => 'WordbookWidget'));	
	}
	
	/**
	 * display widget
	 */	 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		global  $wpdb, $user_ID,$table_prefix,$blog_id;
		$userid=$instance['snorl'];
		$result = wordbooker_get_cache($userid);
		echo $before_widget;
		$name=$result->name;
         	if (strlen($instance['dname']) >0 ) $name=$instance['dname'];
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
                echo '<br /><div class="facebook_picture" align="center">';
                echo '<a href="'.$result->url.'" target="facebook">';
                echo '<img src="'. $result->pic.'" alt=" FB photo for '.$name.'" /></a>';
                echo '</div>';
	
                if ($result->status) {			
			$current_offset=0;
			$current_offset = get_option('gmt_offset');
                	echo '<p><br /><a href="'.$result->url.'">'.$name.'</a> : ';
			echo '<i>'.$result->status.'</i><br />';
       			if ($instance['df']=='fbt') { 
         			echo '('.nicetime($result->updated).').'; 
			}
         		else {
				echo '('.date($instance['df'], $result->updated+(3600*$current_offset)).').';
			}
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
		$instance['df'] = strip_tags($new_instance['df']);
		return $instance;
	}
	
	/**
	 *	admin control form
	 */	 	
	function form($instance) {
		global $user_ID;
		$default = array( 'title' => __('Facebook Status','wordbooker'), 'snorl'=>$user_ID, 'dname'=>'', 'df'=>'D M j, g:i a' );
		$instance = wp_parse_args( (array) $instance, $default );
		$title_id = $this->get_field_id('title');
		$title_name = $this->get_field_name('title');
		$snorl_id = $this->get_field_id('snorl');
		$snorl_name = $this->get_field_name('snorl');
		$dname_id = $this->get_field_id('dname');
		$dname_name = $this->get_field_name('dname');
		$df_id = $this->get_field_id('df');
		$df_name = $this->get_field_name('df');
		echo '<p><label for="'.$title_id.'">'.__('Title of Widget','wordbooker').': </label> <input type="text" class="widefat" id="'.$title_id.'" name="'.$title_name.'" value="'.attribute_escape( $instance['title'] ).'" /></p>';
		echo '<p><label for="'.$dname_id.'">'.__('Display this name','wordbooker').': <input type="text" class="widefat" id="'.$dname_id.'" name="'.$dname_name.'" value="'.attribute_escape( $instance['dname'] ).'" /></label></p>';
		echo '<input type="hidden" class="widefat" id="'.$snorl_id.'" name="'.$snorl_name.'" value="'.attribute_escape( $instance['snorl'] ).'" /></p>';
		echo '<p><label for="'.$df_id.'">'.__('Date Format','wordbooker').':  </label>'; 
		echo '<select id=id="'.$df_id.'"  name="'.$df_name.'" >';
		$ds12=date('D M j, g:i a');
		$dl12=date('l F j, g:i a');
		$dl24=date('l F j, h:i');
		$ds24=date('D M j, h:i');
		$drfc=date('r');
		$arr = array('D M j, g:i a'=> $ds12,  'l F j, g:i a'=> $dl12, 'D M j, h:i'=>$ds24, 'l F j, h:i'=>$dl24,fbt=>__("Facebook Text style",'wordbooker'), r =>$drfc);
		foreach ($arr as $i => $value) {
		if ($i==attribute_escape( $instance['df'])){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
		else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}
		}
		echo '</select></p>';
	}
}



/* register widget when loading the WP core */
add_action('widgets_init', 'wordbooker_widgets');
$plugin_dir = basename(dirname(__FILE__));
#load_plugin_textdomain( 'wordbook', 'wp-content/plugins/' . $plugin_dir, $plugin_dir );

function wordbooker_widgets(){
	register_widget('WordbookWidget');
}

}

wp_register_sidebar_widget('WP_SW1','FaceBook Status', 'widget_facebook');
wp_register_widget_control('WP_SWC1','FaceBook Status', 'fb_widget_control', '500', '500');

function nicetime($date)
{
   
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
   
    $now             = time();
    $unix_date         = $date;
   
       // check validity of date
    if(empty($unix_date)) {   
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {   
        $difference     = $now - $unix_date;
        $tense         = "ago";
       
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
   
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
   
    $difference = round($difference);
   
    if($difference != 1) {
        $periods[$j].= "s";
    }
   
    return "$difference $periods[$j] {$tense}";
}

function widget_facebook($args) {
	extract($args);
	global  $wpdb, $user_ID,$table_prefix,$blog_id;
        $fb_widget_options = unserialize(get_option('fb_widget_options'));
	$title = stripslashes($fb_widget_options['title']);
        $dispname = stripslashes($fb_widget_options['dispname']);
        $dformat=$fb_widget_options['df'];
	echo $before_widget . $before_title . $title . $after_title;
        global $wpdb;
        // We need to get the user_id from the userdata table for this blog.
        $sql="Select user_id from ".WORDBOOKER_USERDATA." limit 1";
        $result = $wpdb->get_results($sql);
	$result = wordbooker_get_cache($result[0]->user_id);
	$pfields=array('is_app_user','first_name','name','status','pic',);
	if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
        echo '<br /><div class="facebook_picture" align="center">';
        echo '<a href="'.$result->url.'" target="facebook">';
        echo '<img src="'. $result->pic.'" /></a>';
        echo '</div>';
	$name=$result->name;
 	if (strlen($dispname)>0) $name=$dispname; 
        if ($result->status) {
		$current_offset=0;
		$current_offset = get_option('gmt_offset');
        	echo '<br /><a href="'.$result->url.'">'.$name.'</a> : ';
		echo '<i>'.$result->status.'</i><br />';
		if ($dformat=='fbt') { 
 			echo '('.nicetime($result->updated).').'; 
		}
 		else {
			echo '('.date($dformat, $result->updated+(3600*$current_offset)).').';

	
		}
	}
	echo $after_widget;

}

function fb_widget_control() {
  // Check if the option for this widget exists - if it doesnt, set some default values
  // and create the option.
  if(!get_option('fb_widget_options'))
  {
    add_option('fb_widget_options', serialize(array('title'=>'Facebook Status', 'dispname'=>'', 'df'=>'D M j, g:i a')));
  }
  $fb_widget_options = $fb_widget_newoptions = unserialize(get_option('fb_widget_options'));
  
  // Check if new widget options have been posted from the form below - 
  // if they have, we'll update the option values.
  if ($_POST['fb_widget_title']){
    $fb_widget_newoptions['title'] = $_POST['fb_widget_title'];
  }
  if ($_POST['fb_widget_dispname']){
    $fb_widget_newoptions['dispname'] = $_POST['fb_widget_dispname'];
  }
  if ($_POST['fb_widget_dformat']){
    $fb_widget_newoptions['df'] = $_POST['fb_widget_dformat'];
  }
  if($fb_widget_options != $fb_widget_newoptions){
    $fb_widget_options = $fb_widget_newoptions;
    update_option('fb_widget_options', serialize($fb_widget_options));
  }
  // Display html for widget form
  ?>
  <p>
    <label for="fb_widget_title">Widget Title:<br />
      <input
      id="fb_widget_title" 
      name="fb_widget_title" 
      type="text" 
      value="<?php echo stripslashes($fb_widget_options['title']); ?>"/>
    </label>
  </p>
  <p>
    <label for="fb_widget_dispname">Display this name instead of your Facebook name :<br />
      <input
      id="fb_widget_dispname" 
      name="fb_widget_dispname"
      type="text" 
      value="<?php echo stripslashes($fb_widget_options['dispname']); ?>"/>
    </label>
  </p>
  <p>
    <label for="fb_widget_dformat">Date Format :<br />
<select id="fb_widget_dformat" name="fb_widget_dformat"  >
<?php
$ds12=date('D M j, g:i a');
$dl12=date('l F j, g:i a');
$dl24=date('l F j, h:i');
$ds24=date('D M j, h:i');
$drfc=date('r');
$arr = array('D M j, g:i a'=> "Short 12 (".$ds12.") - Default",  'l F j, g:i a'=> "Long 12 (".$dl12.") ", 'D M j, h:i'=>"Short 24 (".$ds24.") ", 'l F j, h:i'=>"Long 24 (".$dl24.")",fbt=>"Facebook Text style", r => "RFC 822 (".$drfc." ) ");
foreach ($arr as $i => $value) {
if ($i==$fb_widget_options['df']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}

}
?>
</select>
    </label>
  </p>
  <?php
}  
?>
