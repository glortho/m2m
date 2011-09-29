=== LikeBot - Decentralized like-system ===
Contributors: tommietott
Donate link: http://likebot.com/wordpress
Tags: like, automatic, tracking, integration, author
Requires at least: 2.0.0
Tested up to: 2.9
Stable tag: 0.85

Add a like/dislike feature similar Facebook right on your blog!

== Description ==

LikeBot.com is a decentralized like-system with the intention to make the integration as simple as streamlined as possible for the user. No registration, no authentications - it's just a very simple way for your reader to let you know if they like the post/content or not. 

The LikeBot-button automatically inject itself below your content and align to the right or can optionally be position using the themes administration.

If you wish to learn a bit more about LikeBot - check out http://likebot.com

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `likebot.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. The LikeBot-button will automatically appear below your posts.

== Screenshots ==

1. LikeBot-Button examples
2. LikeBot-Buttons on a blog example

== Frequently Asked Questions ==

= How can I add just the button to another area of my theme? =

In the Theme Editor, you will place this line of code where you want the button to appear in your theme:`<?php if( function_exists('LIKEBOT_BUTTON') ) { LIKEBOT_BUTTON(); } ?>`

Keep in mind that manually inserted buttons wont be aligned left or right, though it will use the background-color and button-design option. Generally you should go with automagically-positioning if you're not very familiar with working with php in theme-files.

= Can i change the appearance of the LikeBot-button? =

It's possible to change the customization plugin administration. Logon as an Administrative account and click "LikeBot Plugin" in the Plugins-menu.

= Can i change the alignment of the button? =

Sure, you can change the alignment under customization in the plugin administration. 

= I've added nolikebot-tag to a post but the buttons keeps showing up? =

Be sure that you've added `<!--nolikebot-->` to the top of your post. Adding it further down could cause the LikeBot-button to appear regardless of the tag.

= The buttons doesn't show up and it says [LikeBot Error]? =

Click the [LikeBot Error]-text and you will be take to a description of the problem.

== Changelog ==

= 0.85 =
* feature: Massive overhaul of the backend and the foundation for a proper REST API are in place. The API will be announced in future versions of LikeBot. Check out http://likebot.com for updates.
* feature: Error handling has been updated
* bugfix: transparency now work properly on Internet Explorer
* vanity: Thanks to Patrik we now have a official logo! Say hi to the Like Robot, http://goo.gl/3KBa :)

= 0.8 =
* feature: LikeBot has moved on to the Google App Engine-platform, making it a lot faster! It's hosted in the worlds largest serverfarm, so accessibility and stability should no longer be an issue. And even if it's "cheap", it's far from "free". So if you like our service, please donate a buck or two at http://likebot.com - thanks!
* feature: LikeBot now require that you only like URL/URIs from the same domain which you're serving the buttons. This means that you cannot like a URL/URI on http://example1.com from http://example2.com.
* feature: LikeBot have proper error-handling. If you encounter an error on your site, just click the [LikeBot Error]-text and you will be taken to a description of the error.

= 0.7 =
* feature: new badge-button design added, you can enable it via the administrative settings.

= 0.6 =
* feature: LikeBot has moved part of it's files to The Coral Content Distribution Network - which means that the buttons should show up a lot quicker from now on.
* feature: You can now turn off automatic insertion of the button below each post. Turning if off requires you to manually add the button to your theme-files. Check the Administration-section for instructions.
* feature: adding `<!--nolikebot-->` to the top of a post will automatically remove the LikeBot-button on that post. Works in conjunction with the `<!--more-->`-tag.
* Bugfix: the plugin now works properly with the `<!--more-->` and adjust itself below the tag if it's present
* Bugfix: spelling errors on the options-page
* LikeBot-buttons automatically get positioned below the post as the default behaviour.
* LikeBot has moved part of it's files to The Coral Content Distribution Network - which means that the buttons should show up a lot quicker from now on.

= 0.5 =
* Bugfix: proper default design

= 0.4 =
* Second public release.

= 0.3 =
* Default button background color changed to nothing/transparent
* You can now like/dislike the service in the plugin administration
* Customization: Change background color of the button
* Customization: Change alignment of the button (left/right)
* Customization: Change appearance of the button (thumbs, text or square-thumbs)

= 0.2 =
* Screenshots added

= 0.1 =
* Initial release
