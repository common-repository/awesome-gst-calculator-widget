<?php
/*******************************************************************/
function wpgstcal_register_widget() {
	register_widget( 'wpgstcal_widget' );
}
add_action( 'widgets_init', 'wpgstcal_register_widget' );
class wpgstcal_widget extends WP_Widget {
	function __construct() {
	parent::__construct(
		'wpgstcal_widget', // widget ID
		__('Awesome GST Calculator Widget', ' wpgstcal_widget_domain'), // widget name
		array( 'description' => __( 'Awesome GST Calculator Widget', 'wpgstcal_widget_domain' ), ) // widget description
		);
	}
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		//if title is present
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		//output
		echo wpgstcal_shortcode_callback(array());  //display widget HTML
		echo $args['after_widget'];
	}
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		$title = $instance[ 'title' ];
		else
		$title = __( 'Default Title', 'wpgstcal_widget_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
	<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}