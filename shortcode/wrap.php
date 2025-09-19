<?php

/**
 * add shortcode
 * syntax: [pt-wrap]
 */



//
add_action( 'ux_builder_setup', 'pt_ux_builder_wrap_shortocde' );

function pt_ux_builder_wrap_shortocde()
{
	add_ux_builder_shortcode( 'pt-wrap', array(
		'name'     => __( 'Pt Wrap' ),
		'category' => __( 'Content' ),
		'priority' => 10,
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
			'has_inner'        => array(
				'type'    => 'checkbox',
				'heading' => 'Has inner',
				'default' => 'true',
			),
			'position_options' => array(
				'type'    => 'group',
				'heading' => __( 'Position' ),
				'options' => [ 
					'is_absolute' => array(
						'type'    => 'checkbox',
						'heading' => 'Is Absolute',
						'default' => 'false',
					),
					'left'        => array(
						'type'        => 'scrubfield',
						'heading'     => 'left',
						'responsive'  => true,
						'placeholder' => '30px',
					),
					'right'       => array(
						'type'       => 'scrubfield',
						'heading'    => 'right',
						'responsive' => true,
						'config'     => [ 
							'placeholder' => '30px',
						],
					),
					'top'         => array(
						'type'        => 'scrubfield',
						'heading'     => 'top',
						'responsive'  => true,
						'placeholder' => '30px',
					),
					'bottom'      => array(
						'type'        => 'scrubfield',
						'heading'     => 'bottom',
						'responsive'  => true,
						'placeholder' => '30px',
					),
					'index'       => array(
						'type'        => 'textfield',
						'heading'     => 'Z index',
						'placeholder' => '-10',
					),
				],
			),
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-wrap', 'pt_get_wrap_shortocde' );
add_shortcode( 'pt-wrap_inner', 'pt_get_wrap_shortocde' );
add_shortcode( 'pt-wrap_inner_inner', 'pt_get_wrap_shortocde' );
add_shortcode( 'pt-wrap_inner_1', 'pt_get_wrap_shortocde' );

function pt_get_wrap_shortocde($atts, $content = null)
{

	extract( shortcode_atts( array(
		'class'       => '',
		'visibility'  => '',
		'has_inner'   => 'true',
		'is_absolute' => 'false',
		'left'        => '',
		'left__md'    => '',
		'left__sm'    => '',
		'right'       => '',
		'right__md'   => '',
		'right__sm'   => '',
		'top'         => '',
		'top__md'     => '',
		'top__sm'     => '',
		'bottom'      => '',
		'bottom__md'  => '',
		'bottom__sm'  => '',
		'index'       => '',
	), $atts ) );

	$style = '';

	if( !empty( $left ) ) {
		$style .= '--left: ' . $left . ';';
	}

	if( !empty( $left__md ) ) {
		$style .= '--left-md: ' . $left__md . ';';
	}

	if( !empty( $left__sm ) ) {
		$style .= '--left-sm: ' . $left__sm . ';';
	}

	if( !empty( $right ) ) {
		$style .= '--right: ' . $right . ';';
	}

	if( !empty( $right__md ) ) {
		$style .= '--right-md: ' . $right__md . ';';
	}

	if( !empty( $right__sm ) ) {
		$style .= '--right-sm: ' . $right__sm . ';';
	}

	if( !empty( $bottom ) ) {
		$style .= '--bottom: ' . $bottom . ';';
	}

	if( !empty( $bottom__md ) ) {
		$style .= '--bottom-md: ' . $bottom__md . ';';
	}

	if( !empty( $bottom__sm ) ) {
		$style .= '--bottom-sm: ' . $bottom__sm . ';';
	}

	if( !empty( $top ) ) {
		$style .= '--top: ' . $top . ';';
	}

	if( !empty( $top__md ) ) {
		$style .= '--top-md: ' . $top__md . ';';
	}

	if( !empty( $top__sm ) ) {
		$style .= '--top-sm: ' . $top__sm . ';';
	}

	if( !empty( $index ) ) {
		$style .= '--z-index: ' . $index . ';';
	}

	if( $is_absolute == 'true' ) {
		$style .= 'position: absolute; width: 100%;';
	}

	$html = '<div class="wrap ' . esc_attr( $class ) . ' ' . esc_attr( $visibility ) . '" style="' . esc_attr( $style ) . '">';
	if( $has_inner === 'true' ) {
		$html .= '<div class="wrap-inner">';
	}

	$html .= do_shortcode( $content );

	if( $has_inner === 'true' ) {
		$html .= '</div>';
	}
	$html .= '</div>';

	return $html;
}
