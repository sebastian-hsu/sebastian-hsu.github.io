<?php header("content-type: application/x-javascript"); 

$wrapper_id = '';
$gallery_id = '';
$items = 1;
$columns = 2;
$type = 'grid';
$current_page_id = '';
$gutter = 30;
$layout = 'contain';
$action = 'photography_portfolio_grid';

if(isset($_GET['id']) && !empty($_GET['id']))
{
	$wrapper_id = $_GET['id'];
}

if(isset($_GET['cat']))
{
	$cat = $_GET['cat'];
}

if(isset($_GET['items']))
{
	$items = $_GET['items'];
}

if(isset($_GET['items_ini']))
{
	$items_ini = $_GET['items_ini'];
}

if(isset($_GET['columns']))
{
	$columns = $_GET['columns'];
}

if(isset($_GET['type']))
{
	$type = $_GET['type'];
}

if(isset($_GET['order']))
{
	$order = $_GET['order'];
}

if(isset($_GET['order_by']))
{
	$order_by = $_GET['order_by'];
}

if(isset($_GET['next_action']))
{
	$action = $_GET['next_action'];
}

if(isset($_GET['current_page_id']))
{
	$current_page_id = $_GET['current_page_id'];
}

if(isset($_GET['gutter']))
{
	$gutter = $_GET['gutter'];
}

if(isset($_GET['layout']))
{
	$layout = $_GET['layout'];
}
?>
function loadPortfolioImage<?php echo esc_js($wrapper_id); ?>()
{
	if(jQuery('#<?php echo esc_js($wrapper_id); ?>_status').val() == 0)
	{
		var currentOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val());
		jQuery('#<?php echo esc_js($wrapper_id); ?>_loading').addClass('visible');
	
		jQuery.ajax({
	        url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
	        type:'POST',
	        data: 'action=<?php echo esc_js($action); ?>&cat=<?php echo esc_js($cat); ?>&items=<?php echo esc_js($items); ?>&items_ini=<?php echo esc_js($items_ini); ?>&offset='+currentOffset+'&columns=<?php echo esc_js($columns); ?>&type=<?php echo esc_js($type); ?>&order=<?php echo esc_js($order); ?>&order_by=<?php echo esc_js($order_by); ?>&layout=<?php echo esc_js($layout); ?>&current_page_id=<?php echo esc_js($current_page_id); ?>&tg_security='+tgAjax.ajax_nonce, 
	        success: function(html)
	        {
	        	jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val(parseInt(currentOffset+<?php echo esc_js($items_ini); ?>));
	        	
	            var htmlObj = jQuery(html);
				
				jQuery('#<?php echo esc_js($wrapper_id); ?>').append(htmlObj).imagesLoaded().done( function( instance ) {
					setTimeout(function(){
						jQuery('#<?php echo esc_js($wrapper_id); ?>').masonry('appended',htmlObj, true);
						
						jQuery('#<?php echo esc_js($wrapper_id); ?>').children('.element').children('.gallery_type').each(function(){
						    jQuery(this).addClass('fade-in');
					    });
					}, 500);
				});
				
				if(jQuery('#tg_lightbox_enable').val() != '')
				{
					if(jQuery('#tg_lightbox_plugin').val() == 'modulobox')
					{
						mobx.destroy();
						mobx.init();
					}
					else
					{
						jQuery(document).setLightbox();
					}
				}
				
				jQuery('#<?php echo esc_js($wrapper_id); ?>_loading').removeClass('visible');
	        }
	    });
	}
}

jQuery(window).load(function(){ 
	jQuery("#<?php echo esc_attr($wrapper_id); ?>").imagesLoaded().done( function( instance ) {
		setTimeout(function(){
			jQuery('#<?php echo esc_attr($wrapper_id); ?>').masonry({
			  itemSelector: '.element',
			  columnWidth: '.element',
			  gutter: <?php echo esc_js($gutter); ?>,
			  percentPosition: true,
			  transitionDuration: 0,
			});
			
		    jQuery("#<?php echo esc_attr($wrapper_id); ?>").children(".element").children(".gallery_type").each(function(){
		        jQuery(this).addClass("fade-in");
		    });
		}, 500);
	});
	
	jQuery(document).ajaxStart(function() {
	  	jQuery('#<?php echo esc_js($wrapper_id); ?>_status').val(1);
	});
	
	jQuery(document).ajaxStop(function() {
	  	jQuery('#<?php echo esc_js($wrapper_id); ?>_status').val(0);
	});

	if (jQuery(document).height() <= jQuery(window).height())
	{
        var currentOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val());
		var total = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_total').val());
		
		if (currentOffset > total)
	    {
	        return false;
	    }
	    else
	    {
	        loadPortfolioImage<?php echo esc_js($wrapper_id); ?>();
	    }
    }

	jQuery(window).on('scroll', function() {
		var currentOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val());
		var total = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_total').val());
		var wrapperHeight = jQuery(this).height();
		
		if(jQuery(window).height() > 1000)
		{
		    var targetOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>').offset().top/2);
		}
		else
		{
		    var targetOffset = jQuery('#<?php echo esc_js($wrapper_id); ?>').offset().top;
		}
	
	    if(jQuery(window).scrollTop() > targetOffset)
	    {
	    	if (currentOffset >= total)
	    	{
	    		return false;
	    	}
	    	else
	    	{
	    		loadPortfolioImage<?php echo esc_js($wrapper_id); ?>();
	    	}
	    }
	});
	
<?php
	if(isset($_GET['filter']) && !empty($_GET['filter']))
	{
?>
	if(jQuery('#tg_portfolio_filterable_link').val()!=1)
	{
		jQuery('#portfolio_wall_filters_<?php echo esc_attr($wrapper_id); ?> li a, #portfolio_wall_filters li a').click(function(){
		  	var selector = jQuery(this).attr('data-filter');
		  	
		  	jQuery('#portfolio_wall_filters_<?php echo esc_attr($wrapper_id); ?> li a, #portfolio_wall_filters li a').removeClass('active');
		  	jQuery(this).addClass('active');

		  	jQuery('#<?php echo esc_attr($wrapper_id); ?>').addClass('loading');
		  	
		  	jQuery.ajax({
		        url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
		        type:'POST',
		        data: 'action=<?php echo esc_js($action); ?>&cat='+selector+'&items=-1&columns=<?php echo esc_js($columns); ?>&type=<?php echo esc_js($type); ?>&layout=<?php echo esc_js($layout); ?>&current_page_id=<?php echo esc_js($current_page_id); ?>&tg_security='+tgAjax.ajax_nonce, 
		        success: function(html)
		        {
			        jQuery('#<?php echo esc_attr($wrapper_id); ?>').masonry('destroy');
		        	jQuery('#<?php echo esc_attr($wrapper_id); ?>').html(html);
		        	
		        	jQuery("#<?php echo esc_attr($wrapper_id); ?>").imagesLoaded().done( function( instance ) {
			        	jQuery('#<?php echo esc_attr($wrapper_id); ?>').masonry({
						  itemSelector: '.element',
						  columnWidth: '.element',
						  gutter: <?php echo esc_js($gutter); ?>,
						  percentPosition: true,
						  transitionDuration: 0,
						});
						
						jQuery("#<?php echo esc_attr($wrapper_id); ?>").children(".element").children(".gallery_type").each(function(){
					        jQuery(this).addClass("fade-in");
					    });
					});
					
					if(jQuery('#tg_lightbox_enable').val() != '')
					{
						if(jQuery('#tg_lightbox_plugin').val() == 'modulobox')
						{
							mobx.destroy();
							mobx.init();
						}
						else
						{
							jQuery(document).setLightbox();
						}
					}
					
					jQuery('#<?php echo esc_attr($wrapper_id); ?>').removeClass('loading');
					jQuery('#<?php echo esc_js($wrapper_id); ?>_total').val(0);
					
					setTimeout(function(){
						jQuery(window).scroll();
					}, 2000);
		        }
		    });
		  	
		  	return false;
		});
	}
<?php
	}
?>
});