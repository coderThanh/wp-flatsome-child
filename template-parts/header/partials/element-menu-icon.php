<?php

/**
 * Menu icon element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

$icon_style = flatsome_option('menu_icon_style');
?>
<li class="nav-icon has-icon">
	<?php if ($icon_style) { ?><div class="header-button"><?php } ?>
		<a href="#" data-open="#main-menu" data-pos="<?php echo flatsome_option('mobile_overlay'); ?>" data-bg="main-menu-overlay" data-color="<?php echo flatsome_option('mobile_overlay_color'); ?>" class="<?php echo get_flatsome_icon_class($icon_style, 'small'); ?>" aria-label="<?php echo __('Menu', 'flatsome'); ?>" aria-controls="main-menu" aria-expanded="false">

			<?php echo get_flatsome_icon('icon-menu'); ?>

			<span class="qodef-m-lines">
				<span class="qodef-m-line qodef--1"></span>
				<span class="qodef-m-line qodef--2"></span>
				<span class="qodef-m-line qodef--3"></span>
			</span>

			<?php if (flatsome_option('menu_icon_title')) echo '<span class="menu-title uppercase hide-for-small">' . __('Menu', 'flatsome') . '</span>'; ?>
		</a>
		<?php if ($icon_style) { ?>
		</div> <?php } ?>
</li>