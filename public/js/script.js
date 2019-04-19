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
		$.each(models,function(mdl,model){
			target =  'vin' + (vehicle);
			current = (vehicle > 1) ? 'vehicle'+ vehicle +'-models' :'models' ;
			label = '<label for="model-' + vehicle +  '-' + mdl + '" class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="'+ target + '" data-current="'+ current + '"> ' + model + '<input type="radio" class="d-none" name="model" value="'+ mdl +'" id="model-' + vehicle +  '-' + mdl + '" /><i class="fa fa-angle-right"></i></label>';
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
		
		if(make =='other' && (!$(this).siblings("input.optional").val() || $(this).siblings("input[type=text]").val() == "" )){
			$(this).parent('.form-group').addClass('has-error');
			return false;
		}
		if(make != 'other'){
			models = carModels[make];
			$.each(models,function(mdl,model){				
				target =  'vin' + (vehicle);
				current = (vehicle > 1) ? 'vehicle'+ vehicle +'-models' :'models' ;
				label = '<label for="model-' + vehicle +  '-' + mdl + '" class="h4  col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="'+ target + '" data-current="'+ current + '"> ' + model + '<input type="radio" class="d-none" name="model" value="'+ mdl +'" id="model-' + vehicle +  '-' + mdl + '" /><i class="fa fa-angle-right"></i></label>';
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
				$('#zipcode').after('<label class="error font-weight-bold mt-3">Sorry! Currently we are not providing service in your area.</label>')
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
		$(this).parents('.container').find('input.optional').val('');
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
		$('form.lead-form > div#dob-container').delay(500).fadeIn(500);
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

	$('body').on('change','.dob-change',function(){
		var i = $(this).data('dob');
		var year = 2016;
		var month = $('select.dob' + i +'-month').val();
		var days = new Date(year, month, 0).getDate();
		var dateSelect = $('select.dob'+ i +'-date');
		dateSelect.html('');
		for(i=1; i <=days;i++ ){
			var z = ('0' + i).slice(-2);
			dateSelect.append('<option value="'+ i +'">' + z +'</option>');
		}
	});


	$('.dob-submit').on('click',function(){
		var i = $(this).data('dob');
		var year = $('select.dob' + i +'-year').val();
		var month = $('select.dob' + i +'-month').val();
		var date = $('select.dob' + i +'-date').val();
		$(this).siblings('.error').remove();

		var dateToCheck = ('0' + month).slice(-2) + '/' +('0' + date).slice(-2) +  '/'+  year;
		// alert(dateToCheck);
		if(!isValidDate(dateToCheck)){
			$('select.dob' + i +'-year','select.dob' + i +'-month','select.dob' + i +'-date').parent('.form-group').addClass('has-error');
			$(this).after('<label class="ml-2 error text-danger">Invalid date</label>');
			return false;
		}
		var df = dateDiff(year + "-" + month + "-" + date);

		if(df.y < 15){	
			$('select.dob' + i +'-year','select.dob' + i +'-month','select.dob' + i +'-date').parent('.form-group').addClass('has-error');
			$(this).after('<label class="ml-2 error text-danger">Age should be 15+</label>');
			return false;			
		}else{
			var targetQuestion = $(this).data('href');
			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);			
		}
	});


	$('.dl-submit').on('click',function(){
		var dl  = $(this).siblings('input').val();
		$(this).parents('.form-group').removeClass('has-error');
		if(!dl){
			$(this).parents('.form-group').addClass('has-error');
		}else{
			var targetQuestion = $(this).data('href');
			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);			
		}
	});

	$('.name-submit').on('click',function(){
		var error = false;
		$.each($('input:visible'),function(){
			$(this).parents('.form-group').removeClass('has-error');
			if(!$(this).val()){
				$(this).parents('.form-group').addClass('has-error');
				error = true;
			}
		});
		if(!error){
			var targetQuestion = $(this).data('href');
			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);			
		}
	});

	$('.vin-submit').on('click',function(){
		var error = false;
		$.each($('input:visible'),function(){
			$(this).parents('.form-group').removeClass('has-error');
			if(!$(this).val()){
				$(this).parents('.form-group').addClass('has-error');
				error = true;
			}
		});
		if(!error){
			var targetQuestion = $(this).data('href');
			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);			
		}
	});

	$('.load-years').on('click',function(){
		debugger
		var label =  $(this).parent().prev('label');
		var name = label.data('current');
		var href = label.data('href');
		var str = label.attr('for');
		str =  str.split('-');
		var year = parseInt(str[str.length-1]);
		for(var i = 1; i<=20; i++ ){
			var labelYear = year - i ; 
			var labelId = name + '-' + labelYear;
			var newLabel = '<label for="' + labelId  +'" class="h4 col-3 col-sm-3 col-md-2 col-lg-2 pl-2 pr-2" data-href="'+ href + '" data-current="' + name + '">'+ labelYear + '<input type="radio" class="d-none" name="'+ name +'" value="'+ labelYear +'" id="' + labelId +'"><i class="fa fa-angle-right"></i> </label>';			
			$(this).parent().before(newLabel);		
		}
		
	})

	function dateDiff(date) {
		var startDate = new Date(date);
		var diffDate = new Date(new Date() - startDate);
		return {y: (diffDate.getFullYear() - 1970), m:diffDate.getMonth(),d:(diffDate.getDate()-1)};
	}

//--------------------------------------------------------------------------
//This function validates the date for MM/DD/YYYY format. 
//--------------------------------------------------------------------------
function isValidDate(dateStr) {
	
 // Checks for the following valid date formats:
 // MM/DD/YYYY
 // Also separates date into month, day, and year variables
 var datePat = /^(\d{2,2})(\/)(\d{2,2})\2(\d{4}|\d{4})$/;
 
 var matchArray = dateStr.match(datePat); // is the format ok?
 if (matchArray == null) {
	// alert("Date must be in MM/DD/YYYY format")
	return false;
 }
 
 month = matchArray[1]; // parse date into variables
 day = matchArray[3];
 year = matchArray[4];
 if (month < 1 || month > 12) { // check month range
	// alert("Month must be between 1 and 12");
	return false;
 }
 if (day < 1 || day > 31) {
	// alert("Day must be between 1 and 31");
	return false;
 }
 if ((month==4 || month==6 || month==9 || month==11) && day==31) {
	// alert("Month "+month+" doesn't have 31 days!")
	return false;
 }
 if (month == 2) { // check for february 29th
	var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
	if (day>29 || (day==29 && !isleap)) {
		// alert("February " + year + " doesn't have " + day + " days!");
		return false;
	}
 }
 return true;  // date is valid
}	
});
