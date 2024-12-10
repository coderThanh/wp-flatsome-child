<?php

/**
 * Init Widget
 */
add_action( 'widgets_init', 'create_widget' );

function create_widget()
{
	register_widget( 'BTN_CLEAR_FILTER_WIDGET' );
}

/**
 * Create class for Widget
 */
class BTN_CLEAR_FILTER_WIDGET extends WP_Widget {
	/**
	 * Init info widget: name, id
	 */
	function __construct()
	{
		parent::__construct(
			'BTN_CLEAR_FILTER_WIDGET',
			__( 'Pt Button Clear Filter', '' ),

			array(
				'description' => __( 'Widget này sẽ xoá filter slug' ),
			)
		);
	}

	/**
	 * Create form option
	 */
	function form($instance)
	{
		$default  = array(
			'title' => __( 'Xoá bộ lọc', '' ),
		);
		$instance = wp_parse_args( (array) $instance, $default );

		$title = esc_attr( $instance['title'] );

		?>
		<p>
			<label><?php _e( 'Nhập tiêu đề', '' ); ?></label>
			<input class="widefat"
				   type="text"
				   name="<?php echo $this->get_field_name( 'title' ); ?>"
				   value="<?php echo $title; ?>" />
		</p>
		<?php

	}

	/**
	 * Save widget form
	 */

	function update($new_instance, $old_instance)
	{
		parent::update( $new_instance, $old_instance );

		$instance          = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Show widget
	 */

	function widget($args, $instance)
	{
		extract( $args );
		extract( $instance );

		global $wp;

		$current_url = $wp->request;

		if( is_search() ) {

			$current_url = "?s=";

			if( !empty( $_GET['s'] ) ) {
				$current_url .= $_GET['s'];
			}

			if( !empty( $_GET['post_type'] ) ) {
				$current_url .= '&post_type=' . $_GET['post_type'];
			}
		}

		ob_start();

		echo $before_widget;
		?>

		<?php if( !empty( $_GET ) ) :
			; ?>
			<a href="/<?php echo esc_attr( $current_url ); ?>"
			   class="btn-clear-filter"><span><?php echo esc_attr( $title ); ?></span></a>
		<?php endif; ?>
		<?php

		echo $after_widget;

		echo ob_get_clean();
	}
}
