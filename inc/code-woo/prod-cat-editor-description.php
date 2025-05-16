<?php



/*
 * Show FE, Arhcive product body bottom 
 */
add_action( 'woocommerce_after_main_content', 'pt_show_archive_product_descriptions_bottom', 10 );

if( !function_exists( 'pt_show_archive_product_descriptions_bottom' ) ) {
	function pt_show_archive_product_descriptions_bottom()
	{
		if( !is_product_category() ) {
			return;
		}

		global $wp_query;

		$cat_id = $wp_query->get_queried_object_id();

		$term_meta = get_term_meta( $cat_id );

		$description = isset( $term_meta["cat_description"] ) ? $term_meta["cat_description"][0] : '';

		ob_start();
		echo '</div>';
		?>
		
		<div class="col">
			<?php if( !empty( $description ) ) :
				; ?>
				<div id="term-description_bottom" class="term-description load-more-wrap">
					<?php echo wpautop( $description ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
		echo ob_get_clean();
	}
}



/**
 * Remove default field Category Descript
 * Add editor later
 */
add_action( 'admin_head', 'pt_remove_default_product_cat_description' );

if( !function_exists( 'pt_remove_default_product_cat_description' ) ) {
	function pt_remove_default_product_cat_description()
	{
		global $current_screen;
		?>
		<?php
		if( $current_screen->id == 'edit-product_cat' ) {
			?>
			<script type="text/javascript">
				jQuery(function ($) {
					$('textarea#description').closest('tr.form-field').remove();
				});
			</script>
			<?php
		}
	}
}

/**
 * Add new desciption with wp-editor
 */

add_filter( 'product_cat_edit_form_fields', 'pt_product_cat_description' );

if( !function_exists( 'pt_product_cat_description' ) ) {
	function pt_product_cat_description($term)
	{

		// put the term ID into a variable
		$t_id = $term->term_id;
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_term_meta( $t_id );

		?>
		<?php wp_nonce_field( 'pt_check_update_term_product_cat', '_pt_check_update_term_product_cat' ); ?>
		<!-- <table class="form-table"> -->
		<tr class="form-field term-description-wrap">
			<th scope="row" valign="top"><label for="description"><?php _e( 'Mô tả đầy đủ' ); ?></label></th>
			<td>
				<?php
				$settings = array( 'wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description', 'tabfocus_elements' => 'content-html,save-post' );

				wp_editor( isset( $term_meta["cat_description"] ) ? $term_meta["cat_description"][0] : "", 'cat_description', $settings );
				?>
			</td>
		</tr>
		<!-- </table> -->
		<?php
	}
}

/**
 * Save Taxomony pro_cat
 */

add_action( 'edited_product_cat', 'pt_save_product_cat_term_fields' );

if( !function_exists( 'pt_save_product_cat_term_fields' ) ) {
	function pt_save_product_cat_term_fields($term_id)
	{

		if( !isset( $_POST['_pt_check_update_term_product_cat'] ) ) {
			return;
		}

		if( wp_verify_nonce( $_POST['_pt_check_update_term_product_cat'], 'pt_check_update_term_product_cat' ) ) {
			update_term_meta(
				$term_id,
				'cat_description',

				$_POST['description']
			);

			// Save description two time
			update_term_meta(
				$term_id,
				'description',
				sanitize_textarea_field( $_POST['cat_summary'] )
			);
		}
	}
}

/*
 * Code Load more for Archive product term description bottom
 */
add_action( 'wp_footer', 'pt_load_more_archive_product_bottom' );

function pt_load_more_archive_product_bottom()
{
	?>
	<style>
		#term-description_bottom {
			overflow: hidden;
			position: relative;
			margin-top : 5px;
		}

		.pt_btn_loadmore_prodct_cat {
			text-align: center;
			cursor: pointer;
			position: absolute;
			z-index: 10;
			bottom: 0;
			width: 100%;
			background: #fff;
		}

		.pt_btn_loadmore_prodct_cat:before {
			height: 68px;
			margin-top: -68px;
			content: "";
			background: linear-gradient(0deg, white 10%, transparent);
			display: block;
		}

		/* .pt_btn_loadmore_prodct_cat a {
						color: #318A00;
						display: block;
					} */
		/* .pt_btn_loadmore_prodct_cat a:after {
						content: '';
						width: 0;
						right: 0;
						border-top: 6px solid #318A00;
						border-left: 6px solid transparent;
						border-right: 6px solid transparent;
						display: inline-block;
						vertical-align: middle;
						margin: -2px 0 0 5px;
					} */
	</style>
	<script>
		jQuery(document).ready(function ($) {
			if ($('#term-description_bottom').length > 0) {
				var wrap = $('#term-description_bottom');
				var current_height = wrap.height();
				var your_height = 400;

				if (current_height > your_height) {
					wrap.css('height', your_height + 'px');
					wrap.append(function () {
						return '<div class="pt_btn_loadmore_prodct_cat content"><a title="Xem thêm" class=" btn button red" href="javascript:void(0);"><span>Xem thêm</span></a></div>';
					});
					$('body').on('click', '.pt_btn_loadmore_prodct_cat.content', function () {
						wrap.removeAttr('style');
						$('body .pt_btn_loadmore_prodct_cat.content').remove();
					});
				}
			}
		});
	</script>
	<?php
}
