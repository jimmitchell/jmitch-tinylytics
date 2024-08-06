=== Tinylytics – Connect Tinylytics to WordPress ===

Plugin Name: Tinylytics
Plugin URI: https://jimmitchell.org/tinylytics-wp-plugin/
Description: Adds your Tinylytics tracking code to your WordPress site.
Tags: analytics, tracking, statistics, stats, uptime
Author: Jim Mitchell
Author URI: https://jimmitchell.org/
Donate link: https://donate.stripe.com/9AQ8Ab6Yr8Y67cYdQR
Requires at least: 4.6
Tested up to: 6.6.1
Stable tag: 1.1.3
Version:    1.1.3
Requires PHP: 5.6.20
Text Domain: jmitch-tinylytics
Domain Path: /languages
License: GPL-2.0-or-later
Contributors: jimmitchell

Adds Tinylytics tracking code to your WordPress site.



== Description ==

This plugin enables Tinylytics analytics for your entire WordPress site. A Tinylytics account (free or paid) is required to use this plugin. Some Tinylytics premium features will not work in this plugin for free accounts.



### Features ###

* Blazing fast performance
* Does one thing and does it well
* Drop-dead simple and easy to use
* Regularly updated and "future proof"
* Includes tracking code on all WordPress web pages
* Sleek plugin Settings page with toggling panels
* Works with or without Gutenberg Block Editor
* Easy to customize the tracking code

This is a lightweight plugin that inserts a Tinylytics tracking code in the pages of your site. To view your site stats, visit your Tinylytics account.


### Privacy ###

__User Data:__ This plugin does not collect any user data. The tracking code added by this plugin is used by Tinylytics to collect all sorts of user data. You can learn more about Tinylytics Privacy [here](https://tinylytics.app/privacy).

__Cookies:__ This plugin does not set or rely on any cookies whatsoever.

__Services:__ This plugin connects to the [Tinylytics.app](https://tinylytics.app) platform to record hit data from your site.

Tinylytics is developed and maintained by [Jim Mitchell](https://social.lol/@jim).


### Support development ###

I develop and maintain this free plugin with love for the WordPress community. To show your support, please [make a donation](https://donate.stripe.com/9AQ8Ab6Yr8Y67cYdQR). 

Links, toots, boosts, tweets, likes, and kudos are also appreciated. Thank you! :)



== Installation ==

### How to install the plugin ###

1. Upload the plugin to your blog and activate
2. Visit the settings to configure your options

After configuring your settings, you can verify that Tinylytics tracking code is included by viewing the source code of your web pages.

__Note:__ this plugin adds the required Tinylytics tracking code to your web pages. In order for the code to do anything, it must correspond to an active, properly configured Tinylytics account. Learn more from the [Tinylytics Documentation](https://tinylytics.app/docs).

[More info on installing WP plugins &raquo;](https://wordpress.org/support/article/managing-plugins/#installing-plugins)


### How to use the plugin ###

To enable Tinylytics tracking on your site, follow these steps:

1. Visit the plugin settings page from the "Tinylytics" option in the WordPress dashboard.
2. In the first setting, "Site ID", enter the Tinylytics site id for your WordPress site.
3. Configure any other plugin settings as desired (optional)

Save changes and done. You can then log into your Tinylytics account to view your stats.


### Plugin Upgrades ###

To upgrade Tinylytics, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 

For more information, visit the [Tinylytics Homepage](https://jimmitchell.org/tinylytics-wp-plugin/).


### Restore Default Options ###

To restore default plugin options, uninstall, then reinstall the plugin.


### Uninstalling ###

Tinylytics cleans up after itself. All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen. Your collected Tinylytics data will remain in your Tinylytics account.


### Like this plugin? ###

If you like Tinylytics, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/jmitch-tinylytics/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!



== Frequently Asked Questions ==

None as of yet. :)



== Screenshots ==

1. Tinylytics: General Settings
2. Tinylytics: Shortcodes

More screenshots available at the [Tinylytics Plugin Homepage](https://jimmitchell.org/tinylytics-wp-plugin/).



== Upgrade Notice ==

To upgrade Tinylytics, just click "Update" from the Plugins screen and let WordPress do it for you automatically. For more information, visit the [Tinylytics Plugin Homepage](https://jimmitchell.org/tinylytics-wp-plugin/).



== Changelog ==

*Thank you to everyone who shares feedback for Tinylytics!*

If you like Tinylytics, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/jmitch-tinylytics/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!

**Version 1.1.3 (08-03-2024)**

* Refactor code here and there. No big changes really.

**Version 1.1.2 (08-02-2024)**

* Add menu position order to properly group with other settings menu items.
* Update WordPress tested version.

**Version 1.1.1 (04-06-2024)**

* Fix an issue where the admin session check would cause Site Health to show a critical issue.

**Version 1.1.0 (03-07-2024)**

* Add option to ignore hits for WordPress admins who are logged into their site.
* Add the ability to set a custom link label when the display public stats option is enabled.

**Version 1.0.6 (02-21-2024)**

* Fix a minor bug to prevent outputting tracking script if site id is empty.

**Version 1.0.5 (02-21-2024)**

* Fix a minor site error if options have not been set in the plugin yet.
* Remove an unused CSS style.
* Code clean up for readability sake.

**Version 1.0.4 (02-17-2024)**

* Better encoding of Tinylytics Javascript link.
* Add proper versioning to css and js enqueued resources.
* Replaced Ko-fi donation page URL with links directly to a Stripe donation page.
* Updated GPL license reference from "GPL v2 or later" to "GPL-2.0-or-later" so plugin check tool doesn't flag it.
* Add a Donate link to the plugin listing page.

**Version 1.0.3 (02-11-2024)**

* Update to correct a missed escaped echo'd attribute.
* Initial release in the WordPress plugin repository.

**Version 1.0.2 (02-04-2024)**

* Updates to meet WordPress plugin submission guidelines.

**Version 1.0.1 (01-15-2024)**

* Initial release.