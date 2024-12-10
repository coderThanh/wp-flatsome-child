<?php

/**
 * add shortcode
 * syntax: [pt-decor-color]
 */


//
add_action( 'ux_builder_setup', 'pt_ux_builder_decor_ball_shortocde' );

function pt_ux_builder_decor_ball_shortocde()
{
	add_ux_builder_shortcode( 'pt-decor-color', array(
		'name'     => __( 'Pt Decor Color' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
		'options'  => array(
			'label'            => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here..',
			),
			'color_start'      => array(
				'type'     => 'colorpicker',
				'heading'  => __( 'Color Start' ),
				'format'   => 'rgb',
				'position' => 'bottom right',
			),
			'color_end'        => array(
				'type'     => 'colorpicker',
				'heading'  => __( 'Color End' ),
				'format'   => 'rgb',
				'position' => 'bottom right',
			),
			'width'            => array(
				'type'       => 'slider',
				'heading'    => 'Width',
				'default'    => '100',
				'responsive' => true,
				'max'        => '100',
				'min'        => '0',
				'unit'       => '%',
				'step'       => '1',
			),
			'position_options' => array(
				'type'    => 'group',
				'heading' => __( 'Position' ),
				'options' => [ 
					'is_absolute' => array(
						'type'    => 'checkbox',
						'heading' => 'Is Absolute',
						'default' => 'false',
					),
					'left'        => array(
						'type'        => 'scrubfield',
						'heading'     => 'left',
						'responsive'  => true,
						'placeholder' => '30px',
					),
					'right'       => array(
						'type'       => 'scrubfield',
						'heading'    => 'right',
						'responsive' => true,
						'config'     => [ 
							'placeholder' => '30px',
						],
					),
					'top'         => array(
						'type'        => 'scrubfield',
						'heading'     => 'top',
						'responsive'  => true,
						'placeholder' => '30px',
					),
					'bottom'      => array(
						'type'        => 'scrubfield',
						'heading'     => 'bottom',
						'responsive'  => true,
						'placeholder' => '30px',
					),
					'index'       => array(
						'type'        => 'textfield',
						'heading'     => 'Z index',
						'placeholder' => '-10',
					),
				],
			),
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-decor-color', 'pt_get_decor_ball_shortocde' );

function pt_get_decor_ball_shortocde($atts, $content = null)
{

	extract( shortcode_atts( array(
		'class'       => '',
		'visibility'  => '',
		'width'       => '100',
		'width__md'   => '100',
		'width__sm'   => '100',
		'color_start' => '',
		'color_end'   => '',
		'is_absolute' => 'false',
		'left'        => '',
		'left__md'    => '',
		'left__sm'    => '',
		'right'       => '',
		'right__md'   => '',
		'right__sm'   => '',
		'top'         => '',
		'top__md'     => '',
		'top__sm'     => '',
		'bottom'      => '',
		'bottom__md'  => '',
		'bottom__sm'  => '',
		'index'       => '',
	), $atts ) );

	$style = '';

	if( !empty( $left ) ) {
		$style .= '--left: ' . $left . ';';
	}

	if( !empty( $left__md ) ) {
		$style .= '--left-md: ' . $left__md . ';';
	}

	if( !empty( $left__sm ) ) {
		$style .= '--left-sm: ' . $left__sm . ';';
	}

	if( !empty( $right ) ) {
		$style .= '--right: ' . $right . ';';
	}

	if( !empty( $right__md ) ) {
		$style .= '--right-md: ' . $right__md . ';';
	}

	if( !empty( $right__sm ) ) {
		$style .= '--right-sm: ' . $right__sm . ';';
	}

	if( !empty( $bottom ) ) {
		$style .= '--bottom: ' . $bottom . ';';
	}

	if( !empty( $bottom__md ) ) {
		$style .= '--bottom-md: ' . $bottom__md . ';';
	}

	if( !empty( $bottom__sm ) ) {
		$style .= '--bottom-sm: ' . $bottom__sm . ';';
	}

	if( !empty( $top ) ) {
		$style .= '--top: ' . $top . ';';
	}

	if( !empty( $top__md ) ) {
		$style .= '--top-md: ' . $top__md . ';';
	}

	if( !empty( $top__sm ) ) {
		$style .= '--top-sm: ' . $top__sm . ';';
	}

	if( !empty( $width ) ) {
		$style .= '--width: ' . $width . '%;';
	}

	if( !empty( $width__md ) ) {
		$style .= '--width-md: ' . $width__md . '%;';
	}

	if( !empty( $width__sm ) ) {
		$style .= '--width-sm: ' . $width__sm . '%;';
	}

	if( !empty( $index ) ) {
		$style .= '--z-index: ' . $index . ';';
	}

	if( $is_absolute == 'true' ) {
		$style .= 'position: absolute;';
	}


	$style .= 'border-radius: 50%;';
	$style .= 'background: radial-gradient(' . $color_start . ', ' . $color_end . ' 70%);';

	ob_start();

	?>
	<div class="wrap decor-ball <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>"
		style="<?php echo esc_attr( $style ); ?>">
		<div style="padding-top: 100%;"></div>
	</div>
	<?php

	return ob_get_clean();
}
