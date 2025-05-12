<?php
class FieldPostTypeWithOption extends FieldsPostType {


	/**
	 * Render danh sách các items
	 *
	 * @param array $items Mảng các items cần render
	 * @param array $options Mảng các items cần render
	 * @param string $id Mảng các items cần render
	 * @return string HTML của danh sách items
	 */
	public function get_render_items_options($items, $id, $name_field, $options, $option_name, $option_label, $option_input_type = 'text', )
	{
		$name        = $this->is_multiple ? $name_field . '[' . $id . '][]' : $name_field . '[]';
		$option_name = $this->is_multiple ? $option_name . '[' . $id . '][]' : $option_name . '[]';

		ob_start();
		?>
		<div id="<?php echo esc_attr( $id ); ?>" class="tw-space-y-[14px] el-items"
			data-field-name="<?php echo esc_attr( $name ); ?>"
			data-field-option="<?php echo esc_attr( $option_name ); ?>"
			data-field-option-label="<?php echo esc_attr( $option_label ); ?>"
			data-field-option-type="<?php echo esc_attr( $option_input_type ); ?>">
			<?php foreach( $items as $key => $value ) : ?>
				<?php
				$post = get_post( $value );
				?>
				<div
					class="input__content tw-border-0 !tw-border-b tw-border-gray-300 tw-border-solid tw-pb-[14px] tw-space-y-[14px]">
					<span class="el-post-title"><?php echo esc_attr( $post->post_title ); ?></span>
					<input type="hidden" name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						class="tw-hidden el-post-input">
					<div>
						<input type="<?php echo esc_attr( $option_input_type ); ?>"
							name="<?php echo esc_attr( $option_name ); ?>"
							value="<?php echo esc_attr( $options[ $key ] ); ?>"
							placeholder="<?php echo esc_attr( $option_label ); ?>" class="tw-w-full">
					</div>
					<div class="tw-flex tw-items-base tw-gap-[20px]">
						<div class="tw-cursor-pointer text-success"
							onclick="openPopupSearchPostTypeToSelectOther(event, '<?php echo esc_attr( $this->id ); ?>', '<?php echo esc_attr( $id ); ?>', 'ptSearchPostAjaxChoicedToChange')">
							<?php _e( 'Chọn' ); ?>
						</div>
						<div class=" tw-cursor-pointer text-danger" onclick="deleteInputWrap(event)">Xóa item</div>
					</div>
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
			onclick="openPopupSearchPostType(event, '<?php echo esc_attr( $this->id ); ?>', '<?php echo esc_attr( $idCurrentRenter ); ?>', 'searchSinglePostByTypeOptionOnChoiced')">
			<?php _e( 'Thêm item' ); ?>
		</button>
		<?php

		return ob_get_clean();
	}
}
