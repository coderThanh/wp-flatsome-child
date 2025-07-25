<?php

/**
 * add shortcode
 * syntax: [pt-marquee-multi-item]
 */


add_action( 'wp_enqueue_scripts', 'pt_shortcode_marquee_multi_item_setup' );

function pt_shortcode_marquee_multi_item_setup()
{
	wp_enqueue_style( 'marquee-multi-item-shortcode', get_stylesheet_directory_uri() . '/shortcode/marquee-multi-item/syles.css', [], '1.0' );
}

//
add_action( 'ux_builder_setup', 'pt_ux_builder_marquee_milti_item' );

function pt_ux_builder_marquee_milti_item()
{
	add_ux_builder_shortcode( 'pt-marquee-multi-item', array(
		'name'     => __( 'Pt Marquee Multi Item' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'options'  => [ 
			'is_pause'         => array(
				'type'    => 'checkbox',
				'heading' => 'Pause',
				'default' => 'false',
			),
			'duration'         => array(
				'type'        => 'textfield',
				'heading'     => 'seconds',
				'responsive'  => true,
				'placeholder' => '5s',
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		],
	) );
}


//
add_shortcode( 'pt-marquee-multi-item', 'pt_get_marquee_milti_item' );

function pt_get_marquee_milti_item($atts, $content = null)
{
	extract( shortcode_atts( array(
		'class'        => '',
		'visibility'   => '',
		'is_pause'     => 'false',
		'duration'     => '5s',
		'duration__md' => '',
		'duration__sm' => '',
	), $atts ) );

	$style      = '';
	$style_item = '';

	if( !empty( $duration ) ) {
		$style .= '--duration: ' . $duration . ';';
	}

	if( !empty( $duration__md ) ) {
		$style .= '--duration-md: ' . $duration__md . ';';
	}

	if( !empty( $duration__sm ) ) {
		$style .= '--duration-sm: ' . $duration__sm . ';';
	}


	if( $is_pause == 'true' ) {
		$style_item .= 'animation-play-state: paused;';
	}

	?>
	<div class="marquee-wrap <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>"
		style="<?php echo esc_attr( $style ); ?>">
		<div class="marquee-inner marquee-animation">
			<div class="item" style="<?php echo esc_attr( $style_item ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<div class="item" style="<?php echo esc_attr( $style_item ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<div class="item" style="<?php echo esc_attr( $style_item ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<div class="item" style="<?php echo esc_attr( $style_item ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<div class="item" style="<?php echo esc_attr( $style_item ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<div class="item" style="<?php echo esc_attr( $style_item ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<div class="item" style="<?php echo esc_attr( $style_item ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<div class="item" style="<?php echo esc_attr( $style_item ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
		</div>
	</div>
	<?php

}
