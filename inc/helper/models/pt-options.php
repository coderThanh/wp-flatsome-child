<?php
class PT_OPTION {
	public static function update($option_key, $value, $type = 'text')
	{
		$value = wp_unslash( $value );

		switch( $type ) {
			case 'textarea':
				update_option( $option_key, sanitize_textarea_field( $value ) );
				break;
			case 'color':
				$color = sanitize_hex_color( $value );
				update_option( $option_key, $color ? $color : '' );
				break;
			case 'html_raw':
				update_option( $option_key, $value );
				break;
			case 'editor':
			case 'html':
				update_option( $option_key, wp_kses_post( $value ) );
				break;
			case 'array_to_string':
				if( is_array( $value ) ) {
					update_option( $option_key, implode( ',', $value ) );
				} else {
					update_option( $option_key, '' );
				}
				break;
			case 'array_int_to_string':
				if( is_array( $value ) ) {
					$clean_ids = array_map( 'intval', $value );
					$clean_ids = array_filter( $clean_ids );
					update_option( $option_key, implode( ',', $clean_ids ) );
				} else {
					update_option( $option_key, '' );
				}
				break;
			case 'number':
				update_option( $option_key, intval( $value ) );
				break;
			case 'text':
			default:
				update_option( $option_key, sanitize_text_field( $value ) );
				break;
		}
	}

	public static function get($option_key, $default = '', $type = 'raw')
	{
		$value = get_option( $option_key, $default );

		switch( $type ) {
			case 'color':
				$color = sanitize_hex_color( $value );
				if( $color ) {
					return $color;
				}
				$default_color = sanitize_hex_color( $default );
				return $default_color ? $default_color : '';
			case 'number':
				return intval( $value );
			case 'array_to_string':
				if( !is_string( $value ) || $value === '' ) {
					return [];
				}
				try {
					$ids = explode( ',', $value );
				} catch( Exception $e ) {
					return [];
				}
				return array_values( $ids );
			case 'array_int_to_string':
				if( !is_string( $value ) || $value === '' ) {
					return [];
				}
				try {
					$ids = array_map( 'intval', explode( ',', $value ) );
				} catch( Exception $e ) {
					return [];
				}
				return array_values( $ids );
			case 'raw':
			default:
				return $value;
		}
	}
}
