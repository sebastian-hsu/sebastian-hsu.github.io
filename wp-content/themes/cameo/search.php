<?php
/**
 * The main template file for display blog page.
 *
 * @package WordPress
*/

get_header(); 

//Include custom header feature
get_template_part("/templates/template-header");
?>

<?php
$page_sidebar = 'Search Sidebar';
?>

<!-- Begin content -->
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">

    			<div class="content">
    			
    			<div class="search_form_wrapper">
						<?php //esc_html_e( "If you didn't find what you were looking for, try a new search.", 'photography-translation' ); ?>
						<?php if (ICL_LANGUAGE_CODE == 'zh-hant'): ?>
						 <div class="search_text">以下顯示搜尋結果</div>
						 <div class="search_text_d">搜尋「<span><?php the_search_query(); ?></span>」結果</div>
						<?php elseif (ICL_LANGUAGE_CODE == 'en'): ?>
					<div class="search_text">The search results are shown below</div>
						 <div class="search_text_d">Search「<span><?php the_search_query(); ?></span>」results</div>
							<?php endif; ?>
	    			<!-- <form class="searchform" method="get" action="<?php echo esc_url(home_url('/')); ?>">
						<input style="width:100%" type="text" class="field searchform-s" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_html_e('Type to search and hit enter...', 'photography-translation' ); ?>">
					</form> -->
    			</div>
					
<?php
if (have_posts()) : while (have_posts()) : the_post();
?>

<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
			<div class="one">
				<?php
					$post_type = get_post_type();
					$post_type_class = '';
					$post_type_title = '';
					
					switch($post_type)
					{
					    case 'galleries':
					    	$post_type_class = '<i class="fa fa-picture-o"></i>';
					    	$post_type_title = esc_html__('Gallery', 'photography-translation' );
					    break;
					    
					    case 'page':
					    default:
					    	$post_type_class = '<i class="fa fa-file-text-o"></i>';
					    	$post_type_title = esc_html__('Page', 'photography-translation' );
					    break;
					    
					    case 'projects':
					    	$post_type_class = '<i class="fa fa-folder-open-o"></i>';
					    	$post_type_title = esc_html__('Projects', 'photography-translation' );
					    break;
					    
					    case 'services':
					    	$post_type_class = '<i class="fa fa-star"></i>';
					    	$post_type_title = esc_html__('Service', 'photography-translation' );
					    break;
					    
					    case 'clients':
					    	$post_type_class = '<i class="fa fa-user"></i>';
					    	$post_type_title = esc_html__('Client', 'photography-translation' );
					    break;
					}
					
					$post_thumb = array();
					if(has_post_thumbnail($post->ID, 'thumbnail'))
					{
					    $image_id = get_post_thumbnail_id($post->ID);
					    $post_thumb = wp_get_attachment_image_src($image_id, 'thumbnail', true);
					    
					    if(isset($post_thumb[0]) && !empty($post_thumb[0]))
					    {
					        $post_type_class = '<div class="search_thumb"><img src="'.esc_url($post_thumb[0]).'" alt=""/></div>';
					    }
					}
				?>
				
			
			    <div class="post_header search">
			    	<h6><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>
			    	<div class="post_detail">
					    <?php echo get_the_time(THEMEDATEFORMAT); ?>
					    <?php
					    	//Get Post's Categories
					    	$post_categories = wp_get_post_categories($post->ID);
					    	if(!empty($post_categories))
					    	{
					    ?>
					    	<?php //echo esc_html_e('In', 'photography-translation' ); ?>
					    <?php
					        	foreach($post_categories as $c)
					        	{
					        		$cat = get_category( $c );
					    ?>
					        	
					    <?php
					        	}
					        }
					    ?>
					</div>
				    
				    <?php
				    	echo photography_substr(strip_tags(strip_shortcodes(get_the_content())), 200);
				    ?>
			    </div>
			</div>
	    </div>
	    
	</div>

</div>
<br class="clear"/>
<!-- End each blog post -->

<?php endwhile; endif; ?>

    	<?php
		    if($wp_query->max_num_pages > 1)
		    {
		    	if (function_exists("photography_pagination")) 
		    	{
		?>
				<br class="clear"/><br/>
		<?php
		    	    photography_pagination($wp_query->max_num_pages);
		    	}
		    	else
		    	{
		    	?>
		    	    <div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
		    	<?php
		    	}
		    ?>
		    <div class="pagination_detail">
		     	<?php
		     		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		     	?>
		     	<?php esc_html_e('Page', 'photography-translation' ); ?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'photography-translation' ); ?> <?php echo esc_html($wp_query->max_num_pages); ?>
		     </div>
		     <?php
		     }
		?>
    	</div>
    	
    		
    	
    </div>
    <!-- End main content -->
    </div>
	
</div>
</div>
<?php get_footer(); ?>