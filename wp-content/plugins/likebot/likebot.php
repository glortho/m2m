<?php
/**
 * @package LikeBot
 * @author Tommie Podzemski
 * @version 0.85
 */
/*
Plugin Name: LikeBot - Decentralized like-system
Plugin URI: http://likebot.com/wordpress
Description: Add a like/dislike feature similar Facebook right on your blog!
Author: Tommie Podzemski
Version: 0.85
Author URI: http://tommie.nu
*/

function LIKEBOT_BUTTON( $args = false ) {
	echo likebot_do_button('');
}

function likebot_do_button($out = '') {
	global $post;
		
	//get our options
	$dbLikebotOptions = unserialize(get_option('likebot_options'));
	
	//override values (and set this if none)
	if (!$dbLikebotOptions['backgroundcolor']) {
		$dbLikebotOptions['backgroundcolor'] = '';
	}
	
	if (!$dbLikebotOptions['alignment']) {
		$dbLikebotOptions['alignment'] = 'right';
	}
	
	if (!$dbLikebotOptions['design']) {
		$dbLikebotOptions['design'] = 'horizontal_thumbs';
	}
	
	if (!$dbLikebotOptions['position']) {
		$dbLikebotOptions['position'] = 'automagically';
	}
	
	if (!strpos($out, '<!--nolikebot-->')) {
		
		//check for manual and automagically
		if ($dbLikebotOptions['position'] == 'manually') {
			//it's manual, return unformatted
		return '
				<a class="LikeBotButton" />
					<script type="text/javascript">
						likebot_bgcolor = \'' . $dbLikebotOptions['backgroundcolor'] . '\';
						likebot_url = \'' . $post->guid  . '\';
						likebot_type = \'' . $dbLikebotOptions['design'] . '\';
					</script>
					<script src="http://i.likebot.com/button.js" type="text/javascript"></script>
				</a>
			';
			
		} else {
			//return formatted since it automatically inserted
			return $out . '<div style="float:' . $dbLikebotOptions['alignment'] . '; margin-left:10px;">	
			<a class="LikeBotButton" />
				<script type="text/javascript">
					likebot_bgcolor = \'' . $dbLikebotOptions['backgroundcolor'] . '\';
					likebot_url = \'' . $post->guid  . '\';
					likebot_type = \'' . $dbLikebotOptions['design'] . '\';
				</script>
				<script src="http://i.likebot.com/button.js" type="text/javascript"></script>
			</a>
			
			</div>';
		}
		
	} else {
		//return original post
		return $out;
	}
}

//grab our options
$dbLikebotOptions = unserialize(get_option('likebot_options'));


if (!$dbLikebotOptions['position'] OR $dbLikebotOptions['position'] == 'automagically') {
	//below content hook
	add_action( 'the_content', 'likebot_do_button', 98 );
}

// options page
function likebot_options() {
	
	// if submitted, process results
	if ( $_POST["likebot_submit"] ) {
		
		$tmpOptions = array();
		
		$tmpOptions['backgroundcolor'] = stripslashes($_POST["likebot_backgroundcolor"]);
		$tmpOptions['alignment'] = stripslashes($_POST["likebot_alignment"]);
		$tmpOptions['design'] = stripslashes($_POST["likebot_design"]);
		$tmpOptions['position'] = stripslashes($_POST["likebot_position"]);

		update_option('likebot_options', serialize($tmpOptions));
	}
	
	//get our options
	$dbLikebotOptions = array();
	$dbLikebotOptions = unserialize(get_option('likebot_options'));
	
	//override values (and set this if none)
	if (!$dbLikebotOptions['backgroundcolor']) {
		$dbLikebotOptions['backgroundcolor'] = '';
	}
	
	if (!$dbLikebotOptions['alignment']) {
		$dbLikebotOptions['alignment'] = 'right';
	}
	
	if (!$dbLikebotOptions['design']) {
		$dbLikebotOptions['design'] = 'horizontal_thumbs';
	}
	
	if (!$dbLikebotOptions['position']) {
		$dbLikebotOptions['position'] = 'automagically';
	}
	
		// options form
	echo '<div><form method="post">';
	echo "<div class=\"wrap\"><h2>LikeBot - Decentralized like-system</h2>";
	echo '
				<h3 class="title">What is LikeBot, and how does it work?</h3>
				<p><a href="http://likebot.com" target="_blank">LikeBot.com</a> is a decentralized like-system with the intention to make the integration as simple as streamlined as possible for the user. No registration, no authentications - it\'s just a very simple way for your reader to let you know if they like the post/content or not.
				<br /><br />
				The LikeBot-button automatically inject itself below your content and align to the right.</p>
				<br />
				<h3 class="title">Customization</h3>				
				<table class="form-table">';
					// background
					echo '<tr valign="top"><th scope="row">Button background color:</th>';
					echo '<td><input type=text value="'.$dbLikebotOptions['backgroundcolor'].'" name="likebot_backgroundcolor">
					<p class=\'help\'>Please use hexadecimals and include the hash (#) before the color-code. Leave it blank for no color.<br /><br /><i>Current color</i>: <div style="width:50px; height:20px; background-color:'.$dbLikebotOptions['backgroundcolor'].';">&nbsp;</div></p></td></tr>';
					
					// align button
					echo '<tr valign="top"><th scope="row">Button alignment:</th>';
						echo '<td valign="top"><input type=radio value="left" name="likebot_alignment" ';
									if ($dbLikebotOptions['alignment'] == "left") {
										echo 'checked ';
									} 
					
					
					echo '>Left &nbsp; <input type=radio value="right" name="likebot_alignment" ';
									if ($dbLikebotOptions['alignment'] == "right") {
										echo 'checked ';
									} 
					echo 	' /> Right</b>
								<p class=\'help\'>Define the alignment of the button, either left or right. Notice that this option has no effect if you use manual positioning.<br /><br /><i>Current alignment</i>: '.$dbLikebotOptions['alignment'].'</small></p></td></tr>';
					
					// button position
					echo '<tr valign="top"><th scope="row">Button position:</th>';
						echo '<td valign="top"><input type=radio value="automagically" name="likebot_position" ';
									if ($dbLikebotOptions['position'] == "automagically") {
										echo 'checked ';
									} 
					
					
					echo '>Automagically add it below each post &nbsp; <input type=radio value="manually" name="likebot_position" ';
									if ($dbLikebotOptions['position'] == "manually") {
										echo 'checked ';
									} 
					echo 	' />I manually add the button-position to my theme-files</b>
								<p class=\'help\'>Choosing Automagically will insert the LikeBot-button below each post. Choosing Manually require you to add the buttons to your pages. If you\'re uncomfortable with editing Theme-files you should definitly go with the Automagically-option. <a href="http://wordpress.org/extend/plugins/likebot/faq/" target="_blank">Instructions for adding the buttons are available in the LikeBot FAQ</a>. <br /><br /><i>Current alignment</i>: '.$dbLikebotOptions['position'].'</p></td></tr>';
					
					
					// button design
					echo '<tr valign="top"><th scope="row">Button design:</th>';
					
					echo '
								<td valign="top">
									<table> 
											<tr> 
												<td style="border-bottom:1px solid gray;">
												<input type=radio value="horizontal_thumbs" name="likebot_design" ';
													if ($dbLikebotOptions['design'] == "horizontal_thumbs") {
														echo 'checked ';
													}
									
													echo '> Horizontal Thumbs (default)
												</td> 
												<td> 
														<a class="LikeBotButton" /> 
															<script type="text/javascript"> 
																likebot_bgcolor = \'\';
																likebot_type = \'horizontal_thumbs\';
															</script> 
															<script src="http://i.likebot.com/button.js" type="text/javascript"></script> 
														</a> 
												</td> 
											</tr> 
											
											<tr> 
												<td style="border-bottom:1px solid gray;">
												
												<input type=radio value="text" name="likebot_design" ';
																if ($dbLikebotOptions['design'] == "text") {
																	echo 'checked ';
																} 
												echo 	' />
												
												Text
												</td> 
												<td> 
														<a class="LikeBotButton" /> 
															<script type="text/javascript"> 
																likebot_bgcolor = \'\';
																likebot_type = \'text\';
															</script> 
															<script src="http://i.likebot.com/button.js" type="text/javascript"></script> 
														</a> 
												</td> 
											</tr> 

											<tr> 
												<td style="border-bottom:1px solid gray;">
												<input type=radio value="badge" name="likebot_design" ';
																if ($dbLikebotOptions['design'] == "badge") {
																	echo 'checked ';
																} 
												echo 	' /> Badge
												</td> 
												<td> 
														<a class="LikeBotButton" /> 
															<script type="text/javascript"> 
																likebot_bgcolor = \'\';
																likebot_type = \'badge\';
															</script> 
															<script src="http://i.likebot.com/button.js" type="text/javascript"></script> 
														</a> 
												</td> 
											</tr> 

											<tr> 
												<td style="border-bottom:1px solid gray;">
												<input type=radio value="square_thumbs" name="likebot_design" ';
																if ($dbLikebotOptions['design'] == "square_thumbs") {
																	echo 'checked ';
																} 
												echo 	' /> Square Thumbs
												</td> 
												<td> 
														<a class="LikeBotButton" /> 
															<script type="text/javascript"> 
																likebot_bgcolor = \'\';
																likebot_type = \'\';
															</script> 
															<script src="http://i.likebot.com/button.js" type="text/javascript"></script> 
														</a> 
												</td> 
											</tr> 
											
										</table> 					
							 ';
					
					
						echo '
					
								<p class=\'help\'>Select which button-design you wish to show on your blog/site.<br /><br /><i>Current alignment</i>: '.$dbLikebotOptions['design'].'</p></td></tr>';
					
					
					echo '<input type="hidden" name="likebot_submit" value="true"></input>
					</table>
					
								<p class="submit"><input type="submit" value="Update Options &raquo;"></input></p></form>
					';
				
				
				
				echo '
				<table cellspacing="10">
				<tr>
				<td style="width:50%" valign="top">
				<div>
				<h3>More information about LikeBot</h3>
				If you wish to learn a bit more about LikeBot - check out <a href="http://likebot.com" target="_blank">http://likebot.com</a><br />
				</div>
				</td>
				<td style="width:50%" valign="top">
				
				<div>
				<h3>Sponsor LikeBot.com</h3>
					If you like and wish to support our service you can either donate though paypay using the button below:
					<br /><br />
					<center> 
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
						<input type="hidden" name="cmd" value="_s-xclick"> 
						<input type="hidden" name="hosted_button_id" value="QWWKBCJR6ALLL"> 
						<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"> 
						<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"> 
						</form> 
					</center> 
					<br /> 
				</div>
				</td>
				</tr>
				</table>
			';

	echo "</div>";
	echo '</form></div>';
}

function addlikebotsubmenu() {
    add_submenu_page('plugins.php', 'LikeBot', 'LikeBot Plugin', 10, __FILE__, 'likebot_options'); 
}
add_action('admin_menu', 'addlikebotsubmenu');






?>
