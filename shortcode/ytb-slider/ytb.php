<?php

/**
 * Yotube Slider with Flatsome UX -----
 * Require: Swiper Element
 */

// Setup 
add_action( 'wp_enqueue_scripts', 'pt_shortcode_ytb_slider_setup', 1500 );

function pt_shortcode_ytb_slider_setup()
{
	wp_enqueue_style( 'pt-ytb-shortcode', get_stylesheet_directory_uri() . '/shortcode/ytb-slider/style.css', [], '1.1' );
	wp_enqueue_script( 'pt-ytb-shortcode', get_stylesheet_directory_uri() . '/shortcode/ytb-slider/script.js', [ 'jquery' ], '1.1', true );
}


/**
 * Shortcode [pt-youtube-slider]
 * Require: [pt-youtube-item]
 */
add_action( 'ux_builder_setup', 'pt_ux_builder_youtube_sliders' );

function pt_ux_builder_youtube_sliders()
{
	add_ux_builder_shortcode( 'pt-youtube-slider', array(
		'name'     => __( 'Pt Youtube List' ),
		'category' => __( 'Content' ),
		'type'     => 'container',
		'priority' => 1,
		'allow'    => array( 'pt-youtube-item' ),
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
	) );
}

add_shortcode( 'pt-youtube-slider', 'pt_youtube_slider' );

function pt_youtube_slider($atts, $content = null)
{

	ob_start();

	$list_content = parse_ytb_shortcode_to_list_attr( $content );


	?>
	<div class="ytb-slider-area">
		<?php if( !empty( $list_content["id"][0] ) ) :
			; ?>
			<div class="ytb-iframe">
				<div class="ytb-iframe-inner">
					<iframe src="https://www.youtube.com/embed/<?php echo $list_content["id"][0]; ?>"
						title="<?php echo $list_content["title"][0]; ?>" frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
						allowfullscreen></iframe>
				</div>
			</div>
		<?php endif; ?>
		<div class="swiper swiper-ytb-thumb">
			<div class="swiper-wrapper" direction="vertical" slides-per-view="auto">
				<?php for( $index = 0; $index < count( $list_content["id"] ); $index++ ) :
					; ?>
					<?php if( !empty( $list_content["id"][ $index ] ) ) :
						; ?>
						<div class="swiper-slide ytb-thumb <?php if( $index == 0 )
							echo "active"; ?>"
							data-id="<?php echo $list_content["id"][ $index ]; ?>" data-index="<?php echo $index; ?>"
							data-title="<?php echo $list_content["title"][ $index ]; ?>">
							<div class="ytb-thumb-inner">
								<div class="ytb-thumb-icon"
									style="background-image:url(&quot;https://img.youtube.com/vi/<?php echo $list_content["id"][ $index ]; ?>/mqdefault.jpg&quot;)">
								</div>
								<div class="ytb-thumb-text"><?php echo __( $list_content["title"][ $index ] ); ?></div>
							</div>
						</div>
					<?php endif; ?>
				<?php endfor; ?>
			</div>
		</div>
	</div>
	<?php

	return ob_get_clean();
}

/**
 * Breadcrumb -----
 * Shortcode [pt-youtube-item]
 * Require: [pt-youtube-slider]
 */

function pt_ux_builder_youtube_item()
{
	add_ux_builder_shortcode( 'pt-youtube-item', array(
		'name'     => __( 'Ytb item' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'require'  => array( 'pt-youtube-slider' ),
		'info'    => '{{ title }}',
		'options'  => array(
			'title' => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( 'Tiêu đề video' ),
				'heading'     => 'Tiêu đề',
				'description' => 'Bắt buộc nhập đầy đủ Tiêu đề & ID, nếu không sẽ hiển thị không đúng',
			),
			'id'    => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( 'AoPiLg8DZ3A' ),
				'heading'     => 'Youtube Video ID',
				'description' => 'Enter a ID Youtube . Example link: https://www.youtube.com/watch?v=AoPiLg8DZ3A',
			),
		),
	) );
}

add_action( 'ux_builder_setup', 'pt_ux_builder_youtube_item' );

add_shortcode( 'pt-youtube-item', 'pt_youtube_item' );

function pt_youtube_item($atts, $content = null)
{
	return "";
}

// 
function parse_ytb_shortcode_to_list_attr($shortcode)
{
	// Store the shortcode attributes in an array here
	$attributes = [];

	// Get all attributes
	if( preg_match_all( '/\w+\=\".*?\"/', $shortcode, $key_value_pairs ) ) {

		// Now split up the key value pairs
		foreach( $key_value_pairs[0] as $kvp ) {
			// var_dump($kvp);
			// echo "<div style='padding-top:10px'></div>";

			$kvp                    = str_replace( '"', '', $kvp );
			$pair                   = explode( '=', $kvp );
			$attributes[ $pair[0] ][] = $pair[1];
		}
	}

	// Return the array
	return $attributes;
}
