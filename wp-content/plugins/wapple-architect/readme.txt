=== Wapple Architect Mobile Plugin for WordPress ===
Contributors: rgubby
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9077801
Tags: mobile, mobilizing, mobilizing wordpress, wordpress mobile, wordpress mobile plugin, wordpress mobile theme, coding for mobile web, mobilize websites and blogs
Requires at least: 2.0
Tested up to: 3.1.1
Stable tag: 3.9.3

Wapple Architect Mobile Plugin for Wordpress is a plugin that allows you to mobilize your blog in minutes.

== Description ==

Wapple Architect Mobile Plugin for Wordpress is a plugin that allows you to mobilize your blog in minutes.

Every single mobile device is detected and all aspects of your blog are tailored to the visiting handset. Sites aren't dumbed down to the lowest common denominator but instead use the features and functionality that advanced phones offer. 

Devices are detected by using Wapple's advanced web services instead of relying on inferior 3rd party tools. If you view your blog with a brand new, never before seen handset, it'll still work perfectly!

Any theme you've installed and have styled for web will be carried across to mobile giving you a consistent look and feel for each and every one of your visitors.

**Why it's different to other plugins:**

* Other mobile plugins for WordPress use a default mobile style which results in an inconsistent experience for your users, Wapple Architect Mobile plugin for WordPress retains the styling of your site from web to mobile.
* There's no redirection to a mobile version of the blog - URLs are exactly the same on web and mobile giving you the ability to promote and use one single domain!
* No transcoding happens here - the mobile version is written in WAPL (an advanced mobile markup language) that results in a completely tailored solution perfect for your mobile visitors.
* Other plugins try to replicate every single feature and plugin you've installed onto the mobile version. We know what mobile users want and have written this plugin with that in mind - the result is a far better user experience.

**Features**

* Dynamic resizing of images
* Retain SEO, preserve your URL structure and promote one single domain
* Mobile Advertising Integration: Admob & Google Adsense
* View stats on Mobile Page Impressions
* Fully compatible with WordPress MU
* Support for multi-lingual characters - even funny characters that make their way onto your blog (from a copy and paste from Word for example) are handled.
* Comment from mobile! Turn on the feature and your visitors can leave comments from their handset.
* Upload mobile specific header/footer images - resized on the fly to fit a visitors handset perfectly
* Place mobile friendly navigation links around your site to help users browse around your blog
* Advanced pagination - split up long posts into manageable chunks that make reading a post on mobile easier
* Any theme that you've installed will have its styles carried across to mobile giving you a consistent look and feel for all your visitors.
* Complete freedom over how you want to style your mobile site. We've done our best to make the mobile stylesheet as comprehensive as possible but no doubt there will be a few things you want to change - you can by editing a few settings.
* Control over almost every element on your mobile page:- change the size and quality of images on posts and pages, show tags and categories in different sections, you can even change the wording of certain elements on your site!
* Plus much much more! For a full feature list, visit the [plugin homepage](http://mobilewebjunkie.com/wordpress-mobile-plugin-install-guide-and-faq/)

Did you know that you can use your Wapple dev key to mobilize your WordPress control panel? By doing so you can write posts from your mobile as well as moderate comments and perform basic post/page/comment management. Download it from [http://wordpress.org/extend/plugins/wordpress-mobile-admin/](http://wordpress.org/extend/plugins/wordpress-mobile-admin/)
== Installation ==

1. To install through WordPress Control Panel:
	* Click "Plugins", then "Add New"
	* Enter "Wapple Architect" as search term and click "Search Plugins"
	* Click the "Install" link on the right hand side against "Wapple Architect Mobile plugin for WordPress"
	* Click the red "Install Now" button
	* Click the "Activate Plugin" link
	* Enter your Wapple Architect dev key into the control panel. You can get one from here [Wapple Dev Key Registration](http://wapple.net/register/plugins-signup.htm)
1. To download and install manually:
	* Upload the entire `architect` folder to the `/wp-content/plugins/` directory.
	* Activate the plugin through the `Plugins` menu in WordPress.
	* Enter your Wapple Architect dev key into the control panel. You can get one from here [Wapple Dev Key Registration](http://wapple.net/register/plugins-signup.htm)

The control panel of Wapple Architect is in `Settings` > `Wapple Architect` 
(on WordPress 2.3.3 and under, `Options` > `Wapple Architect`).

If you want to use the Wapple Architect Mobile Plugin with WordPress MU as a site-wide plugin, install the wapple-architect folder in the plugins directory and activate on a site-by-site basis.
 
== Screenshots ==

1. http://mobilewebjunkie.com screenshot-1.jpg
1. http://www.spignermohammed.com screenshot-2.jpg
1. http://blog.designyoursoul.com screenshot-3.jpg
1. http://www.awhiffoflemongrass.com screenshot-4.jpg
1. http://blog.themda.org screenshot-5.jpg
1. http://vgrepublic.com screenshot-6.jpg
1. http://robinmalau.com screenshot-7.jpg

== Frequently Asked Questions ==

= How do I get a dev key? =

Head over to [Wapple](http://wapple.net/register/plugins-signup.htm) and fill out the simple form, you should be able to get your dev key within a couple of minutes!

= Why doesn't the plugin work? I see the web version on my mobile! =

Have you entered your dev key into the Wapple Architect settings? 
If not, head over to Settings > Wapple Architect (or Options > Wapple Architect if you're on version 2.3.3 and under) and enter it into the "Dev Key" input box.

= Do I need SOAP and SimpleXML running for this plugin to work? =

In older versions of the plugin, you needed SOAP and SimpleXML, but not any more! From version 1.5.13, the dependancy on SimpleXML has been totally removed! You also do not need SOAP and can communicate with Wapple's web services via REST.

= How do I customize the header and/or CSS? =

If you want to upload a custom mobile header image, check out the settings area, it's in the section titled: "Basic Settings" and at the bottom there's a section called "Mobile Theme Settings" - your mobile stylesheet is in there!

You're free to customize any of these, infact, the more you customize the CSS, the better your site will look!

= I can't customize my CSS or upload a header/footer image! =

Check write permissions on the /wp-content/uploads/ folder, it needs to be writable!

== Changelog ==

= 3.9.3 =
* Added better handling of SOAP errors
* Added upgrade notification if over page impressions

= 3.9.2 =
* Added support for PrimePress

= 3.9.1 =
* Fixed issue with some title characters
* Fixed menu URL issue

= 3.9 =
* Fixed issue with random theme page templates not loading mobile version
* Fixed issue with absolute URLs
* Fixed issue with random characters in page menu titles
* No zooming on smart phones - not needed as page should render perfectly
 
= 3.8.4 =
* Fixed issue with an ndash character
* Fixed issue with pagination on some posts
* Added compatibility with WordPress 3.8.4

= 3.8.3 =
* Added compatibility with WordPress 3.8.3

= 3.8.2 =
* Fixed some function redeclaration errors

= 3.8.1 =
* Changed default option for showing excerpts on the homepage

= 3.8 =
* Changed default theme

= 3.7 =
* Added compatibility for SmartPhone Location Lookup Plugin

= 3.6 =
* Added compatibility with WordPress 3.0
* Fixed bug with foreign characters in comments

= 3.5.1 =
* Fixed bug with the mobile menu
* Fixed bug on a home page excerpt

= 3.5 =
* Added sidebar functionality - choose which widgets to show, which pages to show it and a sidebar header
* Added a few missing CSS placeholders
* Added a few more screenshots in to view pre-built themes
* Added gravatar support

= 3.4.1 =
* Fixed bug when a form item doesn't have a type

= 3.4 =
* Added better youtube video handling
* Fixed styling for div mode
* Images less than 75px wide don't get scaled

= 3.3 =
* Added Mobile stats

= 3.2 =
* Added 2 new iPhone styled themes
* Fixed issue with lists and links

= 3.1.1 =
* Fixed issue with foreign characters in the loop

= 3.1 =
* Added option to make home page image as a link
* Added option to remove normal links from home page
* Changed a few screenshots
* Fixed bug in menu element
* Fixed bug with "&" chars in footer
* Updated the WAPL scheme in wapl_builder.php

= 3.0.2 =
* Fixed bug with random HTML tags in post headings

= 3.0.1 =
* Turned off check for parent class scaling - causing issues

= 3.0 =
* Turn your mobile blog into a money making opportunity with these Mobile Advertisers:
* Admob
* Google Adsense
* Added compatibility with other plugins that use Simple HTML DOM
* Fixed bug with parent images and resizing
* Fixed bug with strong and em tags

= 2.3 =
* Added support for custom theme designs

= 2.2 =
* Fixed a random error when a wordsChunk tag was being converted to all lowercase

= 2.1 =
* Fixed small issue with comments not appearing in the correct format

= 2.0 =
* Added pre-designed themes
* Added ability to switch layout
* Added compatibility for every plugin that uses shortcodes - eg. download manager, contact form 7, powerpress 
* Added some extra classes for more styling
* Added full WPMU functionality for styling
* Compatible with WordPress 2.9

= 1.5.13 =
* Fixed error with captions in images not showing the correct image
* Compatible with PHP4
* Removed dependancy on SimpleXML
* Fixed issue with pagination

= 1.5.12 =
* Fixed issue with more missing functions in WP. Despite documentation saying it's there!

= 1.5.11 =
* Fixed issue with missing functions in WP < 2.8
* Added compatibility with WordPress 2.8.6

= 1.5.10 =
* Fixed issue with menus and strange characters
* Archives page now uses theloop element
* Fixed bug with images in a post showing an incorrect file extension

= 1.5.9 =
* Added better support for rogue HTML characters
* Added support for native OBJECT functions
* Fixed issue when images were inside form labels
* Fixed issue when pagination goes over an embedded image

= 1.5.8 =
* Completed all language, punctuation and mathematical symbol sets
* Fixed bug on comments on a post
* Added some help for mobile styling
* Fixed issue with dates not appearing in the right place if you had a preview image on the home page
* Fixed Smart YouTube bug

= 1.5.7.4 =
* Added compatibility with WordPress 2.8.5

= 1.5.7.3 =
* Added inline images for non-scaled images
* Fixed issue with foreign characters in the header
* Better handling of text

= 1.5.7.2 =
* Some pages were displaying an empty page - fixed
* Homepage template bug fix
* Fix with images trying to load files from file://

= 1.5.7.1 =
* Added support for Ozh' Admin Drop Down Menu
* Added support for XHTML Video Embed
* Added support for Smart YouTube
* Added support for turning off device detection (needed for WordPress Mobile Admin!)

= 1.5.7 =
* Added support for YouTube videos
* Added support for Japanese, Chinese, Korean, Hebrew, etc characters
* Removed multiple install scripts running when upgrading the plugin

= 1.5.6.2 =
* Fixed bug with missing function

= 1.5.6.1 =
* Fixed bug with template loader
* Fixed admin bug

= 1.5.6 =
* Fixed an issue with sub pages in WordPress menus
* Better form handling
* Added support for pages with alternative templates
* Fixed issue with links when using certain types of permalinks
* Fixed bug with transparency background colour on archive pages
* Made some performance improvements

= 1.5.5.2 =
* Bug fix for installing in sub-directories
* Fixed issue with footer image previews

= 1.5.5.1 =
* Fixed bug with page views

= 1.5.5 =
* Much better administration page
* Fixed bug with image transparency colour on the home page
* Fixed small bug with upper case image extensions
* Updated path to signup page
* Fixed a few random characters errors

= 1.5.4 =
* Better handling of comments

= 1.5.3 =
* Fixed further windows error when DIRECTORY_SEPARATOR is not set correctly
* Fixed header error with WTF
* Added support for password protected posts
* Added support for access keys
* Made some speed improvements in The Loop(TM)

= 1.5.2 =
* Fixed bug with windows / linux slash

= 1.5.1 =
* REST services now take priority over SOAP for better error handling
* Added compatibility with plugins that output to screen before they should do!
* Added full compatibility with WP Super Cache

= 1.5 =
* Added option: Configure your index page to have categories shown on home page
* Added support for French & German character sets
* Added option: Redirect site to a different URL
* Added option: Remove images from index page excerpt
* Added option: Turn post date on or off on home page
* Added option: Ability to define all english text in a different language - fully internationalized
* Added option: Have header image AND header text
* Added option: Show first image as thumbnail on home page
* Bug fix: Page headers appear at bottom
* Bug fix: Some pages were showing a "more" link without any content showing
* Bug fix: Fixed a random error when showing 2nd page
* Bug fix: A few characters were breaking the title, &raquo; and &laquo; to name 2
* Bug fix: Selecting menus with non-conforming html characters doesn't work
* Improved some areas of documentation

= 1.4.10 =
* Added support for Russian (cyrillic) character set 

= 1.4.9 =
* Added extra web service error handling
* Fixed bug with &copy; and &nbsp; characters

= 1.4.8 =
* Added option: Configurable menus - turn pages on or off on mobile
* Compatible with mobiready test.
* Fixed a few erroneous PHP/SOAP/Linux error messages
* Fixed return plugin path for NFS server setups with load balanced web servers where plugin path is not on web servers 

= 1.4.7 =
* Fixed WP bug when some titles/descriptions come back with quotes and some don't 

= 1.4.6 =
* Fixed bug with & in the blog title/description

= 1.4.5 =
* Added option: Display a different title or description on mobile
* Added support for WTF in mobile title and description 
* Added meta tags to the page
* Added some pre-configured classes to help you style up your site
* New style admin panel - easier to navigate

= 1.4.4 =
* Fixed bug with CURL communication

= 1.4.3 =
* Fixed upgrade bug

= 1.4.2 =
* Added option: Show comments on mobile
* Added option: Change text on previous/next posts link
* Fixed some file permissions. Gracefully downgrade and display nice error message
* Added CSS for text spacers

= 1.4.1 =
* Removed SOAP error message - not needed anymore

= 1.4 =
* Added support for REST web services as well as SOAP
* Compatible with WordPress 2.8.4
* Fixed captions
* Fixed WP formatting issues with strong tags
* Fixed a few multi-language bugs as WP handles posts differently to pages and titles
* Added ability to switch back to mobile site from the website
* Can have have special chars in the footer text
* Added option: Set transparency colours for all images on your mobile site
* Added option: Add a specific image for posts to replace the main site image
* Added support for small images: share links, smileys, etc
* Added class to captions for styling.
* Fixed WP dodgy support for italic, emphasis and strong. WP does weird things with those!
* Added support for WTF in footer text: http://wapl.info/coding-for-the-mobile-web-with-WAPL/chapter/Text-Formatting/

= 1.3.3 =
* Fixed link to standard site

= 1.3.2 =
* Fixed bug on certain mobiles with a dodgy &

= 1.3.1 =
* Better handling of text formatting
* Support for forms
* Support for list items
* Updated schema

= 1.3 =
* Compatible with WordPress 2.8.3
* Header images / text can now be flagged as a "back to home" link
* Added a "switch to desktop" option
* Fixed few CSS bugs
* Added an installation script that sets a few default values on / off
* Specify the number of posts to display on the home page
* Show the tagline of the blog
* Show the author name of the blog
* Show categories on the home page
* Set hard limits on the size of excerpt on home page

= 1.2.1 =
* Fixed a bug with <script> tags

= 1.2 =
* Added a next/prev link on home page if more posts
* Added next/prev classes to style up
* Added handling of multi-language characters
* Added footer text to go with a footer image (also added an empty footer row if no image or text)
* Added 100% support for images - no scrollbar
* Added handling if no SOAP or no simpleXML
* Tidied up some CSS
* Add new class to post titles to distinguish between them and links
* Added admin notification if plugin isn't working (SOAP/simpleXML/dev key)
* Added a configurable home link at the top of the posts page
* Added lots of admin help

= 1.1.3 = 
* Fixes a CSS bug and adds compatibility with WordPress 2.8.2

= 1.1.2 =
* Fixes a bug with installing plugins with WordPress 2.8.1

= 1.1.1 =
* Removes a rogue admin comment

= 1.1 =
* Compatible with WordPress 2.8.1
* You can now add comments from your mobile
* Ability to turn menu off your mobile site
* Long menus wraparound at the top
* Loads of fixes for text formatting, bold, italic, strikethrough and underline
* Ability to specify transparency colour on header and footer images

= 1.0.2 =
* Fixes a minor bug with header and footer image previews

= 1.0.1 =
* Fixes a minor bug with header and footer images
