<?php
/**
 * class ProBlogger Partials
 *
 * @package problogger
 *
 */
add_action( 'template_redirect', array( 'ProBlogger_Partials', 'disable_partials' ) );

add_action( 'pgb_block_navbar', array( 'ProBlogger_Partials', 'problogger_masthead' ), 5 ); // Add Masthead to new location
add_action( 'pgb_block_navbar', array( 'ProBlogger_Partials', 'problogger_jumbotron'), 20 ); // Add Jumbotron
add_action( 'pgb_block_navbar', array( 'ProBlogger_Partials', 'problogger_featuredin'), 40 ); // Add Jumbotron

class ProBlogger_Partials extends ProBlogger {
	
	static function disable_partials() {
		global $post;
		if ( ! $post ) return false;
		// Masthead gets relocated above main nav
		remove_action( 'pgb_block_masthead', 'pgb_load_block_masthead', 10 );

		$hide_top_nav = get_post_meta( $post->ID, '_problogger_meta_top_nav_show_key', true );
		if ( '1' === $hide_top_nav ) 
			remove_action( 'pgb_block_navbartop', 'pgb_load_block_navtop', 10 );

		$hide_main_nav = get_post_meta( $post->ID, '_problogger_meta_main_nav_show_key', true );
		if ( '1' === $hide_main_nav ) 
			remove_action( 'pgb_block_navbar', 'pgb_load_block_navbar', 10 );

	}

	static function problogger_masthead() {
		global $post;
		if ( ! $post ) return false;

		$show = get_post_meta( $post->ID, '_problogger_meta_masthead_show_key', true );
		if ( '1' === $show ) 
			return false;

		if ( ! problogger_option( 'show_masthead', false ) ) {
			get_template_part( 'block', 'masthead' );
			return false;
		}

		$the_post_id = problogger_option( 'masthead_post', false );
		if ( ! get_post_status( $the_post_id ) )
			return false;

		$the_post = get_post( $the_post_id );
		$width = problogger_option( 'masthead_width', 'container' );
		$the_content = apply_filters('the_content', $the_post->post_content);
		$breadcrumbs = ( pgb_get_option( 'show_breadcrumb' ) === '1' ? sprintf( '<div id="breadcrumb-container">%s</div>', pgb_get_breadcrumbs() ) : '' );
		$output = $the_content;
		switch ($width) {
			case 'full':
				$output = sprintf( '<header id="masthead" class="page-header problogger-header">%s%s</header>', $breadcrumbs, $the_content );
				break;
			case 'fullcontain':
				$output = sprintf( '<header id="masthead" class="page-header problogger-header"><div class="container">%s%s</div></header>', $breadcrumbs, $the_content );
				break;
			case 'container':
			default:
				$output = sprintf( '<header id="masthead" class="page-header problogger-header container">%s%s</header>', $breadcrumbs, $the_content );
				break;
		}
		return print $output;

	}

	static function problogger_jumbotron() {
		global $post;
		if ( ! $post ) return false;
		$show = get_post_meta( $post->ID, '_problogger_meta_jumbotron_show_key', true );
		if ( $show == '2' ) 
			return false;

		$the_post_id = get_post_meta( $post->ID, '_problogger_meta_jumbotron_post_id', true );
		if( ! get_post_status( $the_post_id ) )
			return false;

		$the_post = get_post( $the_post_id );
		$width = problogger_option( 'jumbotron_width', 'container' );
		$the_bg_color = get_post_meta( $the_post->ID, '_jumbotron_meta_color_key', true );
		$the_styles = 'style="' . ( $the_bg_color ? 'background-color: '.$the_bg_color.'; ' : '' ) . 'border-radius: 0;"';
		$the_content = apply_filters('the_content', $the_post->post_content);
		$output = $the_content;
		switch ($width) {
			case 'full':
				$output = sprintf( '<section class="jumbotron" %s>%s</section>', $the_styles, $the_content );
				break;
			case 'fullcontain':
				$output = sprintf( '<section class="jumbotron" %s><div class="container">%s</div></section>', $the_styles, $the_content );
				break;
			case 'container':
			default:
				$output = sprintf( '<section class="jumbotron container" %s>%s</section>', $the_styles, $the_content );
				break;
		}
		return print $output;
	}

	static function problogger_featuredin() {
		global $post;
		
		if ( ! $post ) return;
		
		$output = sprintf( '<div id="problogger-featuredin_block"><div class="container">%s</div</div>', apply_filters('the_content', $post->post_content) );

		return $output;
	}

	static function problogger_topnav() {
		$show = problogger_option( 'show_topnav', true );
		$show_all = problogger_option( 'show_topnav_all', false );
		if ( ! $show_all && ! is_front_page() )
			$show = false;

		if ( $show ) :
			self::render_problogger_topnav();
		endif;
	}

	static function render_problogger_topnav() {
		$align = problogger_option( 'topnav_alignment', 'left' );
		print( '<div id="top-nav-wrapper">
			<nav id="top-nav" class="navbar navbar-inverse navbar-static-top site-navigation" ><div class="container-fluid" role="navigation"><div  class="container nav-contain menu-container-width" ><div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".top-navbar-responsive-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
			</button></div><div class="collapse navbar-collapse top-navbar-responsive-collapse">' );
		if ( is_active_sidebar( 'problogger_topnav_before' ) )
			dynamic_sidebar( 'problogger_topnav_before' );
		if ( is_active_sidebar( 'problogger_topnav_after' ) )
			dynamic_sidebar( 'problogger_topnav_after' );
		wp_nav_menu(
				array(
					'theme_location' => 'topmenu',
					'container' => false,
					'menu_class' => 'nav navbar-nav navbar-'.$align,
					'fallback_cb' => '',
					'menu_id' => 'secondary-menu',
					'walker' => new wp_bootstrap_navwalker()
				)
			);
		print( '</div></div></div></nav></div>' );
	}

	static function problogger_posts_header() {
		$show = problogger_option( 'show_masthead', true );
		$show_all = problogger_option( 'show_masthead_all', false );
		if ( ! $show_all && ! is_front_page() )
			$show = false;

		if ( $show ) :
			locate_template( 'block-header.php', true );
		endif;
	}

}
