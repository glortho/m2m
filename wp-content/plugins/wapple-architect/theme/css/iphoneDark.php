<?php 
$homeShowDate = get_option('architect_home_showdate');
$homeShowExcerpt = get_option('architect_home_showexcerpt');
$homeShowAuthor = get_option('architect_showauthor');
$homeShowMore = get_option('architect_home_showmore');
$homeShowPostLink = get_option('architect_showtitlelink');
$headerImage = get_option('architect_use_headerimage');
$footerText = get_option('architect_showfootertext');
?>

body.body{font-size:14px;font-size:14px !important;background:#303030 url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneDark/bg.jpg) repeat-x 0 0;color:#383838;}
a{color:#505c75;}
h1,h2,h3,h4,h5,h6{margin:0;padding:0;color:#93b0d5;}
h2{font-size:1.4em;}
.waplsmall{padding:0;}
#c {}
.postmetadata.alt{padding:0;}
.nav_row,.entry_row_row.h2_row,.post-date_row,.entry_row.excerpt_row,.navigation.archiveNavigation_row,.search_row,.author_row,
	.navigation_row,.postTitle_row,.authorRow.singlepost_row,.postimagerow,.entry_row.singlepost_row,.postTags_row,.postmetadata.commentsTitle_row,
	.postmetadata.alt_row,.commentTitle_row,.postmetadata.commentAuthor_row,.postmetadata.commentDate_row,.postmetadata.commentContent_row,.postNextPrev,
	.postBackRow,.entry_row.page,.postmetadata.categories_row,.postmetadata.tags_row,.search.entry_row,.entry_row.pagetitle,.postTop_row,
	.homeCategoryHeader_row
	{margin:0 5px;}
#header{background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneLight/header.png) repeat-x 0 0;height:71px;line-height:71px;text-align:center;margin-bottom:20px;}		
#header h1,#header a{color:#ffffff;text-shadow: #474747 0px -1px 1px;font-size:1.5em;font-weight:bold;}
.description{color:#93b0d5;font-size:1em;margin-bottom:10px;}
.entry_row{padding-bottom:0;}
.nav_row{margin-bottom:10px;clear:both;margin-top:10px;height:48px;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneLight/menuLeft.png) no-repeat left top;}
.nav{height:48px;line-height:48px;text-align:center;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneDark/menuRight.png) no-repeat right top;}
.nav a{font-size:0.9em;font-weight:bold;color:#ffffff;text-shadow: #616161 0px -1px 0px;font-family:"Helvetica Neue",Helvetica,Arial;text-decoration:none;padding:0 8px;}
.entry_row.h2 a{color:#93b0d5;font-size:1.4em;font-weight:bold;text-decoration:none;font-family:"Helvetica Neue",Helvetica,Arial;padding-left:5px;}
.post-date {background:#ffffff;color:#505c75;text-align:right;padding:10px 5px;border:solid 1px #bbbbbb;font-family:"Helvetica Neue",Helvetica,Arial;-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}
.author{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;border-top:solid 1px #bbbbbb;}
span.homePageImage{display:block;float:right;background:#ffffff;margin:20px 10px 0 0;border:solid 1px #bbbbbb;-moz-border-radius: 5px;-webkit-border-radius: 5px;}
.homePageImage img{margin:2px;}
.entry_row.h2.homePageImage a{margin:0;padding:0;}
.homeCategoryHeader_row h3{margin-top:10px;}
.entry_row.excerpt_row{}
.entry_row.h2 a{display:block;margin-top:10px;margin-bottom:10px;}
.entry_row.excerpt,.entry_row.readmore{padding:5px;background:#ffffff;border:solid 1px #bbbbbb;}
.entry_row.excerpt{padding-top:10px;}
.entry_row.readmore{padding:10px 5px 15px 5px;border-top:0;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}
<?php 
if($homeShowPostLink == true)
{
	//echo '.entry_row.h2.homePageImage{float:right;}';
	echo '.entry_row.h2{margin-top:5px;}';
	echo 'div.homePageImage{display:block;float:right;background:#ffffff;margin:20px 10px 0 0;border:solid 1px #bbbbbb;-moz-border-radius: 5px;-webkit-border-radius: 5px;}';
	echo 'span.post-date{margin:0 5px;}';
}
if($homeShowDate == true AND $homeShowExcerpt == true)
{
	echo '.entry_row.excerpt{}';
}
if($homeShowAuthor == true AND $homeShowExcerpt == true)
{
	echo '.entry_row.excerpt{border-top:0;}';
}

if($homeShowMore == true AND $homeShowExcerpt == true)
{
	echo '.entry_row.excerpt{border-bottom:0;}.entry_row.readmore{border-top:0;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}';
}
if($headerImage)
{
	echo '.headerImage #header{margin-bottom:10px;}#header{height:auto;background:none;margin:0;padding:0;border:none;}#header a{margin:0;padding:0;}';
}
if($homeShowDate == false AND $homeShowAuthor == true)
{
	echo '.author{-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}';
} else if($homeShowDate == false AND $homeShowExcerpt == true)
{
	echo '.entry_row.excerpt{-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}';
}
if($homeShowExcerpt == true AND $homeShowMore == false)
{
	echo '.entry_row.excerpt{padding-bottom:15px;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}';
}
?>

.author.singlepost{-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;padding:10px 5px;}
.postimagerow{float:right;}
.postimage{background:#ffffff;padding:10px 5px 0 0;border-right:solid 1px #bbbbbb;}
.entry_row.singlepost{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;}
.postTags{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;}
.postmetadata.alt{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;}
.postmetadata.commentsTitle{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;}
.postmetadata.commentCount0{border-bottom:solid 1px #bbbbbb;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}

.postmetadata.commentAuthor{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;}
.postmetadata.commentDate{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;}
.postmetadata.commentContent{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px 5px 15px 5px;}
.postmetadata.commentContent.last{border-bottom:solid 1px #bbbbbb;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}
.postNextPrev{background:#ffffff;border:solid 1px #bbbbbb;border-width:0 1px 1px;padding:5px 5px 15px 5px;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}
.postNextPrev a{margin-right:10px;}
.postBack{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;}

.commentTitle{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;border-top:solid 1px #bbbbbb;-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}
.commentTitle_notice{background:#ffffff;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;padding:5px;}
#f_submit{border-bottom:solid 1px #bbbbbb;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}

.navigation{display:block;margin-top:10px;width:100%;}
.search.navigation{margin-left:5px;margin-right:5px;}
.navigation.archiveNavigation_row{display:block;width:100%;}
.navigation .home{margin-left:20px;float:left;display:block;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneLight/home.png) no-repeat 0 0;width:71px;height:29px;}
.navigation .home a{display:block;width:100%;height:100%;text-indent:-9000px;}
.navigation .previous{float:left;display:block;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneLight/previous.png) no-repeat 0 0;width:80px;height:29px;}
.navigation .previous a{display:block;width:100%;height:100%;text-indent:-9000px;}
.navigation .next{position:absolute;right:5px;float:right;display:block;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneLight/next.png) no-repeat 0 0;width:60px;height:29px;}
.navigation .next a{display:block;width:100%;height:100%;text-indent:-9000px;}

.wa404.entry_row{margin:10px 5px;background:#ffffff;border:solid 1px #bbbbbb;padding:5px;-moz-border-radius:10px;-webkit-border-radius:10px;}

.entry_row.header.page_row{margin-top:20px;}
.entry_row.page {background:#ffffff;padding:5px;border:solid 1px #bbbbbb;border-width:0 1px;}
.entry_row.header.page{border:solid 1px #bbbbbb;border-width:1px 1px 0;-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}
.last.entry_row.page{border-bottom:solid 1px #bbbbbb;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}

.entry_row.page_notice{margin:0 5px;background:#ffffff;padding:5px;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;}

.postmetadata.categories{background:#ffffff;padding:5px;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;}
.postmetadata.tags{background:#ffffff;padding:5px;border-left:solid 1px #bbbbbb;border-right:solid 1px #bbbbbb;}
<?php 

if(get_option('architect_search_showcategories'))
{
	echo '.postmetadata.categories{padding-bottom:10px;border-bottom:solid 1px #bbbbbb;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}';
	echo '.search.post-date_row .post-date{border-bottom:0;}';
} else if(get_option('architect_search_showtags'))
{
	echo '.postmetadata.tags{padding-bottom:10px;border-bottom:solid 1px #bbbbbb;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}';
	echo '.search.post-date_row .post-date{border-bottom:0;}';
} else
{
	echo '.search.post-date_row .post-date{-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}';
}
if($homeShowAuthor)
{
	echo '.author_row.search .author{border-bottom:solid 1px #bbbbbb;-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}';
	echo '.search.post-date_row .post-date{border-top:solid 1px #bbbbbb;-moz-border-radius-topright:0px;-webkit-border-top-right-radius:0px;-moz-border-radius-topleft:0px;-webkit-border-top-left-radius:0px;}';
}
?>

.postTop{background:#ffffff;padding:0;border:solid 1px #bbbbbb;border-width:1px 1px 0;-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}

<?php if($footerText == true):?>
#footer{margin-top:15px;text-align:center;color:#c6c6c5;height:76px;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneLight/footer_bg.png) repeat-x 0 0;}
#footer .words{padding-top:28px;}
#footer a{color:#c6c6c5;}
#switchToDesktop{background:#000000;color:#c6c6c5;text-align:center;clear:both;}
<?php else:?>
#switchToDesktop{margin-top:15px;line-height:76px;text-align:center;color:#c6c6c5;height:76px;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/iphoneLight/footer_bg.png) repeat-x 0 0;clear:both;}
<?php endif;?>

#switchToDesktop a{color:#c6c6c5;}
#switchToDesktop div{padding:0 5px 10px 5px;}

#f_s{float:left;}
#f_search input{margin:2px 0 0 5px;}

.postTitle_row{clear:both;}
.postTitle{padding-top:15px;padding-bottom:10px;}

.sidebarheader_row,.sidebar_row,.sidebarfooter_row{margin:0 5px;background:#ffffff;padding:0 5px;}
.sidebarheader_row{margin-top:15px;padding-top:5px;border:solid 1px #bbbbbb;border-width:1px 1px 0;-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}
.sidebar_row{border:solid 1px #bbbbbb;border-width:0 1px;}
.sidebarfooter_row{margin-bottom:15px;border:solid 1px #bbbbbb;border-width:0 1px 1px;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}
.sidebarheader h2{font-size:1.2em;padding-top:10px;}
.sidebar h2{font-size:1.1em;padding-top:5px;}

.navigation.archiveNavigation:after,.navigation_row:after {content: ".";display: block;clear: both;visibility: hidden;line-height: 0;height: 0;}
.navigation.archiveNavigation,.navigation_row {display: inline-block;}
html[xmlns] .navigation.archiveNavigation,html[xmlns] .navigation_row {display: block;}
* html .navigation.archiveNavigation, *html .navigation_row {height: 1%;}