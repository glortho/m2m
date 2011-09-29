<?php 
$string = '<spacemakerChunk><scale>4</scale></spacemakerChunk>';

if(!$text = get_option('architect_single_leaveareplytext'))
{
	$text = 'Leave a Reply';
}
$string .= '<wordsChunk class="commentTitle"><display_as>h3</display_as><quick_text>'.stripslashes($text).'</quick_text></wordsChunk>';
$string .= '<row><cell>';

$string .= '<form>';
$string .= '<action>'.get_option('siteurl').'/wp-comments-post.php</action>';

$string .= '<formItem item_type="text" id="author">';
if(!$text = get_option('architect_single_leaveareplynametext'))
{
	$text = 'Name';
}
$string .= '<label>'.stripslashes($text).'</label>';
$string .= '<name>author</name>';
$string .= '</formItem>';

$string .= '<formItem item_type="text" id="email">';
if(!$text = get_option('architect_single_leaveareplyemailtext'))
{
	$text = 'Email';
}
$string .= '<label>'.stripslashes($text).'</label>';
$string .= '<name>email</name>';
$string .= '</formItem>';

$string .= '<formItem item_type="text" id="url">';
if(!$text = get_option('architect_single_leaveareplywebsitetext'))
{
	$text = 'Website';
}
$string .= '<label>'.stripslashes($text).'</label>';
$string .= '<name>url</name>';
$string .= '</formItem>';

$string .= '<formItem item_type="textarea" id="comment">';
if(!$text = get_option('architect_single_leaveareplycommenttext'))
{
	$text = 'Comment';
}
$string .= '<label>'.stripslashes($text).'</label>';
$string .= '<name>comment</name>';
$string .= '</formItem>';

global $id;

$replytoid = isset($_GET['replytocom']) ? (int) $_GET['replytocom'] : 0;

$string .= '<formItem item_type="hidden" id="comment_post_ID">';
$string .= '<name>comment_post_ID</name>';
$string .= '<value>'.$id.'</value>';
$string .= '</formItem>';

$string .= '<formItem item_type="hidden" id="comment_parent">';
$string .= '<name>comment_parent</name>';
$string .= '<value>'.$replytoid.'</value>';
$string .= '</formItem>';

$string .= '<formItem item_type="submit" id="submit">';
if(!$text = get_option('architect_single_leaveareplysubmittext'))
{
	$text = 'Submit';
}
$string .= '<label>'.stripslashes($text).'</label>';
$string .= '<name>submit</name>';
$string .= '</formItem>';


$string .= '</form>';

$string .= '</cell></row>';

$themeoption = get_option('architect_theme');
if($themeoption != 'iphoneLight' AND $themeoption != 'iphoneDark')
{
	$string .= '<spacemakerChunk><scale>4</scale></spacemakerChunk>';
}

return $string;
?>