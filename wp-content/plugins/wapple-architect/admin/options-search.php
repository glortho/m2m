<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Save search page show tags
	if(architect_save_option('architect_search_showtags')) $updateOption = true;
	// Save search page show categories
	if(architect_save_option('architect_search_showcategories')) $updateOption = true;
	// Search page title
	if(architect_save_option('architect_search_title', array('stripTags' => true))) $updateOption = true;
	// Link to home
	if(architect_save_option('architect_search_hometext', array('stripTags' => true))) $updateOption = true;
	// Link to older entries
	if(architect_save_option('architect_search_olderentriestext', array('stripTags' => true))) $updateOption = true;
	// Link to newer entries
	if(architect_save_option('architect_search_newerentriestext', array('stripTags' => true))) $updateOption = true;
	// "Written by" text
	if(architect_save_option('architect_search_writtenbytext', array('stripTags' => true))) $updateOption = true;
	// "Tags" text
	if(architect_save_option('architect_search_tagstext', array('stripTags' => true))) $updateOption = true;
	// "Posted in" text
	if(architect_save_option('architect_search_postedintext', array('stripTags' => true))) $updateOption = true;
	// "No posts found" text
	if(architect_save_option('architect_search_notext', array('stripTags' => true))) $updateOption = true;
	// Search box title
	if(architect_save_option('architect_search_boxtitletext', array('stripTags' => true))) $updateOption = true;
	// Search box submit value
	if(architect_save_option('architect_search_boxsubmittext', array('stripTags' => true))) $updateOption = true;
}

if($updateOption)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-search" enctype="multipart/form-data">';

	echo architect_admin_header('2', 'Wapple Architect Search Page Settings');
} else
{
	echo '<h3>Search Page Settings</h3>';
}	

echo architect_table_start();

// Show tags on search results
echo architect_admin_option('select', array('label' => 'Show tags on search results', 'name' => 'architect_search_showtags', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_search_showtags'), 'description' => 'Show tags on search results'));

// Show categories on search results
echo architect_admin_option('select', array('label' => 'Show categories on search results', 'name' => 'architect_search_showcategories', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_search_showcategories'), 'description' => 'Show categories on search results'));

echo '<tr><td colspan="2"><h3>Alternative Text Settings</h3></td></tr>';

// Title
echo architect_admin_option('input', array('size' => 20, 'label' => 'Title', 'name' => 'architect_search_title', 'value' => stripslashes(get_option('architect_search_title')), 'description' => 'Search Page Title Override'));

// Text for "home" link
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to home', 'name' => 'architect_search_hometext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_hometext'))), 'description' => 'Change the default text for link back to home'));

// Text for "Older entries"
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to older entries', 'name' => 'architect_search_olderentriestext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_olderentriestext'))), 'description' => 'Change the default text for link to older entries'));

// Text for "Newer entries"
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to newer entries', 'name' => 'architect_search_newerentriestext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_newerentriestext'))), 'description' => 'Change the default text for link to newer entries'));

// Text for "Written by"
echo architect_admin_option('input', array('size' => 20, 'label' => '"Written by" text', 'name' => 'architect_search_writtenbytext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_writtenbytext'))), 'description' => 'Change the default for "Written by" text'));

// Text for "Tags"
echo architect_admin_option('input', array('size' => 20, 'label' => '"Tags" text', 'name' => 'architect_search_tagstext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_tagstext'))), 'description' => 'Change the default for "Tags" text'));

// Text for "Posted in"
echo architect_admin_option('input', array('size' => 20, 'label' => '"Posted in" text', 'name' => 'architect_search_postedintext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_postedintext'))), 'description' => 'Change the default for "Posted in" text'));

// Text for "No posts found"
echo architect_admin_option('input', array('size' => 20, 'label' => '"No posts found" text', 'name' => 'architect_search_notext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_notext'))), 'description' => 'Change the default for "No posts found"'));

// Search box title
echo architect_admin_option('input', array('size' => 20, 'label' => 'Search box title text', 'name' => 'architect_search_boxtitletext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_boxtitletext'))), 'description' => 'Change the default for the search box title'));

// Search box submit
echo architect_admin_option('input', array('size' => 20, 'label' => 'Search box submit value text', 'name' => 'architect_search_boxsubmittext', 'value' => stripslashes(htmlspecialchars(get_option('architect_search_boxsubmittext'))), 'description' => 'Change the default for the search box submit button'));

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}
?>