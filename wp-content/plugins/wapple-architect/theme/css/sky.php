body{font-size:14px;font-size:14px !important;background:#71c1f2;font-family:verdana;}
a{color:#0C739C;}
h1,h2,h3,h4,h5,h6{color:#0C739C;margin-left:5px;}
.entry_row{padding-bottom:0;}

#header{text-align:center;border-top:solid 5px #10a1dc;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/sky/header_bg.jpg) repeat-x 0 0;height:75px;}
#header a{display:block;margin:10px 5px 0 5px;font-weight:bold;color:#0C739C;border:solid 0px #ffffff;-moz-border-radius:10px;-webkit-border-radius:10px;}
#header a:hover{border:solid 0px #ffffff;}

.description{color:#ffffff;}

#footer{border-top:solid 5px #a5d10f;border-bottom:solid 10px #69a54e;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/sky/footer_bg.jpg) repeat-x 0 0;height:75px;}
#footer .words{margin-top:30px;color:#ffffff;margin-left:5px;}

#switchToDesktop{background:#69a54e;color:#ffffff;}
#switchToDesktop div{margin-left:5px;}

.nav{text-align:center;background:url(<?php echo WP_PLUGIN_URL.'/'.get_wapl_plugin_base();?>/theme/images/sky/menu_bg.jpg) repeat-x left top;height:30px;font-size:1.1em;padding:10px 5px 0 5px;}
.nav a{color:#ffffff;}

.entry_row.h2{margin-top:10px;padding-left:5px;}
.entry_row.h2 a{font-weight:bold;font-size:1.1em;color:#0C739C;}
.author{clear:both;padding-left:5px;}
.post-date{color:#525252;font-size:0.9em;font-style:italic;}

.entry_row.h2.imagePreview{float:left;display:block;margin-bottom:5px;}
.homePageImage{float:right;display:block;border:solid 3px #10a1dc;-moz-border-radius:5px;-webkit-border-radius:5px;margin-right:3px;margin-bottom:5px;}

.entry_row.excerpt_row,.entry_row.readmore{clear:both;}

.entry_row.excerpt,.entry_row.singlepost,.postTags,.postmetadata.alt,.postTitle,.postimage,.entry_row.page,.postmetadata.waplsmall.commentlist.even,.postmetadata.waplsmall.commentlist.odd{background:#ffffff;border:solid 3px #71c1f2;-moz-border-radius:5px;-webkit-border-radius:5px;padding:5px;margin:5px 0;}
.postTitle{color:#10a1dc;text-align:center;}
.postimage{text-align:center;}
.entry_row.readmore{padding-left:5px;}

label{color:#0C739C;margin-left:5px;}
input,textarea{border:solid 2px #0C739C;-moz-border-radius:3px;-webkit-border-radius:3px;padding:3px;width:90%;width:90% !important;margin-bottom:10px;margin-left:5px;}
#submit,#search,input[type="submit"]{width:auto;width:auto !important;}

.navigation.archiveNavigation{padding-left:5px;}

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
	echo '.entry_row.excerpt{margin-bottom:0;border-bottom:0;-moz-border-radius-bottomright:0;-webkit-border-bottom-right-radius:0;-moz-border-radius-bottomleft:0;-webkit-border-bottom-left-radius:0;}';
	echo '.entry_row.readmore{margin:0 3px;padding-bottom:5px;background:#ffffff;-moz-border-radius-bottomright:5px;-webkit-border-bottom-right-radius:5px;-moz-border-radius-bottomleft:5px;-webkit-border-bottom-left-radius:5px;}';
} else if($getReadMore)
{
	echo '.entry_row.readmore{margin:3px 3px 0 3px;padding-bottom:5px;background:#ffffff;-moz-border-radius:5px;-webkit-border-radius:5px;}';
}
?>
.sidebarheader_row,.sidebar_row,.sidebarfooter_row{margin:0 3px;background:#ffffff;padding:0 5px;}
.sidebarheader_row{margin-top:10px;padding-top:5px;border:solid 1px #71C1F2;border-width:1px 1px 0;-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}
.sidebar_row{border:solid 1px #71C1F2;border-width:0 1px;}
.sidebarfooter_row{margin-bottom:15px;border:solid 1px #71C1F2;border-width:0 1px 1px;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}
.sidebarheader h2{font-size:1.2em;padding-top:10px;color:#0C739C;margin:0;}
.sidebar h2{font-size:1.1em;padding-top:5px;color:#0C739C;margin:0;}