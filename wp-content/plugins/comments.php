<?php
	global $jskit_wp_plugin_version, $jskit_url;

	$the_permalink = $post->guid;
	ereg('^(\s*([a-z]{1,6}):\/\/)?(www\.)?(([a-z0-9-]{1,63}\.)+[a-z]{2,10})(:[0-9]{1,5})?(\/[~a-z0-9_ \.-\?\/]+)',$the_permalink,$regs);
	$tmp_path = $regs[7];
	$path = ereg_replace('\?','',$tmp_path);
?>
	<script type="text/javascript" id="js-kit-wordpressPluginTemplate" src="<?php echo $jskit_url; ?>/tmpl/wp.cgi?path=<?php echo urlencode($path) ?>&permalink=<?php echo urlencode(get_permalink())."&jskit_wp_plugin_version=".urlencode($jskit_wp_plugin_version)?>"></script>
	
