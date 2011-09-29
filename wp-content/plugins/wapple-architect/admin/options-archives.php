<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;

	// Category text
	if(architect_save_option('architect_archive_cattext', array('stripTags' => true, 'tagAllow' => array('category')))) $updateOption = true;
	// Tag text
	if(architect_save_option('architect_archive_tagtext', array('stripTags' => true, 'tagAllow' => array('tag')))) $updateOption = true;
	// Date text
	if(architect_save_option('architect_archive_datetext', array('stripTags' => true))) $updateOption = true;
	// Author archive text
	if(architect_save_option('architect_archive_authortext', array('stripTags' => true))) $updateOption = true;
	// Blog archive text
	if(architect_save_option('architect_archive_blogarchivetext', array('stripTags' => true))) $updateOption = true;
	// Archive home link
	if(architect_save_option('architect_archive_hometext', array('stripTags' => true))) $updateOption = true;
	// Archive older entries link
	if(architect_save_option('architect_archive_olderentriestext', array('stripTags' => true))) $updateOption = true;
	// Archive newer entries link
	if(architect_save_option('architect_archive_newerentriestext', array('stripTags' => true))) $updateOption = true;
	// No category posts text
	if(architect_save_option('architect_archive_nocattext', array('stripTags' => true, 'tagAllow' => array('category')))) $updateOption = true;
	// No date posts text
	if(architect_save_option('architect_archive_nodatetext', array('stripTags' => true))) $updateOption = true;
	// No author posts text
	if(architect_save_option('architect_archive_noauthortext', array('stripTags' => true, 'tagAllow' => array('author')))) $updateOption = true;
	// No posts found text
	if(architect_save_option('architect_archive_nopoststext', array('stripTags' => true))) $updateOption = true;	
}

if(isset($updateOption) AND $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-archives" enctype="multipart/form-data">';

	echo architect_admin_header('2', 'Wapple Architect Archives Page Settings');
} else
{
	echo '<h3>Archives Page Settings</h3>';
}	
echo architect_table_start();

echo architect_admin_option('text', array('value' => 'Please note that the archives page includes: Category post listings, date listings and author listings<br />A number of settings for the archives page can be configured on the "Home" tab: Show post date, show first image as thumbnail', 'italic' => true));
// Text for "Archive for the .. Category"
echo architect_admin_option('input', array('size' => 30, 'label' => '"Archive for the &lt;category&gt; Category" Text', 'name' => 'architect_archive_cattext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_cattext'))), 'description' => 'Specify what you want to say instead of "Archive for the "&lt;category&gt;" Category" (use &lt;category&gt; for the category name)'));

// Text for "Posts Tagged "
echo architect_admin_option('input', array('size' => 30, 'label' => '"Posts Tagged &lt;tag&gt;" Text', 'name' => 'architect_archive_tagtext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_tagtext'))), 'description' => 'Specify what you want to say instead of "Posts Tagged "&lt;tag&gt;"" (use &lt;tag&gt; for the tag name)'));

// Text for "Archive for 
echo architect_admin_option('input', array('size' => 30, 'label' => '"Archive for" Text', 'name' => 'architect_archive_datetext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_datetext'))), 'description' => 'Specify what you want to say instead of "Archive for" (used in date archives)'));

// Text for "Author Archive
echo architect_admin_option('input', array('size' => 30, 'label' => '"Author Archives" Text', 'name' => 'architect_archive_authortext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_authortext'))), 'description' => 'Specify what you want to say instead of "Author Archive"'));

// Text for "Blog Archives
echo architect_admin_option('input', array('size' => 30, 'label' => '"Blog Archives" Text', 'name' => 'architect_archive_blogarchivetext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_blogarchivetext'))), 'description' => 'Specify what you want to say instead of "Blog Archives"'));

// Text for "home" link
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to home', 'name' => 'architect_archive_hometext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_hometext'))), 'description' => 'Change the default text for link back to home'));

// Text for "Older entries"
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to older entries', 'name' => 'architect_archive_olderentriestext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_olderentriestext'))), 'description' => 'Change the default text for link to older entries'));

// Text for "Newer entries"
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to newer entries', 'name' => 'architect_archive_newerentriestext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_newerentriestext'))), 'description' => 'Change the default text for link to newer entries'));

// Text for "Sorry, but there aren\'t any posts in the .. category yet."
echo architect_admin_option('input', array('size' => 30, 'label' => 'No Category Posts Text', 'name' => 'architect_archive_nocattext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_nocattext'))), 'description' => 'Specify what you want to say instead of "Sorry, but there aren\'t any posts in the "&lt;category&gt;" category yet" (use &lt;category&gt; for the category name)'));

// Text for "Sorry, but there aren\'t any posts with this date."
echo architect_admin_option('input', array('size' => 30, 'label' => 'No Date Posts Text', 'name' => 'architect_archive_nodatetext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_nodatetext'))), 'description' => 'Specify what you want to say instead of "Sorry, but there aren\'t any posts with this date."'));

// Text for "Sorry, but there aren\'t any posts by .. yet"
echo architect_admin_option('input', array('size' => 30, 'label' => 'No Author Posts Text', 'name' => 'architect_archive_noauthortext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_noauthortext'))), 'description' => 'Specify what you want to say instead of "Sorry, but there aren\'t any posts by &lt;author&gt; yet."'));

// Text for "No posts found
echo architect_admin_option('input', array('size' => 30, 'label' => 'No Posts Text', 'name' => 'architect_archive_nopoststext', 'value' => stripslashes(htmlspecialchars(get_option('architect_archive_nopoststext'))), 'description' => 'Specify what you want to say instead of "No posts found"'));

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}
?>