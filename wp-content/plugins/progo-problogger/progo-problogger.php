<?php
/*
Plugin Name: ProGo ProBlogger
Plugin URI:  http://www.progo.com/problogger
Description: Make your blog work for you! Create a better converting blog. New layout options, Calls-To-Action, and more. Go to the WordPress Customizer to begin.
Version:     1.0.0
Author:      ProGo
Author URI:  http://www.progo.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: problogger
*/

defined( 'ABSPATH' ) or die( '' );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

global $pagenow;

$plugin_basename = plugin_basename( __FILE__ );

include( plugin_dir_path( __FILE__ ) . 'includes/class/class.problogger.php');
include( plugin_dir_path( __FILE__ ) . 'includes/class/class.problogger_meta_boxes.php');
include( plugin_dir_path( __FILE__ ) . 'includes/class/class.problogger_page_templater.php');
include( plugin_dir_path( __FILE__ ) . 'includes/class/class.problogger_partials.php');
include( plugin_dir_path( __FILE__ ) . 'includes/class/class.problogger_template_tags.php');
include( plugin_dir_path( __FILE__ ) . 'includes/class/class.problogger_theme_customizer.php');
include( plugin_dir_path( __FILE__ ) . 'includes/class/class.problogger_widgets.php');

// On plugin activate/deactivate/uninstall
register_activation_hook( __FILE__, array( 'ProBlogger', 'activate' ) ); // on plugin activation
register_deactivation_hook( __FILE__, array( 'ProBlogger', 'deactivate' ) ); // on plugin deactivation
register_uninstall_hook( __FILE__, array( 'ProBlogger', 'uninstall' ) ); // on plugin uninstall

// Plugin Update
if ( $pagenow === 'plugins.php' ) :
add_action( "after_plugin_row_{$plugin_basename}", function( $plugin_file, $plugin_data, $status ) {
	echo __( sprintf( '%sRegister%s your copy of ProBlogger to access all the features. Or %spurchase a new key%s.', '<a href="#">', '</a>', '<a href="#">', '</a>' ) );
}, 10, 3 );
endif;

/**
 * Get ProBlogger plugin option
 *
 * @param $option		The name of the option to return
 * @param $default		The default value to return if option does not exist
 */
function problogger_option( $name, $default = false ) {
	$options = get_theme_mod( 'problogger_settings', null );
	// return the option if it exists
	if ( isset( $options[$name] ) ) {
		return apply_filters( "problogger_settings_{$name}", $options[$name] );
	}
	// return default if nothing else
	return apply_filters( "problogger_settings_{$name}", $default );
}

/**
 * Get ProBlogger plugin options as array
 *
 * @param none
 */
function problogger_options() {
	$options = get_theme_mod( 'problogger_settings', null );
	return $options;
}


?>
