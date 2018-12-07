<?php
/*
Plugin Name: WP Static Cache
Plugin URI: http://www.myim.cn/
Description: A very simple and fast caching engine for WordPress that produces static html files for your site.
Author: MyIM
Author URI: http://www.myim.cn/
Version: 1.0.0
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

define("WP_STATIC_CACHE_LOADED", true);
define("WP_STATIC_CACHE_FILE", __FILE__);
define("WP_STATIC_CACHE_DEBUG", true);

define( "WP_STATIC_CACHE_PLUGIN_TITLE" 		, "Static Cache" );
define( "WP_STATIC_CACHE_PLUGIN_NAME" 		, "Static Cache" );

if ( ! defined( 'WP_CONTENT_DIR' ) 	) 	
	define( 'WP_CONTENT_DIR'	, ABSPATH . 'wp-content' );

define( "WP_STATIC_CACHE_PLUGIN_DIR"			, trailingslashit( dirname( __FILE__ ) ) );
define( "WP_STATIC_CACHE_PLUGIN_CORE_DIR"		, WP_STATIC_CACHE_PLUGIN_DIR.'core/' );
define( "WP_STATIC_CACHE_PLUGIN_URL"			, plugin_dir_url( __FILE__ ) );

include_once "core/inc.php";

if( !function_exists( "ecpt_wp_static_cache_replace_line" ) )
{
	// reference code from wp-super-cache
	function ecpt_wp_static_cache_replace_line($old, $new, $my_file) {
		if ( @is_file( $my_file ) == false ) {
			return false;
		}
		if (!ecpt_wp_static_cache_is_writeable_ACLSafe($my_file)) {
			echo "Error: file $my_file is not writable.\n";
			return false;
		}
		$found = false;
		$lines = file($my_file);
		foreach( (array)$lines as $line ) {
			if ( preg_match("/$old/", $line)) {
				$found = true;
				break;
			}
		}
		if ($found) {
			$fd = fopen($my_file, 'w');
			foreach( (array)$lines as $line ) {
				if ( !preg_match("/$old/", $line))
					fputs($fd, $line);
				else {
					fputs($fd, "$new //Added by WP-Static-Cache\n");
				}
			}
			fclose($fd);
			return true;
		}
		$fd = fopen($my_file, 'w');
		$done = false;
		foreach( (array)$lines as $line ) {
			if ( $done || !preg_match('/^(if\ \(\ \!\ )?define|\$|\?>/', $line) ) {
				fputs($fd, $line);
			} else {
				fputs($fd, "$new //Added by WP-Static-Cache\n");
				fputs($fd, $line);
				$done = true;
			}
		}
		fclose($fd);
		return true;
	}
}
if( !function_exists( "ecpt_wp_static_cache_is_writeable_ACLSafe" ) )
{
	// from legolas558 d0t users dot sf dot net at http://www.php.net/is_writable
	function ecpt_wp_static_cache_is_writeable_ACLSafe($path) {
		// PHP's is_writable does not work with Win32 NTFS
		if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
			return ecpt_wp_static_cache_is_writeable_ACLSafe($path.uniqid(mt_rand()).'.tmp');
		else if (is_dir($path))
			return ecpt_wp_static_cache_is_writeable_ACLSafe($path.'/'.uniqid(mt_rand()).'.tmp');
		// check tmp file for read/write capabilities
		$rm = file_exists($path);
		$f = @fopen($path, 'a');
		if ($f===false)
			return false;
		fclose($f);
		if (!$rm)
			unlink($path);
		return true;
	}
}
//启用插件时的操作
function ecpt_wp_static_cache_activate()
{
	@mkdir(WP_STATIC_CACHE_FILES_ROOT,0755);
	// 将advanced-cache.php拷贝到wp-content下
	$dst = WP_CONTENT_DIR . '/advanced-cache.php';
	$src = WP_STATIC_CACHE_PLUGIN_DIR . 'advanced-cache.php';
	@copy( $src, $dst );

	if ( file_exists( ABSPATH . 'wp-config.php') ) {
		$global_config_file = ABSPATH . 'wp-config.php';
	} else {
		$global_config_file = dirname(ABSPATH) . '/wp-config.php';
	}
	
	$wp_cache_line = 'define(\'WP_CACHE\', true);';
	if (!ecpt_wp_static_cache_is_writeable_ACLSafe($global_config_file) 
		|| !ecpt_wp_static_cache_replace_line('define *\( *\'WP_CACHE\'', $wp_cache_line, $global_config_file) ) {
		if ( defined( 'WP_CACHE' ) && constant( 'WP_CACHE' ) == false ) {
			echo '<div id="message" class="updated fade">' . __( "<h3>WP_CACHE constant set to false</h3><p>The WP_CACHE constant is used by WordPress to load the code that serves cached pages. Unfortunately, it is set to false. Please edit your wp-config.php and add or edit the following line above the final require_once command:<br /><br /><code>define('WP_CACHE', true);</code></p>", 'wp-static-cache' ) . "</div>";
		} else {
			echo "<p>" . __( "<strong>Error: WP_CACHE is not enabled</strong> in your <code>wp-config.php</code> file and I couldn&#8217;t modify it.", 'wp-static-cache' ) . "</p>";;
			echo "<p>" . sprintf( __( "Edit <code>%s</code> and add the following line:<br /> <code>define('WP_CACHE', true);</code><br />Otherwise, <strong>WP-Cache will not be executed</strong> by WordPress core. ", 'wp-static-cache' ), $global_config_file ) . "</p>";
		}
		return false;
	}
	
	$wp_static_cache_line = 'define(\'WP_STATIC_CACHE_PLUGIN_HOME\', \'' . WP_STATIC_CACHE_PLUGIN_DIR . '\' );';
	if ( !ecpt_wp_static_cache_is_writeable_ACLSafe($global_config_file) 
		|| !ecpt_wp_static_cache_replace_line('define *\( *\'WP_STATIC_CACHE_PLUGIN_HOME\'', $wp_static_cache_line, $global_config_file ) ) {
			echo '<div id="message" class="updated fade"><h3>' . __( 'Warning', 'wp-static-cache' ) . "! <em>" . sprintf( __( 'Could not update %s!</em> WP_STATIC_CACHE_PLUGIN_HOME must be set in config file.', 'wp-static-cache' ), $global_config_file ) . "</h3>";
			return false;
	}

	
	return true;
}
function ecpt_wp_static_cache_deactivate()
{
	if ( file_exists( ABSPATH . 'wp-config.php') ) {
		$global_config_file = ABSPATH . 'wp-config.php';
	} else {
		$global_config_file = dirname(ABSPATH) . '/wp-config.php';
	}
	
	$line = 'define(\'WP_CACHE\', true);';
	if ( strpos( file_get_contents( $global_config_file ), $line ) 
		&& ( !ecpt_wp_static_cache_is_writeable_ACLSafe( $global_config_file ) 
			|| !ecpt_wp_static_cache_replace_line( 'define *\( *\'WP_CACHE\'', '//' . $line, $global_config_file ) 
			) 
		)
		wp_die( "Could not remove WP_CACHE define from $global_config_file. Please edit that file and remove the line containing the text 'WP_CACHE'. Then refresh this page." );
}

// 插件被启用时的动作
register_activation_hook(		WP_STATIC_CACHE_FILE	, 'ecpt_wp_static_cache_activate');
register_deactivation_hook ( 	WP_STATIC_CACHE_FILE	, 'ecpt_wp_static_cache_deactivate');

function ecpt_wp_static_cache_options_page()
{
	add_menu_page( WP_STATIC_CACHE_PLUGIN_TITLE, WP_STATIC_CACHE_PLUGIN_TITLE	, "manage_options", 'cachemange'	, 'ecpt_wp_static_cache_manage' );
	add_submenu_page( 'cachemange', 'Cache manager - ' . WP_STATIC_CACHE_PLUGIN_TITLE	, 'Cahce Manager'		, "manage_options", 'cachemange'	,'ecpt_wp_static_cache_manage' );
	add_submenu_page( 'cachemange', 'Set up filter - ' . WP_STATIC_CACHE_PLUGIN_TITLE	, 'Set up filter'		, "manage_options", 'setupfilter'	,'ecpt_wp_static_cache_setup_filter' );
}
function ecpt_wp_static_cache_manage()
{
	include ( "core/ecpt-wp-static-cache-view-page-cache.php" );
	dp_ecpt_wp_static_cache_view_page_cache();
}

function ecpt_wp_static_cache_setup_filter()
{
	include ( "core/ecpt-wp-static-cache-setup-filter.php" );
	do_ecpt_wp_static_cache_setup_filter();
}
// 后台菜单事件
add_action( 'admin_menu', 'ecpt_wp_static_cache_options_page' ,999 );
