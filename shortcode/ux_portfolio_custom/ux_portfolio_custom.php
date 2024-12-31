<?php
// Only require this file
require_once( THEME_CHILD_ROOT . '/shortcode/ux_portfolio_custom/shortcode_portfolio_custom.php' );

// remove init
remove_shortcode( "featured_items_slider" );
remove_shortcode( "featured_items_grid" );
remove_shortcode( "ux_portfolio" );

add_shortcode( "featured_items_slider", "pt_portfolio_shortcode" );
add_shortcode( "featured_items_grid", "pt_portfolio_shortcode" );
add_shortcode( "ux_portfolio", "pt_portfolio_shortcode" );

// 
// add_action( 'ux_builder_setup', 'pt_ux_builder_portfolio_custom' );

function pt_ux_builder_portfolio_custom()
{
	// Shortcode to display product categories
	$repeater_columns     = '4';
	$repeater_type        = 'slider';
	$default_text_align   = 'center';
	$repeater_col_spacing = 'small';

	$options    = array(
		'portfolio_meta'        => array(
			'type'    => 'group',
			'heading' => __( 'Options' ),
			'options' => array(
				'style'               => array(
					'type'    => 'select',
					'heading' => __( 'Style' ),
					'default' => 'bounce',
					'options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/values/box-layouts.php' )
				),

				'filter'              => array(
					'type'    => 'radio-buttons',
					'heading' => __( 'Filter' ),
					'default' => '',
					'options' => array(
						''     => array( 'title' => 'Off' ),
						'true' => array( 'title' => 'On' ),
					),
				),

				'filter_nav'          => array(
					'type'       => 'select',
					'heading'    => __( 'Filter Style' ),
					'conditions' => 'filter',
					'default'    => 'line-grow',
					'options'    => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/values/nav-styles.php' ),
				),

				'filter_align'        => array(
					'type'       => 'radio-buttons',
					'conditions' => 'filter',
					'heading'    => 'Filter Align',
					'default'    => 'center',
					'options'    => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/values/align-radios.php' ),
				),

				'lightbox'            => array(
					'type'    => 'radio-buttons',
					'heading' => __( 'Lightbox' ),
					'default' => '',
					'options' => array(
						''     => array( 'title' => 'Off' ),
						'true' => array( 'title' => 'On' ),
					),
				),

				'lightbox_image_size' => array(
					'type'       => 'select',
					'heading'    => __( 'Lightbox Image Size' ),
					'conditions' => 'lightbox == "true"',
					'default'    => 'original',
					'options'    => flatsome_ux_builder_image_sizes(),
				),

				'ids'                 => array(
					'type'       => 'select',
					'heading'    => 'Ids',
					'full_width' => true,
					'config'     => array(
						'multiple'    => true,
						'placeholder' => 'Select...',
						'postSelect'  => array(
							'post_type' => array( 'featured_item' ),
						),
					),
				),

				'cat'                 => array(
					'type'       => 'select',
					'heading'    => 'Category',
					'conditions' => 'ids == ""',
					'full_width' => true,
					'config'     => array(
						'placeholder' => 'Select...',
						'termSelect'  => array(
							'post_type'  => 'featured_item',
							'taxonomies' => 'featured_item_category',
						),
					),
				),

				'number'              => array(
					'type'       => 'textfield',
					'heading'    => 'Total',
					'conditions' => 'ids == ""',
					'default'    => '',
				),

				'offset'              => array(
					'type'       => 'textfield',
					'heading'    => 'Offset',
					'conditions' => 'ids == ""',
					'default'    => '',
				),

				'orderby'             => array(
					'type'       => 'select',
					'heading'    => __( 'Order By' ),
					'default'    => 'menu_order',
					'conditions' => 'ids == ""',
					'options'    => array(
						'title'      => 'Title',
						'name'       => 'Name',
						'date'       => 'Date',
						'menu_order' => 'Menu Order',
					),
				),
				'order'               => array(
					'type'       => 'select',
					'heading'    => __( 'Order' ),
					'conditions' => 'ids == ""',
					'default'    => 'desc',
					'options'    => array(
						'desc' => 'DESC',
						'asc'  => 'ASC',
					),
				),
			),
		),
		'layout_options'        => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/repeater-options.php' ),
		'layout_options_slider' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/repeater-slider.php' ),

		// add custom options here
	);
	$box_styles = require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/box-styles.php' );

	$options = array_merge( $options, $box_styles );

	$advanced = array( 'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ) );
	$options  = array_merge( $options, $advanced );

	add_ux_builder_shortcode( 'ux_portfolio_custom', array(
		'name'      => __( 'Portfolio Custom' ),
		'category'  => __( 'Content' ),
		'wrap'      => true,
		'thumbnail' => flatsome_ux_builder_thumbnail( 'portfolio' ),
		'options'   => $options,
	) );

}
