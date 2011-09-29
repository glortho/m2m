<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Save META tags
	if(architect_save_option('architect_use_meta')) $updateOption = true;
	// Save META keywords
	if(architect_save_option('architect_meta_keywords', array('stripTags' => true))) $updateOption = true;
	// Save page items in menu
	if(isset($_POST['architect_showmenuitems']))
	{
		foreach($_POST['architect_showmenuitems'] as $key => $val)
		{
			$_POST['architect_showmenuitems'][$key] = $val;
		}
		
		$saveVal = implode('|', $_POST['architect_showmenuitems']);
		if($saveVal != get_option('architect_showmenuitems'))
		{
			update_option('architect_showmenuitems', $saveVal);
			$updateOption = true;
		}
	}
	// Save try and do forms
	if(architect_save_option('architect_doform')) $updateOption = true;
	// Redirection
	if(architect_save_option('architect_redirect')) $updateOption = true;
	if(architect_save_option('architect_redirect_url')) $updateOption = true;
	// Layout mode
	if(architect_save_option('architect_layout_mode')) $updateOption = true;
	// Access keys
	if(architect_save_option('architect_accesskeys')) $updateOption = true;
	// Save switch to desktop
	if(architect_save_option('architect_showswitchtodesktop')) $updateOption = true;
	// 404 page text
	if(architect_save_option('architect_advanced_404text', array('stripTags' => true))) $updateOption = true;
}

if(isset($updateOption) AND $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-advanced" enctype="multipart/form-data">';
	echo architect_admin_header('2', 'Wapple Architect Advanced Settings');
} else
{	
	echo '<h3>Advanced Settings</h3>';
}
echo architect_table_start();

// Use meta tags in header
echo architect_admin_option('select', array('label' => 'Use META tags', 'name' => 'architect_use_meta', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_use_meta'), 'description' => 'Use META tags to improve SEO'));

// META keywords
echo architect_admin_option('input', array('label' => 'Mobile META Keywords', 'name' => 'architect_meta_keywords', 'value' => get_option('architect_meta_keywords'), 'description' => 'Enter your mobile META Keywords for improved SEO - separated by commas'));

// Configure menus
$pages = array(0 => 'Home');
foreach(get_pages() as $key => $page)
{
	$pages[$page->ID] = $page->post_title;
}

echo architect_admin_option('select', array('label' => 'Configure pages on menu (hold Ctrl for multiple values)', 'name' => 'architect_showmenuitems[]', 'options' => $pages, 'value' => get_option('architect_showmenuitems'), 'description' => 'Select which pages to show on the menu', 'multiple' => true));

// Try and process forms
echo architect_admin_option('select', array('label' => 'Process Forms', 'name' => 'architect_doform', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_doform'), 'description' => 'Try and build forms to be compatible with mobile (Beta)'));

// Turn on access keys
echo architect_admin_option('select', array('label' => 'Access Keys', 'name' => 'architect_accesskeys', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_accesskeys'), 'description' => 'Show mobile friendly access keys'));

// Show switch to desktop option
echo architect_admin_option('select', array('label' => 'Show switch to desktop', 'name' => 'architect_showswitchtodesktop', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_showswitchtodesktop'), 'description' => 'Show a \'switch to desktop\' link at the bottom'));

// Layout mode
echo architect_admin_option('select', array('label' => 'Layout Mode', 'name' => 'architect_layout_mode', 'options' => array('table' => 'Table', 'div' => 'Div'), 'value' => get_option('architect_layout_mode'), 'description' => 'Construct your mobile site with tables or divs'));

// Turn redirection on
echo architect_admin_option('select', array('label' => 'Mobile Redirect', 'name' => 'architect_redirect', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_redirect'), 'description' => 'Redirect mobile visitors to another URL if you have a separate mobile domain. <br /><strong>Please note that this plugin caters for your mobile visitors and you do not need to set this for most cases!</strong>'));

// Redirect to another URL if a mobile
echo architect_admin_option('input', array('label' => 'Redirect URL', 'name' => 'architect_redirect_url', 'value' => get_option('architect_redirect_url'), 'description' => 'Redirection URL (Include http://)')); 

// 404 text
echo architect_admin_option('input', array('size' => 30, 'label' => '404 text', 'name' => 'architect_advanced_404text', 'value' => stripslashes(htmlspecialchars(get_option('architect_advanced_404text'))), 'description' => 'Change default text on 404 page'));

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}

?>