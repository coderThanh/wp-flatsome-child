<?php

/** Rating
 */
add_action( 'wp_enqueue_scripts', 'pt_shortcode_video_on_view_setup' );

function pt_shortcode_video_on_view_setup()
{
	wp_enqueue_script( 'pt-video-on-view', get_stylesheet_directory_uri() . '/shortcode/video-play-on-view/script.js', [], '1.0.1', true );
}


/**
 * 
 * Shortcode [pt-video-on-view]
 * Require: 
 */
add_action( 'ux_builder_setup', 'pt_ux_builder_video_on_view' );

function pt_ux_builder_video_on_view()
{
	add_ux_builder_shortcode( 'pt-video-on-view', array(
		'name'     => __( 'Pt Video on view' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'options'  => array(
			'video'            => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( 'https://domain/demo.mp4' ),
				'heading'     => __( 'Video source' ),
			),
			'img'              => array(
				'type'    => 'image',
				'heading' => 'Image',
				'default' => '',
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


add_shortcode( 'pt-video-on-view', 'shortcode_pt_video_on_view' );

function shortcode_pt_video_on_view($args, $content)
{
	extract( shortcode_atts( [ 
		'video'      => '',
		'img'        => '',
		'class'      => '',
		'visibility' => '',
	], $args ) );

	if( empty( $video ) ) {
		return;
	}

	ob_start();
	?>
	<div class="<?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?> video-on-view">
		<video loop src="<?php echo esc_url( $video ); ?>">
		</video>
		<?php if( !empty( $img ) ) :
			; ?>
			<div class="el-video-thumnb">
				<img src="<?php echo esc_url( wp_get_attachment_image_url( $img, 'full' ) ); ?>" alt="video thumnail">
				<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 32 32" xml:space="preserve"
					class="el-play">
					<path
						d="M27.268 16.999 4.732 30.001C3.78 30.55 3 30.1 3 29V3c0-1.1.78-1.55 1.732-1.001L27.267 15c.953.55.953 1.45.001 1.999"
						style="fill:#111918" />
				</svg>
			</div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
