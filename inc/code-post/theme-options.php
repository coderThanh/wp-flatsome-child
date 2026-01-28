<?php

// 
$wp_customize->add_setting( 'blog_after_content', array(
	'type'           => 'theme_mod',
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'default'        => '',
	'transport'      => 'refresh',
) );

$wp_customize->add_control( 'blog_after_content', array(
	'type'        => 'textarea',
	'priority'    => 10,
	'section'     => 'blog-layout',
	'label'       => __( 'Nội dung sau bài viết', '' ),
	'description' => __( 'Nội dung sau bài viết sẽ hiển thị bên dưới bài viết', '' ),
	'input_attrs' => array(
		'rows'        => '3',
		'placeholder' => __( 'Bạn có thể truền text hoặc shortcode vào đây', '' ),
	),
) );
