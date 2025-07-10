<?php
// 
add_action( 'flatsome_after_header', 'pt_after_header_shop_show_sub_cat', 5 );
if( !function_exists( 'pt_after_header_shop_show_sub_cat' ) ) {
	function pt_after_header_shop_show_sub_cat()
	{
		global $wp_query;

		if( !is_product_category() ) {
			return;
		}

		$cat_id = $wp_query->get_queried_object_id();

		$get_terms_default_attributes = array(
			'taxonomy'   => 'product_cat', //empty string(''), false, 0 don't work, and return empty array
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false, //can be 1, '1' too
			'pad_counts' => false, //can be 0, '0', '' too
			'public'     => true, //can be 0, '0', '' too
			'child_of'   => $cat_id, //can be 0, '0', '' too
		);
		$terms                        = get_terms( $get_terms_default_attributes );

		if( empty( $terms ) ) {
			return;
		}

		$terms_ids = array_map( function ($item) {
			return $item->term_id;
		}, $terms );
		$terms_ids = implode( ',', $terms_ids );

		ob_start();
		?>
		<section class="prod-cat-sub">
			<?php echo do_shortcode( '[ux_product_categories style="default" slider_nav_style="simple" ids="' . $terms_ids . '" show_count="0" image_size="original" image_hover="zoom" hide_empty="0"]' ); ?>
		</section>
		<?php
		echo ob_get_clean();
	}
}


