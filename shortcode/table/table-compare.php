<?php

/**
 * add shortcode
 * syntax: [pt-table-compare]
 */

//
add_action( 'ux_builder_setup', 'pt_ux_builder_table_compare_shortcode' );

function pt_ux_builder_table_compare_shortcode()
{
	add_ux_builder_shortcode( 'pt-table-compare', array(
		'name'     => __( 'Pt Table Compare' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'allow'    => array( 'pt-table-compare-item' ),
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
			'title_index'       => array(
				'type'        => 'textfield',
				'heading'     => 'Title Index',
				'placeholder' => 'Enter title index here..',
			),
			'title_one'         => array(
				'type'        => 'textfield',
				'heading'     => 'Title One',
				'placeholder' => 'Enter title one here..',
			),
			'title_two'         => array(
				'type'        => 'textfield',
				'heading'     => 'Title Two',
				'placeholder' => 'Enter title two here..',
			),
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-table-compare', 'pt_get_table_compare_shortcode' );

function pt_get_table_compare_shortcode($atts, $content = null)
{

	extract( shortcode_atts( array(
		'title_index' => '',
		'title_one'   => '',
		'title_two'   => '',
		'class'      => '',
		'visibility' => '',

	), $atts ) );

	$GLOBALS['pt_table_compare_items'] = []; // this will reset every call
	$GLOBALS['pt_table_compare_count'] = 0;

	$content = do_shortcode( $content );// run function child

	ob_start();

	?>
	<div class="pt-tab-compare <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>">
		<!-- label -->
		<div class="el-tr el-thead">
			<div class="el-th"><?php echo esc_html( $title_index ); ?></div>
			<div class="el-th"><?php echo esc_html( $title_one ); ?></div>
			<div class="el-th"><?php echo esc_html( $title_two ); ?></div>
		</div>
		<!-- body -->
		<?php foreach( $GLOBALS['pt_table_compare_items'] as $item ) : ?>
			<div class="el-tr">
				<div class="el-td label"><?php echo esc_html( $item['label'] ); ?></div>
				<div class="el-td value <?php echo esc_attr( $item['one_has'] == 'true' ? 'has' : '' ); ?>">
					<?php echo esc_html( $item['one_ontent'] ); ?></div>
				<div class="el-td  value<?php echo esc_attr( $item['two_has'] == 'true' ? 'has' : '' ); ?>">
					<?php echo esc_html( $item['two_content'] ); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}


//
add_action( 'ux_builder_setup', 'pt_ux_builder_table_compare_item_shortcode' );

function pt_ux_builder_table_compare_item_shortcode()
{
	add_ux_builder_shortcode( 'pt-table-compare-item', array(
		'name'     => __( 'Pt Item' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'require'  => array( 'pt-table-compare' ),
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
		'options'  => array(
			'label'       => array(
				'full_width'  => true,
				'heading'     => 'Label',
				'type'        => 'textfield',
				'placeholder' => 'Enter label here..',
			),
			'one_ontent'  => array(
				'heading'    => 'One Content',
				'type'       => 'textfield',
				'full_width' => true,
			),
			'one_has'     => array(
				'type'    => 'checkbox',
				'heading' => 'One Has',
				'default' => 'false',
			),
			'two_content' => array(
				'heading'    => 'Two Content',
				'type'       => 'textfield',
				'full_width' => true,
			),
			'two_has'     => array(
				'type'    => 'checkbox',
				'heading' => 'Two Has',
				'default' => 'false',
			),
		),
	) );
}


//
add_shortcode( 'pt-table-compare-item', 'pt_get_table_compare_item_shortcode' );

function pt_get_table_compare_item_shortcode($atts, $content = null)
{

	extract( shortcode_atts( array(
		'label'       => '',
		'one_ontent'  => '',
		'one_has'     => 'false',
		'two_content' => '',
		'two_has'     => 'false',

	), $atts ) );

	$x = $GLOBALS['pt_table_compare_count']; // init in table compare wrap

	$GLOBALS['pt_table_compare_items'][ $x ] = [
		'label'       => $label,
		'one_ontent'  => $one_ontent,
		'one_has'     => $one_has,
		'two_content' => $two_content,
		'two_has'     => $two_has,
	];

	$GLOBALS['pt_table_compare_count']++;

	return '<span style="display:none"></span>';
}


