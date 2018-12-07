<?php
header("content-type: application/x-javascript");

if(isset($_GET['id']) && !empty($_GET['id']))
{
?>
jQuery('#<?php echo esc_js($_GET['id']); ?>').circliful();
<?php
}
?>