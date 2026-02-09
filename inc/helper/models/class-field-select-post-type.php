<?php

if( !class_exists( 'PT_Field_Select_Post_Type' ) ) {
	class PT_Field_Select_Post_Type {

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
		 * Render Select2 for Post Type
		 *
		 * @param string $input_name  Input name attribute
		 * @param string $post_type   Post Type to query
		 * @param array|string $selected_ids Selected IDs
		 * @param bool $is_multiple   Enable multiple selection
		 * @param string $placeholder Placeholder text
		 * @param array $query_args   Additional WP_Query args
		 *
		 * @return string HTML output
		 */
		public static function render($input_name, $post_type = 'post', $selected_ids = [], $is_multiple = false, $placeholder = 'Chọn bài viết', $query_args = [])
		{

			// Normalize selected_ids
			if( !is_array( $selected_ids ) ) {
				$selected_ids = !empty( $selected_ids ) ? [ $selected_ids ] : [];
			}
			$selected_ids = array_map( 'intval', $selected_ids );

			// Setup attributes
			$id_attr       = uniqid( 'pt_select2_' );
			$name_attr     = $is_multiple ? $input_name . '[]' : $input_name;
			$multiple_attr = $is_multiple ? 'multiple="multiple"' : '';
			$ajax_nonce    = wp_create_nonce( 'pt_select_post_type' );

			// Enqueue Select2 if not already (Optional: better to do this in admin_enqueue_scripts)
			// For now, we assume Select2 is loaded or will be loaded by the theme/plugin

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
						$pre_posts = get_posts( [
							'post_type'      => $post_type,
							'post__in'       => $selected_ids,
							'posts_per_page' => count( $selected_ids ),
							'post_status'    => 'publish',
							'orderby'        => 'post__in',
							'fields'         => 'ids',
						] );
						foreach( $pre_posts as $post_id ) {
							$title    = get_the_title( $post_id );
							$selected = 'selected="selected"';
							?>
							<option value="<?php echo esc_attr( $post_id ); ?>" <?php echo $selected; ?>>
								<?php echo esc_html( $title ); ?> (ID: <?php echo $post_id; ?>)
							</option>
							<?php
						}
					}
					
					?>
				</select>
			
				<script>
					jQuery(document).ready(function ($) {
						// Initialize Select2
						// Check if select2 is available
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
											action: 'pt_select_post_type_search',
											_nonce: "<?php echo esc_attr( $ajax_nonce ); ?>",
											post_type: "<?php echo esc_attr( $post_type ); ?>",
											q: params.term || '',
											page: params.page || 1
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
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * AJAX handler: search posts by type with pagination
		 */
		public static function ajax_search()
		{
			check_ajax_referer( 'pt_select_post_type', '_nonce' );

			$post_type = isset( $_REQUEST['post_type'] ) ? sanitize_key( $_REQUEST['post_type'] ) : 'post';
			$search    = isset( $_REQUEST['q'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['q'] ) ) : '';
			$page      = isset( $_REQUEST['page'] ) ? max( 1, intval( $_REQUEST['page'] ) ) : 1;

			$per_page = 20;

			$query = new WP_Query( [
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => $per_page,
				'paged'          => $page,
				's'              => $search,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => 'ids',
			] );

			$results = [];
			if( $query->have_posts() ) {
				foreach( $query->posts as $pid ) {
					$results[] = [
						'id'   => $pid,
						'text' => get_the_title( $pid ) . ' (ID: ' . $pid . ')',
					];
				}
			}

			$more = ( $query->found_posts > ( $page * $per_page ) );

			wp_send_json( [
				'results' => $results,
				'more'    => $more,
			] );
		}
	}
}

// Register AJAX actions
add_action( 'wp_ajax_pt_select_post_type_search', [ 'PT_Field_Select_Post_Type', 'ajax_search' ] );
