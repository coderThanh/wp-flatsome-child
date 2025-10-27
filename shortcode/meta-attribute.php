<?php
//
add_action( 'ux_builder_setup', 'pt_ux_builder_meta_attribute_shortcode' );

function pt_ux_builder_meta_attribute_shortcode()
{
	add_ux_builder_shortcode( 'pt-meta-attribute', array(
		'name'     => __( 'Pt Meta attribute' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'type'     => 'container',
		'compile'  => false,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'info'     => '{{ title }}',
		'options'  => array(
			'title'            => array(
				'full_width'  => true,
				'heading'     => 'Title',
				'type'        => 'textfield',
				'placeholder' => 'Enter title here..',
			),
			'$content'         => array( // only one field in shortcode // required 'type'     => 'container',
				'heading'    => 'Content',
				'type'       => 'text-editor',
				'full_width' => true,
				'height'     => '300px',
				'tinymce'    => true,
			),
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-meta-attribute', 'pt_meta_attribute_shortcode' );

function pt_meta_attribute_shortcode($atts, $content = null)
{
	extract( shortcode_atts( array(
		'title'      => '',
		'class'      => '',
		'visibility' => '',

	), $atts ) );

	$html = '<div class="pt-meta-attr ' . esc_attr( $class ) . ' ' . esc_attr( $visibility ) . '">';
	if ( ! empty( $title ) ) {
		$html .= '<div class="pt-meta-attr_title">' . esc_html( $title ) . '</div>';
	}
	if ( ! empty( $content ) ) {
		$html .= '<div class="pt-meta-attr_content">' . do_shortcode( $content ) . '</div>';
	}
	$html .= '</div>';
	return $html;
}


