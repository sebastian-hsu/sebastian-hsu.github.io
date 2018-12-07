<?php
global $style, $post, $ajax_load, $ID, $animations,$posttype,$show_media, $taxonomy,$full_content,$feature_label,$lightbox,$hide_img,$img_size,$hide_title;
if($img_size==''){ $img_size = 'wptl-320x220';}
$class = 'filter-'.$ID.'_'.get_the_ID();
if($animations!=''){
	$animations = ' scroll-effect';
}
if($ajax_load==1){ $class .=' de-active';}
$icon = get_post_meta( $post->ID, 'wpex_icon', true ) !='' ? get_post_meta( $post->ID, 'wpex_icon', true ) : 'fa-square no-icon';
$wpex_icon_img = get_post_meta( $post->ID, 'wpex_icon_img', true );
if($wpex_icon_img!=''){ $icon .= $icon.' icon-img';}
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
$link_lb = '';
if($lightbox==1){
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
	$link_lb  = isset($image_src[0]) ? $image_src[0] : '';
}
$hide_lb = false;
?>
<li <?php post_class($class);?> <?php echo 'data-id="filter-'.$ID.'_'.get_the_ID().'"';?>>
	<div class="<?php echo esc_attr($animations);?> tl-ani">
        
        <div class="wpex-timeline-label">
            <?php if( ($show_media!='1' && $hide_img!=1 && has_post_thumbnail(get_the_ID())) || ($show_media=='1' && $hide_img!=1 && has_post_thumbnail(get_the_ID()) && wptl_audio_video_iframe()=='<div class="wptl-embed"></div>') ){ ?>
                <a href="<?php echo $link_lb!='' ? $link_lb : $custom_link;?>" title="<?php the_title_attribute();?>" class="il-img">
                    <?php the_post_thumbnail($img_size);?>
                </a>
            <?php }?>
            <div class="timeline-details">
                <h2 class="tl-title">
                	<?php wpex_tmfulldate(1);
					if($hide_title!='1'){?>
                    	<a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><?php the_title();?></a>
                    <?php }?>
                    <div class="wpex-timeline-icon">
                        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><i class="fa <?php echo esc_attr($icon);?>"></i></a>
                    </div>

                </h2>
                <?php
				if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					echo wptl_audio_video_iframe();
				}?>
                <div class="tlct-shortdes">
                    <p><?php  echo wptl_timeline_desc($full_content,$show_media); ?></p>
                    <?php 
                    $cat_html = wptl_show_cat($posttype, $taxonomy);
                    if($cat_html!=''){?>
                    <div class="wptl-more-meta">
                        <?php echo $cat_html;?>
                    </div>
                    <?php }?>
                </div>
                <?php if($full_content!=1){?>
                <div class="wptl-readmore-center">
                    <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                        <?php echo get_option('wpex_text_conread')!='' ? get_option('wpex_text_conread') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
    <?php if($we_eventcolor!=''|| $wpex_icon_img!=''){?>
	<style type="text/css">
		<?php if($wpex_icon_img!=''){?>
		.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa.no-icon:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;}
		<?php }
		if($we_eventcolor!=''){?>
		.wpex-timeline-list.show-clean li.post-<?php the_ID();?> .wpex-timeline-icon .fa:not(.no-icon):before,
		.wpex-timeline-list.show-clean li.post-<?php the_ID();?> .wptl-readmore-center a,
		.wpex-timeline-list.show-clean .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label h2{color:<?php echo esc_attr($we_eventcolor);?>;}
		.show-clean .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-icon .fa{background:<?php echo esc_attr($we_eventcolor);?>}
		<?php }?>
    </style>
    <?php } ?>
    <?php if($wpex_felabel!=''){
		echo '<div class="wptl-feature-name"><span>'.$wpex_felabel.'</span></div>';
	}?>
    <?php echo isset($year_post) && $year_post!='' ? '<input type="hidden" class="crr-year" value="'.$year_post.'">' : ''; ?>
</li>