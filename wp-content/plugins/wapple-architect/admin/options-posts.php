<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Save use post header image
	if(architect_save_option('architect_single_use_headerimage')) $updateOption = true;
	// Save post header image
	if(isset($_FILES['architect_single_headerimage']))
	{
		$pathToPostHeader = WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'postHeader'.DIRECTORY_SEPARATOR;
		architect_check_path($pathToPostHeader);
		if(move_uploaded_file($_FILES['architect_single_headerimage']['tmp_name'], $pathToPostHeader.$_FILES['architect_single_headerimage']['name']))
		{
			update_option('architect_single_headerimage', $_FILES['architect_single_headerimage']['name']);
			$updateOption = true;
		}
	}
	// Save post header image transparency colour
	if(architect_save_option('architect_single_headerimage_transcol')) $updateOption = true;
	// Save post do paging
	if(architect_save_option('architect_single_dopaging')) $updateOption = true;
	// Save post paging length
	if(architect_save_option('architect_single_paginglength')) $updateOption = true;
	// Save show home link
	if(architect_save_option('architect_single_showhome')) $updateOption = true;
	// Save show post next link
	if(architect_save_option('architect_single_shownext')) $updateOption = true;
	// Save show tags
	if(architect_save_option('architect_single_showtags')) $updateOption = true;
	// Save post image scale
	if(architect_save_option('architect_single_imagescale')) $updateOption = true;
	// Save post image quality
	if(architect_save_option('architect_single_imagequality')) $updateOption = true;
	// Save post image transcol
	if(architect_save_option('architect_single_transcol')) $updateOption = true;
	// Save post response format
	if(architect_save_option('architect_single_responseformat')) $updateOption = true;
	// Save allow post comments
	if(architect_save_option('architect_single_allowcomments')) $updateOption = true;
	// Save show post comments
	if(architect_save_option('architect_single_showcomments')) $updateOption = true;
	// Save read more on post
	if(architect_save_option('architect_single_nextpage')) $updateOption = true;
	// Save read less on post
	if(architect_save_option('architect_single_prevpage')) $updateOption = true;
	// Save text for previous post
	if(architect_save_option('architect_single_previouspost', array('stripTags' => true))) $updateOption = true;
	// Save text for next post
	if(architect_save_option('architect_single_nextpost', array('stripTags' => true))) $updateOption = true;
	// Save text for home post
	if(architect_save_option('architect_single_homepost', array('stripTags' => true))) $updateOption = true;
	// Save tag text
	if(architect_save_option('architect_single_tagtext', array('stripTags' => true))) $updateOption = true;
	// Save post language text
	if(architect_save_option('architect_single_metadatatext', array('stripTags' => true, 'tagAllow' => array('date', 'time', 'category')))) $updateOption = true;
	if(architect_save_option('architect_single_commentsaystext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_commentsingletext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_commentpluraltext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_leaveareplytext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_leaveareplynametext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_leaveareplyemailtext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_leaveareplywebsitetext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_leaveareplycommenttext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_leaveareplysubmittext', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_single_gravatarsupport')) $updateOption = true;
}

if(isset($updateOption) AND $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-posts" enctype="multipart/form-data">';

	echo architect_admin_header('2', 'Wapple Architect Posts Page Settings');
} else
{
	echo '<h3>Posts Page Settings</h3>';
}	
echo architect_table_start();
	
// Use a mobile header image
echo architect_admin_option('select', array('label' => 'Use post header image', 'name' => 'architect_single_use_headerimage', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_single_use_headerimage'), 'description' => 'Use an image on your post to replace main image or header text'));
	
// Upload a mobile footer image	
echo architect_admin_option('file', array('label' => 'Mobile post header image', 'name' => 'architect_single_headerimage', 'description' => 'Browse your local computer for a post header image'));

// Transparency colour for post image
echo architect_admin_option('input', array('label' => 'Post Header Image BG transparency colour', 'size' => 6, 'name' => 'architect_single_headerimage_transcol', 'value' => get_option('architect_single_headerimage_transcol'), 'before' => '#', 'description' => 'What background colour do you want your post header image to have?'));

// Alternative image for posts
if(get_option('architect_single_headerimage'))
{
	if(file_exists(WP_UPLOAD_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'postHeader'.DIRECTORY_SEPARATOR.get_option('architect_single_headerimage')))
	{
		$src = '/wp-content/uploads/'.get_wapl_plugin_base().'/images/postHeader/'.get_option('architect_single_headerimage');
	} else if(file_exists(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.get_wapl_plugin_base().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'postHeader'.DIRECTORY_SEPARATOR.get_option('architect_single_headerimage')))
	{
		$src = '/wp-content/plugins/'.get_wapl_plugin_base().'/theme/images/postheader/'.get_option('architect_single_headerimage');
	} else
	{
		$src = '';
	}
	echo architect_admin_option('image', array('label' => 'Mobile site post header image preview', 'alt' => 'Mobile Post Header Image', 'src' => $src));
}

// Allow comments on posts
echo architect_admin_option('select', array('label' => 'Allow comments on posts', 'name' => 'architect_single_allowcomments', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_single_allowcomments'), 'description' => 'Allow commenting from mobile'));

// Show comments on posts
echo architect_admin_option('select', array('label' => 'Show comments on posts', 'name' => 'architect_single_showcomments', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_single_showcomments'), 'description' => 'Show comments'));

// Pagination on posts
echo architect_admin_option('select', array('label' => 'Do pagination', 'name' => 'architect_single_dopaging', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_single_dopaging'), 'description' => 'Split up posts into smaller, easier to read pages'));
	
// Pagination length
$singlepagepaginglength = ARCHITECT_SINGLE_PAGINGLENGTH;
if(get_option('architect_single_paginglength'))
{
	$singlepagepaginglength = get_option('architect_single_paginglength');
}
echo architect_admin_option('input', array('size' => 4, 'label' => 'Post length', 'name' => 'architect_single_paginglength', 'value' => $singlepagepaginglength, 'after' => 'chars ', 'description' => 'Define length of post before splitting up into multiple pages'));

// Read more / next page text
echo architect_admin_option('input', array('size' => 10, 'label' => 'Read more on post', 'name' => 'architect_single_nextpage', 'value' => stripslashes(get_option('architect_single_nextpage')), 'description' => 'User defined read more link on post'));

// Read less / prev page text
echo architect_admin_option('input', array('size' => 10, 'label' => 'Go back on post', 'name' => 'architect_single_prevpage', 'value' => stripslashes(get_option('architect_single_prevpage')), 'description' => 'User defined go back link on post'));

// Link to previous post
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to previous post name', 'name' => 'architect_single_previouspost', 'value' => stripslashes(get_option('architect_single_previouspost')), 'description' => 'Text to show on link to previous post'));

// Link to next post
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to next post name', 'name' => 'architect_single_nextpost', 'value' => stripslashes(get_option('architect_single_nextpost')), 'description' => 'Text to show on link to next post'));

// Link to home
echo architect_admin_option('input', array('size' => 15, 'label' => 'Link to home name', 'name' => 'architect_single_homepost', 'value' => stripslashes(get_option('architect_single_homepost')), 'description' => 'Text to show on link to home'));

// Show home link on posts
echo architect_admin_option('select', array('label' => 'Show home link', 'name' => 'architect_single_showhome', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_single_showhome'), 'description' => 'Show a link back to the home page'));

// Show next/prev links on posts
echo architect_admin_option('select', array('label' => 'Show next/previous links', 'name' => 'architect_single_shownext', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_single_shownext'), 'description' => 'Show next and previous posts'));
	
// Show tags on posts
echo architect_admin_option('select', array('label' => 'Show tags', 'name' => 'architect_single_showtags', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_single_showtags'), 'description' => 'Show tags on posts'));



// Image scale on posts
$singlepagescale = ARCHITECT_SINGLE_IMAGESCALE;
if(get_option('architect_single_imagescale'))
{
	$singlepagescale = get_option('architect_single_imagescale');
}
echo architect_admin_option('input', array('size' => 2, 'label' => 'Image scale on post', 'name' => 'architect_single_imagescale', 'value' => $singlepagescale, 'after' => '% ', 'description' => 'Define how wide you want post images resized to with relation to screen width'));

// Image quality on posts
$singlepagequality = ARCHITECT_SINGLE_IMAGEQUALITY;
if(get_option('architect_single_imagequality'))
{
	$singlepagequality = get_option('architect_single_imagequality');
}
echo architect_admin_option('input', array('size' => 2, 'label' => 'Image quality on post', 'name' => 'architect_single_imagequality', 'value' => $singlepagequality, 'after' => '% ', 'description' => 'Define the quality of the image on the post'));

// Image transparency colour on posts
echo architect_admin_option('input', array('size' => 6, 'label' => 'Image transcol on post', 'name' => 'architect_single_transcol', 'value' => get_option('architect_single_transcol'), 'before' => '#', 'description' => 'Define the transparency colour of the image on the post'));

echo '<tr><td colspan="2"><h3>Alternative Text Settings</h3></td></tr>';

// Tag text
echo architect_admin_option('input', array('size' => 10, 'label' => 'Tag text', 'name' => 'architect_single_tagtext', 'value' => stripslashes(get_option('architect_single_tagtext')), 'description' => 'Specify what you want to say instead of "Tags:"'));

// Meta data text
echo architect_admin_option('input', array('size' => 20, 'label' => 'Meta data text', 'name' => 'architect_single_metadatatext', 'value' => stripslashes(get_option('architect_single_metadatatext')), 'description' => 'Specify what you want to say instead of "This entry was posted on &lt;date&gt; at &lt;time&gt; and is filed under &lt;category&gt;"'));

// Comment text
echo architect_admin_option('input', array('size' => 20, 'label' => '&lt;author&gt; says: Text', 'name' => 'architect_single_commentsaystext', 'value' => stripslashes(get_option('architect_single_commentsaystext')), 'description' => 'Specify what you want to say instead of " says " (Text that usually goes after the author name)'));

echo architect_admin_option('input', array('size' => 20, 'label' => 'Comment text (single)', 'name' => 'architect_single_commentsingletext', 'value' => stripslashes(get_option('architect_single_commentsingletext')), 'description' => 'Specify what you want to say instead of " comment " (singular)'));
echo architect_admin_option('input', array('size' => 20, 'label' => 'Comment text (plural)', 'name' => 'architect_single_commentpluraltext', 'value' => stripslashes(get_option('architect_single_commentpluraltext')), 'description' => 'Specify what you want to say instead of " comments " (plural)'));

// Responses text
$options = array(
	'1' => '1 response',
	'2' => '1 response to [post title]',
	'3' => '1 comment',
	'4' => '1 comment to [post title]',
);
echo architect_admin_option('select', array('label' => '# responses text', 'name' => 'architect_single_responseformat', 'options' => $options, 'value' => get_option('architect_single_responseformat'), 'description' => 'Define the format of response text'));

// Leave a reply text
echo architect_admin_option('input', array('size' => 20, 'label' => 'Leave a reply text', 'name' => 'architect_single_leaveareplytext', 'value' => stripslashes(get_option('architect_single_leaveareplytext')), 'description' => 'Specify what you want to say instead of "Leave a reply"'));
echo architect_admin_option('input', array('size' => 20, 'label' => 'Leave a reply "Name" text', 'name' => 'architect_single_leaveareplynametext', 'value' => stripslashes(get_option('architect_single_leaveareplynametext')), 'description' => 'Specify what you want to say instead of "Name" in the comment form'));
echo architect_admin_option('input', array('size' => 20, 'label' => 'Leave a reply "Email" text', 'name' => 'architect_single_leaveareplyemailtext', 'value' => stripslashes(get_option('architect_single_leaveareplyemailtext')), 'description' => 'Specify what you want to say instead of "Email" in the comment form'));
echo architect_admin_option('input', array('size' => 20, 'label' => 'Leave a reply "Website" text', 'name' => 'architect_single_leaveareplywebsitetext', 'value' => stripslashes(get_option('architect_single_leaveareplywebsitetext')), 'description' => 'Specify what you want to say instead of "Website" in the comment form'));
echo architect_admin_option('input', array('size' => 20, 'label' => 'Leave a reply "Comment" text', 'name' => 'architect_single_leaveareplycommenttext', 'value' => stripslashes(get_option('architect_single_leaveareplycommenttext')), 'description' => 'Specify what you want to say instead of "Comment" in the comment form'));
echo architect_admin_option('input', array('size' => 20, 'label' => 'Leave a reply "Submit" text', 'name' => 'architect_single_leaveareplysubmittext', 'value' => stripslashes(get_option('architect_single_leaveareplysubmittext')), 'description' => 'Specify what you want to say instead of "Submit" in the comment form'));

// Gravatar support
echo architect_admin_option('select', array('label' => 'Show gravatars on comments', 'name' => 'architect_single_gravatarsupport', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_single_gravatarsupport'), 'description' => 'Show gravatars next to any comments'));

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}

?>