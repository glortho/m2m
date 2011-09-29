<?php /* Arclite/digitalnature */ ?>

<!-- 2nd column (sidebar) -->
<div class="col2">
 <ul id="sidebar">

    <?php if(get_arclite_option('sidebar_categories'))  { ?>
    <li class="block">
      <!-- sidebar menu (categories) -->
      <ul class="menu">
		<?php if(get_option('arclite_jquery')=='no') {
          echo preg_replace('@\<li([^>]*)>\<a([^>]*)>(.*?)\<\/a>@i', '<li$1><a class="fadeThis"$2>$3</a>', wp_list_categories('show_count=0&echo=0&title_li='));
        } else {
          $out = preg_replace('@\<li([^>]*)>\<a([^>]*)>(.*?)\<\/a> \(\<a ([^>]*) ([^>]*)>(.*?)\<\/a>\)@i', '<li $1><a class="fadeThis"$2>$3</a><a class="rss tip" $4></a>', wp_list_categories('show_count=0&echo=0&title_li=&feed=XML&orderby=count&order=desc')); 
			$out = str_replace( "Best in Chow</a>" , "<img align='center' src=\"http://mastomillers.com/wp-content/themes/arclite/images/medal-icons25.png\" width='23' height='23' alt='Best' border='0' /> Best in Chow</a>", $out ) ;
			echo $out ;

		}
         if (function_exists('xili_language_list')) xili_language_list(); ?>
      </ul>
      <!-- /sidebar menu -->
    </li>
    <?php } ?>

	<li class="block">
		      <!-- box -->
		      <div class="box">
		       <div class="titlewrap"><h4><span>Browse</span></h4></div>      
		       <div class="wrapleft">
		        <div class="wrapright">
		         <div class="tr">
		          <div class="bl">
		           <div class="tl">
		            <div class="br the-content" style="min-height: 20px">
		            	<select name="tag-dropdown2" onchange="document.location.href=this.options[this.selectedIndex].value;">
							<option value="#">Restaurants</option>
							<?php dropdown_tag_cloud('number=0&order=asc&search=Restaurant'); ?>
						</select>
						<br />
						<select name="tag-dropdown3" onchange="document.location.href=this.options[this.selectedIndex].value;">
							<option value="#">Cuisines</option>
							<?php dropdown_tag_cloud('number=0&order=asc&search=Cuisine'); ?>
						</select>
						<br />
						<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
							<option value="#">Neighborhoods</option>
							<?php dropdown_tag_cloud('number=0&order=asc&search=Neighborhood'); ?>
						</select>
						<br />
						<select name="tag-dropdown5" onchange="document.location.href=this.options[this.selectedIndex].value;">
							<option value="#">Rating</option>
							<?php dropdown_tag_cloud('number=0&order=asc&search=Rating'); ?>
						</select>
						<br />
						<select name="tag-dropdown4" onchange="document.location.href=this.options[this.selectedIndex].value;">
							<option value="#">Other</option>
							<?php dropdown_tag_cloud('number=0&order=asc'); ?>
						</select>
		            </div>
		           </div>
		          </div>
		         </div>
		        </div>
		       </div>
		      </div>
		      <!-- /box -->
		    </li>

    <?php 	/* Widgetized sidebar, if you have the plugin installed. */
    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
    <?php // wp_list_bookmarks('category_before=&category_after=&title_li=&title_before=&title_after='); ?>
 

   <li class="block">
      <!-- box -->
      <div class="box">
       <div class="titlewrap"><h4><span><?php _e('Archives','arclite'); ?></span></h4></div>      
       <div class="wrapleft">
        <div class="wrapright">
         <div class="tr">
          <div class="bl">
           <div class="tl">
            <div class="br the-content">
             <ul>
              <?php wp_get_archives('type=monthly&show_post_count=1'); ?>
             </ul>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
      <!-- /box -->
    </li>

    <li class="block">
      <!-- box -->
      <div class="box">
       <div class="titlewrap"><h4><span><?php _e('Meta','arclite'); ?></span></h4></div>
       <div class="wrapleft">
        <div class="wrapright">
         <div class="tr">
          <div class="bl">
           <div class="tl">
            <div class="br the-content">
             <ul>
              <?php wp_register(); ?>
              <li><?php wp_loginout(); ?></li>
              <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
              <li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
              <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
              <?php wp_meta(); ?>
             </ul>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
      <!-- /box -->
    </li>
    <?php endif; ?>
 </ul>

	<div style="text-align:center">
	 <script src="http://static.ak.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US" type="text/javascript"></script><script type="text/javascript">FB.init("4ec6f1327fc776b8538c48fd6c13ff03");</script><fb:fan profile_id="114811848207" stream="" connections="8" width="248"></fb:fan><div style="font-size:8px; padding-left:10px"><a href="http://www.facebook.com/pages/Charlottesville-VA/Mas-to-Millers/114811848207">Mas to Millers</a> on Facebook</div>
	</div>
	
</div>
<!-- /2nd column -->
