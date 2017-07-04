=== Plugin Name ===
Contributors: pushlabs
Tags: call button, call now, call, button, metabox, mobile, directory, sales, phone, contact, contact now
Requires at least: 3.8.0
Tested up to: 4.8
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A modern, easy to use call button that shoots to increase conversions and drive sales!

== Description ==

This plugin is an easy and simple way to add a call button to your website for your mobile users. This plugin aims to increase conversions and drive sales by enticing customers to click the button and immediately get in contact with you.

The only thing required to activate the plugin is to enter your phone number and you are good to go!

Additionally, there are a ton of optional features to use to customize the button:

* Mobile Breakpoint: Set the pixel breakpoint when you would like your button/banner to appear.
* Styles: Call Button comes with two different styles: the button, and the banner.
* Button Position: Position your button to the left, middle, or right!
* Button Size: Choose between three button sizes: small, medium, and large.
* Button Background Color: Customize the background color of your button.
* Button Icon Color: Change the icon color to your choosing.
* Button Shadow: enable/disable the shadow of the button.
* Button Border: enable/disable the border of the button.
* Button Border Color: Customize the color of the border.
* Banner Background Color: Customize the background color of your banner.
* Banner Border Color: Add a border to your banner if you would like!
* Banner Text: Add engaging text to your banner to provoke action!
* Banner Font size: change the font size
* Banner Text color: change the text color
* Metabox with customizable settings for each page post.

As mentioned, Call Button also includes a metabox on each page/post where you can customize the phone number, style, or disable the button/banner for that page/post only!

== Installation ==

Installation is simple.

1. Upload `call-button` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Fill in the settings on the “Call Button” page under settings.

== Frequently Asked Questions ==

= Is there any way to add the metabox to custom post types? =

You sure can with a simple filter!
`
/**
 * Push Labs Call Button Post types
 *
 * @author Push Labs
 */
function themeprefix_callbutton_post_types( $post_types ) {
  $post_types = array( 'post', 'page' );

  return $post_types;
}
add_filter( 'pushlabs_callbutton_post_types', 'themeprefix_callbutton_post_types' );
`

= Can I change the Icon? =

Of course! This is done through a filter at the moment. Please see the code below:
`
/**
 * Push Labs Call Button Icon Class
 *
 * @author Push Labs
 */
function themeprefix_callbutton_icon_class( $icon_class ) {
  // Call Button uses Font Awesome. You can use any of their icons in this field.
  $icon_class = 'fa-phone';

  return $icon_class;
}
add_filter( 'pushlabs_callbutton_icon_class', 'themeprefix_callbutton_icon_class' );
`

= How do I add my phone number? =

To add your phone number, go to the Settings > Call Button page and enter your number. Enter only the numbers, special characters are not allowed.

= I already have Font Awesome Installed! Can I dequeue the reference Call Button uses? =

Sure thing! If you already have Font Awesome installed and don't want to use Call Button's, you can use this filter to dequeue it.
`
/**
 * Push Labs Call Button Dequeue Font Awesome
 *
 * @author Push Labs
 */
function themeprefix_callbutton_dequeue_fontawesome( $dequeue ) {
  // True or false
  $dequeue = true;

  return $dequeue;
}
add_filter( 'pushlabs_callbutton_dequeue_fontawesome', 'themeprefix_callbutton_dequeue_fontawesome' );
`

== Screenshots ==

1. Call Button Settings Page
2. Call Button Button Styles
3. Call Button Banner Styles
4. Call Button Color Picker
5. Call Button Add Your Own Text
6. Call Button Post/Page Metabox Settings
7. Call Button Example 1
8. Call Button Example 2
9. Call Button Example 3
10. Call Button Example 4

== Changelog ==

= 1.0 =
* Initial Release
