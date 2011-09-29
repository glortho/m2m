<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Turn building by category on
	if(architect_save_option('architect_home_bycat')) $updateOption = true;
	// Number of categories
	if(architect_save_option('architect_home_categories_total')) $updateOption = true;
	// Homepage categories
	$total = get_option('architect_home_categories_total');
	if($total && $total > 0)
	{
		for($i = 1; $i <= $total; $i++)
		{
			if(architect_save_option('architect_home_category_'.$i)) $updateOption = true;
			if(architect_save_option('architect_home_category_'.$i.'_total')) $updateOption = true;
		}
	}
}

if(isset($updateOption) AND $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-homebycat" enctype="multipart/form-data">';

	echo architect_admin_header('2', 'Wapple Architect Home Page Build by Category Settings');
} else
{
	echo '<h3>Home Page Build by Category Settings</h3>';
}

echo architect_table_start();

// Build by category - on or off
echo architect_admin_option('select', array('label' => 'Build by category', 'name' => 'architect_home_bycat', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_home_bycat'), 'description' => 'Build the homepage by categories'));

// Number of categories
echo architect_admin_option('input', array('size' => 4, 'label' => '# of Categories', 'name' => 'architect_home_categories_total', 'value' => get_option('architect_home_categories_total'), 'description' => 'How many categories to show on the home page'));

$total = get_option('architect_home_categories_total');

if($total && $total > 0)
{
	$cats = get_categories(array('echo' => 0));
	$values = array();
	foreach($cats as $val)
	{
		$values[$val->cat_ID] = $val->cat_name;
	}
	for($i = 1; $i <= $total;$i++)
	{
		// Categories on home page
		echo architect_admin_option('select', array('label' => 'Category #'.$i, 'name' => 'architect_home_category_'.$i, 'options' => $values, 'value' => get_option('architect_home_category_'.$i), 'description' => 'Category #'.$i.' on the home page'));
		
		// Posts in this category
		echo architect_admin_option('input', array('size' => 4, 'label' => '# Posts in Category #'.$i, 'name' => 'architect_home_category_'.$i.'_total', 'value' => get_option('architect_home_category_'.$i.'_total'), 'description' => 'How many posts to show in category #'.$i));
	}
}
echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}

?>