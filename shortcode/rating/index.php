<?php

/** Rating
 */
add_action( 'wp_enqueue_scripts', 'pt_shortcode_rating_setup' );

function pt_shortcode_rating_setup()
{
	wp_enqueue_style( 'pt-rating-shortcode', get_stylesheet_directory_uri() . '/shortcode/rating/style.css', [], '1.0' );
}


/**
 * 
 * Shortcode [pt-rating]
 * Require: 
 */
add_action( 'ux_builder_setup', 'pt_ux_builder_rating' );

function pt_ux_builder_rating()
{
	add_ux_builder_shortcode( 'pt-rating', array(
		'name'     => __( 'Pt Rating' ),
		'category' => __( 'Content' ),
		'priority' => 1,
		'wrap'     => false,
		'inline'   => true,
		'nested'   => true,
		'options'  => array(
			'title_options' => array(
				'type'    => 'group',
				'heading' => __( 'Title' ),
				'options' => array(
					'rating'     => array(
						'type'       => 'slider',
						'heading'    => 'Star',
						'default'    => '5',
						'responsive' => false,
						'max'        => '5',
						'min'        => '0',
						'unit'       => 'star',
						'step'       => '1',
					),
					'is_rating'  => array(
						'type'    => 'checkbox',
						'heading' => 'Can choice star',
						'default' => 'true',
					),
					'name_field' => array(
						'type'        => 'textfield',
						'full_width'  => true,
						'default'     => '',
						'placeholder' => __( '' ),
						'heading'     => __( 'Name field' ),
					),

				),
			),


		),
	) );
}


add_shortcode( 'pt-rating', 'shortcode_pt_rating' );

function shortcode_pt_rating($args, $content)
{
	extract( shortcode_atts( [ 
		'rating'     => 5,
		'is_rating'  => 'true',
		'name_field' => '',
	], $args ) );

	$id_start_1 = generateRandomString();
	$id_start_2 = generateRandomString();
	$id_start_3 = generateRandomString();
	$id_start_4 = generateRandomString();
	$id_start_5 = generateRandomString();

	$id_edited = generateRandomString();

	ob_start();
	?>
	<span onclick="((e)=>document.getElementById('<?php echo esc_attr( $id_edited ); ?>').click())()"
		for="<?php echo esc_attr( $id_edited ); ?>"
		class="pt-star-rating <?php if( $is_rating == "true" )
			echo "can-edit"; ?>">
		<label class="<?php if( $rating == 1 )
			echo "checked" ?>"
				for="<?php echo esc_attr( $id_start_1 ); ?>"
			style="--i:1">
			<span class="material-symbols-rounded">star</span>
		</label>
		<input type="radio"
			class="start"
			name="<?php echo esc_attr( $name_field ); ?>"
			id="<?php echo esc_attr( $id_start_1 ); ?>"
			value="1">
		<label class="<?php if( $rating == 2 )
			echo "checked" ?>"
				for="<?php echo esc_attr( $id_start_2 ); ?>"
			style="--i:2">
			<span class="material-symbols-rounded">star</span>
		</label>
		<input type="radio"
			class="start"
			name="<?php echo esc_attr( $name_field ); ?>"
			id="<?php echo esc_attr( $id_start_2 ); ?>"
			value="2">
		<label class="<?php if( $rating == 3 )
			echo "checked" ?>"
				for="<?php echo esc_attr( $id_start_3 ); ?>"
			style="--i:3">
			<span class="material-symbols-rounded">star</span>
		</label>
		<input type="radio"
			class="start"
			name="<?php echo esc_attr( $name_field ); ?>"
			id="<?php echo esc_attr( $id_start_3 ); ?>"
			value="3">
		<label class="<?php if( $rating == 4 )
			echo "checked" ?>"
				for="<?php echo esc_attr( $id_start_4 ); ?>"
			style="--i:4">
			<span class="material-symbols-rounded">star</span>
		</label>
		<input type="radio"
			class="start"
			name="<?php echo esc_attr( $name_field ); ?>"
			id="<?php echo esc_attr( $id_start_4 ); ?>"
			value="4">
		<label class="<?php if( $rating == 5 )
			echo "checked" ?>"
				for="<?php echo esc_attr( $id_start_5 ); ?>"
			style="--i:5">
			<span class="material-symbols-rounded">star</span>
		</label>
		<input type="radio"
			class="start"
			name="<?php echo esc_attr( $name_field ); ?>"
			id="<?php echo esc_attr( $id_start_5 ); ?>"
			value="5">
		<input type="radio"
			class="edited"
			id="<?php echo esc_attr( $id_edited ); ?>">
	</span>
	<?php
	return ob_get_clean();
}
