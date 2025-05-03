<?php
// Setup theme init
add_action( 'init', 'pt_woo_setup' );

function pt_woo_setup()
{
	/**
	 * Update cart label when custom cart icon is selected
	 *  */
	add_filter( 'woocommerce_add_to_cart_fragments', 'pt_header_add_to_cart_custom_icon_fragment_count_label' );

	remove_filter( 'woocommerce_add_to_cart_fragments', 'flatsome_header_add_to_cart_fragment_count_label', 0 );
}


if( !function_exists( 'pt_header_add_to_cart_custom_icon_fragment_count_label' ) ) {
	/**
	 * Update cart label when custom cart icon is selected
	 *
	 * @param $fragments
	 *
	 * @return mixed
	 */
	function pt_header_add_to_cart_custom_icon_fragment_count_label($fragments)
	{
		$custom_cart_icon = get_theme_mod( 'custom_cart_icon' );
		if( !$custom_cart_icon ) {
			return $fragments;
		}

		ob_start();
		?>
		<span class="image-icon header-cart-icon"
			data-icon-label="<?php echo WC()->cart->cart_contents_count; ?>">
			<img class="cart-img-icon"
				alt="<?php _e( 'Cart', 'woocommerce' ); ?>"
				src="<?php echo do_shortcode( get_theme_mod( 'custom_cart_icon' ) ); ?>" />
			<svg xmlns:xlink="http://www.w3.org/1999/xlink"
				xmlns="http://www.w3.org/2000/svg"
				width="24"
				height="24"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="1.5"
				stroke-linecap="round"
				stroke-linejoin="round">
				<circle cx="9"
					cy="21"
					r="1" />
				<circle cx="20"
					cy="21"
					r="1" />
				<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
			</svg>
		</span>
		<?php
		$fragments['.image-icon.header-cart-icon'] = ob_get_clean();

		return $fragments;
	}
}


/**
 * Product box , detail add unit
 */
function pt_wc_custom_get_price_html_empty($price)
{

	global $product;

	if( $product->get_price() == 0 || empty( $product->get_price() ) ) {
		$price = '<span class="amount">' . __( 'Liên hệ', 'woocommerce' ) . '</span>';
	}

	return $price;
}
add_filter( 'woocommerce_empty_price_html', 'pt_wc_custom_get_price_html_empty' );


