<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

include "inc.php";
include "def.php";

define( 'STATIC_CACHE_LIFE', 3600*24 );                   //缓存文件的生命期，单位秒，86400秒是一天
define( 'STATIC_CACHE_SUFFIX','.html' );             //缓存文件的扩展名，千万别用 .php .asp .jsp .pl 等等

$cache_file_suffix = STATIC_CACHE_SUFFIX ;
$cache_file_lifetime = 	STATIC_CACHE_LIFE ; // 更新周期24小时
$is_xml_request = false;
if( strtolower(substr($_SERVER['REQUEST_URI'],-4,4)) == '.xml' ){ // 请求的是XML文件
	$is_xml_request = true;
}
if( $is_xml_request ){
	$cache_file_suffix = '.xml';
	$cache_file_lifetime = STATIC_CACHE_LIFE;  // XML时间缓存1天(24小时)
}

$protocol = ecpt_wp_static_cache_is_ssl_request()?'https://':'http://';

$cache_file_name  = md5( $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) ;
if(static_cache_is_from_mobile_device()) // 手机端
	$cache_file_name .= '.mobile';


$cache_file_name .= $cache_file_suffix;    //缓存文件名
$cache_dir  = WP_STATIC_CACHE_FILES_ROOT.'/'.substr( $cache_file_name,0,2 ) . '/'  . substr( $cache_file_name,2,2 );
$cache_file = $cache_dir.'/'.$cache_file_name;    //缓存文件存放路径

if( $_SERVER['REQUEST_METHOD']=='GET' && ecpt_wp_static_cache_url_could_cache( $_SERVER['REQUEST_URI'] ) ){      //GET方式请求才缓存，POST之后一般都希望看到最新的结果
	if(file_exists( $cache_file ) && time() - filemtime($cache_file) < $cache_file_lifetime){   //如果缓存文件存在，并且没有过期，就把它读出来。
		//include( $cache_file );
		if( $is_xml_request ) // 如果是XML请求, 改定HEADER.
			header('Content-Type:application/xml');
			
		$fp = fopen($cache_file,'rb');
        fpassthru($fp);
		fclose($fp);
		die();
	}
	@ecpt_wp_static_cache_mkdirs( $cache_dir );
	ob_start('ecpt_wp_static_cache_cache_file');                 //回调函数 auto_cache
}
function ecpt_wp_static_cache_cache_file($contents){         //回调函数，当程序结束时自动调用此函数
	global $cache_file,$protocol;
	$request = '<!--' . $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ' generated at ' . current_time('mysql') . ' by wp static cache version ' . WP_STATIC_CACHE_VERSION . '-->';

	$fp = fopen($cache_file,'wb');
	fwrite($fp,$contents);
	fwrite($fp,$request);
	fclose($fp);
	//chmod($cache_file,0777);
	return $contents;
}
?>