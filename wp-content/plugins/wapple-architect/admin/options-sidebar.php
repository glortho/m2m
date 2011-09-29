<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Save show sidebar on home page
	if(architect_save_option('architect_sidebar_home')) $updateOption = true;
	// Save show sidebar on other pages
	if(architect_save_option('architect_sidebar_other')) $updateOption = true;
    // Save sidebar items
    if(isset($_POST['architect_sidebar_items']))
    {
        foreach($_POST['architect_sidebar_items'] as $key => $val)
        {
            $_POST['architect_sidebar_items'][$key] = $val;
        }
        
        $saveVal = implode('|', $_POST['architect_sidebar_items']);
        if($saveVal != get_option('architect_sidebar_items'))
        {
            update_option('architect_sidebar_items', $saveVal);
            $updateOption = true;
        }
    }
    // Save sidebar header
    if(architect_save_option('architect_sidebar_header')) $updateOption = true;
}

if($updateOption)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-sidebar" enctype="multipart/form-data">';

	echo architect_admin_header('2', 'Wapple Architect Sidebar Settings');
} else
{
	echo '<h3>Sidebar Settings</h3>';
}	

echo architect_table_start();

// Show the sidebar at the bottom of home page
echo architect_admin_option('select', array('label' => 'Show sidebar on home page', 'name' => 'architect_sidebar_home', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_sidebar_home'), 'description' => 'Show the sidebar on the home page'));
// Show the sidebar at the bottom of any other pages
echo architect_admin_option('select', array('label' => 'Show sidebar on any other page', 'name' => 'architect_sidebar_other', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_sidebar_other'), 'description' => 'Show the sidebar on any other pages'));

global $wp_registered_widgets;
// These are the widgets grouped by sidebar
$sidebars_widgets = wp_get_sidebars_widgets();
if(empty( $sidebars_widgets ))
    $sidebars_widgets = wp_get_widget_defaults();
    
$controllableWidgets = array();
foreach($sidebars_widgets as $key => $val)
{
	if(strpos($key,'sidebar-') !== false)
	{
		if(is_array($val) AND !empty($val))
		{
			foreach($val as $widgetVal)
			{
				if(isset($wp_registered_widgets[$widgetVal]))
				{
					$title = $wp_registered_widgets[$widgetVal]['name'];
				} else
				{
				    $title = ucwords(str_replace('-', ' ', $widgetVal));
				}
				$controllableWidgets[$widgetVal] = $title;
			}
		}
	}
}   
echo architect_admin_option('select', array('label' => 'Which widgets to display', 'name' => 'architect_sidebar_items[]', 'options' => $controllableWidgets, 'value' => get_option('architect_sidebar_items'), 'description' => 'Define which widgets appear in your mobile sidebar', 'multiple' => true));

// Sidebar header
echo architect_admin_option('input', array('label' => 'Sidebar header', 'name' => 'architect_sidebar_header', 'value' => stripslashes(htmlspecialchars(get_option('architect_sidebar_header'))), 'description' => 'Header to display at the top of your mobile sidebar'));

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}
?>