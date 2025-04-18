<?php

// [pt_brand_of_product]
function pt_brand_of_product($atts, $content = null, $tag = '')
{
	$sliderrandomid = rand();
	extract( shortcode_atts( array(

		// Meta
		'number'              => null,
		'_id'                 => 'cats-' . rand(),
		'ids'                 => false, // Custom IDs
		'title'               => '',
		'cat'                 => '',
		'orderby'             => 'menu_order',
		'order'               => 'ASC',
		'hide_empty'          => 1,
		'parent'              => 'false',
		'offset'              => '',
		'show_count'          => 'true',
		'class'               => '',
		'visibility'          => '',

		// Layout
		'style'               => 'badge',
		'columns'             => '4',
		'columns__sm'         => '',
		'columns__md'         => '',
		'col_spacing'         => 'small',
		'type'                => 'slider', // slider, row, masonery, grid
		'width'               => '',
		'grid'                => '1',
		'grid_height'         => '600px',
		'grid_height__md'     => '500px',
		'grid_height__sm'     => '400px',
		'slider_nav_style'    => 'reveal',
		'slider_nav_color'    => '',
		'slider_nav_position' => '',
		'slider_bullets'      => 'false',
		'slider_arrows'       => 'true',
		'auto_slide'          => 'false',
		'infinitive'          => 'true',
		'depth'               => '',
		'depth_hover'         => '',

		// Box styles
		'animate'             => '',
		'text_pos'            => '',
		'text_padding'        => '',
		'text_bg'             => '',
		'text_color'          => '',
		'text_hover'          => '',
		'text_align'          => 'center',
		'text_size'           => '',

		'image_size'          => '',
		'image_mask'          => '',
		'image_width'         => '',
		'image_hover'         => '',
		'image_hover_alt'     => '',
		'image_radius'        => '',
		'image_height'        => '',
		'image_overlay'       => '',

		// depricated
		'bg_overlay'          => '#000',

	), $atts ) );

	$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

	// if Ids
	if( isset( $atts['ids'] ) ) {
		$ids     = explode( ',', $atts['ids'] );
		$ids     = array_map( 'trim', $ids );
		$parent  = '';
		$orderby = 'include';
	} else {
		$ids = array();
	}

	// get terms and workaround WP bug with parents/pad counts
	$args = array(
		'orderby'    => $orderby,
		'order'      => $order,
		'hide_empty' => $hide_empty,
		'include'    => $ids,
		'pad_counts' => true,
		'child_of'   => 0,
		'offset'     => $offset,
	);

	ob_start();

	$product_categories = get_terms( 'product_brand', $args );

	if( !empty( $parent ) )
		$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent === 'false' ? 0 : $parent ) );
	if( !empty( $number ) )
		$product_categories = array_slice( $product_categories, 0, $number );

	$classes_box   = array( 'box', 'box-category', 'has-hover' );
	$classes_image = array();
	$classes_text  = array();

	// Create Grid
	if( $type == 'grid' ) {
		$columns      = 0;
		$current_grid = 0;
		$grid         = flatsome_get_grid( $grid );
		$grid_total   = count( $grid );
		flatsome_get_grid_height( $grid_height, $_id );
	}

	// Add Animations
	if( $animate ) {
		$animate = 'data-animate="' . esc_attr( $animate ) . '"';
	}

	// Set box style
	if( $style )
		$classes_box[] = 'box-' . $style;
	if( $style == 'overlay' )
		$classes_box[] = 'dark';
	if( $style == 'shade' )
		$classes_box[] = 'dark';
	if( $style == 'badge' )
		$classes_box[] = 'hover-dark';
	if( $text_pos )
		$classes_box[] = 'box-text-' . $text_pos;
	if( $style == 'overlay' && !$image_overlay )
		$image_overlay = true;

	// Set image styles
	if( $image_hover )
		$classes_image[] = 'image-' . $image_hover;
	if( $image_hover_alt )
		$classes_image[] = 'image-' . $image_hover_alt;
	if( $image_height )
		$classes_image[] = 'image-cover';

	// Text classes
	if( $text_hover )
		$classes_text[] = 'show-on-hover hover-' . $text_hover;
	if( $text_align )
		$classes_text[] = 'text-' . $text_align;
	if( $text_size )
		$classes_text[] = 'is-' . $text_size;
	if( $text_color == 'dark' )
		$classes_text[] = 'dark';

	$css_args_img = array(
		array( 'attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%' ),
		array( 'attribute' => 'width', 'value' => $image_width, 'unit' => '%' ),
	);

	$css_image_height = array(
		array( 'attribute' => 'padding-top', 'value' => $image_height ),
	);

	$css_args = array(
		array( 'attribute' => 'background-color', 'value' => $text_bg ),
		array( 'attribute' => 'padding', 'value' => $text_padding ),
	);

	// Repeater options
	$repeater['id']                  = $_id;
	$repeater['class']               = $class;
	$repeater['visibility']          = $visibility;
	$repeater['tag']                 = $tag;
	$repeater['type']                = $type;
	$repeater['style']               = $style;
	$repeater['format']              = $image_height;
	$repeater['slider_style']        = $slider_nav_style;
	$repeater['slider_nav_color']    = $slider_nav_color;
	$repeater['slider_nav_position'] = $slider_nav_position;
	$repeater['slider_bullets']      = $slider_bullets;
	$repeater['auto_slide']          = $auto_slide;
	$repeater['infinitive']          = $infinitive;
	$repeater['row_spacing']         = $col_spacing;
	$repeater['row_width']           = $width;
	$repeater['columns']             = $columns;
	$repeater['columns__sm']         = $columns__sm;
	$repeater['columns__md']         = $columns__md;
	$repeater['depth']               = $depth;
	$repeater['depth_hover']         = $depth_hover;


	get_flatsome_repeater_start( $repeater );

	if( $product_categories ) {
		foreach( $product_categories as $category ) {

			$classes_col = array( 'product-brand', 'col' );

			$link = get_term_link( $category->term_id );

			$thumbnail_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

			if( $image_size )
				$thumbnail_size = $image_size;

			if( $type == 'grid' ) {
				if( $grid_total > $current_grid )
					$current_grid++;
				$current       = $current_grid - 1;
				$classes_col[] = 'grid-col';
				if( $grid[ $current ]['height'] )
					$classes_col[] = 'grid-col-' . $grid[ $current ]['height'];
				if( $grid[ $current ]['span'] )
					$classes_col[] = 'large-' . $grid[ $current ]['span'];
				if( $grid[ $current ]['md'] )
					$classes_col[] = 'medium-' . $grid[ $current ]['md'];

				// Set image size
				if( $grid[ $current ]['size'] == 'large' )
					$thumbnail_size = 'large';
				if( $grid[ $current ]['size'] == 'medium' )
					$thumbnail_size = 'medium';
			}

			$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );

			if( $thumbnail_id ) {
				$image = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size );
				$image = $image ? $image[0] : wc_placeholder_img_src();
			} else {
				$image = wc_placeholder_img_src();
			}

			?>
			<a href="<?php echo esc_url( $link ); ?>" class="<?php echo esc_attr( implode( ' ', $classes_col ) ); ?>" <?php echo $animate; ?>>
				<div class="col-inner">
					<?php do_action( 'pt_woocommerce_before_subbrand', $category ); ?>
					<div class="<?php echo esc_attr( implode( ' ', $classes_box ) ); ?> ">
						<div class="box-image" <?php echo get_shortcode_inline_css( $css_args_img ); ?>>
							<div class="<?php echo esc_attr( implode( ' ', $classes_image ) ); ?>" <?php echo get_shortcode_inline_css( $css_image_height ); ?>>
								<?php echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="300" height="300" />'; ?>
								<?php if( $image_overlay ) { ?>
									<div class="overlay" style="background-color: <?php echo esc_attr( $image_overlay ); ?>"></div>
								<?php } ?>
								<?php if( $style == 'shade' ) { ?>
									<div class="shade"></div><?php } ?>
							</div>
						</div>
						<div class="box-text <?php echo esc_attr( implode( ' ', $classes_text ) ); ?>" <?php echo get_shortcode_inline_css( $css_args ); ?>>
							<div class="box-text-inner">
								<h5 class="uppercase header-title">
									<?php echo wp_kses_post( $category->name ); ?>
								</h5>
								<?php if( $show_count ) { ?>
									<p
										class="is-xsmall uppercase count <?php if( $style == 'overlay' )
											echo 'show-on-hover hover-reveal reveal-small'; ?>">
										<?php if( $category->count > 0 ) {
											echo apply_filters( 'woocommerce_subcategory_count_html', $category->count . ' ' . ( $category->count > 1 ? esc_html__( 'Products', 'woocommerce' ) : esc_html__( 'Product', 'woocommerce' ) ), $category );
										}
										?>
									</p>
								<?php } ?>
								<?php
								/**
								 * pt_woocommerce_after_subbrand_title hook
								 */
								do_action( 'pt_woocommerce_after_subbrand_title', $category );
								?>
							</div>
						</div>
					</div>
					<?php do_action( 'pt_woocommerce_after_subbrand', $category ); ?>
				</div>
			</a>
			<?php
		}
	}
	wc_reset_loop();

	get_flatsome_repeater_end( $repeater );

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode( "pt_brand_of_product", "pt_brand_of_product" );
