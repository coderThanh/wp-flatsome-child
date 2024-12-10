<?php

/**
 * Posts layout right sidebar.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

do_action( 'flatsome_before_blog' );
?>
<?php
// Get post 
if( is_single() ) {
	global $post;

	$post_id           = $post->ID;
	$categories        = wp_get_post_categories( $post_id );
	$categories_string = implode( ',', $categories );

	$args      = array(
		'post_type'      => 'post',
		'posts_per_page' => 6,
		'cat'            => $categories_string,
	);
	$the_query = new WP_Query( $args );

	if( $the_query->have_posts() ) {

		// Create IDS
		$ids = array();
		while( $the_query->have_posts() ) :
			$the_query->the_post();
			array_push( $ids, get_the_ID() );
		endwhile; // end of the loop. 

		// Set ids
		if( ( $key = array_search( $post_id, $ids ) ) !== false ) {
			unset($ids[ $key ]);
		}
		$ids = implode( ',', $ids );
	}
}
?>
<?php if( !is_single() && flatsome_option( 'blog_featured' ) == 'top' ) {
	get_template_part( 'template-parts/posts/featured-posts' );
} ?>
<div class="row  <?php if( flatsome_option( 'blog_layout_divider' ) )
	echo 'row-divided '; ?>">
	<div class="large-9 small-12 medium-12 col col-content-single-blog">
		<div class="col-inner">
			<?php if( !is_single() && flatsome_option( 'blog_featured' ) == 'content' ) {
				get_template_part( 'template-parts/posts/featured-posts' );
			} ?>
			<?php
			if( is_single() ) {
				get_template_part( 'template-parts/posts/single' );
				comments_template();

			} elseif( flatsome_option( 'blog_style_archive' ) && ( is_archive() || is_search() ) ) {
				get_template_part( 'template-parts/posts/archive', flatsome_option( 'blog_style_archive' ) );
			} else {
				get_template_part( 'template-parts/posts/archive', flatsome_option( 'blog_style' ) );
			}
			?>
		</div>
	</div>
	<div class="post-sidebar large-3 col small-12 medium-12">
		<?php flatsome_sticky_column_open( 'blog_sticky_sidebar' ); ?>
		<?php get_sidebar(); ?>
		<?php flatsome_sticky_column_close( 'blog_sticky_sidebar' ); ?>
	</div>
</div>
<!-- Relate posts -->
<?php if( is_single() && !empty( $ids ) ) :
	; ?>
	<div class="row">
		<div class="col">
			<div class="col-inner">
				<div class="single-blog_release">
					<h3> <?php _e( 'Recent Posts' ); ?></h3>
					<?php
					echo flatsome_apply_shortcode( 'blog_posts', array(
						'type'           => 'row',
						'style'          => 'normal',
						'col_spacing'    => "normal",
						'class'          => "make-box-equal",
						'depth'          => get_theme_mod( 'blog_posts_depth', 0 ),
						'depth_hover'    => get_theme_mod( 'blog_posts_depth_hover', 0 ),
						'text_align'     => get_theme_mod( 'blog_posts_title_align', 'left' ),
						'columns'        => '3',
						"columns__md"    => '2',
						"columns__sm"    => '1',
						'excerpt'        => 'false',
						'excerpt_length' => 0,
						'show_date'      => 'text',
						'comments'       => 'false',
						'show_category'  => 'label',
						'ids'            => $ids,
						'image_height'   => '75%',
						'image_size'     => "medium",
						'image_overlay'  => "rgb(0 0 0 / 0)",
						"image_hover"    => "",
						'readmore'       => '',
						'readmore_color' => 'secondary',
						'readmore_style' => 'bevel',
						// 'readmore_size' => 'small',
					) );
					?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php
do_action( 'flatsome_after_blog' );
?>
