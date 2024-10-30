=== Israel cities dropdown ===
Contributors: meravwebs
Tags: Israel cities, woocommerce
Requires at least: 4.9
Tested up to: 6.5.3
Stable tag: 1.5
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Changes checkout page city field to dropdown with Israel cities.

== Description ==

Israel cities is a simple, light, easy to use plugin.
the purpose of this plugin is to change the city field in the checkout page to dropdown with Israel cities.
The plugin rely on 3rd party as a service, the 3rd party is the Israeli government service to get the list of all the Israeli cities, no data is being sent to this service.
According to the terms we're authorized to copy, distribute and make the data available for the public.
The terms forbid the use of data if it breaks the law or break privacy of person.
The link to the service is: https://data.gov.il/api/3/action/datastore_search
The link to Israeli government terms is: https://data.gov.il/terms

== Changelog ==
= 1.5 =
* Bug fix: Fix Fattal error on updated php versions

= 1.4 =
* Bug fix: Change Ajax object name

= 1.3 =
* Bug fix: Load jQuery UI over https

= 1.2 =
* change dropdown to autocomplete

= 1.1 =
* Set DB table to utf8_general_ci

== Upgrade Notice ==

= 1.2 =
This upgrade replace the previous version of the dropdown with much more freindlier version of autocomplete suggestions from the Israel Cities list

= 1.1 =
This upgrade force DB table charset to be utf8 (which support Hebrew character), so there won't be unrecognized characters.