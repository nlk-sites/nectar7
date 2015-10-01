<?php
/**
 * class ProBlogger_Template_Tags
 *
 */
add_action( 'after_setup_theme', array( 'ProBlogger_Template_Tags', 'remove_pgb_posted_on' ) );
add_action( 'pgb_posted_on', array( 'ProBlogger_Template_Tags', 'problogger_do_posted_on'), 10 );

/**
 * the Class
 */
class ProBlogger_Template_Tags extends ProBlogger {

	/**
	 * Replace pgb_posted_on action
	 */
	static function remove_pgb_posted_on() {
		remove_action( 'pgb_posted_on', 'pgb_do_posted_on', 10 );
	}
	/* callback */
	static function problogger_do_posted_on() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		if ( is_single() ) {
		
			$time_string = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				$time_string
			);

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ){
				$time_string_update = '<time class="updated" datetime="%1$s">%2$s</time>';
				$time_string_update = sprintf( $time_string_update,
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( get_the_modified_date() )
				);
				$time_string_update = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
					esc_url( get_permalink() ),
					esc_attr( get_the_time() ),
					$time_string_update
				);
				$time_string .= __(', updated on ', 'pgb') . $time_string_update;
			}

		}

		printf( __( '<span class="byline">%1$s</span> • <span class="posted-on">%2$s</span>', 'pgb' ),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'pgb' ), get_the_author() ) ),
				esc_html( get_the_author() )
			),
			$time_string
		);
	}

}
