<?php
get_header();
?>

<?php $year_time = get_field( "year_time" ); ?>
<?php $m_d_time = get_field( "m_d_time" ); ?>
<?php $single_location = get_field( "single_location" ); ?>
<?php $google_map = get_field( "google_map" ); ?>
<?php $google_map_img = get_field( "google_map_img" ); ?>
<?php $sign_up_link = get_field( "sign_up_link" ); ?>
<?php $single_banner = get_field( "single_banner" ); ?>
<?php $link_text = get_field( "link_text" ); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
			<div class="post_banner">
				<img src="<?php echo $single_banner['url']; ?>" alt="<?php echo $single_banner['alt']; ?>" />
			</div>
<div class="wpex-single-timeline">

	<?php
	// Start the loop.
	while ( have_posts() ) : the_post();
		$wpex_custom_metadata = get_post_meta( get_the_ID(), 'wpex_custom_metadata', false );?>
        <div class="wpex-info-sp">
			
                <div class="clearfix"></div>
            <div class="speaker-details row">
            	
                
                <div class="timeline-info col-md-7">
										<!-- 中文 -->
					<?php if (ICL_LANGUAGE_CODE == 'zh-hant'): ?>
				<a href="/90-events/" class="back_page"  alt="返回上一頁"><</a>
					<!-- 英文 -->
					<?php elseif (ICL_LANGUAGE_CODE == 'en'): ?>
<a href="/en/90-events/" class="back_page" alt="返回上一頁"><</a>
						<?php endif; ?>
					<h1 class="tl-title">
                    <?php the_title();?>
            		</h1>
                    <div class="timeline-content">
						<?php 
						$content =  preg_replace ('#<embed(.*?)>(.*)#is', ' ', get_the_content(),1);
						$content =  preg_replace ('@<iframe[^>]*?>.*?</iframe>@siu', ' ', $content,1);
						$content =  preg_replace ('/<source\s+(.+?)>/i', ' ', $content,1);
						$content =  preg_replace ('/\<object(.*)\<\/object\>/is', ' ', $content,1);
						$content =  preg_replace ('#\[video\s*.*?\]#s', ' ', $content,1);
						$content =  preg_replace ('#\[audio\s*.*?\]#s', ' ', $content,1);
						$content =  preg_replace ('#\[/audio]#s', ' ', $content,1);
						preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $match);
						foreach ($match[0] as $amatch) {
							if(strpos($amatch,'soundcloud.com') !== false){
								$content = str_replace($amatch, '', $content);
							}elseif(strpos($amatch,'youtube.com') !== false){
								$content = str_replace($amatch, '', $content);
							}
						}
						$content = preg_replace('%<object.+?</object>%is', '', $content,1);
						echo apply_filters('the_content',$content);?>
					</div>
					<!-- /timeline-content -->
				</div>
				<!-- /timeline-info -->
				<!-- 右側時間/地點區塊 -->
						<!-- 中文 -->
					<?php if (ICL_LANGUAGE_CODE == 'zh-hant'): ?>
				<div class="col-md-5 col-sm-12 col-xs-12">
					<div class="row m_b_15">
						<div class="col-sm-6 col-xs-12 time_wrap border_b">
							<h4>時間</h4>
							<!-- 變成活動時間 -->
							<p><?php echo $year_time ?></p>
						</div>
						<div class="col-sm-6 col-xs-12 location_wrap border_b">
							<h4>地點</h5>
							<p><?php echo $single_location ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-xs-12 google_map">
						<?php echo $google_map ?>
						</div>
						<div class="col-sm-12 col-xs-12 google_map_img">
                    				<img src="<?php echo $google_map_img['url']; ?>" alt="<?php echo $google_map_img['alt']; ?>"> 
					</div>
					</div>
					<div class="row margin_top">
						<div class="sign_up_link col-sm-5 col-xs-4">
							<a title="我要報名/更多資訊" target="_blank" href="<?php echo $sign_up_link ?>"><?php echo $link_text?></a>
						</div>
						<div class="share_btn col-sm-7 col-xs-8">
							
							<img title="友善列印" alt="友善列印" class="print_icon" src="<?php echo get_stylesheet_directory_uri()?>/images/print_icon.png" alt="">
							<input title="友善列印" class="print_btn" name="print" type="button" value="友善列印" onclick="varitext()">
							<?php echo do_shortcode('[addtoany]' );?>
						</div>
					</div>
				</div>
				<!-- 英文 -->
					<?php elseif (ICL_LANGUAGE_CODE == 'en'): ?>
								<div class="col-md-5 col-sm-12 col-xs-12">
					<div class="row m_b_15">
						<div class="col-sm-6 col-xs-12 time_wrap border_b">
							<h4>Date</h4>
							<!-- 變成活動時間 -->
							<p><?php echo $year_time ?></p>
						</div>
						<div class="col-sm-6 col-xs-12 location_wrap border_b">
							<h4>Location</h5>
							<p><?php echo $single_location ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-xs-12 google_map">
						<?php echo $google_map ?>
						</div>
					</div>
					<div class="row margin_top">
						<div class="sign_up_link col-sm-5 col-xs-4">
							<a title="sign up" target="_blank" href="<?php echo $sign_up_link ?>"><?php echo $link_text?></a>
						</div>
						<div class="share_btn col-sm-7 col-xs-8">
							
							<img title="Print" alt="Print" class="print_icon" src="<?php echo get_stylesheet_directory_uri()?>/images/print_icon.png" alt="">
							<input title="Print" class="print_btn" name="print" type="button" value="Print" onclick="varitext()">
							<?php echo do_shortcode('[addtoany]' );?>
						</div>
					</div>
				</div>
					<?php endif; ?>
			
				
				<!-- 上下頁 -->
                <?php 
				$we_sevent_navi = get_option('wpex_navi');
				if($we_sevent_navi!='no'){
					$wpex_navi_order = get_option('wpex_navi_order');
					$preevtrsl = get_option('wpex_text_prev')!='' ? get_option('wpex_text_prev') : esc_html__('Previous article','wp-timeline');
					$nextevtrsl = get_option('wpex_text_next')!='' ? get_option('wpex_text_next') : esc_html__('Next article','wp-timeline');
					if($wpex_navi_order!='ct_order'){ ?>
						<div class="timeline-navigation defa">
							<div class="next-timeline">
								<?php next_post_link('%link', $nextevtrsl) ?>
							</div>
							<div class="previous-timeline">
								<?php previous_post_link('%link', $preevtrsl) ?>
							</div>
						</div>
						<?php 
					}else{
						wpex_next_previous_timeline($preevtrsl,$nextevtrsl);
					}
				}?>
                <div class="clearfix"></div>
            </div>
        </div>
		<?php
	endwhile;?>
</div>
</div>
</div>
<?php get_footer(); ?>
