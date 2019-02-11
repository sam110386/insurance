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

	$(".vehicle-makes .choices label").on('click',function(){
		var make = $(this).children('input').val();
		var vehicle = parseInt($(this).data('vehicle'));
		var modelsContanier = $('.models-' + vehicle);
		modelsContanier.html('');
		models = carModels[make];
		debugger
		$.each(models,function(mdl,model){
			target =  'vin' + (vehicle);
			current = (vehicle > 1) ? 'vehicle'+ vehicle +'-models' :'models' ;
			label = '<label for="model-' + vehicle +  '-' + mdl + '" class="h4 col-12 col-sm-12 col-md-6 col-lg-6 pl-2 pr-2" data-href="'+ target + '" data-current="'+ current + '"> ' + model + '<input type="radio" class="d-none" name="model" value="'+ mdl +'" id="model-' + vehicle +  '-' + mdl + '" /><i class="fa fa-angle-right"></i></label>';
			modelsContanier.append(label);
		});
		modelsContanier.parent('.col-12').show();
	});
	$(".vehicle-makes select").on('change',function(){
		var make = $(this).val();
		if(make  == 'other' ){
			$(this).next('input').val('').show();
		}else{
			$(this).next('input').hide();
		}
	});
	$(".vehicle-makes a.show-models").on('click',function(e){
		var targetQuestion = $(this).data('href');
		var make = $(this).siblings("select").val();
		var vehicle = parseInt($(this).data('vehicle'));
		var modelsContanier = $('.models-' + vehicle);
		modelsContanier.html('').parent('.col-12').hide();			

		$(this).parent('.form-group').removeClass('has-error');
		$(this).parents(".container").find("label").removeClass('bg-warning');
		
		if(make =='other' && (!$(this).siblings("input[type=text]").val() || $(this).siblings("input[type=text]").val() == "" )){
			$(this).parent('.form-group').addClass('has-error');
			return false;
		}
		if(make != 'other'){
			models = carModels[make];
			$.each(models,function(mdl,model){
				label = '<label for="model-' + vehicle +  '-' + mdl + '" class="h4 col-12 col-sm-12 col-md-6 col-lg-6 pl-2 pr-2" data-href="vehicle' + (vehicle + 1) +  '" data-current="models"> ' + model + '<input type="radio" class="d-none" name="model" value="'+ mdl +'" id="model-' + vehicle +  '-' + mdl + '" /><i class="fa fa-angle-right"></i></label>';
				modelsContanier.append(label);
			});	
			modelsContanier.parent('.col-12').show();		
		}
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);
	});	
	$('a.vehicle-next').on('click',function(){
		$(this).parents(".container").find("label").removeClass('bg-warning');
		$(this).parents(".container").find('input[type=radio]').prop('checked',false);
		var targetQuestion = $(this).data('href');
		$(this).parent('.form-group').removeClass('has-error');
		if(!$(this).siblings('input').val()){
			$(this).parent('.form-group').addClass('has-error');
			return false;
		}
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);		
	});

	$('.change-question').on('click',function(e){
		var targetQuestion = $(this).data('href');
		var pos = parseInt($(this).data('pos'));
		if(pos == 1){
			$('label.error').remove();
			if($('#zipcode').val() == ""){
				$('#zipcode').parent('.form-group').addClass('has-error');
				return false;
			}else if(!($('#zipcode').val() in zipcodes)){
				$('#zipcode').parent('.form-group').addClass('has-error');
				$(this).after('<label class="error font-weight-bold mt-3">Sorry! Currently we are not providing service in your area.</label>')
				return false;
			}
		}
		$('.form-group').removeClass('has-error');
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);

	});
	$('.container').on('click','.choices > label',function(e){
		$(this).siblings('label').removeClass('bg-warning');
		$(this).addClass('bg-warning');
		$(this).children('input[type=radio]').prop('checked',true);
		$(this).parents('.container').find('input[type=text]').val('');
		$(this).parents('.vehicle-makes').find('select').val($(this).parents('.container').find('select').children('option:first').val());
		$(this).parents('.vehicle-makes').find('input[type=text]').hide();

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
		if(!year){
			$('#dob_year').parent('.form-group').addClass('has-error');
			$('#dob_year').after('<label class="error text-danger">Enter Valid Birth Year</label>');
			return false;
		}else if(parseInt(year) < currentYear - 150){

		}else if(parseInt(year) > currentYear - 15){
			$('#dob_year').parent('.form-group').addClass('has-error');
			$('#dob_year').after('<label class="error text-danger">Age should be 15+</label>');
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