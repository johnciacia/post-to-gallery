<?php
/*
	Plugin Name: Post To Gallery
	Plugin URI: 
	Description: Adds an endpoint to posts for an optional gallery
	Author: John Ciacia
	Version: 0.1
	Author URI: http://www.johnciacia.com

	Copyright 2012  John Ciacia  (email : john@johnciacia.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

Post_To_Gallery::initialize();

/**
 *
 */
class Post_To_Gallery {
	
	/**
	 *
	 */
	public static function initialize() {
		add_action( 'init', array( __CLASS__, 'init' ) );
		add_filter( 'request', array( __CLASS__, 'request' ) );	
		add_filter( 'the_content', array( __CLASS__, 'the_content' ) );
	}

	/**
	 *
	 */
	public static function the_content( $content ) {   
		if( ! is_singular() ) return $content;

		if( get_query_var( 'gallery' ) ) {
			return '[gallery link="file"]'; 
		} else {
			return $content;        
		}
	}

	/**
	 *
	 */
	public static function request( $vars ) {
		if( isset( $vars['gallery'] ) ) $vars['gallery'] = true;
			return $vars;   
	}

	/**
	 *
	 */
	public static function init() {
		add_rewrite_endpoint( 'gallery', EP_PERMALINK );
	}
}


/**
 *
 */
register_activation_hook( __FILE__, 'post_to_gallery_activation' );
function post_to_gallery_activation() {
	Post_To_Gallery::initialize();
	flush_rewrite_rules();
}

/**
 *
 */
register_deactivation_hook( __FILE__, 'post_to_gallery_deactivation' );
function post_to_gallery_deactivation() {
	flush_rewrite_rules();
}

?>