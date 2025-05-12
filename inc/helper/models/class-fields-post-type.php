<?php
class FieldsPostType {
	public $name_field;
	public $post_type;

	public $id;
	public $is_multiple;

	public function __construct($name_field, $post_type, $is_multiple = false)
	{
		$this->name_field  = $name_field;
		$this->post_type   = $post_type;
		$this->id          = generateRandomString( 10 );
		$this->is_multiple = $is_multiple;
	}

	/**
	 * Render danh sách các items
	 *
	 * @param array $items Mảng các items cần render
	 * @return string HTML của danh sách items
	 */
	public function get_render_items($items, $id, $name_field)
	{
		$name = $this->is_multiple ? $name_field . '[' . $id . '][]' : $name_field . '[]';
		ob_start();
		?>
		<div id="<?php echo esc_attr( $id ); ?>" class="tw-space-y-[14px]"
			data-field-name="<?php echo esc_attr( $name ); ?>">
			<?php foreach( $items as $key => $value ) : ?>
				<?php
				$post = get_post( $value );
				?>
				<div
					class="input__content tw-border-0 !tw-border-b tw-border-gray-300 tw-border-solid tw-pb-[14px] tw-flex tw-gap-[14px] tw-items-center">
					<span class="tw-flex-1 el-post-title"><?php echo esc_attr( $post->post_title ); ?></span>
					<div class=" tw-cursor-pointer text-success"
						onclick="openPopupSearchPostTypeToSelectOther(event, '<?php echo esc_attr( $this->id ); ?>', '<?php echo esc_attr( $id ); ?>', 'ptSearchPostAjaxChoicedToChange')">
						<?php _e( 'Chọn' ); ?>
					</div>
					<div class=" tw-cursor-pointer text-danger" onclick="deleteInputWrap(event)">Xóa item</div>
					<input type="hidden" name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						class="tw-hidden el-post-input">
				</div>
			<?php endforeach; ?>
		</div>
		<?php
		return ob_get_clean();
	}


	public function get_render_field_add($idCurrentRenter)
	{
		ob_start();
		?>
		<button type="button" class="btn btn-outline-primary"
			onclick="openPopupSearchPostType(event, '<?php echo esc_attr( $this->id ); ?>', '<?php echo esc_attr( $idCurrentRenter ); ?>')"><?php _e( 'Thêm item' ); ?>
		</button>
		<?php

		return ob_get_clean();
	}
	public function get_render_popup_search()
	{
		$query = [ 
			'post_type' => $this->post_type,
			'limit'     => 40,
			'orderby'   => 'post_title',
			'order'     => 'ASC',
		];

		ob_start();
		?>
		<div class="popup-wrap" id="<?php echo esc_attr( $this->id ); ?>">
			<div class="popup-content">
				<div class="popup-title">Lựa chọn Item</div>
				<div class="field-search-ajax tw-flex tw-gap-[12px] tw-items-start"
					data-id="<?php echo esc_attr( $this->id ); ?>"
					data-query="<?php echo esc_attr( json_encode( $query ) ); ?>"
					data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
					data-isloading="false">
					<div class="tw-relative tw-flex-1">
						<input type="text" placeholder="Tìm kiếm" class="tw-w-full tw-h-[34px]">
						<div
							class="el-result-wrap tw-mt-[20px] tw-w-full tw-z-[50] tw-bg-white tw-border tw-border-gray-300 tw-rounded-md tw-shadow-md tw-overflow-auto tw-py-[12px] tw-max-h-[300px] tw-hidden"
							style="display:none;">
							<div class="el-result" style="display:none;">
								<!-- <div onclick="ptSearchPostAjaxChoiced(event)" class="el-option" data-value="">label</div>  -->
							</div>
							<div class="el-no-result tw-px-[12px]" style="display:none;">Không có kết quả</div>
						</div>
					</div>
					<button type="button" onclick="ptSearchPostAjax(event)"
						class="btn btn-outline-primary !tw-m-0 tw-h-[34px]">Tìm kiếm</button>
				</div>
				<div class="popup-actions tw-mt-[20px]">
					<button type="button" class=" btn btn-outline-danger !tw-m-0"
						onclick="hidenPopup(event, '<?php echo esc_attr( $this->id ); ?>')"> Thoát </button>
				</div>
			</div>
			<div class="popup-bg" onclick="hidenPopup(event, '<?php echo esc_attr( $this->id ); ?>')"></div>
		</div>
		<?php

		return ob_get_clean();
	}
}


// 
function pt_search_post_ajax_handler()
{
	global $wpdb;
	$prefix = $wpdb->prefix;

	// prepare our arguments for the query
	$args = json_decode( stripcslashes( $_POST['query'] ), true );

	extract( wp_parse_args( $args, [ 
		'search_text' => '',
		'post_type'   => 'post',
		'limit'       => 40,
		'orderby'     => 'post_title',
		'order'       => 'ASC', // DESC
	] ) );

	// Fetch total count of tutor_quiz_attempts
	$search_term = '%' . $wpdb->esc_like( $search_text ) . '%';

	$sql = $wpdb->prepare(
		"SELECT * FROM `{$prefix}posts` WHERE post_title LIKE %s AND post_type = %s AND post_status = 'publish' ORDER BY {$orderby} {$order} LIMIT %d",
		$search_term,
		$post_type,
		$limit
	);

	$result = $wpdb->get_results( $sql );

	$result = json_encode( $result );


	ob_start();
	echo $result;
	echo ob_get_clean();

	die();
}

add_action( 'wp_ajax_search_post_ajax', 'pt_search_post_ajax_handler' ); // wp_ajax_{action}
add_action( 'wp_ajax_nopriv_search_post_ajax', 'pt_search_post_ajax_handler' ); // wp_ajax_nopriv_{action}

