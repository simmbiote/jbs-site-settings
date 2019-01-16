=== JBS Site Settings === 

Contributors: simmbiote999 \
Donate link: jbsimms.co.za \
Tags: settings, development, theming \
Requires at least: 3.0.1 \
Tested up to: 3.4 \
Stable tag: 4.3 \
License: GPLv2 or later \
License URI: http://www.gnu.org/licenses/gpl-2.0.html 

A WordPress Plugin that allows developers to easily add editable settings to a WordPress installation. Compatible with WPML.

== Description ==

A WordPress Plugin that allows developers to easily add editable settings to a WordPress installation.
Compatible with WPML - For each active language, a field for the setting value is made available.

== Installation ==

Install using Composer:
`composer require simmbiote/jbs-site-settings`

Go to `Settings > Theme Settings` in the main menu.

== Possible uses ==

* Defining tracking codes.
* Set a feature to enabled / disabled (eg. maintenance mode).
* Add password-protection to your site.
* Define the URL to your Facebook page and use the link anywhere.

Usage:

Shortcode:
`[site-setting id="your-setting-id"]`

PHP
`<?php echo get_sim_setting('your-setting-id'); ?>`


== Features to come ==

✓ Shortcode for usage in editor content. \
✓ Ability to export settings. \
✓ Ability to import settings. \
* Ability to delete settings.

