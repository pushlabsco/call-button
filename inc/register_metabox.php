<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Register Call Button metabox and fields
 *
 * @since 1.0
 *
 * @uses new_cmb2_box()
 * @uses add_field()
 */
function pushlabs_callbutton_register_metabox() {
  $prefix = 'pushlabs_callbutton_metabox_field_';

  $callbutton_metabox = new_cmb2_box( array(
    'id'            => 'pushlabs-callbutton-metabox',
    'title'         => __( 'Call Button', 'pushlabs-callbutton' ),
    'object_types'  => pushlabs_callbutton_post_types(),
    'context'       => 'normal',
    'priority'      => 'high',
    'show_on_cb'    => 'pushlabs_callbutton_hide_metabox',
  ) );

  $callbutton_metabox->add_field( array(
    'name' => __( 'Disable Call Button on this page?', 'pushlabs-callbutton' ),
    'desc' => __( 'If you would like to disable Call Button on this page or post, you can do so here.', 'pushlabs-callbutton' ),
    'id'   => $prefix . 'disable',
    'type' => 'checkbox',
  ) );

  $callbutton_metabox->add_field( array(
    'name' => __( 'Phone Number', 'pushlabs-callbutton' ),
    'desc' => __( 'If you would like to use a different phone number for Call Button on this page, you can specify it here.', 'pushlabs-callbutton' ),
    'id'   => $prefix . 'phone',
    'type' => 'pushlabs_callbutton_number',
  ) );

  $callbutton_metabox->add_field( array(
    'name' => __( 'Style', 'pushlabs-callbutton' ),
    'desc' => __( 'If you would like to use a different style of Call Button for this page, you can specify it here.', 'pushlabs-callbutton' ),
    'id'   => $prefix . 'style',
    'type' => 'radio_image',
    'default' => 'default',
    'options' => array(
      'default' => __( 'Default', 'pushlabs-callbutton' ),
      'button' => __( 'Button', 'pushlabs-callbutton' ),
      'banner' => __( 'Banner', 'pushlabs-callbutton' ),
    ),
    'images_path' => PUSHLABS_CALLBUTTON_PLUGIN_URL,
    'images' => array(
      'default' => 'assets/img/radio-default.png',
      'button' => 'assets/img/radio-button-right.png',
      'banner' => 'assets/img/radio-banner.png',
    ),
  ) );

}
add_action( 'cmb2_admin_init', 'pushlabs_callbutton_register_metabox' );
