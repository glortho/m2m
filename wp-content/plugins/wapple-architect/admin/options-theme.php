<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Save Mobile Theme
	if(architect_save_option('architect_theme')) $updateOption = true;
	
	// Save Mobile stylesheet
	$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css';
	
	if($blogid =get_option('blog_id'))
	{
		$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'style.css';
		architect_check_path(WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR);
	}
	architect_check_path(WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR);
	
	if(is_readable($file))
	{
		$stylesheet = file_get_contents($file);
	} else
	{
		$stylesheet = '';
	}
	
	if(!file_exists($file))
	{
		// Create file if it doesn't exist
		@file_put_contents($file, "");
	}
	
	if(is_writable($file))
	{
		if(stripslashes($_POST['architect_stylesheet']) != $stylesheet)
		{
			if(file_put_contents($file, stripslashes($_POST['architect_stylesheet'])))
			{
				$updateOption = true;
			}
		}
	} else
	{
		echo '<div class="updated architectInitError"><p>"'.$file.'" is not writable - change the permissions to save the stylesheet!</p></div>';
	}
	
	// Save custom stylesheet
	$custom_file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'custom_style.css';
	
	if($blogid =get_option('blog_id'))
	{
		$custom_file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'custom_style.css';
	}
	
	if(is_readable($custom_file))
	{
		$custom_stylesheet = file_get_contents($custom_file);
	} else
	{
		$custom_stylesheet = '';
	}
	
	if(!file_exists($custom_file))
	{
		// Create file if it doesn't exist
		@file_put_contents($custom_file, "");
	}
	
	if(is_writable($custom_file))
	{
		if(stripslashes($_POST['architect_custom_stylesheet']) != $custom_stylesheet)
		{
			if(file_put_contents($custom_file, stripslashes($_POST['architect_custom_stylesheet'])))
			{
				$updateOption = true;
			}
		}
	} else
	{
		echo '<div class="updated architectInitError"><p>"'.$custom_file.'" is not writable - change the permissions to save the stylesheet!</p></div>';
	}
}

if(isset($updateOption) AND $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-theme" enctype="multipart/form-data">';

	echo architect_admin_header('2', 'Wapple Architect Mobile Theme Settings');
} else
{
	echo '<h3>Mobile Theme Settings</h3>';
}

echo architect_table_start();

// Pre-designed themes
$allthemeoptions = array(
	'custom' => 'Custom',
	'iphoneLight' => 'iPhone Light',
	'iphoneDark' => 'iPhone Dark',
	'fire' => 'Coal & Fire',
	//'tree' => 'Lonely Tree', 
	'sky' => 'Sky',
	'wood' => 'Wooden',
	'alum' => 'Brushed Metal',
	'dark' => 'Obsidian',
	'paper' => 'Scrap Book'
);

if(!$themeoption = get_option('architect_theme'))
{
	$themeoption = 'custom';
}

echo architect_admin_option('select', array('label' => 'Mobile Theme', 'name' => 'architect_theme', 'options' => $allthemeoptions, 'value' => $themeoption, 'description' => 'Use a mobile theme or customize it to to look like your web theme'));

echo '<tr><td colspan="2"';
if($themeoption != 'custom')
{
	echo ' style="display:none;"';
	$hidden = true;
} else
{
	$hidden = false;
}
echo '>';

if($themeoption == 'custom')
{
	echo '<p>If you\'d like to use one of our pre-built themes, try changing the "Mobile Theme" option above. A preview of some of our themes can be found below.</p>';

	unset($allthemeoptions['custom']);
	$allthemeoptionsflip = array_flip($allthemeoptions);
		
	echo '<div class="clearfix">';
	foreach(array_rand($allthemeoptions, 6) as $val)
	{
		echo '<img class="themepreview" src="'.ARCHITECT_URL.'theme/images/'.strtolower($allthemeoptionsflip[$allthemeoptions[$val]]).'-preview.png" alt="'.$allthemeoptions[$val].'" title="'.$allthemeoptions[$val].'" />';
	}
	echo '</div><br style="clear:both;" />';
}
echo '<h3>Custom Stylesheets</h3>';
echo '<p>Changing styles allows you to have greater control over how your Web Site looks on a mobile.</p>';
echo '<p>The Wapple Architect Mobile Plugin has 2 mobile stylesheets for you to change, the first one resets some defaults that may have been set by your web theme, the second is for you to change as much as you want to achieve a great looking mobile site. There are some placeholder styles to help get you started!</p>';
echo '<p>For more information about styles in general plus a sandbox area to test, check out <a target="_blank" href="http://www.w3schools.com/css/">w3schools.com</a> and for a more detailed breakdown of what styles are generally available on mobile, head over to <a href="http://www.w3.org/TR/css-mobile/" target="_blank">w3.org</a></p>';
echo '<p>In addition, if you need a tool to test what your application might look like inside a browser, you might find this useful: <a target="_blank" href="http://iphonetester.com/">http://iphonetester.com/</a>.</p></td></tr>';

// Mobile stylesheet
if($blogid =get_option('blog_id') AND file_exists(WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'style.css'))
{
	$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'style.css';
} else if(file_exists(WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css'))
{
	$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css';
} else
{
	$file = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'style.css';
}


echo architect_admin_option('textarea', array('label' => 'Mobile Stylesheet', 'name' => 'architect_stylesheet', 'value' => file_get_contents($file), 'hidden' => $hidden));

// Custom stylesheet
if($blogid =get_option('blog_id') AND file_exists(WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'custom_style.css'))
{
	$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'blogs.dir'.DIRECTORY_SEPARATOR.$blogid.DIRECTORY_SEPARATOR.'custom_style.css';
} else if(file_exists(WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'custom_style.css'))
{
	$file = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'custom_style.css';
} else
{
	$file = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'custom_style.css';
}

echo architect_admin_option('textarea', array('label' => 'Custom Mobile Stylesheet', 'name' => 'architect_custom_stylesheet', 'value' => file_get_contents($file), 'hidden' => $hidden));

if($themeoption != 'custom')
{
	echo '<tr><td colspan="2">
    <img class="themepreview2" src="'.ARCHITECT_URL.'theme/images/'.strtolower($themeoption).'-large-preview.jpg" alt="'.$allthemeoptions[$themeoption].'" title="'.$allthemeoptions[$themeoption].'" />
	
	<p>The built-in themes allow you to style your site quickly. If you want to customize your theme to match your web theme, select "Custom" from "Mobile Theme", save your changes and 2 mobile stylesheets will appear for you to edit.</p>
	<p>The link to the CSS for the "'.$allthemeoptions[$themeoption].'" theme is below. If you want to use it as a base and customize further, click the link, then copy the contents of the CSS, select "Custom" from "Mobile Theme" and paste it into the "Custom Mobile Stylesheet" option (make sure you overwrite everything). Also - change your layout mode to "div" in the Advanced settings area. After that it\'s up to you - you can change pretty much anything!</p> 
	<p><a target="_blank" href="'.WP_PLUGIN_URL.'/'.get_wapl_plugin_base().'/theme/color.php">CSS for "'.$allthemeoptions[$themeoption].'" theme</a></p>
	</td></tr>';
}

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}

?>