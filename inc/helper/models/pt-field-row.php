<?php

class PT_FIELD_ROW {
	public static function get_text(string $label, string $name, string $value = '', string $type = 'text', string $id = '', string $class = 'form-control')
	{
		$id = $id ?: $name;

		ob_start();
		?>
		<tr>
			<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></th>
			<td>
				<input type="<?php echo esc_attr( $type ); ?>" class="<?php echo esc_attr( $class ); ?>"
					name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>"
					value="<?php echo esc_attr( $value ); ?>">
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

	public static function get_textarea(string $label, string $name, string $value = '', int $rows = 4, string $id = '', string $class = 'form-control')
	{
		$id = $id ?: $name;

		ob_start();
		?>
		<tr>
			<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></th>
			<td>
				<textarea class="<?php echo esc_attr( $class ); ?>" name="<?php echo esc_attr( $name ); ?>"
					id="<?php echo esc_attr( $id ); ?>" rows="<?php echo esc_attr( $rows ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

	public static function get_color(string $label, string $name, string $value = '', string $id = '')
	{
		$id = $id ?: $name;

		ob_start();
		?>
		<tr>
			<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></th>
			<td>
				<?php echo PT_INPUT::get_field_color( $name, $value, $id ); ?>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

	public static function get_editor(string $label, string $name, string $value = '', array $settings = [])
	{
		ob_start();
		?>
		<tr>
			<th scope="row"><label><?php echo esc_html( $label ); ?></label></th>
			<td>
				<?php echo PT_INPUT::get_field_editor( $name, $value, $settings ); ?>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}
}

