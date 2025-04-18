<?php
// Add custom Theme Functions here
define( 'WEBSITE_CHILD_URL', get_stylesheet_directory_uri() );
define( 'THEME_CHILD_ROOT', dirname( __FILE__ ) );

// Required file
require_once( THEME_CHILD_ROOT . '/inc/code-post/init.php' );
require_once( THEME_CHILD_ROOT . '/inc/code-woo/init.php' );


// Classic edior
add_filter( 'use_block_editor_for_post', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );


// Setup theme init
add_action( 'init', 'pt_theme_setup' );

function pt_theme_setup()
{
	// Stop scaled image
	add_filter( 'intermediate_image_sizes_advanced', '__return_false' );
	add_filter( 'big_image_size_threshold', '__return_false' );
}

// 
add_action( 'after_setup_theme', 'pt_after_theme_setup' );
function pt_after_theme_setup()
{
	require_once( THEME_CHILD_ROOT . '/shortcode/title.php' );
	require_once( THEME_CHILD_ROOT . '/shortcode/btn/index.php' );
	require_once( THEME_CHILD_ROOT . '/shortcode/image-svg.php' ); // require for btn
	require_once( THEME_CHILD_ROOT . '/shortcode/breakcrums.php' );
	require_once( THEME_CHILD_ROOT . '/shortcode/single-cat-title.php' );
	require_once( THEME_CHILD_ROOT . '/shortcode/wrap.php' );
	require_once( THEME_CHILD_ROOT . '/shortcode/logo.php' );
}



/**
 * Add script for Theme ==============================
 */
add_action( 'wp_enqueue_scripts', 'pt_load_enqueue_scripts', 1000 );

function pt_load_enqueue_scripts()
{
	// Remove style theme child
	wp_dequeue_style( 'flatsome-style-css' );

	// add css
	wp_enqueue_style( 'pt-child-theme-fe-toolkit-style', WEBSITE_CHILD_URL . '/styles.global.css', [], time() );
	wp_enqueue_style( 'pt-child-theme-style', WEBSITE_CHILD_URL . '/style.css', [], time() );
	wp_enqueue_style( 'material-icon-outlined', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200', [], '1.1' );
	wp_enqueue_style( 'material-icon-rounded', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,1,-50..200', [], '1.1' );

	// add js
	wp_enqueue_script( 'pt-helper', WEBSITE_CHILD_URL . '/js/helper.js', [], '1.0', true ); // reuqire by theme
	// wp_enqueue_script('pt-child', WEBSITE_CHILD_URL . '/js/script.js', ['jquery'], '1.0', true);
}


/**
 * Enqueue styles and scripts for the child theme admin area.
 * Reuqire if has plugin woocommerce
 */
add_action( 'admin_enqueue_scripts', 'pt_child_admin_enqueue', 60 );

if( !function_exists( 'pt_child_admin_enqueue' ) ) {

	function pt_child_admin_enqueue()
	{
		// css
		wp_enqueue_style( 'material-icon-outlined', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200', [], '1.1' );
		wp_enqueue_style( 'material-icon-rounded', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,1,-50..200', [], '1.1' );

		wp_enqueue_style( 'pt-admin', WEBSITE_CHILD_URL . '/inc/helper/css/admin-flatsome-style.css', [], time() );

		// js
		// Reuqire if has plugin woocommerce
		wp_enqueue_script( 'pt-admin-fe', WEBSITE_CHILD_URL . '/js/script.js', [], time(), true );
		wp_enqueue_script( 'pt-admin-helper', WEBSITE_CHILD_URL . '/js/helper.js', [], time(), true );
	}
}
