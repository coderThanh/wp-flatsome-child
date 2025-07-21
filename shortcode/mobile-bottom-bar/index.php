<?php

/**
 * add shortcode
 * syntax: [pt-mobile-bottom-bar]
 */


add_action( 'wp_enqueue_scripts', 'pt_shortcode_mobile_bottom_bar_enqueue' );

function pt_shortcode_mobile_bottom_bar_enqueue()
{
	wp_enqueue_style( 'pt-mobile-bottom-bar', get_stylesheet_directory_uri() . '/shortcode/mobile-bottom-bar/syles.css', [], '1.0' );
}

//

/**
 * Shortcode [pt-mobile-bottom-bar]
 * Require: [pt-mobile-bottom-bar-item]
 */
add_action( 'ux_builder_setup', 'pt_ux_builder_mobile_bottom_bar' );

function pt_ux_builder_mobile_bottom_bar()
{
	add_ux_builder_shortcode( 'pt-mobile-bottom-bar', array(
		'name'      => __( 'Pt Mobile Bottom Bar' ),
		'category'  => __( 'Content' ),
		'type'      => 'container',
		'priority'  => 1,
		'allow'     => array( 'pt-mobile-bottom-bar-item', 'pt-mobile-bottom-bar-open-menu-item' ),
		'wrap'      => false,
		'inline'    => true,
		'nested'    => true,
		'thumbnail' => WEBSITE_CHILD_URL . '/shortcode/mobile-bottom-bar/thumbnail.png',
		'info'      => '{{ label }}',
		'options'   => array(
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}

add_shortcode( 'pt-mobile-bottom-bar', 'pt_shortcode_mobile_bottom_bar' );

function pt_shortcode_mobile_bottom_bar($atts, $content = null)
{
	extract( shortcode_atts( array(
		'class'      => '',
		'visibility' => '',
	), $atts ) );


	?>
	<div class="bottom-bar-area <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>">
		<div class="bottom-bar-inner">
			<?php echo do_shortcode( $content ); ?>
		</div>
	</div>
	<?php

}

/**
 * 
 * Shortcode [pt-mobile-bottom-bar-item]
 * Require: [pt-mobile-bottom-bar]
 */

function pt_ux_builder_mobile_bottom_bar_item()
{
	add_ux_builder_shortcode( 'pt-mobile-bottom-bar-item', array(
		'name'     => __( 'Pt item' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'require'  => array( 'pt-mobile-bottom-bar' ),
		'info'     => '{{ title }}',
		'options'  => array(
			'title'      => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( '' ),
				'heading'     => 'Tên',
				'description' => '',
			),
			'url'        => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( '' ),
				'heading'     => 'Đường dẫn',
				'description' => '',
			),
			'rel'        => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( '' ),
				'heading'     => 'rel',
				'description' => '',
			),
			'target'     => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( '' ),
				'heading'     => 'target',
				'description' => '',
			),
			'img'        => array(
				'type'    => 'image',
				'heading' => 'Image',
				'default' => '',
			),
			'inline_svg' => array(
				'type'    => 'checkbox',
				'heading' => 'Inline SVG',
				'default' => 'true',
			),
			'icon_color' => array(
				'type'        => 'colorpicker',
				'heading'     => __( 'Icon Color' ),
				'description' => __( 'Only works for simple SVG icons' ),
				'format'      => 'rgb',
				'position'    => 'bottom right',
				'on_change'   => array(
					'selector' => '.icon-inner',
					'style'    => 'color: {{ value }}',
				),
			),
		),
	) );
}

add_action( 'ux_builder_setup', 'pt_ux_builder_mobile_bottom_bar_item' );

add_shortcode( 'pt-mobile-bottom-bar-item', 'pt_bottom_bar_item' );

function pt_bottom_bar_item($atts, $content = null)
{
	extract( shortcode_atts( array(
		'title'      => '',
		'url'        => '',
		'rel'        => '',
		'target'     => '',
		'img'        => '',
		'inline_svg' => 'true',
		'icon_color' => '',

	), $atts ) );


	$css_args = array(
		'icon_color' => array(
			'attribute' => 'color',
			'value'     => $icon_color,
		),
	);

	?>
	<a href="<?php echo esc_attr( $url ); ?>"
		target="<?php echo esc_attr( $target ); ?>"
		rel="<?php echo esc_attr( $rel ); ?>"
		class="bottom-bar-item"
		<?php echo get_shortcode_inline_css( $css_args ); ?>>
		<div class="icon">
			<div class="icon-inner">
				<?php echo flatsome_get_image( $img, $size = 'full', $alt = $title, $inline_svg ); ?>
			</div>
		</div>
		<span class="bottom-bar-item-title"><?php echo $title; ?></span>
	</a>
	<?php
}


/**
 * 
 * Shortcode [pt-mobile-bottom-bar-open-menu-item]
 * Require: [pt-mobile-bottom-bar]
 */

function pt_ux_builder_mobile_bottom_bar_open_menu_item()
{
	add_ux_builder_shortcode( 'pt-mobile-bottom-bar-open-menu-item', array(
		'name'     => __( 'Pt Open Menu item' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'require'  => array( 'pt-mobile-bottom-bar' ),
		'options'  => array(
			'title'      => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( '' ),
				'heading'     => 'Tên',
				'description' => '',
			),
			'img'        => array(
				'type'    => 'image',
				'heading' => 'Image',
				'default' => '',
			),
			'inline_svg' => array(
				'type'    => 'checkbox',
				'heading' => 'Inline SVG',
				'default' => 'true',
			),
			'icon_color' => array(
				'type'        => 'colorpicker',
				'heading'     => __( 'Icon Color' ),
				'description' => __( 'Only works for simple SVG icons' ),
				'format'      => 'rgb',
				'position'    => 'bottom right',
				'on_change'   => array(
					'selector' => '.icon-inner',
					'style'    => 'color: {{ value }}',
				),
			),
		),
	) );
}

add_action( 'ux_builder_setup', 'pt_ux_builder_mobile_bottom_bar_open_menu_item' );

add_shortcode( 'pt-mobile-bottom-bar-open-menu-item', 'pt_bottom_bar_open_menu_item' );

function pt_bottom_bar_open_menu_item($atts, $content = null)
{
	extract( shortcode_atts( array(
		'title'      => '',
		'img'        => '',
		'inline_svg' => 'true',
		'icon_color' => '',
	), $atts ) );


	$css_args = array(
		'icon_color' => array(
			'attribute' => 'color',
			'value'     => $icon_color,
		),
	);

	?>
	<a href="#"
		data-open="#main-menu"
		data-pos="left"
		data-bg="main-menu-overlay"
		data-color=""
		class="bottom-bar-item"
		aria-label="Menu"
		aria-controls="main-menu"
		aria-expanded="false"
		<?php echo get_shortcode_inline_css( $css_args ); ?>>
		<div class="icon">
			<div class="icon-inner">
				<?php echo flatsome_get_image( $img, $size = 'full', $alt = $title, $inline_svg ); ?>
			</div>
		</div>
		<span class="bottom-bar-item-title"><?php echo $title; ?></span>
	</a>
	<?php
}
