body.body{font-size:14px;font-size:14px !important;font-family:arial;background:#f5f1e9 url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/paper/bg.jpg) repeat 0 0;border-top:solid 5px #000000;color:#efefef;}
a{color:#c1834c;font-weight:bold;}

#header{padding:15px 5px 10px 5px;font-family:times, "Times New Roman", times-roman, georgia, serif;text-align:center;color:#000000;text-shadow: #fff9f3 2px 2px 2px;background:none;}
#header a{color:#000000;text-shadow: #fff9f3 2px 2px 2px;background:none;}
.description{color:#000000;text-shadow: #fff9f3 2px 2px 2px;}

.nav{height:20px;font-size:1.1em;margin:5px 0;padding:5px 0;border-top:solid 2px #c1834c;background:#c1834c url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/paper/menu_bg.jpg) repeat-x 0 0;color:#19100b;text-align:center;border-bottom:solid 2px #beac9c;}
.nav a{color:#ffffff;padding-left:5px;font-weight:bold;background:none;text-decoration:none;}

.entry_row{padding-bottom:5px;}
.entry_row.h2{padding-left:5px;padding-top:15px;}
.entry_row.h2.imagePreview{float:left;display:block;margin-bottom:5px;padding-left:0;padding-top:0;}
.homePageImage{float:right;display:block;border:solid 3px #c1834c;-moz-border-radius:5px;-webkit-border-radius:5px;margin-right:3px;margin-bottom:5px;}
.entry_row.excerpt_row,.entry_row.readmore,.author{clear:both;}
.entry_row.h2 a,.postTitle,.entry_row h2{background:none;color:#000000;font-family:times, "Times New Roman", times-roman, georgia, serif;font-size:1.4em;font-weight:bold;text-shadow: #fff9f3 2px 2px 2px;}
.entry_row h3,.entry_row h4{color:#000000;text-shadow: #735d4a 2px 2px 2px;}
.post-date{padding-bottom:0;color:#5a411c;text-shadow: #806b4c 2px 2px 2px;text-transform:uppercase;font-weight:bold;}

.entry_row.excerpt{margin:5px 0;padding:10px 5px 5px;background:#ffffff;border-bottom:solid 2px #7f7b73;color:#605e5e;}
.entry_row.readmore{margin:5px 0;padding:5px 5px 10px 5px;background:#ffffff;border-bottom:solid 2px #7f7b73;color:#605e5e;}
.entry_row.readmore a{color:#9f3713;font-weight:bold;}

.navigation.archiveNavigation_row,.navigation.archiveNavigation{display:block;}
.navigation_row{padding-left:5px;}

.postimage{text-align:center;margin:5px 0 10px 0;}
.postTitle{padding-left:5px;}
.entry_row.excerpt,.entry_row.singlepost,.postTags,.postmetadata.alt,.postimage,.entry_row.page,.postmetadata.waplsmall.commentlist.even,.postmetadata.waplsmall.commentlist.odd{background:#ffffff;border-bottom:solid 3px #7f7b73;color:#605e5e;padding:5px;}

.search,.commentTitle_row label,.commentTitle,.author,.homeCategoryHeader,.homeCategories,.entry_row.pagetitle,.entry_row h2,.navHome,
	.postmetadata.tags,.postmetadata.categories,.post-date_row,.postmetadata.commentsTitle{padding-left:5px;}
#s,#search,.commentTitle_row input,.commentTitle_row textarea{margin:5px 0 10px 5px;border:solid 2px #7f7b73;border-width:1px 2px 2px 1px;padding:5px;}
.search h3,.postmetadata h3,.commentTitle h3,.homeCategoryHeader h3{color:#000000;text-shadow: #735d4a 2px 2px 2px;}

label,input,textarea,select{margin-left:5px;}
.entry_row input,.entry_row textarea,.entry_row select{border:solid 2px #1c1b1c;border-width:1px 2px 2px 1px;padding:5px;}

#footer{background:#000000;border-top:solid 1px #835939;padding:10px 5px;color:#aaaaaa;}
#switchToDesktop{background:#000000;color:#aaaaaa;padding-left:5px;}
<?php
if(get_option('architect_home_firstimage'))
{
	echo '.entry_row.h2.imagePreview{width:'.((100-$homepagescale)-10).'%;}';
}

if(get_option('architect_use_headerimage'))
{
	echo '#header{height:auto;background:none;margin:0;padding:0;border:none;}#header a{margin:0;padding:0;}';
}
if($getShowExcerpt AND $getReadMore)
{
	echo '.entry_row.excerpt_row{padding-bottom:0;}';
	echo '.entry_row.excerpt{margin-bottom:0;border-bottom:0;}';
	echo '.entry_row.readmore{margin-top:0;}';
} else if($getReadMore)
{
	echo '.entry_row.readmore{padding-bottom:5px;background:#ffffff;}';
}
?>
.sidebarheader_row,.sidebar_row,.sidebarfooter_row{padding:0 5px;color:#605E5E;background:#ffffff;}
.sidebarheader_row{margin-top:10px;padding-top:5px;}
.sidebar_row{}
.sidebarfooter_row{margin-bottom:15px;border-bottom:2px solid #7F7B73;}
.sidebarheader h2{font-size:1.2em;padding-top:10px;margin:0;color:#000000;}
.sidebar h2{font-size:1.1em;padding-top:5px;margin:0;padding-bottom:5px;color:#000000;}