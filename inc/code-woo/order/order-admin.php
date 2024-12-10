<?php
/**
 * Function to handle displaying additional order data after the billing address on the WooCommerce admin order page.
 *
 * @param mixed $order The order object for which to display the additional data.
 */

add_action( 'woocommerce_admin_order_data_after_billing_address', 'pt_wc_admin_order_data_after_billing_address', 20, 1 );

if( !function_exists( 'pt_wc_admin_order_data_after_billing_address' ) ) {
	function pt_wc_admin_order_data_after_billing_address($order)
	{

		global $WC_BILLING_FIELDS, $WC_SHIPPING_FIELDS, $WC_INVOICE_FIELDS;

		// form type
		$checkoutFields  = PT_WC_CHECKOUT_CONTROLLER::getCheckoutFields();
		$shipping_fields = $checkoutFields['shipping'];
		$billing_fields  = $checkoutFields['billing'];
		$invoice_fields  = $checkoutFields['invoice'];

		// data current
		$metaDatas         = PT_WC_CHECKOUT_CONTROLLER::getOrderMetaData( $order );
		$metaDataBillings  = $metaDatas['billing'];
		$metaDataInvoices  = $metaDatas['invoice'];
		$metaDataShippings = $metaDatas['shipping'];

		ob_start();
		?>
		<!-- JSON Address -->
		<?php echo PT_WC_CHECKOUT_CONTROLLER::getHTMLAllAdress(); ?>
		<?php wp_nonce_field( 'pt_wc_order_update_meta_data', '_pt_wc_order_update_meta_data' ); ?>
		<!-- Billing fields -->
		<?php
		$fieldsCurrent = $billing_fields;
		$dataCurrent   = $metaDataBillings;
		?>
		<div class="order-data-item order-fields order-data-billing">
			<div class="el-main-title"><?php esc_html_e( 'Billing', 'woocommerce' ); ?>
				<div class="el-btn-edit"><?php esc_html_e( 'Edit', 'woocommerce' ); ?></div>
			</div>
			<div class="el-info">
				<?php echo PT_WC_CHECKOUT_CONTROLLER::getHTMLOrderBilling( $fieldsCurrent, $dataCurrent ); ?>
			</div>
			<div class="el-field-wrapper">
				<?php
				foreach( $fieldsCurrent as $key => $field ) {
					if( !array_key_exists( $key, $dataCurrent ) ) {
						continue;
					}

					if( $key == 'billing_pt_district' ) {
						$field = PT_WC_CHECKOUT_CONTROLLER::updateDistrictOptions( $key, $field, $dataCurrent['billing_pt_province'] );
					}

					if( $key == 'billing_pt_ward' ) {
						$field = PT_WC_CHECKOUT_CONTROLLER::updateWardsptions( $key, $field, $dataCurrent['billing_pt_district'] );
					}
					woocommerce_form_field( '_' . $key, $field, $dataCurrent[ $key ] );
				}
				?>
			</div>
		</div>
		<!-- Shipping fields -->
		<?php
		$fieldsCurrent = $shipping_fields;
		$dataCurrent   = $metaDataShippings;

		?>
		<div class="order-data-item order-fields order-data-shipping">
			<div class="el-main-title"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?>
				<div class="el-btn-edit"><?php esc_html_e( 'Edit', 'woocommerce' ); ?></div>
			</div>
			<div class="el-info">
				<?php echo PT_WC_CHECKOUT_CONTROLLER::getHTMLOrderShipping( $fieldsCurrent, $dataCurrent ); ?>
			</div>
			<div class="el-field-wrapper">
				<?php
				foreach( $fieldsCurrent as $key => $field ) {
					if( !array_key_exists( $key, $dataCurrent ) ) {
						continue;
					}

					if( $key == 'shipping_pt_district' ) {
						$field = PT_WC_CHECKOUT_CONTROLLER::updateDistrictOptions( $key, $field, $dataCurrent['shipping_pt_province'] );
					}

					if( $key == 'shipping_pt_ward' ) {
						$field = PT_WC_CHECKOUT_CONTROLLER::updateWardsptions( $key, $field, $dataCurrent['shipping_pt_district'] );
					}

					woocommerce_form_field( '_' . $key, $field, $dataCurrent[ $key ] );
				}
				?>
			</div>
		</div>
		<!-- Invoices fields -->
		<?php if( !empty( $metaDataInvoices['billing_invoice_require'] ) ) :
			; ?>
			<?php
			$fieldsCurrent = $invoice_fields;
			$dataCurrent   = $metaDataInvoices;
			?>
			<div class="order-data-item order-fields order-data-invoice">
				<div class="el-main-title"><?php esc_html_e( 'Xuất hoá đơn', 'woocommerce' ); ?>
					<div class="el-btn-edit"><?php esc_html_e( 'Edit', 'woocommerce' ); ?></div>
				</div>
				<div class="el-info">
					<?php echo PT_WC_CHECKOUT_CONTROLLER::getHTMLOrderInvoice( $fieldsCurrent, $dataCurrent ); ?>
				</div>
				<div class="el-field-wrapper">
					<?php
					foreach( $fieldsCurrent as $key => $field ) {
						woocommerce_form_field( '_' . $key, $field, $dataCurrent[ $key ] );
					}
					?>
				</div>
			</div>
		<?php endif; ?>
		<?php

		echo ob_get_clean();
	}
}


// 
add_action( 'woocommerce_update_order', 'pt_wc_handle_order_update_meta_data' );

if( !function_exists( 'pt_wc_handle_order_update_meta_data' ) ) {
	function pt_wc_handle_order_update_meta_data($post_id)
	{

		global $_POST;

		if( !isset( $_POST['_pt_wc_order_update_meta_data'] ) && !wp_verify_nonce( '_pt_wc_order_update_meta_data', 'pt_wc_order_update_meta_data' ) ) {
			return;
		}

		$order = wc_get_order( $post_id );

		// Billing
		$order->update_meta_data( '_billing_pt_full_name', sanitize_text_field( $_POST['_billing_pt_full_name'] ) );

		$order->update_meta_data( '_billing_pt_phone', sanitize_text_field( $_POST['_billing_pt_phone'] ) );

		$order->update_meta_data( '_billing_pt_email', sanitize_email( $_POST['_billing_pt_email'] ) );

		$order->update_meta_data( '_billing_pt_address', sanitize_text_field( $_POST['_billing_pt_address'] ) );

		if( !empty( $_POST['_billing_pt_province'] ) && !empty( $_POST['_billing_pt_district'] ) && !empty( $_POST['_billing_pt_ward'] ) ) {

			$order->update_meta_data( '_billing_pt_province', sanitize_text_field( $_POST['_billing_pt_province'] ) );

			$order->update_meta_data( '_billing_pt_district', sanitize_text_field( $_POST['_billing_pt_district'] ) );

			$order->update_meta_data( '_billing_pt_ward', sanitize_text_field( $_POST['_billing_pt_ward'] ) );
		}

		// Shipping
		$order->update_meta_data( '_shipping_pt_address', sanitize_text_field( $_POST['_shipping_pt_address'] ) );

		if( !empty( $_POST['_shipping_pt_province'] ) && !empty( $_POST['_shipping_pt_district'] ) && !empty( $_POST['_shipping_pt_ward'] ) ) {

			$order->update_meta_data( '_shipping_pt_province', sanitize_text_field( $_POST['_shipping_pt_province'] ) );

			$order->update_meta_data( '_shipping_pt_district', sanitize_text_field( $_POST['_shipping_pt_district'] ) );

			$order->update_meta_data( '_shipping_pt_ward', sanitize_text_field( $_POST['_shipping_pt_ward'] ) );
		}

		// If shipping empty and billing not
		if( empty( $_POST['_shipping_pt_address'] ) && empty( $_POST['_shipping_pt_district'] ) && empty( $_POST['_shipping_pt_ward'] ) ) {

			$order->update_meta_data( '_shipping_pt_address', sanitize_text_field( $_POST['_billing_pt_address'] ) );

			$order->update_meta_data( '_shipping_pt_province', sanitize_text_field( $_POST['_billing_pt_province'] ) );

			$order->update_meta_data( '_shipping_pt_district', sanitize_text_field( $_POST['_billing_pt_district'] ) );

			$order->update_meta_data( '_shipping_pt_ward', sanitize_text_field( $_POST['_billing_pt_ward'] ) );
		}

		// Invoice
		$order->update_meta_data( '_billing_invoice_company_email', sanitize_text_field( $_POST['_billing_invoice_company_email'] ) );

		$order->update_meta_data( '_billing_invoice_company_tax', sanitize_text_field( $_POST['_billing_invoice_company_tax'] ) );

		$order->update_meta_data( '_billing_invoice_company_address', sanitize_text_field( $_POST['_billing_invoice_company_address'] ) );

		$order->update_meta_data( '_billing_invoice_company_name', sanitize_text_field( $_POST['_billing_invoice_company_name'] ) );


		$order->save_meta_data();

	}

}


