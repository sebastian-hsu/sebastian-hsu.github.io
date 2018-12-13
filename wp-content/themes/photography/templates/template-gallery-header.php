<?php
	global $photography_topbar;
	global $photography_page_content_class;
	
	$tg_gallery_feat_content = kirki_get_option('tg_gallery_feat_content');
	
	$pp_page_bg = '';
	//Get page featured image
	if(has_post_thumbnail($post->ID, 'full') && !empty($tg_gallery_feat_content))
    {
        $image_id = get_post_thumbnail_id($post->ID); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        }
    }
    
    //Check if add blur effect
	$tg_page_title_img_blur = kirki_get_option('tg_page_title_img_blur');
	
	$tg_page_title_font_alignment = kirki_get_option('tg_page_title_font_alignment');
	$tg_page_title_bg_vertical_alignment = kirki_get_option('tg_page_title_bg_vertical_alignment');
?>
<div id="page_caption" class="single_gallery <?php if(!empty($pp_page_bg)) { ?>hasbg parallax  <?php echo esc_attr($tg_page_title_bg_vertical_alignment); ?> <?php } ?>  <?php if(!empty($photography_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($photography_page_content_class)) { echo esc_attr($photography_page_content_class); } ?>">
	
	<?php if(!empty($pp_page_bg)) { ?>
		<div id="bg_regular" style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"></div>
	<?php } ?>
	<?php
	    if(!empty($tg_page_title_img_blur))
	    {
	?>
	<div id="bg_blurred" style="background-image:url(<?php echo admin_url('admin-ajax.php').'?action=photography_blurred&src='.esc_url($pp_page_bg); ?>);"></div>
	<?php
	    }
	?>
	
	<div class="page_title_wrapper">
		<div class="page_title_inner <?php if($tg_page_title_font_alignment == 'left' OR $tg_page_title_font_alignment == 'right') { ?>standard_wrapper<?php } ?>">
			<h1><?php the_title(); ?></h1>
			<?php
				$gallery_excerpt = get_the_excerpt();

		    	if(!empty($gallery_excerpt))
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
		    		<?php echo wp_kses_post($gallery_excerpt); ?>
		    	</div>
		    <?php
		    	}
		    ?>
		</div>
	</div>
</div>

<!-- Begin content -->
<div id="page_content_wrapper" class="<?php if(!empty($photography_page_content_class)) { echo esc_attr($photography_page_content_class); } ?>">
<?php while ( have_posts() ) : the_post(); ?>
        <div class="gallery_cols_content <?php if($photography_page_content_class == 'wide') { ?>standard_wrapper<?php } ?>">
	        <?php the_content(); ?>
	    </div>
<?php endwhile; ?>