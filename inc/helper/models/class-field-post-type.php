<?php
class FieldPostType extends FieldsPostType {

	/**
	 * Render danh sách các items
	 *
	 * @param string $itemId Mảng các items cần render
	 * @return string HTML của danh sách items
	 */
	public function get_render_items($itemId, $id, $name_field, $id_current_render = null)
	{
		$post = get_post( $itemId );

		if( !$post ) {
			return '';
		}

		ob_start();
		?>
		<div class="tw-flex tw-gap-[14px] tw-items-center field-post-by-type-wrap">
			<span class="tw-flex-1"><?php echo esc_attr( $post->post_title ); ?></span>
			<?php echo $this->get_render_field_add( '' ); ?>
			<input type="hidden" name="<?php echo esc_attr( $name_field ); ?>"
				value="<?php echo esc_attr( $itemId ); ?>"
				class="tw-hidden">
		</div>
		<?php
		return ob_get_clean();
	}


	public function get_render_field_add($idCurrentRenter)
	{
		ob_start();
		?>
		<div class="tw-cursor-pointer text-primary"
			onclick="openPopupSearchPostType(event, '<?php echo esc_attr( $this->id ); ?>', '<?php echo esc_attr( $idCurrentRenter ); ?>', 'searchSinglePostByTypeOnChoiced')">
			<?php _e( 'Chọn item' ); ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
