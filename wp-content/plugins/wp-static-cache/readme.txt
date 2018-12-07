=== WP Static Cache ===
Contributors: Blode,MyIM
Donate link: http://www.myim.cn/
Tags: performance, Caching, static cache, cache
Requires at least: 3.0.1
Tested up to: 4.6.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A very simple & fast caching engine for WordPress that produces static html files for your site.

== Description ==
WP Static Cache is designed to make your WordPress site much faster and more responsive. This plugin will automatically generate real html files for all pages when they are loaded for the first time, and automatically renew the html files period. 

Key features:
1, Set up filters to skip some directories to generate html file.
2, Caching file management.( delete a caching file )

== Installation ==
1. Upload to your plugins folder, usually wp-content/plugins/ and unzip the file, it will create a wp-content/plugins/wp-static-cache/ directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Menu -> 'wp static cache' screen to configure the plugin

= Manual installation =
1. Download the plugin and extract its contents.
2. Upload the `wp-static-cache` folder to the `/wp-content/plugins/` directory.
3. Activate the **WP Static Cache** plugin through the "Plugins" menu in WordPress.

== Uninstall WP static cache ==
Almost all you have to do is deactivate the plugin on the plugins page.

== Frequently Asked Questions ==

= Do I really need to use this plugin? =
If your site gets Slashdotted
If you’re on a very slow server
If you’ve had a complaint from your host about performance
If you just want to blog rather than testing new plugins and functions of wordpress

= How can I tell if it’s working? =
wp-static-cache adds some tags to the very end of a page in the HTML, so you can view source to see if there any codes like <!-- http://www.youdomain.com generated at 2016.10.26 10:10:10 by wp static cache-->

= Do you cache other pages such as cat ? =
Yes, this plugin cache all pages.

= How do I delete the WP_CACHE define from wp-config.php? =
Load your desktop ftp client and connect to your site. Navigate to the root (or the directory below it) of your site where you'll find wp-config.php. Download that file and edit it in a text editor. Delete the line define( 'WP_CACHE', true ); and save the file. Now upload it, overwriting the wp-config.php on your server.

== Screenshots ==

1. Cache files management.
2. Set-up caching filter.

== Changelog ==

= 1.1 =
* Added support for delete all caching files.

= 1.0 =
* First version.

== Upgrade Notice ==