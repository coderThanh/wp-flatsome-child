<?php
// Setup theme init
add_action( 'init', 'pt_type_post_setup' );

function pt_type_post_setup()
{
	// Add later
	remove_action( 'flatsome_after_header', 'flatsome_custom_blog_header', 10 );
}

/**
 * Add shortcode Blog header to archive post & single post
 */

add_action( 'flatsome_before_blog', 'pt_add_theme_option_blog_header_to_blog_post' );

if( !function_exists( 'pt_add_theme_option_blog_header_to_blog_post' ) ) {
	function pt_add_theme_option_blog_header_to_blog_post()
	{

		$current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		ob_start();
		?>
		<?php
		if( !is_single() && $current_page <= 1 ) {
			echo do_shortcode( get_theme_mod( 'blog_header' ) );
		}
		?>
		<?php
		echo ob_get_clean();
	}
}

/**
 * Add shortcode Blog after content to archive post & single post
 */

add_action( 'flatsome_after_blog', 'pt_add_theme_option_blog_after_content_to_blog_post' );

if( !function_exists( 'pt_add_theme_option_blog_after_content_to_blog_post' ) ) {
	function pt_add_theme_option_blog_after_content_to_blog_post()
	{

		$current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		ob_start();
		?>
		<?php
		if( !is_single() && $current_page <= 1 ) {
			echo do_shortcode( get_theme_mod( 'blog_after_content' ) );
		}
		?>
		<?php
		echo ob_get_clean();
	}
}

// 
/**
 * Create Theme option 
 */

add_action( 'customize_register', 'pt_blog_theme_options', 1500 );

function pt_blog_theme_options($wp_customize)
{
	// Inlcude the Alpha Color Picker control file.
	require_once( THEME_CHILD_ROOT . '/inc/code-post/theme-options.php' );

}
