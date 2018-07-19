<?php

/*
Plugin Name: WPInfoMate
Plugin URI: http://dasun.blog/infomate
Description: A small plugin to check your site's Configurations Info
Author: dazunj
Author URI: http://dasun.blog
License: GPL v3
*/

/*
 * Useful constants
 */

define( 'WPINFO_VERSION', '1.0.0' );
define( 'WPINFO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPINFO_PLUGIN_PATH', dirname( __FILE__ ) . '/' );
define( 'WPINFO_PLUGIN_INC', WPINFO_PLUGIN_PATH . 'inc/' );
define( 'WPINFO_TEXT_DOMAIN', 'wp-infomate' );

// Abort the direct access

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once WPINFO_PLUGIN_INC . 'core.php';
require_once WPINFO_PLUGIN_INC . 'endpoint.php';

// Activation/Deactivation
register_activation_hook( __FILE__, '\WPInfomate\Core\activate' );
register_deactivation_hook( __FILE__, '\WPInfomate\Core\deactivate' );

// Bootstrap

WPInfomate\Core\load();


// Hook the rest end point to plugin

WPInfomate\Rest\register_hooks();