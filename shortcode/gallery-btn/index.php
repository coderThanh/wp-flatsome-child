<?php


/**
 * 
 * Shortcode [pt-gallery-btn]
 * Require: 
 */


add_action( 'wp_enqueue_scripts', 'pt_shortcode_gallery_btn_setup' );

function pt_shortcode_gallery_btn_setup()
{
	wp_enqueue_style( 'gallery-btn-shortcode', get_stylesheet_directory_uri() . '/shortcode/gallery-btn/syles.css', [], '1.0' );
}


add_action( 'ux_builder_setup', 'pt_ux_builder_gallery_btn' );

function pt_ux_builder_gallery_btn()
{


	add_ux_builder_shortcode( 'pt-gallery-btn', array(
		'name'     => __( 'Pt Gallery Button' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'options'  => array(
			'ids'        => array(
				'type'    => 'gallery',
				'heading' => __( 'Images' ),
			),
			'btn_text'   => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( '' ),
				'heading'     => 'Button text',
			),
			'btn_link'   => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( '' ),
				'heading'     => 'Button link',
			),
			'auto_slide' => array(
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
			'infinitive' => array(
				'type'    => 'select',
				'heading' => "Infinitive",
				'default' => '',
				'options' => array(
					'false' => 'Disable',
					''      => 'Enable',
				),
			),
		),
	) );
}


add_shortcode( 'pt-gallery-btn', 'pt_gallery_btn_shotcode' );

function pt_gallery_btn_shotcode($atts, $content = null)
{

	extract( shortcode_atts( array(
		'ids'        => '',
		'btn_text'   => '',
		'btn_link'   => '',
		'auto_slide' => 'false',
		'infinitive' => 'true',
	), $atts ) );

	?>
	<section class="footer-gallery">
		<div class="section-content relative container">
			<?php if( !empty( $btn_text ) ) :
				; ?>
				<?php echo button_shortcode( array(
					'text'        => $btn_text,
					'color'       => 'primary',
					'link'        => $btn_link,
					'radius'      => '10',
					'letter_case' => 'lowercase',
					'class'       => 'btn',
				) ); ?>
			<?php endif; ?>
			<?php echo ux_gallery( array(
				// meta
				'ids'                 => $ids, // Gallery IDS
				'lightbox_image_size' => 'original',

				// Layout
				'style'               => 'overlay',
				'columns'             => '6',
				'columns__sm'         => '3',
				'columns__md'         => '4',
				'col_spacing'         => 'small',
				'type'                => 'slider', // slider, row, masonery, grid
				'slider_nav_style'    => 'simple',
				'slider_nav_color'    => 'light',
				'auto_slide'          => $auto_slide,
				'infinitive'          => $infinitive,

				// Box styles
				'text_align'          => 'center',
				'image_size'          => 'original',
				'image_height'        => '100%',
				'image_radius'        => '6',
				'image_overlay'       => 'rgba(0, 0, 0, 0)',
			) ); ?>
		</div>
	</section>
	<?php
}
