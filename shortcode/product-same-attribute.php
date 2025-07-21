<?php

/**
 * add shortcode
 * syntax: [pt-product-by-coo-attr]
 */

add_action( 'ux_builder_setup', 'pt_ux_builder_product_coo_attr' );

function pt_ux_builder_product_coo_attr()
{
	add_ux_builder_shortcode( 'pt-product-by-coo-attr', array(
		'name'     => __( 'Pt Sản phẩm cùng thuộc tính' ),
		'category' => __( 'Product Page' ),
		'priority' => 1,
		'options'  => array(
			'attr'             => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( 'pa_thuong-hieu' ),
				'heading'     => 'Taxomony cần lấy',
			),

			'columns'          => array(
				'type'    => 'slider',
				'heading' => 'Column Desktop',
				'default' => '4',
				'max'     => '8',
				'min'     => '1',
			),
			'columns__md'      => array(
				'type'    => 'slider',
				'heading' => 'Column table',
				'default' => '4',
				'max'     => '8',
				'min'     => '1',
			),
			'columns__sm'      => array(
				'type'    => 'slider',
				'heading' => 'Column mobile',
				'default' => '3',
				'max'     => '8',
				'min'     => '1',
			),

			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}

//
add_shortcode( 'pt-product-by-coo-attr', 'pt_shortcode_product_loop_by_coo_attr' );

function pt_shortcode_product_loop_by_coo_attr($atts, $content)
{
	extract( shortcode_atts( array(
		'attr'        => '',
		'columns'     => '4',
		"columns__md" => '4',
		"columns__sm" => '3',
		'class'       => '',
		'visibility'  => '',
	), $atts ) );

	global $product;

	$product_attributes = $product->get_attributes();

	$product_id = $product->get_id();

	if( empty( $attr ) || empty( $product_attributes[ $attr ] ) ) {
		return;
	}

	$term_options = $product_attributes[ $attr ]->get_options();

	//
	if( empty( $term_options ) ) {
		return;
	}

	$term_id     = $term_options[0];
	$taxomony_ob = $product_attributes[ $attr ]->get_taxonomy_object();



	//
	if( empty( $term_id ) ) {
		return;
	}

	$term_ob = get_term_by( 'id', $term_id, $attr );

	$args_query = [ 
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 12,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'post__not_in'   => [ $product_id ],
		'tax_query'      => array(
			'relation' => 'AND',
			array(
				'taxonomy'         => $attr,
				'field'            => 'id',
				'terms'            => array( $term_id ),
				'include_children' => true,
				'operator'         => 'IN',
			),
		),
	];

	$the_query = new WP_Query( $args_query );

	// Create IDS
	$ids = array();
	while( $the_query->have_posts() ) :
		$the_query->the_post();
		array_push( $ids, get_the_ID() );
	endwhile; // end of the loop.
	$ids = implode( ',', $ids );

	if( empty( $ids ) ) {
		return;
	}

	?>
	<div class="products-by-coo-attr-wrap">
		<?php if( !empty( $term_ob ) && !empty( $term_ob->name ) ) :
			; ?>
			<div class="term-name">Sản phẩm cùng <span>
					<?php if( !empty( $taxomony_ob ) && !empty( $taxomony_ob->attribute_label ) ) :
						; ?>
						<?php echo $taxomony_ob->attribute_label . ' '; ?>
					<?php endif; ?>
					<?php echo esc_attr( $term_ob->name ); ?>
				</span></div>
		<?php endif; ?>
		<?php
		echo flatsome_apply_shortcode( 'ux_products', array(
			'type'             => 'slider',
			'slider_nav_style' => 'circle',
			'style'            => 'normal',
			'col_spacing'      => "small",
			'class'            => "products-by-coo-attr",
			'columns'          => $columns,
			"columns__md"      => $columns__md,
			"columns__sm"      => $columns__sm,
			'show_cat'         => '0',
			'show_title'       => '0',
			'show_rating'      => '0',
			'show_price'       => '0',
			'equalize_box'     => 'true',
			'ids'              => $ids,
			'image_height'     => '100%',
			'image_size'       => "thumbnail",
			'image_overlay'    => "rgb(0 0 0 / 0)",
		) );
		?>
	</div>
	<?php
	// Reset Post Data
	wp_reset_postdata();

}
