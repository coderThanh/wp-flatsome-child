<?php

if ( ! class_exists( 'PT_Field_Select_Post_Type' ) ) {
	class PT_Field_Select_Post_Type {

		/**
		 * Enqueue Select2 Assets (CDN)
		 * Should be called in admin_enqueue_scripts hook
		 */
		public static function enqueue_assets() {
			// CSS
			wp_enqueue_style( 'select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', [], '4.1.0' );
			
			// JS
			wp_enqueue_script( 'select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'], '4.1.0', true );
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
		public static function render( $input_name, $post_type = 'post', $selected_ids = [], $is_multiple = false, $placeholder = 'Chọn bài viết', $query_args = [] ) {
			
			// Default Query Args
			$args = wp_parse_args( $query_args, [
				'post_type'      => $post_type,
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => 'ids', // Only get IDs to optimize, then get titles
			] );

			// Get Posts
			$posts = get_posts( $args );

			// Normalize selected_ids
			if ( ! is_array( $selected_ids ) ) {
				$selected_ids = ! empty( $selected_ids ) ? [ $selected_ids ] : [];
			}
			$selected_ids = array_map( 'intval', $selected_ids );

			// Setup attributes
			$id_attr = uniqid( 'pt_select2_' );
			$name_attr = $is_multiple ? $input_name . '[]' : $input_name;
			$multiple_attr = $is_multiple ? 'multiple="multiple"' : '';
			
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
					data-placeholder="<?php echo esc_attr( $placeholder ); ?>"
				>
					<?php if ( ! $is_multiple ) : ?>
						<option value=""></option>
					<?php endif; ?>

					<?php 
					foreach ( $posts as $post_id ) : 
						$title = get_the_title( $post_id );
						$selected = in_array( $post_id, $selected_ids ) ? 'selected="selected"' : '';
						?>
						<option value="<?php echo esc_attr( $post_id ); ?>" <?php echo $selected; ?>>
							<?php echo esc_html( $title ); ?> (ID: <?php echo $post_id; ?>)
						</option>
					<?php endforeach; ?>
				</select>
				
				<script>
					jQuery(document).ready(function($) {
						// Initialize Select2
						// Check if select2 is available
						if ($.fn.select2) {
							$('#<?php echo $id_attr; ?>').select2({
								placeholder: "<?php echo $placeholder; ?>",
								allowClear: true,
								width: '100%'
							});
						} else {
							console.warn('Select2 library is not loaded.');
						}
					});
				</script>
				<style>
					/* Basic fix for Select2 in WP Admin if needed */
					.pt-field-select-wrap .select2-container {
						margin-bottom: 5px;
					}
				</style>
			</div>
			<?php
			return ob_get_clean();
		}
	}
}
