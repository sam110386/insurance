$(document).ready(function(){
	$('.change-question').on('click',function(e){
		// debugger
		var targetQuestion = $(this).data('href');
		var pos = parseInt($(this).data('pos'));
		if(pos == 1 && $('#zipcode').val() == ""){
			$('#zipcode').parent('.form-group').addClass('has-error');
			return false;
		}
		$('.form-group').removeClass('has-error');
		$('form.lead-form > div.row').fadeOut(500);
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);

	});
	$('.choices > label').on('click',function(){
		$(this).siblings('label').removeClass('bg-warning');
		$(this).addClass('bg-warning');
		$(this).parent('.choices').siblings('a').click();
		return false;
	});
});