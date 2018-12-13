<?php header("content-type: application/x-javascript"); 

$autoplay = 'true';
$timer = 5;
$caption = 1;

if(isset($_GET['autoplay']) && empty($_GET['autoplay']))
{
	$autoplay = 'false';
}

if(isset($_GET['timer']))
{
	$timer = $_GET['timer'];
}

if(isset($_GET['caption']))
{
	$caption = $_GET['caption'];
}
?>
jQuery(window).load(function(){ 
	jQuery('.slider_wrapper').flexslider({
	      animation: "fade",
	      animationLoop: true,
	      itemMargin: 0,
	      minItems: 1,
	      maxItems: 1,
	      slideshow: <?php echo esc_js($autoplay); ?>,
	      controlNav: false,
	      smoothHeight: true,
	      slideshowSpeed: <?php echo intval($timer*1000); ?>,
	      animationSpeed: 1600,
	      move: 1
	});
});