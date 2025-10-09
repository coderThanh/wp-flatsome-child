<?php

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_video_setup', 1500 );

function pt_shortcode_video_setup()
{
	wp_enqueue_style( 'pt-video-shortcode', get_stylesheet_directory_uri() . '/shortcode/video/style.css', [], time() );
	wp_enqueue_script( 'pt-video-shortcode', get_stylesheet_directory_uri() . '/shortcode/video/script.js', [ 'jquery' ], time(), true );
}

//
add_action( 'ux_builder_setup', 'pt_ux_builder_video' );

function pt_ux_builder_video()
{
	add_ux_builder_shortcode( 'pt-video', array(
		'name'     => __( 'Pt video' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'info'     => '{{ label }}',
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'options'  => [
			'label'                         => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here..',
			),
			'src'                           => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Src',
				'placeholder' => 'Enter video src here..',
			),
			'thumbnail'                     => array(
				'type'    => 'image',
				'heading' => 'Thumbnail',
			),
			'height'                        => array(
				'type'       => 'textfield',
				'heading'    => 'Height',
				'default'    => '56.2%',
				'full_width' => true,
				'responsive' => true,
			),
			'is_autoplay'                   => array(
				'type'    => 'checkbox',
				'heading' => 'Is autoplay',
				'default' => 'true',
			),
			'is_hover_autoplay'             => array(
				'type'    => 'checkbox',
				'heading' => 'Is hover autoplay',
				'default' => '',
			),
			'is_muted'                      => array(
				'type'    => 'checkbox',
				'heading' => 'Is muted',
				'default' => 'true',
			),
			'is_loop'                       => array(
				'type'    => 'checkbox',
				'heading' => 'Is loop',
				'default' => 'true',
			),
			'is_playinside'                 => array(
				'type'    => 'checkbox',
				'heading' => 'Is play inside',
				'default' => 'true',
			),
			'is_disable_picture_in_picture' => array(
				'type'    => 'checkbox',
				'heading' => 'Is disable picture in picture',
				'default' => 'true',
			),
			'is_hidden_controls'            => array(
				'type'    => 'checkbox',
				'heading' => 'Hidden controls',
				'default' => 'true',
			),
			'has_button_play'               => array(
				'type'    => 'checkbox',
				'heading' => 'Has button play',
				'default' => 'true',
			),
			'has_button_mute'               => array(
				'type'    => 'checkbox',
				'heading' => 'Has button mute',
				'default' => 'true',
			),
			'advanced_options'              => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		],
	) );
}


//
add_shortcode( 'pt-video', 'pt_shortcode_height' );

function pt_shortcode_height($atts, $content = null)
{
	extract( shortcode_atts( array(
		'height'                        => '56.2%',
		'height__md'                    => '',
		'height__sm'                    => '',
		'is_autoplay'                   => 'true',
		'is_hover_autoplay'             => '',
		'is_muted'                      => 'true',
		'is_loop'                       => 'true',
		'is_playinside'                 => 'true',
		'is_disable_picture_in_picture' => 'true',
		'is_hidden_controls'            => 'true',
		'has_button_play'               => 'true',
		'has_button_mute'               => 'true',
		'src'                           => '',
		'thumbnail'                     => '',
		'class'                         => '',
		'visibility'                    => '',
	), $atts ) );

	$id           = generateRandomString();
	$style        = '';
	$style_height = get_style_responsive( 'height', $height, $height__md, $height__sm );
	$style .= $style_height;

	$classOut = '';
	$classOut .= esc_attr( $class );
	$classOut .= ' ' . esc_attr( $visibility );
	if( $is_autoplay === 'true' ) {
		$classOut .= ' is-paused';
	}

	if( $is_muted === 'true' ) {
		$classOut .= ' is-muted';
	} else {
		$classOut .= ' is-unmuted';
	}



	$attatment_src = !empty( $thumbnail ) ? wp_get_attachment_image_url( $thumbnail, 'full', false ) : '';

	ob_start();
	?>
	<div class="pt-video <?php echo esc_attr( $classOut ); ?>"
		style="<?php echo esc_attr( $style ); ?>">
		<div class="el-inner">
			<?php if( !empty( $attatment_src ) ) :
				; ?>
				<img
					src="<?php echo esc_url( $attatment_src ); ?>"
					alt="<?php echo esc_attr( $label ); ?>" class="el-thumb">
			<?php endif; ?>
			<video
				id="<?php echo esc_attr( $id ); ?>"
				src="<?php echo esc_url( $src ); ?>"
				poster="<?php echo esc_url( $attatment_src ); ?>"
				class="el-video"
				<?php echo esc_attr( $is_hover_autoplay ) === 'true' ? 'data-hover-autoplay="true"' : ''; ?>
				<?php echo esc_attr( $is_playinside ) === 'true' ? 'playsinline' : ''; ?>
				<?php echo esc_attr( $is_disable_picture_in_picture ) === 'true' ? 'disablePictureInPicture' : ''; ?>
				<?php echo esc_attr( $is_autoplay ) === 'true' ? 'autoplay' : ''; ?>
				<?php echo esc_attr( $is_muted ) === 'true' ? 'muted' : ''; ?>
				<?php echo esc_attr( $is_loop ) === 'true' ? 'loop' : ''; ?>
				<?php echo esc_attr( $is_hidden_controls ) === 'true' ? '' : 'controls'; ?>></video>
			<?php if( $has_button_play === 'true' ) : ?>
				<button class="el-controll-btn  el-button-play"
					onclick="togglePlayPause('<?php echo esc_attr( $id ); ?>', true)">
					<svg width="24" height="24" viewBox="0 0 36 36"
						xmlns="http://www.w3.org/2000/svg"
						fill="currentColor">
						<path class="clr-i-solid clr-i-solid-path-1"
							d="M32.16 16.08 8.94 4.47A2.07 2.07 0 0 0 6 6.32v23.21a2.06 2.06 0 0 0 3 1.85l23.16-11.61a2.07 2.07 0 0 0 0-3.7Z" />
						<path fill="none" d="M0 0h36v36H0z" />
					</svg>
				</button>
			<?php endif; ?>
			<?php if( $is_hidden_controls === 'true' && $has_button_play === 'true' ) :
				; ?>
				<div class="el-controls">
					<!-- Pause button -->
					<button class="el-controll-btn el-button-pause"
						onclick="togglePlayPause('<?php echo esc_attr( $id ); ?>', false)">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
							viewBox="0 0 101.08 116.43"
							xml:space="preserve" fill="currentColor">
							<g data-name="Layer 2">
								<path
									d="M23.33 0h-7.78A15.53 15.53 0 0 0 0 15.52v85.38a15.54 15.54 0 0 0 15.55 15.53h7.78a15.54 15.54 0 0 0 15.55-15.53V15.52A15.54 15.54 0 0 0 23.33 0m62.2 0h-7.78A15.54 15.54 0 0 0 62.2 15.52v85.38a15.54 15.54 0 0 0 15.55 15.53h7.78a15.54 15.54 0 0 0 15.55-15.53V15.52A15.53 15.53 0 0 0 85.53 0"
									data-name="Layer 1" data-original="#000000" />
							</g>
						</svg>
					</button>
					<?php if( $has_button_mute == 'true' ) :
						; ?>
						<!-- Volume button -->
						<button class="el-controll-btn el-button-volume"
							onclick="toggleMute('<?php echo esc_attr( $id ); ?>', true)">
							<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 20 20"
								xml:space="preserve" fill="currentColor">
								<path fill-rule="evenodd"
									d="M9.383 3.076A1 1 0 0 1 10 4v12a1 1 0 0 1-1.707.707L4.586 13H2a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h2.586l3.707-3.707a1 1 0 0 1 1.09-.217m5.274-.147a1 1 0 0 1 1.414 0A9.97 9.97 0 0 1 19 10a9.97 9.97 0 0 1-2.929 7.071 1 1 0 0 1-1.414-1.414A7.97 7.97 0 0 0 17 10a7.97 7.97 0 0 0-2.343-5.657 1 1 0 0 1 0-1.414m-2.829 2.828a1 1 0 0 1 1.415 0A5.98 5.98 0 0 1 15 10a5.98 5.98 0 0 1-1.757 4.243 1 1 0 1 1-1.415-1.415A4 4 0 0 0 13 10a3.98 3.98 0 0 0-1.172-2.828 1 1 0 0 1 0-1.415"
									clip-rule="evenodd" data-original="#000000" />
							</svg>
						</button>
						<!-- Muted button -->
						<button class="el-controll-btn el-button-mute"
							onclick="toggleMute('<?php echo esc_attr( $id ); ?>', false)">
							<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 448.075 448.075"
								xml:space="preserve" fill="currentColor">
								<path
									d="M352.021 16.075c0-6.08-3.52-11.84-8.96-14.4-5.76-2.88-12.16-1.92-16.96 1.92l-141.76 112.96 167.68 167.68zm91.328 404.672-416-416c-6.24-6.24-16.384-6.24-22.624 0s-6.24 16.384 0 22.624l100.672 100.704h-9.376c-9.92 0-18.56 4.48-24.32 11.52-4.8 5.44-7.68 12.8-7.68 20.48v128c0 17.6 14.4 32 32 32h74.24l155.84 124.48c2.88 2.24 6.4 3.52 9.92 3.52 2.24 0 4.8-.64 7.04-1.6 5.44-2.56 8.96-8.32 8.96-14.4v-57.376l68.672 68.672c3.136 3.136 7.232 4.704 11.328 4.704s8.192-1.568 11.328-4.672c6.24-6.272 6.24-16.384 0-22.656"
									data-original="#000000" />
							</svg>
						</button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php

	return ob_get_clean();
}
