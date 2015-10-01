<?php
/**
 * class ProBlogger Widgets
 *
 */
add_action( 'widgets_init', array( 'ProBlogger_Widgets', 'widgets_init' ) ); // ProBlogger widget areas
add_action( 'before_sidebar', array( 'ProBlogger_Widgets', 'problogger_show_sidebar_cta' ), 10, 2 ); // ProBlogger CTA sidebar widget
/**
 * the Class
 */
class ProBlogger_Widgets extends ProBlogger {

	static function widgets_init() {
		/**
		 * Top Right Nav CTA
		 *
		 * Adds widgetized area to top SEO nav bar at right
		 */
		register_sidebar( array(
			'name'          => 'Top Nav - Before',
			'id'            => 'problogger_topnav_before',
			'decription'    => 'Add widget content before Top Nav',
			'before_widget' => '<div class="navbar-left">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="sr-only">',
			'after_title'   => '</span>',
		) );
		register_sidebar( array(
			'name'          => 'Top Nav - After',
			'id'            => 'problogger_topnav_after',
			'decription'    => 'Add widget content after Top Nav',
			'before_widget' => '<div class="navbar-right">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="sr-only">',
			'after_title'   => '</span>',
		) );
		/**
		 * Masthead CTA
		 *
		 * Adds widgetized area to right side of masthead (logo bar)
		 */
		register_sidebar( array(
			'name'          => 'Masthead Right',
			'id'            => 'problogger_masthead_right',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<span class="sr-only">',
			'after_title'   => '</span>',
		) );
		register_sidebar( array(
			'name'          => 'Masthead Middle',
			'id'            => 'problogger_masthead_middle',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<span class="sr-only">',
			'after_title'   => '</span>',
		) );
	}

	/**
	 * Sidebar CTA Widget
	 *
	 * @since 1.1
	 */
	static function problogger_show_sidebar_cta() {
		$options = problogger_options();
		
		// To show, or not to show the CTA Widget
		$guests_only = problogger_option( 'cta_guest_mode', 1 );
		$show = problogger_option( 'cta_show', $guests_only );

		// Widget options
		$cta_header = problogger_option( 'cta_header_text', true );
		$cta_subheader = problogger_option( 'cta_subheader_text', true );
		$cta_testimonial = problogger_option( 'cta_testimonial_text', true );
		$cta_citation = problogger_option( 'cta_testimonial_citation', true );
		$cta_image = problogger_option( 'cta_testimonial_image', false );
		$cta_footer = problogger_option( 'cta_footer', true );
		$form_type = problogger_option( 'cta_form_type', 'custom' );
		$form_custom = problogger_option( 'cta_form_custom', '<form><input type="submit" value="Submit" onClick="alert(\'Please update the Call-To-Action Widget via the WordPress Customizer.\');" /></form>' );
		$form_gform_id = problogger_option( 'cta_form_gform_id', '1' );

		$class_quote = $cta_image ? 'col-xs-12 col-sm-6 col-md-12 col-xs-push-0 col-sm-push-6 col-md-push-0' : 'col-xs-12 col-sm-12 col-md-12';
		$class_image = $cta_testimonial || $cta_citation ? 'col-xs-12 col-sm-6 col-md-12 col-xs-pull-0 col-sm-pull-6 col-md-pull-0' : 'col-xs-12 col-sm-12 col-md-12';

		$the_header = $cta_header ? sprintf( '<h3 class="text-center">%s</h3>', problogger_option( 'cta_header_text', 'ProBlogger widget Header' ) ) : '';
		$the_subheader = $cta_subheader ? sprintf( '<h4 class="text-center">%s</h4>', problogger_option( 'cta_subheader_text', 'Your professional blog sub-header text' ) ) : '';
		$the_testimonial = $cta_testimonial ? sprintf( '<p class="text-center">%s</p>', problogger_option( 'cta_testimonial_text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras efficitur nisi sit amet turpis porta, id aliquam mauris eleifend. Aliquam feugiat augue ut consequat laoreet.' ) ) : '';
		$the_citation = $cta_citation ? sprintf( '<footer class="text-center" ><strong>%s</strong></footer>', problogger_option( 'cta_testimonial_citation', 'The ProGo Team' ) ) : '';
		$the_quote = sprintf( '<div class="%s"><blockquote>%s%s</blockquote></div>', $class_quote, $the_testimonial, $the_citation );
		$the_image = $cta_image ? sprintf( '<div class="%s"><img src="%s" /></div>', $class_image, problogger_option( 'cta_testimonial_image' ) ) : '';
		$the_form = $form_type === 'custom' ? sprintf( '<div class="col-md-12 clear">%s</div>', $form_custom ) : sprintf( '<div class="col-md-12">%s</div>', do_shortcode( '[gravityform id="' . $form_gform_id . '" title="false" description="false" ajax="true"]' ) );
		$the_footer = $cta_footer ? sprintf( '<div class="col-md-12"><p class="text-center privacy-policy"><small>%s</small></p></div>', problogger_option( 'cta_footer', 'Powered by ProGo ProBlogger. Add your <a href="#">Privacy Policy</a> here.' ) ) : '';

		$panel_heading = sprintf( '<div class="panel-heading">%s%s</div>', $the_header, $the_subheader );
		$panel_body = sprintf( '<div class="panel-body">%s%s%s</div>', $the_quote, $the_image, $the_form );
		$panel_footer = ! empty( $the_footer ) ? sprintf( '<div class="panel-footer">%s</div>', $the_footer ) : '';

		$widget = sprintf( '<aside id="problogger-cta-widget" class="widget col-xs-12 col-sm-6 col-md-12"><div id="problogger-sidebar-inner" class="panel panel-primary">%s%s%s</div></aside>', $panel_heading, $panel_body, $panel_footer );

		if ( $show || is_admin() )
			echo $widget;
	}

}

/**
 * Recent_Posts widget class
 *
 * @since 0.1.0
 */
class ProBlogger_Widget_Recent_Posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'problogger_widget_recent_entries', 'description' => __( "Your site&#8217;s most recent Posts.") );
		parent::__construct('problogger-recent-posts', __('ProBlogger Recent Posts'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;

		$excerptlength = ( ! empty( $instance['excerptlength'] ) ) ? absint( $instance['excerptlength'] ) : 50;
		if ( ! $excerptlength )
			$excerptlength = 50;

		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<ul class="list-unstyled">
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<a href="<?php the_permalink(); ?>" class="post-title clearfix"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
				<span class="post-date clearfix"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			<?php echo substr( get_the_excerpt(), 0, $excerptlength) . '...' . ' <a href="' . get_the_permalink() . '" class="clearfix">Read more</a>'; ?>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['excerptlength'] = (int) $new_instance['excerptlength'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	public function form( $instance ) {
		$title			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number			= isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$excerptlength	= isset( $instance['excerptlength'] ) ? absint( $instance['excerptlength'] ) : 50;
		$show_date		= isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id( 'excerptlength' ); ?>"><?php _e( 'Excerpt length:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'excerptlength' ); ?>" name="<?php echo $this->get_field_name( 'excerptlength' ); ?>" type="text" value="<?php echo $excerptlength; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
		<?php
	}
}

/**
 * ProBlogger_Recent_Comments widget class
 *
 * @since 0.1
 */
class ProBlogger_Widget_Recent_Comments extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'problogger_widget_recent_comments', 'description' => __( 'Your site&#8217;s most recent comments.' ) );
		parent::__construct('problogger-recent-comments', __('ProBlogger Recent Comments'), $widget_ops);
		$this->alt_option_name = 'widget_recent_comments';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array($this, 'recent_comments_style') );

		add_action( 'comment_post', array($this, 'flush_widget_cache') );
		add_action( 'edit_comment', array($this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array($this, 'flush_widget_cache') );
	}

	public function recent_comments_style() {

		/**
		 * Filter the Recent Comments default widget styles.
		 *
		 * @since 3.1.0
		 *
		 * @param bool   $active  Whether the widget is active. Default true.
		 * @param string $id_base The widget ID.
		 */
		if ( ! current_theme_supports( 'widgets' ) // Temp hack #14876
			|| ! apply_filters( 'show_recent_comments_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
		<?php
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget_recent_comments', 'widget');
	}

	public function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get('widget_recent_comments', 'widget');
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		$output = '';

		$icon = '<img src="' . get_stylesheet_directory_uri() . '/images/recent-comments-icon.png' . '" class="widget-icon" />';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Comments' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;

		/**
		 * Filter the arguments for the Recent Comments widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Comment_Query::query() for information on accepted arguments.
		 *
		 * @param array $comment_args An array of arguments used to retrieve the recent comments.
		 */
		$comments = get_comments( apply_filters( 'widget_comments_args', array(
			'number'      => $number,
			'status'      => 'approve',
			'post_status' => 'publish'
		) ) );

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . $icon . $title . $args['after_title'];
		}

		$output .= '<ul id="problogger-recentcomments" class="list-unstyled">';
		if ( $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

			foreach ( (array) $comments as $comment) {
				$output .= '<li class="problogger-recentcomments">';
				/* translators: comments widget: 1: comment author, 2: post link */
				$output .= sprintf( _x( '%1$s %2$s on %3$s', 'widgets' ),
					'<p>' . get_comment_excerpt( $comment->comment_ID ) . '</p>',
					'<span class="comment-author-link">' . get_comment_author_link() . '</span>',
					'<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>'
				);
				$output .= '</li>';
			}
		}
		$output .= '</ul>';
		$output .= $args['after_widget'];

		echo $output;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = $output;
			wp_cache_set( 'widget_recent_comments', $cache, 'widget' );
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_comments']) )
			delete_option('widget_recent_comments');

		return $instance;
	}

	public function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of comments to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		<?php
	}
}
