<?php
add_action( 'ux_builder_setup', 'pt_ux_builder_img_shortocde' );
function pt_ux_builder_img_shortocde()
{
	add_ux_builder_shortcode( 'pt-svg', array(
		'name'     => __( 'Pt Svg' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'Content',
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
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

	$class .= ' ' . $visibility;

	$style = get_style_responsive( 'width', $width . '%', $width__md ? $width__md . '%' : '', $width__sm ? $width__sm . '%' : '' );
	$style .= 'color: ' . $color . ';';
	$style .= 'fill: ' . $color . ';';

	ob_start();

	if( !is_numeric( $id ) && $inline_svg != 'true' ) {
		echo '<div  class="pt-svg ' . $class . '" style="' . $style . '"><img src="' . $id . '" alt="img" /></div>';
	} elseif( !is_numeric( $id ) && $inline_svg == 'true' ) {
		echo '<div  class="pt-svg ' . $class . '" style="' . $style . '">' . wp_remote_fopen( $id ) . '</div>';
	} else {
		$meta = get_post_mime_type( $id );
		if( $inline_svg == 'true' ) {
			$source = wp_get_attachment_image_src( $id );
			echo '<div  class="pt-svg ' . $class . '" style="' . $style . '">' . wp_remote_fopen( $source[0] ) . '</div>';
		} else {
			echo '<div  class="pt-svg ' . $class . '" style="' . $style . '">' . wp_get_attachment_image( $id, 'full', false ) . '</div>';
		}
	}

	return ob_get_clean();
}
