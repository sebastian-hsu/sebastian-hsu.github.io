;(function($){
	$(document).ready(function($) {
		function wpex_isScrolledInto_View(elem){ //in visible
			var docViewTop = jQuery(window).scrollTop();
			var docViewBottom = docViewTop + jQuery(window).height();
			var elemTop = jQuery(elem).offset().top;
			var elemBottom = elemTop + jQuery(elem).height();
			return ((elemBottom <= docViewBottom + 200) && (elemTop >= docViewTop));
		}
		function wpex_infinite_scroll(){
			$('.wpex-timeline-list.wpex-infinite').each(function(){
				var Id_tm = jQuery(this).attr("id");
				if(!$("#"+Id_tm+" .wpex-loadmore a.loadmore-timeline").length ){
					return;
				}
				var $loadmore = $("#"+Id_tm+" .wpex-loadmore a.loadmore-timeline");
				if (wpex_isScrolledInto_View("#"+Id_tm+" .wpex-loadmore a.loadmore-timeline") && !$loadmore.hasClass('loading') && !$("#"+Id_tm+" .wpex-loadmore").hasClass('hidden')) {
					//alert('okk');
					$loadmore.trigger('click');
				}
			});
		}
		function wpex_timeline_scroll(){
			var $this = $(this);
			$(".wpex-timeline-list").each(function(){
				var Id_tm = jQuery(this).attr("id");
				var this_tl = $(this);
				var $tl_top = this_tl.offset().top;
				var $tl_end = $tl_top + this_tl.height();
				$tl_top =  $tl_top -200;
				$tl_end =  $tl_end;
				if (($(document).scrollTop() >= $tl_top) && ($(document).scrollTop() <= $tl_end)) {
					$("#"+Id_tm+" .wpex-filter").addClass('active');
				}else{
					$("#"+Id_tm+" .wpex-filter").removeClass('active');
				}
				var windowHeight = $(window).height(),
				gridTop = windowHeight * .3;
				var scrollTop = $this.scrollTop();
				$("#"+Id_tm+" ul li").each(function(){
					var ftid = $(this).data('id');
					var thisTop = $(this).offset().top - $(window).scrollTop();
					var thisBt =  thisTop + $(this).height(); 
					if (thisTop >= gridTop) {
						$('#'+ftid).removeClass('active');
					} else {
						$('#'+ftid).addClass('active');
					}
					/*-- If animation enable --*/
					var animations  		= $("#"+Id_tm).data('animations');
					if((animations !='') && (thisTop < windowHeight * .7)){
						$(this).children(":first").removeClass('scroll-effect').addClass( animations+' animated');
					}
					/*var topDistance = $(this).offset().top;
					var ftid = $(this).data('id');
					var btDistance = topDistance + $(this).height();
					if ( (scrollTop >= topDistance) && ( scrollTop <= btDistance)) {
						$('#'+ftid).addClass('active');
					}else {
						$('#'+ftid).removeClass('active');
					}*/
				});
			});
		};
		$(".wpex-filter:not(.year-ft)").on('click', 'div span',function() {
			var contenId = jQuery(this).attr("id");
			var windowHeight = $(window).height();
			$('html,body').animate({
				scrollTop: $("."+contenId).offset().top - windowHeight * .2},
				'slow');
		});
		if($(".wpex-timeline-list").length ){
			wpex_timeline_scroll();
			wpex_infinite_scroll()
			$(document).scroll(function() {
				wpex_timeline_scroll();
				wpex_infinite_scroll()
			});
		}
		/*--year filter--*/
		$(".wpex-filter.year-ft").on('click', 'div span',function() {
			var $this_click = $(this);
			var timelineId = jQuery(this).data('id');
			$('#timeline-'+timelineId).addClass("loading no-more");
			var id_crsc = 'timeline-'+timelineId;
			$('#'+id_crsc+' .wpex-filter.year-ft div span').removeClass("active");
			$this_click.addClass('active');
			var tax = jQuery(this).data('value');
			var mult ='';
			if($('#'+id_crsc+' .wpex-taxonomy-filter li a.active').length ){
				mult = $('#'+id_crsc+' .wpex-taxonomy-filter li a.active').data('value');
			}
			var ajax_url  		= $('#timeline-'+timelineId+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#timeline-'+timelineId+' input[name=param_shortcode]').val();
			$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
			$('#timeline-'+timelineId+' ul.wpex-timeline li').fadeOut(300, function() { $(this).remove(); });
			var param = {
				action: 'wpex_filter_year',
				taxonomy_id : tax,
				mult : mult,
				param_shortcode: param_shortcode,
			};
			$.ajax({
				type: "post",
				url: ajax_url,
				dataType: 'json',
				data: (param),
				success: function(data){
					if(data != '0')
					{
						if(data != ''){ 
							var $_container = $('#'+id_crsc+' ul.wpex');
							$_container.html('');
							if(data.html_content != ''){ 
								$('#'+id_crsc+' .wpex-tltitle.wpex-loadmore').prepend('<span class="yft">'+$this_click.html()+'</span>');
								$('#'+id_crsc+' .wpex-loadmore:not(.lbt)').removeClass("hidden");
								$_container.append(data.html_content);
							}else{
								$('#'+id_crsc+' .wpex-loadmore').addClass("hidden");
								$_container.append('<h2 style="text-align: center;">'+data.massage+'</h2>');
							}
							setTimeout(function(){ 
								$('#'+id_crsc+' ul.wpex > li').addClass("active");
							}, 200);
							$('#'+id_crsc).removeClass("loading");
						}
						wpex_timeline_scroll();
						wpex_infinite_scroll();
						$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
					}else{$('.row.loadmore').html('error');}
				}
			});
			return false;
		});
		/*--Taxonomy filter--*/
		$(".wpex-taxonomy-filter").on('click', 'li a',function() {
			var $this_click = $(this);
			var timelineId = jQuery(this).data('id');
			var id_crsc = 'timeline-'+timelineId;
			$('#timeline-'+timelineId+' .wpex-taxonomy-filter li a').removeClass("active");
			$('#'+id_crsc+' .wpex-filter.year-ft div span').removeClass("active");
			$('#'+id_crsc+' .wpex-loadmore').removeClass("hidden");
			$this_click.addClass('active');
			var tax = jQuery(this).data('value');
			var ajax_url  		= $('#timeline-'+timelineId+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#timeline-'+timelineId+' input[name=param_shortcode]').val();
			$('#timeline-'+timelineId).addClass("loading");
			$('#timeline-'+timelineId+' ul.wpex-timeline li').fadeOut(300, function() { $(this).remove(); });
			$('#'+id_crsc+' input[name=num_page_uu]').val(1);
			$('#'+id_crsc+' input[name=current_page]').val(1);
			$('#'+id_crsc+' .wpex-tltitle.wpex-loadmore .yft').remove();
			var param = {
				action: 'wpex_filter_taxonomy',
				taxonomy_id : tax,
				param_shortcode: param_shortcode,
			};
			$.ajax({
				type: "post",
				url: ajax_url,
				dataType: 'json',
				data: (param),
				success: function(data){
					if(data != '0')
					{
						if(data == ''){ 
							$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
						}
						else{
							var $_container = $('#'+id_crsc+' ul.wpex');
							$_container.html('');
							$_container.append(data.html_content);
							$('#'+id_crsc+' .wpex-filter:not(.year-ft) div span').remove();
							$('#'+id_crsc+' .wpex-filter:not(.year-ft) div').append(data.date);
							setTimeout(function(){ 
								$('#'+id_crsc+' ul.wpex > li').addClass("active");
							}, 200);
							$('#'+id_crsc).removeClass("loading");
							$('#'+id_crsc+' input[name=param_query]').val(JSON.stringify(data.data_query));
						}
						if(data.more != 1){
							$('#'+id_crsc).addClass("no-more");
							$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
						}else{
							$('#'+id_crsc).removeClass("no-more");
						}
						wpex_timeline_scroll();
						$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
					}else{$('.row.loadmore').html('error');}
				}
			});
			return false;
		});
		/*-loadmore-*/
		$('.loadmore-timeline').on('click',function() {
			var $this_click = $(this);
			$this_click.addClass('disable-click');
			var id_crsc  		= $this_click.data('id');
			var n_page = $('#'+id_crsc+' input[name=num_page_uu]').val();
			$('#'+id_crsc+' .loadmore-timeline').addClass("loading");
			var param_query  		= $('#'+id_crsc+' input[name=param_query]').val();
			var page  		= $('#'+id_crsc+' input[name=current_page]').val();
			var num_page  		= $('#'+id_crsc+' input[name=num_page]').val();
			var ajax_url  		= $('#'+id_crsc+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#'+id_crsc+' input[name=param_shortcode]').val();
			var crr_y = '';
			if($('#'+id_crsc+' li:last-child > input.crr-year').length){
				crr_y = $('#'+id_crsc+' li:last-child > input.crr-year').val();
			}
				var param = {
					action: 'wpex_loadmore_timeline',
					param_query: param_query,
					page: page*1+1,
					param_shortcode: param_shortcode,
					param_year: crr_y,
				};
	
				$.ajax({
					type: "post",
					url: ajax_url,
					dataType: 'json',
					data: (param),
					success: function(data){
						if(data != '0')
						{
							n_page = n_page*1+1;
							$('#'+id_crsc+' input[name=num_page_uu]').val(n_page)
							if(data.html_content == ''){ 
								$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
							}
							else{
								$('#'+id_crsc+' input[name=current_page]').val(page*1+1);
								var $_container = $('#'+id_crsc+' ul.wpex');
								$_container.append(data.html_content);
								$('#'+id_crsc+' .wpex-filter:not(.year-ft) div').append(data.date);
								setTimeout(function(){ 
									$('#'+id_crsc+' ul.wpex > li').addClass("active");
								}, 200);
							}
							if(n_page == num_page){
								$('#'+id_crsc).addClass("no-more");
								$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
							}
							wpex_timeline_scroll();
							$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
							$('#'+id_crsc+' .loadmore-timeline').removeClass("loading");
							$this_click.removeClass('disable-click');
						}else{$('.row.loadmore').html('error');}
					}
				});
			return false;	
		});
		/*----*/
		$(".wpex-timeline-list .wpex-filter").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
		$(".wpex-timeline-list .wpex-filter > .fa").on('click',function() {
			var id_crsc  		= $(this).data('id');
			if(!$('#'+id_crsc+' .wpex-filter').hasClass('show-filter')){
				$('#'+id_crsc+' .wpex-filter').addClass('show-filter');
				$('#'+id_crsc+' .wpex-filter').css("right", 0);
			}else{
				$('#'+id_crsc+' .wpex-filter').removeClass('show-filter');
				$('#'+id_crsc+' .wpex-filter').css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
			}
		});
		if($(".wpex-timeline-list").length){
			var $tl_top = $(".wpex-timeline-list").offset().top;
			var $tl_end = $tl_top + $(".wpex-timeline-list ul").height();
			if (($(document).scrollTop() >= $tl_top) && ($(document).scrollTop() <= $tl_end)) {
				/*//$(".wpex-timeline-list .wpex-filter").addClass('active');*/
			}
		}
		/*--Light box--*/
		wpex_timeline_lightbox();
		function wpex_timeline_lightbox(){
			$('.wpex-timeline-list').each(function(){
				var $this = $(this);
				var id =  $this.attr("id");
				if($($this).hasClass('wptl-lightbox')){
					if($('#'+id).hasClass('left-tl') && $('#'+id).hasClass('show-icon')){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .wpex-content-left > a',
							useHistoryApi: true
						});
					}else if($('#'+id).hasClass('show-clean')){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: ' .wpex-timeline-label > a',
							useHistoryApi: true
						});
					}else if($('#'+id).hasClass('show-wide_img') || $('#'+id).hasClass('show-simple-bod')){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: ' .timeline-details > a',
							useHistoryApi: true
						});
					}else if($('#'+id).hasClass('left-tl') || ($('#'+id).hasClass('center-tl') && !$('#'+id).hasClass('show-icon'))){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .wpex-timeline-time > a',
							useHistoryApi: true
						});
					}else{
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .timeline-details > a',
							useHistoryApi: true
						});
					}
				}
			});
		}
		/*--Slider timeline--*/
		$('.horizontal-timeline.ex-multi-item').each(function(){
			var $this = $(this);
			var id =  $this.data('id');
			var slidesshow =  $this.data('slidesshow');
			var startit =  $this.data('startit') > 0 ? $this.data('startit') : 1;
			var auto_play = $this.data('autoplay');
			var auto_speed = $this.data('speed');
			var rtl_mode = $this.data('rtl');
			var start_on =  $this.data('start_on') > 0 ? $this.data('start_on') : 0;
			$('#'+id+' .horizontal-nav').EX_ex_s_lick({
				infinite: false,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',	
				slidesToShow: slidesshow,
				slidesToScroll: 1,
				dots: false,
				autoplay: auto_play==1 ? true : false,
				autoplaySpeed: auto_speed!='' ? auto_speed : 3000,
				arrows: true,
				centerMode:  false,
				focusOnSelect: true,
				adaptiveHeight: true,
				responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 1,
					  }
					},
					{
					  breakpoint: 768,
					  settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					}
				  ]
				
			});
		});
		$('.horizontal-timeline:not(.ex-multi-item) ul.horizontal-nav li').on('click',function() {
			$(this).prevAll().addClass('prev_item');
			$(this).nextAll().removeClass('prev_item');
		});
		$(window).resize(function() {
			$('.horizontal-timeline:not(.ex-multi-item)').each(function(){
				var $this = $(this);
				setTimeout(function() {
					var id =  $this.data('id');
					var $slide = $('#'+id+' ul.horizontal-nav li.ex_s_lick-current');
					var crrleft = $slide.offset();
					var ct_left = $('#'+id+' .horizontal-nav').offset();
					var ct_width = $slide.width();
					var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
					$('#'+id+' .timeline-pos-select').css( 'width',ps_width);
				}, 200);
			});
		});
		$('.horizontal-timeline:not(.ex-multi-item)').each(function(){
			var $this = $(this);
			if($this.hasClass('tl-hozsteps')){center_mode = false}
			var style = $this.data('layout');
			var id =  $this.data('id');
			var count_it =  $this.data('count');
			var slidesshow =  $this.data('slidesshow');
			var arrowpos =  $this.data('arrowpos');
			var startit =  $this.data('startit') > 0 ? $this.data('startit') : 1;
			var auto_play = $this.data('autoplay');
			var auto_speed = $this.data('speed');
			var rtl_mode = $this.data('rtl');
			
			var start_on =  $this.data('start_on') > 0 ? $this.data('start_on') : 0;
			
			var center_mode = $this.data('center');
			
			$('#'+id+' .horizontal-content')
			
			.on('beforeChange', function(event, EX_ex_s_lick, currentSlide, nextSlide){
				$li_curr = nextSlide + 1;
				$('#'+id+' .horizontal-nav li.ex_s_lick-slide:nth-child('+$li_curr+')').prevAll().addClass('prev_item');
				$('#'+id+' .horizontal-nav li.ex_s_lick-slide:nth-child('+$li_curr+')').nextAll().removeClass('prev_item');
			  }
			)
			.on('afterChange', function(event, EX_ex_s_lick, direction,nextSlide){
				for (var i = 0; i < EX_ex_s_lick.$slides.length; i++)
				{
					var $slide = $(EX_ex_s_lick.$slides[i]);
					if ($slide.hasClass('ex_s_lick-current')) {
						/* update width */
						$pos_c = i + 1;
						//var $slide = $(EX_ex_s_lick.$slides[i]);
						var $slide = $('#'+id+' ul.horizontal-nav li:nth-child('+$pos_c+')');
						var crrleft = $slide.offset();
						var ct_left = $('#'+id+' .horizontal-nav').offset();
						var ct_width = $slide.width();
						var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
						$('#'+id+' .timeline-pos-select').css( 'width',ps_width);
						
						
						$slide.removeClass('prev_item');
						$slide.nextAll().removeClass('prev_item');
						break;
					}
				}
			  }
			)
			
			.EX_ex_s_lick({
				infinite: false,
				speed:auto_speed!='' ? auto_speed : 250,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight:true,
				autoplay: auto_play==1 && count_it <= slidesshow ? true : false,
				arrows: arrowpos !='top' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',
				fade: true,
				asNavFor: '#'+id+' .horizontal-nav',
			});
			$('#'+id+' .horizontal-nav')
			.on('init', function(event, EX_ex_s_lick, direction){
				if(start_on!='' && $.isNumeric(start_on)){
					var $slide = $(EX_ex_s_lick.$slides[start_on]);
					$slide.addClass('ex_s_lick-current');
					$(EX_ex_s_lick.$slides[0]).removeClass('ex_s_lick-current');
					$slide.nextAll().removeClass('prev_item');
					$slide.prevAll().addClass('prev_item');
				}else{
					var $slide = $(EX_ex_s_lick.$slides[0]);
				}
				//console.log($slide);
				if ($slide.hasClass('ex_s_lick-current')) {
					var crrleft = $slide.offset();
					var ct_left = $('#'+id+' .horizontal-nav').offset();
					var ct_width = $slide.width();
					var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
				}
				$('#'+id+' .timeline-pos-select').css( 'width',ps_width);
			})
			.EX_ex_s_lick({
				infinite: false,
				speed:auto_speed!='' ? auto_speed : 250,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',	
				slidesToShow: slidesshow,
				slidesToScroll: 1,
				asNavFor: '#'+id+' .horizontal-content',
				dots: false,
				autoplay: auto_play==1 ? true : false,
				autoplaySpeed: auto_speed!='' ? auto_speed : 3000,
				arrows: arrowpos =='top' ? true : false,
				centerMode: center_mode !='left' ? true : false,
				focusOnSelect: true,
				
				
				responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 1,
					  }
					},
					{
					  breakpoint: 600,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 1
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					}
				  ]
				
			});
		});
	});
}(jQuery));

