<?php header("content-type: application/x-javascript"); 
	
	if(!isset($_GET['id']))
	{
		$_GET['id'] = '';
	}
	
	if(!isset($_GET['gutter']))
	{
		$_GET['gutter'] = 0;
	}
	
	if(!isset($_GET['next_action']))
	{
		$_GET['next_action'] = 'photography_portfolio_classic';
	}
	
	if(!isset($_GET['columns']))
	{
		$_GET['columns'] = 2;
	}
	
	if(!isset($_GET['type']))
	{
		$_GET['type'] = 'grid';
	}
	
	if(!isset($_GET['page_id']))
	{
		$_GET['page_id'] = 1;
	}
	
	if(!isset($_GET['layout']))
	{
		$_GET['layout'] = 'contain';
	}
?>
jQuery("#<?php echo esc_attr($_GET['id']); ?>").imagesLoaded().done( function( instance ) {
	setTimeout(function(){
		jQuery('#<?php echo esc_attr($_GET['id']); ?>').masonry({
		  itemSelector: '.element',
		  columnWidth: '.element',
		  gutter: <?php echo esc_js($_GET['gutter']); ?>,
		  percentPosition: true,
		  transitionDuration: 0,
		});

	    jQuery("#<?php echo esc_attr($_GET['id']); ?>").children(".element").children(".gallery_type").each(function(){
	        jQuery(this).addClass("fade-in");
	    });
	    
	    jQuery(window).trigger('hwparallax.reconfigure');
	}, 500);
});
<?php
	if(isset($_GET['filter']) && !empty($_GET['filter']))
	{
?>
	if(jQuery('#tg_portfolio_filterable_link').val()!=1)
	{
		jQuery('#portfolio_wall_filters_<?php echo esc_attr($_GET['id']); ?> li a, #portfolio_wall_filters li a').click(function(){
			jQuery(document.body).css({'cursor' : 'wait'});
		  	var selector = jQuery(this).attr('data-filter');
		  	
		  	jQuery('#portfolio_wall_filters_<?php echo esc_attr($_GET['id']); ?> li a, #portfolio_wall_filters li a').removeClass('active');
		  	jQuery(this).addClass('active');

		  	jQuery('#<?php echo esc_attr($_GET['id']); ?>').addClass('loading');
		  	
		  	jQuery.ajax({
		        url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
		        type:'POST',
		        data: 'action=<?php echo esc_js($_GET['next_action']); ?>&cat='+selector+'&items=-1&columns=<?php echo esc_js($_GET['columns']); ?>&type=<?php echo esc_js($_GET['type']); ?>&layout=<?php echo esc_js($_GET['layout']); ?>&current_page_id=<?php echo esc_js($_GET['page_id']); ?>&tg_security='+tgAjax.ajax_nonce, 
		        success: function(html)
		        {
			        jQuery('#<?php echo esc_attr($_GET['id']); ?>').masonry('destroy');
		        	jQuery('#<?php echo esc_attr($_GET['id']); ?>').html(html);
		        	
		        	jQuery("#<?php echo esc_attr($_GET['id']); ?>").imagesLoaded().done( function( instance ) {
			        	setTimeout(function(){
				        	jQuery('#<?php echo esc_attr($_GET['id']); ?>').masonry({
							  itemSelector: '.element',
							  columnWidth: '.element',
							  gutter: <?php echo esc_js($_GET['gutter']); ?>,
							  percentPosition: true,
							  transitionDuration: 0,
							});
							
							jQuery("#<?php echo esc_attr($_GET['id']); ?>").children(".element").children(".gallery_type").each(function(){
						        jQuery(this).addClass("fade-in");
						    });
						    
						    jQuery(window).trigger('hwparallax.reconfigure');
						    jQuery('#<?php echo esc_attr($_GET['id']); ?>').removeClass('loading');
						    jQuery(document.body).css({'cursor' : 'default'});
						    
						    jQuery(window).trigger('hwparallax.reconfigure');
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
		        }
		    });
		  	
		  	return false;
		});
	}
<?php
	}
?>