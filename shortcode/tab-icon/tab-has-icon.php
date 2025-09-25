<?php

/**
 * add shortcode
 * syntax: [pt-tab-has-icon]
 * required: /js/tab.js
 */

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_tab_has_icon_setup', 1500 );

function pt_shortcode_tab_has_icon_setup()
{
	wp_enqueue_style( 'pt-tab-has-icon-shortcode', get_stylesheet_directory_uri() . '/shortcode/tab-icon/style.css', [], '1.0');
}

//
add_action( 'ux_builder_setup', 'pt_ux_builder_tab_has_icon_shortocde' );

function pt_ux_builder_tab_has_icon_shortocde()
{
	add_ux_builder_shortcode( 'pt-tab-has-icon', array(
		'name'     => __( 'Pt Tab has icon' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'allow'    => array( 'pt-tab-has-icon-item' ),
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
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-tab-has-icon', 'pt_get_tab_has_icon_shortocde' );

function pt_get_tab_has_icon_shortocde($atts, $content = null)
{

	extract( shortcode_atts( array(
		'class'      => '',
		'visibility' => '',

	), $atts ) );

	$GLOBALS['pt_tabs']      = []; // this will reset every call
	$GLOBALS['pt_tab_count'] = 0;

	$content = do_shortcode( $content );// run funtion child


	?>
	<div class="tab-area <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>">
		<?php if( is_array( $GLOBALS['pt_tabs'] ) ) :
			; ?>
			<div class="tab-area-titles can-scroll-vertical">
				<div class="tab-area-titles-inner">
					<?php foreach( $GLOBALS['pt_tabs'] as $key => $item ) :
						; ?>
						<div class="tab-area-title-item">
							<?php if( !empty( $item['img'] ) ) :
								; ?>
								<?php echo flatsome_get_image( $item['img'], $size = 'full', $alt = $item['title'], $item['inline_svg'] ); ?>
							<?php endif; ?>
							<span class="tab-area-title">
								<?php echo esc_attr( $item['title'] ); ?>
							</span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="tab-area-contents">
				<?php foreach( $GLOBALS['pt_tabs'] as $key => $item ) :
					; ?>
					<div class="tab-area-content-item">
						<?php echo do_shortcode( $item['content'] ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<!-- reuire for UX builder -->
		<?php echo $content; ?>
	</div>
	<?php
}


//
add_action( 'ux_builder_setup', 'pt_ux_builder_tab_has_icon_item_shortocde' );

function pt_ux_builder_tab_has_icon_item_shortocde()
{
	add_ux_builder_shortcode( 'pt-tab-has-icon-item', array(
		'name'     => __( 'Pt Tab item' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'require'  => array( 'pt-tab-has-icon' ),
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
		'options'  => array(
			'label'      => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter label here..',
			),
			'title'      => array(
				'full_width' => true,
				'type'       => 'textfield',
				'heading'    => 'title',
			),
			'img'        => array(
				'type'    => 'image',
				'heading' => 'Image',
				'default' => '',
			),
			'inline_svg' => array(
				'type'    => 'checkbox',
				'heading' => 'Inline SVG',
				'default' => 'true',
			),
		),
	) );
}


//
add_shortcode( 'pt-tab-has-icon-item', 'pt_get_tab_has_icon_item_shortocde' );

function pt_get_tab_has_icon_item_shortocde($atts, $content = null)
{

	extract( shortcode_atts( array(
		'title'      => '',
		'img'        => '',
		'inline_svg' => 'true',

	), $atts ) );

	$x = $GLOBALS['pt_tab_count']; // init in tab wrap

	$GLOBALS['pt_tabs'][ $x ] = [ 
		'title'      => $title,
		'img'        => $img,
		'inline_svg' => $inline_svg,
		'content'    => $content,
	];

	$GLOBALS['pt_tab_count']++;

	return '<span style="display:none">' . do_shortcode( $content ) . '</span>';
}


