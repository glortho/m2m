=== WP-Slimbox2 Plugin ===
Contributors: malcalevak
Donate link: http://transientmonkey.com/wp-slimbox2
Tags: slimbox, slimbox2, lightbox, jQuery, picture, photo, image, overlay, display, lightbox2
Requires at least: 2.8
Tested up to: 2.9.2
Stable Tag: 1.0.3.2

An WordPress implementation of the Slimbox2 javascript.

== Description ==

A WordPress implementation of the stellar Slimbox2 script by Christophe Beyls (an enhanced clone of the Lightbox script) which utilizes the jQuery library to create an impressive image overlay with slide-out effects.

Almost, if not all, options are configurable from the administration panel. For more on the settings and what they do check out the <a href="http://www.digitalia.be/software/slimbox2/" title="Slimbox 2, the ultimate lightweight Lightbox clone for jQuery">Slimbox2</a> page.

Support forums are generously hosted by Ryan Hellyer of PixoPoint, <a href="http://pixopoint.com/forum/index.php?board=6.0">here</a>.

Recent Changes in v1.0.3.2:<br />
1.  Fix for defaults in new installs.<br /><br />

Recent Changes in v1.0.3.1:<br />
1.  Forgot to commit one of the RTL specific changes.<br /><br />

Recent Changes in v1.0.3:<br />
1.  Updated to Version 2.0.4 of Slimbox.<br />
2.  Added encodeURI to autoload script to automatically fix URLs containing invalid characters.<br />
3.	All "fixed" CSS moved to static CSS files, addition of RTL specific CSS.<br />
4.  Addition of Belarusian/&#1041;&#1077;&#1083;&#1072;&#1088;&#1091;&#1089;&#1082;&#1110; Translation.<br />
5.  Addition of Chinese/&#20013;&#25991; Translation.<br />
6.  Update of Spanish/Espa&#241;ol and Dutch/Nederlandse Translations.<br />
7.  Update of German/Deutsch Translation.<br />
8.	Addition of Localization Tracking (see FAQ for details).<br />
9.	Minor fixes/tweaks.<br />


== Installation ==

After you've downloaded and extracted the files:

1. Upload the complete `WP-Slimbox2` folder to the `/wp-content/plugins/` directory<br />
2. Activate the plugin through the 'Plugins' menu in WordPress<br />
3. Visit the "WP-Slimbox2" page in your WordPress options menu to configure any advanced settings.<br />
5. Manually add the <code>rel="lightbox"</code> attribute to any link tag to activate the lightbox or <code>rel="lightbox-imagesetname"</code> for an image set, using the title attribute to store a caption. Alternatively you may use the autoload option to automatically prepare links to images and additionally enable picasaweb and flickr integration to easily utilize their albums.<br />

== Frequently Asked Questions ==

= Does Slimbox2 support the lightbox effect on pages and videos? =

No. As stated in the script creators FAQ, Slimbox was designed to display images only, to be simple and to have the smallest code. <br />

= What kind of grouping does autoload utilize? =
Autoload has been modified to group all images in a Wordpress post if the theme places posts inside a div with class="post". If the images are instead on a page they will all be grouped together. If you want individual group sets it is recommend you instead manually insert 'rel="lightbox-groupname"' inside your hyperlinks to specify your groups.

= Why do I need WordPress 2.8+? =

The Javascript requires jQuery 1.3+ which wasn't included in WordPress until 2.8. If you're using something to override the included jQuery with a newer version (a feature I may add at a later date) it should be compatible from 2.1+ since I believe that was when wp_enqueue_script() was implemented.<br />

= Why can't the plugin do X, Y or Z? =

Either the Javascript doesn't support it, or I haven't gotten around to adding it.<br />

= Why isn't the plugin in my language? Could I contribute a translation? =

I only know English, but as of v.0.9.4 the plugin supports localization using PO and MO files, just like WordPress.<br />
A copy of the POT file to use in your translations can be found in the languages directory as wp-slimbox2.pot.<br />
If you're willing to provide a translation I'd be more than happy to include it. The NEXT, PREV, and Close buttons can be translated as well.<br />
If you've translated the plugin or would like to find out more please let me know by posting on our <a href="http://pixopoint.com/forum/index.php?topic=1383.0">support forums</a>.<br />

= Why should I use this plugin? =

You want Lightbox or Slimbox effects using the jQuery library, and don't want any sort of "ad".<br />
You want complete control over all the javascript settings from the admin page.<br />

= What is Localization Tracking? =

To satisfy my own curiosity regarding how many people are using a non-English version of the plugin I've written a small script, statTrack.php. During activiation of the plugin it submits the localization of the WordPress install to my server for recording. It will only do this once, and no other information is transmitted. To disable it, you can safely delete statTrack.php and the plugin should function normally.<br />

= What if I have other questions that haven't been answered? =

Please try our <a href="http://pixopoint.com/forum/index.php?board=6.0">support forums</a>, and read the Slimbox creators <a href="http://code.google.com/p/slimbox/wiki/FAQ">FAQ</a>.<br />

== Screenshots ==

1. Administration interface in WordPress 2.7
2. Overlay effect.

== History ==
Version 1.0.3.1 - May-04-2010:<br />
	Fix for defaults in new installs.<br />
Version 1.0.3.1 - May-03-2010:<br />
	Forgot to commit one of the RTL specific changes.<br />
Version 1.0.3 - May-02-2010:<br />
	Updated to Version 2.0.4 of Slimbox.<br />
	Added encodeURI to autoload script to automatically fix URLs containing invalid characters.<br />
	All "fixed" CSS moved to static CSS files, addition of RTL specific CSS.<br />
	Addition of Belarusian/&#1041;&#1077;&#1083;&#1072;&#1088;&#1091;&#1089;&#1082;&#1110; Translation.<br />
	Addition of Chinese/&#20013;&#25991; Translation.<br />
	Update of Spanish/Espa&#241;ol and Dutch/Nederlandse Translations.<br />
	Update of German/Deutsch Translation.<br />
	Addition of Localization Tracking (see FAQ for details).<br />
	Minor fixes/tweaks.<br /><br />
Version 1.0.2 - Jan-21-2010:<br />
	Fixed IE Javascript issue.<br />
	Fixed potential XSS vulnerability and rare inability to update.<br />
	Addition of Turkish/T&uuml;rk&ccedil;e Translation.<br />
	Update of French/Fran&ccedil;ais Translation.<br /><br />
Version 1.0.1 - Jan-20-2010:<br />
	To accomodate some installs the global options variable was removed.<br />
	To repair a small issue regarding selectors, .closest was used instead of .parents, bumping the jQuery requirement to 1.3, in turn bumping the WP requirement to 2.8. (If you insist on using an older version of WP, you can either manually upgrade jQuery, or switch back to using .parents, and specifically choose the selector value you want to use).<br /><br />
Version 1.0 Beta - Jan-19-2010:<br />
	Addition of options to select caption source, render the caption as a hyperlink to the image, control autoload grouping element, and disable the effect on mobile phones.<br />
	Initialization is now encapsulated within a function (usable in Infinite Scroll plugin, etc)<br />
	All Javascript is now static, no more dynamic files.<br />
	All Javascript and CSS compressed using YUI Compressor.<br /><br />
Version 0.9.7 Beta - Apr-21-2009:<br />
	Addition of farbtastic overlay color select.<br />
	Automatic key code recognition.<br />
	Addition of French/Fran&ccedil;ais and Dutch/Nederlandse languages.<br />
	Options transferred to WPlize class, less database calls.<br />
	Flickr and Picasaweb images now properly load Slimbox settings.<br />
	Minor typographical corrections.<br /><br />
Version 0.9.6 Beta - Feb-19-2009:<br />
	Added rudimentary German/Deutsch translation - thanks Laws<br />
	Tiling Next/Prev Links in Safari Fix - thanks monodistortion<br />
	Switch from wp-blog-header to wp-load, may resolve issue on certain servers that fail to properly serve dynamic JS and CSS<br /><br />
Version 0.9.5 Beta - Feb-01-2009:<br />
	Added minor IE6 fix to prevent tiling of next and previous images in a unique scenario.<br />
	Espa&#241;ol/Spanish language typo correction.<br />
	Updated to Slimbox 2.02 (and adjusted version # accordingly, see Slimbox website for more details)<br />
	Support for RTL languages added (proper image progression and button display)<br />
	Caching/compression reenabled on javascript - cache for one year, or until version change which occurs on option update.<br />
	Support options on autoloaded image files (ie .jpg?w=400 now is properly detected)<br /><br />
Version 0.9.4.1 Beta: Removed caching of autload script, for real this time. - v0.9.4.1 - Jan-24-2009<br /><br />
Version 0.9.4 Beta: Localization support implemented. Currently only Espa&#241;ol/Spanish provided. See FAQ to contribute other languages. Removed caching of autload script, at least for now. - v0.9.4 - Jan-24-2009<br /><br />
Version 0.9.3 Beta: Flickr and Picasaweb Integration, Slimbox 2.01, maintenance mode, autogrouping by post/page, compression and caching - Jan-14-2009<br /><br />
Version 0.9.2.3 Beta: Bug fix. Autoload wasn't loading options. - v0.9.2.3 - Jan-08-2009<br /><br />
Version 0.9.2.2 Beta: Emergency Admin for minor overlay opacity setting error - Jan-07-2009<br /><br />
Version 0.9.2.1 Beta: Emergency JS Fix - Jan-07-2009<br /><br />
Version 0.9.2 Beta: Addition of option to change the overlay color - Jan-07-2009<br /><br />
Version 0.9.1 Beta: Addition of option to enable automatically applying to all image links (png,jpg,gif) - Jan-06-2009<br /><br />
Version 0.9 Beta: Intial release - Jan-05-2008<br /><br />

= Credits =

Thanks to the following for help with the development of this plugin:<br />

* <a href="http://www.digitalia.be/software/slimbox2">Christophe Beyls</a> - Creator of the Slimbox2 Javascript<br />
* <a href="http://gsgd.co.uk/sandbox/jquery/easing/">George McGinley Smith</a> - Creator of the jQuery Easing Plugin Javascript<br />
* <a href="http://acko.net/dev/farbtastic/">Steven Wittens</a> - Creator of the jQuery Farbtastic colorpicker Javascript<br />
* <a href="http://pixopoint.com">Ryan Hellyer</a> - For spurring my interest in WordPress plugins by welcoming my assistance on his <a href="http://pixopoint.com/multi-level-navigation/">Multi-level Navigation plugin</a> and for hosting our <a href="http://pixopoint.com/forum/index.php?board=6.0">support forums</a>.<br />
* Spi for code suggestion to autogroup items by post.<br />
* <a href="http://nv1962.net/">nv1962</a> - Suggestion to implement localization and Spanish/Espa&#241;ol and Dutch/Nederlandse translations.<br />
* Laws for German/Deutsch localization.<br />
* monodistortion  for CSS tweaks to prevent tiling of images.<br />
* Jandry for the French/Fran&ccedil;ais translation.
* <a href="http://www.serhatyolacan.com">Serhat Yola&ccedil;an</a> for the Turkish/T&uuml;rk&ccedil;e translation.
* <a href="http://pc.de">Marcis G.</a> for the Belarusian/&#1041;&#1077;&#1083;&#1072;&#1088;&#1091;&#1089;&#1082;&#1110; translation.
* <a href="http://www.easespot.com">easespot</a> for the Chinese/&#20013;&#25991; translation and FunDo for additional assistance.
* Anyone else I forgot to mention who's made a suggestion or provided me with ideas.<br />
