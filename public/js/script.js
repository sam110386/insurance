/* Brand Carousel Start */
$(document).ready(function() {
	var owl = $('.owl-carousel');
	owl.owlCarousel({
		items: 6,
		loop: true,
		margin: 10,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
		dots: false,
		autoHeight:true,
		responsive:{
			0:{
				items:2,
				nav:false
			},
			480:{
				items:3,
				nav: false
			},
			600:{
				items:5,
				nav:false
			},
			1000:{
				items:8,
				nav:false
			}
		}		
	});

})


$.each(['fadeIn','fadeOut'], function (i, ev) {
	var el = $.fn[ev];
	$.fn[ev] = function () {
		this.trigger(ev);
		return el.apply(this, arguments);
	};
});

jQuery(document).ready( function($) {
	$('.start-application').on('click',function(){
		$('.start-content').fadeOut();
		$('#zipcode-container').fadeIn();
	})

	// Default checked radio buttons
	$("input[type='radio']").prop('checked', false);
	$("input[type='text']:not('.skip-reset'),input[type='email']:not('.skip-reset'),input[type='number']:not('.skip-reset'),input[type='tel']:not('.skip-reset'),select:not('.skip-reset')").val('');
	// $("input[type='radio']:checked").parent('label').addClass('bg-warning')

	var quesitonCount = $('form.lead-form > .container.step').length;
	$(".q-progress table tr").html('');
	for(var b=0; b < quesitonCount; b++){
		$(".q-progress table tr").append('<td><hr class="before"/><i class="fa fa-dot-circle"></i><hr class="after" /></td>');
	}

	$('form.lead-form > .container').on('fadeIn', function() {
		$(this).addClass('answered');
		$('.q-progress table tr td').removeClass('question-done');
		$('.q-progress table tr td').removeClass('recent-done');
		var prevQuestionsNew = $(this).prevAll('div.container.step').length;
		var prevQuestionsOld = $('.q-progress table tr td.question-done').length;
		if(prevQuestionsNew && prevQuestionsNew !== prevQuestionsOld){
			for(var s = 1; s <= prevQuestionsNew; s++){
				var classAdd = (s==prevQuestionsNew) ? "recent-done question-done" : "question-done";
				$('.q-progress table tr td:nth-child(' + s + ')').addClass(classAdd);	
			}
		}
		if($(this).hasClass('editable-field')) $(this).addClass('review-on');
		$(window).scrollTop(0);
	});




 	// year select on change trigger next quesiton
 	$('.lead-form').on('change','select.auto-select',function(){
 		if($(this).val() == 'other'){
 			$(this).siblings('input').show();
 		}else{
 			$(this).siblings('input').hide();
 			$(this).siblings('a').trigger('click');
 		}
 	})

 	// change question on policy question
 	
 	$('input[name=at_fault],input[name=tickets],input[name=dui],input[name=uninsured],input[name=towing],input[name=rental]').parent('label').on('click',function(){
 		$(this).children('input[type=radio]').prop('checked',true);
 		$('a.next-question:visible').trigger('click').delay(500);
 	})
 	
    // Disable scroll when focused on a number input.
    $('.lead-form').on('focus', 'input[type=number]', function(e) {
    	$(this).on('wheel', function(e) {
    		e.preventDefault();
    	});
    });

    // Restore scroll on number inputs.
    $('.lead-form').on('blur', 'input[type=number]', function(e) {
    	$(this).off('wheel');
    });

    // Disable up and down keys.
    $('.lead-form').on('keydown', 'input[type=number]', function(e) {
    	if ( e.which == 38 || e.which == 40 )
    		e.preventDefault();
    });  


    $("select.referrer").on('change',function(){
    	if($(this).val() == 'Other'){
    		$('.ref-name').show();
    	}else{
    		$('.ref-name').hide();
    	}
    })
});
/* Brand Carousel End */

$(document).ready(function(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; 
	var yyyy = today.getFullYear();
	if (dd < 10) {
		dd = '0' + dd;
	}
	if (mm < 10) {
		mm = '0' + mm;
	}
	var today = dd + '/' + mm + '/' + yyyy;
	$('input.masked-dob').inputmask("datetime", {
		inputFormat: "mm/dd/yyyy",
		"placeholder": "MM/DD/YYYY",
		min: "01/01/1900",
		max: today,
		"onincomplete": function(){
			$(this).next('.error').remove();
			$(this).after('<label class="error text-danger">Invalid Date</label>');
		},
		"oncomplete": function(){ 
			$(this).next('.error').remove();
		}		
	});

	$("input#phone").inputmask("(999) 999-9999",{placeholder: "(xxx) xxx-xxxx"});
	$('input.vehicle-year-input').inputmask("9999", {
		"placeholder": "YYYY",
		min: "1900",
		max: new Date().getFullYear(),
		"onincomplete": function(){
			$(this).next('.error').remove();
			$(this).after('<label class="error text-danger">Invalid year</label>');
		},
		"oncomplete": function(){ 
			$(this).next('.error').remove();
		}
	});

	var models = [];
	var vMake = "";
	var vYear = 0;
	var vModel = "";
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

	$("#insurance-companies > label").on('click',function(){
		if(!$(this).hasClass('other')){
			$("#current-insurance-other").val('');
			$('.other-insurance-company').slideUp(500);
		}
	})
	$('#other-company').on('click',function(e){
		e.preventDefault();
		$("#insurance-companies > label").removeClass('bg-warning');
		$('#insurance-companies > label > input[type=radio]').prop('checked',false);
		$(this).addClass('bg-warning');
		$('#company-other').prop('checked',true);
		$('.other-insurance-company').slideDown(500);
		return false;		
	})

	$(".get-make.choices").on('click',"label",function(){
		var year = $(this).data('year');
		var href = $(this).data('models');
		var current = $(this).data('make');
		var vehicle = $(this).data('vehicle');
		var label = "";
		vYear =  year;
		$("#"+current + "-container .choices").html("");
		$("#"+current + "-container select").html("");
		$.ajax({
			type: "GET",
			url: '/ajax/makes/' + year
		}).done(function( res ) {
			if(res){
				// var popMakes = [{"make":"Acura"},{"make":"Audi"},{"make":"BMW"},{"make":"Chevrolet"},{"make":"Dodge"},{"make":"Ford"},{"make":"Honda"},{"make":"INFINITI"},{"make":"Lexus"},{"make":"Mercedes-Benz"},{"make":"Nissan"},{"make":"Toyota"}];
				var popMakes = [{"make":"Acura"},{"make":"Audi"},{"make":"BMW"},{"make":"Cadillac"},{"make":"Chevrolet"},{"make":"Dodge"},{"make":"Ford"},{"make":"GMC"},{"make":"Honda"},{"make":"Hyundai"},{"make":"INFINITI"},{"make": "Kia"},{"make":"Lexus"},{"make":"Mercedes-Benz"},{"make":"Nissan"},{"make":"Toyota"},{"make":"Volkswagen"},{"make":"Volvo"}];	
				$.each(popMakes,function(i,mk){
					make = mk.make;
					label = '<label class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-year="' + year + '" data-href="'+ href +'" data-current="'+ current +'" data-vehicle="'+ vehicle +'">'+ make +'<input type="radio" class="d-none" name="'+ current +'" value="'+ make+ '" /></label>';
					$("#"+current + "-container .choices").append(label);
				})

				$("#"+current + "-container select").append("<option value=''>Choose one</option>");
				$.each(res,function(i,mk){
					make = mk.make;
					select = "<option value='"+ make +"' data-year='" + year + "'>"+ make +"</option>";
					$("#"+current + "-container select").append(select);
				});
				$("#"+current + "-container select").siblings('input').attr('data-year',year);
				$("#"+current + "-container select").append("<option value='other'>Enter My Vehicle Make Manually</option>");
			}
		});

	})

	$(".vehicle-makes .choices").on('click','label',function(){
		var make = $(this).children('input').val();
		var vehicle = parseInt($(this).data('vehicle'));
		var year = parseInt($(this).data('year'));
		var modelsContanier = $('.models-' + vehicle);
		vMake = make;
		printModels(modelsContanier,{year: year, make: make, vehicle: vehicle});
		modelsContanier.parent('.col-12').show();
	});

	function printModels(modelsContanier,data){
		var vehicle = data.vehicle;
		var make =  data.make;
		var year =  data.year;
		modelsContanier.html('');
		models = [];
		$.ajax({
			type: "GET",
			url: '/ajax/models/' + year + '/' + make
		}).done(function( res ) {
			if(res){
				$.each(res,function(mdl,model){
					target =  'trims' + (vehicle);
					current = (vehicle > 1) ? 'vehicle'+ vehicle +'-models' :'models' ;
					label = '<label data-make="'+ make +'" data-vehicle="' + vehicle + '" data-year="'+ year +'" class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="'+ target + '" data-current="'+ current + '"> ' + model.vmodel + '<input type="radio" class="d-none" name="model-'+ vehicle +'" value="'+ model.vmodel +'" /><i class="fa fa-angle-right"></i></label>';
					modelsContanier.append(label);
					models.push(model.vmodel);
				});
			}
		});
	}

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
		var year = $(this).siblings("select").children("option:selected").data("year");
		modelsContanier.html('').parent('.col-12').hide();	

		$(this).parent('.form-group').removeClass('has-error');
		$(this).parents(".container").find("label").removeClass('bg-warning');
		$('.error').remove();
		if(!make){	
			$(this).parent('.form-group').addClass('has-error');
			$(this).before('<label class="error mt-2 row col-12">Please select vehicle Make.</label>')
			return false;
		}
		else if(make =='other' && (!$(this).siblings("input.optional").val() || $(this).siblings("input[type=text]").val() == "" )){
			$(this).parent('.form-group').addClass('has-error');
			return false;
		}
		if(make != 'other'){
			printModels(modelsContanier,{year: year, make: make, vehicle: vehicle});
			modelsContanier.parent('.col-12').show();		
		}else{
			make = $(this).siblings("input").val()
			year = $(this).siblings("input").data('year');
			printModels(modelsContanier,{year: year, make: make, vehicle: vehicle});
			modelsContanier.parent('.col-12').show();						
		}
		vMake = make;
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);
	});	
	$('.model-search').on('blur',function(){
		$(this).siblings('.models-list').slideUp();
	});
	$('.model-search').on('focus',function(){
		$(this).siblings('.models-list').slideDown();
	});	
	$('.model-search').on('keyup',function(){
		var list = $(this).siblings('.models-list');		
		list.html('').hide();

		var s = $(this).val();
		if(!s) return;

		var regex = new RegExp('(' + RegExp.escape(s) + ')', 'ig');		
		$.each(models,function(i,m){
			if(regex.test(m)){
				mOrg = m;
				m = m.replace(regex, '<strong class="">$1</strong>');
				list.append('<a href="javascript:;" data-value="' + mOrg + '" class="list-group-item list-group-item-action">'+ m +'</a>');
			}
		});	
		list.show();
	});

	if (!RegExp.escape) {
		RegExp.escape = function(value) {
			return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
		};
	}
	$('.models-list').on('click','a',function(){
		$(this).parent().siblings('.model-search').val($(this).data('value'));
		$(this).parent('.models-list').html();
		$(this).parents('.vehicle-models').find('.vehicle-next').trigger('click');
	});
	$('a.vehicle-next').on('click',function(){
		debugger
		$(this).parents(".container").find("label").removeClass('bg-warning');
		$(this).parents(".container").find('input[type=radio]').prop('checked',false);
		var targetQuestion = $(this).data('href');
		var input = $(this).parents(".container").find("input[type=text]");
		input.parent('.form-group').removeClass('has-error');
		if(!input.val()){
			input.parent('.form-group').addClass('has-error');
		    $([document.documentElement, document.body]).animate({
		        scrollTop: input.parent().offset().top - ($('header nav').height() + 50)
		    }, 500);			
			return false;
		}
		var vehicle = parseInt($(this).data('vehicle'));
		var trimContanier = $('.trims-' + vehicle);
		printTrims(trimContanier,{year: vYear, model: $(this).parents('.vehicle-models').find('.model-search').val(), make:vMake,vehicle: vehicle});
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);		
	});
	function printTrims(trimContanier,data){
		var vehicle = data.vehicle;
		var make =  data.make;
		var year =  data.year;
		var model =  data.model;
		trimContanier.html('');
		$.ajax({
			type: "GET",
			url: '/ajax/trims/' + year + '/' + make + '/' + model
		}).done(function( res ) {
			if(res.length){
				trimContanier.siblings('.manual-trim').hide();
				$.each(res,function(i,trim){
					target =  'vin' + (vehicle);
					current = 'trims' + vehicle;
					trimHtml = '<label data-vehicle="' + vehicle + '" data-year="'+ year +'" class="h4 border col-10 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="'+ target + '" data-current="'+ current + '"> ' + trim.trim_1 + '<input type="radio" class="d-none" name="trim-'+ vehicle +'" value="'+ trim.trim_1 +'" /><i class="fa fa-angle-right"></i></label>';
					trimContanier.append(trimHtml);
				});
			}else{
				trimContanier.siblings('.manual-trim').show();
			}
		});
	}
	$(".vehicle-models .choices").on('click','label',function(){
		var model = $(this).children('input').val();
		var vehicle = parseInt($(this).data('vehicle'));
		var year = parseInt($(this).data('year'));
		var make = $(this).data('make');
		var trimContanier = $('.trims-' + vehicle);
		vModel = model;
		printTrims(trimContanier,{year: year, make: make, model: model, vehicle: vehicle});
		trimContanier.parent('.col-12').show();
	});

	$('.change-question.prev').on('click',function(){
		$(this).parents('div.container').removeClass('answered');
	})
	$('.change-question').on('click',function(e){
		var targetQuestion = $(this).data('href');
		var pos = parseInt($(this).data('pos'));
		var zip = $('#zipcode').val();
		zip = (zip) ? zip.trim() : "";
		if(pos == 1){
			$('label.error').remove();
			if($('#zipcode').val() == ""){
				$('#zipcode').parent('.form-group').addClass('has-error');
				return false;
			}else if(!(zip in zipcodes)){
				$('#zipcode').parent('.form-group').addClass('has-error');
				$('#zipcode').after('<label class="error font-weight-bold mt-3">Sorry! Currently we are not providing service in your area.</label>')
				return false;
			}else{
				$("#d-city").val(zipcodes[zip]);
				$("#d-zipcode").val(zip);
				$(".progress-container").slideDown(500);
			}
		}
		$('#start-screen').slideUp(500);
		$('.form-group').removeClass('has-error');
		$('form.lead-form > div.container').fadeOut(500);
		$('.brand-carousel').slideUp();
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);
	});

	$(".year-select-next").on('click',function(){
		$('label.error').remove();
		$(this).parents('.form-group').removeClass('has-error');
		var cYear = new Date().getFullYear() + 1;
		if(!$(this).siblings('select').val()){
			$(this).parents('.form-group').addClass('has-error');
			$(this).after('<label class="error mt-2 row col-12">Please select vehicle Year.</label>');
			return false;
		}else if( $(this).siblings('select').val() == 'other' &&  $(this).siblings('input').val() == ''){
			$(this).parents('.form-group').addClass('has-error');
			$(this).after('<label class="error mt-2 row col-12">Please enter vehicle Year between 1900-' + cYear +'.</label>');
			return false;
		}else if($(this).siblings('select').val() == 'other' && $(this).siblings('input').val() < 1900 || $(this).siblings('input').val() > cYear ){
			$(this).parents('.form-group').addClass('has-error');
			$(this).after('<label class="error mt-2 row col-12">Please enter vehicle Year between 1900-' + cYear +'.</label>');
			return false;
		}
		var year = ($(this).siblings('select').val() == 'other') ? $(this).siblings('input').val() : $(this).siblings('select').val();
		var href = $(this).data('models');
		var current = $(this).data('make');
		var vehicle = $(this).data('vehicle');
		var label = "";
		vYear =  year;
		$("#"+current + "-container .choices").html("");
		$("#"+current + "-container select").html("");
		$.ajax({
			type: "GET",
			url: '/ajax/makes/' + year
		}).done(function( res ) {
			if(res){
				var popMakes = [{"make":"Acura"},{"make":"Audi"},{"make":"BMW"},{"make":"Cadillac"},{"make":"Chevrolet"},{"make":"Dodge"},{"make":"Ford"},{"make":"GMC"},{"make":"Honda"},{"make":"Hyundai"},{"make":"INFINITI"},{"make": "Kia"},{"make":"Lexus"},{"make":"Mercedes-Benz"},{"make":"Nissan"},{"make":"Toyota"},{"make":"Volkswagen"},{"make":"Volvo"}];
				$.each(popMakes,function(i,mk){
					make = mk.make;
					label = '<label class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-year="' + year + '" data-href="'+ href +'" data-current="'+ current +'" data-vehicle="'+ vehicle +'">'+ make +'<input type="radio" class="d-none" name="'+ current +'" value="'+ make+ '" /></label>';
					$("#"+current + "-container .choices").append(label);
				})

				$("#"+current + "-container select").append("<option value=''>Choose one</option>");
				$.each(res,function(i,mk){
					make = mk.make;
					select = "<option value='"+ make +"' data-year='" + year + "'>"+ make +"</option>";
					$("#"+current + "-container select").append(select);
				});
				$("#"+current + "-container select").siblings('input').attr('data-year',year);				
				$("#"+current + "-container select").append("<option value='other'>Enter My Vehicle Make Manually</option>");
			}
		});

		$(this).parents('.container').find('input[type=radio]').prop('checked',false);
		$(this).parents('.container').find('label.bg-warning').removeClass('bg-warning');
		var targetQuestion = $(this).data('href');
		var prevQuestion = $(this).data('current');
		if(targetQuestion && prevQuestion){	
			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container a.change-question").data('href',prevQuestion);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);
		}
		return false;
	});	

	$('.container').on('click','.choices > label',function(e){
		$(this).siblings('label').removeClass('bg-warning');
		$(this).addClass('bg-warning');
		$(this).children('input[type=radio]').prop('checked',true);
		$(this).parents('.container').find('input.optional,select.optional').val('');
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

	$('.name-email-submit').on('click',function(e){
		$('.error').remove();
		var error = false;
		var el = "";
		var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
		$('.form-group').removeClass('has-error');
		$('.error-label').removeClass('error-label');

		var i = $(this).data('dob');
		var dob = $('input.dob' + i).val();
		if(dob){
			dob = dob.split('/');
			var df = dateDiff(dob[2] + "-" + dob[0] + "-" + dob[1]);

			if(df.y < 15){	
				$('input.dob' + i).parent('.form-group').addClass('has-error');
				$('input.dob' + i).parent('.form-group').append('<label class="ml-2 col-12 error text-danger">Age should be 15+</label>');
				el = (!error) ? $('input.dob' + i) : el;	
				error = true;
			}
		}else{
			el = (!error) ? $('input.dob' + i) : el;
			$('input.dob' + i).parent('.form-group').addClass('has-error');
		}

		$.each($('input:visible'),function(){
			if(!$(this).val()){
				$(this).parents('.form-group').addClass('has-error');
				el = (!error) ? $(this) : el;
				error = true;
			}
		});
		var cId = $(this).parents('.container').attr('id');
		$.each($('#' + cId + ' input[type=radio]'),function(e){
			var name = $(this).attr('name');
			if(!$('input[name='+  name +']').is(':checked')){
				$('input[name='+  name +']').parent('label').addClass('error-label');
				el = (!error) ? $('input[name='+  name +']') : el;
				error = true;
			}
		});		
		$.each($('select:visible'),function(){
			if(!$(this).val()){
				$(this).parents('.form-group').addClass('has-error');
				el = (!error) ? $(this) : el;
				error = true;
			}else{
				$(this).parents('.form-group').removeClass('has-error');
			}
		});
		if($('#first_name').val() == "" || $.trim($('#first_name').val()) == ""){
			$('#first_name').parent('.form-group').addClass('has-error');
			el = (!error) ? $('#first_name') : el;
			error = true;
		}
		if($('#last_name').val() == "" || $.trim($('#last_name').val()) == ""){
			$('#last_name').parent('.form-group').addClass('has-error');
			el = (!error) ? $('#last_name') : el;

			error = true;
		}
		if($('#email').val() == "" || $.trim($('#email').val()) == ""){
			$('#email').parent('.form-group').addClass('has-error');
			el = (!error) ? $('#email') : el;
			error = true;
		}
		if($('#email').val() && !pattern.test($('#email').val())){
			$('#email').parent('.form-group').addClass('has-error');
			$('#email').after('<label class="error text-danger">Enter Valid Email</label>');
			el = (!error) ? $('#email') : el;
			error = true;
		}		
		if(error){
			el.focus();
		    $([document.documentElement, document.body]).animate({
		        scrollTop: el.parent().offset().top - ($('header nav').height() + 50)
		    }, 500);			
			return false;
		}
		$('span.first-name-label').html($('#first_name').val());
		var targetQuestion = $(this).data('href');
		$('form.lead-form > div.container').fadeOut(500);
		$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);
		return false;
	});
	$('.driver-state').on('change',function(){
		if($(this).val()=='other'){
			$(this).parents('.container').find('.driver-state-input').removeClass('d-none');
		}else{
			$(this).parents('.container').find('.driver-state-input').addClass('d-none');
		}
	});

	$('.final-submit').on('click',function(e){
		var el = "";
		var error = false;
		var phoneRegex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
		$('.form-group').removeClass('has-error');
		$('.error:visible').remove();

		if($('#street').val() == "" || $.trim($('#street').val()) == ""){
			$('#street').parent('.form-group').addClass('has-error');
			el = (!error) ? $('#street') : el;
			error = true;
		}
		if($('#phone').val() == "" || $.trim($('#phone').val()) == ""){
			$('#phone').parent('.form-group').addClass('has-error');
			el = (!error) ? $('#phone') : el;
			error = true;
		}
		if($('#phone').val() && !phoneRegex.test($('#phone').val())){
			$('#phone').parent('.form-group').addClass('has-error');
			$('#phone').after('<label class="error text-danger">Enter Valid Phone Number</label>');
			el = (!error) ? $('#phone') : el;
			error = true;
		}
		if(!$('#TnC').is(":checked")){
			$('#TnC').parent('.custom-control.custom-checkbox ').addClass('has-error');
			el = (!error) ? $('#TnC') : el;
			error =true;
		}
		if(error){
		    $([document.documentElement, document.body]).animate({
		        scrollTop: el.parent().offset().top - ($('header nav').height() + 25)
		    }, 500);			
			return false;
		}
		$('form.lead-form').submit();	
	});
	$('.next-question').on('click',function(e){
		var targetQuestion = $(this).data('href');
		var prevQuestion = $(this).data('current');
		if(targetQuestion && prevQuestion){
			var error = false;
			$('.error').removeClass('error');
			$.each($('#' + prevQuestion + '-container input[type=radio]'),function(e){
				var name = $(this).attr('name');
				if(!$('input[name='+  name +']').is(':checked')){
					$(this).parent('label').addClass('error');
					error = true;
				}
			});
			$.each($('input:visible:not(".not-required")'),function(){
				$(this).parents('.form-group').removeClass('has-error');
				if(!$(this).val()){
					$(this).parents('.form-group').addClass('has-error');
					error = true;
				}
			});
			$.each($('select:visible:not(".not-required")'),function(){
				$(this).parents('.form-group').removeClass('has-error');
				if(!$(this).val()){
					$(this).parents('.form-group').addClass('has-error');
					error = true;
				}
			});

			if(error) return;

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
		dateSelect.append('<option value="">DD</option>');
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
		$('.error').remove();
		var error = false;
		var el = '';
		$.each($('input:visible'),function(){
			$(this).parents('.form-group').removeClass('has-error');
			if(!$(this).val()){
				$(this).parents('.form-group').addClass('has-error');
				el = (!error) ? $(this) : el;
				error = true;
			}
		});
		$.each($('select:visible'),function(){
			$(this).parents('.form-group').removeClass('has-error');
			if(!$(this).val()){
				el = (!error) ? $(this) : el;
				$(this).parents('.form-group').addClass('has-error');
				error = true;
			}
		});
		$('.error-label').removeClass('error-label');
		var cId = $(this).parents('.container').attr('id');
		$.each($('#' + cId + ' input[type=radio]'),function(e){
			var name = $(this).attr('name');
			if(!$('input[name='+  name +']').is(':checked')){
				$('input[name='+  name +']').parent('label').addClass('error-label');
				el = (!error) ? $('input[name='+  name +']') : el;
				error = true;
			}
		});
		var i = $(this).data('dob');
		var dob = $('input.dob' + i).val();
		if(dob){
			dob = dob.split('/');
			var df = dateDiff(dob[2] + "-" + dob[0] + "-" + dob[1]);

			if(df.y < 15){	
				$('input.dob' + i).parent('.form-group').addClass('has-error');
				$('input.dob' + i).parent('.form-group').append('<label class="ml-2 col-12 error text-danger">Age should be 15+</label>');
				el = (!error) ? $(this) : el;
				error = true;	
			}
		}else{
			$('input.dob' + i).parent('.form-group').addClass('has-error');
			el = (!error) ? $(this) : el;
			error = true;
		}
		if(error){
			el.focus();
		    $([document.documentElement, document.body]).animate({
		        scrollTop: el.parent().offset().top - ($('header nav').height() + 50)
		    }, 500);			
			return false;
		}
		if(!error){
			var targetQuestion = $(this).data('href');
			$('form.lead-form > div.container').fadeOut(500);
			$('form.lead-form > div#'+targetQuestion+"-container").delay(500).fadeIn(500);			
		}
	});

	$('.vin-submit').siblings('input').on('keyup',function(){
		if($(this).val() && $(this).val().length > 10){
			$(this).siblings('.vin-submit').removeClass('disabled');
		}else{
			$(this).siblings('.vin-submit').addClass('disabled');
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
