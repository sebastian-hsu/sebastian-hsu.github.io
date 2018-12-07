<?php header("content-type: application/x-javascript");?>
var calScreenWidth = jQuery(window).width();
var imgFlowSize = 0.6;
if(calScreenWidth > 480)
{
imgFlowSize = 0.4;
}
else
{
imgFlowSize = 0.2;
}
<?php
if(isset($_GET['portfolioset']))
{
?>
imf.create("imageFlow", '<?php echo admin_url('admin-ajax.php'); ?>?action=photography_script_image_portfolio_flow&portfolioset=<?php echo esc_attr($_GET['portfolioset']); ?>', 0.6, 0.4, 0, 10, 8, 4);
<?php
}
else
{
?>
imf.create("imageFlow", '<?php echo admin_url('admin-ajax.php'); ?>?action=photography_script_image_portfolio_flow', 0.6, 0.4, 0, 10, 8, 4);

<?php
}
?>