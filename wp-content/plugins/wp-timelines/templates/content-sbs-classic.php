<?php
global $style, $post, $ajax_load, $ID, $animations,$posttype,$show_media, $taxonomy,$full_content,$feature_label,$lightbox,$hide_img,$img_size,$hide_title;
if($img_size=='' && $style==''){ $img_size = 'wptl-320x220';}
else if($img_size==''){  $img_size = 'wptl-100x100';}
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
            <div class="timeline-details">
                <?php
				wpex_tmfulldate(1);
				if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					echo wptl_audio_video_iframe();
				}elseif( has_post_thumbnail(get_the_ID()) && $hide_img!=1){?>
                    <a class="img-left" href="<?php echo $link_lb!='' ? $link_lb : $custom_link;?>" title="<?php the_title_attribute();?>">
                        <span class="info-img">
							<?php the_post_thumbnail($img_size);?>
                        </span>
                    </a>
                <?php }?>
                <div class="tlct-shortdes">
                    <h2 style=" display:inline;">
                        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                            <?php echo '<span class="tlmobile-visible">'.wpex_date_tl().'&nbsp;-&nbsp;</span>';
							if($hide_title!='1'){ the_title();}?>
                        </a>
                    </h2>
                    <?php 
					$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
					if($wpex_sublabel!=''){?>
            			<div class="wptl-more-meta"><span><?php echo $wpex_sublabel;?></span></div>
            		<?php } ?>
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
        </div>
        <?php if($full_content!='1'){?>
        <div class="wptl-readmore-center">
            <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                <?php echo get_option('wpex_text_conread')!='' ? get_option('wpex_text_conread') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        <?php }?>
    </div>
    <div class="wpex-timeline-icon">
    	<?php if($wpex_icon_img!=''){ $icon = str_replace("no-icon","icon-img",$icon);}?>
        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><i class="fa <?php echo esc_attr($icon);?>"></i></a>
    </div>
    <?php if($we_eventcolor!=''|| $wpex_icon_img!=''){?>
	<style type="text/css">
		<?php if($wpex_icon_img!=''){?>
		.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa.icon-img:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;}
		<?php }
		if($we_eventcolor!=''){?>
		.sidebyside-tl.show-classic li.post-<?php the_ID();?> span.tll-date,
		.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa{ background:<?php echo esc_attr($we_eventcolor);?>}
		.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label:before{border-right-color:<?php echo esc_attr($we_eventcolor);?>}
		.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label{ border-left-color:<?php echo esc_attr($we_eventcolor);?>;}
		@media(min-width:768px){
			.wpex-timeline-list:not(.show-icon) .wpex-timeline.style-center > li.post-<?php the_ID();?>:nth-child(odd) .wpex-timeline-label{border-right-color:<?php echo esc_attr($we_eventcolor);?>}
			.wpex-timeline-list .wpex-timeline.style-center > li.post-<?php the_ID();?>:nth-child(odd) .wpex-timeline-label:before{ border-left-color:<?php echo esc_attr($we_eventcolor);?>;}
		}
		.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-time span:last-child{color:<?php echo esc_attr($we_eventcolor);?>;}
		<?php }?>
    </style>
    <?php } ?>
    <?php if($wpex_felabel!=''){
		echo '<div class="wptl-feature-name"><span>'.$wpex_felabel.'</span></div>';
	}?>
    <?php echo isset($year_post) && $year_post!='' ? '<input type="hidden" class="crr-year" value="'.$year_post.'">' : ''; ?>
</li>