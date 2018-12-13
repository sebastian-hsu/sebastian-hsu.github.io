<?php 
header("content-type: application/x-javascript"); 

if(isset($_GET['grid']) && !empty($_GET['grid']))
{
	$rows = 3;
	if(isset($_GET['rows']) && !empty($_GET['rows']))
	{
		$rows = $_GET['rows'];
	}
?>
jQuery(function() {
			
    jQuery( '#<?php echo esc_js($_GET['grid']); ?>' ).gridrotator( {
    	rows : <?php echo esc_js($rows); ?>,
		columns : 10,
		interval : 2000,
		w1024 : {
		    rows : <?php echo esc_js($rows); ?>,
		    columns : 9
		},
		w768 : {
		    rows : <?php echo esc_js($rows); ?>,
		    columns : 8
		},
		w480 : {
		    rows : <?php echo esc_js($rows+1); ?>,
		    columns : 6
		},
		w320 : {
		    rows : <?php echo esc_js($rows+1); ?>,
		    columns : 6
		},
		w240 : {
		    rows : <?php echo esc_js($rows+1); ?>,
		    columns : 5
		},
    } );

});
<?php
}
?>