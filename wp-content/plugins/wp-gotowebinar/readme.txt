=== WP GoToWebinar ===
Contributors: northernbeacheswebsites
Donate link: https://northernbeacheswebsites.com.au/product/donate-to-northern-beaches-websites/
Tags: gotowebinar, widget, shortcode, citrix, webinar registration, webinars, upcoming webinars, wpbakery page builder, mailchimp, constant contact
Requires at least: 3.0.1
Tested up to: 6.0.2
Stable tag: 14.36
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP GoToWebinar displays a listing or calendar of upcoming webinars using a shortcode or widget which can link to a registration form on your website.


== Description ==

WP GoToWebinar is a totally free plugin used to display upcoming webinars in a table, calendar or widget from your GoToWebinar account which link to registration forms on your website.

By using simple shortcodes or the WPBakery Page Builder plugin you can place upcoming webinars or registration forms on any post or page with ease.

As webinars pass and new webinars are created, the upcoming webinar display updates automatically each day making WP GoToWebinar a zero-maintenance experience.

Use the shortcode [gotowebinar] to display webinars in a table format, [gotowebinar-calendar] to display webinars in a calendar format, [gotowebinar-reg key=”YOUR WEBINAR KEY”] to display a registration form for a specific webinar, or use [gotowebinar-reg key=”upcoming”] to show a registration form of your next upcoming webinar!

There’s also a range of additional shortcode parameter that can be used which can:

1. Only show webinars from a particular timezone
2. Only show webinars if the webinar title contains or doesn't contain particular text
3. Only show webinars within the next X number of days
4. Hide a certain phrase in the title from displaying

Please checkout the plugin FAQ section for more information on the different shortcode parameters, or better yet use the WPBakery Page Builder plugin.

WP GoToWebinar also enables your users to convert the times and dates of upcoming webinar displays and registration forms into their local timezone with a click of a link! Reduce spam registrations with Google reCaptcha support.

Translate/customise standard registration form fields and create dynamic success and error messages for your users simply and quickly. Customise colours of various elements and enable hover tooltips to provide additional information to your users on upcoming webinars and registration forms.

WP GoToWebinar is mobile friendly, implements smart caching to make loading times super fast and it's also unobtrusive so it should adapt fairly well to your themes existing styles. Using our 1-click GoToWebinar authentication process and simple user interface you'll have things up and running in no time! Watch a full walkthrough of all these features in this video here:

[youtube https://www.youtube.com/watch?v=7lLOk14OpfA]

= Want to create, manage and sell upcoming and previously recorded webinars from WordPress? Or how about integrate your registrattion forms with email marketing and CRM packages including: ActiveCampaign, Agile CRM, Campaign Monitor, Constant Contact, Highrise, Hubspot, Insightly, MailChimp, Pipedrive, Salesforce and Zoho? Want to get webinar performance information from WordPress? Or what about displaying a live webinar countdown in the toolbar of your website! Upgrade to WP GoToWebinar Pro today to experience true GoToWebinar-WordPress awesomeness! =

Learn more here: https://northernbeacheswebsites.com.au/wp-gotowebinar-pro or watch the below video:

[youtube https://www.youtube.com/watch?v=M3rty3sV9lU]

Please show your support for this plugin by donating what you can via the plugin settings page as your support will contribute to support and new features!


== Installation ==

There are a few options for installing and setting up this plugin.

= Upload Manually =

1. Download and unzip the plugin
2. Upload the 'wp-gotowebinar' folder into the '/wp-content/plugins/' directory
3. Go to the Plugins admin page and activate the plugin

= Install via the Admin Area =

1. In the admin area go to Plugins > Add New and search for "WP GoToWebinar"
2. Click install and then click activate


== Frequently Asked Questions ==

= To setup the plugin =

1. In the WordPress admin area go to Settings > WP GoToWebinar
2. Click the "Click here to get Auth and Key" button to connect the plugin to your GoToWebinar account

= How to use the Upcoming Webinar shortcode =

1. Navigate to the post or page you would like to add the webinars to
2. Enter in the shortcode [gotowebinar]
3. You can also add filters to the shortcode like: [gotowebinar include="Training" exclude="Introduction" hide="Training" timezone="Australia/Sydney" days="10"]

= How to use the Register Webinar shortcode to display a registration form for a single webinar =

1. Navigate to the post or page you would like to add the webinars to
2. Enter in the shortcode [gotowebinar-reg key="YOUR WEBINAR KEY"] < this can be found on the GoToWebinar website
3. You can also add a hide parameter to the shortcode to hide parts of the title showing like: [gotowebinar key="YOUR WEBINAR KEY" hide="Training"]

= How do I enable users to signup on a form on my website =

1. Add the shortcode [gotowebinar-reg] on your newly created or existing registration page
2. In the plugin setting (Settings > WP GoToWebinar) select your registration page from the Custom Registration Page dropdown setting
3. That's it! Now when people click register from the Upcoming Webinars Shortcode or Widget instead of going to the GoToWebinar website they are taken to your registration page

= How to Use the Widget =

1. Go to Appearance > Widgets and drag the 'GoToWebinar' widget to your sidebar
2. Enter in a Title to appear above the webinar listing e.g. "Upcoming Webinars"
3. The same filters that apply to the shortcode are also available here

Please see a full list of FAQ's on the plugin settings page for a comprehensive list. 


== Screenshots ==

1. Once you have installed the plugin, navigate to Settings > WP GoToWebinar in the admin area
2. Insert a shortcode into a page
3. Add the widget to a sidebar
4. View the table on your website
5. View the widget on your website
6. View the registration form on your website
7. Adding a webinar using WPBakery Page Builder
8. Calendar view of upcoming webinars
9. Calendar view list of upcoming webinars



== Changelog ==

= 14.36 =
* Compatibility Update

= 14.35 =
* Fixes and added flexibility for calendar

= 14.34 =
* Bug fixes

= 14.33 =
* Force check for plugin updates

= 14.32 =
* Added filter to change recording assets

= 14.31 =
* Ability to filter recording assets start date

= 14.30 =
* Fix for timezone conversion

= 14.29 =
* Fixing of ajax spinner

= 14.28 =
* Bug fix in version 14.27

= 14.27 =
* Added a new shortcode parameter and filter to modify the thank you page for the registration form

= 14.26 =
* Added a filter for the source

= 14.25 =
* Additional filter for registration page

= 14.24 =
* Bug fix for copy billing details button

= 14.23 =
* Help fix PHP errors

= 14.22 =
* Fix to date transation when using WordPress date

= 14.21 =
* Compatibility with WordPress 5.5

= 14.20 =
* Better code for getting upcoming webinars for registration form shortcode

= 14.19 =
* Minor bug fixes

= 14.18 =
* Makes --Select-- translateable

= 14.17 =
* Removal of PHP errors from checkout

= 14.16 =
* Added registration actions

= 14.15 =
* Changing of function names to reduce conflict

= 14.14 =
* Made GDPR text translateable 

= 14.13 =
* New option to use the WordPress date and time format and functioning of the getting of the date and time to make things more streamlined

= 14.12 =
* Fixed minor bug on submit button of registration form

= 14.11 =
* New pro option to disable sending of query strings to thank you page

= 14.10 =
* Better compatibility with Contact Form 7 Recapcta

= 14.9 =
* Updates to how recording downloads are managed

= 14.8 =
* Small bug fix of shortcode.php 

= 14.7 =
* Timezone fix for shortcode display

= 14.6 =
* Updated support for recording assets by getting previous webinars instead of recording assets

= 14.5 =
* Added support for source

= 14.4 =
* Fix for creating webinar products which don't have descriptions

= 14.3 =
* PHP 7.3 compatibility
* New filters if there are no webinars

= 14.2 =
* Updated to font awesome 5

= 14.1 =
* Bug fixes

= 14.0 =
* Smarter loading of styles and scripts - sorry it took so long
* Full compliance with API v2

= 13.10 =
* Support for variable products

= 13.9 =
* Fixing of recording assets function

= 13.8 =
* Tested with WordPress 5.1.1

= 13.7 =
* New pro option: ability to change default of opt-in checkbox for email service/crm integration
* New pro option: ability to make opt-in checkbox for email/crm integration mandatory before form submits
* New pro option: MailChimp integration, require email opt-in 
* Tested with WordPress 5.1

= 13.6 =
* Fix for time conversation on single webinar page

= 13.5 =
* Quick release to ensure WordPress 5.0 compatibility. Further testing is required with WordPress 5.0 but this will hopefully be all that is needed

= 13.4 =
* We now validate the email before sending for registration because GoToWebinar's API bizarely doesn't do any validation

= 13.3 =
* Correct display of time in Webinar Product Manager (pro version)

= 13.2 =
* Smarter sorting of webinars
* new pro setting to show days in webinar countdown 

= 13.1 =
* Bug fix for showing old webinars in table when they belong to long series of webinars

= 13.0 =
* Pro feature release - now you can display webinar recordings in a table using the shortcode [gotowebinar-recordings] - please see the FAQ tab in the plugin settings for more info
* We also provide better documentation around the pro feature which shows webinar products in a table which is done by this shortcode: [gotowebinar-products] - please see the FAQ tab in the plugin settings for more info
* Minor bug fixes
* New date format options to help German users

= 12.22 =
* Fix for people with webinars that start at the exact same time

= 12.21 =
* Nicer HTML for shortcodes

= 12.20 =
* Some cleaning up of the admin area and updates to our free user support policy due to WordPress forum rules

= 12.19 =
* Better isolation of time and date picker scripts to prevent plugin conflicts

= 12.18 =
* Trimming of authentication details to remove white space before or after details which can occur when copying and pasting data

= 12.17 =
* Better versioning of CSS and javascript

= 12.16 =
* Now using javascript-based timezone detection technique to convert webinar times instead of API call because the API IP based method

= 12.15 =
* Tested with latest version of WordPress
* New connection log system which should make support easier and make it more accessible as it is now found in the support tab
* Better reporting of application used in diagnostic information
* Updated messaging and clearance of authorisation code in query string to make initial setup of plugin more expected

= 12.14 =
* Now supports simulated live webinars in the webinar product drop down (pro version only)

= 12.13 =
* You now have the option of creating your own GoToWebinar app instead of relying on our application which serves everyone. This can give you a more stable connection with GoToWebinar. Please see the new instructions just under the "General Options" tab in the plugin settings

= 12.12 =
* Added connection log to plugin for better debugging of authentication issues

= 12.11 =
* Now we get upcoming webinars from version 2 of the api so simulated live webinars are also fetched

= 12.10 =
* Now the tooltips have better CSS targeting 
* Improved authentication reliability for pro users

= 12.9 =
* Now the thank you page redirect includes time and date query strings so you can add these onto a custom thank you message
* From the plugin settings you can set the default value of the registration confirmation checkbox for better GDPR compliance

= 12.8 =
* A new pro feature commonly requested - now you can easily sell webinar recordings via WooCommerce! Simply create a new WooCommerce product that is Virtual and Downloadable and then in the "General" tab select your webinar recording from the new "Webinar recording selection" field

= 12.7 =
* Fixed compatibility issue with alternative WPBakery Page Builder, caused by WPBakery Page Builder

= 12.6 =
* Now added webinar id to thank you page query string

= 12.5 =
* Implemented a range of measures to reduce the API burden caused by the plugin. This includes: 1) reducing API calls made from plugin settings, reduced statistics to just the last week or max 10 webinars, prevented the ability to turn caching off, you can only clear the cache once now every 24 hours, calls made in the plugin settings have now been standardised under one transient name instead of separate ones for settings and the WPBakery Page Builder/tinyMCE editor. Updates have been made to the FAQ to address these changes. 

= 12.4 =
* Updated notices on free version of plugin which weren't displaying properly

= 12.3 =
* Frontend error messages only show to admins now
* First name, last name and email now sent in query string to thank you page so you can do what you want with that :) 
* Temporary disclaimer around authentication issues caused by GoToWebinar

= 12.2 =
* Now hides registration forms of old webinars

= 12.1 =
* THIS IS A REALLY IMPORTANT AND BREAKING UPDATE, PLEASE READ THIS NOTICE IN FULL!!!
* On the 14th of August 2018 GotoWebinar is going to strictly enforce the OAuth 2.0 authentication protocol for the GoToWebinar API. This means the way this plugin handles authentication is going to be a bit different as we no longer have an access token we can use indefinitely, instead we need to continually fetch access tokens for each call. But importantly what this means for you is that you need to update the plugin by at least the 14/8/18 otherwise the plugin will stop working AND when you do update the plugin it's critical you reauthenticate the plugin by clicking the new "CLICK HERE TO CONNECT WITH GOTOWEBINAR" button in the General Options tab in the plugin settings. Failing to do so will break the plugin and may cause errors on the front of your site. SO UPDATE AND REAUTHENTICATE and everyone will be happy.

= 12.0 =
* Now you can use AND or OR conditions in the include or exclude parameters of shortcodes and use AND conditions in the hide parameters of shortcodes. For example [gotowebinar include="PublicANDWebinarANDNew York" exclude="PrivateORTest" hide="PublicANDWebinar"]
* Updated FAQ tab to give examples of above
* Refactoring of code used in shortcodes
* Tested with WordPress 4.9.4
* Pro update, use the new shortcode [gotowebinar-products] to display a table of webinar products on any post or page
* Fix for IE bug on select fields on registration forms which were required but the form failed initial validation 
* Only implements Google reCAPTCHA script if setting enabled

= 11.4 =
* Pro update, Added Zoho workflow trigger option to trigger workflows in Zoho if required

= 11.3 =
* Pro update, now automatic updates

= 11.2 =
* Pro update, now payments made via non instant methods (like bank transfer) will not register the person for a webinar after checkout. Instead these orders need to marked as completed on the WooCommerce orders page for the person to be registered for a webinar.  
* Tested to version 4.9.1 of WordPress

= 11.1 =
* Fixes logging issue that may cause success message not to display on the webinar registration form

= 11.0 =
* New Webinar Countdown Toolbar feature for pro users which displays a live countdown until the next webinar begins on the front end of the site
* Adds translation support for WooCommerce Checkout items

= 10.2 =
* Re-enables authentication check on plugin settings which was accidently removed in version 10
* Fixed timezone conversion error when creating webinars with the pro version of the plugin.

= 10.1 =
* Removes javascript console error on form submissions by free users of the plugin.

= 10.0 =
* The settings have been completely rebuilt from scratch to provide better compliance to WordPress settings standards and to provide better commonality between other plugins by Northern Beaches Websites. This should make the code far more extendable in the future. From a user perspective there should be pretty little change.
* You can now add a new opt in condition for the registration form to be submitted. This label can also be translated in the translations settings of the plugin. 
* The pro version of the plugin now has heaps more integrations. These new integrations include: Campaign Monitor, Hubspot CRM, Insightly CRM, Highrise CRM, Agile CRM, Pipedrive CRM, Salesforce CRM and Zoho CRM. So the pro ad has been updated as a result. 
* Now has TinyMCE support so if you aren't using the WPBakery Page Builder plugin you can now insert shortcodes just as easily using the standard WordPress content editor!
* New log tab so you can see all the activity of the plugin
* You can now check out how your webinars are performing with the pro version of the plugin

= 9.2 =
* The plugin now shows an authentication status message on the plugin settings page. This can help users who have account issues.

= 9.1 =
* New video showcasing all the features of WP GoToWebinar
* Nicer display of times in calendar

= 9.0 =
* An all new way to display webinars with a new calendar view! Just use the new shortcode [gotowebinar-calendar]. Please check out the plugin FAQ to learn more
* Localised scripts and css files to improve page loading times

= 8.12 =
* Now you can use the additional parameters: 'include','exclude' and 'timezone' to show a registration form for the most upcoming webinar which meets those parameters. Thanks Marcin for the suggestion.
* Fixed WPBakery Page Builder general registration shortcode from not displaying in grid

= 8.11 =
* Now in the translation tab you can set a custom required message for registration form fields

= 8.10 =
* Fixed PHP error on one of the WPBakery Page Builder file

= 8.9 =
* Resolved missing instances in version 8.8 update

= 8.8 =
* Hopefully should fix retrieving body from ajax request on old versions of PHP

= 8.7 =
* Loaded jQueryUI to fix for older versions of WordPress

= 8.6 =
* Opened up the 'Support' tab for the free version of the plugin. And provided more strict guidelines before posting to the WordPress forum to allow me to better diagnose issues and help people.

= 8.5 =
* Implementation support for new pro feature - integration with ActiveCampaign

= 8.4 =
* Removed unnecessary jQuery Validation script from plugin

= 8.3 =
* Updated translation of minutes for German language. Thanks Gernot!

= 8.2 =
* Tested with WordPress 4.7.5
* Added new setting option to display a custom error message if the attendee limit is reached

= 8.1 =
* Now if a user is logged in the registration form will be autocompleted with the logged in users first name, last name and email address

= 8.0 =
* Updated base URL of API calls to new address so the plugin will continue to work in 2018 and beyond
* Improved logic for showing a certain amount of webinars for widget when a webinar is a sequence or series webinar
* Fixed issue with previous webinars showing in the widget if they are part of a series or sequence webinar and they have passed
* Fixed PHP bug which could show if you have nominated not to show time conversion
* Tested with WordPress version 4.7.4

= 7.10 =
* Pro version update makes creating webinars not show unnecessary error messages

= 7.9 =
* Pro version update which includes new option to not make past webinar products draft

= 7.8 =
* Pro version updates and compatibility

= 7.7 =
* Removes error message caused by code which disables updates

= 7.6 =
* Bug fix of code in previous release 7.5 which prevented error message of timezone comparison not show

= 7.5 =
* If the location of a user can't be detected via their IP address it will now show a custom error message which can be set in the settings
* Fixed jQuery bug for time and date picker

= 7.4 =
* Updated German translation of register link
* Minor updates of settings user interface
* Gave registration form messages unique class names

= 7.3 =
* Fixes break caused by previous new setting in case it is not set

= 7.2 =
* Added 24 hour time format support with new setting

= 7.1 =
* Updated default success message of registration form so the URL is now working correctly

= 7.0 =
* Tested with Wordpress 4.7
* Major refactoring of code for upcoming webinars to reduce code and make updates easier
* You can now display a registration form of your next webinar using a new shortcode parameter
* Updated registration form spinner so it only runs on the form submit and not the time conversion 
* You can now have more than one registration form work successfuly on a single page 

= 6.10 =
* Minor update to prevent pro users receiving updates from Wordpress.org

= 6.9 =
* You can now put Google reCAPTCHA on your registration form, a new setting can be found in the General Options tab

= 6.8 =
* Bug fix from previous update as the timezone conversion feature will now work in HTTPS

= 6.7 =
* Bug fix from previous update as the timezone conversion feature will now work in HTTPS

= 6.6 =
* Timezone conversion now works on Firefox and some other browsers
* Timezone conversion now uses IP detection  to identify users location rather than the users browser clock which means timezone conversion works on proxy servers

= 6.5 =
* Better cache management of registration page information so only successful calls are cached
* Added new error message management in translation settings so you can add a custom error message if a webinar has been cancelled or an incorrect webinar ID has been specified

= 6.4 =
* Added quickstart guide with permanently dismissable notice
* Custom theme files can now be placed in the child theme if available
* Fixed display of settings tab for people on older versions of Wordpress

= 6.3 =
* Prevents clear cache action from occuring twice
* Improved security
* Simplification of javascript code when submitting registration form

= 6.2 =
* Loads external Jquery UI script via HTTPS, before this ui features might not work on HTTPS sites on the settings page

= 6.1 =
* Minor re-arrangement of code
* Complete re-organisation of settings page into tabs which makes it more digestible and better displays pro version features

= 6.0 =
* New announcement and compatibility with WP GoToWebinar Pro which provides the easiest way to sell webinars
* Adds a template file for widgets so you can modify the widget code and still enjoy plugin updates
* Minor bug fixes
* better compatibility with webinars with multiple dates

= 5.11 =
* Allows for theme templates of shortcode files

= 5.10 =
* Additional update to version 5.7 with time conversion not working on single registration pages

= 5.9 =
* Minor bug fix for users on PHP 5.3

= 5.8 =
* Made it easier to selectively hide upcoming webinars columns using CSS

= 5.7 =
* Fixes issue with time conversion not working due to browser updates.

= 5.6 =
* Minor bug fixes for display of single webinar registration forms.

= 5.5 =
* Better error handling for the registration page.

= 5.4 =
* Better error handling if the API call to GoToWebinar doesn't succeed. Also fixed the clear cache button which broke from a previous update.

= 5.3 =
* Fixed more minor PHP errors and an issue whereby mailing list signup was showing for non-pro users

= 5.2 =
* Fixed minor PHP error due to 5.1 release

= 5.1 =
* This update is just an administration update. A lot of the code has been re-organised to allow for easier editing and updating in the future, particularly for the pro version. It also includes testing with Wordpress 4.6

= 5.0 =
* Now users can convert times and dates by clicking the timezone conversion link which can be enabled in the settings

= 4.8 =
* Minor styling changes to help customisations

= 4.7 =
* Minor styling changes - mainly so that webinar description formatting and better compatibility on mobile

= 4.6 =
* Minor styling changes - mainly so that webinar description formatting will display more like what it's on in GoToWebinar

= 4.5 =
* Added new custom thank you page option after successful registration instead of default options

= 4.4 =
* Added settings and other shortcuts on the plugin page
* Added last name to dynamic field for custom messages

= 4.3 =
* You can now have custom success, error and already registered messages via the settings page

= 4.2 =
* Missing timezone conversion which was causing issues for some users

= 4.1 =
* Added translation of Submit button on registration form which can be changed on the main plugin settings page

= 4.0 =
* The upcoming webinars table or widget is now translated based on the users Wordpress language setting
* The registration fields are now manually translatable via a new options panel in the settings
* Minor bug fix with WPBakery Page Builder settings not working for one of the elements

= 3.5 =
* Fixed a bug that was occuring for people using a verison of PHP less than 5.4 which doesn't support bigintasstring

= 3.4 =
* Various PHP bug fixes for users who have PHP errors turned on
* When registering for a webinar it now checks whether you have already registered for the webinar and displays an appropriate error message
* Attempted fix for users whose upcoming webinar table might not have worked
* Added diagnostic information on settings page

= 3.3 =
* Minor bug fix with registration URL's not going to the correct address on some systems.

= 3.2 =
* Updated display of successful registration
* Fixed loading icon
* Launch of WP GoToWebinar Pro

= 3.1 =
* Minor bug fix with WPBakery Page Builder display
* Wording changes

= 3.0 =
* Now the registration form is an exact mirror of your GoToWebianr form. So you can now edit your form fields in GoToWebinar and it will appear in WP GoToWebinar
* Fixed terminology so if a webinar is exactly 1 hour it will show "hour" and not "hours"
* Updated documentation
* Added new tooltip which shows what day of the week the webinar belongs to

= 2.2 =
* Added WPBakery Page Builder Support
* Updated some wording on documentation

= 2.1 =
* Added a new caching system for getting upcoming webinars and webinar details which significantly improves loading times and also reduces api requests to GoToWebinar
* Remove debug mode setting and replaced it with clear cache option
* Added new days filter to get a particular amount of webinars in the future
* Replaced CDN of external script to an HTTPS script to make things more secure for those using HTTPS

= 2.0 =
* You can now register for GoToWebinar's using a shortcode to display the registration details of one webinar or there's a setting which enables you to turn all register links in the upcoming webinars display to go to a new registration page on your site. 
* New debug mode to reduce API requests for development

= 1.1 =
* Added better documentation including this Wordpress plugin page and in the plugins settings page
* Added new super simple authentication method to connect the plugin to a users GoToWebinar account
* Added color options so a user can now set the color of icons and the tooltip
* Added a new hide parameter in the shortcode and a hide option in the widget to hide words/phrases from the title of the webinar

= 1.0 =
* Initial launch of the plugin


== Upgrade Notice ==

= 14.36 =
* Compatibility Update

= 14.35 =
* Fixes and added flexibility for calendar

= 14.34 =
* Bug fixes

= 14.33 =
* Force check for plugin updates

= 14.32 =
* Added filter to change recording assets

= 14.31 =
* Ability to filter recording assets start date

= 14.30 =
* Fix for timezone conversion

= 14.29 =
* Fixing of ajax spinner

= 14.28 =
* Bug fix in version 14.27

= 14.27 =
* Added a new shortcode parameter and filter to modify the thank you page for the registration form

= 14.26 =
* Added a filter for the source

= 14.25 =
* Additional filter for registration page

= 14.24 =
* Bug fix for copy billing details button

= 14.23 =
* Help fix PHP errors

= 14.22 =
* Fix to date transation when using WordPress date

= 14.21 =
* Compatibility with WordPress 5.5

= 14.20 =
* Better code for getting upcoming webinars for registration form shortcode

= 14.19 =
* Minor bug fixes

= 14.18 =
* Makes --Select-- translateable

= 14.17 =
* Removal of PHP errors from checkout

= 14.16 =
* Added registration actions

= 14.15 =
* Changing of function names to reduce conflict

= 14.14 =
* Made GDPR text translateable 

= 14.13 =
* New option to use the WordPress date and time format and functioning of the getting of the date and time to make things more streamlined

= 14.12 =
* Fixed minor bug on submit button of registration form

= 14.11 =
* New pro option to disable sending of query strings to thank you page

= 14.10 =
* Better compatibility with Contact Form 7 Recapcta

= 14.9 =
* Updates to how recording downloads are managed

= 14.8 =
* Small bug fix of shortcode.php 

= 14.7 =
* Timezone fix for shortcode display

= 14.6 =
* Updated support for recording assets by getting previous webinars instead of recording assets

= 14.5 =
* Added support for source

= 14.4 =
* Fix for creating webinar products which don't have descriptions

= 14.3 =
* PHP 7.3 compatibility
* New filters if there are no webinars

= 14.2 =
* Updated to font awesome 5

= 14.1 =
* Bug fixes

= 14.0 =
* Smarter loading of styles and scripts - sorry it took so long
* Full compliance with API v2

= 13.10 =
* Support for variable products

= 13.9 =
* Fixing of recording assets function

= 13.8 =
* Tested with WordPress 5.1.1

= 13.7 =
* New pro option: ability to change default of opt-in checkbox for email service/crm integration
* New pro option: ability to make opt-in checkbox for email/crm integration mandatory before form submits
* New pro option: MailChimp integration, require email opt-in 
* Tested with WordPress 5.1

= 13.6 =
* Fix for time conversation on single webinar page

= 13.5 =
* Quick release to ensure WordPress 5.0 compatibility. Further testing is required with WordPress 5.0 but this will hopefully be all that is needed

= 13.4 =
* We now validate the email before sending for registration because GoToWebinar's API bizarely doesn't do any validation

= 13.3 =
* Correct display of time in Webinar Product Manager (pro version)

= 13.2 =
* Smarter sorting of webinars
* new pro setting to show days in webinar countdown 

= 13.1 =
* Bug fix for showing old webinars in table when they belong to long series of webinars

= 13.0 =
* Pro feature release - now you can display webinar recordings in a table using the shortcode [gotowebinar-recordings] - please see the FAQ tab in the plugin settings for more info
* We also provide better documentation around the pro feature which shows webinar products in a table which is done by this shortcode: [gotowebinar-products] - please see the FAQ tab in the plugin settings for more info
* Minor bug fixes
* New date format options to help German users

= 12.22 =
* Fix for people with webinars that start at the exact same time

= 12.21 =
* Nicer HTML for shortcodes

= 12.20 =
* Some cleaning up of the admin area and updates to our free user support policy due to WordPress forum rules

= 12.19 =
* Better isolation of time and date picker scripts to prevent plugin conflicts

= 12.18 =
* Trimming of authentication details to remove white space before or after details which can occur when copying and pasting data

= 12.17 =
* Better versioning of CSS and javascript

= 12.16 =
* Now using javascript-based timezone detection technique to convert webinar times instead of API call because the API IP based method

= 12.15 =
* Tested with latest version of WordPress
* New connection log system which should make support easier and make it more accessible as it is now found in the support tab
* Better reporting of application used in diagnostic information
* Updated messaging and clearance of authorisation code in query string to make initial setup of plugin more expected

= 12.14 =
* Now supports simulated live webinars in the webinar product drop down (pro version only)

= 12.13 =
* You now have the option of creating your own GoToWebinar app instead of relying on our application which serves everyone. This can give you a more stable connection with GoToWebinar. Please see the new instructions just under the "General Options" tab in the plugin settings

= 12.12 =
* Added connection log to plugin for better debugging of authentication issues

= 12.11 =
* Now we get upcoming webinars from version 2 of the api so simulated live webinars are also fetched

= 12.10 =
* Now the tooltips have better CSS targeting
* Improved authentication reliability for pro users 

= 12.9 =
* Now the thank you page redirect includes time and date query strings so you can add these onto a custom thank you message
* From the plugin settings you can set the default value of the registration confirmation checkbox for better GDPR compliance

= 12.8 =
* A new pro feature commonly requested - now you can easily sell webinar recordings via WooCommerce! Simply create a new WooCommerce product that is Virtual and Downloadable and then in the "General" tab select your webinar recording from the new "Webinar recording selection" field

= 12.7 =
* Fixed compatibility issue with alternative WPBakery Page Builder, caused by WPBakery Page Builder

= 12.6 =
* Now added webinar id to thank you page query string

= 12.5 =
* Implemented a range of measures to reduce the API burden caused by the plugin. This includes: 1) reducing API calls made from plugin settings, reduced statistics to just the last week or max 10 webinars, prevented the ability to turn caching off, you can only clear the cache once now every 24 hours, calls made in the plugin settings have now been standardised under one transient name instead of separate ones for settings and the WPBakery Page Builder/tinyMCE editor. Updates have been made to the FAQ to address these changes. 

= 12.4 =
* Updated notices on free version of plugin which weren't displaying properly

= 12.3 =
* Frontend error messages only show to admins now
* First name, last name and email now sent in query string to thank you page so you can do what you want with that :) 
* Temporary disclaimer around authentication issues caused by GoToWebinar

= 12.2 =
* Now hides registration forms of old webinars

= 12.1 =
* THIS IS A REALLY IMPORTANT AND BREAKING UPDATE, PLEASE READ THIS NOTICE IN FULL!!!
* On the 14th of August 2018 GotoWebinar is going to strictly enforce the OAuth 2.0 authentication protocol for the GoToWebinar API. This means the way this plugin handles authentication is going to be a bit different as we no longer have an access token we can use indefinitely, instead we need to continually fetch access tokens for each call. But importantly what this means for you is that you need to update the plugin by at least the 14/8/18 otherwise the plugin will stop working AND when you do update the plugin it's critical you reauthenticate the plugin by clicking the new "CLICK HERE TO CONNECT WITH GOTOWEBINAR" button in the General Options tab in the plugin settings. Failing to do so will break the plugin and may cause errors on the front of your site. SO UPDATE AND REAUTHENTICATE and everyone will be happy.

= 12.0 =
* Now you can use AND or OR conditions in the include or exclude parameters of shortcodes and use AND conditions in the hide parameters of shortcodes. For example [gotowebinar include="PublicANDWebinarANDNew York" exclude="PrivateORTest" hide="PublicANDWebinar"]
* Updated FAQ tab to give examples of above
* Refactoring of code used in shortcodes
* Tested with WordPress 4.9.4
* Pro update, use the new shortcode [gotowebinar-products] to display a table of webinar products on any post or page
* Fix for IE bug on select fields on registration forms which were required but the form failed initial validation 
* Only implements Google reCAPTCHA script if setting enabled

= 11.4 =
* Pro update, Added Zoho workflow trigger option to trigger workflows in Zoho if required

= 11.3 =
* Pro update, now automatic updates

= 11.2 =
* Pro update, now payments made via non instant methods (like bank transfer) will not register the person for a webinar after checkout. Instead these orders need to marked as completed on the WooCommerce orders page for the person to be registered for a webinar.  
* Tested to version 4.9.1 of WordPress

= 11.1 =
* Fixes logging issue that may cause success message not to display on the webinar registration form

= 11.0 =
* New Webinar Countdown Toolbar feature for pro users which displays a live countdown until the next webinar begins on the front end of the site
* Adds translation support for WooCommerce Checkout items

= 10.2 =
* Re-enables authentication check on plugin settings which was accidently removed in version 10
* Fixed timezone conversion error when creating webinars with the pro version of the plugin.

= 10.1 =
* Removes javascript console error on form submissions by free users of the plugin.

= 10.0 =
* The settings have been completely rebuilt from scratch to provide better compliance to WordPress settings standards and to provide better commonality between other plugins by Northern Beaches Websites. This should make the code far more extendable in the future. From a user perspective there should be pretty little change.
* You can now add a new opt in condition for the registration form to be submitted. This label can also be translated in the translations settings of the plugin. 
* The pro version of the plugin now has heaps more integrations. These new integrations include: Campaign Monitor, Hubspot CRM, Insightly CRM, Highrise CRM, Agile CRM, Pipedrive CRM, Salesforce CRM and Zoho CRM. So the pro ad has been updated as a result. 
* Now has TinyMCE support so if you aren't using the WPBakery Page Builder plugin you can now insert shortcodes just as easily using the standard WordPress content editor!
* New log tab so you can see all the activity of the plugin
* You can now check out how your webinars are performing with the pro version of the plugin

= 9.2 =
* The plugin now shows an authentication status message on the plugin settings page. This can help users who have account issues.

= 9.1 =
* New video showcasing all the features of WP GoToWebinar
* Nicer display of times in calendar

= 9.0 =
* An all new way to display webinars with a new calendar view! Just use the new shortcode [gotowebinar-calendar]. Please check out the plugin FAQ to learn more
* Localised scripts and css files to improve page loading times

= 8.12 =
* Now you can use the additional parameters: 'include','exclude' and 'timezone' to show a registration form for the most upcoming webinar which meets those parameters. Thanks Marcin for the suggestion.
* Fixed WPBakery Page Builder general registration shortcode from not displaying in grid

= 8.11 =
* Now in the translation tab you can set a custom required message for registration form fields

= 8.10 =
* Fixed PHP error on one of the WPBakery Page Builder file

= 8.9 =
* Resolved missing instances in version 8.8 update

= 8.8 =
* Hopefully should fix retrieving body from ajax request on old versions of PHP

= 8.7 =
* Loaded jQueryUI to fix for older versions of WordPress

= 8.6 =
* Opened up the 'Support' tab for the free version of the plugin. And provided more strict guidelines before posting to the WordPress forum to allow me to better diagnose issues and help people.

= 8.5 =
* Implementation support for new pro feature - integration with ActiveCampaign

= 8.4 =
* Removed unnecessary jQuery Validation script from plugin

= 8.3 =
* Updated translation of minutes for German language. Thanks Gernot!

= 8.2 =
* Tested with WordPress 4.7.5
* Added new setting option to display a custom error message if the attendee limit is reached

= 8.1 =
* Now if a user is logged in the registration form will be autocompleted with the logged in users first name, last name and email address

= 8.0 =
* Updated base URL of API calls to new address so the plugin will continue to work in 2018 and beyond
* Improved logic for showing a certain amount of webinars for widget when a webinar is a sequence or series webinar
* Fixed issue with previous webinars showing in the widget if they are part of a series or sequence webinar and they have passed
* Fixed PHP bug which could show if you have nominated not to show time conversion
* Tested with WordPress version 4.7.4

= 7.10 =
* Pro version update makes creating webinars not show unnecessary error messages

= 7.9 =
* Pro version update which includes new option to not make past webinar products draft

= 7.8 =
* Pro version updates and compatibility

= 7.7 =
* Removes error message caused by code which disables updates

= 7.6 =
* Bug fix of code in previous release 7.5 which prevented error message of timezone comparison not show

= 7.5 =
* If the location of a user can't be detected via their IP address it will now show a custom error message which can be set in the settings
* Fixed jQuery bug for time and date picker

= 7.4 =
* Updated German translation of register link
* Minor updates of settings user interface
* Gave registration form messages unique class names

= 7.3 =
* Fixes break caused by previous new setting in case it is not set

= 7.2 =
* Added 24 hour time format support with new setting

= 7.1 =
* Updated default success message of registration form so the URL is now working correctly

= 7.0 =
* Tested with Wordpress 4.7
* Major refactoring of code for upcoming webinars to reduce code and make updates easier
* You can now display a registration form of your next webinar using a new shortcode parameter
* Updated registration form spinner so it only runs on the form submit and not the time conversion 
* You can now have more than one registration form work successfuly on a single page 

= 6.10 =
* Minor update to prevent pro users receiving updates from Wordpress.org

= 6.9 =
* You can now put Google reCAPTCHA on your registration form, a new setting can be found in the General Options tab

= 6.8 =
* Bug fix from previous update as the timezone conversion feature will now work in HTTPS

= 6.7 =
* Bug fix from previous update as the timezone conversion feature will now work in HTTPS

= 6.6 =
* Timezone conversion now works on Firefox and some other browsers
* Timezone conversion now uses IP detection  to identify users location rather than the users browser clock which means timezone conversion works on proxy servers

= 6.5 =
* Better cache management of registration page information so only successful calls are cached
* Added new error message management in translation settings so you can add a custom error message if a webinar has been cancelled or an incorrect webinar ID has been specified

= 6.4 =
* Added quickstart guide with permanently dismissable notice
* Custom theme files can now be placed in the child theme if available
* Fixed display of settings tab for people on older versions of Wordpress

= 6.3 =
* Prevents clear cache action from occuring twice
* Improved security
* Simplification of javascript code when submitting registration form

= 6.2 =
* Loads external Jquery UI script via HTTPS, before this ui features might not work on HTTPS sites on the settings page

= 6.1 =
* Minor re-arrangement of code
* Complete re-organisation of settings page into tabs which makes it more digestible and better displays pro version features

= 6.0 =
* Announcement and compatibility with new WP GoToWebinar Pro - the easiest way to sell webinars!

= 5.11 =
* Allows for theme templates of shortcode files

= 5.10 =
* Additional update to version 5.7 with time conversion not working on single registration pages

= 5.9 =
* Minor bug fix for users on PHP 5.3

= 5.8 =
* Made it easier to selectively hide upcoming webinars columns using CSS

= 5.7 =
* Fixes issue with time conversion not working due to browser updates.

= 5.6 =
* Minor bug fixes for display of single webinar registration forms.

= 5.5 =
* Better error handling for the registration page.

= 5.4 =
* Better error handling if the API call to GoToWebinar doesn't succeed. Also fixed the clear cache button which broke from a previous update.

= 5.2 =
* Fixed minor PHP error due to 5.1 release

= 5.1 =
* This update is just an administration update. A lot of the code has been re-organised to allow for easier editing and updating in the future, particularly for the pro version. It also includes testing with Wordpress 4.6

= 5.0 =
* Now users can convert times and dates by clicking the timezone conversion link which can be enabled in the settings

= 4.6 =
* Minor styling changes - mainly so that webinar description formatting will display more like what it's on in GoToWebinar

= 4.5 =
* Added new custom thank you page option after successful registration to use instead of the default or customised thank you message. You can still use the default/customised message - and this is great because it is fast. But I realised that some people want to put tracking/conversion code on thank you pages after a successful registration so this thank you page selection caters for this better.

= 4.3 =
* You can now have custom success, error and already registered messages via the settings page.

= 3.5 =
* This and similar version 3 releases addresses a lot of bugs experienced by some users.

= 2.0 =
* Customers can now register GoToWebinar's on your website! Please see Settings > WP GoToWebinar for details.

= 1.1 =
* Added better documentation and better authorisation to GoToWebinar.

= 1.0 =
* This is the first version of the plugin. No updates available yet.