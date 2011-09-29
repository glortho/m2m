<div class="wrap">
<h2><?php _e('Discussion Options') ?></h2>
<form method="post" action="<?php echo  get_option('siteurl'). "/wp-admin/"; ?>options.php">
<?php wp_nonce_field('update-options') ?>
<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options &raquo;') ?>" /></p>
<fieldset class="options">
<legend><?php echo __('Usual settings for an article:').'<br /><small><em>('.__('These settings may be overridden for individu
al artic
les.').')</em></small>'; ?></legend>
<ul>
<li>
<label for="default_pingback_flag">
<input name="default_pingback_flag" type="checkbox" id="default_pingback_flag" value="1" <?php checked('1', get_option('default_pingback_flag')); ?> />
<?php _e('Attempt to notify any blogs linked to from the article (slows down posting.)') ?></label>
</li>
<li>
<label for="default_ping_status">
<input name="default_ping_status" type="checkbox" id="default_ping_status" value="open" <?php checked('open', get_option('default_ping_status')); ?> />
<?php _e('Allow link notifications from other blogs (pingbacks and trackbacks.)') ?></label>
</li>
<li>
<label for="default_comment_status">
<input name="default_comment_status" type="checkbox" id="default_comment_status" value="open" <?php checked('open', get_option('default_comment_status')); ?> />
<?php _e('Allow people to post comments on the article') ?></label>
</li>
</form>
</div>
