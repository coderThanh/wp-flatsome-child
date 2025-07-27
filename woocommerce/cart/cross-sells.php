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

if( $cross_sells ) : ?>
	<div class="cross-sells">
		<?php

		$product_ids = [];

		$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'woocommerce' ) );
		if( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php foreach( $cross_sells as $cross_sell ) : ?>
			<?php
			array_push( $product_ids, $cross_sell->get_id() );
			?>
		<?php endforeach; ?>
		<?php if( !empty( $product_ids ) ) :
			; ?>
			<?php

			$ids = implode( $product_ids, ',' );

			echo do_shortcode( '[ux_products columns__sm="3" columns__md="3" columns="4" type="slider" slider_nav_style="circle" show_cat="0" show_rating="0" show_quick_view="0" ids="' . $ids . '"]' ); ?>
		<?php endif; ?>
	</div>
	<?php
endif;

wp_reset_postdata();
