<?php

/**
 * add shortcode
 * syntax: [pt-slider-one-change-bg]
 */

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_slider_one_change_setup', 1500 );

function pt_shortcode_slider_one_change_setup()
{
	wp_enqueue_script( 'pt-slider-one-change-bg-shortcode', get_stylesheet_directory_uri() . '/shortcode/slider-one-change-bg/script.js', [], time(), true );
}

//
add_action( 'ux_builder_setup', 'pt_ux_builder_slider_one_change_shortcode' );

function pt_ux_builder_slider_one_change_shortcode()
{
	add_ux_builder_shortcode( 'pt-slider-one-change-bg', array(
		'name'     => __( 'Pt Slide one change bg' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'allow'    => array( 'pt-slider-one-change-bg-item' ),
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
			'show_index'       => array(
				'type'    => 'checkbox',
				'heading' => 'Show Index',
				'default' => 'true',
			),
			'show_nav'         => array(
				'type'    => 'checkbox',
				'heading' => 'Show Naviagtor',
				'default' => 'true',
			),
			'show_pagination'  => array(
				'type'    => 'checkbox',
				'heading' => 'Show Pagination',
				'default' => '',
			),
			'show_process'     => array(
				'type'    => 'checkbox',
				'heading' => 'Show PaginationProcess',
				'default' => '',
			),
			'auto_height'      => array(
				'type'    => 'checkbox',
				'heading' => 'Auto Height',
				'default' => '',
			),
			'auto_slide'       => array(
				'type'    => 'select',
				'heading' => 'Auto Slide',
				'default' => '',
				'options' => array(
					''     => 'Disabled',
					'2000' => '2 sec.',
					'3000' => '3 sec.',
					'4000' => '4 sec.',
					'5000' => '5 sec.',
					'6000' => '6 sec.',
					'7000' => '7 sec.',
				),
			),

			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-slider-one-change-bg', 'pt_slide_one_change_bg_shortcode' );

function pt_slide_one_change_bg_shortcode($atts, $content = null)
{

	extract( shortcode_atts( array(
		'auto_slide'      => '',
		'show_index'      => 'true',
		'show_nav'        => 'true',
		'show_pagination' => '',
		'show_process'    => '',
		'auto_height'     => '',
		'class'           => '',
		'visibility'      => '',

	), $atts ) );

	$GLOBALS['pt_slide_one_change_bg_items'] = []; // this will reset every call
	$GLOBALS['pt_slide_one_change_bg_count'] = 0;

	$content = do_shortcode( $content );// run function child

	ob_start();
	?>
	<!-- Swiper -->
	<div class="pt-slide-one-change-bg <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>"
		data-auto-slide="<?php echo esc_attr( $auto_slide ); ?>" data-auto-height="<?php echo esc_attr( $auto_height ); ?>">
		<div class="swiper ptSwiperOneChangeBg">
			<div class="swiper-wrapper">
				<?php $current_index = 0; ?>
				<?php foreach( $GLOBALS['pt_slide_one_change_bg_items'] as $item ) : ?>
					<div class="swiper-slide">
						<div class="el-item">
							<div class="el-item_inner">
								<!-- thumb -->
								<?php $img = wp_get_attachment_image_url( $item['img'], 'full', false ); ?>
								<?php if( !empty( $img ) ) :
									; ?>
									<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>"
										class="el-item_img">
								<?php endif; ?>
								<!-- body -->
								<div class="el-item_body">
									<?php if( $show_index == 'true' ) :
										; ?>
										<span class="el-item_count"><?php echo sprintf( '%02d', $current_index + 1 ); ?></span>
									<?php endif; ?>
									<?php if( !empty( $item['title'] ) ) :
										; ?>
										<a href="<?php echo esc_url( $item['href'] ); ?>" class="el-item_title">
											<?php echo $item['title']; ?>
										</a>
									<?php endif; ?>
									<div class="el-item_desc"><?php echo do_shortcode( $item['content'] ); ?></div>
								</div>
							</div>
						</div>
					</div>
					<?php $current_index++; ?>
				<?php endforeach; ?>
			</div>
			<?php if( $show_process == 'true' ) :
				; ?>
				<div class="autoplay-progress">
					<svg viewBox="0 0 48 48">
						<circle cx="24" cy="24" r="20"></circle>
					</svg>
					<span></span>
				</div>
			<?php endif; ?>
			<?php if( $show_pagination == 'true' ) : ?>
				<div class="swiper-pagination"></div>
			<?php endif; ?>
			<?php if( $show_nav == 'true' ) : ?>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			<?php endif; ?>
		</div>
		<div class="el-bgs">
			<?php foreach( $GLOBALS['pt_slide_one_change_bg_items'] as $item ) : ?>
				<?php $img = wp_get_attachment_image_url( $item['img'], 'full', false ); ?>
				<div class="el-bg" style="background-image: url(<?php echo esc_url( $img ); ?>);">
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php echo $content; ?>
	<?php
	return ob_get_clean();
}


//
add_action( 'ux_builder_setup', 'pt_ux_builder_slider_one_change_bg_item_shortcode' );

function pt_ux_builder_slider_one_change_bg_item_shortcode()
{
	add_ux_builder_shortcode( 'pt-slider-one-change-bg-item', array(
		'name'     => __( 'Pt Item' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'require'  => array( 'pt-slider-one-change-bg' ),
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
		'options'  => array(
			'label' => array(
				'full_width'  => true,
				'heading'     => 'Label',
				'type'        => 'textfield',
				'placeholder' => 'Enter label here..',
			),
			'img'   => array(
				'type'    => 'image',
				'heading' => 'Image',
				'default' => '',
			),
			'title' => array(
				'full_width'  => true,
				'heading'     => 'Title',
				'type'        => 'textfield',
				'placeholder' => 'Enter title here..',
			),
			'href'  => array(
				'full_width' => true,
				'heading'    => 'Href',
				'type'       => 'textfield',
			),
		),
	) );
}


//
add_shortcode( 'pt-slider-one-change-bg-item', 'pt_get_slider_one_change_bg_item_shortcode' );

function pt_get_slider_one_change_bg_item_shortcode($atts, $content = null)
{

	extract( shortcode_atts( array(
		'img'   => '',
		'title' => '',
		'href'  => '',

	), $atts ) );

	$x = $GLOBALS['pt_slide_one_change_bg_count']; // init in table compare wrap

	$GLOBALS['pt_slide_one_change_bg_items'][ $x ] = [
		'img'     => $img,
		'title'   => $title,
		'href'    => $href,
		'content' => $content,
	];

	$GLOBALS['pt_slide_one_change_bg_count']++;

	return '<span></span>';
}


