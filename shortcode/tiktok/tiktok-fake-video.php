<?php


/**
 * 
 * Shortcode [pt-tiktok-fake-short-video]
 * Require: 
 */
add_action( 'ux_builder_setup', 'pt_ux_builder_tiktok_fake_short_video' );

function pt_ux_builder_tiktok_fake_short_video()
{
	add_ux_builder_shortcode( 'pt-tiktok-fake-short-video', array(
		'name'     => __( 'Pt Tiktok Fake Video' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
		'options'  => array(
			'label' => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here..',
			),
			'img'   => array(
				'type'    => 'image',
				'heading' => 'Image',
				'default' => '',
			),
			'url'   => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'URL',
				'placeholder' => 'Ví dụ: https://www.tiktok.com/@username/video/1234567890123456789',
			),
			'view'  => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'View',
				'placeholder' => 'Ví dụ: 327.8k',
			),
			'tag'   => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Tag',
				'placeholder' => 'Ví dụ: Hot trend',
			),
		),
	) );
}


add_shortcode( 'pt-tiktok-fake-short-video', 'shortcode_pt_tiktok_fake_short_video' );

function shortcode_pt_tiktok_fake_short_video($args, $content)
{
	extract( shortcode_atts( [
		'label' => '',
		'img'   => '',
		'url'   => '',
		'view'  => '0',
		'tag'   => '',
	], $args ) );

	$attatment_src = !empty( $img ) ? wp_get_attachment_image_url( $img, 'full', false ) : '';

	ob_start();
	?>
	<a href="<?php echo esc_url( $url );?>" target="_blank" class="tiktok-fake-video">
		<?php if( !empty( $attatment_src ) ) :
			; ?>
			<img
				src="<?php echo esc_url( $attatment_src ); ?>"
				alt="<?php echo esc_attr( $label ); ?>" class="el-thumb">
		<?php endif; ?>
		<?php if( !empty( $tag ) ) :
			; ?>
			<div class="el-tag"><?php echo esc_attr( $tag ); ?></div>
		<?php endif; ?>
		<div class="el-view">
			<svg width="30" height="30" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
				<path
					d="M18.54 9 8.88 3.46a3.42 3.42 0 0 0-5.13 3v11.12A3.42 3.42 0 0 0 7.17 21a3.43 3.43 0 0 0 1.71-.46L18.54 15a3.42 3.42 0 0 0 0-5.92Zm-1 4.19-9.66 5.62a1.44 1.44 0 0 1-1.42 0 1.42 1.42 0 0 1-.71-1.23V6.42a1.42 1.42 0 0 1 .71-1.23A1.5 1.5 0 0 1 7.17 5a1.54 1.54 0 0 1 .71.19l9.66 5.58a1.42 1.42 0 0 1 0 2.46Z" />
			</svg>
			<span><?php echo esc_attr( $view ); ?></span>
		</div>
	</a>
	<?php

	return ob_get_clean();
}
