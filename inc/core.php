<?php

/**
 * Core plugin functionality.
 * @package WPInfomate
 *
 */

namespace WPInfomate\Core;

/*
 * Default setup function
 * return void
 */
function load() {

	$name_space = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $name_space( 'wpinfomate_init' ) );
	add_action( 'admin_menu', $name_space( 'wpinfomate_admin_menu' ) );
	add_action( 'admin_enqueue_scripts', $name_space( 'admin_scripts' ) );
	add_action( 'admin_enqueue_scripts', $name_space( 'admin_styles' ) );

	do_action( 'wpinfomate_loaded' );
}

function wpinfomate_init() {

	do_action( 'wpinfomate_init' );

}

/**
 * Activate the plugin
 *
 * @return void
 */
function activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	init();
	flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {

}

/*
 * Add admin menu page
 */
function wpinfomate_admin_menu() {

	add_menu_page(
		__( 'WPInfomate', WPINFO_TEXT_DOMAIN ),
		__( 'WPInfo', WPINFO_TEXT_DOMAIN ),
		'manage_options',
		WPINFO_TEXT_DOMAIN,
		"\WPInfomate\Core\display_wpinfomate_admin",
		'dashicons-info'
	);

}

/*
 * Admin menu page display
 */

function display_wpinfomate_admin() {
	?>
    <div id="wp-info-admin"></div>
	<?php
}

/**
 * Enqueue admin scripts
 * @return void
 */
function admin_scripts() {


	wp_enqueue_script(
		WPINFO_TEXT_DOMAIN . '-admin-scripts',
		WPINFO_PLUGIN_URL . 'assets/js/admin.js',
		[],
		WPINFO_VERSION
	);

	wp_localize_script(
		WPINFO_TEXT_DOMAIN . '-admin-scripts',
		'wpr_object',
		array(
			'api_nonce' => wp_create_nonce( 'wp_rest' ),
			'api_url'   => rest_url( WPINFO_TEXT_DOMAIN . '/v/1/' )
		)
	);
}

/*
 * Enqueue admin styles
 * @return void
 */

function admin_styles() {

	wp_enqueue_style(
		'wpinfomate-admin-styles',
		WPINFO_PLUGIN_URL . 'assets/css/admin.css',
		[],
		WPINFO_VERSION
	);
}

