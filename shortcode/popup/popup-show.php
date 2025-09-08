<?php

/**
 * Yotube Slider with Flatsome UX -----
 * Require: 
 */

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_popup_setup', 1500 );

function pt_shortcode_popup_setup()
{
	wp_enqueue_style( 'pt-popup-shortcode', get_stylesheet_directory_uri() . '/shortcode/popup/style.css', [], '1.0' );
	wp_enqueue_script( 'pt-popup-shortcode', get_stylesheet_directory_uri() . '/shortcode/popup/script.js', [ 'jquery' ], '1.0', true );
}

//
add_action( 'ux_builder_setup', 'pt_ux_builder_popup_show' );

function pt_ux_builder_popup_show()
{
	add_ux_builder_shortcode( 'pt-popup-place-in-footer', array(
		'name'     => __( 'Pt Popup show' ),
		'category' => __( 'Content' ),
		'type'     => 'container',
		'priority' => 1,
		'allow'    => array( 'pt-wrap' ),
		'info'     => '{{ label }}',
		'wrap'     => false,
		'inline'   => true,
		'nested'   => false,
		'options'  => [ 
			'label'            => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here..',
			),
			'id'               => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'ID Popup Show',
				'placeholder' => 'idPopupShow',
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		],
	) );
}


//
add_shortcode( 'pt-popup-place-in-footer', 'pt_popup_place_in_footer' );

function pt_popup_place_in_footer($atts, $content = null)
{
	extract( shortcode_atts( array(
		'id'         => '',
		'class'      => '',
		'visibility' => '',
	), $atts ) );

	$html = '<div id="' . esc_attr( $id ) . '"';
	$html .= ' class="pt-popup-wrap ' . esc_attr( $class ) . ' ' . esc_attr( $visibility ) . '">';
	$html .= '  <div class="pt-popup-inner">';
	$html .= '    <div class="pt-popup-content">';
	$html .= do_shortcode( $content );
	$html .= '    </div>';
	$html .= '    <div class="pt-popup-bg" onclick="ptPopUpClose(event)"></div>';
	$html .= '    <div class="pt-popup-btn-close" onclick="ptPopUpClose(event)">';
	$html .= '      <span class="material-symbols-outlined">close</span>';
	$html .= '    </div>';
	$html .= '  </div>';
	$html .= '</div>';

	return $html;
}

