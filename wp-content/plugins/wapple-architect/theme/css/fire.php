body{color:#dd3b33;background:#494646;font-size:14px;}
a{color:#ffffff;}
a:hover{color:#fdf1db;}
td{padding-left:2px;}
#header{height:50px;padding:10px 2px;line-height:50px;text-align:center;background:#585858;border-bottom:solid 1px #aaaaa9;}
.headerImage #header{background:none;padding:0;border-bottom:none;}
#header a{color:#fdf1db;font-size:1.8em;font-weight:bold;text-decoration:none;border-bottom:solid 1px #aaaaa9;}
#header a:hover{background:none;border-bottom:solid 1px #ffffff;}

.description{margin-bottom:5px;}

.nav{text-align:center;padding:5px 0;color:#dd3b33;font-size:0.9em;border-top:solid 1px #aaaaa9;}
.nav a{color:#ffffff;padding:2px 5px;}
.nav a:hover{color:#fdf1db;}
.navigation td{padding-left:2px;}

.entry_row{padding-bottom:0;}
.entry_row.h2 {background-color:#585858;padding:4px 2px;border-bottom:solid 1px #aaaaa9;}
.entry_row.h2 a{color:#ffffff;padding:0 5px;}
.entry_row.h2 a:hover{background-color:#585858;color:#fdf1db;}
.entry_row.h2.imagePreview_wapl_link{border-bottom:none;}
.entry_row.h2.imagePreview .post-date{color:#fdf1db;}
.entry_row.readmore{padding:10px 2px 5px 2px;}
.entry_row.readmore_wapl_link{font-size:0.8em;font-style:italic;}

.entry_row.h2.imagePreview{clear:both;}
.entry_row.h2.imagePreview{float:left;display:block;margin-bottom:5px;padding-left:0;padding-top:0;}
.homePageImage{float:right;display:block;margin-right:3px;margin-bottom:5px;}
.entry_row.excerpt_row,.entry_row.readmore,.author{clear:both;}

.post-date{padding-top:5px;}

#footer{background:#585858;height:30px;padding:5px 0;border-top:solid 1px #aaaaa9;color:#0E273D;text-align:center;}
#footer a,#switchToDesktop a{color:#ffffff;}
#footer a:hover,#switchToDesktop a:hover{color:#fdf1db;}
#switchToDesktop{color:#dd3b33;text-align:center;background:#585858;}
<?php
if(get_option('architect_use_headerimage'))
{
	echo '#header{height:auto;background:none;margin:0;padding:0;border:none;}#header a{margin:0;padding:0;}';
}
if(get_option('architect_home_firstimage'))
{
	echo '.entry_row.h2.imagePreview{background-color:#585858;border-bottom:solid 1px #aaaaa9;width:'.((100-$homepagescale)-10).'%;}';
	echo '.entry_row.h2{background:none;border:none;}';
}
?>

.sidebarheader_row,.sidebar_row,.sidebarfooter_row{}
.sidebarheader_row{margin-top:10px;}
.sidebar_row{}
.sidebarfooter_row{margin-bottom:15px;}
.sidebarheader h2{font-size:1.2em;padding-top:10px;color:#FDF1DB;border-bottom:1px solid #AAAAA9;}
.sidebar h2{background:#585858;border-bottom:1px solid #AAAAA9;color:#FDF1DB;font-size:1.1em;}
