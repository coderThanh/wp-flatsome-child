<?php

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_grid_setup', 1500 );

function pt_shortcode_grid_setup()
{
	wp_enqueue_style( 'pt-grid-shortcode', get_stylesheet_directory_uri() . '/shortcode/grid/style.css', [], '1.0' );
}

//
add_action( 'ux_builder_setup', 'pt_ux_builder_grid' );

function pt_ux_builder_grid()
{
	add_ux_builder_shortcode( 'pt-grid', array(
		'name'     => __( 'Pt grid' ),
		'category' => __( 'Content' ),
		'type'     => 'container',
		'priority' => 1,
		'info'     => '{{ label }}',
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'options'  => [ 
			'label'            => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here..',
			),
			'col'              => array(
				'type'        => 'textfield',
				'heading'     => 'Columns',
				'default'     => 1,
				'placeholder' => 1,
				'responsive'  => true,
			),
			'gap'              => array(
				'type'       => 'textfield',
				'heading'    => 'Gap',
				'full_width' => true,
				'responsive' => true,
			),
			'align'            => array(
				'type'       => 'select',
				'heading'    => 'Align',
				'default'    => 'stretch',
				'responsive' => true,
				'options'    => array(
					'flex-start' => 'flex-start',
					'flex-end'   => 'flex-end',
					'center'     => 'center',
					'baseline'   => 'baseline',
					'stretch'    => 'stretch',
				),
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		],
	) );
}


//
add_shortcode( 'pt-grid', 'pt_shortcode_grid' );
add_shortcode( 'pt-grid_inner', 'pt_shortcode_grid' );
add_shortcode( 'pt-grid_inner_inner', 'pt_shortcode_grid' );
add_shortcode( 'pt-grid_inner_1', 'pt_shortcode_grid' );

function pt_shortcode_grid($atts, $content = null)
{
	extract( shortcode_atts( array(
		'col'        => 1,
		'col__md'    => '',
		'col__sm'    => '',
		'gap'        => '',
		'gap__md'    => '',
		'gap__sm'    => '',
		'align'      => 'stretch',
		'align__md'  => '',
		'align__sm'  => '',
		'class'      => '',
		'visibility' => '',
	), $atts ) );

	$style = '';

	$style_col   = get_style_responsive( 'col', $col, $col__md, $col__sm );
	$style_gap   = get_style_responsive( 'gap', $gap, $gap__md, $gap__sm );
	$style_align = get_style_responsive( 'align', $align, $align__md, $align__sm );
	$style .= $style_col;
	$style .= $style_gap;
	$style .= $style_align;

	ob_start();

	?>
	<div class="pt-grid <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>"
		style="<?php echo esc_attr( $style ); ?>">
		<?php echo do_shortcode( $content ); ?>
	</div>
	<?php

	return ob_get_clean();
}
