<?php

if( !class_exists( 'PT_WC_CHECKOUT_CONTROLLER' ) ) {

	class PT_WC_CHECKOUT_CONTROLLER {

		static function getHTMLAllAdress()
		{
			global $VN_DISTRICT, $VN_WARDS, $VN_PROVINES;

			$wards     = array_values( $VN_WARDS );
			$districts = array_values( $VN_DISTRICT );

			ob_start();
			?>
			<!-- JSON Address -->
			<div id="data-provinces"
				data-value="<?php echo htmlspecialchars( json_encode( $VN_PROVINES ) ); ?>"></div>
			<div id="data-districts"
				data-value="<?php echo htmlspecialchars( json_encode( $districts ) ); ?>"></div>
			<div id="data-wards"
				data-value="<?php echo htmlspecialchars( json_encode( $wards ) ); ?>"></div>
			<?php
			return ob_get_clean();
		}

		static function updateDistrictOptions(string $key, array $field, string $keyProvince)
		{

			global $VN_DISTRICT;

			if( $field['type'] != 'select' || $keyProvince == '' ) {
				return $field;
			}

			$listDistricts = array_filter( $VN_DISTRICT, function ($item) use ($keyProvince) {
				return $item['matp'] == $keyProvince;
			} );

			foreach( $listDistricts as $item ) {
				$field['options'][ $item['maqh'] ] = $item['name'];
			}
			return $field;
		}

		//
		static function updateWardsptions(string $key, array $field, string $keyDistrict)
		{

			global $VN_WARDS;

			if( $field['type'] != 'select' || $keyDistrict == '' ) {
				return $field;
			}

			$listWards = array_filter( $VN_WARDS, function ($item) use ($keyDistrict) {
				return $item['maqh'] == $keyDistrict;
			} );

			foreach( $listWards as $item ) {
				$field['options'][ $item['xaid'] ] = $item['name'];
			}

			return $field;
		}

		/**
		 * Retrieves the province with the given ID from the global $VN_PROVINES array.
		 *
		 * @param string $id The ID of the province to retrieve.
		 * @return mixed|null The province with the given ID, or null if it is not found.
		 */
		//
		static function getProvince($id)
		{

			global $VN_PROVINES;

			if( array_key_exists( $id, $VN_PROVINES ) ) {
				return $VN_PROVINES[ $id ];
			}

			return null;
		}

		/**
		 * Retrieves the district with the given ID from the global $VN_DISTRICT array.
		 *
		 * @param string $id The ID of the district to retrieve.
		 * @return mixed|null The district with the given ID, or null if it is not found.
		 */
		//
		static function getDistrict($id)
		{

			global $VN_DISTRICT;

			$items = array_filter( $VN_DISTRICT, function ($item) use ($id) {
				return $item['maqh'] == $id;
			} );

			$item = array_shift( $items );

			if( isset( $item ) ) {
				return $item;
			}
			return null;
		}

		/**
		 * Retrieves the ward with the given ID from the global $VN_WARDS array.
		 *
		 * @param string $id The ID of the ward to retrieve.
		 * @return mixed|null The ward with the given ID, or null if it is not found.
		 */
		static function getWard($id)
		{

			global $VN_WARDS;

			$items = array_filter( $VN_WARDS, function ($item) use ($id) {
				return $item['xaid'] == $id;
			} );

			$item = array_shift( $items );

			if( isset( $item ) ) {
				return $item;
			}
			return null;
		}

		/**
		 * Generates the HTML for the order billing information.
		 *
		 * @param array $fields An array of fields to display in the order billing information.
		 * @param mixed $values An array of values for each field.
		 * @return string The generated HTML for the order billing information.
		 */
		//
		static function getHTMLOrderBilling(array $fields, $values)
		{
			if( empty( $fields ) || empty( $values ) ) {
				return "";
			}

			ob_start();
			?>
			<?php
			foreach( $fields as $key => $field ) :
				; ?>
				<?php if( !array_key_exists( $key, $values ) ) :
					continue; ?>
				<?php endif; ?>
				<?php $value = $values[ $key ]; ?>
				<div class="el-info-item">
					<div class="el-info-label">
						<?php echo esc_html( $field['label'] ); ?>
					</div>
					<div class="el-info-value">
						<?php
						if( $key == 'billing_pt_province' ) {

							$province = self::getProvince( $value );

							if( $province ) {
								$value = $province;
							}

						} else if( $key == 'billing_pt_district' ) {
							$district = self::getDistrict( $value );

							if( $district ) {
								$value = $district['name'];
							}
						} else if( $key == 'billing_pt_ward' ) {
							$ward = self::getWard( $value );

							if( $ward ) {
								$value = $ward['name'];
							}
						}
						?>
						<?php echo esc_html( $value ); ?>
					</div>
				</div>
			<?php endforeach; ?>
			<?php
			return ob_get_clean();
		}

		/**
		 * Retrieves the HTML content for displaying order shipping information.
		 *
		 * @param array $fields The array of fields for the shipping information.
		 * @param mixed $values The values corresponding to the fields.
		 * @return string The HTML content for order shipping information.
		 */
		// 
		static function getHTMLOrderShipping(array $fields, $values)
		{
			if( empty( $fields ) || empty( $values ) ) {
				return '';
			}

			ob_start();
			?>
			<?php
			foreach( $fields as $key => $field ) :
				; ?>
				<?php $value = $values[ $key ]; ?>
				<div class="el-info-item">
					<div class="el-info-label">
						<?php echo esc_html( $field['label'] ); ?>
					</div>
					<div class="el-info-value">
						<?php
						if( $key == 'shipping_pt_province' ) {
							$province = self::getProvince( $value );

							if( $province ) {
								$value = $province;
							}

						} else if( $key == 'shipping_pt_district' ) {
							$district = self::getDistrict( $value );

							if( $district ) {
								$value = $district['name'];
							}
						} else if( $key == 'shipping_pt_ward' ) {
							$ward = self::getWard( $value );

							if( $ward ) {
								$value = $ward['name'];
							}
						}
						?>
						<?php echo esc_html( $value ); ?>
					</div>
				</div>
			<?php endforeach; ?>
			<?php
			return ob_get_clean();
		}

		/**
		 * Generate HTML for an order invoice based on provided fields and values.
		 *
		 * @param array $fields The fields to display in the invoice.
		 * @param array $values The corresponding values for the fields.
		 * @return string The HTML content of the generated invoice.
		 */
		static function getHTMLOrderInvoice(array $fields, $values)
		{
			if( empty( $fields ) || empty( $values ) ) {
				return '';
			}

			ob_start();
			?>
			<?php
			foreach( $fields as $key => $field ) :
				; ?>
				<?php if( !array_key_exists( $key, $values ) ) {
					continue;
				} ?>
				<?php $value = $values[ $key ]; ?>
				<div class="el-info-item">
					<div class="el-info-label">
						<?php echo esc_html( $field['label'] ); ?>
					</div>
					<div class="el-info-value">
						<?php echo esc_html( $value ); ?>
					</div>
				</div>
			<?php endforeach; ?>
			<?php
			return ob_get_clean();
		}

		/**
		 * Retrieves the metadata of an order.
		 *
		 * @param WC_Order $order The order object.
		 * @return array An array containing the metadata of the order, with the following keys:
		 *               - 'billing': An array of billing fields and their values.
		 *               - 'shipping': An array of shipping fields and their values.
		 *               - 'invoice': An array of invoice fields and their values.
		 */
		static function getOrderMetaData($order)
		{
			global $WC_BILLING_FIELDS, $WC_INVOICE_FIELDS, $WC_SHIPPING_FIELDS;

			// data current
			$metaDatas = $order->get_meta_data();

			$metaDatas = array_map( function ($item) {
				return $item->get_data();
			}, $metaDatas );

			$metaDataBillings  = [];
			$metaDataInvoices  = [];
			$metaDataShippings = [];

			foreach( $metaDatas as $data ) {
				$keyTrimed = trim( $data['key'], '_' );

				if(
					array_search( $keyTrimed, $WC_BILLING_FIELDS ) !== false
				) {
					$metaDataBillings[ $keyTrimed ] = $data['value'];

				} else if( array_search( $keyTrimed, array_merge( $WC_INVOICE_FIELDS, [ 'billing_invoice_require' ] ) ) !== false ) {
					$metaDataInvoices[ $keyTrimed ] = $data['value'];

				} else if( array_search( $keyTrimed, $WC_SHIPPING_FIELDS ) !== false ) {
					$metaDataShippings[ $keyTrimed ] = $data['value'];
				}
			}

			return [ 
				'billing'  => $metaDataBillings,
				'shipping' => $metaDataShippings,
				'invoice'  => $metaDataInvoices,
			];
		}

		/**
		 * Retrieves the checkout fields for the WooCommerce checkout.
		 *
		 * @return array An associative array containing the billing, shipping, and invoice fields.
		 */
		static function getCheckoutFields()
		{
			global $WC_BILLING_FIELDS, $WC_SHIPPING_FIELDS, $WC_INVOICE_FIELDS;

			// form type
			$WC_Checkout = new WC_Checkout();

			$billing_total_fields = $WC_Checkout->get_checkout_fields( 'billing' );
			$shipping_fields      = $WC_Checkout->get_checkout_fields( 'shipping' );

			$billing_fields = array_filter( $billing_total_fields, function ($key) use ($WC_BILLING_FIELDS) {
				return in_array( $key, $WC_BILLING_FIELDS );
			}, ARRAY_FILTER_USE_KEY );

			$invoice_fields = array_filter( $billing_total_fields, function ($key) use ($WC_INVOICE_FIELDS) {
				return in_array( $key, $WC_INVOICE_FIELDS );
			}, ARRAY_FILTER_USE_KEY );

			return [ 
				'billing'  => $billing_fields,
				'shipping' => $shipping_fields,
				'invoice'  => $invoice_fields,
			];
		}
	}


}
