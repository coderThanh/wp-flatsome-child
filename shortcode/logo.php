<?php

/**
 * add shortcode
 * syntax: [pt-logo]
 */

//
add_action( 'ux_builder_setup', 'pt_ux_builder_logo_shortocde' );

function pt_ux_builder_logo_shortocde()
{
	add_ux_builder_shortcode( 'pt-logo', array(
		'name'     => __( 'Pt Logo' ),
		'category' => __( 'Content' ),
		'priority' => 10,
		'info'     => '{{ label }}',
		'options'  => array(
			'label'            => array(
				'full_width'  => true,
				'type'        => 'textfield',
				'heading'     => 'Label',
				'placeholder' => 'Enter admin label here..',
			),
			'is_light'         => array(
				'type'    => 'checkbox',
				'heading' => 'Is Logo light',
				'default' => 'false',
			),
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-logo', 'pt_get_logo_shortocde' );

function pt_get_logo_shortocde($atts, $content = null)
{

	extract( shortcode_atts( array(
		'class'      => '',
		'visibility' => '',
		'is_light'   => 'false',
	), $atts ) );

	$logo_url = null;

	if( $is_light == 'true' ) {
		$logo_url = wp_get_attachment_image_url( get_theme_mod( 'site_logo_dark' ), 'full' );
	} else {
		$logo_url = wp_get_attachment_image_url( get_theme_mod( 'site_logo' ), 'full' );
	}

	?>
	<?php if( !empty( $logo_url ) ) :
		; ?>
		<div class="<?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>">
			<img src="<?php echo esc_attr( $logo_url ); ?>" alt="logo">
		</div>
	<?php endif; ?>
<?php

}
