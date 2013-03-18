=== Plugin Name ===
Contributors: rjune
Donate link: http://www.oriontechnologysolutions.com/web-design/gcal-sidebar/#donate
Tags: sidebar, google, calendar
Requires at least: 2.8
Tested up to: 2.9.2
Stable tag: 2.8

Gcal Sidebar pulls a Google calendar feed and displays it in the sidebar of your wordpress blog. It supports both widget and shortcode modes.


== Description ==
Gcal Sidebar pulls a Google calendar feed and displays it in the sidebar of your wordpress blog. It supports both widget and shortcode modes.

List of shortcode options (Default options are first):
<ul>
<li>map_link=[0|1] 0 disables the map link, 1 shows a link to the location in google maps.</li>
<li>mode=[agenda|prose] agenda will display the title and time of the event, prose displays the title, then description</li>
<li>show_date[none|short|long] none displays no date header, short displays "Thu, Dec 2", long displays "Thursday, December 2"</li>
<li>pub_or_priv[0|1] 0 is a public calender, 1 is a private calendar</li>
<li>priv_id=[STRING] STRING is the private key of the calendar, see the FAQ for instructions on how to get it.</li>
<li>rs_offset=[0|number] lets you ignore the first X results</li>
<li>max_results=[4|number] Set the number of results to display in your calendar</li>
</ul>

== Installation ==
1. Upload gcal-sidebar.php to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure in the Settings menu.
1. Place it in your sidebar in the widets section.

== Frequently Asked Questions ==

= How do I use the shortcode? =
[gcal-sidebar feed_id="FEED_ID" ] is the bare minimum needed to display a calendar. Additionally, refer to the Description for a full list of shortcode options

= What do I put in the Calendar ID field? =
Simply put the ID of the calendar, GCal Sidebar will generate the URL itself. You can get the ID by going to the settings of a calendar, then looking in the "Calendar Address" section on the far right.

= Where do I get the Private Key? =
This is somewhat harder. Again, go to the settings page of the calendar. Look at the bottom in the "Private Address" section. Click on iCal, and copy the text between 'private-' and '/basic.ics'. That is your private key. Paste that into the public / private config box to allow access to private calendars.

= How do I display a different calendar on every page? =
Get the Calendar ID, then go to the page and scroll down to the "Custom Fields" Section. Create a new field named gcal_sidebar_feed_id and put the calendar ID in as the value. 

== Screenshots ==
No screenshots yet.

== Changelog ==

= 2.9 =
* Fixed bug where all day events are not properly displayed as all day.
* Turned back to ul rather than dictionary list.
* Added Date Header option in widget

= 2.8 =
* Fixed bug using gmdate instead of local date, causing events to show up on the wrong day
* Fixed bug causing an empty event to show up at the head of the list
* Fixed bug where h3 was injected into the title incorrectly
* Better input validation

= 2.7 =
* Added wrapper div so themes can control the layout easier.

= 2.6 =
* Added shortcode support, agenda / prose mode, and show_date options

= 2.5 =
* Fixed bug where empty calendars displayed empty events on Jan 1 1970

= 2.4 =
* Caches calender so that if the server connection fails it can still display your calendar

= 2.3 =
* Fixed bug where <select> was not closed. Caused UI issues on IE and Chrome.
* Added Custom_field support. Setting "gcal_sidebar_feed_id" to a calendar ID or comma seperated list of calendar IDs will override the widget config. This overrides *ALL* widgets.

= 2.2 =
* Fixed bug with private calendar key not set
* Private events now say busy instead of being blank
* Implemented "All day" idea from brady8(your patch was an old version)
* Added patch from Ned for richsnippets support
* Properly sorted required / optional configs in the widget config

= 2.1 =
* Submitted to wordpress.org

= 2.0 =
* Added multicalendar support
* Pull title from calendar if the widget config is empty
* Changed timezone offset to timezone dropdown default is "Automatic"

= 1.1 =
* Removed style from a link to the individual event. The theme should define that, not the module

= 1.0 =
* Pull timezone from the calendar instead of relying on the current system or user input.
* Moved timezone offset option to end of the config as it should be almost never required now.

= 0.5 =
* Rearranged the widget config to put common items near the top.
* Luis Esparza added the ability to display private calendars. Thank you sir.

= 0.4 =
* Added results offset feature, This lets you ignore the next X events in your calendar feed. Thanks to Kevin Gruber for funding the development.
* Added an option to display a MAP link next to each entry.

= 0.3 =
* Fixed TimeZone offset bug. (Timezone was two hours off)
* Fixed bugs in title link and event link dropdowns

= 0.2 =
* Added support for multiple calendars
* Tooltip shows address and description when you mouseover the link

= 0.1 =
* Initial Creation

== Upgrade Notice ==
