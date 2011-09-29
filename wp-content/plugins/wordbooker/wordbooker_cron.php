<?php

/**
Extension Name: Wordbooker Cron
Extension URI: http://blogs.canalplan.org.uk/steve
Version: 1.9.4
Description: Collection of processes that are often handled by wp_cron scheduled jobs
Author: Steve Atty
*/

function wordbooker_cache_refresh ($user_id,$fbclient) {
	global $blog_id,$wpdb,$table_prefix;
	wordbooker_debugger("Cache Refresh Commence ",$user_id,0) ; 
	$result = $wpdb->get_row("select facebook_id from ".WORDBOOKER_USERDATA." where user_ID=".$user_id);
	$uid=$result->facebook_id;
	$user_info = get_userdata($user_id);
	$wordbooker_settings =get_option('wordbooker_settings'); 
	wordbooker_debugger("Cache Refresh for ",$user_info->user_login,0) ;
	wordbooker_debugger("Using APP ID : ",WORDBOOKER_FB_ID,0) ;  
	# If we've not got the ID from the table lets try to get it from the logged in user
	if (strlen($uid)==0) {
		wordbooker_debugger("No Cache record for user - getting Logged in user ",$uid,0) ; 
		try {
			$uid=$fbclient->users_getLoggedInUser();
		}
		catch (Exception $e) {
			$error_code = $e->getCode();
			$error_msg = $e->getMessage();
			wordbooker_debugger("Logged in user ".$error_msg," ",0) ;
			unset($uid);
		}
	}
	usleep(200000);
	# If we now have a uid lets go and do a few things.
	if (strlen($uid)>0){
		wordbooker_debugger("Cache processing for user : ",$user_info->user_login,0) ;
		wordbooker_debugger("Getting Permisions for : ",$user_info->user_login,0) ;
		$permlist= array(WORDBOOKER_FB_PUBLISH_STREAM,WORDBOOKER_FB_STATUS_UPDATE,WORDBOOKER_FB_READ_STREAM,WORDBOOKER_FB_CREATE_NOTE);
		foreach($permlist as $perm){
		try {
			$permy = $fbclient->users_hasAppPermission($perm);
			$error_code = null;
			if($permy==0) {
				$add_auths=1;
				wordbooker_debugger("User is missing permssion : ".$perm," ",0) ;
			} 
			else {
				wordbooker_debugger("User has permssion : ".$perm," ",0) ;
			}
			$error_msg = null;
		} catch (Exception $e) {
			$error_msg = $e->getMessage();
			wordbooker_debugger("Permissions may be corrupted  ".$error_msg ," ",0);
			$users = null;
			$add_auths=1;
		}
		}
		# Check that the user has permission to publish to all their fan pages. All we need to know is if one or more is missing permissions - FB will do the rest for us
	#	$query = "SELECT page_id FROM page_admin WHERE uid=$uid and page_id in (select page_id from page_fan where uid=$uid)";

	#	echo $query."<br>";
	#	$result1 = $fbclient->fql_query($query);
	#	var_dump($result1);

		#$query="SELECT page_id FROM page_admin WHERE uid=$uid and ) page_id in (select page_id from page_fan where uid=$uid ) or page_id IN (SELECT page_id FROM page_admin WHERE uid=$uid))";
		#echo $query;

		usleep(200000);
		$query = "SELECT page_id FROM page_admin WHERE uid = $uid";
		try {
			$result2 = $fbclient->fql_query($query);
		}
		catch (Exception $e) {
			$error_msg = $e->getMessage();
			wordbooker_debugger("Failed to get page ids  : ".$error_msg," ",0);
		return;

	}

	$result=$result2;

		$add_auths=0;
		if (is_array($result)){
			foreach ($result as $page) {
				wordbooker_debugger("Checking permissions for page  : ",$page['page_id'],0) ;
				try {
					$permy = $fbclient->users_hasAppPermission("publish_stream",$page['page_id']);
					$error_code = null;
					if($permy==0) {$add_auths=1;wordbooker_debugger("Page needs publish stream permission for : ",$page['page_id'],0) ;} 
					else { wordbooker_debugger("No permissions needed for page : ",$page['page_id'],0);}
					
					$error_msg = null;
				} catch (Exception $e) {
					wordbooker_debugger("Permission Exception for page ".$page['page_id'],$e->getMessage(),0);
					$users = null;
					$add_auths=1;
				}
			}
		}
		
		# Now lets check over the over permissions and build up the bit mask
		$perms_to_check= array(WORDBOOKER_FB_PUBLISH_STREAM,WORDBOOKER_FB_STATUS_UPDATE,WORDBOOKER_FB_READ_STREAM,WORDBOOKER_FB_CREATE_NOTE);
		foreach(array_keys($perms_to_check) as $key){
	 		if (! $fbclient->users_hasAppPermission($perms_to_check[$key],$uid)) { wordbooker_debugger("Additional Permissions needed : ",$key,0) ; $add_auths = $add_auths | pow(2,$key);}
		}
		# And update the table. We do this here just in case the FQL_Multi fails.
		wordbooker_debugger("Additional Permissions needed : ",$add_auths,0) ;
		$sql="update ".WORDBOOKER_USERDATA." set auths_needed=".$add_auths." where user_ID=".$user_id;
		$result = $wpdb->get_results($sql);

		# Lets get the person/page this user wants to get the status for. We get this from the user_meta
		$wordbook_user_settings_id="wordbookuser".$blog_id;
		$wordbookuser=get_usermeta($user_id,$wordbook_user_settings_id);
		$suid=$uid;
		usleep(200000);
		if (isset($wordbookuser['wordbook_status_id'])  && $wordbookuser['wordbook_status_id']!=-100) {$suid=$wordbookuser['wordbook_status_id'];}
		wordbooker_debugger("Getting Status for : ",$suid,0) ;

		try {
			$query="SELECT uid,time,message FROM status WHERE uid= $suid limit 1";
			$fb_status_info = $fbclient->fql_query($query);
		}
		catch (Exception $e) {
			$error_msg = $e->getMessage();
			wordbooker_debugger("Cache: Failed to get Status  : ".$error_msg," ",99);
		}
		$fb_status_info=$fb_status_info[0];
		usleep(200000);
		try {
			$query="SELECT name, url, pic FROM profile WHERE id=$suid ";
			$fb_profile_info = $fbclient->fql_query($query);
		
		} 
		catch (Exception $e) {
			$error_msg = $e->getMessage();
			wordbooker_debugger("Cache: Failed to get user info : ".$error_msg," ",99);
		}
		$fb_profile_info=$fb_profile_info[0];
		usleep(200000);
		try {
			$query="SELECT name,page_id FROM page WHERE page_id IN (SELECT page_id FROM page_admin WHERE uid= $uid )";
			$fb_page_info = $fbclient->fql_query($query);
		} 
		catch (Exception $e) 
		{
			$error_msg = $e->getMessage();
			wordbooker_debugger("Cache: Failed to get page info : ".$error_msg," ",99);
		}
		usleep(200000);
		try {
			$query="Select is_app_user FROM user where uid=$uid";
			$fb_app_info = $fbclient->fql_query($query);
		} 
		catch (Exception $e) 
		{
			$error_msg = $e->getMessage();
			wordbooker_debugger("Cache: Failed to get app_user inf : ".$error_msg," ",99);
		}
		$fb_app_info=$fb_app_info[0];
		usleep(200000);
		$sql="update ".WORDBOOKER_USERDATA." set name='".mysql_real_escape_string($fb_profile_info["name"])."'";$all_pages=array();
		#var_dump($fb_page_info);
			if (is_array($fb_page_info)) { 
				if (is_array($fb_page_info)) { $encoded_names=str_replace('\\','\\\\',serialize($fb_page_info));}
					$mbc=false;
					if (function_exists('mb_convert_encoding')) { $mbc=true;}
					 foreach ( $fb_page_info as $pageinfo ) {	
					$pages["page_id"]=$pageinfo["page_id"];
					if ($mbc) {
						$pages["name"]=mb_convert_encoding($pageinfo["name"],'UTF-8');
					}
					else
					{
						$pages["name"]=$pageinfo["name"];
					}
					$all_pages[]=$pages;
				 	wordbooker_debugger("Page info for page ID ".$pages["page_id"],$pages["name"],0) ;
					}
				$sql.=", pages= '".mysql_real_escape_string($encoded_names)."'";
			} else {wordbooker_debugger( "Cache: Failed to get page information from FB"," ",99); }
			

			if (is_array($fb_status_info)) {
					wordbooker_debugger("Setting name as  : ",$fb_profile_info["name"],0) ;
				if (stristr($fb_status_info["message"],"[[PV]]")) {
					wordbooker_debugger("Found [[PV]] - not updating status"," ",0);
				} 
				else {
					wordbooker_debugger("Setting status as  : ",$fb_status_info["message"],0) ;
					$sql.=", status='".mysql_real_escape_string($fb_status_info["message"])."'";
					$sql.=", updated= Coalesce(".mysql_real_escape_string($fb_status_info["time"].",1)");
				}
			} 
			if (is_array($fb_profile_info)) {
				wordbooker_debugger("Setting URL as  : ",$fb_profile_info["url"],0) ;
				$sql.=", url='".mysql_real_escape_string($fb_profile_info["url"])."'";
				$sql.=", pic='".mysql_real_escape_string($fb_profile_info["pic"])."'";
			}	else {wordbooker_debugger("Cache: Failed to get Image information from FB"," ",99); }
			$sql.=", facebook_id='".$uid."'";
			
			if (is_array($fb_app_info)) {
				$sql.=", use_facebook=".$fb_app_info["is_app_user"];
			}
			$sql.="  where user_ID=".$user_id;
			$result = $wpdb->get_results($sql);
	}
	wordbooker_debugger("Cache Refresh Complete for user",$uid,0) ; 
}

function wordbooker_poll_facebook($single_user=null) {
	global  $wpdb, $user_id,$table_prefix;
	# If a user ID has been passed in then restrict to that single user.
	$limit_user="";
	if (isset($single_user)) {$limit_user=" where user_id=".$single_user." limit 1";}
	wordbooker_trim_errorlogs();
	$wordbooker_settings =get_option('wordbooker_settings'); 
	# This runs through the Cached users and refreshes them
      	$sql="Select user_id from ".WORDBOOKER_USERDATA.$limit_user;
        $wb_users = $wpdb->get_results($sql);
	if (is_array($wb_users)) {
		wordbooker_debugger("Batch Cache Refresh Commence "," ",0) ; 
		foreach ($wb_users as $wb_user){	
			wordbooker_debugger("Calling Cache refresh for  :  ",$wb_user->user_id,0) ;	
			$wbuser = wordbooker_get_userdata($wb_user->user_id);
			$fbclient = wordbooker_fbclient($wbuser);
			wordbooker_cache_refresh($wb_user->user_id,$fbclient);
			usleep(200000);
		}
		wordbooker_debugger("Batch Cache Refresh completed "," ",0) ; 
	}

	if ( !isset($wordbooker_settings['wordbook_comment_get'])) {
			wordbooker_debugger("Comment Scrape not active. Cron Finished "," ",0) ; 
		return;
	}

	// Yes they have so lets get to work. We have to get the FB users associated with this blog
        $sql="Select user_id from ".WORDBOOKER_USERDATA.$limit_user;
        $wb_users = $wpdb->get_results($sql);
	if (!is_array($wb_users)) {
		return;
	}
	foreach ($wb_users as $wb_user){
		wordbooker_debugger("Processing comment data for user ",$wb_user->user_id,0) ;	
		$wbuser = wordbooker_get_userdata($wb_user->user_id);
		$fbuserid=wordbooker_get_cache($wb_user->user_id,'facebook_id'); 
		// Now we need to check if they've set Auto Approve on comments.
		$comment_approve=0;
		if (isset($wordbooker_settings['wordbook_comment_approve'])) {$comment_approve=1;}
		wordbooker_debugger("Checking to see if we have any posts to check for comment ",' ',0) ;
		// Go the postcomments table - this contains a list of FB post_ids, the wp post_id that corresponds to it and the timestamps of the last FB comment pulled.
		$sql='Select fb_post_id,comment_timestamp,wp_post_id from ' . WORDBOOKER_POSTCOMMENTS . ' where fb_post_id like "'.$fbuserid->facebook_id.'%" order by fb_post_id desc ';	
		$rows = $wpdb->get_results($sql);

		wordbooker_debugger("Number of posts to check for comments : ",count($rows),0) ;
		// For each FB post ID we find we go out to the stream on Facebook and grab the comments.
		if (count($rows)>0) {		
			$fbclient = wordbooker_fbclient($wbuser);
			foreach ($rows as $comdata_row) {
				$fbsql='select time,text,fromid,xid from comment where time >'.$comdata_row->comment_timestamp." and post_id='".$comdata_row->fb_post_id."'";
				try {
					$fbcomments=$fbclient->fql_query($fbsql);
				}
				catch (Exception $e) 
				{
					$error_msg = $e->getMessage();
					wordbooker_debugger("Comment fetch from Facebook Failed : ".$error_msg," ",99);
				}
				if (is_array($fbcomments)) {
					wordbooker_debugger("Incoming Comment count for Post ".$comdata_row->fb_post_id,count($fbcomments),0) ;	
					foreach ($fbcomments as $comment) {
						// If the comment has a later timestamp than the one we currently have recorded then lets get some more information 
						if ($comment[time]>$comdata_row->comment_timestamp) {
							$fbuserinfo=$fbclient->users_getInfo($comment['fromid'],'name,profile_url');
							if (is_array($fbuserinfo[0])) {
							wordbooker_debugger("Comment found from ",$fbuserinfo[0]['name'],0) ;	
							$commemail=$wordbooker_settings['wordbooker_comment_email'];
							$time = date("Y-m-d H:i:s",$comment[time]);
							$current_offset = get_option('gmt_offset');
							$atime = date("Y-m-d H:i:s",$comment[time]+(3600*$current_offset));
							$data = array(
								'comment_post_ID' => $comdata_row->wp_post_id,
								'comment_author' => $fbuserinfo[0]['name'],
								'comment_author_email' => $commemail,
								'comment_author_url' => $fbuserinfo[0]['profile_url'],
								'comment_content' => $comment['text'],
								'comment_author_IP' => '127.0.0.1',
								'comment_date' => $atime,
								'comment_date_gmt' => $time,
								'comment_parent'=> 0,
								'user_id' => 0,
							   	'comment_agent' => 'Wordbooker plugin '.WORDBOOKER_CODE_RELEASE,
								'comment_approved' => $comment_approve,
							);
							// change this to use wp_new_comment /includes/comment.php for docs
							$pos = strripos($comment[text], "Comment: [");
							if ($pos === false) {
								$comname=$fbuserinfo[0][name];
								$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comdata_row->wp_post_id' AND comment_approved != 'trash' AND ( comment_author = '$comname' ";
								if ( $commemail )
									$dupe .= "OR comment_author_email = '$commemail' ";
								$dupe .= ") AND comment_content = '$comment[text]' LIMIT 1";
								#var_dump($dupe);
								if ( $wpdb->get_var($dupe) ) {
									wordbooker_debugger("Looks like a duplicate comment so discarding it"," ",0) ;
								} else {
									wordbooker_debugger("Posting comment to blog"," ",0) ;
									if ($comment_approve==1){
										 $newComment = wp_insert_comment($data);
									} else {
										 $newComment = wp_new_comment($data);
									}
									//Allows integration with WP-FB-AutoConnect to get correct avatars.
									update_comment_meta($newComment, "fb_uid", $comment['fromid']);
								}
							}
						}
						$sql='update '. WORDBOOKER_POSTCOMMENTS .' set comment_timestamp='.$comment['time'].' where fb_post_id="'.$comdata_row->fb_post_id.'" and wp_post_id='.$comdata_row->wp_post_id;
						$result = $wpdb->query($sql);
						} // end of new comment process	
					sleep(1);
					} // End of Foreach process
				}  // End of is_array check
				else {
					wordbooker_debugger("No Incoming Comments for Post : ",$comdata_row->fb_post_id,0) ;	
				}
			} // End of Foreach 
		} // End of if count
		sleep(1);
	} // end of foreach user
}
?>
