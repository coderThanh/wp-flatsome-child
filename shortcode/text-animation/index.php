<?php
// Required: animate.js
// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_text_animation_setup', 1500 );

function pt_shortcode_text_animation_setup()
{
	// wp_enqueue_style( 'pt-text-animate-shortcode', get_stylesheet_directory_uri() . '/shortcode/text-animation/style.css', [], time() );
	wp_enqueue_script( 'pt-text-animate-shortcode', get_stylesheet_directory_uri() . '/shortcode/text-animation/script.js', [ 'jquery' ], '1.0.1', true );
}

//
add_action( 'ux_builder_setup', 'pt_ux_builder_text_aniamtion' );

function pt_ux_builder_text_aniamtion()
{
	add_ux_builder_shortcode( 'pt-text-animate', array(
		'type'     => 'container',
		'name'     => __( 'Pt text animate', 'flatsome' ),
		'category' => __( 'Content', 'flatsome' ),
		'compile'  => false,
		'overlay'  => true,
		'info'     => '{{ label }}',

		'options'  => array(
			'label'                    => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here...',
			),
			'$content'                 => array(
				'heading'    => 'Multiline Content',
				'type'       => 'text-editor',
				'full_width' => true,
				'height'     => 'calc(100vh - 470px)',
				'tinymce'    => false,
			),
			'type'                     => array(
				'type'    => 'select',
				'heading' => 'type',
				'default' => 'letter_bounce',
				'options' => array(
					'letter_bounce' => 'Letter bounce',
				),
			),
			'milisecond_change'        => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Time change (milisecond)',
				'placeholder' => 2000,
				'default'     => 2000,
			),
			'milisecond_animation_in'  => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Time animation in (milisecond)',
				'placeholder' => 2000,
				'default'     => 2000,
			),
			'milisecond_animation_out' => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Time animation out (milisecond)',
				'placeholder' => 2000,
				'default'     => 2000,
			),
			'advanced_options'         => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-text-animate', 'pt_shortcode_text_animation' );

function pt_shortcode_text_animation($atts, $content = null)
{
	extract( shortcode_atts( array(
		'type'                     => 'letter_bounce',
		'milisecond_change'        => 2000,
		'milisecond_animation_in'  => 2000,
		'milisecond_animation_out' => 2000,
		'class'                    => '',
		'visibility'               => '',
	), $atts ) );


	$classOut = 'pt-text-animate pt-text-animate--' . esc_attr( $type ) . ' ';
	$classOut .= ' ' . esc_attr( $class );
	$classOut .= ' ' . esc_attr( $visibility );


	// Xử lý $content từ text editor (có HTML tags)
	if( !empty( $content ) ) {
		// Chuyển <br> và <br/> thành xuống dòng
		$content_processed = str_replace( array( '<br>', '<br/>', '<br />' ), "\n", $content );
		// Loại bỏ các HTML tags khác
		$content_processed = strip_tags( $content_processed );
		// Loại bỏ khoảng trắng thừa và tách thành array
		$texts_array = array_filter( array_map( 'trim', explode( "\n", $content_processed ) ) );
	} else {
		// Fallback về $texts nếu $content rỗng
		$texts_array = explode( "\n", $content );
	}

	$texts_json = json_encode( $texts_array );

	return '<div class="' . esc_attr( $classOut ) . '" data-texts="' . esc_attr( $texts_json ) . '" data-milisecond-change="' . esc_attr( $milisecond_change ) . '" data-milisecond-animation-in="' . esc_attr( $milisecond_animation_in ) . '" data-milisecond-animation-out="' . esc_attr( $milisecond_animation_out ) . '">' . '<div>' . do_shortcode( $content ) . '</div>' . '</div>';

}
