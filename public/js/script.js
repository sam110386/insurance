$(document).ready(function(){
	$('#zipcode').on('keypress',function(e){
		if (e.keyCode == 13) {
			$("a.zipcode-submit").click();
			return false;
		}
	});
	$('input').on('keypress',function(e){
		if (e.keyCode == 13) {
			return false;
		}
	});    
	$('.change-question').on('click',function(e){
		var targetQuestion = $(this).data('href');
		var pos = parseInt($(this).data('pos'));
		if(pos == 1 && $('#zipcode').val() == ""){
			$('#zipcode').parent('.form-group').addClass('has-error');
			return false;
		}
		$('.form-group').removeClass('has-error');
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);

	});
	$('.choices > label').on('click',function(e){
		$(this).siblings('label').removeClass('bg-warning');
		$(this).addClass('bg-warning');
		$(this).children('input[type=radio]').prop('checked',true);
		
		var targetQuestion = $(this).data('href');
		var prevQuestion = $(this).data('current');
		if(targetQuestion && prevQuestion){	
			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container a.change-question").data('href',prevQuestion);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);
		}
		return false;
	});

	$('.months > label').on('click',function(e){
		$(this).siblings('label').removeClass('bg-warning');
		$(this).addClass('bg-warning');
		$(this).children('input[type=radio]').prop('checked',true);
		
		var dob_month = $('input[name=dob_month]:checked').val();
		if(dob_month){
			dob_month = parseInt(dob_month);
			var a = new Date('2016',parseInt(dob_month,10)-1,'02');
			$( "#dob_picker" ).datepicker("destroy");
			$( "#dob_picker" ).datepicker({
				inline: true,
				changeMonth: false,
				changeYear: false,
				dateFormat: "dd",
				defaultDate: new Date(2016, dob_month - 1, 1),
			});
			$("#dob_picker").datepicker('option', 'firstDay', a.getDay()-1);
			
			$("#dob_picker").on("change",function(){
				$('#dob_date').val($(this).val());
				$('form.lead-form > div.container').fadeOut(500);
				$('form.lead-form > div#dob-year-container').delay(500).fadeIn(500);
				return false;
			});	

			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#dob-date-container').delay(500).fadeIn(500);
		}
		return false;
	});


	$('.dob-year-submit').on('click',function(e){
		var dt = new Date();
		var currentYear = dt.getFullYear();
		var year = $('#dob_year').val();
		$('#dob_year').parent('.form-group').removeClass('has-error');
		$('#dob_year').siblings('label.error').remove();
		if(!year || parseInt(year) < currentYear - 150 || parseInt(year) > currentYear - 15){
			$('#dob_year').parent('.form-group').addClass('has-error');
			$('#dob_year').after('<label class="error text-danger">Enter Valid Birth Year</label>');
			return false;
		}
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#name-email-container').delay(500).fadeIn(500);
		return false;
	});

	$('.name-email-submit').on('click',function(e){
		var error = false;
		var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
		$('.form-group').removeClass('has-error');
		if($('#first_name').val() == "" || $.trim($('#first_name').val()) == ""){
			$('#first_name').parent('.form-group').addClass('has-error');
			error = true;
		}
		if($('#last_name').val() == "" || $.trim($('#last_name').val()) == ""){
			$('#last_name').parent('.form-group').addClass('has-error');
			error = true;
		}
		if($('#email').val() == "" || $.trim($('#email').val()) == ""){
			$('#email').parent('.form-group').addClass('has-error');
			error = true;
		}
		if($('#email').val() && !pattern.test($('#email').val())){
			$('#email').parent('.form-group').addClass('has-error');
			$('#email').after('<label class="error text-danger">Enter Valid Email</label>');
			error = true;
		}
		if(error){
			return false;
		}
		$('span.first-name-label').html($('#first_name').val());
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#last-container').delay(500).fadeIn(500);
		return false;
	});

	$('.final-submit').on('click',function(e){
		var error = false;
		var phoneRegex = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/
		$('.form-group').removeClass('has-error');
		if($('#street').val() == "" || $.trim($('#street').val()) == ""){
			$('#street').parent('.form-group').addClass('has-error');
			error = true;
		}
		if($('#phone').val() == "" || $.trim($('#phone').val()) == ""){
			$('#phone').parent('.form-group').addClass('has-error');
			error = true;
		}
		if($('#phone').val() && !phoneRegex.test($('#phone').val())){
			$('#phone').parent('.form-group').addClass('has-error');
			$('#phone').after('<label class="error text-danger">Enter Valid Phone Numberyy</label>');
			error = true;
		}
		if(error){
			return false;
		}
		$('form.lead-form').submit();				
	});
	$('.next-question').on('click',function(e){
		var targetQuestion = $(this).data('href');
		var prevQuestion = $(this).data('current');
		if(targetQuestion && prevQuestion){	
			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container a.change-question").data('href',prevQuestion);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);
		}
		return false;
	});
});