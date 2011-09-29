=== Transpose Email ===
Tags: Transpose Email, email, contact, javascript
Contributors: Ajay
Donate link: http://ajaydsouza.com/donate/
Stable tag: trunk
Requires at least: 2.5
Tested up to: 2.9.1

Keeps your email safe from spammers when you want to use mailto: links.

== Description ==

Putting your email address in a blog post is an open invitation to spammers. There are several methods to prevent this, like using a contact form or obfuscating your email. 

Transpose Email plugin allows you to use JavaScript to create an encoded link. Clicking that link will trigger the user's email client to open and create an email.

You have the option to set the default subject line to whatever you want.

= Features =

* Easy to use and edit.
* Doesn't require any external program to encrypt your email.
* Function can be called muliple times on the same page, just by passing different email addresses.
* Uses the user's default email program like Outlook Express to send the email. So, will work even your host has disabled the mail() function of php as well as SMTP.
* Doesn't require reencrypting of your email address in case it changes. All you need to do is update the arguments to the function.


== Installation ==

1. Unzip ald-transpose-email.zip as is into your plugins folder, usually `wp-content/plugins/`
2. Activate the plugin on the plugin screen
3. Add `<a href="javascript:Transpose_Email('someone','example.com','About your site') ">Email Me</a>`. Change someone and example.com to match your email address


== Changelog ==

= 1.3 =
* Better support for blogs which have the `wp-content` folder moved from the original folder
* Added support for blank subject line

= 1.2.1 =
* Uploaded in the WordPress repository.

= 1.2 =
* Readme file update

= 1.1 =
* Moved the javascript function to an external .js file. Now the plugin works even when your blog is served as application/xhtml+xml on browsers that support it, e.g Firefox

= 1.0 =
* First release

== Frequently Asked Questions ==

= What are the requirements for this plugin? =

1. WordPress 2.5 or above 
2. The user's browser needs to have JavaScript enabled

= Can I customize what is displayed? =

Yes, you can. The javascript function accepts the following arguments:
1. userid - The part that comes before the @ in your email address e.g. if your email is *someone@example.com*, enter it as *someone*
2. domain - The part that comes after the @ in your email address e.g. if your email is *someone@example.com*, enter it as *example.com*
3. subject - The subject line of the email you will receive. 

For more information, please visit http://ajaydsouza.com/wordpress/plugins/transpose-email-plugin/#customizing

= Do I really need this plugin? =
This plugin would be useful when you don't want to use your contact form and instead use mailto: links. Using mailto: has the drawback of spambots finding your email address. This plugin encrypts your emailaddress, thus keeping you safe from spammers.
