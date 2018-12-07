<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

if( defined( 'WP_CACHE' ) && WP_CACHE === true && defined( 'WP_STATIC_CACHE_PLUGIN_HOME' ) )
	WP_DEBUG ? include_once( WP_STATIC_CACHE_PLUGIN_HOME . 'static-cache.php' ) : @include_once( WP_STATIC_CACHE_PLUGIN_HOME . 'static-cache.php' );
?>