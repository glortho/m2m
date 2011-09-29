<?php
/*
Plugin Name: JR qTip for Wordpress
Plugin URI: http://www.jacobras.nl/wordpress/qtip-for-wordpress/
Description: JR qTip for Wordpress is a plugin that uses qTip to display nice looking, user friendly tooltips. Colors and position are easily changeable.
Version: 1.3
Author: Jacob Ras
Author URI: http://www.jacobras.nl

	Copyright 2009  Jacob Ras  (email : info@jacobras.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

--------------------

~ Changelog:
v1.3 (September 21, 2009)
- Using array instead of vars for settings

v1.2 (September 19, 2009)
- Added positioning & color images in configuration page
- Fixed bug #001

v1.1 (September 19, 2009)
- Added admin configuration page
- Added Google API support

v1.0 (September 19, 2009)
- First final release

*/

function jr_qtip_for_wordpress() {
	
	$jr = get_option('jr_qtip_for_wordpress');
	$jr['qtip_folder'] = get_bloginfo('url') . '/wp-content/plugins/jr-qtip-for-wordpress/';
	
	if ($jr['enable_qtip'] == 'on') {
		echo '<!-- JR qTip for Wordpress -->' . "\n";
		echo '<script type="text/javascript" src="';
		
		if ($jr['enable_google_api'] == 'on') {
			echo 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js';
		} else {
			echo $jr['qtip_folder'] . 'jquery-1.3.2.min.js';
		}
		
		echo '"></script>' . "\n";
		echo '<script type="text/javascript" src="' . $jr['qtip_folder'] . 'jquery.qtip-1.0.0-rc3.min.js"></script>' . "\n";
		echo '<script type="text/javascript" src="' . $jr['qtip_folder'] . 'jr_qtip_for_wordpress_tooltip.php?color=' . $jr['tooltip_color'] . '&tooltip_target=' . $jr['tooltip_target'] . '&tooltip_position=' . $jr['tooltip_position'] . '"></script>' . "\n";
		echo '<!-- JR qTip for Wordpress -->' . "\n";
	}
}



function jr_qtip_for_wordpress_admin() { ?>
	
	<div class="wrap">
		<a href="http://www.jacobras.nl"><img src="http://www.jacobras.nl/logo-32.png" width="32" height="32" style="float:left;height:32px;margin:14px 6px 0 6px;width:32px;" alt="" /></a>
		<h2>JR qTip for Wordpress Options</h2>
		
		<?php if($_POST['jr_hidden'] == 'Y') {
			$jr['enable_qtip'] = $_POST['jr_enable_qtip'];
			$jr['enable_google_api'] = $_POST['jr_enable_google_api'];
			$jr['tooltip_color'] = $_POST['jr_tooltip_color'];
			$jr['tooltip_target'] = $_POST['jr_tooltip_target'];
			$jr['tooltip_position'] = $_POST['jr_tooltip_position'];
			update_option('jr_qtip_for_wordpress', $jr);
			?>
			<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
			<?php
		} else {
			$jr = get_option('jr_qtip_for_wordpress');
		} ?>
		
		<div class="postbox-container" style="width:70%;">
			<div class="metabox-holder">	
				<form action="" method="post">
				<input type="hidden" name="jr_hidden" value="Y" />
					<div class="postbox">
						<h3><span>Settings for JR qTip for Wordpress</span></h3>
						<div class="inside">
							<table class="form-table">
								
								<tr>
									<th valign="top">
										<label>Enable qTip for Wordpress:</label>
									</th>
									<td valign="top">
										<input type="checkbox" name="jr_enable_qtip" <?php if ($jr['enable_qtip']) { echo 'checked="checked"'; } ?> />
									</td>
								</tr>
								
								<tr>
									<th valign="top">
										<label>Tooltip color:</label>
									</th>
									<td valign="top">
										<select name="jr_tooltip_color">
											<option <?php if($jr['tooltip_color'] == 'cream') { echo 'selected="selected"'; } ?> value="cream">Cream&nbsp;&nbsp;&nbsp;</option>
											<option <?php if($jr['tooltip_color'] == 'dark') { echo 'selected="selected"'; } ?> value="dark">Dark&nbsp;&nbsp;&nbsp;</option>
											<option <?php if($jr['tooltip_color'] == 'green') { echo 'selected="selected"'; } ?> value="green">Green&nbsp;&nbsp;&nbsp;</option>
											<option <?php if($jr['tooltip_color'] == 'light') { echo 'selected="selected"'; } ?> value="light">Light&nbsp;&nbsp;&nbsp;</option>
											<option <?php if($jr['tooltip_color'] == 'red') { echo 'selected="selected"'; } ?> value="red">Red&nbsp;&nbsp;&nbsp;</option>
											<option <?php if($jr['tooltip_color'] == 'blue') { echo 'selected="selected"'; } ?> value="blue">Blue&nbsp;&nbsp;&nbsp;</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<th valign="top">
										<label>Tooltip target position:</label>
									</th>
									<td valign="top">
										<select name="jr_tooltip_target">
											<?php
											
											$aTooltipPositions = array('topLeft', 'topMiddle', 'topRight', 'rightTop', 'rightMiddle', 'rightBottom', 'bottomRight', 'bottomMiddle', 'bottomLeft', 'leftBottom', 'leftMiddle', 'leftTop');
											
											$i = 0;
											while ($i < count($aTooltipPositions)) {
												
												echo '<option ';
												if ($jr['tooltip_target'] == $aTooltipPositions[$i]) { echo 'selected="selected" '; }
												echo 'value="' . $aTooltipPositions[$i] . '">' . $aTooltipPositions[$i] . '&nbsp;&nbsp;&nbsp;</option>' . "\n";
												$i++;
											}
											
											?>
										</select>
									</td>
								</tr>
								
								<tr>
									<th valign="top">
										<label>Tooltip position:</label>
									</th>
									<td valign="top">
										<select name="jr_tooltip_position">
											<?php
											
											$aTooltipPositions = array('topLeft', 'topMiddle', 'topRight', 'rightTop', 'rightMiddle', 'rightBottom', 'bottomRight', 'bottomMiddle', 'bottomLeft', 'leftBottom', 'leftMiddle', 'leftTop');
											
											$i = 0;
											while ($i < count($aTooltipPositions)) {
												
												echo '<option ';
												if ($jr['tooltip_position'] == $aTooltipPositions[$i]) { echo 'selected="selected" '; }
												echo 'value="' . $aTooltipPositions[$i] . '">' . $aTooltipPositions[$i] . '&nbsp;&nbsp;&nbsp;</option>' . "\n";
												$i++;
											}
											
											?>
										</select>
									</td>
								</tr>
								
								<tr>
									<th valign="top">
										<label>Use Google API:</label><br />
										<small>Include jQuery code from Google servers</small>
									</th>
									<td valign="top">
										<input type="checkbox" name="jr_enable_google_api" <?php if ($jr['enable_google_api']) { echo 'checked="checked"'; } ?> />
									</td>
								</tr>
								
							</table>
							
							<div style="margin:20px 0 12px 0;padding-left:12px;"><input type="submit" class="button-primary" name="submit" value="Save settings" /></div>
						</div>
					</div>
					
					<div class="postbox">
					<h3>Tooltip color &amp; positioning preview:</h3>
					<p style="text-align:center;">
						<img src="<?php echo get_bloginfo('url') . '/wp-content/plugins/jr-qtip-for-wordpress/qtip_positioning.jpg'; ?>" />
					</p>
					
					<p style="text-align:center;">
						<img src="<?php echo get_bloginfo('url') . '/wp-content/plugins/jr-qtip-for-wordpress/qtip_colors_preview.gif'; ?>" />
					</p>
					</div>
					
				</form>
			</div>
		</div>
		
		<div class="postbox-container" style="width:20%;">
			<div class="metabox-holder">
				<div class="postbox">
					<h3><span>Need help?</span></h3>
					<div class="inside" style="padding:0 12px;">
						<p>If you have any problems with this plugin or good ideas for improvements or new features, please <a href="http://www.jacobras.nl/contact/">let me know</a>.</p>
					</div>
				</div>
				
				<div class="postbox">
					<h3><span>Like this plugin?</span></h3>
					<div class="inside" style="padding:0 12px;">
						<p>Why don't you:</p>
						
						<a href="http://www.jacobras.nl/wordpress/" style="padding:4px;display:block;padding-left:25px;background-repeat:no-repeat;background-position:2px 50%;text-decoration:none;border:none;background-image:url(http://www.jacobras.nl/logo-16.png);">Check out my other handy plugins</a>
						
						<a href="http://wordpress.org/extend/plugins/jr-qtip-for-wordpress/" style="padding:4px;display:block;padding-left:25px;background-repeat:no-repeat;background-position:2px 50%;text-decoration:none;border:none;background-image:url(http://www.jacobras.nl/logo-16.png);">Vote for the plugin on WordPress.org.</a>
						
						<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=F8RVLT4RZTVJY&lc=NL&item_name=Jacob%20Ras&item_number=JR%20qTip%20for%20Wordpress&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted"style="padding:4px;display:block;padding-left:25px;background-repeat:no-repeat;background-position:2px 50%;text-decoration:none;border:none;background-image:url(http://www.jacobras.nl/logo-16.png);">Donate a token of your appreciation.</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<?php }

function jr_qtip_for_wordpress_configpage() {
	add_options_page("JR qTip for Wordpress", "JR qTip for Wordpress", 1, "jr-qtip-for-wordpress", "jr_qtip_for_wordpress_admin");  
}


// default settings
$jr 						= array();
$jr['enable_qtip']			= 'on';
$jr['enable_google_api']	= 'on';
$jr['tooltip_color']		= 'cream';
$jr['tooltip_target']		= 'bottomMiddle';
$jr['tooltip_position']		= 'topMiddle';
add_option('jr_qtip_for_wordpress', $jr);
add_action('admin_menu', 'jr_qtip_for_wordpress_configpage');
add_action('wp_footer', 'jr_qtip_for_wordpress');
?>