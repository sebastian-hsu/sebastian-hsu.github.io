<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

if ( ! defined( 'WP_CONTENT_DIR' ) 	) 	
	define( 'WP_CONTENT_DIR'	, ABSPATH . 'wp-content' );

define( 'WP_STATIC_CACHE_FILES_DIR_NAME' , 'static-cache-files' );
define( 'WP_STATIC_CACHE_FILES_ROOT', WP_CONTENT_DIR . '/' . WP_STATIC_CACHE_FILES_DIR_NAME );
define( 'WP_STATIC_CACHE_VERSION','2016.10.31');

function ecpt_wp_static_cache_mkdirs( $dir )
{
	if(!is_dir( $dir ) )
	{
		if(!ecpt_wp_static_cache_mkdirs(dirname($dir))){
			return false;
		}
		if(!@mkdir($dir,0777)){
			return false;
		}
	}
	return true;
}
function ecpt_wp_static_cache_url_could_cache( $request ){
	global $ecpt_wp_static_cache_url_filter;
	if( $request == '/' ) return true;
	foreach( $ecpt_wp_static_cache_url_filter as $filter ){
		if( strstr( $request, $filter ) )
			return false;
	}
	return true;
}
function ecpt_wp_static_cache_is_ssl_request() 
{
	if ( isset( $_SERVER['HTTPS'] ) ) {
		if ( 'on' == strtolower( $_SERVER['HTTPS'] ) ) {
			return true;
		}

		if ( '1' == $_SERVER['HTTPS'] ) {
			return true;
		}
	} elseif ( isset($_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
		return true;
	}
	return false;
}
?>