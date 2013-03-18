===WP Forum Server ===
Author: VastHTML
Author URI: http://forumpress.org/
Donate link: http://forumpress.org/
Plugin URI: http://forumpress.org/
Tags: forum, integrated, bbpress
Requires at least: 2.6
Tested up to: 3.3.1
Stable tag: 1.7.4

This Wordpress plugin is a complete forum system for your wordpress blog.

== Description ==

WP Forum Server : A complete forum system for your wordpress blog.
The forum is a plugin, so no additional work is needed to integrate it into your site.

WP Forum Server is a an advanced, stable fork of WP Forum.

If there are any problems installing this plugin
please visit the site at http://forumpress.org/
and download the plugin from there.

If you want to show off your forum please
visit: http://forumpress.org/support/forumpress-g5/forum-server-1.4-and-previous-archive-f19
and leave a link to your site.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `forum-server` folder to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Make a new page to place your forum into. Make sure you have it on the `HTML` editor.

4. Simply place the tag `<!--VASTHTML-->` or `[forumServer]` in the new page content area.

Please visit http://forumpress.org/ for usage instructions.

Complete Installation Instructions: http://forumpress.org/installation-setup

For a complete demo visit http://forumpress.org/support/

== Frequently Asked Questions ==

= Do you have a demo? =
Yes- it's located here: http://forumpress.org/support

= The file from Wordpress.org does not work =
Go to http://forumpress.org/
and download from there.

= Is there a gallery i can see other people using the plugin? =
http://forumpress.org/support/forumpress-g5/forum-server-1.4-and-previous-archive-f19

= How do I translate interface in another language? =
To make a translation of any wp plugin use this plugin
http://wordpress.org/extend/plugins/codestyling-localization/

When the .mo file is ready:

1. Prefix the .mo file with "vasthtml-", for example: vasthtml-en_EN.mo.

2. Copy this file to /wp-content/plugins/forum-server/languages/

3. Go to Admin > WP Forum Server > General Options and choose your language

Also you can add description to your translate file: create file vasthtml-en_EN.txt with short description and put it info language directory.

= May I recommend some new features? =
Yes please do. http://vasthtml.com/support/?vasthtmlaction=viewtopic&t=20.0

= Where can I get support? =
In the support forums on Vast HTML: http://forumpress.org/support


== Screenshots ==

1. Choose a forum skin.
2. The home page for the forum options.
3. About the forum page.

== Changelog ==

= 1.7.5 =
* fixing harmless "exploits"

= 1.7.4 =
* fixing harmless "exploits"

= 1.7.3 =
* minor changes to fix version

= 1.7.2 =
* restored missing files from SVN

= 1.7.1 =
* wpf-insert.php injection vulnerability fixed

= 1.7 =
* Added automatically create forum page and example content

= 1.6.9 =
* Fixed bug: modules loading errors

= 1.6.8 =
* Fixed bug: SEO-friendly URLs in PRO-version
* Fixed bug: dropdown select in admin moderators and users
* Fixed bug: subject encoding in topic reply
* Added "Upgrade to Pro" links

= 1.6.7 =
* Fixed bug with wordpress html editor in admin

= 1.6.6 =
* Fixed major security bug with RSS feed
* Fixed BBCodes php errors on some of installation
* Names of users on forum now displays the same as throughout wordpress ( using 'Display name' instead of 'user name' )
* Improved usabiity of changing languages. Now available through wordpress admin panel in a simple way

= 1.6.5 =
* Fixed bug: warning php message

= 1.6.4 =
* Fixed bug: duplicate topic forms
* Fixed bug: default encoding in database tables changed to UTF-8
* Fixed bug: parsing '$' character
* Fixed bug: width for posts with embedded video or code listings
* Fixed bug: login form when wordpress is installed in it's own directory (not in root folder)
* Fixed bug: 'show new posts since last visit' feature
* Fixed bug: links to posts in RSS feed
* Fixed bug: database error when deleting forum
* Fixed bug: interface of adding users to users' groups

= 1.6.3 =
* Fixed bug: Fix icon for my hot topics
* Fixed bug: Fix minimize forum header button
* Fixed bug: Fix deleting single post in topic
* Fixed bug: Fix deleting category when there's some topics in it
* Fixed bug: Fix redirect after posting in topic on non first page
* Fixed bug: Fix checking user_level for sticky post function
* Fixed forum related errors (undefined variables) with debug-mode enabled

= 1.6.2 =
* Fixed bug: Incorrect formatting in replies subject for topics and posts containing apostrophes
* Fixed bug: Disallow ability to modify guest posts by other guests
* Fixed bug: Fix the topic links in the rss feed and email-notifications
* Added line breaks in post/answer body for better text formatting

= 1.6 =
* Fixed bug: Duplicate launch of plugin with sfc-like plugin
* Fixed bug: Fix youtube video insertion (allow html embed object)
* Was added support SEO-frendly URLs

= 1.5.2 =
* Fixed bug: Duplicate launch of plugin on certain themes and WordPress installations
* Fixed bug: Localization support on WordPress 3.0+
* Fixed bug: Javascript error when using "Show or hide header" feature on certain Forum Server skins

= 1.5.1 =
* Fixed bug: Path problems if wordpress is in subdirectory

= 1.5 =
* Fixed bug: Incompatibility with FireStats plugin and possibly certain other plugins, the bug also could cause a lot of database errors
* Fixed bug: Duplicating topics due to plugin incompatibility with certain plugins
* Fixed bug: No post body inside the topic due to plugin incompatibility with certain plugins
* Fixed bug: BBCode content inside e-mail notifications
* Fixed bug: Closing a topic didn't work as expected
* Fixed bug: sending e-mail notifications of your own replies when subscribed on topic
* Fixed bug: When subscribing to replies on topic, a blank screen was showing up
* "Unmake sticky" renamed to "Unstick" (for sticky topics)
* Fixed bug: Unstick function now works
* Fixed bug: search system now works
* Improved search system, now it searches in topic titles and can search in both titles and content
* Fixed bug: Email notifications were not sent in some cases
* New placeholder for inserting forum into WordPress page: [forumServer] can be used instead of <!--VASTHTML-->

= 1.4 =
* Added admin ability to close a topic
* Added admin ability to move a topic
* Fixed bug with message width on narrow theme column
* Fixed bug with Google Analytics hiding message textarea
* Fixed bug when user manually changes url parameters

= 1.3 =
* The link to edit categories now works.
* Made a work around for those having trouble deleting categories.

= 1.2 =
* Link to FORUM in Breadcrumb
* Group Link and Group Page
* Fixed the blank page redirection stuff

= 1.1 =
* Fixed database errors
= 1.0 =
* Code clean up
* Changed menu style to match Wordpress 2.7+
* Changed all images to a more updated look
== Upgrade Notice ==

= 1.5 =
This version fixes a number of plugin incompatibility bugs. Upgrade highly recommended.

= 1.4 =
This version fixes a security related bug. Upgrade immediately.
