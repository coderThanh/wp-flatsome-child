<?php
// [blog_posts]
function shortcode_pt_loop_post_item($atts, $content = null, $tag = '')
{

	extract(shortcode_atts(array(
		// Layout
		'depth' => '',
		'depth_hover' => '',

		'style' => '',

		'cat' => '',
		'category' => '', // Added for Flatsome v2 fallback
		'excerpt' => 'visible',
		'excerpt_length' => 15,
		'offset' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'tags' => '',

		// Read more
		'readmore' => '',
		'readmore_color' => '',
		'readmore_style' => 'outline',
		'readmore_size' => 'small',

		// div meta
		'post_icon' => 'true',
		'comments' => 'true',
		'show_date' => 'badge', // badge, text
		'badge_style' => '',
		'show_category' => 'false',

		//Title
		'title_size' => 'large',
		'title_style' => '',

		// Box styles
		'animate' => '',
		'text_pos' => 'bottom',
		'text_padding' => '',
		'text_bg' => '',
		'text_size' => '',
		'text_color' => '',
		'text_hover' => '',
		'text_align' => 'center',
		'image_size' => 'medium',
		'image_width' => '',
		'image_radius' => '',
		'image_height' => '56%',
		'image_hover' => '',
		'image_hover_alt' => '',
		'image_overlay' => '',
		'image_depth' => '',
		'image_depth_hover' => '',

	), $atts));

	// Stop if visibility is hidden

	ob_start();

	$classes_box = array();
	$classes_image = array();
	$classes_text = array();

	// Fix overlay color
	if ($style == 'text-overlay') {
		$image_hover = 'zoom';
	}
	$style = str_replace('text-', '', $style);

	// Fix overlay
	if ($style == 'overlay' && !$image_overlay) $image_overlay = 'rgba(0,0,0,.25)';

	// Set box style
	if ($style) $classes_box[] = 'box-' . $style;
	if ($style == 'overlay') $classes_box[] = 'dark';
	if ($style == 'shade') $classes_box[] = 'dark';
	if ($style == 'badge') $classes_box[] = 'hover-dark';
	if ($text_pos) $classes_box[] = 'box-text-' . $text_pos;

	if ($image_hover)  $classes_image[] = 'image-' . $image_hover;
	if ($image_hover_alt)  $classes_image[] = 'image-' . $image_hover_alt;
	if ($image_height) $classes_image[] = 'image-cover';

	// Text classes
	if ($text_hover) $classes_text[] = 'show-on-hover hover-' . $text_hover;
	if ($text_align) $classes_text[] = 'text-' . $text_align;
	if ($text_size) $classes_text[] = 'is-' . $text_size;
	if ($text_color == 'dark') $classes_text[] = 'dark';

	$css_args_img = array(
		array('attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%'),
		array('attribute' => 'width', 'value' => $image_width, 'unit' => '%'),
	);

	$css_image_height = array(
		array('attribute' => 'padding-top', 'value' => $image_height),
	);

	$css_args = array(
		array('attribute' => 'background-color', 'value' => $text_bg),
		array('attribute' => 'padding', 'value' => $text_padding),
	);

	// Add Animations
	if ($animate) {
		$animate = 'data-animate="' . $animate . '"';
	}

	$classes_text = implode(' ', $classes_text);
	$classes_image = implode(' ', $classes_image);
	$classes_box = implode(' ', $classes_box);

	$show_excerpt = $excerpt;

?>

	<div class="box <?php echo $classes_box; ?> box-blog-post has-hover">
		<?php if (has_post_thumbnail()) { ?>
			<div class="box-image" <?php echo get_shortcode_inline_css($css_args_img); ?>>
				<div class="<?php echo $classes_image; ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
					<a href="<?php the_permalink() ?>" class="plain" aria-label="<?php echo esc_attr(the_title()); ?>">
						<?php the_post_thumbnail($image_size); ?>
					</a>
					<?php if ($image_overlay) { ?><div class="overlay" style="background-color: <?php echo $image_overlay; ?>"></div><?php } ?>
					<?php if ($style == 'shade') { ?><div class="shade"></div><?php } ?>
				</div>
				<?php if ($post_icon && get_post_format()) { ?>
					<div class="absolute no-click x50 y50 md-x50 md-y50 lg-x50 lg-y50">
						<div class="overlay-icon">
							<i class="icon-play"></i>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
		<div class="box-text <?php echo $classes_text; ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
			<div class="box-text-inner blog-post-inner">

				<?php do_action('flatsome_blog_post_before'); ?>

				<?php if ($show_category !== 'false') { ?>
					<p class="cat-label <?php if ($show_category == 'label') echo 'tag-label'; ?> is-xxsmall op-7 uppercase">
						<?php
						foreach ((get_the_category()) as $cat) {
							echo $cat->cat_name . ' ';
						}
						?>
					</p>
				<?php } ?>
				<h5 class="post-title is-<?php echo $title_size; ?> <?php echo $title_style; ?>">
					<a href="<?php the_permalink(); ?>" class="plain"><?php the_title(); ?></a>
				</h5>
				<?php if ((!has_post_thumbnail() && $show_date !== 'false') || $show_date == 'text') { ?><div class="post-meta is-small op-8"><?php echo get_the_date(); ?></div><?php } ?>
				<div class="is-divider"></div>
				<?php if ($show_excerpt !== 'false') { ?>
					<p class="from_the_blog_excerpt <?php if ($show_excerpt !== 'visible') {
														echo 'show-on-hover hover-' . $show_excerpt;
													} ?>"><?php
															$the_excerpt  = get_the_excerpt();
															$excerpt_more = apply_filters('excerpt_more', ' [...]');
															echo flatsome_string_limit_words($the_excerpt, $excerpt_length) . $excerpt_more;
															?>
					</p>
				<?php } ?>
				<?php if ($comments == 'true' && comments_open() && '0' != get_comments_number()) { ?>
					<p class="from_the_blog_comments uppercase is-xsmall">
						<?php
						$comments_number = get_comments_number(get_the_ID());
						/* translators: %s: comment count */
						printf(
							_n('%s Comment', '%s Comments', $comments_number, 'flatsome'),
							number_format_i18n($comments_number)
						)
						?>
					</p>
				<?php } ?>

				<?php if ($readmore) { ?>
					<a href="<?php echo get_the_permalink(); ?>" class="button <?php echo $readmore_color; ?> is-<?php echo $readmore_style; ?> is-<?php echo $readmore_size; ?> mb-0">
						<?php echo $readmore; ?>
					</a>
				<?php } ?>

				<?php do_action('flatsome_blog_post_after'); ?>

			</div>
		</div>
		<?php if (has_post_thumbnail() && ($show_date == 'badge' || $show_date == 'true')) { ?>
			<?php if (!$badge_style) $badge_style = get_theme_mod('blog_badge_style', 'outline'); ?>
			<div class="badge absolute top post-date badge-<?php echo $badge_style; ?>">
				<div class="badge-inner">
					<span class="post-date-day"><?php echo get_the_time('d', get_the_ID()); ?></span><br>
					<span class="post-date-month is-xsmall"><?php echo get_the_time('M', get_the_ID()); ?></span>
				</div>
			</div>
		<?php } ?>
	</div>


<?php

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("loop-post-item", "shortcode_pt_loop_post_item");
