<?php
// remove_shortcode( 'accordion-item' );
// add_shortcode( 'accordion-item', 'pt_ux_accordion_item_custom' );


/**
 * Output the accordion-item shortcode.
 *
 * @param array  $atts    Shortcode attributes.
 * @param string $content Accordion content.
 * @param string $tag     The name of the shortcode, provided for context to enable filtering.
 *
 * @return string.
 */
function pt_ux_accordion_item_custom($atts, $content = null, $tag = '')
{
	global $flatsome_accordion_state, $flatsome_accordion_faq_schema;

	$current = count( $flatsome_accordion_state ) - 1;
	$state   = isset( $flatsome_accordion_state[ $current ] )
		? $flatsome_accordion_state[ $current ]
		: null;

	$atts = shortcode_atts(
		array(
			'id'     => 'accordion-' . wp_rand(),
			'title'  => 'Accordion Panel',
			'anchor' => '',
			'class'  => '',
		),
		$atts,
		$tag
	);

	$is_open       = false;
	$classes       = array( 'accordion-item' );
	$title_classes = array( 'accordion-title', 'plain' );

	if( is_array( $state ) && $state['current'] === $state['open'] ) {
		$is_open         = true;
		$title_classes[] = 'active';
	}

	if( !empty( $atts['class'] ) )
		$classes[] = $atts['class'];

	if( isset( $flatsome_accordion_state[ $current ]['current'] ) ) {
		$flatsome_accordion_state[ $current ]['current']++;
	}

	if( isset( $flatsome_accordion_state[ $current ]['faq_schema'] ) && $flatsome_accordion_state[ $current ]['faq_schema'] ) {
		$question = wp_strip_all_tags( $atts['title'] );
		$answer   = $content;

		$answer = do_shortcode( $answer );
		$answer = shortcode_unautop( $answer );
		$answer = wptexturize( $answer );

		if( $GLOBALS['wp_embed'] instanceof \WP_Embed ) {
			$answer = $GLOBALS['wp_embed']->autoembed( $answer );
		}

		$flatsome_accordion_faq_schema[] = array(
			'question' => $question,
			'answer'   => $answer,
		);
	}

	$link_atts = array(
		'id'            => esc_attr( $atts['id'] ) . '-label',
		'class'         => esc_attr( implode( ' ', $title_classes ) ),
		'href'          => !empty( $atts['anchor'] )
			? '#' . rawurlencode( $atts['anchor'] )
			: esc_url( '#accordion-item-' . flatsome_to_dashed( $atts['title'] ) ),
		'aria-expanded' => $is_open ? 'true' : 'false',
		'aria-controls' => esc_attr( $atts['id'] ) . '-content',
	);

	$accordion_inner_atts = array(
		'id'              => esc_attr( $atts['id'] ) . '-content',
		'class'           => 'accordion-inner',
		'style'           => $is_open ? 'display: block;' : null,
		'aria-labelledby' => esc_attr( $atts['id'] ) . '-label',

	);

	$stt = $flatsome_accordion_state[ $current ]['current'] ? $flatsome_accordion_state[ $current ]['current'] - 1 : 1;

	ob_start();

	?>
	<div id="<?php echo esc_attr( $atts['id'] ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<a <?php echo flatsome_html_atts( $link_atts ); ?>>
			<div
				class="el-stt"><?php echo esc_attr( $stt > 9 ? $stt : '0' . $stt ); ?></div>
			<button class="toggle" aria-label="<?php esc_attr_e( 'Toggle', 'flatsome' ); ?>"><i
					class="icon-angle-down"></i></button>
			<span><?php echo $atts['title']; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
		</a>
		<div <?php echo flatsome_html_atts( $accordion_inner_atts ); ?>>
			<?php echo do_shortcode( $content ); ?>
		</div>
	</div>
	<?php

	return ob_get_clean();
}
