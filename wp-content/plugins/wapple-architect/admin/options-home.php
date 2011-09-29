<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Save show excerpt on home page
	if(architect_save_option('architect_home_showexcerpt')) $updateOption = true;
	// Save home page excerpt override
	if(architect_save_option('architect_home_excerpt_override')) $updateOption = true;
	// Save remove captions
	if(architect_save_option('architect_home_removecaptions')) $updateOption = true;
	// Save home page show date
	if(architect_save_option('architect_home_showdate')) $updateOption = true;
	// Save home page show categories
	if(architect_save_option('architect_home_showcategories')) $updateOption = true;
	// Save home page image scale
	if(architect_save_option('architect_home_imagescale')) $updateOption = true;
	// Save home page image quality
	if(architect_save_option('architect_home_imagequality')) $updateOption = true;
	// Save home page transparency colour
	if(architect_save_option('architect_home_transcol')) $updateOption = true;
	// Save home show search
	if(architect_save_option('architect_home_showsearch')) $updateOption = true;
	// Save number of posts on home page
	if(architect_save_option('architect_home_posts_per_page')) $updateOption = true;
	// Show first image from post on home page
	if(architect_save_option('architect_home_firstimage')) $updateOption = true;
	// Save first image is a link to the article
	if(architect_save_option('architect_firstimageaslink')) $updateOption = true;
	// Save post titles
	if(architect_save_option('architect_showtitlelink')) $updateOption = true;
	// Save show more link
	if(architect_save_option('architect_home_showmore')) $updateOption = true;
	// Save older & newer posts link 
	if(architect_save_option('architect_home_olderposts', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_home_newerposts', array('stripTags' => true))) $updateOption = true;
	if(architect_save_option('architect_home_readmore', array('stripTags' => true))) $updateOption = true;
}

if(isset($updateOption) AND $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-home" enctype="multipart/form-data">';

	echo architect_admin_header('2', 'Wapple Architect Home Page Settings');
} else
{
	echo '<h3>Home Page Settings</h3>';
}	
echo architect_table_start();


// Show home page excerpt
echo architect_admin_option('select', array('label' => 'Show excerpt on homepage', 'name' => 'architect_home_showexcerpt', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_home_showexcerpt'), 'description' => 'Show a bit of your post on the homepage'));

// Show home page excerpt override
echo architect_admin_option('input', array('size' => 5, 'label' => 'Home page excerpt chars limit', 'name' => 'architect_home_excerpt_override', 'value' => get_option('architect_home_excerpt_override'), 'description' => 'Restrict home page excerpt to this number of chars'));

// Remove captions from excerpts
echo architect_admin_option('select', array('label' => 'Remove captions from excerpt', 'name' => 'architect_home_removecaptions', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_home_removecaptions'), 'description' => 'Captions are a pain - you can remove them completely from your excerpt here'));

// Show post date
echo architect_admin_option('select', array('label' => 'Show post date on homepage', 'name' => 'architect_home_showdate', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_home_showdate'), 'description' => 'Show the post date on the home page'));

// Show categories at the bottom of the home page
echo architect_admin_option('select', array('label' => 'Show categories on homepage', 'name' => 'architect_home_showcategories', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_home_showcategories'), 'description' => 'Show a list of categories at the bottom of the home page'));

// Image scale on home page
$homepagescale = ARCHITECT_HOME_IMAGESCALE;
if(get_option('architect_home_imagescale'))
{
	$homepagescale = get_option('architect_home_imagescale');
}
echo architect_admin_option('input', array('size' => 2, 'label' => 'Image scale on homepage', 'name' => 'architect_home_imagescale', 'value' => $homepagescale, 'after' => '% ', 'description' => 'Define how wide you want post images resized to with relation to screen width'));	

// Image quality on home page
$homepagequality = ARCHITECT_HOME_IMAGEQUALITY;
if(get_option('architect_home_imagequality'))
{
	$homepagequality = get_option('architect_home_imagequality');
}
echo architect_admin_option('input', array('size' => 2, 'label' => 'Image quality on homepage', 'name' => 'architect_home_imagequality', 'value' => $homepagequality, 'after' => '% ', 'description' => 'Define the quality of the image on the home page'));	

// Image transcol on home page
echo architect_admin_option('input', array('size' => 6, 'label' => 'Image transcol on homepage', 'name' => 'architect_home_transcol', 'value' => get_option('architect_home_transcol'), 'before' => '# ', 'description' => 'Define the transparency colour of the image on the home page'));	

// Show search on home page
echo architect_admin_option('select', array('label' => 'Show search on home page', 'name' => 'architect_home_showsearch', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_home_showsearch'), 'description' => 'Show search box on the home page (appears at bottom)'));

// Number of posts on home page
$posts_per_page = get_option('posts_per_page');
$option_posts_per_page = get_option('architect_home_posts_per_page');
if($option_posts_per_page)
{
	$posts_per_page = $option_posts_per_page;
}
echo architect_admin_option('input', array('size' => 2, 'label' => '# Posts on homepage', 'name' => 'architect_home_posts_per_page', 'value' => $posts_per_page, 'description' => 'Define the number of posts on the home page'));	

// Show the first image from the post on the home page
echo architect_admin_option('select', array('label' => 'Show first image in post as thumbnail', 'name' => 'architect_home_firstimage', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_home_firstimage'), 'description' => 'Show the first image from the post as a thumbnail'));

// First image is a link to the post
echo architect_admin_option('select', array('label' => 'First image is a link to the post', 'name' => 'architect_firstimageaslink', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_firstimageaslink'), 'description' => 'The first image in the post is also a link to the post'));

// Show normal post link
echo architect_admin_option('select', array('label' => 'Display a normal style link to a post', 'name' => 'architect_showtitlelink', 'options' => array('1' => 'Yes', '-1' => 'No'), 'value' => get_option('architect_showtitlelink'), 'description' => 'Display a normal link to the post'));

// Show more link
echo architect_admin_option('select', array('label' => 'Show read more link on home page', 'name' => 'architect_home_showmore', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => get_option('architect_home_showmore'), 'description' => 'Show more link on home page'));

// Older articles link
echo architect_admin_option('input', array('size' => 10, 'label' => 'Older articles link', 'name' => 'architect_home_olderposts', 'value' => stripslashes(get_option('architect_home_olderposts')), 'description' => 'User defined older links on homepage'));

// Newer articles link
echo architect_admin_option('input', array('size' => 10, 'label' => 'Newer articles link', 'name' => 'architect_home_newerposts', 'value' => stripslashes(get_option('architect_home_newerposts')), 'description' => 'User defined newer links on homepage'));
echo architect_admin_option('input', array('size' => 10, 'label' => 'Read more link', 'name' => 'architect_home_readmore', 'value' => stripslashes(get_option('architect_home_readmore')), 'description' => 'User defined "read more" link on homepage'));

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}

?>