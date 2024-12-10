<?php

/**
 * Mobile account element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

$icon_style = flatsome_option('account_icon_style');
?>
<li class="account-item has-icon">
	<?php if ($icon_style && $icon_style !== 'image' && $icon_style !== 'plain') echo '<div class="header-button">'; ?>
	<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="account-link-mobile <?php echo get_flatsome_icon_class($icon_style, 'small'); ?>" title="<?php _e('My account', 'woocommerce'); ?>">
		<?php
		echo get_flatsome_icon('icon-user');

		echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22"
    x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""
    fill="currentColor">
    <g>
        <path
            d="M256 288.389c-153.837 0-238.56 72.776-238.56 204.925 0 10.321 8.365 18.686 18.686 18.686h439.747c10.321 0 18.686-8.365 18.686-18.686.001-132.142-84.722-204.925-238.559-204.925zM55.492 474.628c7.35-98.806 74.713-148.866 200.508-148.866s193.159 50.06 200.515 148.866H55.492zM256 0c-70.665 0-123.951 54.358-123.951 126.437 0 74.19 55.604 134.54 123.951 134.54s123.951-60.35 123.951-134.534C379.951 54.358 326.665 0 256 0zm0 223.611c-47.743 0-86.579-43.589-86.579-97.168 0-51.611 36.413-89.071 86.579-89.071 49.363 0 86.579 38.288 86.579 89.071 0 53.579-38.836 97.168-86.579 97.168z"
            opacity="1" class=""></path>
    </g>
</svg>';
		?>
	</a>
	<?php if ($icon_style && $icon_style !== 'image' && $icon_style !== 'plain') echo '</div>'; ?>
</li>