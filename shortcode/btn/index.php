<?php

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_btn_enqueue' );

function pt_shortcode_btn_enqueue()
{
	wp_enqueue_style( 'pt-btn-shortcode', get_stylesheet_directory_uri() . '/shortcode/btn/btn.css', [], '1.0' );
}

//
add_action( 'ux_builder_setup', 'pt_ux_builder_btn' );

function pt_ux_builder_btn()
{
	add_ux_builder_shortcode( 'pt-btn', array(
		'name'     => __( 'Pt Button' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'info'     => '{{ text }}',
		'options'  => [ 
			'text'             => array(
				'full_width' => true,
				'type'       => 'textfield',
				'heading'    => 'Text',
			),
			'layout_options'   => array(
				'type'    => 'group',
				'heading' => 'Layout',
				'options' => array(
					'color'   => array(
						'type'    => 'select',
						'heading' => 'Color',
						'default' => 'primary',
						'options' => array(
							'primary'   => 'primary',
							'secondary' => 'secondary',
							'tertiary'  => 'tertiary',
							'alert'     => 'alert',
							'success'   => 'success',
							'warning'   => 'warning',
							'process'   => 'process',
							'bg'        => 'bg',
							'opposite'  => 'opposite',
							'black'     => 'black',
							'white'     => 'white',
						),
					),
					'type'    => array(
						'type'    => 'select',
						'heading' => 'Type',
						'default' => '',
						'options' => array(
							''       => 'button',
							'submit' => 'submit',
						),
					),
					'kind'    => array(
						'type'    => 'select',
						'heading' => 'Kind',
						'default' => 'default',
						'options' => array(
							'text-only' => 'text only',
							'underline' => 'underline',
							'text'      => 'text',
							'outline'   => 'outline',
							'dashed'    => 'dashed',
							'filled'    => 'filled',
							'default'   => 'default',
						),
					),
					'size'    => array(
						'type'    => 'select',
						'heading' => 'size',
						'default' => 'md',
						'options' => array(
							'lg' => 'lg',
							'md' => 'md',
							'sm' => 'sm',
							'xs' => 'xs',
							'no' => 'no size',
						),
					),
					'padding' => array(
						'type'       => 'margins',
						'heading'    => 'Padding',
						'conditions' => 'size === "no"',
						'full_width' => true,
						'min'        => 0,
						'max'        => 200,
						'step'       => 1,
					),
					'btnSize' => array(
						'type'        => 'textfield',
						'heading'     => 'Button Size',
						'conditions'  => 'type === "no"',
						'placeholder' => '40px',
					),
					'expand'  => array(
						'type'    => 'checkbox',
						'heading' => 'Expand',
					),
				),
			),

			'icon_options'     => array(
				'type'    => 'group',
				'heading' => 'Icon',
				'options' => array(
					'svg'       => array(
						'type'    => 'image',
						'heading' => 'Svg',
						'default' => '',
					),
					'svg_width' => array(
						'type'        => 'textfield',
						'heading'     => 'Svg size',
						'default'     => '',
						'placeholder' => '24px',
					),
					'is_circle' => array(
						'type'    => 'checkbox',
						'heading' => 'Is Circle',
					),
					'icon'      => array(
						'type'    => 'select',
						'heading' => 'Icon',
						'options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/values/icons.php' ),
					),
					'icon_pos'  => array(
						'type'    => 'select',
						'heading' => 'Position',
						'options' => array(
							''     => 'Right',
							'left' => 'Left',
						),
					),
				),
			),
			'link_options'     => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/links.php' ),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		],
	) );
}


//
add_shortcode( 'pt-btn', 'pt_shortcode_btn' );

function pt_shortcode_btn($atts, $content = null)
{
	extract( shortcode_atts( array(
		'text'       => '',
		'color'      => 'primary',
		'type'       => '',
		'kind'       => 'default',
		'size'       => 'md',
		'expand'     => '',
		'is_circle'  => '',
		'padding'    => '',
		'btnSize'    => '',
		'svg'        => '',
		'svg_width'  => '',
		'icon'       => '',
		'icon_pos'   => '',
		'link'       => '',
		'target'     => '_self',
		'rel'        => '',
		'class'      => '',
		'visibility' => '',
	), $atts ) );


	// Build CSS classes
	$classes = array( 'pt-btn' );
	if( $color )
		$classes[] = "pt-btn-color--{$color}";
	if( $kind )
		$classes[] = "pt-btn-kind--{$kind}";
	if( $size )
		$classes[] = "pt-btn-size--{$size}";
	if( $expand )
		$classes[] = "pt-btn--expand";
	if( $is_circle )
		$classes[] = "pt-btn-shape--circle";
	if( $class )
		$classes[] = $class;
	if( $visibility )
		$classes[] = $visibility;

	$classes = implode( ' ', array_filter( $classes ) );

	// Build inline styles for custom padding
	$style = pt_get_shortcode_inline_css( array(
		array(
			'attribute' => '--btn-padding',
			'value'     => $size !== 'no' ? $padding : '',
		),
		array(
			'attribute' => '--btn-size',
			'value'     => $btnSize,
		),
	) );

	// Prepare icon HTML if exists
	$icon_left  = $icon && $icon_pos == 'left' ? get_flatsome_icon( $icon, null, array( 'aria-hidden' => 'true' ) ) : '';
	$icon_right = $icon && $icon_pos !== 'left' ? get_flatsome_icon( $icon, null, array( 'aria-hidden' => 'true' ) ) : '';

	$svg_html = $svg ? shortcode_image_basic( [ 
		'id'    => $svg,
		'width' => $svg_width,
		'height' => $svg_width,
		'type'  => 'svg',
		'class' => 'pt-btn__icon',
	] ) : '';

	// Build button/link HTML
	if( $link ) {
		$rel_attr = $rel ? 'rel="' . $rel . '"' : '';
		return sprintf(
			'<a href="%s" class="%s" target="%s" %s %s>
                %s%s
                <span class="pt-btn__text">%s</span>
                %s%s
            </a>',
			esc_url( $link ),
			esc_attr( $classes ),
			esc_attr( $target ),
			$rel_attr,
			$style,
			$icon_left,
			$icon_pos === 'left' ? $svg_html : '',
			esc_html( $text ),
			$icon_right,
			$icon_pos !== 'left' ? $svg_html : '',
		);
	} else {
		return sprintf(
			'<button type="%s" class="%s" %s>
                %s%s
                <span class="pt-btn__text">%s</span>
                %s%s
            </button>',
			esc_attr( $type ?: 'button' ),
			esc_attr( $classes ),
			$style,
			$icon_left,
			$icon_pos === 'left' ? $svg_html : '',
			esc_html( $text ),
			$icon_right,
			$icon_pos !== 'left' ? $svg_html : '',
		);
	}

}

