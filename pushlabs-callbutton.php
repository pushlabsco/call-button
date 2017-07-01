<?php
/*
Plugin Name: Call Button
Plugin URI: https://pushlabs.co/
Description: A call button placed on your website to instantly increase conversions!
Version: 1.0
Author: Push Labs
Author URI: https://pushlabs.co
Text Domain: pushlabs-callbutton
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
define( 'PUSHLABS_CALLBUTTON_PLUGIN_VERSION', '1.0' );

// Include necessary classes and frameworks
if( file_exists( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2/init.php' ) ) {
  require_once( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2/init.php' );
}
if( file_exists( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/classes/options_page.php' ) ) {
  require_once( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/classes/options_page.php' );
}
if( file_exists( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/register_metabox.php' ) ) {
  require_once( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/register_metabox.php' );
}
if( file_exists( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2-radio-image/cmb2-radio-image.php' ) ) {
  require_once( PUSHLABS_CALLBUTTON_PLUGIN_PATH . 'inc/vendor/cmb2-radio-image/cmb2-radio-image.php' );
}

/**
 * Load the plugin text domain for localization
 *
 * @since 1.0
 * @link https://codex.wordpress.org/I18n_for_WordPress_Developers
 *
 * @uses load_plugin_textdomain()
 */
function pushlabs_callbutton_load_textdomain() {
  /**
   * Using basename( dirname( __FILE__ ) ) instead of PUSHLABS_CALLBUTTON_PLUGIN_BASE
   * due to open_basedir() issues.
   */
  load_plugin_textdomain( 'pushlabs-callbutton', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'pushlabs_callbutton_load_textdomain' );

/**
 * Enqueue admin scripts and styles in the backend
 *
 * @since 1.0
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
 * @since 1.0
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
 * @since 1.0
 */
function pushlabs_callbutton_inline_css() {
  $prefix = 'pushlabs_callbutton_';
  $style_button_prefix = $prefix . 'style_button_';
  $style_banner_prefix = $prefix . 'style_banner_';

  // Get our data
  $mobile_breakpoint = pushlabs_callbutton_get_option( $prefix . 'breakpoint' );
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

  if ( !empty( $mobile_breakpoint ) ) {
    $mobile_breakpoint = $mobile_breakpoint;
  } else {
    $mobile_breakpoint = '768';
  }

  $css .= '@media (min-width: ' . $mobile_breakpoint . 'px) { .pushlabs-callbutton { display: none !important; } }';

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
 * Add settings link to the plugin's page
 *
 * @since 1.0
 * @param @links string settings link
 * @return string link on the plugin's page.
 *
 * @uses __()
 */
function pushlabs_callbutton_settings_link( $links ) {
  $settings_link = __( '<a href="options-general.php?page=pushlabs_callbutton">Settings</a>', 'call-button' );
  array_unshift($links, $settings_link);
  return $links;
}
add_filter('plugin_action_links_' . PUSHLABS_CALLBUTTON_PLUGIN_BASE, 'pushlabs_callbutton_settings_link' );

/**
 * The post types that our metabox will be shown on.
 *
 * @since 1.0
 * @uses apply_filters()
 * @return array Array of post types Call Button uses
 */
function pushlabs_callbutton_post_types() {
  $post_types = array( 'post', 'page' );
  $post_types = apply_filters( 'pushlabs_callbutton_post_types', $post_types );

  return $post_types;
}

/**
 * Dequeue Font Awesome Filter
 *
 * @since 1.0
 */
function pushlabs_callbutton_dequeue_fontawesome() {
  $dequeue = false;
  $dequeue = apply_filters( 'pushlabs_callbutton_dequeue_fontawesome', $dequeue );


  return $dequeue;
}


/**
 * Only display the metabox if the user wants it
 *
 * @since 1.0
 *
 * @param  object $cmb Current box object
 * @return bool True if current user's ID is 1
 */
function pushlabs_callbutton_hide_metabox() {
  $prefix = 'pushlabs_callbutton_';

  $is_visible = pushlabs_callbutton_get_option( $prefix . 'hide_metabox' );

  if ( !empty( $is_visible ) ) {
    return false;
  } else {
    return true;
  }
}

/**
 * Build the call button
 *
 * @since 1.0
 */
function pushlabs_callbutton_button() {
  // Establish some variables
  $style_prefix = 'pushlabs_callbutton_style_';
  $class = 'pushlabs-callbutton-';
  $metabox_prefix = 'pushlabs_callbutton_metabox_field_';


  // If we are on a page or post and there is metabox data, use it.
  $is_metabox_visible = pushlabs_callbutton_get_option( 'pushlabs_callbutton_hide_metabox' );
  $phone_metabox = $disable_metabox = '';
  $style_metabox = 'default';
  if ( empty( $is_metabox_visible ) ) {
    if( is_page() || is_single() || is_home() && get_option( 'show_on_front') == 'page' ) {
      // Identify if we are on a page or the home page and grab the ID conditionally
      if( is_page() || is_single() ) {
        $the_id = get_the_ID();
      } elseif( is_home() && get_option( 'show_on_front' ) == 'page' ) {
        $the_id = get_option( 'page_for_posts' );
      }

      // Our metabox data
      $phone_metabox = get_post_meta( $the_id, $metabox_prefix . 'phone', true );
      $disable_metabox = get_post_meta( $the_id, $metabox_prefix . 'disable', true );
      $style_metabox = get_post_meta( $the_id, $metabox_prefix . 'style', true );
    }
  }

  // Our settings data
  $phone_option = pushlabs_callbutton_get_option( 'pushlabs_callbutton_phone' );
  $style_option = pushlabs_callbutton_get_option( 'pushlabs_callbutton_style' );
  $button_position_option = pushlabs_callbutton_get_option( 'pushlabs_callbutton_style_button_position' );
  $button_size_option = pushlabs_callbutton_get_option( 'pushlabs_callbutton_style_button_size' );
  $banner_text_option = pushlabs_callbutton_get_option( 'pushlabs_callbutton_style_banner_text' );

  // Declare our data
  $phone_obj = ( !empty( $phone_metabox ) ? $phone_metabox : $phone_option );
  $style_obj = ( $style_metabox != 'default' ? $style_metabox : $style_option );
  $button_position_obj = $button_position_option;
  $button_size_obj = $button_size_option;
  $banner_text_obj = $banner_text_option;

  // If no phone number is provided, quit
  if ( empty( $phone_option ) ) {
    return;
  }

  if ( !empty( $disable_metabox ) ) {
    return;
  }

  // Essemble the style class
  $style = $class . 'style--' . $style_obj;

  // Essemble the position class
  if ( $style_obj === 'button' ) {
    $position = $class . 'position--' . $button_position_obj;
  } else {
    $position = '';
  }

  // Essemble the size class
  if ( $style_obj === 'button' ) {
    $size = $class . 'size--' . $button_size_obj;
  } else {
    $size = '';
  }

  // Filter to change the icon class
  $icon_class = 'fa-phone';
  $icon_class = apply_filters( 'pushlabs_callbutton_icon_class', $icon_class );

  // Create the icon
  $icon = '';
  if ( $style_obj === 'button' ) {
    $icon = '<span class="fa-stack fa-2x">';
    $icon .= '<i class="fa fa-circle fa-stack-2x ' . $class . 'shadow"></i>';
    $icon .= '<i class="fa fa-circle fa-stack-2x ' . $class . 'background"></i>';
    $icon .= '<i class="fa fa-circle-thin fa-stack-2x border ' . $class . 'background-white"></i>';
    $icon .= '<i class="fa ' . $icon_class . ' ' . $class . 'icon-pos fa-stack-1x"></i>';
    $icon .= '</span>';
  } else {
    $icon .= '<i class="fa ' . $icon_class . ' ' . $class . 'icon-pos"></i>';
  }

  // Add text if applicable
  $text = '';
  if ( $style_obj === 'banner' ) {
    $text .= $banner_text_obj;
  }

  // Create the button
  $button = '<a href="tel:' . $phone_obj . '" class="pushlabs-callbutton ' . $style . ' ' . $size . ' ' . $position . '">';
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

/**
 * Create our custom Phone field for CMB2
 *
 * @since 1.0
 */
function cmb2_render_callback_for_pushlabs_callbutton_number( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
  // Choose our input type
  echo $field_type_object->input( array( 'type' => 'number', 'class' => 'medium-text' ) );
}
add_action( 'cmb2_render_pushlabs_callbutton_number', 'cmb2_render_callback_for_pushlabs_callbutton_number', 10, 5 );

/**
 * Sanitize our custom phone field for CMB2
 *
 * @since 1.0
 */
function cmb2_sanitize_pushlabs_callbutton_number_callback( $null, $new ) {
  // Sanitize the input
  $new = preg_replace( "/[^0-9]/", "", $new );
  return $new;
}
add_filter( 'cmb2_sanitize_pushlabs_callbutton_number', 'cmb2_sanitize_pushlabs_callbutton_number_callback', 10, 2 );
