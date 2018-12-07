<?php
if(!function_exists('wpex_template_plugin')){
	function wpex_template_plugin($pageName){
		if (locate_template('wp-timeline/'.$pageName . '.php') != '') {
			get_template_part('wp-timeline/'.$pageName );
		} else {
			include wpex_get_plugin_url().'templates/' . $pageName . '.php';
		}
	}
}
// Query function
if(!function_exists('wpex_timeline_query')){
	function wpex_timeline_query($posttype, $count, $order, $orderby, $cat, $tag, $taxonomy, $meta_key, $ids,$page=false,$mult=false){
		if($orderby == 'timeline_date'){
			$meta_key = 'wptl_orderdate';
			$orderby = 'meta_value_num';
		}
		if($posttype == 'wp-timeline' && $taxonomy == ''){
			$taxonomy = 'wpex_category';
		}
		$posttype = explode(",", $posttype);
		if($ids!=''){ //specify IDs
			$ids = explode(",", $ids);
			$args = array(
				'post_type' => $posttype,
				'posts_per_page' => $count,
				'post_status' => array( 'publish', 'future' ),
				'post__in' =>  $ids,
				'order' => $order,
				'orderby' => $orderby,
				'ignore_sticky_posts' => 1,
			);
		}elseif($ids==''){
			$args = array(
				'post_type' => $posttype,
				'posts_per_page' => $count,
				'post_status' => array( 'publish', 'future' ),
				'tag' => $tag,
				'order' => $order,
				'orderby' => $orderby,
				'meta_key' => $meta_key,
				'ignore_sticky_posts' => 1,
			);
			if(!is_array($cat) && $taxonomy =='') {
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){
					$args['category__in'] = $cats;
				}else{			 
					$args['category_name'] = $cat;
				}
			}elseif(count($cat) > 0 && $taxonomy ==''){
				$args['category__in'] = $cat;
			}
			if($taxonomy !='' && $tag!=''){
				$tags = explode(",",$tag);
				if(is_numeric($tags[0])){$field_tag = 'term_id'; }
				else{ $field_tag = 'slug'; }
				if(count($tags)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($tags as $iterm) {
						  $texo[] = 
							  array(
								  'taxonomy' => $taxonomy,
								  'field' => $field_tag,
								  'terms' => $iterm,
							  );
					  }
				  }else{
					  $texo = array(
						  array(
								  'taxonomy' => $taxonomy,
								  'field' => $field_tag,
								  'terms' => $tags,
							  )
					  );
				}
			}
			//cats
			if($taxonomy !='' && $cat!=''){
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){$field = 'term_id'; }
				else{ $field = 'slug'; }
				if(count($cats)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($cats as $iterm) {
						  $texo[] = 
							  array(
								  'taxonomy' => $taxonomy,
								  'field' => $field,
								  'terms' => $iterm,
							  );
					  }
				  }else{
					  $texo = array(
						  array(
								  'taxonomy' => $taxonomy,
								  'field' => $field,
								  'terms' => $cats,
							  )
					  );
				}
			}
			if(isset($mult) && $mult!=''){
				$texo['relation'] = 'AND';
				$texo[] = 
					array(
						'taxonomy' => 'wpex_category',
						'field' => 'term_id',
						'terms' => $mult,
					);
			}
			if(isset($texo)){
				$args += array('tax_query' => $texo);
			}
		}	
		if(isset($page) && $page!=''){
			$args['paged'] = $page;
		}
		return apply_filters( 'wptimeline_query', $args );
	}
}
//
add_action( 'wp_ajax_wpex_loadmore_timeline', 'ajax_wpex_loadmore_timeline' );
add_action( 'wp_ajax_nopriv_wpex_loadmore_timeline', 'ajax_wpex_loadmore_timeline' );

function ajax_wpex_loadmore_timeline(){
	global $style,$ajax_load,$ID,$animations, $posttype,$show_media, $taxonomy,$full_content,$feature_label,$lightbox,$hide_img,$img_size,$hide_title;
	$year_post = isset($_POST['param_year']) ? $_POST['param_year'] : '';
	$ajax_load =1;
	$atts = json_decode( stripslashes( $_POST['param_shortcode'] ), true );
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'post';
	$count =  isset($atts['count']) ? $atts['count'] :'9';
	$style = isset($atts['style']) ? $atts['style'] : '';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'3';
	$alignment 		= isset($atts['alignment']) && $atts['alignment']!='' ? $atts['alignment'] : 'center';
	$animations 		= isset($atts['animations']) ? $atts['animations'] : '';
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	$img_size 		= isset($atts['img_size']) ? $atts['img_size'] : '';
	$hide_title 		= isset($atts['hide_title']) ? $atts['hide_title'] : '';
	$hide_img 		= isset($atts['hide_img']) ? $atts['hide_img'] : '';
	$feature_label 		= isset($atts['feature_label']) ? $atts['feature_label'] : '';
	$full_content 		= isset($atts['full_content']) ? $atts['full_content'] : '0';
	$lightbox 		= isset($atts['lightbox']) ? $atts['lightbox'] : '0';
	$page = $_POST['page'];
	if($style =='modern'){ $style = 'icon';}
	$param_query = json_decode( stripslashes( $_POST['param_query'] ), true );
	$end_it_nb ='';
	if($page!=''){ 
		$param_query['paged'] = $page;
		$count_check = $page*$posts_per_page;
		if(($count_check > $count) && (($count_check - $count)< $posts_per_page)){$end_it_nb = $count - (($page - 1)*$posts_per_page);}
		else if(($count_check > $count)) {die;}
	}
	$alignment = $alignment =='sidebyside' ? 'center' : $alignment;
	$the_query = new WP_Query( $param_query );
	$it = $the_query->post_count;
	$html = $ft_date = '';
	if($the_query->have_posts()){
		$i =0;
		while($the_query->have_posts()){ $the_query->the_post();
			$i++;
			ob_start();
			if($style =='' || $style =='modern' || $style =='icon'){
				if($alignment=='center'){
					if(isset($atts['alignment']) && $atts['alignment'] =='sidebyside' && $style ==''){
						wpex_template_plugin('content-sbs-classic');
					}else{
						wpex_template_plugin('content-timeline-center');
					}
				}else{
					wpex_template_plugin('content-timeline');
				}
			}else{
				wpex_template_plugin('content-timeline-'.$style);
			}
			$content = ob_get_clean();
			$html .= $content;
			if($posttype == 'wp-timeline'){
				$wpex_date = wpex_date_tl();
			}else{
				$wpex_date = get_the_date( get_option( 'date_format' ) );
			}
			$ft_date .='<span id="filter-'.$ID.'_'.get_the_ID().'">'.$wpex_date.'</span>';
			if($end_it_nb!='' && $end_it_nb == $i){break;}
		}
	}
	$output =  array('html_content'=>$html,'date'=> $ft_date);
	echo str_replace('\/', '/', json_encode($output));
	die;
}
// filter category
add_action( 'wp_ajax_wpex_filter_taxonomy', 'ajax_wpex_filter_taxonomy' );
add_action( 'wp_ajax_nopriv_wpex_filter_taxonomy', 'ajax_wpex_filter_taxonomy' );

function ajax_wpex_filter_taxonomy(){
	global $style, $ajax_load, $ID, $animations,$posttype,$show_media,$full_content,$feature_label,$lightbox,$hide_img;
	$ajax_load =1;
	$atts = json_decode( stripslashes( $_POST['param_shortcode'] ), true );
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'post';
	$count =  isset($atts['count']) ? $atts['count'] :'9';
	$style = isset($atts['style']) ? $atts['style'] : '';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'3';
	$alignment 		= isset($atts['alignment']) && $atts['alignment']!='' ? $atts['alignment'] : 'center';
	$animations 		= isset($atts['animations']) ? $atts['animations'] : '';
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	
	$cat 		= isset($_POST['taxonomy_id']) && $_POST['taxonomy_id']!='all' ? $_POST['taxonomy_id'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '9';
	$posts_per_page 		= isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '3';
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$taxonomy 		= isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
	$feature_label 		= isset($atts['feature_label']) ? $atts['feature_label'] : '';
	$hide_img 		= isset($atts['hide_img']) ? $atts['hide_img'] : '';
	$full_content 		= isset($atts['full_content']) ? $atts['full_content'] : '0';
	
	$lightbox 		= isset($atts['lightbox']) ? $atts['lightbox'] : '0';
	
	$page = $_POST['page'];
	if($style =='modern'){ $style = 'icon';}
	if($posts_per_page =="" || $posts_per_page > $count){$posts_per_page = $count;}
	$args = wpex_timeline_query($posttype, $posts_per_page, $order, $orderby, $cat, $tag, $taxonomy, $meta_key, $ids);
	$the_query = new WP_Query( $args );
	$it = $the_query->found_posts;
	$html = $ft_date = '';
	if($the_query->have_posts()){
		while($the_query->have_posts()){ $the_query->the_post();
			ob_start();
			if($style =='bg' || $style =='wide_img' || $style =='simple' || $style =='clean'){
				wpex_template_plugin('content-timeline-'.$style);
			}else{
				if($alignment=='center'){
					wpex_template_plugin('content-timeline-center');
				}else{
					wpex_template_plugin('content-timeline');
				}
			}
			$content = ob_get_clean();
			$html .= $content;
			if($posttype == 'wp-timeline'){
				$wpex_date = wpex_date_tl();
			}else{
				$wpex_date = get_the_date( get_option( 'date_format' ) );
			}
			$ft_date .='<span id="filter-'.$ID.'_'.get_the_ID().'">'.$wpex_date.'</span>';
		}
	}
	$output =  array('html_content'=>$html,'date'=> $ft_date,'more'=> $it > $posts_per_page ? 1: 0, 'data_query'=> $args);
	echo str_replace('\/', '/', json_encode($output));
	die;
}
// filter year
add_action( 'wp_ajax_wpex_filter_year', 'ajax_wpex_filter_year' );
add_action( 'wp_ajax_nopriv_wpex_filter_year', 'ajax_wpex_filter_year' );

function ajax_wpex_filter_year(){
	global $style, $ajax_load, $ID, $animations,$posttype,$show_media;
	$ajax_load =1;
	$atts = json_decode( stripslashes( $_POST['param_shortcode'] ), true );
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'post';
	$count =  isset($atts['count']) ? $atts['count'] :'9';
	$style = isset($atts['style']) ? $atts['style'] : '';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'3';
	$alignment 		= isset($atts['alignment']) && $atts['alignment']!='' ? $atts['alignment'] : 'center';
	$animations 		= isset($atts['animations']) ? $atts['animations'] : '';
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	
	$cat 		= isset($_POST['taxonomy_id']) && $_POST['taxonomy_id']!='all' ? $_POST['taxonomy_id'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '9';
	$posts_per_page 		= isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '3';
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$taxonomy 		= 'wpex_year';
	
	
	$page = $_POST['page'];
	if($style =='modern'){ $style = 'icon';}
	$args = wpex_timeline_query($posttype, -1, $order, $orderby, $cat, $tag, $taxonomy, $meta_key, $ids,'', $_POST['mult']);
	//print_r($args);
	$the_query = new WP_Query( $args );
	$html = $ft_date = '';
	if($the_query->have_posts()){
		while($the_query->have_posts()){ $the_query->the_post();
			ob_start();
			if($style =='bg'){
				wpex_template_plugin('content-timeline-bg');
			}else{
				if($alignment=='center'){
					wpex_template_plugin('content-timeline-center');
				}else{
					wpex_template_plugin('content-timeline');
				}
			}
			$content = ob_get_clean();
			$html .= $content;
			if($posttype == 'wp-timeline'){
				$wpex_date = wpex_date_tl();
			}else{
				$wpex_date = get_the_date( get_option( 'date_format' ) );
			}
			$ft_date .='<span id="filter-'.$ID.'_'.get_the_ID().'">'.$wpex_date.'</span>';
		}
	}
	$output =  array('html_content'=>$html,'massage'=> esc_html__('Nothing Found','wp-timeline'));
	echo str_replace('\/', '/', json_encode($output));
	die;
}

// google font
if(!function_exists('wpex_startsWith')){
	function wpex_startsWith($haystack, $needle)
	{
		return !strncmp($haystack, $needle, strlen($needle));
	}
}
if(!function_exists('wptlex_get_google_fonts_url')){
	function wptlex_get_google_fonts_url ($font_names) {
	
		$font_url = '';
	
		$font_url = add_query_arg( 'family', urlencode(implode('|', $font_names)) , "//fonts.googleapis.com/css" );
		return $font_url;
	} 
}
if(!function_exists('wptlex_get_google_font_name')){
	function wptlex_get_google_font_name($family_name){
		$name = $family_name;
		if(wpex_startsWith($family_name, 'http')){
			// $family_name is a full link, so first, we need to cut off the link
			$idx = strpos($name,'=');
			if($idx > -1){
				$name = substr($name, $idx);
			}
		}
		$idx = strpos($name,':');
		if($idx > -1){
			$name = substr($name, 0, $idx);
			$name = str_replace('+',' ', $name);
		}
		return $name;
	}
}
if(!function_exists('wpex_custom_link')){
	function wpex_custom_link(){
		$custom_link = esc_url(get_post_meta( get_the_ID(), 'wpex_link', true ));
		$wpex_disable_link = get_option('wpex_disable_link');
		if($custom_link=='' && $wpex_disable_link!='yes'){
			$custom_link = get_permalink(get_the_ID());
		}elseif($wpex_disable_link=='yes' && $custom_link ==''){
			$custom_link ='javascript:;';
		}
		return apply_filters( 'wptimeline_link', $custom_link );
	}
}
if(!function_exists('wpex_next_previous_timeline')){
	function wpex_next_previous_timeline($preevtrsl,$nextevtrsl){
			global $post;
			$value = get_post_meta( $post->ID, 'wpex_order', true );
			$args = array( 'post_type' => 'wp-timeline', 'posts_per_page' => 1, 'orderby'=> 'meta_value_num', 'order' => 'ASC','meta_key' => 'wpex_order', 'meta_value' => $value,  'meta_compare' => '>', 'meta_type'=> 'NUMERIC' );
			$post_nex = get_posts( $args );
			$next_l ='';
			foreach ( $post_nex as $post ){
				$next_l = get_the_permalink($post->ID);
			} 
			wp_reset_postdata();
			$previous_l = '';
			/*$args_fix = array( 
				'post_type' => 'wp-timeline', 
				'posts_per_page' => 1, 
				'orderby'=> 'meta_value_num', 
				'order' => 'DESC',
				'meta_key' => 'wpex_order', 
				'meta_value' => ($value - 1),  
				'meta_compare' => '=', 
				'meta_type'=> 'NUMERIC'
			);
			$post_fix = get_posts( $args_fix );
			foreach ( $post_fix as $post ){
				$previous_l = get_the_permalink($post->ID);
			}
			wp_reset_postdata();*/
			if($previous_l == ''){
				$args_pre = array( 
					'post_type' => 'wp-timeline', 
					'posts_per_page' => 1, 
					'orderby'=> 'meta_value_num', 
					'order' => 'DESC',
					'meta_key' => 'wpex_order', 
					'meta_value' => $value,
					'meta_compare' => '<', 
					'meta_type'=> 'NUMERIC'
				);
				$post_pre = get_posts( $args_pre );
				foreach ( $post_pre as $post ){
					$previous_l = get_the_permalink($post->ID);
				}
				wp_reset_postdata();
			}
			$html ='<div class="timeline-navigation">';
			if($previous_l!=''){
					$html .='<div class="previous-timeline"><a href="'.$previous_l.'" class="btn btn-primary"><i class="fa fa-angle-double-left"></i>'.$preevtrsl.'</a></div>';
			}
			if($next_l!=''){
					$html .='<div class="next-timeline"><a href="'.$next_l.'" class="btn btn-primary">'.$nextevtrsl.'<i class="fa fa-angle-double-right"></i></a></div>';
			}
			$html .='</div><div class="clear"></div>';
			echo  $html;
	}
}

if(!function_exists('wpex_safe_strtotime')){
	function wpex_safe_strtotime($string,$fm)
	{
		if(!preg_match("/\d{4}/", $string, $match)) return null; //year must be in YYYY form
		if($fm != ''){
			$date_fm = $fm;
		}else{
			$date_fm =  get_option('date_format');
		}
		$year = intval($match[0]);//converting the year to integer
		if($year >= 1970 && $year < 2036) return date_i18n( $date_fm, strtotime($string));//the year is after 1970
		if(stristr(PHP_OS, "WIN") && !stristr(PHP_OS, "DARWIN")) //OS seems to be Windows, not Unix nor Mac
		{
			$diff = 1975 - $year;//calculating the difference between 1975 and the year
			$new_year = $year + $diff;//year + diff = new_year will be for sure > 1970
			$new_date = date_i18n( $date_fm, strtotime(str_replace($year, $new_year, $string)));//replacing the year with the new_year, try strtotime, rendering the date
			return str_replace($new_year, $year, $new_date);//returning the date with the correct year
		}
		return date_i18n( $date_fm,strtotime($string));//do normal strtotime
	}
}

if(!function_exists('wpex_date_tl')){
	function wpex_date_tl() {
		$wpex_date = get_post_meta( get_the_ID(), 'wpex_date', true );
		if($wpex_date==''){
			$wpex_date = wpex_safe_strtotime(get_post_meta( get_the_ID(), 'wpex_pkdate', true ),'');
		}
		return $wpex_date;
	}
}

if(!function_exists('wpex_post_class')){
	add_filter('post_class', 'wpex_post_class', 10,3);
	function wpex_post_class($classes, $class, $post_id){
		//check if some meta field is set 
		$wpex_link = get_post_meta($post_id, 'wpex_link', true);
		if ($wpex_link!='') {
			$classes[] = 'wptl-customlink'; //add a custom class
		}	 
		// Return the array
		return $classes;
	}
}