<?php

/**
 * add shortcode
 * syntax: [pt-slider-img-center]
 */

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_slider_img_center_change_bg_setup', 1500 );

function pt_shortcode_slider_img_center_change_bg_setup()
{
	// wp_enqueue_style( 'pt-slider-img-center-change-bg-shortcode', get_stylesheet_directory_uri() . '/shortcode/slider-img-center-change-bg/style.css', [], '1.0');
	wp_enqueue_script( 'pt-slider-img-center-change-bg-shortcode', get_stylesheet_directory_uri() . '/shortcode/slider-img-center-change-bg/script.js', [], '1.0.1', true );
}


//
add_action( 'ux_builder_setup', 'pt_ux_builder_slider_img_center_change_bg_shortcode' );

function pt_ux_builder_slider_img_center_change_bg_shortcode()
{
	add_ux_builder_shortcode( 'pt-slider-img-center', array(
		'name'     => __( 'Pt Slide img center' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'allow'    => array( 'pt-slider-img-center-item' ),
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
			// 'auto_slide'       => array(
			// 	'type'    => 'select',
			// 	'heading' => 'Auto Slide',
			// 	'default' => '',
			// 	'options' => array(
			// 		''     => 'Disabled',
			// 		'2000' => '2 sec.',
			// 		'3000' => '3 sec.',
			// 		'4000' => '4 sec.',
			// 		'5000' => '5 sec.',
			// 		'6000' => '6 sec.',
			// 		'7000' => '7 sec.',
			// 	),
			// ),
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-slider-img-center', 'pt_slide_img_center_shortcode' );

function pt_slide_img_center_shortcode($atts, $content = null)
{

	extract( shortcode_atts( array(
		'auto_slide' => '',
		'class'      => '',
		'visibility' => '',

	), $atts ) );

	$GLOBALS['pt_slide_center_items'] = []; // this will reset every call
	$GLOBALS['pt_slide_center_count'] = 0;

	$content = do_shortcode( $content );// run function child

	ob_start();

	?>
	<!-- Swiper -->
	<div class="pt-slide-center-img <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>"
		data-auto-slide="">
		<div class="swiper ptSwiperCenterImg">
			<div class="swiper-wrapper">
				<?php $current_index = 0; ?>
				<?php foreach( $GLOBALS['pt_slide_center_items'] as $item ) : ?>
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
									<a href="<?php echo esc_url( $item['href'] ); ?>" class="el-item_title">
										<span class="el-item_count"><?php echo sprintf( '%02d', $current_index + 1 ); ?></span>
										<?php echo $item['title']; ?>
									</a>
									<div class="el-item_desc"><?php echo do_shortcode( $item['content'] ); ?></div>
								</div>
							</div>
						</div>
					</div>
					<?php $current_index++; ?>
				<?php endforeach; ?>
			</div>
			<div class="autoplay-progress">
				<svg viewBox="0 0 48 48">
					<circle cx="24" cy="24" r="20"></circle>
				</svg>
				<span></span>
			</div>
		</div>
		<div class="el-bgs">
			<?php foreach( $GLOBALS['pt_slide_center_items'] as $item ) : ?>
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
add_action( 'ux_builder_setup', 'pt_ux_builder_slider_img_center_item_shortcode' );

function pt_ux_builder_slider_img_center_item_shortcode()
{
	add_ux_builder_shortcode( 'pt-slider-img-center-item', array(
		'name'     => __( 'Pt Item' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		// 'type'     => 'container',
		'require'  => array( 'pt-slider-img-center' ),
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
		'options'  => array(
			'label'    => array(
				'full_width'  => true,
				'heading'     => 'Label',
				'type'        => 'textfield',
				'placeholder' => 'Enter label here..',
			),
			'img'      => array(
				'type'    => 'image',
				'heading' => 'Image',
				'default' => '',
			),
			'title'    => array(
				'full_width'  => true,
				'heading'     => 'Title',
				'type'        => 'textfield',
				'placeholder' => 'Enter title here..',
			),
			'href'     => array(
				'full_width' => true,
				'heading'    => 'Href',
				'type'       => 'textfield',
			),
			'$content' => array( // only one field in shortcode // required 'type'     => 'container',
				'heading'    => 'One Content',
				'type'       => 'textarea',
				'full_width' => true,
				'height'     => '200px',
				'tinymce'    => false,
			),
		),
	) );
}


//
add_shortcode( 'pt-slider-img-center-item', 'pt_get_slider_img_center_item_shortcode' );

function pt_get_slider_img_center_item_shortcode($atts, $content = null)
{

	extract( shortcode_atts( array(
		'img'   => '',
		'title' => '',
		'href'  => '',

	), $atts ) );

	$x = $GLOBALS['pt_slide_center_count']; // init in table compare wrap

	$GLOBALS['pt_slide_center_items'][ $x ] = [
		'img'     => $img,
		'title'   => $title,
		'href'    => $href,
		'content' => $content,
	];

	$GLOBALS['pt_slide_center_count']++;

	return '<span style="display:none"></span>';
}


