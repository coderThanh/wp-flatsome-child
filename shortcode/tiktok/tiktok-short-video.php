<?php

// Setup 
// add_action( 'wp_enqueue_scripts', 'pt_shortcode_tiktok_short_video', 1500 );

// function pt_shortcode_tiktok_short_video()
// {
// 	wp_enqueue_script( 'pt-tiktok', 'https://www.tiktok.com/embed.js', [], '', true );
// }

/**
 * 
 * Shortcode [pt-tiktok-short-video]
 * Require: 
 */
add_action( 'ux_builder_setup', 'pt_ux_builder_tiktok_short_video' );

function pt_ux_builder_tiktok_short_video()
{
	add_ux_builder_shortcode( 'pt-tiktok-short-video', array(
		'name'     => __( 'Pt Tiktok Short Video' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ label }}',
		'options'  => array(
			'label'            => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here..',
			),
			'tiktok_video_url' => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'TikTok Video URL',
				'placeholder' => 'Enter TikTok video URL here..',
			),
		),
	) );
}


add_shortcode( 'pt-tiktok-short-video', 'shortcode_pt_tiktok_short_video' );

function shortcode_pt_tiktok_short_video($args, $content)
{
	extract( shortcode_atts( [
		'label'            => '',
		'tiktok_video_url' => '',
	], $args ) );

	$video_id = preg_match( '/\/video\/(\d+)/', $tiktok_video_url, $matches ) ? $matches[1] : '';
	
	if( empty( $video_id ) )
	{
		return '';
	}
	return '<blockquote class="tiktok-embed" cite="' . esc_attr( $tiktok_video_url ) . '" data-video-id="' . esc_attr( $video_id ) . '"><!-- Section Require by tiktok --><section> </section></blockquote><script async src="https://www.tiktok.com/embed.js"></script>';
}
