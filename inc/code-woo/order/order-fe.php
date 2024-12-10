<?php

add_action( 'woocommerce_checkout_billing', 'pt_wc_after_checkout_billing', 200 );

if( !function_exists( 'pt_wc_after_checkout_billing' ) ) {
	/**
	 * A function to handle actions after the checkout billing section.
	 *
	 */
	function pt_wc_after_checkout_billing()
	{
		$WC_Checkout = new WC_Checkout();

		$checkoutFields = PT_WC_CHECKOUT_CONTROLLER::getCheckoutFields();
		$invoice        = $checkoutFields['invoice'];

		ob_start();

		?>

		<?php echo PT_WC_CHECKOUT_CONTROLLER::getHTMLAllAdress(); ?>

		<!-- Invoice -->
		<div class="woocommerce-invoice-fields">
			<div id="require-invoice">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input id="require-invoice-checkbox"
						class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
						type="checkbox"
						name="billing_invoice_require" /> <span><?php esc_html_e( 'Xuất hoá đơn công ty', ); ?></span>
				</label>

			</div>

			<div class="invoice_address">
				<?php do_action( 'woocommerce_before_checkout_invoice_form' ); ?>

				<div class="el-field-wrapper">
					<?php

					foreach( $invoice as $key => $field ) {
						woocommerce_form_field( $key, $field, $WC_Checkout->get_value( $key ) );
					}
					?>
				</div>

				<?php do_action( 'woocommerce_after_checkout_invoice_form' ); ?>

			</div>

		</div>
		<?php

		echo ob_get_clean();
	}
}


// 
add_action( 'woocommerce_order_details_after_customer_address', 'pt_wc_after_customer_address', 100, 2 );

if( !function_exists( 'pt_wc_after_customer_address' ) ) {
	function pt_wc_after_customer_address(string $type, $order)
	{


		// form type
		$checkoutFields = PT_WC_CHECKOUT_CONTROLLER::getCheckoutFields();

		$shipping_fields = $checkoutFields['shipping'];
		$billing_fields  = $checkoutFields['billing'];
		$invoice_fields  = $checkoutFields['invoice'];

		// data current
		$metaDatas = PT_WC_CHECKOUT_CONTROLLER::getOrderMetaData( $order );

		$metaDataBillings  = $metaDatas['billing'];
		$metaDataInvoices  = $metaDatas['invoice'];
		$metaDataShippings = $metaDatas['shipping'];


		ob_start();
		?>
		<?php if( $type == 'billing' ) :
			; ?>
			<div class="el-info">
				<?php echo PT_WC_CHECKOUT_CONTROLLER::getHTMLOrderBilling( $billing_fields, $metaDataBillings ); ?>
			</div>
		<?php endif; ?>

		<?php
		echo ob_get_clean();
		// 
		ob_start();
		?>
		<?php if( $type == 'shipping' ) :
			; ?>
			<div class="el-info">
				<?php echo PT_WC_CHECKOUT_CONTROLLER::getHTMLOrderShipping( $shipping_fields, $metaDataShippings ); ?>
			</div>
		<?php endif; ?>
		<?php
		echo ob_get_clean();

		// 
		ob_start();
		?>
		<?php if( !empty( $metaDataInvoices['billing_invoice_require'] ) ) :
			; ?>
			<div class="woocommerce-column woocommerce-column--2 woocommerce-column--invoice-address col-2">
				<h2 class="woocommerce-column__title"><?php esc_html_e( 'Xuất hoá đơn', 'woocommerce' ); ?></h2>
				<div class="el-info">
					<?php echo PT_WC_CHECKOUT_CONTROLLER::getHTMLOrderInvoice( $invoice_fields, $metaDataInvoices ); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php
		echo ob_get_clean();

	}
}
