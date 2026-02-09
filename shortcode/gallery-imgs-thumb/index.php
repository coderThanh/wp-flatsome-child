<?php

// init 
add_action( 'wp_enqueue_scripts', function () {
	// Enqueue Custom Script
	wp_enqueue_script( 'pt-gallery-thumb-js', WEBSITE_CHILD_URL . '/shortcode/gallery-imgs-thumb/script.js', [ 'swiper-js' ], '1.0', true );

} );

add_shortcode( 'pt_gallery_imgs_thumb', 'pt_gallery_imgs_thumb_shortcode' );

function pt_gallery_imgs_thumb_shortcode($atts)
{
	$atts = shortcode_atts( array(
		'ids'        => '',
		'thumb'      => 5,
		'thumb__md'  => 4,
		'thumb__sm'  => 3,
		'lightbox'      => true,
		'class'      => '',
		'visibility' => '',
	), $atts );

	if( empty( $atts['ids'] ) ) {
		return '';
	}

	$img_ids = explode( ',', $atts['ids'] );
	if( empty( $img_ids ) ) {
		return '';
	}

	$thumb     = intval( $atts['thumb'] ) > 0 ? intval( $atts['thumb'] ) : 3;
	$thumb__md = intval( $atts['thumb__md'] ) > 0 ? intval( $atts['thumb__md'] ) : 4;
	$thumb__sm = intval( $atts['thumb__sm'] ) > 0 ? intval( $atts['thumb__sm'] ) : 5;

	$uniq_id = uniqid( 'gallery_thumb_' );
	
	$classes = [ 'pt-gallery-wrapper' ];
	if ( ! empty( $atts['class'] ) ) $classes[] = $atts['class'];
	if ( ! empty( $atts['visibility'] ) ) $classes[] = $atts['visibility'];
	
	// Lightbox support
	if ( $atts['lightbox'] && $atts['lightbox'] !== 'false' ) {
		$classes[] = 'lightbox-multi-gallery';
	}

	ob_start();
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
		id="<?php echo esc_attr( $uniq_id ); ?>"
		data-thumb-col="<?php echo esc_attr( $thumb__sm ); ?>"
		data-thumb-col-md="<?php echo esc_attr( $thumb__md ); ?>"
		data-thumb-col-lg="<?php echo esc_attr( $thumb ); ?>">
		<!-- Main Slider -->
		<div class="swiper gallery-main">
			<div class="swiper-wrapper">
				<?php foreach( $img_ids as $id ) :
					// Check if attachment exists
					if( !wp_get_attachment_image_src( $id ) ) continue;
					
					// Get image src for lightbox
					$full_image_src = wp_get_attachment_image_src( $id, 'full' );
					$lightbox_url = $full_image_src ? $full_image_src[0] : '';
					$attachment_data = get_post( $id );
					$caption = $attachment_data->post_excerpt;
					?>
					<div class="swiper-slide">
						<div class="el-img-main">
							<?php if ( $atts['lightbox'] && $atts['lightbox'] !== 'false' && $lightbox_url ) : ?>
								<a href="<?php echo esc_url( $lightbox_url ); ?>" 
								   class="image-lightbox lightbox-gallery" 
								   title="<?php echo esc_attr( $caption ); ?>">
									<?php echo wp_get_attachment_image( $id, 'large' ); ?>
								</a>
							<?php else : ?>
								<?php echo wp_get_attachment_image( $id, 'large' ); ?>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- Thumbs Slider -->
		<div class="swiper gallery-thumbs">
			<div class="swiper-wrapper">
				<?php foreach( $img_ids as $id ) :
					if( !wp_get_attachment_image_src( $id ) )
						continue;
					?>
					<div class="swiper-slide">
						<div class="el-img-thumb">
							<?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
