<?php
//
add_action( 'ux_builder_setup', 'pt_ux_builder_title' );

function pt_ux_builder_title()
{
	add_ux_builder_shortcode( 'pt-title-simple', array(
		'name'     => __( 'Pt title' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'options'  => [ 
			'title'            => array(
				'full_width' => true,
				'type'       => 'textfield',
				'heading'    => 'Title',
			),
			'url'              => array(
				'full_width' => true,
				'type'       => 'textfield',
				'heading'    => 'Url',
			),
			'tag'              => array(
				'type'    => 'select',
				'heading' => 'Tag',
				'default' => 'h2',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
				),
			),
			'size'             => array(
				'type'    => 'select',
				'heading' => 'Size',
				'default' => '',
				'options' => array(
					'is-big' => 'Big',
					''       => 'Normal',
				),
			),
			'color'            => array(
				'type'    => 'select',
				'heading' => 'Color',
				'default' => '',
				'options' => array(
					''          => 'Default',
					'primary'   => 'primary',
					'secondary' => 'secondary',
					'alert'     => 'alert',
					'success'   => 'success',
				),
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		],
	) );
}


//
add_shortcode( 'pt-title-simple', 'pt_shortcode_title_simple' );

function pt_shortcode_title_simple($atts, $content = null)
{
	extract( shortcode_atts( array(
		'title'      => '',
		'tag'        => 'h2',
		'size'       => '',
		'color'      => '',
		'class'      => '',
		'url'        => '',
		'visibility' => '',
	), $atts ) );

	$className = 'title-simple';

	if( !empty( $size ) ) {
		$className .= ' ' . $size;
	}

	if( !empty( $class ) ) {
		$className .= ' ' . $class;
	}

	if( !empty( $visibility ) ) {
		$className .= ' ' . $visibility;
	}

	echo '<' . $tag . ' ';
	echo ' class="' . $className . '"';

	if( !empty( $color ) ) {
		echo ' data-text-color="' . $color . '"';
	}

	echo ' >';

	if( !empty( $url ) ) {
		echo '<a class="el-text" href="' . esc_url( $url ) . '">' . esc_attr( $title ) . '</a>';
	} else {
		echo '<span class="el-text" >'.esc_attr( $title ) . '</span>';
	}
	
	echo '</' . $tag . '>';

}

