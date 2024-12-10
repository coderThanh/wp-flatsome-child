<?php

/**
 * Posts archive 2 column.
 *
 * @package          Flatsome\Templates
 * @flatsome-version  3.18.0
 */

if (have_posts()) : ?>

<?php
	// Create IDS
	$ids = array();
	while (have_posts()) : the_post();
		array_push($ids, get_the_ID());
	endwhile; // end of the loop.
	$ids = implode(',', $ids);
?>

	<?php
	echo flatsome_apply_shortcode('blog_posts', array(
		'type'        => 'row',
		'style' => 'normal',
		'col_spacing' => "normal",
		'class'			=> "make-box-equal",
		'depth'       => get_theme_mod('blog_posts_depth', 0),
		'depth_hover' => get_theme_mod('blog_posts_depth_hover', 0),
		'text_align'  => get_theme_mod('blog_posts_title_align', 'left'),
		'columns'     => '2',
		"columns__md" => '2',
		"columns__sm" => '2',
		'excerpt' => 'false',
		'excerpt_length' => 0,
		'show_date'   =>  'text',
		'comments' => 'false',
		'show_category' => 'label',
		'ids'         => $ids,
		'image_height' => '75%',
		'image_size' => "medium",
		'image_overlay' => "rgb(0 0 0 / 0)",
		"image_hover" => "zoom",
		'readmore' => '',
		'readmore_color' => 'secondary',
		'readmore_style' => 'bevel',
		// 'readmore_size' => 'small',
	));
	?>

<?php flatsome_posts_pagination(); ?>

<?php else : ?>

	<?php get_template_part('template-parts/posts/content', 'none'); ?>

<?php endif; ?>
