<?php
include('wpframe.php');
wpframe_stop_direct_call(__FILE__);

if(isset($_POST['action'])) {
	//FIX BY myhow2guru.com with some Correction by b. murphy.
	register_post_type( 'template', array(
		'public'  => false,
		'_builtin' => true, /* internal use only. don't use this when registering your own post type. */
	));

	if($_POST['action'] == 'edit') {
		if(!isset($_POST['menu_order'])) $_POST['menu_order'] = 0;
		else { //If the post of any template is set to 1, that is the default template. Set all others to 0
			$wpdb->get_results("UPDATE {$wpdb->posts} SET menu_order='0' WHERE post_type='template' AND post_author='{$current_user->ID}'");
		}

		edit_post();

	} elseif($_POST['action'] == 'new') {
		wp_write_post();
	}
}
?><div class="wrap">
<h2><?php e("Manage Templates"); ?></h2>

<?php
wp_enqueue_script( 'listman' );
wp_print_scripts();
?>

<table class="widefat">
	<thead>
	<tr>
		<th scope="col"><div style="text-align: center;">ID</div></th>
		<th scope="col">Title</th>
		<th scope="col">Author</th>
		<th scope="col">Created on</th>
		<th scope="col" colspan="3">Action</th>
	</tr>
	</thead>

	<tbody id="the-list">
<?php
// Retrieve the templates
$templates = templates_get_users_templates($current_user->ID);

if (count($templates)) {
	$bgcolor = '';
	$class = ('alternate' == $class) ? '' : 'alternate';
	
	foreach($templates as $template) {
		print "<tr id='post-{$template->ID}' class='$class'>\n";
		$user_info = get_userdata($template->post_author);
		?>
		<th scope="row" style="text-align: center;"><?php echo $template->ID ?></th>
		<td><?php echo $template->post_title ?></td>
		<td><?php echo apply_filters('the_author', $user_info->display_name) ?></td>
		<td><?php echo date(get_option('date_format') . ' ' . get_option('time_format'), strtotime($template->post_date)) ?></td>
		<td><a href='post-new.php?template=<?php echo $template->post_name?>' class='edit' title='<?php echo __('Create a new post using this template')?>'><?php echo __('New Post')?></a></td>
		<td><a href='edit.php?page=article-templates/template_form.php&amp;action=edit&amp;template=<?php echo $template->ID?>' class='edit'><?php echo  __('Edit'); ?></a></td>
		<td><?php
			$link = "post.php?action=delete&amp;post=$template->ID";
			if (function_exists('wp_nonce_url')) {
				$link = wp_nonce_url($link, 'delete-post_' . $template->ID);
			}
		?><a href='<?php echo $link?>' class='delete' onclick="return confirm('<?php e(addslashes("You are about to delete this template '{$template->post_title}'. Press 'OK' to delete and 'Cancel' to stop."))?>');"><?php echo __('Delete')?></a></td>
<?php
		}
?>
	</tr> 
<?php
	} else {
?>
	<tr style='background-color: <?php echo $bgcolor; ?>;'>
		<td colspan="4"><?php e('No templates found.') ?></td>
	</tr>
<?php
}
?>
	</tbody>
</table>

<a href="edit.php?page=article-templates/template_form.php&amp;action=new"><?php e("Create New Template")?></a>
</div>
