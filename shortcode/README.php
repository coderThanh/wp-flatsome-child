<?php

/** options example */
if( !isset( $repeater_posts ) )
	$repeater_posts = 'posts';
if( !isset( $repeater_post_type ) )
	$repeater_post_type = 'post';
if( !isset( $repeater_post_cat ) )
	$repeater_post_cat = 'category';

array(
	'name'     => __( 'Pt Post Slider Simple' ),
	'category' => __( 'Content' ),
	'priority' => 1,
	'wrap'     => false,
	'inline'   => true,
	'nested'   => true,
	'options'  => array(
		'twitter_link'          => array(
			'type'        => 'textfield',
			'full_width'  => true,
			'default'     => '',
			'placeholder' => __( '' ),
			'heading'     => 'twitter link',
		),
		'auto_slide'            => array(
			'type'    => 'select',
			'heading' => 'Auto Slide',
			'default' => '',
			'options' => array(
				''     => 'Disabled',
				'2000' => '2 sec.',
				'3000' => '3 sec.',
				'4000' => '4 sec.',
				'5000' => '5 sec.',
				'6000' => '6 sec.',
				'7000' => '7 sec.',
			),
		),
		'infinitive'            => array(
			'type'    => 'select',
			'heading' => "Infinitive",
			'default' => '',
			'options' => array(
				'false' => 'Disable',
				''      => 'Enable',
			),
		),
		'columns'               => array(
			'type'       => 'slider',
			'heading'    => 'Columns',
			'conditions' => 'type !== "grid" && type !== "slider-full"',
			'default'    => '4',
			'responsive' => true,
			'max'        => '8',
			'min'        => '1',
			'unit'       => 'rem',
			'step'       => '0.25',
		),
		'col_spacing'           => array(
			'type'    => 'select',
			'heading' => 'Column Spacing',
			'default' => 'normal',
			'options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/values/col-spacing.php' )
		),

		// Full fetch
		'post_options'          => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/repeater-posts.php' ),

		// Fetch customs
		'cat'                   => array(
			'type'       => 'select',
			'heading'    => 'Category',
			'param_name' => 'cat',

			'default'    => '',
			'config'     => array(
				'multiple'    => true,
				'placeholder' => 'Select...',
				'termSelect'  => array(
					'post_type'  => $repeater_post_cat,
					'taxonomies' => $repeater_post_cat,
				),
			),
		),
		$repeater_posts         => array(
			'type'    => 'textfield',
			'heading' => 'Total Posts',

			'default' => '8',
		),
		'orderby'               => array(
			'type'    => 'select',
			'heading' => 'Order by',

			'default' => 'date',
			'options' => array(
				'ID'            => 'ID',
				'title'         => 'Title',
				'name'          => 'Name',
				'date'          => 'Published Date',
				'modified'      => 'Modified Date',
				'rand'          => 'Random',
				'comment_count' => 'Comment Count',
				'menu_order'    => 'Menu Order',
			),
		),
		'order'                 => array(
			'type'    => 'select',
			'heading' => 'Order',

			'default' => 'DESC',
			'options' => array(
				'ASC'  => 'ASC',
				'DESC' => 'DESC',
			),
		),
		'tags'                  => array(
			'type'       => 'select',
			'heading'    => 'Tag',
			'conditions' => 'ids == ""',
			'default'    => '',
			'config'     => array(
				'multiple'    => true,
				'placeholder' => 'Select...',
				'termSelect'  => array(
					'post_type'  => $repeater_post_type,
					'taxonomies' => 'post_tag',
				),
			),
		),

		// Images
		'ids'                   => array(
			'type'    => 'gallery',
			'heading' => __( 'Images' ),
		),

		// img + svg
		'img'                   => array(
			'type'    => 'image',
			'heading' => 'Image',
			'default' => '',
		),
		'inline_svg'            => array(
			'type'    => 'checkbox',
			'heading' => 'Inline SVG',
			'default' => 'true',
		),
		'type'                  => array(
			'type'    => 'select',
			'heading' => 'Order',
			'default' => 'DESC',
			'options' => array(
				'slider' => 'Slider',
				'row'    => 'Row',
			),
		),
		'width'                 => array(
			'type'       => 'select',
			'heading'    => 'Width',
			'conditions' => 'type !== "slider-full"',
			'default'    => '',
			'options'    => array(
				''           => 'Container',
				'full-width' => 'Full Width',
			),
		),
		'icon_color'            => array(
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
		'layout_options'        => array(
			'type'    => 'group',
			'heading' => __( 'Layout' ),
			'options' => [

			], ),
		'padding'               => array(
			'type'       => 'scrubfield',
			'heading'    => 'Padding',
			'responsive' => true, //
			'default'    => '30px',
			'min'        => 0,
			'max'        => 500,
		),
		'layout_options_slider' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/repeater-slider.php' ),

		// 
		'advanced_options'      => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
	),
);
