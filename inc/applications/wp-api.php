<?php
class WP_API {
	public static function get(string $domain, array $body = [])
	{
		try {
			$res = wp_remote_get( $domain, [ 
				'body' => $body,
			] );

			if( ( !is_wp_error( $res ) ) && ( 200 === wp_remote_retrieve_response_code( $res ) ) ) {
				$responseBody = json_decode( $res['body'], true );

				return $responseBody;
			}

			return $res;
		} catch ( Exception $ex ) {
			return $ex;
		}

	}

	public static function post(string $domain, string $body)
	{
		try {
			$refer = '';

			if( !empty( $_REQUEST['_wp_http_referer'] ) && is_string( $_REQUEST['_wp_http_referer'] ) ) {
				$refer = $_REQUEST['_wp_http_referer'];
			} elseif( !empty( $_SERVER['HTTP_REFERER'] ) ) {
				$refer = $_SERVER['HTTP_REFERER'];
			}

			$res = wp_remote_post( $domain, [ 
				'body'    => $body,
				'headers' => [ 
					'Content-Type' => 'application/json',
					'Referer'      => $refer,
				],
			] );

			// return $res;

			if( ( !is_wp_error( $res ) ) && ( 200 === wp_remote_retrieve_response_code( $res ) ) ) {
				$responseBody = json_decode( $res['body'], true );

				return $responseBody;
			}

			return $res;
		} catch ( Exception $ex ) {
			return $ex;
		}

	}

	public static function getTogeter($urls)
	{
		$multiCurl = [];

		$mh = curl_multi_init();

		foreach( $urls as $i => $url ) {
			$multiCurl[ $i ] = curl_init();
			curl_setopt( $multiCurl[ $i ], CURLOPT_URL, $url );
			curl_setopt( $multiCurl[ $i ], CURLOPT_RETURNTRANSFER, true );
			curl_multi_add_handle( $mh, $multiCurl[ $i ] );
		}

		$running = null;

		do {
			curl_multi_exec( $mh, $running );
			curl_multi_select( $mh );
		} while( $running > 0 );

		$results = [];

		foreach( $multiCurl as $i => $ch ) {
			$results[ $i ] = curl_multi_getcontent( $ch );
			curl_multi_remove_handle( $mh, $ch );
		}

		curl_multi_close( $mh );

		$results = array_filter( $results, function ($item) {
			return !empty( $item );
		} );

		// 
		$decodeds = [];

		foreach( $results as $key => $item ) {

			$decoded = json_decode( $item, true );

			if( !empty( $decoded ) ) {
				$decodeds[ $key ] = $decoded;
			}
		}

		return $decodeds;
	}
}

