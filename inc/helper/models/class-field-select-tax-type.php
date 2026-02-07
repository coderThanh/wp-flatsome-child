<?php

if( !class_exists( 'PT_Field_Select_TAX_Type' ) ) {
	class PT_Field_Select_TAX_Type {

		/**
		 * Enqueue Select2 Assets (CDN)
		 * Should be called in admin_enqueue_scripts hook
		 */
		public static function enqueue_assets()
		{
			// CSS
			wp_enqueue_style( 'select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', [], '4.1.0' );

			// JS
			wp_enqueue_script( 'select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', [ 'jquery' ], '4.1.0', true );
		}

		/**
		 * Render Select2 for Taxonomy
		 *
		 * @param string $input_name  Input name attribute
		 * @param string $taxonomy    Taxonomy to query
		 * @param array|string $selected_ids Selected IDs
		 * @param bool $is_multiple   Enable multiple selection
		 * @param string $placeholder Placeholder text
		 * @param array $query_args   Additional get_terms args (e.g., ['parent' => 0] for root only)
		 *
		 * @return string HTML output
		 */
		public static function render($input_name, $taxonomy = 'category', $selected_ids = [], $is_multiple = false, $placeholder = 'Chọn danh mục', $query_args = [], $show_id = true)
		{

			// Normalize selected_ids
			if( !is_array( $selected_ids ) ) {
				$selected_ids = !empty( $selected_ids ) ? [ $selected_ids ] : [];
			}
			$selected_ids = array_map( 'intval', $selected_ids );

			// Setup attributes
			$id_attr       = uniqid( 'pt_select2_tax_' );
			$name_attr     = $is_multiple ? $input_name . '[]' : $input_name;
			$multiple_attr = $is_multiple ? 'multiple="multiple"' : '';
			$ajax_nonce    = wp_create_nonce( 'pt_select_tax_type' );

			// Serialize query_args for AJAX
			$query_args_json = json_encode( $query_args );

			ob_start();
			?>
			<div class="pt-field-select-wrap">
				<select
					name="<?php echo esc_attr( $name_attr ); ?>"
					id="<?php echo esc_attr( $id_attr ); ?>"
					class="pt-select2-field"
					<?php echo $multiple_attr; ?>
					style="width: 100%;"
					data-placeholder="<?php echo esc_attr( $placeholder ); ?>">
					<?php if( !$is_multiple ) : ?>
						<option value=""></option>
					<?php endif; ?>
					<?php
					// Pre-populate selected options only
					if( !empty( $selected_ids ) ) {
						$terms = get_terms( [
							'taxonomy'   => $taxonomy,
							'include'    => $selected_ids,
							'hide_empty' => false,
						] );
						
						if ( ! is_wp_error( $terms ) ) {
							foreach( $terms as $term ) {
								$selected = 'selected="selected"';
								$option_text = esc_html( $term->name );
								if ( $show_id ) {
									$option_text .= ' (ID: ' . $term->term_id . ')';
								}
								?>
								<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php echo $selected; ?>>
									<?php echo $option_text; ?>
								</option>
								<?php
							}
						}
					}
					?>
				</select>
			
				<script>
					jQuery(document).ready(function ($) {
						// Initialize Select2
						if ($.fn.select2) {
							$('#<?php echo $id_attr; ?>').select2({
								placeholder: "<?php echo $placeholder; ?>",
								allowClear: true,
								width: '100%',
								minimumInputLength: 0,
								ajax: {
									url: "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>",
									dataType: 'json',
									delay: 250,
									data: function (params) {
										return {
											action: 'pt_select_tax_type_search',
											_nonce: "<?php echo esc_attr( $ajax_nonce ); ?>",
											taxonomy: "<?php echo esc_attr( $taxonomy ); ?>",
											query_args: <?php echo json_encode($query_args); ?>, 
											q: params.term || '',
											page: params.page || 1,
											show_id: <?php echo $show_id ? '1' : '0'; ?>
										};
									},
									processResults: function (data, params) {
										params.page = params.page || 1;
										return {
											results: data.results || [],
											pagination: {
												more: !!data.more
											}
										};
									},
									cache: true
								},
								templateResult: function (item) {
									if (item.loading) return item.text;
									return item.text;
								},
								templateSelection: function (item) {
									return item.text || item.id;
								}
							});
						} else {
							console.warn('Select2 library is not loaded.');
						}
					});
				</script>
				<style>
					.pt-field-select-wrap .select2-container {
						margin-bottom: 5px;
					}
				</style>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * AJAX handler: search terms by taxonomy with pagination
		 */
		public static function ajax_search()
		{
			check_ajax_referer( 'pt_select_tax_type', '_nonce' );

			$taxonomy   = isset( $_REQUEST['taxonomy'] ) ? sanitize_key( $_REQUEST['taxonomy'] ) : 'category';
			$search     = isset( $_REQUEST['q'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['q'] ) ) : '';
			$page       = isset( $_REQUEST['page'] ) ? max( 1, intval( $_REQUEST['page'] ) ) : 1;
			$query_args = isset( $_REQUEST['query_args'] ) ? $_REQUEST['query_args'] : [];
			$show_id    = isset( $_REQUEST['show_id'] ) ? (bool) $_REQUEST['show_id'] : true;

			// Handle JSON object from jQuery
			if ( is_string( $query_args ) ) {
				$decoded = json_decode( stripslashes( $query_args ), true );
				if ( is_array( $decoded ) ) {
					$query_args = $decoded;
				}
			}

			$per_page = 20;
			$offset   = ( $page - 1 ) * $per_page;

			$args = [
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'search'     => $search,
				'number'     => $per_page,
				'offset'     => $offset,
				'fields'     => 'all', // Get term objects
			];

			// Merge custom query args (e.g. parent => 0)
			if ( ! empty( $query_args ) && is_array( $query_args ) ) {
				$args = array_merge( $args, $query_args );
			}

			$terms = get_terms( $args );

			// Check for 'more' pages
			// To accurately check 'more', we might need to count total terms matching search
			// For simple 'more' logic, if we got $per_page results, we assume there might be more. 
			// Or we can count total separately.
			
			$count_args = $args;
			unset($count_args['number']);
			unset($count_args['offset']);
			$count_args['fields'] = 'count';
			$total_count = get_terms($count_args); // This returns string count

			if ( is_wp_error( $total_count ) ) {
				$total_count = 0;
			}

			$results = [];
			if ( ! is_wp_error( $terms ) ) {
				foreach( $terms as $term ) {
					$text = $term->name;
					if ( $show_id ) {
						$text .= ' (ID: ' . $term->term_id . ')';
					}
					$results[] = [
						'id'   => $term->term_id,
						'text' => $text,
					];
				}
			}

			$more = ( $total_count > ( $page * $per_page ) );

			wp_send_json( [
				'results' => $results,
				'more'    => $more,
			] );
		}
	}
}

// Register AJAX actions
add_action( 'wp_ajax_pt_select_tax_type_search', [ 'PT_Field_Select_TAX_Type', 'ajax_search' ] );
