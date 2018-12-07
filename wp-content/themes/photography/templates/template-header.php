<?php
/**
*	Get Current page object
**/

if(!is_null($post))
{
	$page_obj = get_page($post->ID);
}

$current_page_id = '';

/**
*	Get current page id
**/

if(!is_null($post) && isset($page_obj->ID))
{
    $current_page_id = $page_obj->ID;
}

global $photography_topbar;
global $photography_page_content_class;

//Get Page Menu Transparent Option
$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);

//Get page header display setting
$page_title = get_the_title();
$page_show_title = get_post_meta($current_page_id, 'page_show_title', true);

if(is_tag())
{
	$page_show_title = 0;
	$page_title = single_cat_title( '', false );
	$term = 'tag';
} 
elseif(is_category())
{
    $page_show_title = 0;
	$page_title = single_cat_title( '', false );
	$term = 'category';
}
elseif(is_archive())
{
	$page_show_title = 0;

	if ( is_day() ) : 
		$page_title = get_the_date(); 
    elseif ( is_month() ) : 
    	$page_title = get_the_date('F Y'); 
    elseif ( is_year() ) : 
    	$page_title = get_the_date('Y'); 
    elseif ( !empty($term) ) : 
    	$ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    	$page_taxonomy = get_taxonomy($ob_term->taxonomy);
    	$page_title = $ob_term->name;
    else :
    	$page_title = esc_html__('Blog Archives', 'photography-translation'); 
    endif;
    
    $term = 'archive';
    
}
else if(is_search())
{
	$page_show_title = 0;
	$page_title = esc_html__('Search', 'photography-translation' );
	$term = 'search';
}

global $photography_hide_title;
if($photography_hide_title == 1)
{
	$page_show_title = 1;
}

global $photography_screen_class;
if($photography_screen_class == 'split' OR $photography_screen_class == 'single_client')
{
	$page_show_title = 0;
}
if($photography_screen_class == 'single_client')
{
	$page_show_title = 1;
	
	if(class_exists('MultiPostThumbnails'))
	{
		$pp_page_bg = MultiPostThumbnails::get_post_thumbnail_url('clients', 'cover-image', $current_page_id);
		
		if(!empty($pp_page_bg))
		{
			$page_show_title = 0;
		}
	}
}

if(empty($page_show_title))
{
	//Get current page tagline
	$page_tagline = get_post_meta($current_page_id, 'page_tagline', true);
	
	if(is_category())
	{
		$page_tagline = category_description();
	}
	
	if(is_tag())
	{
		$page_tagline = category_description();
	}
	
	if(is_single() && $post->post_type == 'galleries')
	{
		$page_tagline = get_the_excerpt();
	}
	
	if(is_single() && $post->post_type == 'clients')
	{
		$page_tagline = $post->post_content;
	}

	if(is_archive() && get_query_var( 'taxonomy' ) == 'gallerycat')
	{
		$page_tagline = $ob_term->description;
	}
	
	if(is_archive() && get_query_var( 'taxonomy' ) == 'eventcat')
	{
		$page_tagline = $ob_term->description;
	}
	
	if(is_search())
	{
		$page_tagline = esc_html__('Search Results for ', 'photography-translation' ).get_search_query();
	}

	$pp_page_bg = '';
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full') && empty($term))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        }
    }
    
    //If on client post type page
	if(is_single() && $post->post_type == 'clients' && class_exists('MultiPostThumbnails'))
	{
		$pp_page_bg = MultiPostThumbnails::get_post_thumbnail_url('clients', 'cover-image', $current_page_id);
	}
    
    //Check if add blur effect
	$tg_page_title_img_blur = kirki_get_option('tg_page_title_img_blur');
	
	$tg_page_title_font_alignment = kirki_get_option('tg_page_title_font_alignment');
	$tg_page_title_bg_vertical_alignment = kirki_get_option('tg_page_title_bg_vertical_alignment');
?>
<div id="page_caption" class="<?php if(!empty($pp_page_bg)) { ?>hasbg parallax <?php echo esc_attr($tg_page_title_bg_vertical_alignment); ?> <?php } ?> <?php if(!empty($photography_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($photography_screen_class)) { echo esc_attr($photography_screen_class); } ?> <?php if(!empty($photography_page_content_class)) { echo esc_attr($photography_page_content_class); } ?>">
	<?php if(!empty($pp_page_bg)) { ?>
		<div id="bg_regular" style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"></div>
	<?php } ?>
	<?php
	    if(!empty($tg_page_title_img_blur) && !empty($pp_page_bg) && $photography_screen_class != 'split')
	    {
	?>
	<div id="bg_blurred" style="background-image:url(<?php echo admin_url('admin-ajax.php').'?action=photography_blurred&src='.esc_url($pp_page_bg); ?>);"></div>
	<?php
	    }
	?>
	
	<?php
		if($photography_screen_class == 'split')
		{
	?>
	<div class="bg_frame_split"></div>
	<?php
		}
	?>

	<?php
		if($photography_screen_class == 'split' OR $photography_screen_class == 'split wide')
		{
			$page_show_title = 1;	
		}
		
		if(empty($page_show_title))
		{
	?>
	<div class="page_title_wrapper">
		<div class="page_title_inner <?php if($tg_page_title_font_alignment == 'left' OR $tg_page_title_font_alignment == 'right') { ?>standard_wrapper<?php } ?>">
			<?php
			if(is_single() && $post->post_type == 'clients')
			{
				//Get client thumbnail
				$client_thumbnail = '';
				if(has_post_thumbnail($current_page_id, 'thumbnail') && empty($term))
			    {
			        $image_id = get_post_thumbnail_id($current_page_id); 
			        $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail', true);
			        
			        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
			        {
			        	$client_thumbnail = $image_thumb[0];
			        }
			    }
			    
			    if(!empty($client_thumbnail))
			    {
			?>
				<div class="client_thumbnail">
					<img src="<?php echo esc_url($client_thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"/>
				</div>
			<?php
			    }
			} // if single client page
			?>
			
			<?php
			if(!empty($client_thumbnail))
			{
			?>
				<div class="client_header_info">
			<?php
			}
			?>
				<h1 <?php if(!empty($pp_page_bg) && !empty($photography_topbar)) { ?>class ="withtopbar"<?php } ?>><?php echo esc_html($page_title); ?></h1>
				<?php
			    	if(!empty($page_tagline))
			    	{
			    ?>
			    	<?php
				    	$tg_page_tagline_alignment = kirki_get_option('tg_page_tagline_alignment');
		
			    		if(empty($pp_page_bg)) 
			    		{
			    	?>
			    		<hr class="title_break">
			    	<?php
			    		}
			    	?>
			    	<div class="page_tagline">
			    		<?php echo wp_kses_post($page_tagline); ?>
			    	</div>
			    <?php
			    	}
			    ?>
			<?php
			if(!empty($client_thumbnail))
			{
			?>
				</div>
			<?php
			}
			?>
		</div>
	</div>
	<?php
		}
	?>

</div>
<?php
}
?>

<!-- Begin content -->
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if(!empty($pp_page_bg) && !empty($photography_topbar)) { ?>withtopbar <?php } ?> <?php if(!empty($photography_page_content_class)) { echo esc_attr($photography_page_content_class); } ?>">