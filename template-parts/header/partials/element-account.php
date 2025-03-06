<?php

/**
 * Account element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.19.0
 */

if( !is_woocommerce_activated() ) {
	fl_header_element_error( 'woocommerce' );

	return;
}

$icon_custom = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22"
    x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""
    fill="currentColor">
    <g>
        <path
            d="M256 288.389c-153.837 0-238.56 72.776-238.56 204.925 0 10.321 8.365 18.686 18.686 18.686h439.747c10.321 0 18.686-8.365 18.686-18.686.001-132.142-84.722-204.925-238.559-204.925zM55.492 474.628c7.35-98.806 74.713-148.866 200.508-148.866s193.159 50.06 200.515 148.866H55.492zM256 0c-70.665 0-123.951 54.358-123.951 126.437 0 74.19 55.604 134.54 123.951 134.54s123.951-60.35 123.951-134.534C379.951 54.358 326.665 0 256 0zm0 223.611c-47.743 0-86.579-43.589-86.579-97.168 0-51.611 36.413-89.071 86.579-89.071 49.363 0 86.579 38.288 86.579 89.071 0 53.579-38.836 97.168-86.579 97.168z"
            opacity="1" class=""></path>
    </g>
</svg>';

$icon_style           = get_theme_mod( 'account_icon_style' );
$header_account_title = get_theme_mod( 'header_account_title', 1 );
$is_button            = $icon_style && $icon_style !== 'image' && $icon_style !== 'plain';
$li_atts              = [ 
	'class' => [ 'account-item', 'has-icon' ],
];

if( is_account_page() )
	$li_atts['class'][] = 'active';
if( is_user_logged_in() )
	$li_atts['class'][] = 'has-dropdown';
?>
<li <?php echo flatsome_html_atts( $li_atts ); ?>>
	<?php if( $is_button )
		echo '<div class="header-button">'; ?>
	<?php
	if( is_user_logged_in() ) :
		$link_atts = [ 
			'href'       => esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
			'class'      => [ 'account-link', 'account-login' ],
			'title'      => esc_attr__( 'My account', 'woocommerce' ),
			'aria-label' => !$header_account_title ? esc_attr__( 'My account', 'woocommerce' ) : null,
		];

		if( $icon_style && $icon_style !== 'image' ) {
			$link_atts['class'][] = get_flatsome_icon_class( $icon_style, 'small' );
		}
		?>
		<a <?php echo flatsome_html_atts( $link_atts ); ?>>
			<?php if( get_theme_mod( 'header_account_title', 1 ) ) : ?>
				<span class="header-account-title">
					<?php
					if( get_theme_mod( 'header_account_username' ) ) :
						$wp_current_user = wp_get_current_user();
						echo esc_html( apply_filters( 'flatsome_header_account_username', $wp_current_user->display_name ) );
					else :
						esc_html_e( 'My account', 'woocommerce' );
					endif;
					?>
				</span>
			<?php endif; ?>
			<?php
			if( $icon_style == 'image' ) :
				echo '<i class="image-icon circle">' . get_avatar( get_current_user_id() ) . '</i>';
			elseif( $icon_style ) :
				echo get_flatsome_icon( 'icon-user' );

				echo $icon_custom;
			endif;
			?>
		</a>
		<?php
	else : // Show login/register link.
		$link_atts = [ 
			'href'       => esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
			'class'      => [ 'nav-top-link', 'nav-top-not-logged-in', get_flatsome_icon_class( $icon_style, 'small' ) ],
			'title'      => esc_attr__( 'Login', 'woocommerce' ),
			'aria-label' => !$header_account_title ? esc_attr__( 'Login', 'woocommerce' ) : null,
			'data-open'  => ( get_theme_mod( 'account_login_style', 'lightbox' ) == 'lightbox' && !is_checkout() && !is_account_page() ) ? '#login-form-popup' : null,
		];

		if( $icon_style && $icon_style !== 'image' ) {
			$link_atts['class'][] = get_flatsome_icon_class( $icon_style, 'small' );
		}
		?>
		<a <?php echo flatsome_html_atts( $link_atts ); ?>>
			<?php if( get_theme_mod( 'header_account_title', 1 ) ) : ?>
				<span>
					<?php
					esc_html_e( 'Login', 'woocommerce' );
					if( get_theme_mod( 'header_account_register' ) ) :
						echo ' / ' . esc_html__( 'Register', 'woocommerce' );
					endif;
					?>
				</span>
				<?php
			else :
				echo get_flatsome_icon( 'icon-user' );

				echo $icon_custom;
			endif;
			?>
		</a>
	<?php endif; ?>
	<?php if( $is_button )
		echo '</div>'; ?>
	<?php
	// Show Dropdown for logged in users.
	if( is_user_logged_in() ) :
		?>
		<ul class="nav-dropdown <?php flatsome_dropdown_classes(); ?>">
			<?php wc_get_template( 'myaccount/account-links.php' ); ?>
		</ul>
	<?php endif; ?>
</li>