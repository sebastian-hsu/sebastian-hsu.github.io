<?php 
header("content-type: application/x-javascript");

if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['end']) && !empty($_GET['end']))
{
?>
window.odometerOptions = {
  format: '(,ddd).dd'
};
setTimeout(function(){
    jQuery('#<?php echo esc_js($_GET['id']); ?>').html(<?php echo esc_js($_GET['end']); ?>);
}, 1000);
<?php
}
?>