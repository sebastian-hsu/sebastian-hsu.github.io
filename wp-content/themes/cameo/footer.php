<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 */
 
?>

<?php
	//Check if blank template
	global $photograhy_is_no_header;
	global $photography_screen_class;
	
	if(!is_bool($photograhy_is_no_header) OR !$photograhy_is_no_header)
	{

	global $photography_homepage_style;
	
	//If display photostream
	$pp_photostream = get_option('pp_photostream');
	if(THEMEDEMO && isset($_GET['footer']) && !empty($_GET['footer']))
	{
		$pp_photostream = 0;
	}

	if(!empty($pp_photostream) && $photography_homepage_style != 'fullscreen_video')
	{
		$photos_arr = array();
	
		if($pp_photostream == 'flickr')
		{
			$pp_flickr_id = get_option('pp_flickr_id');
			$photos_arr = photography_get_flickr(array('type' => 'user', 'id' => $pp_flickr_id, 'items' => 30));
		}
		else
		{
			$pp_instagram_username = get_option('pp_instagram_username');
			$pp_instagram_access_token = get_option('pp_instagram_access_token');
			$photos_arr = photography_get_instagram($pp_instagram_username, $pp_instagram_access_token, 30);
		}
		
		if(!empty($photos_arr) && $photography_screen_class != 'split' && $photography_screen_class != 'split wide' && $photography_homepage_style != 'fullscreen' && $photography_homepage_style != 'flow')
		{
			wp_enqueue_script("photography-modernizr", get_template_directory_uri()."/js/modernizr.js", false, THEMEVERSION, true);
			wp_enqueue_script("photography-jquery-gridrotator", get_template_directory_uri()."/js/jquery.gridrotator.js", false, THEMEVERSION, true);
			wp_enqueue_script("photography-script-footer-gridrotator", admin_url('admin-ajax.php')."?action=photography_script_gridrotator&grid=footer_photostream&rows=2", false, THEMEVERSION, true);
?>
<br class="clear"/>
<div id="footer_photostream" class="footer_photostream_wrapper ri-grid ri-grid-size-3">
	<h2 class="widgettitle photostream">
		<?php
			if($pp_photostream == 'instagram')
			{
		?>
			<a href="https://instagram.com/<?php echo esc_html($pp_instagram_username); ?>" target="_blank">
				<i class="fa fa-instagram marginright"></i><?php echo esc_html($pp_instagram_username); ?>
			</a>
		<?php
			}
			else
			{
		?>
			<i class="fa fa-flickr marginright"></i>Flickr
		<?php
			}
		?>
	</h2>
	<ul>
		<?php
			foreach($photos_arr as $photo)
			{
		?>
			<li><a target="_blank" href="<?php echo esc_url($photo['link']); ?>"><img src="<?php echo esc_url($photo['thumb_url']); ?>" alt="" /></a></li>
		<?php
			}
		?>
	</ul>
</div>
<?php
		}
	}
?>

<?php
	//Get Footer Sidebar
	$tg_footer_sidebar = kirki_get_option('tg_footer_sidebar');
	if(THEMEDEMO && isset($_GET['footer']) && !empty($_GET['footer']))
	{
	    $tg_footer_sidebar = 0;
	}
?>
<div class="footer_bar <?php if(isset($photography_homepage_style) && !empty($photography_homepage_style)) { echo esc_attr($photography_homepage_style); } ?> <?php if(!empty($photography_screen_class)) { echo esc_attr($photography_screen_class); } ?> <?php if(empty($tg_footer_sidebar)) { ?>noborder<?php } ?>">

	<?php
	    if(!empty($tg_footer_sidebar))
	    {
	    	$footer_class = '';
	    	
	    	switch($tg_footer_sidebar)
	    	{
	    		case 1:
	    			$footer_class = 'one';
	    		break;
	    		case 2:
	    			$footer_class = 'two';
	    		break;
	    		case 3:
	    			$footer_class = 'three';
	    		break;
	    		case 4:
	    			$footer_class = 'four';
	    		break;
	    		default:
	    			$footer_class = 'four';
	    		break;
	    	}
	    	
	    	global $photography_homepage_style;
	?>
	<div id="footer" class="<?php if(isset($photography_homepage_style) && !empty($photography_homepage_style)) { echo esc_attr($photography_homepage_style); } ?>">
	<ul class="sidebar_widget <?php echo esc_attr($footer_class); ?>">
	    <?php dynamic_sidebar('Footer Sidebar'); ?>
	</ul>
	</div>
	<br class="clear"/>
	<?php
	    }
	?>

	<div class="footer_bar_wrapper <?php if(isset($photography_homepage_style) && !empty($photography_homepage_style)) { echo esc_attr($photography_homepage_style); } ?>">
		<?php
			//Check if display social icons or footer menu
			$tg_footer_copyright_right_area = kirki_get_option('tg_footer_copyright_right_area');
			
			if($tg_footer_copyright_right_area=='social')
			{
				if($photography_homepage_style!='flow' && $photography_homepage_style!='fullscreen' && $photography_homepage_style!='carousel' && $photography_homepage_style!='flip' && $photography_homepage_style!='fullscreen_video')
				{	
					//Check if open link in new window
					$tg_footer_social_link = kirki_get_option('tg_footer_social_link');
			?>
			<div class="social_wrapper">
			    <ul>
			    	<?php
			    		$pp_facebook_url = get_option('pp_facebook_url');
			    		
			    		if(!empty($pp_facebook_url))
			    		{
			    	?>
			    	<li class="facebook"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> href="<?php echo esc_url($pp_facebook_url); ?>"><i class="fa fa-facebook-official"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_twitter_username = get_option('pp_twitter_username');
			    		
			    		if(!empty($pp_twitter_username))
			    		{
			    	?>
			    	<li class="twitter"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> href="//twitter.com/<?php echo esc_attr($pp_twitter_username); ?>"><i class="fa fa-twitter"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_flickr_username = get_option('pp_flickr_username');
			    		
			    		if(!empty($pp_flickr_username))
			    		{
			    	?>
			    	<li class="flickr"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Flickr" href="//flickr.com/people/<?php echo esc_attr($pp_flickr_username); ?>"><i class="fa fa-flickr"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_youtube_url = get_option('pp_youtube_url');
			    		
			    		if(!empty($pp_youtube_url))
			    		{
			    	?>
			    	<li class="youtube"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Youtube" href="<?php echo esc_url($pp_youtube_url); ?>"><i class="fa fa-youtube"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_vimeo_username = get_option('pp_vimeo_username');
			    		
			    		if(!empty($pp_vimeo_username))
			    		{
			    	?>
			    	<li class="vimeo"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Vimeo" href="//vimeo.com/<?php echo esc_attr($pp_vimeo_username); ?>"><i class="fa fa-vimeo-square"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_tumblr_username = get_option('pp_tumblr_username');
			    		
			    		if(!empty($pp_tumblr_username))
			    		{
			    	?>
			    	<li class="tumblr"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Tumblr" href="//<?php echo esc_attr($pp_tumblr_username); ?>.tumblr.com"><i class="fa fa-tumblr"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_google_url = get_option('pp_google_url');
			    		
			    		if(!empty($pp_google_url))
			    		{
			    	?>
			    	<li class="google"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Google+" href="<?php echo esc_url($pp_google_url); ?>"><i class="fa fa-google-plus"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_dribbble_username = get_option('pp_dribbble_username');
			    		
			    		if(!empty($pp_dribbble_username))
			    		{
			    	?>
			    	<li class="dribbble"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Dribbble" href="//dribbble.com/<?php echo esc_attr($pp_dribbble_username); ?>"><i class="fa fa-dribbble"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_linkedin_url = get_option('pp_linkedin_url');
			    		
			    		if(!empty($pp_linkedin_url))
			    		{
			    	?>
			    	<li class="linkedin"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Linkedin" href="<?php echo esc_url($pp_linkedin_url); ?>"><i class="fa fa-linkedin"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			            $pp_pinterest_username = get_option('pp_pinterest_username');
			            
			            if(!empty($pp_pinterest_username))
			            {
			        ?>
			        <li class="pinterest"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Pinterest" href="//pinterest.com/<?php echo esc_attr($pp_pinterest_username); ?>"><i class="fa fa-pinterest"></i></a></li>
			        <?php
			            }
			        ?>
			        <?php
			        	$pp_instagram_username = get_option('pp_instagram_username');
			        	
			        	if(!empty($pp_instagram_username))
			        	{
			        ?>
			        <li class="instagram"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Instagram" href="//instagram.com/<?php echo esc_attr($pp_instagram_username); ?>"><i class="fa fa-instagram"></i></a></li>
			        <?php
			        	}
			        ?>
			        <?php
			        	$pp_behance_username = get_option('pp_behance_username');
			        	
			        	if(!empty($pp_behance_username))
			        	{
			        ?>
			        <li class="behance"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Behance" href="//behance.net/<?php echo esc_attr($pp_behance_username); ?>"><i class="fa fa-behance-square"></i></a></li>
			        <?php
			        	}
			        ?>
			        <?php
					    $pp_500px_url = get_option('pp_500px_url');
					    
					    if(!empty($pp_500px_url))
					    {
					?>
					<li class="500px"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="500px" href="<?php echo esc_url($pp_500px_url); ?>"><i class="fa fa-500px"></i></a></li>
					<?php
					    }
					?>
			    </ul>
			</div>
		<?php
				}
			} //End if display social icons
			else
			{
				if ( has_nav_menu( 'footer-menu' ) ) 
			    {
				    wp_nav_menu( 
				        	array( 
				        		'menu_id'			=> 'footer_menu',
				        		'menu_class'		=> 'footer_nav',
				        		'theme_location' 	=> 'footer-menu',
				        	) 
				    ); 
				}
			}
		?>
	    <?php
	    	//Display copyright text
	        $tg_footer_copyright_text = kirki_get_option('tg_footer_copyright_text');

	        if(!empty($tg_footer_copyright_text))
	        {
	        	echo '<div id="copyright">'.wp_kses_post(htmlspecialchars_decode($tg_footer_copyright_text)).'</div><br class="clear"/>';
	        }
	    ?>
	    
	    <?php
	    	//Check if display to top button
	    	$tg_footer_copyright_totop = kirki_get_option('tg_footer_copyright_totop');
	    	
	    	if(!empty($tg_footer_copyright_totop))
	    	{
	    ?>
	    	<a id="toTop"><i class="fa fa-angle-up"></i></a>
	    <?php
	    	}
	    ?>
	</div>
</div>

</div>

<?php
    } //End if not blank template
?>

<div id="overlay_background">
	<?php
		global $photography_page_gallery_id;
		
		//Check if display sharing buttons
		$tg_global_sharing = kirki_get_option('tg_global_sharing');
		
		if(is_single() OR !empty($photography_page_gallery_id) OR !empty($tg_global_sharing))
		{
	?>
	<div id="fullscreen_share_wrapper">
		<div class="fullscreen_share_content">
	<?php
			get_template_part("/templates/template-share");
	?>
		</div>
	</div>
	<?php
		}
	?>
</div>

<?php
    //Check if theme demo then enable layout switcher
    if(THEMEDEMO)
    {
?>
    <div id="option_wrapper">
    <div class="inner">
    	<div style="text-align:center">
	    	<h6 class="demo_title">Created With Photography</h6>
	    	<div class="demo_desc">
		    	We designed Photography theme to make it works especially for photography & portfolio site. Here are a few included examples that you can import with one click.
	    	</div>
	    	<?php
	    		$customizer_styling_arr = array( 
					array(
						'id'	=>	'white1', 
						'title' => 'Classic White', 
						'url' => 'http://themes.themegoods.com/photography/demo1/',
						'new' => false,
					),
					array(
						'id'	=>	'dark3', 
						'title' => 'Classic Black', 
						'url' => 'http://themes.themegoods.com/photography/demo2/',
						'new' => false,
					),
					array(
						'id'	=>	'bold_black', 
						'title' => 'Bold Black', 
						'url' => 'http://themes.themegoods.com/photography/demo3/',
						'new' => true,
					),
					array(
						'id'	=>	'bold_white', 
						'title' => 'Bold White', 
						'url' => 'http://themes.themegoods.com/photography/demo4/',
						'new' => true,
					),
				);
	    	?>
	    	<ul class="demo_list">
	    		<?php
	    			foreach($customizer_styling_arr as $customizer_styling)
	    			{
	    		?>
	    		<li>
	        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/customizer/screenshots/<?php echo esc_html($customizer_styling['id']); ?>.jpg" alt="" <?php if(empty($customizer_styling['url'])) { ?>class="no_blur"<?php } ?>/>
	        		<?php 
		        		if($customizer_styling['new'])
		        		{
			        ?>
	        			<span class="label_new">New</span>
	        		<?php 
		        		}
		        		
		        		if(!empty($customizer_styling['url']))
		        		{
			        ?>
	        		<div class="demo_thumb_hover_wrapper">
	        		    <div class="demo_thumb_hover_inner">
	        		    	<div class="demo_thumb_desc">
	    	    	    		<h6><?php echo esc_html($customizer_styling['title']); ?></h6>
	    	    	    		<a href="<?php echo esc_url($customizer_styling['url']); ?>" target="_blank" class="button white">Launch</a>
	        		    	</div> 
	        		    </div>	   
	        		</div>		
	        		<?php
		        		}
		        	?>   
	    		</li>
	    		<?php
	    			}
	    		?>
	    	</ul>
	    	
	    	<h6 class="demo_title">Predefined Stylings</h6>
	    	<?php
	    		$customizer_styling_arr = array( 
					array(
						'id'	=>	'white1', 
						'title' => 'White Demo: Left Align Menu', 
						'url' => 'http://themes.themegoods.com/photography/demo1/'
					),
					array(
						'id'	=>	'white2', 
						'title' => 'White Demo: Center Align Menu', 
						'url' => 'http://themes.themegoods.com/photography/demo1/home/home-creative-2/?menulayout=centeralign'
					),
					array(
						'id'	=>	'white3', 
						'title' => 'White Demo: With Top Bar', 
						'url' => 'http://themes.themegoods.com/photography/demo1/home/home-revolution-slider/?topbar=1'
					),
					array(
						'id'	=>	'white4', 
						'title' => 'White Demo: Fullscreen Menu', 
						'url' => 'http://themes.themegoods.com/photography/demo1/home/home-10-masonry-gallery/?menulayout=hammenufull'
					),
					array(
						'id'	=>	'white5', 
						'title' => 'White Demo: Left Vertical Menu', 
						'url' => 'http://themes.themegoods.com/photography/demo1/pages/about-us-2/?menulayout=leftmenu'
					),
					array(
						'id'	=>	'white6', 
						'title' => 'White Demo: Black Frame', 
						'url' => 'http://themes.themegoods.com/photography/demo1/home/home-15-animated-grid/?frame=1&amp;frame_color=black'
					),
					array(
						'id'	=>	'white8', 
						'title' => 'White Demo: Boxed Layout', 
						'url' => 'http://themes.themegoods.com/photography/demo1/gallery-archive/gallery-archive-4-columns-contained/?boxed=1'
					),
					array(
						'id'	=>	'dark1', 
						'title' => 'Dark Demo: Left Align Menu', 
						'url' => 'http://themes.themegoods.com/photography/demo2/'
					),
					array(
						'id'	=>	'dark2', 
						'title' => 'Dark Demo: Center Align Menu', 
						'url' => 'http://themes.themegoods.com/photography/demo2/home/home-creative-2/?menulayout=centeralign'
					),
					array(
						'id'	=>	'dark3', 
						'title' => 'Dark Demo: With Top Bar', 
						'url' => 'http://themes.themegoods.com/photography/demo2/home/home-revolution-slider/?topbar=1'
					),
					array(
						'id'	=>	'dark4', 
						'title' => 'Dark Demo: Fullscreen Menu', 
						'url' => 'http://themes.themegoods.com/photography/demo2/home/home-10-masonry-gallery/?menulayout=hammenufull'
					),
					array(
						'id'	=>	'dark5', 
						'title' => 'Dark Demo: Left Vertical Menu', 
						'url' => 'http://themes.themegoods.com/photography/demo2/pages/about-us-2/?menulayout=leftmenu'
					),
					array(
						'id'	=>	'dark6', 
						'title' => 'Dark Demo: Black Frame', 
						'url' => 'http://themes.themegoods.com/photography/demo2/home/home-15-animated-grid/?frame=1&amp;frame_color=black'
					),
					array(
						'id'	=>	'dark8', 
						'title' => 'Dark Demo: Boxed Layout', 
						'url' => 'http://themes.themegoods.com/photography/demo2/gallery-archive/gallery-archive-4-columns-contained/?boxed=1'
					),
				);
	    	?>
	    	<ul class="demo_list">
	    		<?php
	    			foreach($customizer_styling_arr as $customizer_styling)
	    			{
	    		?>
	    		<li>
	        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/customizer/screenshots/<?php echo esc_html($customizer_styling['id']); ?>.jpg" alt=""/>
	        		<div class="demo_thumb_hover_wrapper">
	        		    <div class="demo_thumb_hover_inner">
	        		    	<div class="demo_thumb_desc">
	    	    	    		<h6><?php echo esc_html($customizer_styling['title']); ?></h6>
	    	    	    		<a href="<?php echo esc_url($customizer_styling['url']); ?>" target="_blank" class="button white">Launch</a>
	        		    	</div> 
	        		    </div>	   
	        		</div>		   
	    		</li>
	    		<?php
	    			}
	    		?>
	    	</ul>
    	</div>
    </div>
    </div>
    <div id="option_btn">
    	<a href="javascript:;" class="demotip" title="Choose Theme Demo"><span class="ti-settings"></span></a>
    	
    	<a href="http://themegoods.theme-demo.net/photographyresponsivephotographytheme" class="demotip" title="Try Before You Buy" target="_blank"><span class="ti-pencil-alt"></span></a>
    	
    	<a href="http://themes.themegoods.com/photography/landing2/customers-sites/" class="demotip" title="Showcase" target="_blank"><span class="ti-heart"></span></a>
    	
    	<a href="http://themes.themegoods.com/photography/doc" class="demotip" title="Theme Documentation" target="_blank"><span class="ti-book"></span></a>
    	
    	<a href="http://themeforest.net/item/photography-responsive-photography-theme/13304399?ref=ThemeGoods&amp;license=regular&amp;open_purchase_for_item_id=13304399&amp;purchasable=source&amp;ref=ThemeGoods&amp;redirect_back=true" class="demotip" title="Purchase Theme" target="_blank"><span class="ti-shopping-cart"></span></a>
    </div>
<?php
    	wp_enqueue_script("jquery.cookie", get_template_directory_uri()."/js/jquery.cookie.js", false, THEMEVERSION, true);
    	wp_enqueue_script("script-demo", get_template_directory_uri()."/js/custom_demo.js", false, THEMEVERSION, true);
    }
?>

<?php
    $tg_frame = kirki_get_option('tg_frame');
    if(THEMEDEMO && isset($_GET['frame']) && !empty($_GET['frame']))
    {
	    $tg_frame = 1;
    }
    
    if(!empty($tg_frame))
    {
    	wp_enqueue_style("tg_frame", get_template_directory_uri()."/css/tg_frame.css", false, THEMEVERSION, "all");
?>
    <div class="frame_top"></div>
    <div class="frame_bottom"></div>
    <div class="frame_left"></div>
    <div class="frame_right"></div>
<?php
    }
    if(THEMEDEMO && isset($_GET['frame_color']) && !empty($_GET['frame_color']))
    {
?>
<style>
.frame_top, .frame_bottom, .frame_left, .frame_right { background: <?php echo esc_html($_GET['frame_color']); ?> !important; }
	.page-id-6377 .gallery3.archive.center_display .gallery_archive_desc h4, .three_cols.gallery .element .center_display .portfolio_title .table .cell h5 {
    font-size: 1.2em!important;
    letter-spacing: -0.03125em;
}

.mobx-thumb-bg {

    background-size: contain!important;
	background-color: #111;}

.mobx-caption-inner {
max-width: 50em!important;
    margin: 0 auto;
    pointer-events: auto;
    cursor: default;
}

.gallery_type, .portfolio_type{
opacity:1;
}

.gallery_archive_desc_content{
	height:15em!Important;
}

.galleries-template-default .one_third.gallery3.static  {
   overflow: hidden;
   max-height: 11.875em;
}

.gallery3 p{
	padding:0em!important;
}
.ppb_portfolio .one_third.gallery3.static {
overflow: hidden;
    max-height: inherit!important;
}
.ppb_header_content img{
	
	max-width:250px!important;
	margin:0 auto;
}


.portfolio_desc.portfolio3 h5 {
font-size: 1.2em;
color: #fff;
}

.portfolio_desc {
float: left;
text-align: center;
margin-top: 0;
background-color: #aa8a49;
font-weight: 800;
}

.three_cols.gallery .element{
	width: calc(33% - 1.25em);
	
}
.galleries-template-default .one_third.gallery3.static {
overflow: hidden;
max-height: 16em;
}

.post_header_title .post_info_date{
	font-size: 1.5em;
}
.page-id-6217 h2,.page-id-6287 h2{
	border-bottom:1px solid #a6824a;
	color:#a6824a;
}


.postid-6492 #page_content_wrapper .inner .sidebar_content img, .page_content_wrapper .inner .sidebar_content img {
max-width: 100%;
height: auto;
position: relative;
bottom: 5em;
}

.postid-7113 #page_content_wrapper .inner .sidebar_content img, .page_content_wrapper .inner .sidebar_content img {
max-width: 100%;
height: auto;
position: relative;
bottom: 5em;
}
table tr th, table tr td{
	padding: 0.25em;
}
.logo_wrapper img{
  max-width:15.625em;
}

 .wpex-timeline > li .wpex-timeline-label h2 {
margin-top: 0em;
margin-bottom: 0.3125em;
font-weight: normal;
text-transform: none!important;
}

h1, h2, h3, h4, h5, h6, h7 {
color: #222;
font-family: 'Montserrat', 'Helvetica Neue', Arial,Verdana,sans-serif;
font-weight: 400;
text-transform: none!important;
letter-spacing: 0!important;
}

@media (max-width: 47.9375em) {
	.three_cols.gallery .element{
			width: 100%
	}
.galleries-template-default .one_third.gallery3.static  {
   overflow: hidden;
   max-height: inherit!important;
}
}
	

.tab_content td span {
font-size: 1.25em;
line-height: 1.6em;
}

.page_content_wrapper p {
font-size: 1.25em;
line-height: 1.6em;
padding-top: 0.7em;
padding-bottom: 0.7em;
}

.history_page .tab_link {
font-size: 1.15em;
}

.footer_logo img {
    top: 0.6em;
    position: relative;
    max-width: 11em;
}
	

.timeline-content p{
	font-size: 1.15em!important;
line-height: 1.6em!important;
}

.ppb_header_content p{
	font-size: 1.15em!important;
line-height: 1.6em!important;
}

.home #nav_wrapper .menu-item a {
    color: #AA8A49 !important;
    font-size: 1em !important;
    padding-left: 10px;
    padding-right: 10px;
}
.home #nav_wrapper  .menu-item .sub-menu a {
    color: #AA8A49 !important;
    font-size: 1em !important;
    padding-left: 10px;
    padding-right: 10px;
	    color: #262118 !important;
}
.home #nav_wrapper  .menu-item .sub-menu a:hover {
    color: #fff !important;
   
}
.gallery_archive_desc h4{
	line-height:30px;
}
.timeline-content img{
	max-width:100%;
	
}

@media (max-width: 75em) {
	 .mobile_menu_wrapper #header_searchform{
		display:block;
	}
	 .mobile_menu_wrapper #header_searchform input{
	border:1px solid #000;
		padding-left:1em;
		    width: 100%;
        padding-top: 0.2em;
    padding-bottom: 0.2em;
		
}
	
 .mobile_menu_wrapper #header_searchform button{
		color:#000!important;
	}
}

.single-post #page_content_wrapper p, .page_content_wrapper p {font-size: 1.25em;
}

.ppb_header_content p {
	font-size: 1.25em!important;     line-height: 1.6em!important;
}

.readmore {font-size: 1.6em;}

.post_info_date {font-size: 1.5em;}

/* .page-id-6217 .three_cols.gallery:not(.mixed_grid) .element.masonry, .page-id-6217 .three_cols.gallery:not(.mixed_grid) .element:nth-child(3n){
	       margin-right: 0.5em;
    margin-left: 0.8em;
}

.page-id-6287 .three_cols.gallery:not(.mixed_grid) .element.masonry, .page-id-6287  .three_cols.gallery:not(.mixed_grid) .element:nth-child(3n){
	       margin-right: 0.5em;
    margin-left: 0.8em;
} */
.nav_wrapper_inner a{
	letter-spacing:0px;
}
.home .header_style_wrapper{
	z-index:9998
}

#index-page .footer{
	
}
#custom_post_widget-5908{
	width:60%;
}
#custom_post_widget-5911{
	width:40%;
	
}
#custom_post_widget-5908 p{
	padding:0px;
	letter-spacing: 0;
}
#custom_post_widget-5908 {
	top:0px;
	
}

#custom_post_widget-5911 {
	    position: relative;
        top: -5px;
}
#index-page .footer{
	    position: relative;
    top: 0px;
	min-height: 250px;
}
#index-page #text-14{
	padding-top:5px;
}

#index-page .top-section .nav .arrow-tip-bot{
	    top: 1.6em!important;
}
.page-template-blog_f #page_content_wrapper p, .page-template-blog_f .page_content_wrapper p {font-size: 1.25em;}

.mobx-play {
    background-position: 0.75em -17.8em;
}
.page-id-6377 #page_caption{
	margin-bottom:0px;
}

.page-id-6377 #page_content_wrapper{
	padding:0px;
}

@media (max-width: 88.75em) {
	.home #nav_wrapper .menu-item a {
    color: #AA8A49 !important;
    font-size: 1em !important;
    padding-left: 5px;
    padding-right: 5px;
}

}

.google_map_img{
	display:none;
}

#index-page .top-section .nav-down{
	bottom:-1.25em!important;
}



@media only screen and (max-width: 47.9375em){
	.single-post #page_caption.hasbg {
        height: 18.75em;
}


	#index-page .top-section{
		top: -0px!important;
	}
	#index-page .top-section .nav-down{
		bottom:0px!important;
	}
	
}
.right_logo img{
	max-width: 7em;
    top: 0.2em;
}
div#custom_post_widget-5911 p {
   text-align: right;
}
@media only screen and (min-width: 68.75em){
	.page-id-6376 #page_content_wrapper{
		max-width: 98em;
	}
}
@media (max-width: 90em){
.home #footer {
    padding-top: 0em;
    padding-bottom: 0em;
}
	#index-page .footer {
    position: relative;
    top: 0px;
    min-height: 250px;
}
}

.footer{
	background: #262118!important;
}
@media (max-width: 61.9375em){
.home #footer {
    padding-top: 0em;
    padding-bottom: 0em;
}
	#index-page .footer {
    position: relative;
    top: 0px;
        min-height: 400px;
}
	div#custom_post_widget-5911 p {
   text-align: left;
}
	#custom_post_widget-5908 {width:100%;
}
	#custom_post_widget-5911{
		width:100%;
	}
}

body#index-page .bot-section .tab-panel.active{
	z-index:999999!important;
	position:absolute;
	padding-top:40px;
}

  @media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {  
		#index-page .top-section .view{
			top:calc(50vh - 250px)!important;
		}
		#index-page .top-section .nav-down{
			bottom:0em!important;
		}
		 .nav_wrapper_inner #menu_border_wrapper  a{
			letter-spacing:0px;
			font-size:70%!important;
			word-spacing: normal;
			padding-left:5px!important;
			padding-right:5px!important;
			 text-transform: uppercase!important;
		}
			.home .nav_wrapper_inner #menu_border_wrapper  a{
			letter-spacing:0px;
			font-size:70%!important;
			word-spacing: normal;
			padding-left:5px!important;
			padding-right:5px!important;
			 text-transform: uppercase!important;
		}
		.home #nav_wrapper .menu-item .sub-menu a{
			    font-size: 70%!important;
		}
		#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a{
			    width: 13.625em;
		}
}
#nav_wrapper .menu-item .sub-menu a{
	font-weight: bold!important;
}
@media only screen and (max-width: 47.9375em){
.mobile_main_nav li.menu-item-has-children > a:after {
    left: 16em;
}
.home	.mobile_main_nav li.menu-item-has-children > a:after {
    left: 17em!important;
}
}
.footer_bar{
	     border-top: 0em solid #e1e1e1; 
	    background: #262118;
}

.home #wrapper{
	background-color: #262118 !important;
} 
body.home  .bot-section {
    -ms-overflow-style: none;
}

</style>
<?php
	}
?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
