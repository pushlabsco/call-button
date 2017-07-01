<?php
/**
 * Exit if accessed directly
 */
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Call Button Options Page
 * @version 1.0
 */
class Pushlabs_Callbutton_Options {
  /**
    * Option key, and option page slug
    * @var string
    */
  protected $key = 'pushlabs_callbutton';
  /**
    * Options page metabox id
    * @var string
    */
  protected $metabox_id = 'pushlabs_callbutton_metabox';
  /**
   * Options Page title
   * @var string
   */
  protected $title = '';
  /**
   * Options Page hook
   * @var string
   */
  protected $options_page = '';
  /**
   * Holds an instance of the object
   *
   * @var Myprefix_Admin
   */
  protected static $instance = null;
  /**
   * Returns the running object
   *
   * @return Myprefix_Admin
   */
  public static function get_instance() {
    if ( null === self::$instance ) {
      self::$instance = new self();
      self::$instance->hooks();
    }
    return self::$instance;
  }
  /**
   * Constructor
   * @since 1.0
   */
  protected function __construct() {
    // Set our title
    $this->title = __( 'Call Button', 'pushlabs-callbutton' );
  }
  /**
   * Initiate our hooks
   * @since 1.0
   */
  public function hooks() {
    add_action( 'admin_init', array( $this, 'init' ) );
    add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
  }
  /**
   * Register our setting to WP
   * @since  1.0
   */
  public function init() {
    register_setting( $this->key, $this->key );
  }
  /**
   * Add menu options page
   * @since 1.0
   */
  public function add_options_page() {
    $this->options_page = add_options_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
    // Include CMB CSS in the head to avoid FOUC
    add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
  }
  /**
   * Admin page markup. Mostly handled by CMB2
   * @since  1.0
   */
  public function admin_page_display() {
    ?>
    <div class="wrap cmb2-options-page <?php echo $this->key; ?>">
      <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
      <h2 class="nav-tab-wrapper wp-clearfix">
        <a href="#settings" class="nav-tab nav-tab-active"><?php _e( 'Settings', 'pushlabs-callbutton' ); ?></a>
        <a href="#styles" class="nav-tab"><?php _e( 'Styles', 'pushlabs-callbutton' ); ?></a>
      </h2>
      <?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
    </div>
  <?php
  }
  /**
   * Add the options metabox to the array of metaboxes
   * @since  1.0
   */
  function add_options_page_metabox() {
    // hook in our save notices
    add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );
    $cmb = new_cmb2_box( array(
      'id'         => $this->metabox_id,
      'hookup'     => false,
      'cmb_styles' => false,
      'show_on'    => array(
        // These are important, don't remove
        'key'   => 'options-page',
        'value' => array( $this->key, )
      ),
    ) );

    $prefix = 'pushlabs_callbutton_';

    // Set our CMB2 fields
    $cmb->add_field( array(
      'name' => __( 'Phone Number', 'pushlabs-callbutton' ),
      'desc' => __( 'Please enter your phone number including area code.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'phone',
      'type' => 'pushlabs_callbutton_number',
      'before_row' => '<div class="wrap pushlabs-callbutton-pane1">',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Mobile Breakpoint', 'pushlabs-callbutton' ),
      'desc' => __( 'If you would like to customize the breakpoint for which the button/banner appear, you can specify a pixel here. (Defualt: 768px)', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'breakpoint',
      'type' => 'pushlabs_callbutton_number',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Hide the Metabox on Posts and Pages?', 'pushlabs-callbutton' ),
      'desc' => __( 'If you don\'t need the metabox for Call Button, you can hide it here.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'hide_metabox',
      'type' => 'checkbox',
      'after_row' => '</div>',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Style', 'pushlabs-callbutton' ),
      'desc' => __( 'Please select your style.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style',
      'type' => 'radio_image',
      'default' => 'button',
      'options' => array(
        'button' => __( 'Button', 'pushlabs-callbutton'),
        'banner' => __( 'Banner', 'pushlabs-callbutton'),
      ),
      'images_path' => PUSHLABS_CALLBUTTON_PLUGIN_URL,
      'images' => array(
        'button' => 'assets/img/radio-blank.png',
        'banner' => 'assets/img/radio-banner.png',
      ),
      'before_row' => '<div class="wrap pushlabs-callbutton-pane2">',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Button Position', 'pushlabs-callbutton' ),
      'desc' => __( 'The position your button will be in.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_button_position',
      'type' => 'radio_inline',
      'options'          => array(
        'left' => __( 'Left', 'pushlabs-callbutton' ),
        'middle'   => __( 'Middle', 'pushlabs-callbutton' ),
        'right'     => __( 'Right', 'pushlabs-callbutton' ),
      ),
      'default' => 'right',
      'before_row' => '<div class="pushlabs-callbutton-style-box box-style--button"><h2>' . __( 'Button Style', 'pushlabs-callbutton' ) . '</h2><div class="pushlabs-callbutton-box-options">',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Button Size', 'pushlabs-callbutton' ),
      'desc' => __( 'The size of your button.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_button_size',
      'type' => 'radio_inline',
      'options'          => array(
        'small' => __( 'Small', 'pushlabs-callbutton' ),
        'medium'   => __( 'Medium', 'pushlabs-callbutton' ),
        'large'     => __( 'Large', 'pushlabs-callbutton' ),
      ),
      'default' => 'medium',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Background Color', 'pushlabs-callbutton' ),
      'desc' => __( 'Background color for the call button.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_button_bg_color',
      'type' => 'colorpicker',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Icon Color', 'pushlabs-callbutton' ),
      'desc' => __( 'Icon color for the call button.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_button_color',
      'type' => 'colorpicker',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Disable Shadow?', 'pushlabs-callbutton' ),
      'desc' => __( 'Toggle to enable/disable the drop shadow of the button.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_button_shadow',
      'type' => 'checkbox',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Disable Border?', 'pushlabs-callbutton' ),
      'desc' => __( 'Toggle to enable/disable the border of the button.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_button_border',
      'type' => 'checkbox',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Border Color', 'pushlabs-callbutton' ),
      'desc' => __( 'Border color for the call button if enabled.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_button_border_color',
      'type' => 'colorpicker',
      'after_row' => '</div></div>',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Background Color', 'pushlabs-callbutton' ),
      'desc' => __( 'Background color for the call banner.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_banner_bg_color',
      'type' => 'colorpicker',
      'before_row' => '<div class="pushlabs-callbutton-style-box box-style--banner"><h2>' . __( 'Banner Style', 'pushlabs-callbutton' ) . '</h2><div class="pushlabs-callbutton-box-options">',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Border Top Color', 'pushlabs-callbutton' ),
      'desc' => __( 'Add a border to the top of the banner.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_banner_border',
      'type' => 'colorpicker',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Banner Text', 'pushlabs-callbutton' ),
      'desc' => __( 'If you would like to include text after your icon, you can do that here.', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_banner_text',
      'type' => 'text',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Banner Font Size', 'pushlabs-callbutton' ),
      'desc' => __( 'Font size for the text. (In px)', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_banner_font_size',
      'type' => 'pushlabs_callbutton_number',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Text Color', 'pushlabs-callbutton' ),
      'desc' => __( 'This includes the icon and text color if applicable', 'pushlabs-callbutton' ),
      'id'   => $prefix . 'style_banner_color',
      'type' => 'colorpicker',
      'after_row' => '</div></div></div>',
    ) );


  }
  /**
   * Register settings notices for display
   *
   * @since  1.0
   * @param  int   $object_id Option key
   * @param  array $updated   Array of updated fields
   * @return void
   */
  public function settings_notices( $object_id, $updated ) {
    if ( $object_id !== $this->key || empty( $updated ) ) {
      return;
    }
    add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'pushlabs-callbutton' ), 'updated' );
    settings_errors( $this->key . '-notices' );
  }
  /**
   * Public getter method for retrieving protected/private variables
   * @since  1.0
   * @param  string  $field Field to retrieve
   * @return mixed          Field value or exception is thrown
   */
  public function __get( $field ) {
    // Allowed fields to retrieve
    if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
      return $this->{$field};
    }
    throw new Exception( 'Invalid property: ' . $field );
  }
}
/**
 * Helper function to get/return the Myprefix_Admin object
 * @since  1.0
 * @return Myprefix_Admin object
 */
function pushlabs_callbutton_options_instance() {
  return Pushlabs_Callbutton_Options::get_instance();
}

function pushlabs_callbutton_get_option( $key = '', $default = false ) {
  if ( function_exists( 'cmb2_get_option' ) ) {
    // Use cmb2_get_option as it passes through some key filters.
    return cmb2_get_option( pushlabs_callbutton_options_instance()->key, $key, $default );
  }
  // Fallback to get_option if CMB2 is not loaded yet.
  $opts = get_option( pushlabs_callbutton_options_instance()->key, $default );
  $val = $default;
  if ( 'all' == $key ) {
    $val = $opts;
  } elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
    $val = $opts[ $key ];
  }
  return $val;
}

// Get it started
pushlabs_callbutton_options_instance();
