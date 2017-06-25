=== WP Simple Redirect ===
Contributors: Arevico
Donate Link: http://eepurl.com/b-6Xan
Tags: short link, simple redirect, manage, pages, permalink, post, redirect, seo
Requires at least: 3.0
Tested up to: 4.6
Stable tag: 1.1

Create short links and redirect in your WordPress dashboard, both simple links as well as regular expression matching.

== Description ==
Create short links and redirect in your WordPress dashboard, both simple links as well as regular expression matching.

Features:

1. Fast and efficient (doesn't use rewrite rules)
1. Simple and easy 
1. Global Variables: Add variables such as Affiliate ID, IP Address to the redirected link.
1. Custom Variables: You can also define your own variables to add.
1. Global Prefix: prefix a string like /go/ before all links. This will make sure the database is not queried unnecesarily

Link Matching Options

1. Starts with: match the url if it start with a pattern
2. Contains: match the url if it contains a pattern
3. Regular Expressions: you can capture a portion of the url and reuse it in the redirect 'fore example example.com/watch/(.*)'

== Installation ==
1. Upload "arevico-redirect.php" to the "/wp-content/plugins/" directory.
1. Activate the plugin through the "Plugins" menu in WordPress.

== Frequently Asked Questions ==

= I updated a redirect, but i still getting an old redirect? =

When using a 301 Permanent Redirect, the browser stores this redirect to redirect faster in the future. To solve this, use a 307 redirect when testing and/or clear the browser cache. On most major browsers, the shortcut ctrl + shift + delete can be used for this.

== Screenshots == 

1. Customer Variables and System Variables
1. Global Options. Use a global prefix and redirect when no links are found
1. An overview of all redirects

== Changelog ==
= 1.0 =
The initial release. 