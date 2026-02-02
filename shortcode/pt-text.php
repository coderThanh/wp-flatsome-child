<?php

/**
 * add shortcode
 * syntax: [pt-text]
 */

//
add_action( 'ux_builder_setup', 'pt_ux_builder_text_shortocde' );

function pt_ux_builder_text_shortocde()
{
	add_ux_builder_shortcode( 'pt-text', array(
		'name'     => __( 'Pt Nội dung' ),
		'category' => __( 'content' ),
		'priority' => 10,
		'type'     => 'container',
		'compile'  => false,
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
			'$content'         => array(
				'heading'    => 'Nội dung',
				'type'       => 'text-editor',
				'full_width' => true,
				'height'     => '400px',
				'tinymce'    => true,
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-text', 'pt_get_text_shortocde' );

function pt_get_text_shortocde($atts, $content = null)
{
	extract( shortcode_atts( array(
		'class'      => '',
		'visibility' => '',
	), $atts ) );

	return do_shortcode( '<div class="' . esc_attr( $class ) . ' ' . esc_attr( $visibility ) . '">' . $content . '</div>' );
}
