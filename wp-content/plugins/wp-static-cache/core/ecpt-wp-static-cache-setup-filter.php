<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

function ecpt_wp_static_cache_change_to_quotes($str) {
    return sprintf("'%s'\n", $str);
}
function ecpt_wp_static_cache_build_filter_content( $body )
{
	$body = str_replace( "\r","",$body);
	$arr_body = explode( "\n", $body );
	$new_body_string =  implode(',', array_map('ecpt_wp_static_cache_change_to_quotes', $arr_body ));
	
	$content = '<?php' . "\n";
	$content .= '// 过滤器, 过滤掉的uri不被CACHE' . "\n";
	$content .= '$ecpt_wp_static_cache_url_filter = array(' . "\n";
	$content .= $new_body_string;
	$content .= ")\n?>\n";
	return $content;
}

function do_ecpt_wp_static_cache_setup_filter() 
{
	global $wpdb;
	if( !current_user_can("manage_options") )
		wp_die(__('Sorry, but you have no permissions to change settings.'));

	$def_file = WP_STATIC_CACHE_PLUGIN_CORE_DIR . 'def.php';
	
	if( isset( $_POST['filters'] ) )
	{
		$filters_content = trim($_POST['filters']);
		if( empty( $filters_content ) )
			file_put_contents( $def_file, ' ' );
		else 
		{
			file_put_contents( $def_file, ecpt_wp_static_cache_build_filter_content( $filters_content )  );
		}
	}
	
	$filters = file_get_contents( $def_file );
	$exist_string = '';
	
	if( !empty( $filters ) )
	{
		preg_match_all( "/\'(.+?)\'/si",$filters,$matches );
		$exist_string = implode( "\n",$matches[1] );
	}
?>
	<div class="wrap">
		<h2><?php echo WP_STATIC_CACHE_PLUGIN_NAME;?></h2>
		<h3>修改过滤器</h3>
		<div><b>请将不希望被生成静态缓存的网站目录列在下边, 一行一个:</b></div>
		<form name="form1" id="form1" method="post" action="">
		<?php wp_nonce_field('setup-cache-filter'); ?>
		
		<!-- ================== -->
		<div>
		<textarea rows="10" cols="80" id="filters" name="filters"><?php echo $exist_string; ?></textarea>
		</div>
		<input type="submit" value="保存" class="button-secondary action" />
		</form>
		</div><br/>
	<?php
}
?>