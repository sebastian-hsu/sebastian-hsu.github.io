jQuery(document).ready(function($){
	// toggle checkboxes
	$(".mdc-image-sizes-wrap input[type='checkbox']").click(function(){
		if( ! $(this).is(':checked') ) {
	    	$(".mdc-image-sizes-wrap input[type='checkbox'][value='all']").prop('checked', false);
		}
	});
	$(".mdc-image-sizes-wrap input[type='checkbox'][value='all']").change(function(){
	    $('input:checkbox').not(this).prop('checked', this.checked);
	});
	// survey
    $(document).on('click', '.is-dismissible.imgsz-survey-notice .notice-dismiss, .imgsz-survey', function(e){
        $(this).prop('disabled', true)
        $.ajax({
            url: ajaxurl,
            data: { 'action' : 'imgsz_survey', 'participate' : $(this).data('participate') },
            type: 'POST',
            success: function(ret) {
                $('.survey-notice').slideToggle(500)
            }
        })
    })
})