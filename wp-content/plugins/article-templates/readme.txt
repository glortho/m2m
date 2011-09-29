=== Article Templates ===
Contributors: binnyva
Donate link: http://binnyva.com/
Tags: post,templates,template,page,admin
Requires at least: 2.5
Tested up to: 3.0.1
Stable tag: 1.05.2

Article Templates plugin lets you create templates that can be used when writing a new post or page.

== Description ==

This plugin lets you create templates that can be used when writing a new post or page. This will be very useful if you are writting many post with the same structure.

== Installation ==

1. Download the zipped file.
1. Extract and upload the contents of the folder to /wp-contents/plugins/ folder
1. Go to the Plugin management page of WordPress admin section and enable the Article Templates plugin
1. Go to the Templates Management page(Manage > Manage Templates) to create the templates.

== How to Use ==

Go to the Templates Management page(Manage &gt; Manage Templates). All the templates you have created will be shown there. You will have the option to create, edit and delete templates in this page.

All templates you have created will be shown in a dropdown in the Post pages. When creating a new post, you can chose a template from the dropdown menu and it will be inserted into the editor automatically.

If a template is set as default, that will be inserted into the editor whenever you write a new post.

Please note that the templates can only be used by the user who created the template. This feature might be removed in the future versions.

For more information, go to [Article Templates](http://www.bin-co.com/tools/wordpress/plugins/article_templates/ "Article Templates WordPress Plugin") documentation.

== ChangeLog ==

= 1.02.0 =
* Production version for WordPress 2.3

= 1.03.0 =
* Article Templates now supports WordPress 2.5
* Drops support for older versions

= 1.04.0 =
* Change by Kim Parsell (http://www.kpdesign.net/): fix for style, layout, and text content of div containing template dropdown box on Write tab (post and page) to seamlessly integrate it with the new Wordpress admin layout. Works with the fresh and classic themes.
* This version also fixes the new line insertion bug that happens in code(non-visual) editor mode.

= 1.05.0 =
* WP 2.8 Compatibility
* Made admin forms prettier
* Now uses wpframe
* Changed by Philipp Bartels (mail@pBartels.info)
* Added feature to make a template available to all users (users at or above editor role may do this)
* Added feature to set a default template for all users, without overwriting a user selected default template (administrators may do this)
* Fixed the editor bug that happens in WP 2.8.5

= 1.05.1 =
* Changed <?= to <?php. Compatibility issue with a few hosts. Working with WP 3.0 now.

= 1.05.2 =
* A critical bug fix.