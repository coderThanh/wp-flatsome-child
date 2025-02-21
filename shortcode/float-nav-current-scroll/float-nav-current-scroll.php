<?php
// Require: swiper, js

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_float_nav_current_scroll', 1500 );

function pt_shortcode_float_nav_current_scroll()
{
	wp_enqueue_script( 'pt-float-nav-current-scroll-shortcode', get_stylesheet_directory_uri() . '/shortcode/float-nav-current-scroll/float-nav-current-scroll.js', [ 'jquery' ], time(), true );
}


//
add_action( 'ux_builder_setup', 'pt_ux_builder_float_nav_current_scroll' );

function pt_ux_builder_float_nav_current_scroll()
{
	add_ux_builder_shortcode( 'pt-float-nav-current-scroll', array(
		'name'     => __( 'Pt Float nav current scroll' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'allow'    => array( 'pt-float-nav-current-scroll-item' ),
		'options'  => [ 
			'is_logo'          => array(
				'type'    => 'checkbox',
				'heading' => 'Show logo',
				'default' => 'true',
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		],
	) );
}


//
add_shortcode( 'pt-float-nav-current-scroll', 'pt_get_float_nav_current_scroll' );

function pt_get_float_nav_current_scroll($atts, $content = null)
{
	extract( shortcode_atts( array(
		'class'      => '',
		'visibility' => '',
		'is_logo'    => 'true',
	), $atts ) );

	$GLOBALS['pt_float_nav_current_scrolls']      = []; // this will reset every call
	$GLOBALS['pt_float_nav_current_scroll_count'] = 0;

	$content = do_shortcode( $content );// run funtion child to set varibale global


	$logo_url = '';

	if( $is_logo == 'true' ) {
		$logo_url = wp_get_attachment_image_url( get_theme_mod( 'site_logo' ), 'full' );
	}


	ob_start();
	?>
	<div class="float-nav-current-scroll <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>">
		<div class="el-sticky">
			<div class="container">
				<div class="el-inner">
					<?php if( !empty( $logo_url ) ) : ?>
						<img src="<?php echo esc_attr( $logo_url ); ?>" alt="logo" class="el-logo">
					<?php endif; ?>
					<div class="el-nav">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php foreach( $GLOBALS['pt_float_nav_current_scrolls'] as $key => $value ) :
									; ?>
									<div class="swiper-slide">
										<a href="#<?php echo esc_attr( $value['id'] ); ?>" class="el-nav-item"
											data-index="<?php echo esc_attr( $key ); ?>"
											data-id="<?php echo esc_attr( $value['id'] ); ?>">
											<?php echo esc_attr( $value['title'] ); ?>
										</a>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- reuire for UX builder -->
	<?php echo $content; ?>
	<?php

	return ob_get_clean();
}

//  item
add_action( 'ux_builder_setup', 'pt_ux_builder_float_nav_current_scroll_item' );

function pt_ux_builder_float_nav_current_scroll_item()
{
	add_ux_builder_shortcode( 'pt-float-nav-current-scroll-item', array(
		'name'     => __( 'Pt Float nav item' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		// 'type'     => 'container',
		'require'  => array( 'pt-float-nav-current-scroll' ),
		'options'  => [ 
			'title' => array(
				'type'    => 'textfield',
				'heading' => 'Title',
			),
			'id'    => array(
				'type'        => 'textfield',
				'heading'     => 'Id to scroll',
				'placeholder' => __( 'idScrollTo' ),
			),
		],
	) );
}


//
add_shortcode( 'pt-float-nav-current-scroll-item', 'pt_get_float_nav_current_scroll_item' );

function pt_get_float_nav_current_scroll_item($atts, $content = null)
{
	extract( shortcode_atts( array(
		'title' => '',
		'id'    => '',
	), $atts ) );

	$index = $GLOBALS['pt_float_nav_current_scroll_count']; // init in tab wrap

	$GLOBALS['pt_float_nav_current_scrolls'][ $index ] = [ 
		'title' => $title,
		'id'    => $id,
	];

	$GLOBALS['pt_float_nav_current_scroll_count']++;

	return '<span></span>';
}


