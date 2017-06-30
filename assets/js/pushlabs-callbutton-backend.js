jQuery( document ).ready(function($) {

  // Our Style settings drop down boxes
  $( function() {
    $('#pushlabs_callbutton_metabox .cmb-type-radio-image #pushlabs_callbutton_style1, #pushlabs_callbutton_metabox .cmb-type-radio-image #pushlabs_callbutton_style2').bind('change', function (e) {
      if ( $( '#pushlabs_callbutton_metabox .cmb-type-radio-image #pushlabs_callbutton_style1' ).attr( 'checked' ) ) {
        $( '.pushlabs-callbutton-style-box.box-style--banner .pushlabs-callbutton-box-options' ).hide( 500 );
        $( '.pushlabs-callbutton-style-box.box-style--button .pushlabs-callbutton-box-options' ).show( 500 );
      }
      if ( $( '#pushlabs_callbutton_metabox .cmb-type-radio-image #pushlabs_callbutton_style2' ).attr( 'checked' ) ) {
        $( '.pushlabs-callbutton-style-box.box-style--button .pushlabs-callbutton-box-options' ).hide( 500 );
        $( '.pushlabs-callbutton-style-box.box-style--banner .pushlabs-callbutton-box-options' ).show( 500 );
      }
    }).trigger( 'change' );
  });

  // Change button image based on position selected
  $( function() {
    $( '#pushlabs_callbutton_style_button_position1, #pushlabs_callbutton_style_button_position2, #pushlabs_callbutton_style_button_position3' ).bind( 'change', function ( e ) {
      if ( $( '#pushlabs_callbutton_style_button_position1' ).attr( 'checked' ) ) {
        $( 'label[for="pushlabs_callbutton_style1"] img' ).attr( 'src', pushlabs_callbutton.imgUrl + 'radio-button-left.png' );
      }
      if ( $( '#pushlabs_callbutton_style_button_position2' ).attr( 'checked' ) ) {
        $( 'label[for="pushlabs_callbutton_style1"] img' ).attr( 'src', pushlabs_callbutton.imgUrl + 'radio-button-middle.png' );
      }
      if ( $( '#pushlabs_callbutton_style_button_position3' ).attr( 'checked' ) ) {
        $( 'label[for="pushlabs_callbutton_style1"] img' ).attr( 'src', pushlabs_callbutton.imgUrl + 'radio-button-right.png' );
      }
    }).trigger( 'change' );
  });

  $( function() {
    $( '#pushlabs_callbutton_style_button_border' ).bind( 'change', function ( e ) {
      if ( $( '#pushlabs_callbutton_style_button_border' ).attr( 'checked' ) ) {
        $( '.cmb2-id-pushlabs-callbutton-style-button-border-color' ).hide( 500 );
      } else {
        $( '.cmb2-id-pushlabs-callbutton-style-button-border-color' ).show( 500 );
      }
    }).trigger( 'change' );
  });

});
