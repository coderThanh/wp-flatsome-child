<?php
add_action( 'ux_builder_setup', 'pt_ux_builder_img_shortocde' );
function pt_ux_builder_img_shortocde()
{
	add_ux_builder_shortcode( 'pt-svg', array(
		'name'     => __( 'Pt Svg' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'Content',
		'options'  => array(
			'id'               => array(
				'type'    => 'image',
				'heading' => 'Image',
				'default' => '',
			),
			'inline_svg'       => array(
				'type'    => 'checkbox',
				'heading' => 'Inline SVG',
				'default' => 'true',
			),
			'color'            => array(
				'type'     => 'colorpicker',
				'heading'  => __( 'Color' ),
				'format'   => 'rgb',
				'position' => 'bottom right',
			),
			'width'            => array(
				'type'       => 'slider',
				'heading'    => 'Width',
				'default'    => '100',
				'responsive' => true,
				'max'        => '100',
				'min'        => '0',
				'unit'       => '%',
				'step'       => '1',
			),
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


// Function for shortcode [pt-svg]
add_shortcode( 'pt-svg', 'pt_svg_shortocde' );

function pt_svg_shortocde($atts, $content = null)
{
	extract( shortcode_atts( array(
		'class'      => '',
		'visibility' => '',
		'id'         => '',
		'inline_svg' => 'true',
		'width'      => '100',
		'width__md'  => '',
		'width__sm'  => '',
		'color'      => '',
	), $atts ) );

	if( empty( $id ) ) {
		return;
	}

	$class .= ' ' . $visibility;

	$style = get_style_responsive( 'width', $width . '%', $width__md ? $width__md . '%' : '', $width__sm ? $width__sm . '%' : '' );
	$style .= 'color: ' . $color . ';';
	$style .= 'fill: ' . $color . ';';

	if( !is_numeric( $id ) && $inline_svg != 'true' ) {
		return '<div  class="pt-svg ' . $class . '" style="' . $style . '"><img src="' . $id . '" alt="img" /></div>';
	}


	if( $inline_svg == 'true' ) {
		$file = get_attached_file( $id );
		if( $file && file_exists( $file ) ) {
			return preg_replace(
				'#<script(.*?)>(.*?)</script>#is',
				'',
				'<div  class="pt-svg ' . $class . '" style="' . $style . '">' . file_get_contents( $file ) . '</div>'
			);
		}
	} else {
		return '<div  class="pt-svg ' . $class . '" style="' . $style . '"><img src="' . wp_get_attachment_image_url( $id, 'full', false ) . '" alt="img" /></div>';
	}
}
