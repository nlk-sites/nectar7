<?php
/**
 * class ProBlogger
 *
 */
add_action( 'after_setup_theme', array( 'ProBlogger', 'setup' ) );
add_action( 'init', array( 'ProBlogger', 'init') );
add_action( 'wp_enqueue_scripts', array( 'ProBlogger', 'enqueue_styles' ) );
add_action( 'wp_enqueue_scripts', array( 'ProBlogger', 'enqueue_scripts' ) );
add_filter( 'body_class',array( 'ProBlogger', 'body_classes' ) );

add_action( 'admin_init', array( 'ProBlogger', 'wpbakery_support' ) );
add_action( 'admin_enqueue_scripts', array( 'ProBlogger', 'enqueue_admin_scripts' ) );

// Errors and Warnings
if ( is_plugin_active( 'progo-jumbotron/progo-jumbotron.php' ) )
	add_action( 'admin_notices', array( 'ProBlogger', 'admin_notice' ) );

/**
 * the Class
 */
class ProBlogger {

	public static $ver;
	public static $plugin_dir;
	public static $plugin_url;

	public function __construct() {
		$plugin_dir = trailingslashit( plugin_dir_path( dirname( dirname( __FILE__ ) ) ) );
		$plugin_url = trailingslashit( plugin_dir_url( dirname( dirname( __FILE__ ) ) ) );
		$plugin_data = get_plugin_data( $plugin_dir . 'progo-problogger.php', $markup = true, $translate = true );
		self::$plugin_dir = $plugin_dir;
		self::$plugin_url = $plugin_url;
		self::$ver = $plugin_data['Version'];
	} // end __construct()

	static function activate() {
		// New posts category for Featured posts
		wp_create_category('Featured');
	} // end activate()

	static function deactivate() {
		// Do something...
	} // end deactivate()

	static function uninstall() {
		if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
			exit();

		// Delete plugin options
		//$option_name = 'plugin_option_name';
		//delete_option( $option_name );

		// For site options in multisite
		//delete_site_option( $option_name );

		// Drop a custom db table
		//global $wpdb;
		//$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}mytable" );
	} // end uninstall()

	/**
	 * Plugin compatibility check
	 *
	 * This plugin is not compatible with progo-jumbotron plugin. Checks if progo-jumbotron is installed and issues a warning.
	 */
	static function admin_notice() {
		echo sprintf( '<div class="error"><p><strong>%1$s</strong> %2$s</p></div>', __( 'Warning!', 'problogger' ), __( 'ProGo Problogger may not be compatible with the ProGo Jumbotron plugin as it includes duplicate functionality. Please disable ProGo Jumbotron plugin before continuing.', 'problogger' ) );
	} // end admin_notice()

	/**
	 * Set up theme defaults and register support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	static function setup() {

		// New top menu bar for CTAs
		register_nav_menus( array(
			'topmenu'  => __( 'Top Nav', 'problogger' ),
		) );

		// Add WooCommerce support
		add_theme_support( 'woocommerce' );

	}

	/**
	 * Init theme defaults
	 */
	static function init() {

		register_post_type( 'progo_jumbotron',
			array(
				'labels' => array(
					'name' => __( 'Jumbotrons', 'problogger' ),
					'singular_name' => __( 'Jumbotron', 'problogger' ),
					'menu_name' => __( 'Jumbotron', 'problogger' ),
					'all_items' => __( 'All Jumbotrons', 'problogger' ),
					'edit_item' => __( 'Edit Jumbotron', 'problogger' )
					),
				'description' => 'ProBlogger Jumbotron section blocks',
				'public' => true,
				'has_archive' => false,
				'exclude_from_search' => true,
				'supports' => array(
					'title',
					'editor',
					'thumbnail',
					'revisions',
					),
				'menu_position' => 5,
				'menu_icon' => 'dashicons-images-alt2',
			)
		);
		register_post_type( 'progo_masthead',
			array(
				'labels' => array(
					'name' => __( 'Mastheads', 'problogger' ),
					'singular_name' => __( 'Masthead', 'problogger' ),
					'menu_name' => __( 'Masthead', 'problogger' ),
					'all_items' => __( 'All Mastheads', 'problogger' ),
					'edit_item' => __( 'Edit Masthead', 'problogger' )
					),
				'description' => 'ProBlogger Custom Masthead',
				'public' => true,
				'has_archive' => false,
				'exclude_from_search' => true,
				'supports' => array(
					'title',
					'editor',
					'thumbnail',
					'revisions',
					),
				'menu_position' => 5,
				'menu_icon' => 'dashicons-images-alt2',
			)
		);

	}

	/**
	 * Enqueue scripts and styles
	 */
	static function enqueue_styles() {
		wp_enqueue_style( 'problogger_styles', self::$plugin_url . 'includes/css/styles.css', '', self::$ver );
	}

	static function enqueue_scripts() {
		wp_enqueue_script( 'problogger_scripts', self::$plugin_url . 'includes/js/frontend.js', array( 'jquery' ), self::$ver, true );
	}

	static function enqueue_admin_scripts() {
		wp_enqueue_style( 'problogger_admin_styles', self::$plugin_url . 'includes/css/admin-styles.css', '', self::$ver );
		wp_enqueue_script( 'problogger_admin_scripts', self::$plugin_url . 'includes/js/admin.js', array( 'jquery' ), self::$ver, true );
	}

	/**
	 * Custom body classes
	 */
	static function body_classes( $classes ) {
		$classes[] = 'progo-problogger';
		return $classes;
	}

	/**
	 * Declare WP Bakery Visual Composer support
	 */
	static function wpbakery_support() {
		if ( is_admin() && is_plugin_active( 'js_composer/js_composer.php' ) ) {
			$post_types = array(
				'progo_jumbotron',
				'progo_masthead',
				'pbl_featuredin'
			);
			vc_set_default_editor_post_types( $post_types );
		}
	}

	/**
	 * Get Jumbotron Posts as array
	 */
	static function problogger_get_jumbotron_posts() {
		$posts = array( '' => '(none)' );
		$args = array( 'post_type' => 'progo_jumbotron', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
			$posts[ get_the_ID() ] = get_the_title();
		endwhile;
		return $posts;
	}

	/**
	 * Get Masthead Posts as array
	 */
	static function problogger_get_masthead_posts() {
		$posts = array( '' => '(none)' );
		$args = array( 'post_type' => 'progo_masthead', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
			$posts[ get_the_ID() ] = get_the_title();
		endwhile;
		return $posts;
	}

}
