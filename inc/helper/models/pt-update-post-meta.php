<?php
class PT_UPDATE_POST_META {
	public static function update($post_id, $meta_key, $post_field_name, $type = 'text')
	{
		if( !isset( $_POST[ $post_field_name ] ) ) {
			return;
		}

		$value = $_POST[ $post_field_name ];

		switch( $type ) {
			case 'editor':
			case 'html':
				update_post_meta( $post_id, $meta_key, wp_kses_post( $value ) );
				break;
			case 'array_to_string':
				// Handle array of IDs
				if( is_array( $value ) ) {
					$clean_ids = array_map( 'intval', $value );
					$clean_ids = array_filter( $clean_ids );
					update_post_meta( $post_id, $meta_key, implode( ',', $clean_ids ) );
				} else {
					update_post_meta( $post_id, $meta_key, '' );
				}
				break;
			case 'number':
				update_post_meta( $post_id, $meta_key, intval( $value ) );
				break;
			case 'text':
			default:
				update_post_meta( $post_id, $meta_key, sanitize_text_field( $value ) );
				break;
		}
	}

}
