<?php

/**
 * pgb-child functions and definitions
 */

add_action( 'wp_enqueue_scripts', 'pgb_child_enqueue_styles' );
function pgb_child_enqueue_styles() {
    wp_enqueue_style( 'pgb', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'pgb_child_enqueue_scripts' );
function pgb_child_enqueue_scripts() {
    wp_enqueue_script( 'nectar7-js', get_stylesheet_directory_uri() . '/includes/js/nectar7.js', array('jquery') );
}


function get_woo_cart_menu() {
	global $woocommerce;
	if ( sizeof( $woocommerce->cart->cart_contents) > 0 ) :
		$item = sprintf( '<ul class="nav navbar-nav navbar-right"><li><a href="%s">(%s) items <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a></li></ul>', $woocommerce->cart->get_checkout_url(), $woocommerce->cart->get_cart_contents_count() );
	else :
		$item = sprintf( '<ul class="nav navbar-nav navbar-right"><li><a href="%s">Cart empty <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a></li></ul>', $woocommerce->cart->get_checkout_url() );
	endif;
	return $item;
}

remove_filter( 'the_content', 'wpautop' );
