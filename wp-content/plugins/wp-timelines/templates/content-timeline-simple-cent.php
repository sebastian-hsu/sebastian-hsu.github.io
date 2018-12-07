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
	<div class="<?php echo esc_attr($animations);?>">
        
        <div class="wpex-timeline-label">
            <time class="wpex-timeline-time" datetime="<?php echo esc_attr(get_the_date( get_option( 'time_format' ) ).' '.get_the_date( get_option( 'date_format' ) ));?>">
                <span class="s-date"><?php wpex_tmfulldate(1);?></span>
                <span class="clearfix"></span>
            </time>
            <div class="timeline-details">
                <?php
				if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					echo wptl_audio_video_iframe();
				}elseif(has_post_thumbnail(get_the_ID()) && $hide_img!=1){?>
                    <a class="img-left" href="<?php echo $link_lb!='' ? $link_lb : $custom_link;?>" title="<?php the_title_attribute();?>">
                        <span class="info-img">
							<?php the_post_thumbnail($img_size);?>
                        </span>
                    </a>
                <?php }?>
                <div class="tlct-shortdes">
                    <?php 
					wptl_title_html($hide_title,$custom_link);
					if($style=='wide_img' && (get_post_meta( get_the_ID(), 'wpex_sublabel', true )!='')){
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
            <div class="clearfix"></div>
            <?php if($full_content!=1){?>
            <div class="wptl-readmore-center">
                <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                    <?php echo get_option('wpex_text_conread')!='' ? get_option('wpex_text_conread') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="wpex-timeline-icon">
        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><i class="fa <?php echo esc_attr($icon);?>"></i></a>
    </div>
    <?php if($we_eventcolor!=''|| $wpex_icon_img!=''){?>
	<style type="text/css">
		<?php if($wpex_icon_img!=''){?>
		#timeline-<?php echo esc_attr($ID);?> li.post-<?php the_ID();?> .wpex-timeline-icon .fa.no-icon:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;}
		<?php }
		if($we_eventcolor!=''){?>
		#timeline-<?php echo esc_attr($ID);?> ul li.post-<?php the_ID();?> .wpex-timeline-time .tll-date{ color:<?php echo esc_attr($we_eventcolor);?>; background:transparent;}
		#timeline-<?php echo esc_attr($ID);?> .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-icon .fa{background:<?php echo esc_attr($we_eventcolor);?>;}
		#timeline-<?php echo esc_attr($ID);?> li.post-<?php the_ID();?> .wptl-readmore-center a,
		#timeline-<?php echo esc_attr($ID);?> li.post-<?php the_ID();?> .wpex-timeline-icon .fa:not(.no-icon):before{color:<?php echo esc_attr($we_eventcolor);?>;}
		<?php }?>
    </style>
    <?php } ?>
    <?php if($wpex_felabel!=''){
		echo '<div class="wptl-feature-name"><span>'.$wpex_felabel.'</span></div>';
	}?>
    <?php echo isset($year_post) && $year_post!='' ? '<input type="hidden" class="crr-year" value="'.$year_post.'">' : ''; ?>
</li>