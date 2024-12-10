<?php

/**
 * add shortcode
 * syntax: [pt-process]
 */

//
add_action( 'ux_builder_setup', 'pt_ux_builder_process_shortocde' );

function pt_ux_builder_process_shortocde()
{
	add_ux_builder_shortcode( 'pt-process', array(
		'name'     => __( 'Pt process' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ count }}',
		'options'  => array(
			'count'            => array(
				'type'       => 'slider',
				'heading'    => 'Value',
				'default'    => '90',
				'responsive' => false,
				'max'        => '100',
				'min'        => '0',
				'unit'       => '%',
				'step'       => '1',
			),
			'is_hidden_value'  => array(
				'type'    => 'checkbox',
				'heading' => 'Hidden Value label',
				'default' => 'true',
			),
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-process', 'pt_get_process_shortocde' );

function pt_get_process_shortocde($atts, $content = null)
{
	extract( shortcode_atts( array(
		'is_hidden_value' => 'true',
		'class'           => '',
		'visibility'      => '',
		'count'           => '90',
	), $atts ) );

	ob_start();

	?>
	<div class="process-line <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>">
		<div class="el-inner">
			<div class="el-value" style="width: <?php echo esc_attr( $count ); ?>%;">
				<?php if( $is_hidden_value != 'true' ) :
					; ?>
					<span class="el-label value"><?php echo esc_attr( $count ); ?>%</span>
				<?php endif; ?>
			</div>
			<div class="el-label start">0%</div>
			<div class="el-label end">100%</div>
		</div>
	</div>
	<?php

	return ob_get_clean();
}

// style here
// .process-line {
//     background-color: rgb(var(--bg-opposite), 7%);
//     position: relative;
//     border-radius: 10px;
//     margin-bottom: 22px;
// }

// .process-line .el-inner {
//     position: relative;
//     z-index: 20;
// }

// .process-line  .el-label {
//     font-size: var(--size-small);
//     color: rgb(var(--color-text-title), 60%);
//     position: absolute;
//     bottom: -30px;
//     left: 0;	
// }

// .process-line  .el-label.end{
//     left: unset;
// 	right: 0;
// }

// .process-line  .el-label.value {
//     left: 100%;
// }

// .process-line  .el-value {
//     position: relative;
//     border-radius: 10px;
//     height: 14px;
//     background-color: rgb(var(--color-primary));
// }

