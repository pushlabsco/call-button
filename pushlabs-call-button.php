<?php
/*
Plugin Name: Call Button
Plugin URI: https://pushlabs.co/
Description: A call button placed on your website to instantly increase conversions!
Version: 0.1
Author: Push Labs
Author URI: https://pushlabs.co
Text Domain: call-button
Domain Path: /languages
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

// Define some constants
define( 'PUSHLABS_CALLBUTTON_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PUSHLABS_CALLBUTTON_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PUSHLABS_CALLBUTTON_PLUGIN_BASE', plugin_basename(__FILE__) );
define( 'PUSHLABS_CALLBUTTON_PLUGIN_VERSION', '0.1' );

// Include necessary classes and frameworks
if( file_exists( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2/init.php' ) ) {
  require_once( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2/init.php' );
}
if( file_exists( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/classes/options_page.php' ) ) {
  require_once( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/classes/options_page.php' );
}
if( file_exists( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2-conditionals/cmb2-conditionals.php' ) ) {
  require_once( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2-conditionals/cmb2-conditionals.php' );
}
if( file_exists( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2-radio-image/cmb2-radio-image.php' ) ) {
  require_once( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2-radio-image/cmb2-radio-image.php' );
}

/**
 * Load the plugin text domain for localization
 *
 * @since 0.1
 * @link https://codex.wordpress.org/I18n_for_WordPress_Developers
 *
 * @uses load_plugin_textdomain()
 */
function pushlabs_callbutton_load_textdomain() {
  /**
   * Using basename( dirname( __FILE__ ) ) instead of PUSHLABS_CALLBUTTON_PLUGIN_BASE
   * due to open_basedir() issues.
   */
  load_plugin_textdomain( 'call-button', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'pushlabs_callbutton_load_textdomain' );

/**
 * Enqueue admin scripts and styles in the backend
 *
 * @since 0.1
 *
 * @uses wp_enqueue_style()
 * @uses wp_enqueue_script()
 */
function pushlabs_callbutton_enqueue_admin_scripts() {
  // @TODO enqueue on condition
  wp_enqueue_style( 'pushlabs-callbutton-backend', PUSHLABS_CALLBUTTON_PLUGIN_URL . 'assets/css/pushlabs-callbutton-backend.css', array(), PUSHLABS_CALLBUTTON_PLUGIN_VERSION );
  wp_enqueue_script( 'pushlabs-callbutton-backend', PUSHLABS_CALLBUTTON_PLUGIN_URL . 'assets/js/pushlabs-callbutton-backend.js', array( 'jquery' ), PUSHLABS_CALLBUTTON_PLUGIN_VERSION );

  wp_add_inline_script( 'pushlabs-callbutton-backend', 'var pushlabs_callbutton = {"imgUrl":"' . PUSHLABS_CALLBUTTON_PLUGIN_URL . 'assets/img/"}' );
}
add_action( 'admin_enqueue_scripts', 'pushlabs_callbutton_enqueue_admin_scripts' );

/**
 * Enqueue Call Button scripts and styles for the frontend
 *
 * @since 0.1
 *
 * @uses wp_enqueue_script()
 * @uses wp_enqueue_style()
 */
function pushlabs_callbutton_enqueue_scripts() {
  wp_enqueue_style( 'pushlabs-callbutton', PUSHLABS_CALLBUTTON_PLUGIN_URL . 'assets/css/pushlabs-callbutton.css', array(), PUSHLABS_CALLBUTTON_PLUGIN_VERSION );
  wp_enqueue_style( 'pushlabs-callbutton-fontawesome', PUSHLABS_CALLBUTTON_PLUGIN_URL . 'inc/vendor/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
}
add_action( 'wp_enqueue_scripts', 'pushlabs_callbutton_enqueue_scripts' );

/**
 * Enqueue our inline CSS styles created from the settings page.
 *
 * @since 0.1
 */
function pushlabs_callbutton_inline_css() {
  $prefix = 'pushlabs_callbutton_';
  $style_button_prefix = $prefix . 'style_button_';
  $style_banner_prefix = $prefix . 'style_banner_';

  // Get our data
  $style_button_bg_color = pushlabs_callbutton_get_option( $style_button_prefix . 'bg_color' );
  $style_button_color = pushlabs_callbutton_get_option( $style_button_prefix . 'color' );
  $style_button_shadow = pushlabs_callbutton_get_option( $style_button_prefix . 'shadow' );
  $style_button_border = pushlabs_callbutton_get_option( $style_button_prefix . 'border' );
  $style_button_border_color = pushlabs_callbutton_get_option( $style_button_prefix . 'border_color' );
  $style_banner_bg_color = pushlabs_callbutton_get_option( $style_banner_prefix . 'bg_color' );
  $style_banner_color = pushlabs_callbutton_get_option( $style_banner_prefix . 'color' );
  $style_banner_border = pushlabs_callbutton_get_option( $style_banner_prefix . 'border' );
  $style_banner_font_size = pushlabs_callbutton_get_option( $style_banner_prefix . 'font_size' );

  // Create our variable
  $css = '';

  if ( !empty( $style_button_bg_color ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--button .pushlabs-callbutton-background {color: ' . $style_button_bg_color . '}';
  }
  if ( !empty( $style_button_color ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--button .pushlabs-callbutton-icon-pos {color: ' . $style_button_color . '}';
  }
  if ( !empty( $style_button_shadow ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--button .pushlabs-callbutton-shadow {display: none}';
  }
  if ( !empty( $style_button_border ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--button .pushlabs-callbutton-background-white {display: none}';
  }
  if ( !empty( $style_button_border_color ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--button .pushlabs-callbutton-background-white {color: ' . $style_button_border_color . '}';
  }
  if ( !empty( $style_banner_bg_color ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--banner {background-color: ' . $style_banner_bg_color . '}';
  }
  if ( !empty( $style_banner_color ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--banner {color: ' . $style_banner_color . '}';
  }
  if ( !empty( $style_banner_border ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--banner {border-top: 1px solid ' . $style_banner_border . '}';
  }
  if ( !empty( $style_banner_font_size ) ) {
    $css .= '.pushlabs-callbutton.pushlabs-callbutton-style--banner {font-size: ' . $style_banner_font_size . 'px}';
  }

  wp_add_inline_style( 'pushlabs-callbutton', $css );

}
add_action( 'wp_enqueue_scripts', 'pushlabs_callbutton_inline_css' );

/**
 * Build the call button
 *
 * @since 0.1
 */
function pushlabs_callbutton_button() {
  // Our Data
  $style_prefix = 'pushlabs_callbutton_style_';
  $phone_meta = pushlabs_callbutton_get_option( 'pushlabs_callbutton_phone' );
  $style_meta = pushlabs_callbutton_get_option( 'pushlabs_callbutton_style' );
  $button_position_meta = pushlabs_callbutton_get_option( 'pushlabs_callbutton_style_button_position' );
  $banner_text_meta = pushlabs_callbutton_get_option( 'pushlabs_callbutton_style_banner_text' );

  // Establish some variables
  $class = 'pushlabs-callbutton-';


  $style = $class . 'style--' . $style_meta;

  if ( $style_meta === 'button' ) {
    $position = $class . 'position--' . $button_position_meta;
  } else {
    $position = '';
  }

  $icon_class = 'fa-phone';

  // If no phone number is provided, don't show the button
  if ( empty( $phone_meta ) ) {
    return;
  }

  // Create the icon
  $icon = '';
  if ( $style_meta === 'button' ) {
    $icon = '<span class="fa-stack fa-2x">';
    $icon .= '<i class="fa fa-circle fa-stack-2x ' . $class . 'shadow"></i>';
    $icon .= '<i class="fa fa-circle fa-stack-2x ' . $class . 'background"></i>';
    $icon .= '<i class="fa fa-circle-thin fa-stack-2x border ' . $class . 'background-white"></i>';
    $icon .= '<i class="fa ' . $icon_class . ' ' . $class . 'icon-pos fa-stack-1x"></i>';
    $icon .= '</span>';
  } else {
    $icon .= '<i class="fa ' . $icon_class . ' ' . $class . 'icon-pos"></i>';
  }

  $text = '';
  if ( $style_meta === 'banner' ) {
    $text .= $banner_text_meta;
  }

  // Create the button
  $button = '<a href="tel:' . $phone_meta . '" class="pushlabs-callbutton ' . $style . ' ' . $position . '">';
  $button .= '<span class="pushlabs-callbutton-container">';
  $button .= $icon;
  $button .= $text;
  $button .= '</span>';
  $button .= '</a>';

  // Output the button
  $output = $button;
  echo $output;
}
add_action( 'wp_footer', 'pushlabs_callbutton_button' );
