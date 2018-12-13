<?php
header("content-type: application/x-javascript"); 

$pp_contact_enable_captcha = get_option('pp_contact_enable_captcha');

//Get contact form ID
$contact_form_id = 'contact_form';
$response_id = 'reponse_msg';

if(isset($_GET['form']))
{
	$contact_form_id.= '_'.$_GET['form'];
	$response_id.= '_'.$_GET['form'];
}
?>
<?php
 if(!empty($pp_contact_enable_captcha))
 {
 ?>
 
 // refresh captcha
 jQuery('img#captcha-refresh').click(function() {  
     	
     	change_captcha();
 });
 
 function change_captcha()
 {
	 document.getElementById('captcha').src="<?php echo admin_url('admin-ajax.php'); ?>?action=photography_script_get_captcha&rnd=" + Math.random();
 }
 
 <?php
 }
?>

jQuery(document).ready(function() {
	jQuery('form#<?php echo esc_js($contact_form_id); ?>').submit(function() {
		jQuery('form#<?php echo esc_js($contact_form_id); ?> .error').remove();
		var hasError = false;
		jQuery('.required_field').each(function() {
			if(jQuery.trim(jQuery(this).val()) == '') {
				var labelText = jQuery(this).prev('label').text();
				jQuery('#<?php echo esc_js($response_id); ?> ul').append('<li class="error"><?php echo esc_html_e('Please enter', 'photography-translation' ); ?> '+labelText+'</li>');
				hasError = true;
			} else if(jQuery(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,13})?$/;
				if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
					var labelText = jQuery(this).prev('label').text();
					jQuery('#<?php echo esc_js($response_id); ?> ul').append('<li class="error"><?php echo esc_html_e('Please enter valid', 'photography-translation' ); ?> '+labelText+'</li>');
					hasError = true;
				}
			}
		});
		if(!hasError) {
			var contactData = jQuery('#<?php echo esc_js($contact_form_id); ?>').serialize();

			<?php
			if(!empty($pp_contact_enable_captcha))
			{
			?>
			jQuery.ajax({
			    type: 'GET',
			    url: '<?php echo admin_url('admin-ajax.php'); ?>?action=photography_script_get_captcha&check=true',
			    data: jQuery('#<?php echo esc_js($contact_form_id); ?>').serialize(),
			    success: function(msg){
			    	if(msg == 'true')
			    	{
			    		jQuery('#contact_submit_btn<?php echo esc_js($_GET['form']); ?>').fadeOut('normal', function() {
							jQuery(this).parent().append('<i class="fa fa-circle-o-notch fa-spin"></i>');
						});
						
			    		jQuery.ajax({
						    type: 'POST',
						    url: '<?php echo admin_url('admin-ajax.php'); ?>?action=photography_contact_mailer',
						    data: contactData+'&tg_security='+tgAjax.ajax_nonce,
						    success: function(results){
						    	jQuery('#<?php echo esc_js($contact_form_id); ?>').hide();
						    	jQuery('#<?php echo esc_js($response_id); ?>').html(results);
						    }
						});
			    	}
			    	else
			    	{
			    		alert(msg);
			    		return false;
			    	}
			    }
			});
			<?php
 			} else {
 			?>
 			jQuery('#contact_submit_btn<?php echo esc_js($_GET['form']); ?>').fadeOut('normal', function() {
				jQuery(this).parent().append('<i class="fa fa-circle-o-notch fa-spin"></i>');
			});
 			
 			jQuery.ajax({
			    type: 'POST',
			    url: '<?php echo admin_url('admin-ajax.php'); ?>?action=photography_contact_mailer',
			    data: contactData+'&tg_security='+tgAjax.ajax_nonce,
			    success: function(results){
			    	jQuery('#<?php echo esc_js($contact_form_id); ?>').hide();
			    	jQuery('#<?php echo esc_js($response_id); ?>').html(results);
			    }
			});
 			<?php
			}
			?>
		}
		
		return false;
		
	});
});