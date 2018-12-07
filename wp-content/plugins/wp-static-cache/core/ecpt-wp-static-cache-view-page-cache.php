<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

function dp_ecpt_wp_static_cache_view_page_cache() 
{
	global $wpdb;
	if( !current_user_can("manage_options") )
		wp_die(__('Sorry, but you have no permissions to change settings.'));
	
	$where = ' WHERE 1';
	/* ########## the 'order' part ########## */
	$order	= '';
	$sort 	= '';
	$order_val 	= array('t', 'count');
	$cache_file = '';
	$cache_url = '';
	if( isset( $_REQUEST['keyword'] ) && $_REQUEST['keyword'] != '' ) {
		$cache_file_name  = md5( $_REQUEST['keyword'] ). STATIC_CACHE_SUFFIX;    //缓存文件名
		$cache_dir  = WP_STATIC_CACHE_FILES_ROOT.'/'.substr( $cache_file_name,0,2 ) . '/'  . substr( $cache_file_name,2,2 );
		$cache_file = $cache_dir.'/'.$cache_file_name;    //缓存文件存放路径
		$cache_url = content_url() .'/' . WP_STATIC_CACHE_FILES_DIR_NAME . '/' . substr( $cache_file_name,0,2 ) . '/'  . substr( $cache_file_name,2,2 ) .'/'. $cache_file_name;
		if( !is_file( $cache_file ) ){
			$cache_file = '';
			$cache_url = '';
		}
	}
	if( isset($_REQUEST['call']) && $_REQUEST['call'] == 'delete' && isset($_REQUEST['url']) ) {
		$cache_file_name  = md5( $_REQUEST['url'] ). STATIC_CACHE_SUFFIX;    //缓存文件名
		$cache_dir  = WP_STATIC_CACHE_FILES_ROOT.'/'.substr( $cache_file_name,0,2 ) . '/'  . substr( $cache_file_name,2,2 );
		$cache_file = $cache_dir.'/'.$cache_file_name;    //缓存文件存放路径
		@unlink( $cache_file );
		$result1 = 'Chaching file has been deleted!';
	} 
	if( isset($_REQUEST['call']) && $_REQUEST['call'] == 'deleteall' )
	{
		dp_ecpt_wp_static_cache_delete_sub_dir( WP_STATIC_CACHE_FILES_ROOT );
		$result1 = 'All chaching file has been deleted!';
	}
	
	$imgdele = '<img src="'.WP_STATIC_CACHE_PLUGIN_URL . 'img/delete.gif" alt="删除此缓存" title="删除此缓存"/>';
?>
	<script type="text/javascript">
	function doDelete( )
	{
		ret = confirm("你确定要删除这个缓存?");
		if(ret)
			return true;
		else
			return false;
	}
	</script>
	<div class="wrap">
		<h2><?php echo WP_STATIC_CACHE_PLUGIN_NAME;?></h2>
		<h3>Caching files manager</h3>
		<?php
		if(isset($err))
		{?>
			<div class="error fade"><p><b><?php _e('Error :', 'unp_lang')?></b><ul><?php echo $err;?></ul></p></div>
		<?php
		}

		if(isset($result1))
		{?>
			<div id="message" class="updated fade"><p><?php if(is_string($result1)) echo "<ul>".$result1."</ul>"; else echo "";?></p></div>
		<?php }?>
		
		<form name="form1" id="form1" method="post" action="" onsubmit="return chkbulkfrm()">
		<?php wp_nonce_field('manage-cache-campaign'); ?>
		<p class="search-box">
		<input type="search" value="" name="keyword" id="post-search-input" placeholder="URL, e.g.:http://www.google.com/ " style="width:400px;">
		<input type="submit" value="Search Caching file" class="button" id="search-submit" name=""></p>
		
		<!-- ================== -->
		<div><b>Caching root: <?php echo WP_STATIC_CACHE_FILES_ROOT;?><br/>
		Cached directories: <?php echo dp_ecpt_wp_static_cache_count_dir( WP_STATIC_CACHE_FILES_ROOT );?><br/>
		Caching file life-time: <?php echo STATIC_CACHE_LIFE;?> seconds <br />
		Caching file postfix: <?php echo STATIC_CACHE_SUFFIX;?><br/>
		<p><a href="/wp-admin/admin.php?page=cachemange&call=deleteall" class="button button-primary">Clear all caching files</a></p>
		</b></div>
		<table class="form-table widefat" id="unp_manage_campaign">
		<thead>
		<tr>
		<th align="center" style="white-space: nowrap;">Url of Caching file</th>
		<th align="center" style="white-space: nowrap;">Directory</th>
		<th align="center" style="white-space: nowrap;">Action</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if( $cache_file && $cache_url ){?>
			<tr>
				<td><a href="<?php echo $cache_url;?>" target="_blank"><?php echo $cache_url;?></a></td>
				<td><?php echo $cache_file;?></td>
				<td><a href="/wp-admin/admin.php?page=cachemange&call=delete&url=<?php echo $_REQUEST['keyword'];?>" onclick="javascript:return doDelete()" title="Delete"><?php echo $imgdele;?></a></td>
			</tr>
		<?php }
		else
		{
			?>
			<tr>
			<td>Can not find caching file.</td>
			<td>-</td>
			<td>-</td>
			</tr>
			<?php
		}?>
		</tbody>
		</table>
		</form>
		</div><br/>
	<?php
}
function dp_ecpt_wp_static_cache_delete_sub_dir( $path ) 
{
    $op = @dir( $path );
    while(false != ($item = $op->read())) 
	{
        if($item == '.' || $item == '..') {
            continue;
        }
		
        if(is_dir( $op->path . '/' . $item) ) 
		{
            dp_ecpt_wp_static_cache_delete_sub_dir($op->path.'/'.$item);
			
            @rmdir($op->path.'/'.$item);
        } else {
            @unlink($op->path.'/'.$item);
        }
    }   
}
function dp_ecpt_wp_static_cache_count_dir( $dir )
{
    if ($handle = @opendir($dir)){
        $count = 0;
        while (false !== ( $item = @readdir($handle)) ) {
            if (is_dir( $dir . '/' . $item ) and $item != '.' and $item != '..' ){
                $count ++;
            }
        }
        @closedir( $handle );
        return $count;
    }
	return 0;
} 
?>