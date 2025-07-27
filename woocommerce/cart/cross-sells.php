<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

?>
<!-- get product relative -->
<?php if( false ) :
	; ?>
	<?php
	$product_ids_in_cart = [];
	foreach( WC()->cart->get_cart() as $cart_item ) {
		$product_ids_in_cart[] = $cart_item['product_id'];
	}
	// Loại bỏ trùng lặp nếu cần
	$product_ids_in_cart = array_unique( $product_ids_in_cart );

	$relative_ids = [];
	$product_cats = [];
	foreach( $product_ids_in_cart as $product_id ) {
		$terms = get_the_terms( $product_id, 'product_cat' );
		if( !is_wp_error( $terms ) && !empty( $terms ) ) {
			foreach( $terms as $term ) {
				array_push( $product_cats, $term->term_id );
			}
		}
	}

	if( !empty( $product_cats ) ) {
		$args      = [ 
			'post_type'      => 'product',
			'posts_per_page' => 12,
			'post__not_in'   => $product_ids_in_cart,
			'tax_query'      => [ 
				[ 
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $product_cats,
				],
			],
		];
		$the_query = new WP_Query( $args );

		if( $the_query->have_posts() ) {
			while( $the_query->have_posts() ) :
				$the_query->the_post();
				array_push( $relative_ids, get_the_ID() );
			endwhile; // end of the loop. 
		}
	}
	?>
	<?php if( !empty( $relative_ids ) ) :
		; ?>
		<?php
		$relative_ids = implode( ',', $relative_ids );
		?>
		<div class="cross-sells cross-relates">
			<h2>Sản phẩm tương tự</h2>
			<?php echo do_shortcode( '[ux_products columns__sm="3" columns__md="3" columns="4" type="slider" slider_nav_style="circle" show_cat="0" show_rating="0" show_quick_view="0" ids="' . $relative_ids . '"]' );
			; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
<!-- get cross sells -->
<?php if( $cross_sells ) : ?>
	<?php
	$product_ids = [];
	?>
	<?php foreach( $cross_sells as $cross_sell ) : ?>
		<?php
		array_push( $product_ids, $cross_sell->get_id() );
	?>
	<?php endforeach; ?>
	<?php if( !empty( $product_ids ) ) :
		; ?>
		<div class="cross-sells">
			<?php

			$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'woocommerce' ) );
			if( $heading ) :
				?>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php

			$ids = implode( $product_ids, ',' );
			echo do_shortcode( '[ux_products columns__sm="3" columns__md="3" columns="4" type="slider" slider_nav_style="circle" show_cat="0" show_rating="0" show_quick_view="0" ids="' . $ids . '"]' ); ?>
		</div>
	<?php endif; ?>
<?php
endif;

wp_reset_postdata();
