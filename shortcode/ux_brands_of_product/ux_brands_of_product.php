<?php

/**
 * add shortcode
 * syntax: [pt_brand_of_product]
 */
require_once( dirname( __FILE__ ) . "/shortcode_brands_of_product.php" );

add_action( 'ux_builder_setup', 'pt_ux_builder_product_by_brand' );

function pt_ux_builder_product_by_brand()
{

	$repeater_columns = '4';
	$repeater_type    = 'slider';

	$default_text_align = 'center';

	$options = array(
		'style_options'         => array(
			'type'    => 'group',
			'heading' => __( 'Style' ),
			'options' => array(
				'style' => array(
					'type'    => 'select',
					'heading' => __( 'Style' ),
					'default' => 'badge',
					'options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/values/box-layouts.php' )
				),
			),
		),
		'layout_options'        => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/repeater-options.php' ),
		'layout_options_slider' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/repeater-slider.php' ),
		'cat_meta'              => array(
			'type'    => 'group',
			'heading' => __( 'Meta' ),
			'options' => array(

				'ids'        => array(
					'type'       => 'select',
					'heading'    => 'Categories',
					'param_name' => 'ids',
					'config'     => array(
						'multiple'    => true,
						'placeholder' => 'Select..',
						'termSelect'  => array(
							'post_type'  => 'product_brand',
							'taxonomies' => 'product_brand',
						),
					),
				),

				'number'     => array(
					'type'       => 'textfield',
					'heading'    => 'Total',
					'conditions' => 'ids == ""',
					'default'    => '',
				),

				'offset'     => array(
					'type'       => 'textfield',
					'heading'    => 'Offset',
					'conditions' => 'ids == ""',
					'default'    => '',
				),

				'orderby'    => array(
					'type'    => 'select',
					'heading' => __( 'Order By' ),
					'default' => 'menu_order',
					'options' => array(
						'name'       => 'Name',
						'date'       => 'Date',
						'menu_order' => 'Menu Order',
					),
				),
				'order'      => array(
					'type'    => 'select',
					'heading' => __( 'Order' ),
					'default' => 'asc',
					'options' => array(
						'asc'  => 'ASC',
						'desc' => 'DESC',
					),
				),
				'show_count' => array(
					'type'    => 'checkbox',
					'heading' => 'Show Count',
					'default' => 'true',
				),
			),
		),
	);

	$box_styles = require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/box-styles.php' );
	$options    = array_merge( $options, $box_styles );

	$advanced = array( 'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ) );
	$options  = array_merge( $options, $advanced );

	add_ux_builder_shortcode( 'pt_brand_of_product', array(
		'name'     => __( 'Pt Thương hiệu sản phẩm' ),
		'category' => __( 'Product Page' ),
		'priority' => 20,
		'options'  => $options,
	) );
}
