<?php
/*
 * Show FE, Arhcive product
 */
// add_action( 'woocommerce_after_main_content', 'pt_show_archive_product_background', 10 );

if( !function_exists( 'pt_show_archive_product_background' ) ) {
	function pt_show_archive_product_background()
	{
		if( !is_product_category() ) {
			return;
		}
		global $wp_query;

		$cat_id     = $wp_query->get_queried_object_id();
		$term_meta  = get_term_meta( $cat_id );
		$background = isset( $term_meta["background"] ) ? $term_meta["background"][0] : '';

		ob_start();
		?>
		<?php
		echo ob_get_clean();
	}
}



/**
 * Add new field image
 */

add_filter( 'product_cat_edit_form_fields', 'pt_product_cat_edit_background' );

if( !function_exists( 'pt_product_cat_edit_background' ) ) {
	function pt_product_cat_edit_background($term)
	{

		// put the term ID into a variable
		$t_id = $term->term_id;
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_term_meta( $t_id );

		?>
		<?php wp_nonce_field( 'pt_check_update_term_product_cat_for_background', '_pt_check_update_term_product_cat_for_background' ); ?>
		<!-- <table class="form-table"> -->
		<tr class="form-field term-description-wrap">
			<th scope="row" valign="top"><label for="description"><?php _e( 'Ảnh nền' ); ?></label></th>
			<td>
				<?php echo button_upload_image( 'background', isset( $term_meta["background"] ) ? $term_meta["background"][0] : "" ); ?>
			</td>
		</tr>
		<!-- </table> -->
		<?php
	}
}

/**
 * Save Taxomony pro_cat
 */

add_action( 'edited_product_cat', 'pt_save_product_cat_term_bg' );

if( !function_exists( 'pt_save_product_cat_term_bg' ) ) {
	function pt_save_product_cat_term_bg($term_id)
	{

		if( !isset( $_POST['_pt_check_update_term_product_cat_for_background'] ) ) {
			return;
		}

		if( wp_verify_nonce( $_POST['_pt_check_update_term_product_cat_for_background'], 'pt_check_update_term_product_cat_for_background' ) ) {
			update_term_meta(
				$term_id,
				'background',
				$_POST['background']
			);
		}
	}
}
