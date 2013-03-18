=== Notify Bar ===
Contributors: miltonbjones
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZHVKV26GGDSWQ
Tags: notify, notification, alert, box, alert box, alert bar, bar, status bar, ribbon
Requires at least: 3.3
Tested up to: 3.3
Stable tag: 1.2
License: GPLv2

Adds a Notify Bar across the top of some or all pages on your website. 

== Description ==

This plugin adds a bar (Notify Bar) across the top of some or all pages on your website.  The bar displays a headline and a paragraph, which can be used to publish important announcements such as upcoming site maintenance, downtime, approaching deadlines, or whatever seems important.  The background color, headline color, message color and the link color can be customized with a color picker.  There is also an optional jQuery slideUp feature that allows the user to click a 'Hide This' link and remove the bar after reading the message.  


== Installation ==

1. Upload the *notify-bar* folder to your `/wp-content/plugins/` directory
1. Activate the plugin through the *Plugins* menu in WordPress
1. Place `<?php if (function_exists('mbj_notify_bar_display')) { mbj_notify_bar_display(); } ?>` immediately after the BODY tag in the template files for all areas that you want to display the Notify Bar on your site.  Depending on your set up, this may involve only pasting this code in one place in header.php, or you may have multiple places where the BODY tag is used.
1. You will then be able to compose your message, adjust the settings, and deploy the Notify Bar to your website by hitting the *Notify Bar* link in the *Settings* sub-menu of the WordPress admin panel main menu.

== Frequently Asked Questions ==

= Where do I find the Notify Bar controls within the WordPress admin panel? = 

Look for *Settings* on the main navigation menu on the left side of the WordPress admin panel.  Within that *Settings* sub-menu, you'll see an item called *Notify Bar*.  That link will take you to a panel where you can edit and activate the Notify Bar.

= Why does the Notify Bar not look the same on all sites? =

The Notify Bar plugin is meant to be flexible enough to look good on a variety of websites by going pretty light on CSS and using inheriting fonts and various other properties from the site you are installing it on.  For example, on most websites, the background color of the Notify Bar will stretch the full width of the page, but on some sites that might not be the case.  One way this could happen would be if you have set the HTML body element of your site to have a width of less than 100%.  There are other conditions that might make the Notify Bar look different across different websites, but the hope is that by inheriting the fonts from what you're using on your site and by allowing you to set your own colors, you can make the Notify Bar look nice on most any website.


= Can I use HTML tags within the content of the message part of the Notify Bar on my site? =

Yes, the following tags can be used in the message field on the Notify Bar settings admin page:

* br
* strong
* em
* b
* i
* span
* a (with attributes of href, title, and alt)


= Why can I only type one paragraph for the message? =

This plugin is written in a way that encloses the message part of the Notify Bar with HTML paragraph tags.  This is meant to keep things simple and allow the plugin to be used for delivering succinct messages across the top of a website. 

= Can my website visitors hide the Notify Bar after reading the message? = 

Yes.  As the site owner, you have the option to include or not include a 'Hide This' link on the Notify Bar you set up for your site.  When the 'Hide This' link is clicked, the Notify Bar will be slide up out of view and not display again until a new browser session is started. 


== Screenshots ==

1. Screenshot of Notify Bar with the Twenty Eleven WordPress theme
2. Screenshot of Notify Bar on my blog
3. Screenshot of the Notify Bar admin panel

== Changelog ==

= 1.2 =
* Changed Visit Plugin Site link

= 1.1 =
* Added options to customize headline color and message color

= 1.0 =
* Plugin launched




