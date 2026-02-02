<?php

/**
 * add shortcode
 * syntax: [pt-single-cat-title]
 */
add_shortcode( 'pt-single-cat-title', 'pt_get_single_cat_title' );

function pt_get_single_cat_title($atts, $content = null)
{

	extract( shortcode_atts( array(
		'title'    => '',
		'type_tag' => 'div',
	), $atts ) );

	ob_start();


	echo '<' . $type_tag . ' class="cat-title page-title">';

	if( is_page() || is_single() ) :
		echo '<span>' . get_the_title() . '</span>';

	elseif( is_category() ) :
		echo '<span>' . single_cat_title( "", false ) . '</span>';
	elseif( is_tax() ) :
		echo '<span>' . single_term_title( "", false ) . '</span>';
	elseif( is_archive() ) :
		echo '<span>' . the_archive_title( "", false ) . '</span>';

	elseif( is_tag() ) :
		printf( __( 'Tag : %s', 'flatsome' ), '<span>' . single_tag_title( '', false ) . '</span>' );

	elseif( is_search() ) :
		printf( __( 'Tìm kiếm: %s', 'flatsome' ), '<span>' . get_search_query() . '</span>' );

	elseif( is_author() ) :
		/* Queue the first post, that way we know
		 * what author we're dealing with (if that is the case).
		 */
		the_post();
		printf( __( 'Tác giả: %s', 'flatsome' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		/* Since we called the_post() above, we need to
		 * rewind the loop back to the beginning that way
		 * we can run the loop properly, in full.
		 */
		rewind_posts();

	elseif( is_day() ) :
		printf( __( 'Theo ngày: %s', 'flatsome' ), '<span>' . get_the_date() . '</span>' );

	elseif( is_month() ) :
		printf( __( 'Theo tháng: %s', 'flatsome' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

	elseif( is_year() ) :
		printf( __( 'Theo năm: %s', 'flatsome' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

	else :
		echo '<span>' . $title . '</span>';
	endif;

	echo '</' . $type_tag . '>';

	return ob_get_clean();
}

add_action( 'ux_builder_setup', 'pt_ux_builder_single_cat_title' );

function pt_ux_builder_single_cat_title()
{
	add_ux_builder_shortcode( 'pt-single-cat-title', array(
		'name'     => __( 'Pt Single Category title' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'options'  => array(
			'title'    => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => '',
				'placeholder' => __( 'Tiêu đề thay thế' ),
				'heading'     => 'Tiêu đề thay thế',
			),
			'type_tag' => array(
				'type'    => 'select',
				'heading' => 'Tag HTML',
				'default' => 'div',
				'options' => array(
					'div' => 'div',
					'h1'  => 'h1',
					'h2'  => 'h2',
					'h3'  => 'h3',
				),
			),
		),
	) );
}
