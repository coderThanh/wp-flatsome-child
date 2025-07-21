<?php

/**
 * add shortcode
 * syntax: [pt-the-content]
 */

//
add_action( 'ux_builder_setup', 'pt_ux_builder_the_content_shortocde' );

function pt_ux_builder_the_content_shortocde()
{
	add_ux_builder_shortcode( 'pt-the-content', array(
		'name'     => __( 'Pt The Content' ),
		'category' => __( 'Content' ),
		'priority' => 10,
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
			'has_inner'        => array(
				'type'    => 'checkbox',
				'heading' => 'Has inner',
				'default' => 'true',
			),
			// 
			'advanced_options' => require( THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php' ),
		),
	) );
}


//
add_shortcode( 'pt-the-content', 'pt_get_the_content_shortcode' );

function pt_get_the_content_shortcode($atts, $content = null)
{

	extract( shortcode_atts( array(
		'class'      => '',
		'visibility' => '',
		'has_inner'  => 'true',

	), $atts ) );

	?>
	<div class="content-box <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $visibility ); ?>"
		style="<?php echo esc_attr( $style ); ?>">
		<?php if( $has_inner == 'true' ) :
			; ?>
			<div class="content-box-inner">
			<?php endif; ?>
			<?php the_content(); ?>
			<?php if( $has_inner == 'true' ) :
				; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php

}
