<?php

/**
 * Shortcode [pt-popup-item]
 * Require: [pt-youtube-item]
 */
add_action( 'ux_builder_setup', 'pt_ux_builder_popup_item_sliders' );

function pt_ux_builder_popup_item_sliders()
{
	add_ux_builder_shortcode( 'pt-popup-item', array(
		'name'     => __( 'Pt Popup button' ),
		'category' => __( 'Content' ),
		'priority' => 1,
        'type'     => 'container',
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
		'options'  => array(
			'label'            => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here..',
			),
			// 
			'text'             => array(
				'full_width' => true,
				'type'       => 'textfield',
				'heading'    => 'Text',
			),
			'id_popup_show'    => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'ID Popup Show',
				'placeholder' => '#idPopupShow',
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}

add_shortcode( 'pt-popup-item', 'pt_shortcode_popup_item' );

function pt_shortcode_popup_item($atts, $content = null) {
    extract( shortcode_atts( array(
        'text'          => '',
        'id_popup_show' => '',
        'class'         => '',
        'visibility'    => '',
    ), $atts ) );

    $html  = '<div class="pt-popup-btn-open ' . esc_attr($class) . ' ' . esc_attr($visibility) . '" ';
    $html .= 'onclick="ptPopUpOpen(event)" data-id-popup-show="' . esc_attr($id_popup_show) . '">';

    if ( !empty($text) ) {
        $html .= '<span>' . esc_html($text) . '</span>';
    }

    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;
}

