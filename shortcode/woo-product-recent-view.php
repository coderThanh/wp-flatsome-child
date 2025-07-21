<?php

add_action( 'template_redirect', 'pt_woo_product_recent_view_set_ids' );

if( !function_exists( 'pt_woo_product_recent_view_set_ids' ) ) {
	/**
	 * Sets the IDs of recently viewed products.
	 *
	 * This function gets the ID of the current product, checks for existing IDs in the 'recently_viewed' cookie,
	 * adds the current product ID to the list, removes duplicates, and updates the cookie.
	 *
	 * @global WC_Product $product The current product object.
	 * @return void
	 */
	function pt_woo_product_recent_view_set_ids()
	{

		if( !is_product() ) {
			return;
		}

		global $post;

		$id = $post->ID;

		$day = time() + 60 * 60 * 24;

		$stringIDs = $_COOKIE['recently_viewed'] ?? '';

		$ids = array_filter( explode( ',', $stringIDs ) );

		array_unshift( $ids, $id );

		$ids = array_unique( $ids );

		if( count( $ids ) > 12 ) {
			$ids = array_slice( $ids, 0, 12 );
		}

		$stringIDs = implode( ',', $ids );

		setcookie( 'recently_viewed', $stringIDs, $day, '/' );

	}
}

//
add_action( 'ux_builder_setup', 'pt_woo_product_recent_view_ux' );

if( !function_exists( 'pt_woo_product_recent_view_ux' ) ) {
	/**
	 * Registers the 'Pt Logo' shortcode with UX Builder.
	 *
	 * @return void
	 */
	function pt_woo_product_recent_view_ux()
	{
		add_ux_builder_shortcode( 'pt-woo-recently-view', array(
			'name'     => __( 'Pt Product Recently View' ),
			'category' => __( 'Content' ),
			'priority' => 10,
			'info'     => '{{ title }}',
			'options'  => array(
				'title'            => array(
					'full_width'  => true,
					'type'        => 'textfield',
					'heading'     => 'Label',
					'placeholder' => 'Enter label here..',
				),
				// 
				'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
			),
		) );
	}
}


//
add_shortcode( 'pt-woo-recently-view', 'pt_woo_product_recent_view_shortcode' );

if( !function_exists( 'pt_woo_product_recent_view_shortcode' ) ) {
	function pt_woo_product_recent_view_shortcode($atts)
	{

		extract( shortcode_atts( array(
			'title'      => '',
			'class'      => '',
			'visibility' => '',
		), $atts ) );

		$stringIDs = $_COOKIE['recently_viewed'] ?? '';

		if( empty( $stringIDs ) ) {
			return;
		}

		$col    = get_theme_mod( 'related_products_pr_row', 4 );
		$col_md = get_theme_mod( 'related_products_pr_row_tablet', 3 );
		$col_sm = get_theme_mod( 'related_products_pr_row_mobile', 2 );

		$attr = [ 
			'ids'          => $stringIDs,
			'style'        => "normal",
			'type'         => "slider",
			'columns__sm'  => $col_sm,
			'columns__md'  => $col_md,
			'columns'      => $col,
			'show_cat'     => "0",
			'show_rating'  => "0",
			'equalize_box' => "true",
			'image_height' => "100%",
			'image_size'   => "thumbnail",
			'text_align'   => "left",
		];


		echo $title ? '<div class="prd-recently-view-title">' . $title . '</div>' : '';

		echo ux_products( $attr );


	}
}


