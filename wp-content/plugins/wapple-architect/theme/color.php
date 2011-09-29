<?php
define('ARCHITECTABSPATH', substr($_SERVER['SCRIPT_FILENAME'], 0, strpos($_SERVER['SCRIPT_FILENAME'], 'wp-content')).DIRECTORY_SEPARATOR);
require_once(ARCHITECTABSPATH.'wp-load.php');

header("Content-type: text/css");

$themeoption = get_option('architect_theme');

$getShowExcerpt = get_option('architect_home_showexcerpt');
$getReadMore = get_option('architect_home_showmore');
$homepagescale = ARCHITECT_HOME_IMAGESCALE;
$getVal = get_option('architect_home_imagescale');
if($getVal)
{
	$homepagescale = $getVal;
}
		
switch($themeoption)
{
	case 'fire':
		require_once('css'.DIRECTORY_SEPARATOR.'fire.php'); break;
	case 'tree':
		require_once('css'.DIRECTORY_SEPARATOR.'tree.php'); break;
	case 'sky':
		require_once('css'.DIRECTORY_SEPARATOR.'sky.php'); break;
	case 'wood':
		require_once('css'.DIRECTORY_SEPARATOR.'wood.php'); break;
	case 'alum':
		require_once('css'.DIRECTORY_SEPARATOR.'alum.php'); break;
	case 'dark':
		require_once('css'.DIRECTORY_SEPARATOR.'dark.php'); break;
	case 'paper':
		require_once('css'.DIRECTORY_SEPARATOR.'paper.php'); break;
	case 'iphoneLight':
		require_once('css'.DIRECTORY_SEPARATOR.'iphoneLight.php'); break;
	case 'iphoneDark':
		require_once('css'.DIRECTORY_SEPARATOR.'iphoneDark.php'); break;
	default: break;
}
?>