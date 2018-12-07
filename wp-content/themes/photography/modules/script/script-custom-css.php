<?php 
header('Content-type: text/css');

$pp_advance_combine_css = get_option('pp_advance_combine_css');

if(!empty($pp_advance_combine_css))
{
	//Function for compressing the CSS as tightly as possible
	function photography_compress($buffer) {
	    //Remove CSS comments
	    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	    //Remove tabs, spaces, newlines, etc.
	    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	    return $buffer;
	}

	//This GZIPs the CSS for transmission to the user
	//making file size smaller and transfer rate quicker
	ob_start("ob_gzhandler");
	ob_start("photography_compress");
}
?>

<?php
	//Check if hide portfolio navigation
	$pp_portfolio_single_nav = get_option('pp_portfolio_single_nav');
	if(empty($pp_portfolio_single_nav))
	{
?>
.portfolio_nav { display:none; }
<?php
	}
?>
<?php
	$tg_fixed_menu = kirki_get_option('tg_fixed_menu');
	
	if(!empty($tg_fixed_menu))
	{
		//Check if Wordpress admin bar is enabled
		$menu_top_value = 0;
		if(is_admin_bar_showing())
		{
			$menu_top_value = 30;
		}
?>
.top_bar.fixed
{
	position: fixed;
	animation-name: slideDown;
	-webkit-animation-name: slideDown;	
	animation-duration: 0.5s;	
	-webkit-animation-duration: 0.5s;
	z-index: 999;
	visibility: visible !important;
	top: <?php echo intval($menu_top_value); ?>px;
}

<?php
	$pp_menu_font = get_option('pp_menu_font');
	$pp_menu_font_diff = 16-$pp_menu_font;
?>
.top_bar.fixed #menu_wrapper div .nav
{
	margin-top: <?php echo intval($pp_menu_font_diff); ?>px;
}

.top_bar.fixed #searchform
{
	margin-top: <?php echo intval($pp_menu_font_diff-8); ?>px;
}

.top_bar.fixed .header_cart_wrapper
{
	margin-top: <?php echo intval($pp_menu_font_diff+5); ?>px;
}

.top_bar.fixed #menu_wrapper div .nav > li > a
{
	padding-bottom: 24px;
}

.top_bar.fixed .logo_wrapper img
{
	max-height: 40px;
	width: auto;
}
<?php
	}
	
	//Hack animation CSS for Safari
	$current_browser = photography_get_browser();

	if(isset($current_browser['name']) && $current_browser['name'] == 'Internet Explorer')
	{
?>
#wrapper
{
	overflow-x: hidden;
}
.mobile_menu_wrapper
{
    overflow: auto;
}
body.js_nav .mobile_menu_wrapper 
{
    display: block;
}
.gallery_type, .portfolio_type
{
	opacity: 1;
}
#searchform input[type=text]
{
	width: 75%;
}
.woocommerce .logo_wrapper img
{
	max-width: 50%;
}
<?php
	}
?>

<?php
	$tg_sidemenu = kirki_get_option('tg_sidemenu');
	
	if(empty($tg_sidemenu))
	{
?>
#mobile_nav_icon
{
    display: none !important;
}
<?php
	}
?>

<?php
if(THEMEDEMO)
{
?>
#option_btn
{
	position: fixed;
	top: 150px;
	right: -2px;
	cursor:pointer;
	z-index: 9;
	background: #fff;
	border-right: 0;
	width: 40px;
	height: 155px;
	padding: 5px 0 5px 0;
	text-align: center;
	border-radius: 5px 0px 0px 5px;
	box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
}

#option_btn span
{
	font-size: 15px;
	line-height: 31px;
	color: #000;
}

#option_wrapper
{
	position: fixed;
	top: 0;
	right:-401px;
	width: 400px;
	background: #fff;
	z-index: 99999;
	font-size: 13px;
	box-shadow: -1px 1px 10px rgba(0, 0, 0, 0.1);
	overflow: auto;
	height: 100%;
	color: #000;
}

#option_wrapper:hover
{
	overflow-y: auto;
}

#option_wrapper h6.demo_title
{
	font-size: 15px;
	font-weight: 600;
	letter-spacing: 0;
}

.demo_color_list
{
	list-style: none;
	display: block;
	margin: 30px 0 10px 0;
}

.demo_color_list > li
{
	display: inline-block;
	position: relative;
	width: 11%;
	height: auto;
	overflow: hidden;
	cursor: pointer;
	padding: 0;
	box-sizing: border-box;
	text-align: center;
	font-size: 11px;
	margin-bottom: 15px;
}

.demo_color_list > li .item_content_wrapper
{
	width: 100%;
}

.demo_color_list > li .item_content_wrapper .item_content
{
	width: 100%;
	box-sizing: border-box;
}

.demo_color_list > li .item_content_wrapper .item_content .item_thumb
{
	width: 30px;
	height: 30px;
	position: relative;
	line-height: 0;
	border-radius: 250px;
	margin: auto;
}

.demo_list
{
	list-style: none;
	display: block;
	margin: 30px 0 20px 0;
	float: left;
}

.demo_list li
{
	display: block;
	float: left;
	position: relative;
	margin-bottom: 15px;
	margin-right: 14px;
	width: calc(50% - 7px);
	line-height: 0;
}

.demo_list li .label_new
{
	position: absolute;
    top: -12px;
    right: -12px;
    width: 32px;
    height: 32px;
    text-align: center;
    line-height: 32px;
    font-size: 10px;
    font-weight: 600;
    border-radius: 50px;
    color: #fff;
    background: #FF4A52;
    z-index: 2;
}

.demo_list li:nth-child(2n)
{
	margin-right: 0;
}

.demo_list li img
{
	max-width: 100%;
	height: auto;
	line-height: 0;
}

.demo_list li:hover img
{
	-webkit-transition: all 0.2s ease-in-out;
	-moz-transition: all 0.2s ease-in-out;
	-o-transition: all 0.2s ease-in-out;
	-ms-transition: all 0.2s ease-in-out;
	transition: all 0.2s ease-in-out;
	-webkit-filter: blur(2px);
	filter: blur(2px);
	-moz-filter: blur(2px);
}

.demo_list li:hover .demo_thumb_hover_wrapper 
{
	opacity: 1;
}

.demo_thumb_hover_wrapper 
{
	background-color: rgba(0, 0, 0, 0.5);
	height: 100%;
	left: 0;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	top: 0;
	transition: opacity 0.4s ease-in-out;
	-o-transition: opacity 0.4s ease-in-out;
	-ms-transition: opacity 0.4s ease-in-out;
	-moz-transition: opacity 0.4s ease-in-out;
	-webkit-transition: opacity 0.4s ease-in-out;
	visibility: visible;
	width: 100%;
	line-height: normal;
}

.demo_thumb_hover_inner
{
	display: table;
	height: 100%;
	width: 100%;
	text-align: center;
	vertical-align: middle;
}

.demo_thumb_desc
{
	display: table-cell;
	height: 100%;
	text-align: center;
	vertical-align: middle;
	width: 100%;
	padding: 0 10% 0 10%;
	box-sizing: border-box;
}

#option_wrapper .inner h6
{
	margin: 0;
}

.demo_thumb_hover_inner h6
{
	color: #fff !important;
	line-height: 20px;
	font-size: 12px;
	letter-spacing: 0;
}

.demo_thumb_desc .button.white
{
	margin-top: 5px;
    font-size: 11px !important;
    padding: .4em 1.5em .3em 1.5em;
}

.demo_thumb_desc .button.white:hover
{
	background: #fff !important;
	color: #000 !important;
	border-color: #fff !important;
}

#option_wrapper .inner
{
	padding: 25px 15px 0 15px;
	box-sizing: border-box;
}

body.admin-bar #option_wrapper .inner
{
	padding-top: 70px;
}

#option_wrapper .demo_desc
{
	box-sizing: border-box;
	margin-top: 10px;
	padding: 0 10px 0 10px;
	font-size: 12px;
	opacity: 0.7;
}

.demotip
{
	display: block;
}

@media only screen and (max-width: 767px) {
	#option_btn, #option_wrapper
	{
		display: none;
	}
}
<?php
}
?>

@media only screen and (max-width: 768px) {
	html[data-menu=leftmenu] .mobile_menu_wrapper
	{
		right: 0;
		left: initial;
		
		-webkit-transform: translate(360px, 0px);
		-ms-transform: translate(360px, 0px);
		transform: translate(360px, 0px);
		-o-transform: translate(360px, 0px);
	}
}

<?php
	$tg_full_arrow = kirki_get_option('tg_full_arrow');
	
	if(!empty($tg_full_arrow))
	{
?>
a#prevslide:before
{
	font-family: "FontAwesome";
	font-size: 24px;
	line-height: 45px;
	display: block;
	content: '\f104';
	color: #fff;
	margin-top: 0px;
}
a#nextslide:before
{
	font-family: "FontAwesome";
	font-size: 24px;
	line-height: 45px;
	display: block;
	content: '\f105';
	color: #fff;
	margin-top: 0px;
}
body.page-template-gallery a#prevslide, body.single-galleries a#prevslide
{ 
	z-index:999; cursor: pointer; display: block; position: fixed; left: 20px; top: 46%; padding: 0 20px 0 20px; width: initial; height: initial; border: 2px solid #fff; opacity: 0.5; 
	-webkit-transition: .2s ease-in-out;
	-moz-transition: .2s ease-in-out;
	-o-transition: .2s ease-in-out;
	transition: .2s ease-in-out;
	width: 50px;
	height: 50px;
	box-sizing: border-box;
	
	border-radius: 250px;
}

body.page-template-gallery a#nextslide, body.single-galleries a#nextslide
{ 
	z-index:999; cursor: pointer;  display: block; position: fixed; right: 20px; top: 46%; padding: 0 20px 0 20px; width: initial; height: initial; border: 2px solid #fff; opacity: 0.5; 
	-webkit-transition: .2s ease-in-out;
	-moz-transition: .2s ease-in-out;
	-o-transition: .2s ease-in-out;
	transition: .2s ease-in-out;
	width: 50px;
	height: 50px;
	box-sizing: border-box;
	
	border-radius: 250px;
}

body.page-template-gallery a#prevslide:hover, body.page-template-gallery a#nextslide:hover, body.single-galleries a#prevslide:hover, body.single-galleries a#nextslide:hover { opacity: 1; }
<?php
	}
?>

<?php
	//Check if disable kenburns hover effect
	$tg_disable_hover_kenburns = kirki_get_option('tg_disable_hover_kenburns');
	
	if(empty($tg_disable_hover_kenburns))
	{
?>
.two_cols.gallery .element:hover img, .three_cols.gallery .element:hover img, .four_cols.gallery .element:hover img, .five_cols.gallery .element:hover img, .one_half.gallery2.classic a:hover img, .one_third.gallery3.classic a:hover img, .one_fourth.gallery4.classic a:hover img
{
	-ms-transform: scale(1);
    -moz-transform: scale(1);
    -o-transform: scale(1);
    -webkit-transform: scale(1);
    transform: scale(1);
}
<?php
	}
?>

<?php
	
	$tg_boxed_bg_image = kirki_get_option('tg_boxed_bg_image');
	if(!empty($tg_boxed_bg_image))
	{
?>
body.tg_boxed
{
	background-image: url('<?php echo esc_url($tg_boxed_bg_image); ?>');
}
<?php
	}
?>

<?php
	
	$tg_menu_font_size = kirki_get_option('tg_menu_font_size');
	if(!empty($tg_menu_font_size))
	{
?>
#menu_wrapper .nav li.arrow > a:after, #menu_wrapper div .nav li.arrow > a:after
{
	margin-top: <?php echo intval($tg_menu_font_size-11+3); ?>px;
}
<?php
	}
?>

<?php
	
	$tg_sidebar_title_border = kirki_get_option('tg_sidebar_title_border');
	if(empty($tg_sidebar_title_border))
	{
?>
#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle
{
	padding: 0;
	border: 0;
}
<?php
	}
?>

<?php
	
	$tg_page_title_bg_opacity = kirki_get_option('tg_page_title_bg_opacity');
	if(empty($tg_page_title_bg_opacity))
	{
?>
#page_caption.hasbg .page_title_wrapper
{
	background: rgba(0,0,0,<?php echo esc_attr($tg_page_title_bg_opacity/100); ?>);
}
<?php
	}
?>

<?php
	
	$tg_transparent_menu_border = kirki_get_option('tg_transparent_menu_border');
	if(empty($tg_transparent_menu_border))
	{
?>
html[data-style=fullscreen] .top_bar.hasbg, .top_bar.hasbg
{
	border: 0;
}
<?php
	}
?>

<?php
	
	$tg_transparent_menu_bg_opacity = kirki_get_option('tg_transparent_menu_bg_opacity');
?>
html[data-style=fullscreen] .top_bar.hasbg, .top_bar.hasbg
{
	background: rgba(0,0,0,<?php echo esc_attr($tg_transparent_menu_bg_opacity/100); ?>);
}

<?php
	
	$tg_page_tagline_alignment = kirki_get_option('tg_page_tagline_alignment');
	if($tg_page_tagline_alignment == 'below')
	{
?>
#page_caption.hasbg .page_tagline
{
	clear: both;
	margin-top: 10px;
}
<?php
	}
?>

<?php
	
	$tg_page_title_font_alignment = kirki_get_option('tg_page_title_font_alignment');
	if($tg_page_title_font_alignment == 'left' OR $tg_page_title_font_alignment == 'right')
	{
?>
#page_caption hr.title_break
{
	display: inline-block;
}

#page_caption .page_title_wrapper
{
	margin: 0;
}

.page_tagline
{
	display: block;
	margin: 0;
}
<?php
	}
?>

<?php
	
	$tg_page_title_img_gradient = kirki_get_option('tg_page_title_img_gradient');
	$tg_content_bg_color = kirki_get_option('tg_content_bg_color');
	$rgba_arr = photography_hex_to_rgb($tg_content_bg_color);
		
	if(!empty($tg_page_title_img_gradient))
	{
?>
#page_caption.hasbg #bg_regular::after,
#page_caption.hasbg #bg_blurred::after
{
	content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: transparent;
    background-image: -webkit-gradient(linear,left top,left bottom,from(transparent),color-stop(60%,transparent),color-stop(66%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.1)),color-stop(93%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.95)),to(rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,1)));
    background-image: -webkit-linear-gradient(transparent 0%,transparent 60%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.1) 66%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.95) 93%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,1) 100%);
    background-image: linear-gradient(transparent 0%,transparent 60%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.1) 66%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.95) 93%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,1) 100%)
}
<?php
	}
?>
.bg_gradient::after
{
	content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: -1px;
    left: 0;
    background: transparent;
    background-image: -webkit-gradient(linear,left top,left bottom,from(transparent),color-stop(60%,transparent),color-stop(66%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.1)),color-stop(93%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.95)),to(rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,1)));
    background-image: -webkit-linear-gradient(transparent 0%,transparent 60%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.1) 66%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.95) 93%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,1) 100%);
    background-image: linear-gradient(transparent 0%,transparent 60%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.1) 66%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,0.95) 93%,rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,1) 100%)
}

<?php
	//Get lightbox setting
	$tg_lightbox_enable = kirki_get_option('tg_lightbox_enable');
	$tg_lightbox_plugin = kirki_get_option('tg_lightbox_plugin');
	
	if(!empty($tg_lightbox_enable)) 
	{
		//Get lightbox overlay opacity
		$tg_lightbox_opacity = kirki_get_option('tg_lightbox_opacity');
		$tg_lightbox_opacity = $tg_lightbox_opacity/100;
	
		if($tg_lightbox_plugin == 'modulobox')
		{
			$tg_lightbox_skin = kirki_get_option('tg_lightbox_skin');
			if($tg_lightbox_skin == 'metro-white')
			{
				$bgcolor = '#ffffff';
			}
			else
			{
				$bgcolor = '#000000';
			}
			$rgba_arr = photography_hex_to_rgb($bgcolor);
?>
body.<?php echo esc_attr($tg_lightbox_skin); ?> .mobx-overlay
{
	    background-color: rgba(<?php echo intval($rgba_arr['r']); ?>,<?php echo intval($rgba_arr['g']); ?>,<?php echo intval($rgba_arr['b']); ?>,<?php echo esc_attr($tg_lightbox_opacity); ?>);
}
<?php	
		}
	}
?>

<?php
//Check if enable progressive image option
$tg_enable_lazy_loading = kirki_get_option('tg_enable_lazy_loading');	

if(empty($tg_enable_lazy_loading))
{
?>
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:0.99; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:0.99; } }
@-ms-keyframes fadeIn { from { opacity:0; } to { opacity:0.99; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:0.99; } }
 
.fade-in {
    animation-name: fadeIn;
	-webkit-animation-name: fadeIn;
	-ms-animation-name: fadeIn;	

	animation-duration: 0.7s;	
	-webkit-animation-duration: 0.7s;
	-ms-animation-duration: 0.7s;	

	-webkit-animation-fill-mode:forwards; 
    -moz-animation-fill-mode:forwards;
    -ms-animation-fill-mode:forwards;
    animation-fill-mode:forwards;
    
    visibility: visible !important;
}
<?php
}
?>

<?php
	//Get main menu layout
	$tg_menu_layout = photography_menu_layout();
	
	if($tg_menu_layout == 'centeralogo')
	{
		$logo_margin_left = 96;
		
		//get custom logo
    	$tg_retina_logo = kirki_get_option('tg_retina_logo');

    	if(!empty($tg_retina_logo))
    	{
    		//Get image width and height
		    $image_id = photography_get_image_id($tg_retina_logo);
		    
		    if(!empty($image_id))
		    {
		        $obj_image = wp_get_attachment_image_src($image_id, 'original');
		        
		        $image_width = 0;
			    
			    if(isset($obj_image[1]))
			    {
			    	$image_width = intval($obj_image[1]/2);
			    }
			    
			    $logo_margin_left = intval($image_width/2);
		    }
    	}
?>
@media only screen and (min-width: 960px)
{
	#logo_normal.logo_container
	{
		margin-left: -<?php echo intval($logo_margin_left); ?>px;
	}
<?php
		//get custom logo
    	$tg_retina_transparent_logo = kirki_get_option('tg_retina_transparent_logo');

    	if(!empty($tg_retina_transparent_logo))
    	{
    		//Get image width and height
		    $image_id = photography_get_image_id($tg_retina_transparent_logo);
		    
		    if(!empty($image_id))
		    {
		        $obj_image = wp_get_attachment_image_src($image_id, 'original');
		        
		        $image_width = 0;
			    
			    if(isset($obj_image[1]))
			    {
			    	$image_width = intval($obj_image[1]/2);
			    }
			    
			    $logo_margin_left = intval($image_width/2);
		    }
    	}
?>
	#logo_transparent.logo_container
	{
		margin-left: -<?php echo intval($logo_margin_left); ?>px;
	}
}
<?php
	$tg_topbar = kirki_get_option('tg_topbar');
	
	if(!empty($tg_topbar))
	{
?>
@media only screen and (min-width: 960px)
{
	.top_bar.scroll .logo_container
	{
		top: 15px;
	}
	
	.top_bar .logo_container, .top_bar.scroll_up:not(.scroll) .logo_container
	{
		top: 45px;
	}
}
@media only screen and (max-width: 767px) {
	.top_bar .logo_container
	{
		top: 45px;
	}
}
<?php
	}
?>

<?php
	}
?>

<?php
/**
*	Get custom CSS for Desktop View
**/
$pp_custom_css = get_option('pp_custom_css');


if(!empty($pp_custom_css))
{
    echo stripslashes($pp_custom_css);
}
?>

<?php
/**
*	Get custom CSS for iPad Portrait View
**/
$pp_custom_css_tablet_portrait = get_option('pp_custom_css_tablet_portrait');


if(!empty($pp_custom_css_tablet_portrait))
{
?>
@media only screen and (min-width: 768px) and (max-width: 959px) {
<?php
    echo stripslashes($pp_custom_css_tablet_portrait);
?>
}
<?php
}
?>

<?php
/**
*	Get custom CSS for iPhone Portrait View
**/
$pp_custom_css_mobile_portrait = get_option('pp_custom_css_mobile_portrait');


if(!empty($pp_custom_css_mobile_portrait))
{
?>
@media only screen and (max-width: 767px) {
<?php
    echo stripslashes($pp_custom_css_mobile_portrait);
?>
}
<?php
}
?>

<?php
/**
*	Get custom CSS for iPhone Landscape View
**/
$pp_custom_css_mobile_landscape = get_option('pp_custom_css_mobile_landscape');


if(!empty($pp_custom_css_tablet_portrait))
{
?>
@media only screen and (min-width: 480px) and (max-width: 767px) {
<?php
    echo stripslashes($pp_custom_css_mobile_landscape);
?>
}
<?php
}
?>

<?php
if(!empty($pp_advance_combine_css))
{
	ob_end_flush();
	ob_end_flush();
}
?>