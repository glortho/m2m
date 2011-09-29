<?php
/*
Plugin Name: Article Templates
Plugin URI: http://www.bin-co.com/tools/wordpress/plugins/article_templates/
Description: Enables template support for posts and pages. You can see all existing templates in the <a href="edit.php?page=article-templates/manage.php">Manage Templates</a> page.
Version: 1.05.2
Author: Binny V A
Author URI: http://binnyva.com/
*/

/**
 * Add a new menu under Manage, visible for all users with template viewing level.
 */
add_action( 'admin_menu', 'templates_add_menu_links' );
function templates_add_menu_links() {
	global $wp_version;
	$view_level= 2;
	$page = 'edit.php';
	if($wp_version >= '2.7') $page = 'tools.php';
	
	add_submenu_page($page, __('Manage Templates', 'article-templates'), __('Manage Templates', 'article-templates'), $view_level, 'article-templates/manage.php' );
	$hookname = get_plugin_page_hookname('article-templates/template_form.php', '' );
	$GLOBALS['_registered_pages'][$hookname] = true;
}

/**
 * Add a Drop down in the post create page that lists all the templates.
 */
add_action( 'edit_form_advanced', 'templates_post_page_templates_list' );
add_action( 'edit_page_form', 'templates_post_page_templates_list' );
function templates_post_page_templates_list() {
	global $current_user;
	$templates = templates_get_users_templates($current_user->ID);
	$template_js_data = array();
?>
<div id="article-template" class="postbox">
<h3><?php _e("Article Template", 'article-templates') ?></h3>
<div class="inside">
<p><?php _e('Article template allows you to create templates that can be used when writing a new post or page. Templates are very useful if you create several posts with the same structure. You can create a new template under the <a title="Manage Templates" href="edit.php?page=article-templates/manage.php">Manage Templates</a> section.', 'article-templates') ?></p>

<label for="template" style="font-size: 11px; font-weight: bold;"><?php _e("Template: ", 'article-templates') ?></label>
<br /><br />
<select name="template" id="template">
	<option value="none"><?php _e("None", 'article-templates') ?></option>
	<?php foreach($templates as $template) { ?>
	<option value="<?php echo $template->post_name?>"><?php echo $template->post_title?></option>
	<?php $template_js_data[$template->post_name] = template_js_escape($template->post_content); } ?>
</select>

<script type="text/javascript">
var all_templates = <?php echo templates_array2json($template_js_data)?>;

addLoadEvent(function(){
	document.getElementById("template").onchange=insertTemplate;

	var url = document.location.href;
	//Don't insert the default template in the templates section.
	if(url.indexOf("edit.php?page=article-templates\/template_form.php")+1) return;

	//Don't insert the default template in a edit page/post action
	if(url.indexOf("post.php?action=edit")+1) return;
	if(url.indexOf("page.php?action=edit")+1) return;

	//Setting the template in the URL as the default template.
	var match = url.match(/[\?\&]template=([^\&]+)/);
	if(match) {
		var template = match[1];
		document.getElementById("template").value = template;
		insertTemplate('url');
		return;
	}
	
	<?php if($_REQUEST['action'] != 'edit') { ?>
	//If there is a default template, insert that
	var default_template = "<?php echo templates_get_default_template_for_user($current_user->ID)?>";
	if(default_template) {
		document.getElementById("template").value = default_template;
		insertTemplate('default');
	}
	<?php } ?>
});

function insertTemplate(insertion_type) {
	template = document.getElementById("template").value;
	if(template == 'none') return;
	if(!all_templates[template]) return;

	if(window.tinyMCE && document.getElementById("content").style.display=="none") {
		//If there is any content in the text area, don't insert the template
		if(getText(tinyMCE.get('content').getContent())) {
			alert("Cannot insert template - content already present");
			document.getElementById("template").value = "none";
			return;
		}
		tinyMCE.get('content').setContent(all_templates[template].replace(/\n/g,"<br />"));

	} else if(document.getElementById("content")) {
		//If there is any content in the text area, don't insert the template
		if(getText(document.getElementById("content").value)) {
			alert("Cannot insert template - content already present");
			return;
		}

		document.getElementById("content").value = all_templates[template];
	}
}

function getText(str) {
	return str.replace(/<[^>]+>/g,'').replace(/\s/g,'');
}
</script>
</div>
</div>
<?php
}

/**
 * Get all the templates created by the given user
 */
function templates_get_users_templates($user_id) {
    global $wpdb;
    
    $query = <<<SQL
        SELECT DISTINCT ID, post_title, post_name, post_date, post_type, post_content, post_author
        FROM {$wpdb->posts}
        JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
        WHERE post_type='template' AND (post_author='$user_id' OR meta_key='available_for_all')
        ORDER BY post_date DESC
SQL;

    return $wpdb->get_results($query);
}

/**
 * Get the default templates for the given user
 */
function templates_get_default_template_for_user($user_id) {
    global $wpdb;

    $user_selected =
        $wpdb->get_var("SELECT post_name FROM {$wpdb->posts} " .
                       " WHERE post_type='template' AND post_author='$user_id' AND menu_order='1' LIMIT 1");

    if( ! $user_selected )
    {
        $query = <<<SQL
            SELECT DISTINCT post_name
            FROM {$wpdb->posts}
            JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
            WHERE post_type='template' AND meta_key='default_for_all' AND meta_value = 1
            ORDER BY post_date DESC
SQL;

        return $wpdb->get_var($query);
    }

    return $user_selected;
}

/// Register server side request handling function
add_action('save_post', 'article_templates_handle_update', 10, 2);
function article_templates_handle_update( $post_id, $post )
{
    if( ! empty($_REQUEST['available_for_all']) )
    {
        add_post_meta($post_id, 'available_for_all', intval($_REQUEST['available_for_all']), true)
            or update_post_meta($post_id, 'available_for_all', intval($_REQUEST['available_for_all']));
    }
    else
    {
        delete_post_meta($post_id, 'available_for_all');
    }

    if( ! empty($_REQUEST['default_for_all']) )
    {
        // avoid multiple default_for_all templates
        global $wpdb;
		$wpdb->get_results("DELETE FROM {$wpdb->postmeta} WHERE meta_key = \"default_for_all\"");        

        add_post_meta($post_id, 'default_for_all', intval($_REQUEST['default_for_all']), true)
            or update_post_meta($post_id, 'default_for_all', intval($_REQUEST['default_for_all']));

        // default_for_all implies available_for_all
        add_post_meta($post_id, 'available_for_all', 1, true)
            or update_post_meta($post_id, 'available_for_all', 1, true);
    }
    else
    {
        delete_post_meta($post_id, 'default_for_all');
    }
}

////////////////////////////////////////////////// Library Functions //////////////////////////////////
function template_js_escape($text) {
	$safe_text = preg_replace("/\r?\n/", '\n', addslashes($text));
	$safe_text = preg_replace("/\//", '\\/', $safe_text);
	
	return $safe_text;
}
/**
 * Array2json library function - is not needed in PHP 5.2+
 * http://www.bin-co.com/php/scripts/array2json/
 */
function templates_array2json($arr) {
    $parts = array();
    $is_list = false;

    //Find out if the given array is a numerical array
    $keys = array_keys($arr);
    $max_length = count($arr)-1;
    if(($keys[0] === 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
        $is_list = true;
        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
            if($i != $keys[$i]) { //A key fails at position check.
                $is_list = false; //It is an associative array.
                break;
            }
        }
    }

    foreach($arr as $key=>$value) {
        if(is_array($value)) { //Custom handling for arrays
            if($is_list) $parts[] = templates_array2json($value); /* :RECURSION: */
            else $parts[] = '"' . $key . '":' . templates_array2json($value); /* :RECURSION: */
        } else {
            $str = '';
            if(!$is_list) $str = '"' . $key . '":';

            //Custom handling for multiple data types
            if(is_numeric($value)) $str .= $value; //Numbers
            elseif($value === false) $str .= 'false'; //The booleans
            elseif($value === true) $str .= 'true';
            else $str .= '"' . ($value) . '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Object?)

            $parts[] = $str;
        }
    }
    $json = implode(',',$parts);
    
    if($is_list) return '[' . $json . ']';//Return numerical JSON
    return '{' . $json . '}';//Return associative JSON
}
