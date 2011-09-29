<?php
define(ARCHITECTABSPATH, substr($_SERVER['SCRIPT_FILENAME'], 0, strpos($_SERVER['SCRIPT_FILENAME'], 'wp-content')).DIRECTORY_SEPARATOR);
require_once(ARCHITECTABSPATH.'wp-load.php');

$contents = file_get_contents(get_stylesheet_directory().DIRECTORY_SEPARATOR.'style.css');

/* Remove all URLs from stylesheet */
$contents = preg_replace('/url\((.*?)\)/', 'url()', $contents);

header("Content-type: text/css");
ob_end_clean();
echo $contents;
?>