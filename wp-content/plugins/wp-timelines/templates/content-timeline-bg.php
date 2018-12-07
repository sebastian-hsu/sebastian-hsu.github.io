<?php
global $style, $post, $ajax_load, $ID, $animations,$posttype,$show_media, $taxonomy,$full_content,$feature_label,$lightbox,$hide_img,$hide_title;
$class = 'filter-'.$ID.'_'.get_the_ID();
if($animations!=''){
	$animations = ' scroll-effect';
}
if($ajax_load==1){ $class .=' de-active';}
$icon = get_post_meta( $post->ID, 'wpex_icon', true ) !='' ? get_post_meta( $post->ID, 'wpex_icon', true ) : 'fa-square no-icon';
$wpex_icon_img = get_post_meta( $post->ID, 'wpex_icon_img', true );
$we_eventcolor = get_post_meta( $post->ID, 'we_eventcolor', true );
$custom_link = wpex_custom_link();
$wpex_felabel ='';
if($feature_label==1){
	$wpex_felabel = get_post_meta( $post->ID, 'wpex_felabel', true );
	if($posttype!='wp-timeline' && $wpex_felabel==''){
		global $year_post;
		if(!isset($year_post) || $year_post==''){
			$wpex_felabel = $year_post = get_the_date('Y');
		}elseif($year_post!= get_the_date('Y')){
			$wpex_felabel = $year_post = get_the_date('Y');
		}
	}
	if($wpex_felabel!=''){
		$class .=' wptl-feature';
	}
}
if($hide_img!=1){
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
	$bg_style = 'style="background-image:url('.esc_url($image_src[0]).');"';
}else{$bg_style = '';}
$hide_lb = false;
?>
<li <?php post_class($class);?> <?php echo 'data-id="filter-'.$ID.'_'.get_the_ID().'"';?>>
	<div class="<?php echo esc_attr($animations);?>">
        <div class="wpex-timeline-label">
            <?php  wpex_tmbigdate();?>
            <div class="timeline-details" <?php echo $bg_style;?>>
            	<div class="bg-inner">
                <?php
				if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					echo wptl_audio_video_iframe();
				}?>
                <div class="tlct-shortdes">
                    <h2 style=" display:inline;">
                        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                            <?php echo '<span class="tlmobile-visible">'.wpex_date_tl().'&nbsp;-&nbsp;</span>';
							if($hide_title!='1'){ the_title();}?>
                        </a>
                    </h2>
                    <?php if((get_post_meta( get_the_ID(), 'wpex_sublabel', true )!='')){
						echo '<div class="wptl-more-meta"><span>'.get_post_meta( get_the_ID(), 'wpex_sublabel', true ).'</span></div>';
					}?>
                    <p><?php  echo wptl_timeline_desc($full_content,$show_media); ?></p>
                    <?php 
                    $cat_html = wptl_show_cat($posttype, $taxonomy);
                    if($cat_html!=''){?>
                    <div class="wptl-more-meta">
                        <?php echo $cat_html;?>
                    </div>
                    <?php }?>
                </div>
                </div>
            </div>
            
            <div class="clearfix"></div>
        </div>
        <div class="wptl-readmore-center">
            <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                <?php echo get_option('wpex_text_conread')!='' ? get_option('wpex_text_conread') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <div class="wpex-timeline-icon">
    	<?php if($wpex_icon_img!=''){ $icon = $icon .' icon-img';}?>
        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><i class="fa <?php echo esc_attr($icon);?>"></i></a>
    </div>
    <?php if($we_eventcolor!=''|| $wpex_icon_img!=''){?>
	<style type="text/css">
		<?php if($wpex_icon_img!=''){?>
		.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa.no-icon:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;}
		<?php }
		if($we_eventcolor!=''){?>
		
		.show-bg li.post-<?php the_ID();?> .wpex-timeline-icon .fa,
		.wpex-timeline-list.show-bg.left-tl li.post-<?php the_ID();?> .wpex-timeline-label .wpex-content-left .wpex-leftdate,
        .show-bg.show-icon .wpex-timeline.style-center > li.post-<?php the_ID();?> .wpex-content-left .wpex-leftdate{ background:<?php echo esc_attr($we_eventcolor);?>}
		.wpex-timeline-list.show-bg .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label:after,
		.show-bg .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label:before,
		.show-bg.show-icon .wpex-timeline.style-center > li.post-<?php the_ID();?> .wpex-timeline-label:after{border-right-color:<?php echo esc_attr($we_eventcolor);?>}
		@media(min-width:768px){
			.show-bg .wpex-timeline.style-center > li.post-<?php the_ID();?>:nth-child(odd) .wpex-timeline-label:before,
			.show-bg.show-icon .wpex-timeline.style-center > li.post-<?php the_ID();?>:nth-child(odd) .wpex-timeline-label:after{ border-left-color:<?php echo esc_attr($we_eventcolor);?>;}
		}
		.show-bg .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-time span:last-child,
		.show-bg.show-icon li.post-<?php the_ID();?> .wpex-timeline-icon .fa:not(.no-icon):before{color:<?php echo esc_attr($we_eventcolor);?>;}
		
		<?php }?>
    </style>
    <?php } ?>
    <?php if($wpex_felabel!=''){
		echo '<div class="wptl-feature-name"><span>'.$wpex_felabel.'</span></div>';
	}?>
    <?php echo isset($year_post) && $year_post!='' ? '<input type="hidden" class="crr-year" value="'.$year_post.'">' : ''; ?>
</li>