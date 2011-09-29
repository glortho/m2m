<?php
include('wpframe.php');
wpframe_stop_direct_call(__FILE__);
?>
<div class="wrap">
<h2><?php echo __(ucfirst($_REQUEST['action']) . " Template"); ?></h2>

<?php
$template_id= 0;
$title		= '';
$content	= '';

//Edit an existing template
if($_REQUEST['action'] == 'edit' and isset($_REQUEST['template']) and is_numeric($_REQUEST['template'])) {
	$template_id = $_REQUEST['template'];
	$template_data = $wpdb->get_results("SELECT ID,post_title,post_name,post_content,menu_order FROM {$wpdb->posts} "
				. " WHERE ID='$template_id' AND post_type='template' AND post_author='{$current_user->ID}'");
				
	$title	= $template_data[0]->post_title;
	$name	= $template_data[0]->post_name;
	$content= $template_data[0]->post_content;
	$default_template	= $template_data[0]->menu_order;
	$available_for_all	= get_post_meta($template_id, 'available_for_all', true);
	$default_for_all	= get_post_meta($template_id, 'default_for_all', true);
}

wpframe_add_editor_js();

?>

<form name="post" action="edit.php?page=article-templates/manage.php" method="post" id="post">
<div id="poststuff">
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">

<div class="postbox">
<h3 class="hndle"><span><?php e('Template Title') ?></span></h3>
<div class="inside">
<input type="text" name="post_title" size="30" tabindex="1" value="<?php echo attribute_escape( $title ); ?>" id="title" />
</div></div>

<div class="postbox">
<h3 class="hndle"><span><?php e('Template Content') ?></span></h3>
<div class="inside">
<?php if ( 'edit' == $action and $template_id) { ?>
<a href="<?php echo clean_url(apply_filters('preview_post_link', add_query_arg('preview', 'true', get_permalink($template_id)))); ?>" style="position: absolute; right: 2em; margin-right: 19em; text-decoration: underline;" target="_blank"><?php _e('Preview &raquo;'); ?></a>
<?php } ?>
<?php the_editor($content); ?>
</div></div>

<div class="postbox">
<h3 class="hndle"><span><?php e('Template Status') ?></span></h3>
<div class="inside">
<div>
    <label for="menu_order"><?php e('Default Template'); ?></label>
    <input type="checkbox" id="menu_order" name="menu_order" value="1" <?php echo ($default_template)?"checked='checked'":''?> />
</div>
<?php // allow just users editors to add templates available to all users ?>
<?php if( 5 <= $user_level ) { ?>
<div>
    <label for="available_for_all"><?php e('Available to all users'); ?></label>
    <input type="checkbox" id="available_for_all" name="available_for_all" value="1" <?php echo ($available_for_all)?"checked='checked'":''?> />
</div>
<?php }
// allow just administrators to set as default template for all users
if( 8 <= $user_level ) { ?>
<div>
    <label for="default_for_all"><?php e('Default for all users'); ?></label>
    <input type="checkbox" id="default_for_all" name="default_for_all" value="1" <?php echo ($default_for_all)?"checked='checked'":''?> />
</div>
<?php } ?>
</div></div>

<p class="submit">
<input type="hidden" value="" name="post_name" />
<input type="hidden" name="action" value="<?php echo stripslashes($_REQUEST['action'])?>" />
<input type="hidden" name="post_ID" value="<?php echo stripslashes($_REQUEST['template'])?>" />
<input type="hidden" name="saveasprivate" value="1" />
<input type="hidden" name="post_type" value="template" />
<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />

<span id="autosave"></span>
<input type="submit" name="submit" value="<?php _e('Save') ?>" style="font-weight: bold;" tabindex="4" />
</p>

<p><?php do_action('edit_page_form'); ?></p>
</div>
</form>

</div>
