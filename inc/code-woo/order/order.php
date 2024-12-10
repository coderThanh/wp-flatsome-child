<?php

require_once( THEME_CHILD_ROOT . '/inc/code-woo/order/controller.php' );
require_once( THEME_CHILD_ROOT . '/inc/code-woo/order/order-admin.php' );
require_once( THEME_CHILD_ROOT . '/inc/code-woo/order/order-fe.php' );
require_once( THEME_CHILD_ROOT . '/assest/vn-address/provinces.php' );
require_once( THEME_CHILD_ROOT . '/assest/vn-address/districts.php' );
require_once( THEME_CHILD_ROOT . '/assest/vn-address/wards.php' );


$WC_BILLING_FIELDS = [ 
	'billing_pt_address'
	, 'billing_pt_full_name'
	, 'billing_pt_phone'
	, 'billing_pt_email'
	, 'billing_pt_district'
	, 'billing_pt_province'
	, 'billing_pt_ward',
];

$WC_INVOICE_FIELDS = [ 
	'billing_invoice_company_email'
	, 'billing_invoice_company_tax'
	, 'billing_invoice_company_address'
	, 'billing_invoice_company_name',
];

$WC_SHIPPING_FIELDS = [ 
	'shipping_pt_address'
	, 'shipping_pt_province'
	, 'shipping_pt_district'
	, 'shipping_pt_ward',
];


//
add_action( 'wp_enqueue_scripts', 'pt_custom_order_enqueue', 60 );

if( !function_exists( 'pt_custom_order_enqueue' ) ) {
	function pt_custom_order_enqueue()
	{
		wp_enqueue_style( 'pt-order', WEBSITE_CHILD_URL . '/inc/code-woo/order/css/order-fe.css', [], '1.0.1' );

		wp_enqueue_script( 'pt-order', WEBSITE_CHILD_URL . '/inc/code-woo/order/js/order.js', [ 'jquery' ], '1.0.1', true );
	}
}

//
add_action( 'admin_enqueue_scripts', 'pt_custom_order_admin_enqueue', 60 );

if( !function_exists( 'pt_custom_order_admin_enqueue' ) ) {
	function pt_custom_order_admin_enqueue()
	{
		wp_enqueue_style( 'admin-pt-order', WEBSITE_CHILD_URL . '/inc/code-woo/order/css/order-admin.css', [], '1.0.1' );

		wp_enqueue_script( 'admin-pt-order', WEBSITE_CHILD_URL . '/inc/code-woo/order/js/order.js', [ 'jquery' ], '1.0.1', true );
	}
}

//
add_filter( 'woocommerce_checkout_fields', 'pt_custom_checkout_field', 99 );

if( !function_exists( 'pt_custom_checkout_field' ) ) {
	function pt_custom_checkout_field($fields)
	{
		// billing
		unset($fields['billing']['billing_last_name']);
		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_postcode']);
		unset($fields['billing']['billing_first_name']);
		unset($fields['billing']['billing_email']);
		unset($fields['billing']['billing_phone']);
		unset($fields['billing']['billing_address_1']);


		$fields['billing']['billing_pt_full_name'] = array(
			'type'        => 'text',
			'label'       => __( 'Họ và tên' ),
			'placeholder' => _x( 'Họ và tên', 'placeholder' ),
			'required'    => true,
			'class'       => array( 'form-row-wide' ),
			'clear'       => true,
			'priority'    => 10,
		);

		$fields['billing']['billing_pt_phone'] = array(
			'type'        => 'tel',
			'label'       => __( 'Số điện thoại' ),
			'placeholder' => _x( 'Ví dụ: 093 123 456', 'placeholder' ),
			'required'    => true,
			'class'       => array( 'form-row-first' ),
			'clear'       => true,
			'priority'    => 12,
		);

		$fields['billing']['billing_pt_email'] = array(
			'type'        => 'email',
			'label'       => __( 'Email' ),
			'placeholder' => _x( 'email', 'placeholder' ),
			'required'    => true,
			'class'       => array( 'form-row-last' ),
			'clear'       => true,
			'priority'    => 15,
		);

		$fields['billing']['billing_pt_address'] = array(
			'type'        => 'text',
			'label'       => __( 'Số nhà' ),
			'placeholder' => _x( 'Ví dụ: 18 Trần Hưng Đạo', 'placeholder' ),
			'required'    => true,
			'class'       => array( 'form-row-first' ),
			'clear'       => true,
			'priority'    => 20,
		);

		$fields['billing']['billing_pt_province'] = array(
			'type'     => 'text',
			'label'    => __( 'Tỉnh / thành phố' ),
			'required' => true,
			'class'    => array( 'form-row-last', 'wc-address-search', 'wc-procinves-select' ),
			'clear'    => true,
			'priority' => 25,
		);

		$fields['billing']['billing_pt_district'] = array(
			'type'     => 'text',
			'label'    => __( 'Quận / huyện' ),
			'required' => true,
			'class'    => array( 'form-row-first', 'wc-address-search', 'wc-district-select' ),
			'clear'    => true,
			'priority' => 26,
		);

		$fields['billing']['billing_pt_ward'] = array(
			'type'     => 'text',
			'label'    => __( 'Phường / xã' ),
			'required' => true,
			'class'    => array( 'form-row-last', 'wc-address-search', 'wc-ward-select' ),
			'clear'    => true,
			'priority' => 27,
			// 'options'  => array_merge( [ 
			// 	'' => 'Chọn phường / xã',
			// ] ),
		);

		// Invoice
		$fields['billing']['billing_invoice_require'] = array(
			'type'     => 'text',
			'label'    => __( 'Xuất hoá đơn công ty' ),
			'required' => false,
			'class'    => array( 'is-field-invoice' ),
			'clear'    => true,
			'priority' => 22,
		);



		$fields['billing']['billing_invoice_company_tax'] = array(
			'type'     => 'text',
			'label'    => __( 'Mã số thuế' ),
			'required' => true,
			'class'    => array( 'is-field-invoice' ),
			'clear'    => true,
			'priority' => 22,
		);

		$fields['billing']['billing_invoice_company_name'] = array(
			'type'     => 'text',
			'label'    => __( 'Tên công ty' ),
			'required' => true,
			'class'    => array( 'is-field-invoice' ),
			'clear'    => true,
			'priority' => 22,
		);

		$fields['billing']['billing_invoice_company_address'] = array(
			'type'     => 'text',
			'label'    => __( 'Địa chỉ công ty' ),
			'required' => true,
			'class'    => array( 'is-field-invoice' ),
			'clear'    => true,
			'priority' => 22,
		);

		$fields['billing']['billing_invoice_company_email'] = array(
			'type'     => 'email',
			'label'    => __( 'Email công ty' ),
			'required' => true,
			'class'    => array( 'is-field-invoice' ),
			'clear'    => true,
			'priority' => 22,
		);

		// Shipping
		unset($fields['shipping']['shipping_first_name']);
		unset($fields['shipping']['shipping_last_name']);
		unset($fields['shipping']['shipping_country']);
		unset($fields['shipping']['shipping_state']);
		unset($fields['shipping']['shipping_postcode']);
		unset($fields['shipping']['shipping_city']);
		unset($fields['shipping']['shipping_address_1']);
		unset($fields['shipping']['shipping_address_2']);
		unset($fields['shipping']['shipping_company']);


		$fields['shipping']['shipping_pt_address'] = array(
			'type'        => 'text',
			'label'       => __( 'Số nhà' ),
			'placeholder' => _x( 'Ví dụ: 18 Trần Hưng Đạo', 'placeholder' ),
			'required'    => true,
			'class'       => array( 'form-row-first' ),
			'clear'       => true,
			'priority'    => 10,
		);


		$fields['shipping']['shipping_pt_province'] = array(
			'type'     => 'text',
			'label'    => __( 'Tỉnh / thành phố' ),
			'required' => true,
			'class'    => array( 'form-row-last', 'wc-address-search', 'wc-procinves-select' ),
			'clear'    => true,
			'priority' => 25,
		);

		$fields['shipping']['shipping_pt_district'] = array(
			'type'     => 'text',
			'label'    => __( 'Quận / huyện' ),
			'required' => true,
			'class'    => array( 'form-row-first', 'wc-address-search', 'wc-district-select' ),
			'clear'    => true,
			'priority' => 26,
		);

		$fields['shipping']['shipping_pt_ward'] = array(
			'type'     => 'text',
			'label'    => __( 'Phường / xã' ),
			'required' => true,
			'class'    => array( 'form-row-last', 'wc-address-search', 'wc-ward-select' ),
			'clear'    => true,
			'priority' => 27,
		);




		return $fields;
	}
}


add_action( 'woocommerce_after_checkout_validation', 'woocommerce_after_checkout_validation_alter', 10, 2 );

function woocommerce_after_checkout_validation_alter($data, $errors)
{
	if( empty( $data['billing_invoice_require'] ) ) {

		if( $errors->get_error_data( 'billing_invoice_company_tax_required' ) ) {
			$errors->remove( 'billing_invoice_company_tax_required' );
		}

		if( $errors->get_error_data( 'billing_invoice_company_name_required' ) ) {
			$errors->remove( 'billing_invoice_company_name_required' );
		}

		if( $errors->get_error_data( 'billing_invoice_company_address_required' ) ) {
			$errors->remove( 'billing_invoice_company_address_required' );
		}

		if( $errors->get_error_data( 'billing_invoice_company_email_required' ) ) {
			$errors->remove( 'billing_invoice_company_email_required' );
		}
	}

	// fix error by coutry
	$errors->remove( 'shipping' );



	return $data;
}
