<?php

/**
Extension Name: Wordbooker Options 
Extension URI: http://wordbooker.tty.org.uk
Version: 1.9.5
Description: Advanced Options for the WordBooker Plugin
Author: Steve Atty
*/

// This is WP 2.8 specific
function wordbooker_option_init(){
	register_setting( 'wordbooker_options', 'wordbooker_settings','worbooker_validate_options');
}

function worbooker_validate_options($options) {
	# Do they want to reset? If so we reset the options and let WordPress do the business for us!
	if (isset( $_POST["RSD"] ))  {
		$options["wordbook_default_author"]=0;
		$options["wordbook_republish_time_frame"]=10;
		$options["wordbook_attribute"]= __("Posted a new post on their blog");
		$options["wordbooker_status_update_text"]= __(": New blog post :  %title% - %link%");
		$options["wordbook_actionlink"]=300;
		$options['wordbook_orandpage']=2;
		$options['wordbook_extract_length']=256;
		$options['wordbook_page_post']=-100;
		$options['wordbook_page_post']=-100;
		$options["wordbooker_publish_default"]=null;
		$options["wordbook_republish_time_obey"]=null;
		$options["wordbooker_publish_override"]=null;
		$options["wordbooker_status_update"]=null;
		$options["wordbook_search_this_header"]=null;
		$options["wordbook_comment_approve"]=null;
		$options["wordbook_comment_push"]=null;
		$options["wordbook_comment_poll"]=null;
		$options["wordbook_publish_no_user"]=null;
		$options["wordbook_advanced_diagnostics"]=null;
		$options["wordbooker_like_button"]=null;
		$options['wordbook_description_meta_length']=350;
		$options['wordbooker_like_width']=250;
		$options['wordbooker_comment_email']=get_bloginfo( 'admin_email' );
	}
	return $options;
}

function wbs_is_hash_valid($form_hash) {
	$ret = false;
	$saved_hash = wbs_retrieve_hash();
	if ($form_hash === $saved_hash) {
		$ret = true;
	}
	return $ret;
}

function wbs_generate_hash() {
	return md5(uniqid(rand(), TRUE));
}

function wbs_store_hash($generated_hash) {
	return update_option('wordbooker_token',$generated_hash,'WordBooker Security Hash');
}

function wbs_retrieve_hash() {
	$ret = get_option('wordbooker_token');
	return $ret;
}

function wordbooker_microtime_float()
{
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}


function wordbooker_option_manager() {
	global $ol_flash, $wordbooker_settings, $_POST, $wp_rewrite,$user_ID,$wpdb, $table_prefix,$current_blog,$blog_id,$db_prefix,$wordbooker_script_start;

	$wordbooker_script_start = wordbooker_microtime_float();
	echo '<div class="wrap">';
	echo '<h2>WordBooker Plugin</h2>';
	if ( isset ($_POST["reset_user_config"])) {wordbooker_delete_userdata(); }
	//Set some defaults:
	$wordbooker_settings=wordbooker_options();
	$smoot_settings =get_option('wordbook_settings');
	# If we dont have any settings then try to recover them from old settings.
	if (! isset($wordbooker_settings["wordbook_default_author"])) {
		$wordbooker_settings =get_option('wordbook_settings');
		$wordbooker_settings['schemavers']=WORDBOOKER_SCHEMA_VERSION;
		wordbooker_set_options($wordbooker_settings);
		$wordbooker_settings =wordbooker_options();
	}

	$oldv=0;
	// Version check here
	if (WORDBOOKER_WP_VERSION <28) {
	$oldv=1;
	}

	if (! wbs_retrieve_hash()) {
		$temp_hash = wbs_generate_hash();
		wbs_store_hash($temp_hash);
	}

	#var_dump($wordbooker_settings);
	// If no default author set, lets set it
	if (! isset($wordbooker_settings["wordbook_default_author"])){ $wordbooker_settings["wordbook_default_author"]=0;}
	// If no default republish time frame set, then set it.
	if (! isset($wordbooker_settings["wordbook_republish_time_frame"])){ $wordbooker_settings["wordbook_republish_time_frame"]=10;}
	// If no attribute set, then set it.
	if (! isset($wordbooker_settings["wordbook_attribute"])){ $wordbooker_settings["wordbook_attribute"]= __("Posted a new post on their blog");}
	// If no Status line text, then set it 
	if (! isset($wordbooker_settings["wordbooker_status_update_text"])){ $wordbooker_settings["wordbooker_status_update_text"]= __(": New blog post :  %title% - %link%");}
	// No Share link set, then set it
	if (! isset($wordbooker_settings["wordbook_actionlink"])){ $wordbooker_settings["wordbook_actionlink"]=300;}
	// No andor set, then set it
	if (! isset($wordbooker_settings['wordbook_orandpage'])){ $wordbooker_settings['wordbook_orandpage']=2;}
	// No extract length
 	if (! isset($wordbooker_settings['wordbook_extract_length'])) {$wordbooker_settings['wordbook_extract_length']=256;}
 	if (! isset($wordbooker_settings['wordbook_page_post'])) {$wordbooker_settings['wordbook_page_post']=-100;}
	 // Generate meta Description
	if (! isset($wordbooker_settings['wordbook_description_meta_length'])) {$wordbooker_settings['wordbook_description_meta_length']='350';}

	// Now lets write those setting back.;
	wordbooker_set_options($wordbooker_settings);
	$wordbook_user_settings_id="wordbookuser".$blog_id;
	global $table_prefix,$db_prefix;
	echo '<div class="wrap">';
	if(isset($_POST['user_meta'])) {
		// Now we check the hash, to make sure we are not getting CSRF
		if(wbs_is_hash_valid($_POST['token'])) {
			$wordbookuser_settings['wordbook_extract_length'] = $_POST['wordbook_extract_length'];
		        $wordbookuser_settings['wordbooker_publish_default'] = $_POST['wordbooker_publish_default'];
			$wordbookuser_settings['wordbook_attribute'] = $_POST['wordbook_attribute'];
			$wordbookuser_settings["wordbooker_status_update_text"]=$_POST['wordbooker_status_update_text'];
			$wordbookuser_settings["wordbooker_status_update"]=$_POST['wordbooker_status_update'];
			$wordbookuser_settings["wordbook_actionlink"]=$_POST['wordbook_actionlink'];
			$wordbookuser_settings["wordbook_search_this_header"]=$_POST['wordbook_search_this_header'];
			$wordbookuser_settings["wordbook_page_post"]=$_POST['wordbook_page_post'];
			$wordbookuser_settings['wordbook_orandpage']=$_POST['wordbook_orandpage'];
			$wordbookuser_settings['wordbook_disable_status']=$_POST['wordbook_disable_status'];
			$wordbookuser_settings['wordbook_status_id']=$_POST['wordbook_status_id'];
			$wordbookuser_settings['wordbook_thumb_only']=$_POST['wordbook_thumb_only'];
			$wordbookuser_settings['wordbook_use_excerpt']=$_POST['wordbook_use_excerpt'];
			$encoded_setings=$wordbookuser_settings;
			$wordbook_user_settings_id="wordbookuser".$blog_id;
			update_usermeta( $user_ID, $wordbook_user_settings_id, $encoded_setings );
			if (isset($_POST['rwbus'])) {delete_usermeta( $user_ID, $wordbook_user_settings_id );$ol_flash =  __("Your user level settings have been reset.");} else {
	       		$ol_flash =  __("Your user level settings have been saved."); }
		} else {
			// Invalid form hash, possible CSRF attempt
			$ol_flash =  __("Security hash missing.");
		} // endif wbs_is_hash_valid
	}  // end if user_meta check.

	if ($oldv==1) {
	// Easiest test to see if we have been submitted to
		if(isset($_POST['token'])) {
			// Now we check the hash, to make sure we are not getting CSRF
			if(wbs_is_hash_valid($_POST['token'])) {
				$x=$_POST['wordbooker_settings']['wordbook_default_author'];
				if (isset($x)) { 
					delete_option('wordbooker_settings');
					$wordbooker_settings['schemavers']=WORDBOOKER_SCHEMA_VERSION;
					wordbooker_set_options($wordbooker_settings);
					#var_dump($_POST);
					foreach (array_keys($_POST['wordbooker_settings']) as $key) {$wordbooker_settings[$key]=$_POST['wordbooker_settings'][$key];}
					update_option('wordbooker_settings',$wordbooker_settings);
				}
					# Pre 2.8 reset code.
				if ( isset ($_POST["rsysdef"])) {
					$wordbooker_settings["wordbook_default_author"]=0;
					$wordbooker_settings["wordbook_republish_time_frame"]=10;
					$wordbooker_settings["wordbook_attribute"]= __("Posted a new post on their blog");
					$wordbooker_settings["wordbooker_status_update_text"]= __(": New blog post :  %title% - %link%");
					$wordbooker_settings["wordbook_actionlink"]=300;
					$wordbooker_settings['wordbook_orandpage']=2;
					$wordbooker_settings['wordbook_extract_length']=256;
					$wordbooker_settings['wordbook_page_post']=-100;
					$wordbooker_settings["wordbooker_publish_default"]=null;
					$wordbooker_settings["wordbook_republish_time_obey"]=null;
					$wordbooker_settings["wordbooker_publish_override"]=null;
					$wordbooker_settings["wordbooker_status_update"]=null;
					$wordbooker_settings["wordbook_search_this_header"]=null;
					$wordbooker_settings["wordbook_comment_approve"]=null;
					$wordbooker_settings["wordbook_comment_push"]=null;
					$wordbooker_settings["wordbook_comment_poll"]=null;
					$wordbooker_settings["wordbook_publish_no_user"]=null;
					$wordbooker_settings["wordbook_advanced_diagnostics"]=null;
					$wordbooker_settings["wordbooker_like_button_show"]=null;
					$wordbooker_settings['wordbooker_comment_email']=get_bloginfo( 'admin_email' );
					wordbooker_set_options($wordbooker_settings);
				}
					$ol_flash =  __("Your settings have been saved.");
			} else {
				// Invalid form hash, possible CSRF attempt
				$ol_flash =  __("Security hash missing.");
			} // endif wbs_is_hash_valid
		} 
	}


	if ($ol_flash != '') echo '<div id="message" class="updated fade"><p>' . $ol_flash . '</p></div>';
	
	wordbooker_option_notices();

	$sql="select user_ID from ".WORDBOOKER_USERDATA." where user_ID=".$user_ID;
	$result = $wpdb->get_results($sql);
	# We need to put a check in here to stop this crapping out if there is no user id - so flag no row returned 
	$got_id=0;
	 if ( isset($result[0]->user_ID)) { 
		$wbuser = wordbooker_get_userdata($result[0]->user_ID);
 		if ($wbuser->session_key) { $got_id=1;}
	}

	if ($got_id==1) {
		wordbooker_update_userdata($wbuser);
		$checked_flag=array('on'=>'checked','off'=>'');
		$fbclient = wordbooker_fbclient($wbuser);
		$missing=0;
		if (!method_exists( 'FacebookRestClient1', 'stream_publish' ) ){ $missing=1;}
		if (!method_exists( 'FacebookRestClient1', 'stream_addcomment' ) ){ $missing=1;}
		if ($missing > 0 ) {
			_e("Fatal Error. Facebook Client libraries missing key functions. Please check your installed plugins for other Facebook plugins");
			echo "&nbsp;:<br /><br />";
			_e("Active Plugins");
			echo "&nbsp;:<b><br /><br />";	
			$active_plugins = get_option('active_plugins');
			$eep=get_plugins();
			foreach($active_plugins as $name) {
				echo $eep[$name]['Title']." ( ".$eep[$name]['Version']." ) <br />";
			}
			echo "</b></div>";
			return;
		}

		$wordbooker_script_end = wordbooker_microtime_float();
		#echo "Script executed in ".bcsub($wordbooker_script_end, $wordbooker_script_start, 4)." seconds.";
		# Populate  the cache table for this user if its not there.
		$result = $wpdb->get_row("select facebook_id from ".WORDBOOKER_USERDATA." where user_id=".$user_ID);
		if (strlen($result->facebook_id)<4) {
			
			wordbooker_cache_refresh($user_ID,$fbclient);
 		}

		$wordbooker_script_end = wordbooker_microtime_float();
	#	echo "Script executed in ".bcsub($wordbooker_script_end, $wordbooker_script_start, 4)." seconds.";
		# If the user saved their config after setting permissions or chose to refresh the cache then lets refresh the cache
		if ( isset ($_POST["perm_save"])) { wordbooker_cache_refresh($user_ID,$fbclient); }
	$wordbooker_script_end = wordbooker_microtime_float();
		#echo "Script executed in ".bcsub($wordbooker_script_end, $wordbooker_script_start, 4)." seconds.";
		$fblike_action=array('recommend'=>'Recommend ','like'=>'Like ');
		$fblike_colorscheme=array('dark'=>'Dark','light'=>'Light');
		$fblike_font=array('arial'=>'Arial','lucida grande'=>'Lucida grande ','segoe ui'=>'Segoe ui','tahoma'=>'Tahoma','trebuchet ms'=>'Trebuchet ms ','verdana'=>'Verdana');
		$fblike_button=array('button_count'=>'Button Count ','standard'=>'Standard ','box_count'=>'Box Count');
		$fblike_faces=array('false'=>'No','true'=>'Yes');	
		$fblike_send=array('false'=>'No','true'=>'Yes');
		$fblike_location=array('top'=>'Above Post ','bottom'=>'Below Post');

	if ($oldv==0) {

		echo'<p><hr><h3>';
		_e('Blog Level Customisation');
		echo'</h3><form action="options.php" method="post" action="">';
		settings_fields('wordbooker_options');
		echo '<input type="hidden" name="wordbooker_settings[schemavers]" value='.$wordbooker_settings['schemavers'].' />';
		$sql="select wpu.ID,wpu.display_name from $wpdb->users wpu,".WORDBOOKER_USERDATA." wud where wpu.ID=wud.user_id;";
		$wb_users = $wpdb->get_results($sql); 
			if(!isset($wordbooker_settings['wordbooker_comment_email'])) {$wordbooker_settings['wordbooker_comment_email']=get_bloginfo( 'admin_email' );}
		## Make it so that the drop down includes "Current logged in user" We know now that they have to have an account now as I've changed the code.
		_e( 'Unless changed, Posts will be published on the Facebook belonging to :');
		echo '<select name="wordbooker_settings[wordbook_default_author]" ><option value=0>' ;
		 _e('Current Logged in user');
		echo '&nbsp;</option>';
		$option="";
  		foreach ($wb_users as $wb_user) {	
			if ($wb_user->ID==$wordbooker_settings["wordbook_default_author"] ) {$option .= '<option selected="yes" value='.$wb_user->ID.'>';} else {
        		$option .= '<option value='.$wb_user->ID.'>';}
        		$option .= $wb_user->display_name;
        		$option .= '</option>';
		}
		echo $option;
		echo '</select><br />';

                echo '<label for="wb_extract_length">'.__('Length of Extract').' :</label> <select id="wordbook_extract_length" name="wordbooker_settings[wordbook_extract_length]"  >';
	        $arr = array(10=> "10",20=> "20",50=> "50",100=> "100",120=> "120",150=> "150",175=> "175",200=> "200",  250=> "250", 256=>__("256 (Default) "), 270=>"270", 300=>"300", 350 => "350",400 => "400");
                foreach ($arr as $i => $value) {
                        if ($i==$wordbooker_settings['wordbook_extract_length']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}}
                echo "</select><br />";

		echo '<label for="wb_publish_default">'.__("Default Publish Post to Facebook"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_publish_default]" '.$checked_flag[$wordbooker_settings["wordbooker_publish_default"]].' ><br />';

		echo '<label for="wb_publish_no_user">'.__("Publish Posts by non Wordbooker users"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_publish_no_user]" '.$checked_flag[$wordbooker_settings["wordbook_publish_no_user"]].' ><br />';

		echo '<label for="wb_publish_user_publish">'.__("Allow non Wordbooker users to chose to publish a post"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_allow_publish_select]" '.$checked_flag[$wordbooker_settings["wordbook_allow_publish_select"]].' ><br />';

		echo '<label for="wb_wordbooker_fb_rec_act">'.__("Include FB Recent activity on Wordbooker Options page"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_fb_rec_act]" '.$checked_flag[$wordbooker_settings["wordbooker_fb_rec_act"]].' ><br />';


		echo '<label for="wb_facebook_like_share">'.__("Include a Facebook Share button in blog"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_share_too]" '.$checked_flag[$wordbooker_settings["wordbooker_like_share_too"]].' ><br />';

		echo '<label for="wb_facebook_like">'.__("Include a Facebook Like button in blog"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_show]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_show"]].' ><br />';
		echo '<label for="wb_facebook_like">'.__("Don't show Like or Share on Sticky Posts"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_no_share_like_stick]" '.$checked_flag[$wordbooker_settings["wordbooker_no_share_like_stick"]].' ><br />';

		if (!is_numeric($wordbooker_settings['wordbooker_like_width']) || $wordbooker_settings['wordbooker_like_width'] <0) {$wordbooker_settings['wordbooker_like_width']=250;}
		echo '<label for="wb_facebook_like_width">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Width of Facebook Like box"). ' : </label>';
		echo '<INPUT TYPE=text NAME="wordbooker_settings[wordbooker_like_width]"  size="7"value="'.$wordbooker_settings["wordbooker_like_width"].'" ><br />';

		echo '<label for="wb_facebook_iframe">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Use Iframes instead of FBXML"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_iframe]" '.$checked_flag[$wordbooker_settings["wordbooker_iframe"]].' ><br />';
	
		echo '<label for="wb_facebook_like_front">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Like button on front page"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_frontpage]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_frontpage"]].' ><br />';

		echo '<label for="wb_facebook_like_front">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Like button on Category pages"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_category]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_category"]].' ><br />';

		echo '<label for="wb_facebook_like_page">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Like button on Pages"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_page]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_page"]].' ><br />';

		echo '<label for="wb_facebook_like">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Like button in each post"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_post]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_post"]].' ><br />';


		echo '<label for="wb_facebook_share_front">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Share button on front page"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_share_button_frontpage]" '.$checked_flag[$wordbooker_settings["wordbooker_share_button_frontpage"]].' ><br />';

		echo '<label for="wb_facebook_share_front">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Share button on Category pages"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_share_button_category]" '.$checked_flag[$wordbooker_settings["wordbooker_share_button_category"]].' ><br />';

		echo '<label for="wb_facebook_like_page">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Share button on Pages"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_share_button_page]" '.$checked_flag[$wordbooker_settings["wordbooker_share_button_page"]].' ><br />';

		echo '<label for="wb_facebook_like">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Share button in each post"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_share_button_post]" '.$checked_flag[$wordbooker_settings["wordbooker_share_button_post"]].' ><br />';


		echo '<label for="wb_fbshare_location">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Share - Display Button ').' :</label> <select id="wordbook_fbshare_location" name="wordbooker_settings[wordbook_fbshare_location]"  >';
		foreach ($fblike_location as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fbshare_location']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_location[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_location[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_location">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Display Button ').' :</label> <select id="wordbook_fblike_location" name="wordbooker_settings[wordbook_fblike_location]"  >';
		foreach ($fblike_location as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_location']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_location[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_location[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_action">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Verb to Display').' :</label> <select id="wordbook_fblike_action" name="wordbooker_settings[wordbook_fblike_action]"  >';
		foreach ($fblike_action as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_action']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_action[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_action[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_colorscheme">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Colour Scheme').' :</label> <select id="wordbook_fblike_colorscheme" name="wordbooker_settings[wordbook_fblike_colorscheme]"  >';
		foreach ($fblike_colorscheme as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_colorscheme']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_colorscheme[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_colorscheme[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_font">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Display Font').' :</label> <select id="wordbook_fblike_font" name="wordbooker_settings[wordbook_fblike_font]"  >';
		foreach ($fblike_font as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_font']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_font[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_font[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Layout Style').' :</label> <select id="wordbook_fblike_button" name="wordbooker_settings[wordbook_fblike_button]"  >';
		foreach ($fblike_button as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_button']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_button[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_button[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_faces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Display Faces (Standard layout only)').' :</label> <select id="wordbook_fblike_faces" name="wordbooker_settings[wordbook_fblike_faces]"  >';
		foreach ($fblike_faces as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_faces']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_faces[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_faces[$i].'</option>';}}
		echo "</select><br />";


		echo '<label for="wb_fblike_send">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Show Send	Button (Only when using FBXML)').' :</label> <select id="wordbook_fblike_send" name="wordbooker_settings[wordbook_fblike_send]"  >';
		foreach ($fblike_send as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_send']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_send[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_send[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_attribute">'.__("Post Attribute"). ' : </label>';
		echo '<INPUT NAME="wordbooker_settings[wordbook_attribute]" size=60 maxlength=240 value="'.htmlspecialchars(stripslashes($wordbooker_settings["wordbook_attribute"])).'"><br />';

		echo '<label for="wb_publish_timeframe">'.__("Republish Post if edited more than"). ' : </label>';
		echo '<INPUT NAME="wordbooker_settings[wordbook_republish_time_frame]" size=3 maxlength=3 value='.$wordbooker_settings["wordbook_republish_time_frame"].'> '.__("days ago").' <INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_republish_time_obey]" '.$checked_flag[$wordbooker_settings["wordbook_republish_time_obey"]].' ><br />';

		echo '<label for="wb_publish_republicatio">'.__("Override Re-Publication window "). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_publish_override]" '.$checked_flag[$wordbooker_settings["wordbooker_publish_override"]].' > ( '.__("Force Re-Publish Post to Facebook on Edit").')<br />';

		echo '<label for="wb_status_update">'.__("Update Facebook Status"). ' :</label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_status_update]" '.$checked_flag[$wordbooker_settings["wordbooker_status_update"]].' >';
		echo' <INPUT NAME="wordbooker_settings[wordbooker_status_update_text]" size=60 maxlength=60 value="'.htmlspecialchars(stripslashes($wordbooker_settings["wordbooker_status_update_text"])).'"> ';

		echo '<br /><label for="wb_action_link">'.__("Action Link Option "). ': </label><select id="wordbook_actionlink" name="wordbooker_settings[wordbook_actionlink]"  >';	
      		 $arr = array(100=> "None ",  200=> __("Share Link "), 300=>__("Read Full Article"));
                foreach ($arr as $i => $value) {
                        if ($i==$wordbooker_settings['wordbook_actionlink']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}}
                echo "</select><br />";

		echo '<label for="wordbook_search_this_header">'.__("Enable Extended description for Share Link"). ' :</label> ';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_search_this_header]" '.$checked_flag[$wordbooker_settings["wordbook_search_this_header"]].' /><br />';
			echo '<label for="wb_description_meta_length">'.__('Length of Description Meta-Tag').' :</label> <select id="wordbook_description_meta_length" name="wordbooker_settings[wordbook_description_meta_length]" >';
		$arr = array(0=> "Disable", 150=> "150", 350=>"350 (Default)");
		foreach ($arr as $i => $value) {
		if ($i==$wordbooker_settings['wordbook_description_meta_length']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
		else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_import_comment">'.__("Import Comments from Facebook for Wordbook Posts"). ': </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_comment_get]" '.$checked_flag[$wordbooker_settings["wordbook_comment_get"]]. '/> ( '.__("Next Scheduled fetch is in").' : '.date('i',(wp_next_scheduled('wb_cron_job') - time ())).' minute(s) )<br />';

		echo '<label for="wb_publish_comment_approve">'.__("Auto Approve imported comments / Bypass Spam checks"). ' :</label> ';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_comment_approve]" '.$checked_flag[$wordbooker_settings["wordbook_comment_approve"]].' /><br />';

		echo '<label for="wb_publish_comment_push">'.__("Push Comments up to Facebook"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_comment_push]" '.$checked_flag[$wordbooker_settings["wordbook_comment_push"]].' /> <br />  ';
		echo '<input type="hidden" name="wordbooker_settings[wordbook_page_post]" value="-100" />';
		echo '<input type="hidden" name="wordbooker_settings[wordbook_orandpage]" value="2" />';

if(ADVANCED_DEBUG) {
		echo '<label for="wb_comment_poll">'.__("Force Poll for Comments when visiting this screen"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_comment_poll]" '.$checked_flag[$wordbooker_settings["wordbook_comment_poll"]].' /> <br />';
}
		echo '<label for="wb_comment_email">'.__("Assign this email address to comments"). ' :</label>';
		echo' <INPUT NAME="wordbooker_settings[wordbooker_comment_email]" size=60 maxlength=60 value="'.stripslashes($wordbooker_settings["wordbooker_comment_email"]).'"> <br />';

		
		echo '<label for="wb_comment_poll">'.__("Enable Advanced post diagnostics"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_advanced_diagnostics]" '.$checked_flag[$wordbooker_settings["wordbook_advanced_diagnostics"]].' /></P><p>';

		if (current_user_can('activate_plugins')) {echo '<input type="submit" name="SBLO" value="'.__("Save Blog Level Options").'" class="button-primary"  />&nbsp;&nbsp;&nbsp;<input type="submit" name="RSD" value="'.__("Reset to system Defaults").'" class="button-primary" action="poo" />';}
		echo '</p></form><br /></div><hr>';

	}

	if ($oldv==1) {
		echo'<p><hr><h3>'.__("Blog Level Customisation").' : </h3>';
		echo'<form action="" method="post">';
		echo '<input type="hidden" name="wordbooker_settings[schemavers]" value='.$wordbooker_settings['schemavers'].' />';
		echo '<input type="hidden" name="token" value="' . wbs_retrieve_hash() . '" />';
		$sql="select wpu.ID,wpu.display_name from $wpdb->users wpu,".WORDBOOKER_USERDATA." wud where wpu.ID=wud.user_id;";
		$wb_users = $wpdb->get_results($sql); 
		## Make it so that the drop down includes "Current logged in user"
		_e( 'Unless changed, Posts will be published on the Facebook belonging to :');
		echo '<select name="wordbooker_settings[wordbook_default_author]" ><option value=0>' ;
		 _e('Current Logged in user');
		echo '&nbsp;</option>';
		$option="";
  		foreach ($wb_users as $wb_user) {	
			if ($wb_user->ID==$wordbooker_settings["wordbook_default_author"] ) {$option .= '<option selected="yes" value='.$wb_user->ID.'>';} else {
        		$option .= '<option value='.$wb_user->ID.'>';}
        		$option .= $wb_user->display_name;
        		$option .= '</option>';
		}
		echo $option;
		echo '</select><br />';

                echo '<label for="wb_extract_length">'.__('Length of Extract').' :</label> <select id="wordbook_extract_length" name="wordbooker_settings[wordbook_extract_length]"  >';
	      	        $arr = array(10=> "10",20=> "20",50=> "50",100=> "100",120=> "120",150=> "150",175=> "175",200=> "200",  250=> "250", 256=>__("256 (Default) "), 270=>"270", 300=>"300", 350 => "350",400 => "400");
                foreach ($arr as $i => $value) {
                        if ($i==$wordbooker_settings['wordbook_extract_length']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}}
                echo "</select><br />";

		echo '<label for="wb_publish_default">'.__("Default Publish Post to Facebook"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_publish_default]" '.$checked_flag[$wordbooker_settings["wordbooker_publish_default"]].' ><br />';

		echo '<label for="wb_publish_no_user">'.__("Publish Posts by non Wordbooker users"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_publish_no_user]" '.$checked_flag[$wordbooker_settings["wordbook_publish_no_user"]].' ><br />';


		echo '<label for="wb_facebook_like">'.__("Include a Facebook Like button in blog"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_show]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_show"]].' ><br />';

		echo '<label for="wb_facebook_like_share">'.__("Include a Facebook Share button in blog"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_share_too]" '.$checked_flag[$wordbooker_settings["wordbooker_like_share_too"]].' ><br />';


		echo '<label for="wb_facebook_iframe">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Use Iframes instead of FBXML"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_iframe]" '.$checked_flag[$wordbooker_settings["wordbooker_iframe"]].' ><br />';

		echo '<label for="wb_facebook_like">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Like button in each post"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_post]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_post"]].' ><br />';

		echo '<label for="wb_facebook_like_front">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Like button on front page"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_frontpage]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_frontpage"]].' ><br />';

		echo '<label for="wb_facebook_like_page">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Like button on Pages"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_page]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_page"]].' ><br />';

		echo '<label for="wb_facebook_like_front">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Like button on Category pages"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_like_button_category]" '.$checked_flag[$wordbooker_settings["wordbooker_like_button_category"]].' ><br />';
		echo '<label for="wb_facebook_like_front">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Share button on front page"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_share_button_frontpage]" '.$checked_flag[$wordbooker_settings["wordbooker_share_button_frontpage"]].' ><br />';

		echo '<label for="wb_facebook_like_page">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Share button on Pages"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_share_button_page]" '.$checked_flag[$wordbooker_settings["wordbooker_share_button_page"]].' ><br />';


		echo '<label for="wb_facebook_like">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Share button in each post"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_share_button_post]" '.$checked_flag[$wordbooker_settings["wordbooker_share_button_post"]].' ><br />';


		echo '<label for="wb_facebook_like_front">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__("Show Facebook Share button on Category pages"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_share_button_category]" '.$checked_flag[$wordbooker_settings["wordbooker_share_button_category"]].' ><br />';






		echo '<label for="wb_fbshare_location">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Share - Display Button ').' :</label> <select id="wordbook_fbshare_location" name="wordbooker_settings[wordbook_fbshare_location]"  >';
		foreach ($fblike_location as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fbshare_location']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_location[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_location[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_location">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Display Button ').' :</label> <select id="wordbook_fblike_location" name="wordbooker_settings[wordbook_fblike_location]"  >';
		foreach ($fblike_location as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_location']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_location[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_location[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_action">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Verb to Display').' :</label> <select id="wordbook_fblike_action" name="wordbooker_settings[wordbook_fblike_action]"  >';
		foreach ($fblike_action as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_action']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_action[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_action[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_colorscheme">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Colour Scheme').' :</label> <select id="wordbook_fblike_colorscheme" name="wordbooker_settings[wordbook_fblike_colorscheme]"  >';
		foreach ($fblike_colorscheme as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_colorscheme']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_colorscheme[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_colorscheme[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_font">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Display Font').' :</label> <select id="wordbook_fblike_font" name="wordbooker_settings[wordbook_fblike_font]"  >';
		foreach ($fblike_font as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_font']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_font[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_font[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Layout Style').' :</label> <select id="wordbook_fblike_button" name="wordbooker_settings[wordbook_fblike_button]"  >';
		foreach ($fblike_button as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_button']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_button[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_button[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_fblike_faces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.__('Facebook Like - Display Faces').' :</label> <select id="wordbook_fblike_faces" name="wordbooker_settings[wordbook_fblike_faces]"  >';
		foreach ($fblike_faces as $i => $value) {
			if ($i==$wordbooker_settings['wordbook_fblike_faces']){ print '<option selected="yes" value="'.$i.'" >'.$fblike_faces[$i].'</option>';}
		       else {print '<option value="'.$i.'" >'.$fblike_faces[$i].'</option>';}}
		echo "</select><br />";

		echo '<label for="wb_attribute">'.__("Post Attribute"). ' : </label>';
		echo '<INPUT NAME="wordbooker_settings[wordbook_attribute]" size=60 maxlength=240 value="'.stripslashes($wordbooker_settings["wordbook_attribute"]).'"><br />';

		echo '<label for="wb_publish_timeframe">'.__("Republish Post if edited more than"). ' : </label>';
		echo '<INPUT NAME="wordbooker_settings[wordbook_republish_time_frame]" size=3 maxlength=3 value='.$wordbooker_settings["wordbook_republish_time_frame"].'> '.__("days ago").' <INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_republish_time_obey]" '.$checked_flag[$wordbooker_settings["wordbook_republish_time_obey"]].' ><br />';

		echo '<label for="wb_publish_republication">'.__("Override Re-Publication window "). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_publish_override]" '.$checked_flag[$wordbooker_settings["wordbooker_publish_override"]].' > ( '.__("Force Re-Publish Post to Facebook on Edit").')<br />';

		echo '<label for="wb_status_update">'.__("Update Facebook Status"). ' :</label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbooker_status_update]" '.$checked_flag[$wordbooker_settings["wordbooker_status_update"]].' >';
		echo' <INPUT NAME="wordbooker_settings[wordbooker_status_update_text]" size=60 maxlength=60 value="'.stripslashes($wordbooker_settings["wordbooker_status_update_text"]).'"> ';

		echo '<br /><label for="wb_action_link">'.__("Action Link Option "). ': </label><select id="wordbook_actionlink" name="wordbooker_settings[wordbook_actionlink]"  >';	
      		 $arr = array(100=> "None ",  200=> __("Share Link "), 300=>__("Read Full Article"));
                foreach ($arr as $i => $value) {
                        if ($i==$wordbooker_settings['wordbook_actionlink']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}}
                echo "</select><br />";

		echo '<label for="wordbook_search_this_header">'.__("Enable Extended description for Share Link"). ' :</label> ';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_search_this_header]" '.$checked_flag[$wordbooker_settings["wordbook_search_this_header"]].' /><br />';

		echo '<label for="wb_import_comment">'.__("Import Comments from Facebook for Wordbook Posts"). ': </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_comment_get]" '.$checked_flag[$wordbooker_settings["wordbook_comment_get"]]. '/> ( '.__("Next Scheduled fetch is at").' : '.date_i18n(get_option('time_format'),wp_next_scheduled('wb_cron_job')).' ) <br />';

		echo '<label for="wb_publish_comment_approve">'.__("Auto Approve imported comments / Bypass Spam Checks"). ' :</label> ';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_comment_approve]" '.$checked_flag[$wordbooker_settings["wordbook_comment_approve"]].' /><br />';

		echo '<label for="wb_publish_comment_push">'.__("Push Comments up to Facebook"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_comment_push]" '.$checked_flag[$wordbooker_settings["wordbook_comment_push"]].' /> <br />  ';
		echo '<input type="hidden" name="wordbooker_settings[wordbook_page_post]" value="-100" />';
		echo '<input type="hidden" name="wordbooker_settings[wordbook_orandpage]" value="2" />';
		echo '<label for="wb_comment_poll">'.__("Force Poll for Comments when visiting this screen"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_comment_poll]" '.$checked_flag[$wordbooker_settings["wordbook_comment_poll"]].' /> <br />';

		echo '<label for="wb_comment_poll">'.__("Enable Advanced post diagnostics"). ' : </label>';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_settings[wordbook_advanced_diagnostics]" '.$checked_flag[$wordbooker_settings["wordbook_advanced_diagnostics"]].' /></P><p>';

		if (current_user_can('activate_plugins')) {echo '<input type="submit" value="Save Blog Level Options" class="button-primary"  />&nbsp;&nbsp;&nbsp;<input type="submit" name="rsysdef" value="Reset to system Defaults" class="button-primary"  />';}
		echo '</p></form><br /><br /></div><hr>';
}
		# USER LEVEL OPTIONS
		$wordbookuser_settings=get_usermeta($user_ID,$wordbook_user_settings_id);
		# Set a couple of options that we really need.
		if( !isset($wordbookuser_settings['wordbook_orandpage'])) {$wordbookuser_settings['wordbook_orandpage']=2;}
		if( !isset($wordbookuser_settings['wordbooker_publish_default'])) {$wordbookuser_settings['wordbooker_publish_default']=$wordbooker_settings['wordbooker_publish_default'];}
		$wordbooker_script_end = wordbooker_microtime_float();
		#echo "Script executed in ".bcsub($wordbooker_script_end, $wordbooker_script_start, 4)." seconds.";
		echo '<div class="wrap">';
		echo '<h3>'.__('User Level Customisation').'</h3>';
		_e("If set, these options will override the Blog Level options for this user");

		echo '<br /><br /><form action="" method="post">';
		echo '<input type="hidden" name="token" value="' . wbs_retrieve_hash() . '" />';
		echo '<input type="hidden" name="user_meta" value="true" />';

		echo '<label for="wb_publish_default">'.__('Default Publish Post to Facebook').' : </label>';
		echo '<select id="wordbooker_publish_default" name="wordbooker_publish_default"  >';	
      		 $arr = array(0=> __("Same as Blog"), 100=> __("No"),  200=> ("Yes"));
                foreach ($arr as $i => $value) {
                        if ($i==$wordbookuser_settings['wordbooker_publish_default']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}
		}
                echo "<</select><br />";

 		echo '<label for="wb_extract_length">'.__('Length of Extract').' : </label><select id="wordbook_extract_length" name="wordbook_extract_length"  >';
	        $arr = array(0=> __("Same as Blog"),10=> "10",20=> "20",50=> "50",100=> "100",120=> "120",150=> "150",175=> "175",200=> "200",  250=> "250", 256=>__("256 (Default) "), 270=>"270", 300=>"300", 350 => "350",400 => "400");
                foreach ($arr as $i => $value) {
                        if ($i==$wordbookuser_settings['wordbook_extract_length']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}
		}
                echo "</select><br />";
		echo '<input type="hidden" name="wordbook_page_post" value="-100" />';
		echo '<input type="hidden" name="wordbook_orandpage" value="2" />';
		# Get the list of pages this user is an admin for
		$result = $wpdb->get_row("select pages from ".WORDBOOKER_USERDATA." where user_id=".$user_ID);
		$fanpages=unserialize($result->pages);
		$have_fan_pages=0;
		if (strlen($result->pages) > 0 ){
			$have_fan_pages=1;
			echo '<label for="wb_fan_page"> <select id="wordbook_orandpage" name="wordbook_orandpage"  >';
			$arr = array(1=> __("Instead of"),  2=> __("As well as") );
               		foreach ($arr as $i => $value) {
                       		 if ($i==$wordbookuser_settings['wordbook_orandpage']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                      		 else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}
			}
                	echo "</select>";
			echo '&nbsp;'.__('publishing to a personal wall, post to the following fan page').' : <select name="wordbook_page_post" ><option selected="yes" value=-100>'.__('No Fan Page').'&nbsp;&nbsp;</option>';
			$option="";
			foreach ($fanpages as $fan_page) {
				if (strlen($fan_page['name'])>=2) {
				if ($fan_page['page_id']==$wordbookuser_settings["wordbook_page_post"] ) {$option .= '<option selected="yes" value='.$fan_page['page_id'].'>';} else { $option .= '<option value='.$fan_page['page_id'].'>';}
				$option .= $fan_page['name']." (".$fan_page['page_id'].")&nbsp;&nbsp;";
				$option .= '</option>';}
			}
			echo $option;
			echo '</select><br />'; 
		}
		echo '<label for="wb_status_update">'.__('Update Facebook Status').'  : </label> ';
		echo ' <select id="wordbooker_status_update" name="wordbooker_status_update"  >';	
       		$arr = array(0=> __("Same as Blog"), 100=> __("No"),  200=> __("Yes"));
                foreach ($arr as $i => $value) {
                        if ($i==$wordbookuser_settings['wordbooker_status_update']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}
		}
                echo "</select>";
		echo '<INPUT NAME="wordbooker_status_update_text" size=60 maxlength=60 value="'.htmlspecialchars(stripslashes($wordbookuser_settings["wordbooker_status_update_text"])).'"> ';
		echo '</select><br />';

		echo '<label for="wb_attribute">'.__('Post Attribute').' : </label>';
		echo '<INPUT NAME="wordbook_attribute" size=60 maxlength=240 value="'.htmlspecialchars(stripslashes($wordbookuser_settings["wordbook_attribute"])).'"><br />';

		echo '<label for="wb_action_link">'.__('Action Link Option').' : </label><select id="wordbook_actionlink" name="wordbook_actionlink"  >';	
       		$arr = array(0=> __("Same as Blog"), 100=> __("None"),  200=> __("Share Link"), 300=>__("Read Full Article"));
                foreach ($arr as $i => $value) {
                        if ($i==$wordbookuser_settings['wordbook_actionlink']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}
		}
                echo "</select><br />";

		echo '<label for="wordbook_search_this_header">'.__('Enable Extended description for Share Link').' : </label> ';
		echo '<select id="wordbook_search_this_header" name="wordbook_search_this_header"  >';	
       		$arr = array(0=> __("Same as Blog"), 100=> __("No"),  200=> __("Yes"));
                foreach ($arr as $i => $value) {
                        if ($i==$wordbookuser_settings['wordbook_search_this_header']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
                       else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}
		}
                echo "</select><br />";


		if ( function_exists( 'get_the_post_thumbnail' ) ) {
			echo '<label for="wb_thumb_only">'.__('Use Post Thumbnail only').' : </label>';
			echo '<INPUT TYPE=CHECKBOX NAME="wordbook_thumb_only" '.$checked_flag[$wordbookuser_settings["wordbook_thumb_only"]].'><br />';
		}
		
		echo '<label for="wb_use_extract">'.__('Use Post Excerpt').' : </label>';
			echo '<INPUT TYPE=CHECKBOX NAME="wordbook_use_excerpt" '.$checked_flag[$wordbookuser_settings["wordbook_use_excerpt"]].'><br />';

		echo '<label for="wb_status_id">'.__('Show Status for').' : </label> <select name="wordbook_status_id" ><option selected="yes" value=-100>'.__('My Own Profile').'&nbsp;&nbsp;</option>';
		$option="";
		if ($have_fan_pages==1) {
			foreach ($fanpages as $fan_page) {
				if ($fan_page[page_id]==$wordbookuser_settings["wordbook_status_id"] ) {$option .= '<option selected="yes" value='.$fan_page[page_id].'>';} else { $option .= '<option value='.$fan_page[page_id].'>';}
				$option .= $fan_page[name]."&nbsp;&nbsp;";
				$option .= '</option>';
			}
			echo $option;
		}
		echo '</select><br />'; 
		_e('Disable Facebook User information in Status');
		echo ' : <INPUT TYPE=CHECKBOX NAME="wordbook_disable_status" '.$checked_flag[$wordbookuser_settings["wordbook_disable_status"]].'><br /><p>';

		echo '<input type="submit" value="'.__("Save User Options").'" name="swbus" class="button-primary"  />&nbsp;&nbsp;&nbsp;<input type="submit" name="rwbus" value="'.__("Reset to Blog Defaults").'" class="button-primary"  /></form><br /></div><hr>';
		
	// Lets poll if they want to - we only poll for this user
			#$dummy=wordbooker_poll_facebook($user_ID);
		if ( isset($wordbooker_settings["wordbook_comment_poll"])  && ADVANCED_DEBUG ){
			$dummy=wordbooker_poll_facebook($user_ID);
		}
		wordbooker_render_errorlogs();
		wordbooker_render_diagnosticlogs();
		wordbooker_status($user_ID);
		wordbooker_option_status($wbuser);
		$wordbooker_script_end = wordbooker_microtime_float();
		#echo "Script executed in ".bcsub($wordbooker_script_end, $wordbooker_script_start, 4)." seconds.";
		echo "<br /><hr><h3>";
 	_e("Donate");
		echo "</h3>";

		if (wordbooker_contributed (0) ){
		_e("Thank you for contributing towards the support and development of this extension.");
		echo "<br /><br />";
	}
	else {
		_e("If you've found this extension useful then please feel free to donate to its support and future development. Please provide your FB Id number and your website when making payment so your details can be added to the 'thanks' list"); }
	  ?><br /><br />
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHPwYJKoZIhvcNAQcEoIIHMDCCBywCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYBS1CS6j8gSPzUcHkKZ5UYKF2n97UX8EhSB+QgoExXlfJWLo6S7MJFvuzay0RhJNefA9Y1Jkz8UQahqaR7SuIDBkz0Ys4Mfx6opshuXQqxp17YbZSUlO6zuzdJT4qBny2fNWqutEpXe6GkCopRuOHCvI/Ogxc0QHtIlHT5TKRfpejELMAkGBSsOAwIaBQAwgbwGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIitf6nEQBOsSAgZgWnlCfjf2E3Yekw5n9DQrNMDoUZTckFlqkQaLYLwnSYbtKanICptkU2fkRQ3T9tYFMhe1LhAuHVQmbVmZWtPb/djud5uZW6Lp5kREe7c01YtI5GRlK63cAF6kpxDL9JT2GH10Cojt9UF15OH46Q+2V3gu98d0Lad77PXz3V1XY0cto29buKZZRfGG8u9NfpXZjv1utEG2CP6CCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTA5MTAyODE0MzM1OVowIwYJKoZIhvcNAQkEMRYEFIf+6qkVI7LG/jPumIrQXIOhI4hJMA0GCSqGSIb3DQEBAQUABIGAdpAB4Mj4JkQ6K44Xxp4Da3GsRCeiLr2LMqrAgzF8jYGgV9zjf7PXxpC8XJTVC7L7oKDtoW442T9ntYj6RM/hSjmRO2iaJq0CAZkz2sPZWvGlnhYrpEB/XB3dhmd2nGhUMSXbtQzZvR7JMVoPR0zxL/X/Hfj6c+uF7BxW8xTSBqw=-----END PKCS7-----">
		<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
		<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
		</form><br /><br /><hr><h3>
		<?php
		_e("Thanks");
		echo "</h3>";
		_e("The following people and blogs have contributed to the ongoing development of this plugin : "); 
		
		wordbooker_contributed(1);

		echo "<br /><hr>";
		wordbooker_option_support();
	#	echo "</div>";
        }
	 else {
		wordbooker_option_setup($wbuser);
		wordbooker_render_diagnosticlogs();
		wordbooker_option_support();
	}	

	}	


/* Use the admin_menu action to define the custom boxes. Dont do this unless we have options set */
	if (get_option('wordbooker_settings')) { add_action('admin_menu', 'wordbooker_add_custom_box');}

/* Adds a custom section to the "advanced" Post edit screens */
function wordbooker_add_custom_box() {
	if (current_user_can(WORDBOOKER_MINIMUM_ADMIN_LEVEL)) {
		add_meta_box( 'wordbook_sectionid', __('WordBooker Options'),'wordbooker_inner_custom_box', 'post', 'advanced' );
		add_meta_box( 'wordbook_sectionid', __('WordBooker Options'),'wordbooker_inner_custom_box', 'page', 'advanced' );
	}
}
   
/* Prints the inner fields for the custom post/page section */
function wordbooker_inner_custom_box() {
	# We need to put in a "read only" key on the inputs for users who will be able to post but not be able to change settings.
	echo '<input type="hidden" name="wordbook_noncename" id="wordbook_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	global $wpdb,$user_ID,$blog_id,$post;
	$wordbooker_settings=wordbooker_options(); 
	$checked_flag=array('on'=>'checked','off'=>'', 100=>'', 200=>'checked');
	# Now get the user settings for this blog.
	# If the user is set to logged in user then get the current user, otherwise pick up the settings for the user selected.
	if  ($wordbooker_settings["wordbook_default_author"] == 0 ) {$wb_user_id=$user_ID;} else {$wb_user_id=$wordbooker_settings["wordbook_default_author"];}
	$wordbook_user_settings_id="wordbookuser".$blog_id;
	# We need to do some more checking here. If the user does not have an entry in the wordbooker user table then we should get the user options for the user set as the default user.
	$wordbookuser=get_usermeta($wb_user_id,$wordbook_user_settings_id);
	# If we have user settings then lets go through and override the blog level defaults.
	if(is_array($wordbookuser)) {
		foreach (array_keys($wordbookuser) as $key) {
			if ((strlen($wordbookuser[$key])>0) && ($wordbookuser[$key]!="0") ) {
				$wordbooker_settings[$key]=$wordbookuser[$key];
			} 
		}
	}
	$x = get_post_meta($post->ID, 'wordbooker_options', true); 
	if(is_array($x)) {
		foreach (array_keys($x) as $key ) {
			if (substr($key,0,8)=='wordbook') {
				$post_meta[$key]=str_replace( array('&amp;','&quot;','&#039;','&lt;','&gt;','&nbsp;&nbsp;'),array('&','"','\'','<','>',"\t"),$x[$key]);
			}
		}
	}	
	# If we have post settings then lets go through and override the blog level defaults.
	if(is_array($post_meta)) {
	#	foreach (array_keys($post_meta) as $key) {
	#		if ((strlen($post_meta[$key])>0) && ($post_meta[$key]!="0") ) {
	#			$wordbooker_settings[$key]=$post_meta[$key];
	#			echo "replacing ".$key."<br>";
	#		} 
		$wordbooker_settings=$post_meta;
		#}

	}
	if (wordbooker_get_userdata($user_ID)) {
		if (! isset($wordbooker_settings['wordbook_page_post'])) { $wordbooker_settings['wordbook_page_post']=-100;}
		if (! isset($wordbooker_settings['wordbook_orandpage'])) { $wordbooker_settings['wordbook_orandpage']= 2; }
		echo '<input type="hidden" name="wordbook_page_post" value="-100" />';
		echo '<input type="hidden" name="wordbook_orandpage" value="2" />';
		echo __("The following options override the defaults set on the options page")."<br /><br />";
		$sql="select wpu.ID,wpu.display_name from $wpdb->users wpu,".WORDBOOKER_USERDATA." wud where wpu.ID=wud.user_id;";
		$wb_users = $wpdb->get_results($sql);
		_e('Posts will be published on the Facebook belonging to');
		echo ' : <select name="wordbook_default_author" >';
		foreach ($wb_users as $wb_user) {	
			if ($wb_user->ID==$wordbooker_settings["wordbook_default_author"] || ($wordbooker_settings["wordbook_default_author"] == 0 && $wb_user->ID==$user_ID)) 					{$option = '<option selected="yes" value='.$wb_user->ID.'>';} 
			else {
				$option = '<option value='.$wb_user->ID.'>';
			}
			$option .= " ".$wb_user->display_name;
			if ($wb_user->ID==$user_ID) { $option.=" ( ".__('You')." )&nbsp;&nbsp;"; }
			$option .= '</option>';
			echo $option;
		}
		echo "</select><br />";
		$result = $wpdb->get_row("select pages from ".WORDBOOKER_USERDATA." where user_id=".$wb_user_id);
		$fanpages=unserialize($result->pages);
		if (is_array($fanpages)){
			echo '<select id="wordbook_orandpage" name="wordbook_orandpage"  >';
			$arr = array(1=> __("Or"),  2=> __("And") );
			foreach ($arr as $i => $value) {
		       		if ($i==$wordbooker_settings['wordbook_orandpage']){ 
					print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';
				}
		     		  else {
					print '<option value="'.$i.'" >'.$arr[$i].'</option>';
				}
			}
			echo "</select> ";
			_e('post to the following fan page');
			$option='<select name="wordbook_page_post" > ';
			if ($wordbooker_settings['wordbook_page_post']==-100) { $option .= '<option selected="yes" value=-100>'.__('No Fan Page').'</option>';} else { $option .= '<option value=-100>'.__('Select Fan Page').'</option>';}
			foreach ($fanpages as $fan_page) {
				if (strlen($fan_page['name'])>=2) {
				if ($fan_page['page_id']==$wordbooker_settings['wordbook_page_post']){ $option .= '<option selected="yes" value="'.$fan_page['page_id'].'" >'.$fan_page['name'].'</option>';}
		       		else {$option .= '<option value="'.$fan_page['page_id'].'" >'.$fan_page['name'].' ('.$fan_page['page_id'].')&nbsp;&nbsp;</option>';}
				$option .= '</option>';}
			}
			echo  ": ".$option;
			echo '</select><br />'; 
		}

		echo __('Length of Extract').' : <select id="wordbook_extract_length" name="wordbook_extract_length"  >';
		$arr = array( 10=> "10",20=> "20",50=> "50",100=> "100",120=> "120",150=> "150",175=> "175", 200=> "200",  250=> "250", 256=>"256", 270=>"270", 300=>"300", 350 => "350",400 => "400");
	        foreach ($arr as $i => $value) {
	                if ($i==$wordbooker_settings['wordbook_extract_length']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';}
	               else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}
		}
	        echo "</select><br />";

		echo __('Action Link Option').' :<select id="wordbook_actionlink" name="wordbook_actionlink"  >';	
	       $arr = array(100=> "None ",  200=> __("Share Link"), 300=>__("Read Full Article"));
		        foreach ($arr as $i => $value) {
		                if ($i==$wordbooker_settings['wordbook_actionlink']){ print '<option selected="yes" value="'.$i.'" >'.$arr[$i].'</option>';} 
		               else {print '<option value="'.$i.'" >'.$arr[$i].'</option>';}}
		        echo "<</select><br /><br />";

		echo '<input type="hidden" name="soupy" value="twist" />';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_publish_default" '.$checked_flag[$wordbooker_settings["wordbooker_publish_default"]].' > '.__('Publish Post to Facebook').'<br />';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_publish_override" '.$checked_flag[$wordbooker_settings["wordbooker_publish_override"]].' >'.__('Force Re-Publish Post to Facebook on Edit (overrides republish window)').'<br />';
		if ( function_exists( 'get_the_post_thumbnail' ) ) {
			echo '<INPUT TYPE=CHECKBOX NAME="wordbook_thumb_only" '.$checked_flag[$wordbooker_settings["wordbook_thumb_only"]].'>'.__(' Use Thumbnail as only image').' <br />';
		}

		echo '<INPUT TYPE=CHECKBOX NAME="wordbook_use_excerpt" '.$checked_flag[$wordbooker_settings["wordbook_use_excerpt"]].' > Use Wordpress Excerpt for Wall Post <br />';
		echo 'Facebook Post Attribute line: <INPUT NAME="wordbook_attribute" size=60 maxlength=240 value="'.htmlspecialchars(stripslashes($wordbooker_settings["wordbook_attribute"])).'"><br />';	
		echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_status_update" '.$checked_flag[$wordbooker_settings["wordbooker_status_update"]].' > '.__('Facebook Status Update text').' : <INPUT NAME="wordbooker_status_update_text" size=60 maxlength=60 value="'.htmlspecialchars(stripslashes($wordbooker_settings["wordbooker_status_update_text"])).'"><br />';
		echo '<INPUT TYPE=CHECKBOX NAME="wordbook_comment_get" '.$checked_flag[$wordbooker_settings["wordbook_comment_get"]].' > '.__('Fetch comments from Facebook for this post').'<br />';
} else {
echo "Wordbooker Blog level settings are in force<br>";

if ( isset($wordbooker_settings['wordbook_allow_publish_select'])) { 
echo '<input type="hidden" name="crabstick" value="stairwell" />';
echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_publish_default" '.$checked_flag[$wordbooker_settings["wordbooker_publish_default"]].' > '.__('Publish Post to Facebook').'<br />';
echo '<INPUT TYPE=CHECKBOX NAME="wordbooker_publish_override" '.$checked_flag[$wordbooker_settings["wordbooker_publish_override"]].' >'.__('Force Re-Publish Post to Facebook on Edit (overrides republish window)').'<br />';
}
}

}
if (WORDBOOKER_WP_VERSION > 27) {
add_action('admin_init', 'wordbooker_option_init' );
}
add_action('admin_menu', 'wordbooker_admin_menu');
?>
