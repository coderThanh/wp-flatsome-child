<?php
class Order_Service {

	/**
	 * T o ch c  1 h ng trong DB
	 *
	 * @param string $body d li u c a h ng, c  tr c c ph n t ch  l  JSON
	 *
	 * @return array
	 */
	public static function create(array $body)
	{
		$domain = API_DOMAIN . '/order/create';

		$data = WP_API::post( $domain, json_encode( $body ) );

		return $data;
	}

	public static function getTotalSuccess()
	{
		$domain = API_DOMAIN . '/order/total/success';

		$data = WP_API::get( $domain );

		return $data;
	}

	public static function getOrders($query)
	{
		$domain = API_DOMAIN . '/order/list';

		$data = WP_API::get( $domain, $query );

		return $data;
	}
}
