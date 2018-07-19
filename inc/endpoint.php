<?php

/**
 * REST API Endpoint for Sever Information
 * @package WPInfomate
 *
 */

namespace WPInfomate\Rest;

/*
* Register hooks to inti Rest API
*/

function register_hooks(){

	add_action('rest_api_init','WPInfomate\Rest\register_rest_endpoints');

}

function register_rest_endpoints(){

	$version = '1';
	$namespace = WPINFO_TEXT_DOMAIN.'/v/'.$version;

	$name_space = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	register_rest_route( $namespace, 'server', array(
		array(
			'methods'               => \WP_REST_Server::READABLE,
			'callback'              => $name_space( 'get_server_info' ), // Set to our renamed 'get' callback function
			'permission_callback'   => $name_space( 'admin_permissions_check' ),
			'args'                  => array(),
		),
	) );

	register_rest_route( $namespace, 'wpinfo', array(
		array(
			'methods'               => \WP_REST_Server::READABLE,
			'callback'              => $name_space( 'get_wp_info' ), // Set to our renamed 'get' callback function
			'permission_callback'   => $name_space( 'admin_permissions_check' ),
			'args'                  => array(),
		),
	) );

}

function get_server_info( $request ){

	global $wpdb;

	$data = array(

		'os' => php_uname('s'),
		'server_ip' => $_SERVER['SERVER_ADDR'],
		'server_hostname' => php_uname('n'),
		'server_protocol' => $_SERVER['SERVER_PROTOCOL'],
		'server_admin' => $_SERVER['SERVER_ADMIN'],
		'server_port' => $_SERVER['SERVER_PORT'],
		'php_version' => phpversion(),
		'mysql_version' => $wpdb->db_version(),
		'php_memory_limit' => ini_get('memory_limit'),
		'cgi_version' => $_SERVER['GATEWAY_INTERFACE'],
		'uptime' => exec("uptime", $system)
	);
	$response = array();

	foreach ( $data as $key => $value ){
		$info = array(
			'name' => $key,
			'value' => $value
		);

		array_push( $response, $info);
	}


	return new \WP_REST_Response( $response );
}

function get_wp_info(){

	$data = array(
		'active_theme' => esc_html(wp_get_theme()->get('Name')),
		'hostname' => DB_HOST,
		'db_username' => DB_USER,
		'db_name' => DB_NAME,
		'db_charset' => DB_CHARSET,
		'debugging' => WP_DEBUG ? "Enabled" : "Disabled",
		'memory_limit' => WP_MEMORY_LIMIT
	);

	$response = array();

	foreach ( $data as $key => $value ){
		$info = array(
			'name' => $key,
			'value' => $value
		);

		array_push( $response, $info);
	}


	return new \WP_REST_Response( $response );

}

function admin_permissions_check( $request ){
	return current_user_can('manage_options');
}