<?php

add_action( 'wp_enqueue_scripts', 'photography_parent_theme_enqueue_styles',9999 );

function photography_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'photography-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'flexboxgrid-style',
        get_stylesheet_directory_uri() . '/css/flexboxgrid.min.css',
        array( 'photography-style' )
    );
     wp_enqueue_script( 'main',
       get_stylesheet_directory_uri() . '/js/main.js'
   );
    
    wp_enqueue_style( 'costom-style',
        get_stylesheet_directory_uri() . '/css/style.css',
        array( 'photography-style')
    );

}

function ml_get_icl_post_languages(){
  $languages = icl_get_languages('skip_missing=1');
  if(1 < count($languages)){
    return '<li><a href="'.$languages['zh-hant']['url'].'" class="active_'.$languages['zh-hant']['active'].'">中</a></li><span>|</span><li><a href="'.$languages['en']['url'].'" class="active_'.$languages['en']['active'].'">En</a></li>';
  }
}
add_shortcode('ks_show_ml', 'ml_get_icl_post_languages');

//修正管理後台顯示
function clean_my_admin_head() {
	$screen = get_current_screen();
	$str = '';
	if (is_admin() && ($screen->id == 'dashboard')) {
		$str .= '<style>#wp-version-message { display: none; } #footer-upgrade {display: none;}</style>';
	}
	echo $str;
}
add_action('admin_head', 'clean_my_admin_head');
//優化主題樣式相關
function optimize_theme_setup() {
	//整理head資訊
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_shortlink_wp_head');
	add_filter('the_generator', '__return_false');
	add_filter('show_admin_bar', '__return_false');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'feed_links_extra', 3);
	//移除css, js資源載入時的版本資訊
	function remove_version_query($src) {
		if (strpos($src, 'ver=')) {
			$src = remove_query_arg('ver', $src);
		}
		return $src;
	}
	add_filter('style_loader_src', 'remove_version_query', 999);
	add_filter('script_loader_src', 'remove_version_query', 999);
	add_filter('widget_text', 'do_shortcode');
	add_filter('xmlrpc_enabled', '__return_false');
	//移除 JSON API 與一些系統功能
	// Filters for WP-API version 1.x
	add_filter('json_enabled', '__return_false');
	add_filter('json_jsonp_enabled', '__return_false');
	// Filters for WP-API version 2.x
	add_filter('rest_enabled', '__return_false');
	add_filter('rest_jsonp_enabled', '__return_false');
	// Remove the REST API lines from the HTML Header
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);
	// Remove the REST API endpoint.
	remove_action('rest_api_init', 'wp_oembed_register_route');
	// Turn off oEmbed auto discovery.
	add_filter('embed_oembed_discover', '__return_false');
	// Don't filter oEmbed results.
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
	// Remove oEmbed discovery links.
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action('wp_head', 'wp_oembed_add_host_js');
	function chuck_disable_rest_endpoints($access) {
		if (!is_user_logged_in()) {
			return new WP_Error('rest_cannot_access', __('Only authenticated users can access the REST API.', 'disable-json-api'), array('status' => rest_authorization_required_code()));
		}
		return $access;
	}
	add_filter('rest_authentication_errors', 'chuck_disable_rest_endpoints');
	// remove x-pingback HTTP header
	add_filter('wp_headers', function ($headers) {
		unset($headers['X-Pingback']);
		return $headers;
	});
	// disable pingbacks
	add_filter('xmlrpc_methods', function ($methods) {
		unset($methods['pingback.ping']);
		return $methods;
	});
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	load_theme_textdomain( 'photography-translation', get_stylesheet_directory().'/languages/photography' );
	$textdomain = 'exc_mb';
        $locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );
        // By default, try to load language files from /wp-content/languages/custom-meta-boxes/
        load_textdomain( $textdomain, get_stylesheet_directory() . '/languages/custom-meta-boxes/' . $textdomain . '-' . $locale . '.mo' );
        load_textdomain( $textdomain, get_stylesheet_directory() . '/languages/wp-timeline/wp-timeline-' . $locale . '.mo' );
	load_textdomain( 'wp-timeline', get_stylesheet_directory() . '/languages/wp-timeline/wp-timeline-' . $locale . '.mo' );
}
add_action('after_setup_theme', 'optimize_theme_setup');

function ks_set_image_meta_upon_image_upload($post_ID) {

	if (wp_attachment_is_image($post_ID)) {
		$my_image_title = get_post($post_ID)->post_title;
		$my_image_title = preg_replace('%\s*[-_\s]+\s*%', ' ', $my_image_title);
		$my_image_title = ucwords(strtolower($my_image_title));
		$my_image_meta = array(
			'ID' => $post_ID,
			'post_title' => $my_image_title,
			'post_excerpt' => $my_image_title,
			'post_content' => $my_image_title,
		);
		update_post_meta($post_ID, '_wp_attachment_image_alt', $my_image_title);
		wp_update_post($my_image_meta);
	}
}
add_action('add_attachment', 'ks_set_image_meta_upon_image_upload');
/*
add_action('send_headers', function(){ 
    // Enforce the use of HTTPS
	//header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
	// Prevent Clickjacking
	header("X-Frame-Options: SAMEORIGIN");
	// Prevent XSS Attack
	//header("Content-Security-Policy: default-src 'self';"); // FF 23+ Chrome 25+ Safari 7+ Opera 19+
	//header("X-Content-Security-Policy: default-src 'self';"); // IE 10+
	// Block Access If XSS Attack Is Suspected
	//header("X-XSS-Protection: 1;");// mode=block");
	// Prevent MIME-Type Sniffing
	header("X-Content-Type-Options: nosniff");
	// Referrer Policy
	header("Referrer-Policy: no-referrer-when-downgrade");
}, 1);
//add_action( 'send_headers', 'send_frame_options_header', 10, 0 );
*/
function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url(/wp-content/uploads/2018/07/中研院網站_最新消息_RWD-1-02w132.png) !important;
    background-size: 300px 200px !important;
    width: 300px !important;
    height: 200px !important; }
    </style>';
}
add_action('login_head', 'custom_login_logo');

function fixed_static_html_css() {
    echo '<style type="text/css">
.page-id-6217.three_cols.gallery:not(.mixed_grid) .element.masonry, .three_cols.gallery:not(.mixed_grid) .element:nth-child(3n){
margin-right: 15px;
}
    </style>';
}
///add_action('wp_footer', 'fixed_static_html_css');

