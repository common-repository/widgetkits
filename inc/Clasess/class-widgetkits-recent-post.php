<?php
/**
 * Widgetkit class-widgetkits-recent-post.php widget class file
 *
 * @package Widgetkit
 */


/**
 * WidgetkitRecentPost widget.
 */
class WidgetkitRecentPost extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'widgetkits_recent_post', // Base ID
			esc_html__( '= Widgetkits = Posts ', 'widgetkits' ), // Name
			array( 'description' => esc_html__( 'Display Recent Posts', 'widgetkits' ) ) // Args
		);
	}



	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );
		$ppp = isset( $instance['ppp'] ) ? esc_attr( (int) $instance['ppp'] ) : 10;
		?>
		<?php
		if ( ! empty( $instance['title'] ) ) {
			$widget_title = $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			echo wp_kses_post( $widget_title );
		}
		$argument     = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $ppp,
			'ignore_sticky_posts' => true,
		);
		$recent_query = new WP_Query( $argument );
		if ( $recent_query->have_posts() ) :
			?>
		<div class="widgetkits-resent-post">
			<?php
			while ( $recent_query->have_posts() ) :
				$recent_query->the_post();
				?>
			<div class="widgetkits-resent-post-item">
				<?php if(has_post_thumbnail()): ?>
					<a href="<?php the_permalink(); ?>" class="widgetkits-media-thumb">
						<?php  the_post_thumbnail('thumbnail'); ?>
					</a>
				<?php endif; ?>
				<div class="widgetkits-media-body">
					<div class="widgetkits-resent-post-title">
						<h5>
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h5>
					</div>
					<div class="widgetkits-entry-meta">
						<?php
							widgetkits_posted_on();
							widgetkits_posted_by();
						?>
					</div><!-- .entry-meta -->
				</div>
			</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Sorry, no posts found.', 'widgetkits' ); ?></p>
		<?php endif; ?>
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['ppp']   = ( ! empty( $new_instance['ppp'] ) ) ? sanitize_text_field( $new_instance['ppp'] ) : '';

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'widgetkits' );
		$ppp   = isset( $instance['ppp'] ) ? $instance['ppp'] : '5';
		?>
		<p>
			<label id= for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'widgetkits' ); ?></label> 
			<input class="widefat widgetkits_special-wfield" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
			<label id= for="<?php echo esc_attr( $this->get_field_id( 'ppp' ) ); ?>"><?php esc_html_e( 'Post Per Page:', 'widgetkits' ); ?></label> 
			<input class="widefat widgetkits_special-wfield" id="<?php echo esc_attr( $this->get_field_id( 'ppp' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ppp' ) ); ?>" type="text" value="<?php echo esc_attr( $ppp ); ?>"/>
		</p>
		<?php
	}

} // class WidgetkitRecentPost


if ( ! function_exists( 'widgetkits_recent_post_widget_init' ) ) {
	function widgetkits_recent_post_widget_init() {
		register_widget( 'WidgetkitRecentPost' );
	}
}
add_action( 'widgets_init', 'widgetkits_recent_post_widget_init' );
