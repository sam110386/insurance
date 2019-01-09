$(document).ready(function(){

	$('#zipcode').on('keypress',function(e){
		if (e.keyCode == 13) {
			$("a.zipcode-submit").click();
            return false;
        }
    })
	$('.change-question').on('click',function(e){
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
	$('.choices > label').on('click',function(e){
		$(this).siblings('label').removeClass('bg-warning');
		$(this).addClass('bg-warning');
		$(this).children('input[type=radio]').prop('checked',true);
		
		var targetQuestion = $(this).data('href');
		var prevQuestion = $(this).data('current');
		if(targetQuestion && prevQuestion){	
			$('form.lead-form > div.row').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container a.change-question").data('href',prevQuestion);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);
		}
		return false;
	});
});