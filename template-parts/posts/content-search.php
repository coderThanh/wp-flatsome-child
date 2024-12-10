<?php

/**
 * Posts archive 2 column.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

if (have_posts()) : ?>
	<div class="row row-search">
		<?php
		while (have_posts()) : the_post();
			global $post; ?>
			<?php $link = get_permalink($post->ID); ?>
			<div class="col search-item">
				<div class="search-box">
					<div class="search-box-title">
						<a href="<?php echo  esc_url($link); ?>">
							<?php the_title(); ?>
						</a>
					</div>
					<div class="search-box-exerpt">
						<?php the_excerpt($post->ID); ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>

	<?php flatsome_posts_pagination(); ?>

<?php else : ?>

	<?php get_template_part('template-parts/posts/content', 'none'); ?>

<?php endif; ?>