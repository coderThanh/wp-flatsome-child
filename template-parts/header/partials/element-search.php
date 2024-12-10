<?php

/**
 * Search element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

$icon_style = get_theme_mod('search_icon_style');
?>
<?php if (get_theme_mod('header_search_style') !== 'lightbox') { ?>
	<li class="header-search header-search-dropdown has-icon has-dropdown menu-item-has-children">
		<?php if ($icon_style) { ?><div class="header-button"><?php } ?>
			<a href="#" aria-label="<?php echo __('Search', 'woocommerce'); ?>" class="<?php echo get_flatsome_icon_class(flatsome_option('search_icon_style'), 'small'); ?>">
				<?php echo get_flatsome_icon('icon-search'); ?>

				<!-- 1/2 -->
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon" color="currentColor" fill="currentColor">
					<path d="M495,466.2L377.2,348.4c29.2-35.6,46.8-81.2,46.8-130.9C424,103.5,331.5,11,217.5,11C103.4,11,11,103.5,11,217.5   S103.4,424,217.5,424c49.7,0,95.2-17.5,130.8-46.7L466.1,495c8,8,20.9,8,28.9,0C503,487.1,503,474.1,495,466.2z M217.5,382.9 C126.2,382.9,52,308.7,52,217.5S126.2,52,217.5,52C308.7,52,383,126.3,383,217.5S308.7,382.9,217.5,382.9z" />
				</svg>
			</a>
			<?php if ($icon_style) { ?>
			</div><?php } ?>
		<ul class="nav-dropdown <?php flatsome_dropdown_classes(); ?>">
			<?php get_template_part('template-parts/header/partials/element-search-form'); ?>
		</ul>
	</li>
<?php } else if (get_theme_mod('header_search_style') == 'lightbox') { ?>
	<li class="header-search header-search-lightbox has-icon">
		<?php if ($icon_style) { ?><div class="header-button"><?php } ?>
			<a href="#search-lightbox" aria-label="<?php echo __('Search', 'woocommerce'); ?>" data-open="#search-lightbox" data-focus="input.search-field" class="<?php echo get_flatsome_icon_class(get_theme_mod('search_icon_style'), 'small'); ?>">
				<?php echo get_flatsome_icon('icon-search', '16px'); ?>

				<!-- 2/2 -->
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon" color="currentColor" fill="currentColor">
					<path d="M495,466.2L377.2,348.4c29.2-35.6,46.8-81.2,46.8-130.9C424,103.5,331.5,11,217.5,11C103.4,11,11,103.5,11,217.5   S103.4,424,217.5,424c49.7,0,95.2-17.5,130.8-46.7L466.1,495c8,8,20.9,8,28.9,0C503,487.1,503,474.1,495,466.2z M217.5,382.9 C126.2,382.9,52,308.7,52,217.5S126.2,52,217.5,52C308.7,52,383,126.3,383,217.5S308.7,382.9,217.5,382.9z" />
				</svg>
			</a>

			<?php if ($icon_style) { ?>
			</div>
		<?php } ?>

		<div id="search-lightbox" class="mfp-hide dark text-center">
			<?php echo do_shortcode('[search size="large" style="' . get_theme_mod('header_search_form_style') . '"]'); ?>
		</div>
	</li>
<?php } ?>