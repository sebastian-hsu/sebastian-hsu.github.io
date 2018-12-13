<?php header("content-type: application/x-javascript"); 
	
	if(!isset($_GET['id']))
	{
		$_GET['id'] = '';
	}
?>
jQuery("#<?php echo esc_attr($_GET['id']); ?>").imagesLoaded().done( function( instance ) {
	setTimeout(function(){
	    jQuery("#<?php echo esc_attr($_GET['id']); ?>").children(".element").children(".gallery_type").each(function(){
	        jQuery(this).addClass("fade-in");
	    });
    }, 500);
    
    jQuery(window).trigger('hwparallax.reconfigure');
});