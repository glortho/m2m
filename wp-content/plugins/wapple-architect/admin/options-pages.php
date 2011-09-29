<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Save page image scale
	if(architect_save_option('architect_page_imagescale')) $updateOption = true;
	// Save page image quality
	if(architect_save_option('architect_page_imagequality')) $updateOption = true;
	// Save page  image transcol
	if(architect_save_option('architect_page_transcol')) $updateOption = true;	
}

if(isset($updateOption) AND $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-pages" enctype="multipart/form-data">';

	echo architect_admin_header('2', 'Wapple Architect Pages Settings');
} else
{
	echo '<h3>Pages Settings</h3>';
}	

echo architect_table_start();

// Image scale on pages
$pagescale = ARCHITECT_PAGE_IMAGESCALE;
if(get_option('architect_page_imagescale'))
{
	$pagescale = get_option('architect_page_imagescale');
}
echo architect_admin_option('input', array('size' => 2, 'label' => 'Image scale on page', 'name' => 'architect_page_imagescale', 'value' => $pagescale, 'after' => '% ', 'description' => 'Define how wide you want page images resized to with relation to screen width'));

// Image quality on pages
$pagequality = ARCHITECT_PAGE_IMAGEQUALITY;
if(get_option('architect_page_imagequality'))
{
	$pagequality = get_option('architect_page_imagequality');
}
echo architect_admin_option('input', array('size' => 2, 'label' => 'Image quality on page', 'name' => 'architect_page_imagequality', 'value' => $pagequality, 'after' => '% ', 'description' => 'Define the quality of the image on the page'));

// Image transcol on pages
echo architect_admin_option('input', array('size' => 6, 'label' => 'Image transcol on page', 'name' => 'architect_page_transcol', 'value' => get_option('architect_page_transcol'), 'before' => '#', 'description' => 'Define the transparency colour of the image on the page'));

echo '</table>';

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}
?>