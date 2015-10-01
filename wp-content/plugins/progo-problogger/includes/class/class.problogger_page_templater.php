<?php
/**
 * class ProBlogger Page Templates
 *
 */
add_action( 'plugins_loaded', array( 'ProBloggerPageTemplater', 'get_instance' ) );
/**
 * the Class
 */
class ProBloggerPageTemplater extends ProBlogger {

	/**
	 * A Unique Identifier
	 */
	protected $plugin_slug;

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;


	/**
	 * Returns an instance of this class. 
	 */
	public static function get_instance() {

		if( null == self::$instance ) {
			self::$instance = new ProBloggerPageTemplater();
		} 

		return self::$instance;

	}

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	public function __construct() {

		parent::__construct();

		$this->templates = array();

		// Add a filter to the attributes metabox to inject template into the cache.
		add_filter( 'page_attributes_dropdown_pages_args', array( $this, 'register_project_templates' ) );

		// Add a filter to the save post to inject out template into the page cache
		add_filter( 'wp_insert_post_data', array( $this, 'register_project_templates' ) );

		// Add a filter to the template include to determine if the page has our 
		// template assigned and return it's path
		add_filter( 'template_include', array( $this, 'view_project_template') );

		// Get array of page templates
		$templates = scandir( parent::$plugin_dir . 'includes/templates/' );
		if ( is_array( $templates ) ) :
			foreach ( $templates as $template ) {

				if ( $template == '.' || $template == '..' || strpos( $template, '.' ) ) continue;
				$template_meta = get_file_data( parent::$plugin_dir . 'includes/templates/' . $template . '/' . $template . '.php', array('name' => 'Template Name', 'description' => 'Description') );
				$this->templates[ $template . '/' . $template . '.php' ] = ( isset( $template_meta['name'] ) ? $template_meta['name'] : 'ProBlogger Page Template' );

			}
		endif;

		// Admin Menu
		add_action( 'admin_menu', array( $this, 'problogger_page_templater_menu' ) );

	}

	public function problogger_page_templater_menu() {
		add_options_page( 'ProGo Page Templater', 'ProGo Page Templater', 'manage_options', 'problogger-page-templater', array( $this, 'problogger_page_teplater_options' ) );
	}

	public function problogger_page_teplater_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		print( '<ul class="wrap">' );
		if ( is_array($this->templates) ) {
			foreach ( $this->templates as $template => $name ) {
				print( '<li>' . $name . '</li>' );
			}
		}
		print( '</ul>' );
	}


	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 *
	 */
	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list. 
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	}

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template( $template ) {

		global $post;

		if ( ! $post ) return $template;

		if ( ! isset( $this->templates[ get_post_meta( $post->ID, '_wp_page_template', true ) ] ) ) {
			return $template;
		}

		$file = parent::$plugin_dir . 'includes/templates/' .get_post_meta( 
			$post->ID, '_wp_page_template', true 
		);
				
		// Just to be safe, we check if the file exist first
		if( file_exists( $file ) ) {
			return $file;
		} 
		else {
			echo $file;
		}

		return $template;

	}

}
