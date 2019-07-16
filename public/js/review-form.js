$(document).ready(function(){
	$('#reviewPopup').on('show.bs.modal', function (e) {
	  $('.q-progress tr td:last-child').addClass('recent-done question-done').prev('td').removeClass('recent-done');
	});
	$('#reviewPopup').on('hide.bs.modal', function (e) {
	  $('.q-progress tr td:last-child').removeClass('recent-done question-done').prev('td').addClass('recent-done');
	});	
	$('.review-application').on('click',function(){
		var error = false;
		var phoneRegex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
		$('.form-group').removeClass('has-error');
		$('.error:visible').remove();

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
			$('#phone').after('<label class="error text-danger">Enter Valid Phone Number</label>');
			error = true;
		}
		if(error){
			return false;
		}		
		$("#reviewPopup .questions_review_data").html('');		
		var vehiclesHtml = getVehicleHtml();
		html =  getVehicleHtml()  + insuranceHtml() + getPersonalInfoHtml() + getDriverHtml() + getContactInfoHtml();
		$("#reviewPopup .questions_review_data").append(html);
		$("#reviewPopup").modal('show');
	});

	function getVehicleHtml(){
		var html = "<h5 class='text-uppercase'>Vehicle Information</h5>";
		var vehcileHead =	"<tr class='bg-primary text-white'>" +
							"<th>#</th>" +
							"<th>Year</th>" +
							"<th>Make</th>" +
							"<th>Model</th>" +
							"<th>Trim</th>" +
							"<th>VIN</th>" +
							"<th>Ownership</th>" +
							"<th>Primary Use</th>" +
							"<th>Miles Driven/Year</th>" +
							"<th>Edit</th>" +
							"</tr>";
		//first vehicle
		var year1 = ($('select[name=vehicle-year]').val()) ? $('select[name=vehicle-year]').val() : $("input[name=year]:checked").val();
		if($('input[name=make-other]').val()){
			var make1 = $('input[name=make-other]').val();
		}else if($('select[name=make-select]').val()){
			var make1 = $('select[name=make-select]').val();
		}else{
			var make1 = $("input[name=make]:checked").val();
		}
		var model1 = ($('input[name=model1-other]').val()) ? $('input[name=model1-other]').val() : $("input[name=model-1]:checked").val();
		var trim1 = $("input[name=trim-1]:checked").val();
		var vin1 = $('input[name=vin1]').val();
		var ownership1 = $("input[name=ownership-vehicle-1]:checked").val();
		var primaryUse1 = $("input[name=primary-use-vehicle-1]:checked").val();
		var milesDriven1 = $("input[name=miles-driven-per-year-vehicle-1]:checked").val();
			
		var vehicle1 = "<tr>";
		vehicle1 += "<th>1.</th>";
		vehicle1 += "<td>" + year1 + "</td>";
		vehicle1 += "<td>" + make1 + "</td>";
		vehicle1 += "<td>" + model1 + "</td>";
		vehicle1 += "<td>" + trim1 + "</td>";
		vehicle1 += "<td>" + vin1 + "</td>";
		vehicle1 += "<td>" + ownership1 + "</td>";
		vehicle1 += "<td>" + primaryUse1 + "</td>";
		vehicle1 += "<td>" + milesDriven1 + "</td>";
		vehicle1 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
		vehicle1 += "</tr>";
		// Second vehicle
		var vehicle2 = "";
		if($("input[name=miles-driven-per-year-vehicle-2]:checked").val()){
			var year2 = ($('select[name=vehicle-year-2]').val()) ? $('select[name=vehicle-year-2]').val() : $("input[name=vehicle2-year]:checked").val();
			if($('input[name=vehicle2-make-other]').val()){
				var make2 = $('input[name=vehicle2-make-other]').val();
			}else if($('select[name=vehicle2-make-select]').val()){
				var make2 = $('select[name=vehicle2-make-select]').val();
			}else{
				var make2 = $("input[name=vehicle2-make]:checked").val();
			}
			var model2 = ($('input[name=model2-other]').val()) ? $('input[name=model2-other]').val() : $("input[name=model-2]:checked").val();
			var trim2 = $("input[name=trim-2]:checked").val();
			var vin2 = $('input[name=vin2]').val();
			var ownership2 = $("input[name=ownership-vehicle-2]:checked").val();
			var primaryUse2 = $("input[name=primary-use-vehicle-2]:checked").val();
			var milesDriven2 = $("input[name=miles-driven-per-year-vehicle-2]:checked").val();
				
			vehicle2 += "<tr>";
			vehicle2 += "<th>2.</th>";
			vehicle2 += "<td>" + year2 + "</td>";
			vehicle2 += "<td>" + make2 + "</td>";
			vehicle2 += "<td>" + model2 + "</td>";
			vehicle2 += "<td>" + trim2 + "</td>";
			vehicle2 += "<td>" + vin2 + "</td>";
			vehicle2 += "<td>" + ownership2 + "</td>";
			vehicle2 += "<td>" + primaryUse2 + "</td>";
			vehicle2 += "<td>" + milesDriven2 + "</td>";
			vehicle2 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle2 += "</tr>";
		}
		// Third vehicle
		var vehicle3 = "";
		if($("input[name=miles-driven-per-year-vehicle-3]:checked").val()){
			var year3 = ($('select[name=vehicle-year-3]').val()) ? $('select[name=vehicle-year-3]').val() : $("input[name=vehicle3-year]:checked").val();
			if($('input[name=vehicle3-make-other]').val()){
				var make3 = $('input[name=vehicle3-make-other]').val();
			}else if($('select[name=vehicle3-make-select]').val()){
				var make3 = $('select[name=vehicle3-make-select]').val();
			}else{
				var make3 = $("input[name=vehicle3-make]:checked").val();
			}
			var model3 = ($('input[name=model3-other]').val()) ? $('input[name=model3-other]').val() : $("input[name=model-3]:checked").val();
			var trim3 = $("input[name=trim-3]:checked").val();
			var vin3 = $('input[name=vin3]').val();
			var ownership3 = $("input[name=ownership-vehicle-3]:checked").val();
			var primaryUse3 = $("input[name=primary-use-vehicle-3]:checked").val();
			var milesDriven3 = $("input[name=miles-driven-per-year-vehicle-3]:checked").val();
				
			vehicle3 += "<tr>";
			vehicle3 += "<th>3.</th>";
			vehicle3 += "<td>" + year3 + "</td>";
			vehicle3 += "<td>" + make3 + "</td>";
			vehicle3 += "<td>" + model3 + "</td>";
			vehicle3 += "<td>" + trim3 + "</td>";
			vehicle3 += "<td>" + vin3 + "</td>";
			vehicle3 += "<td>" + ownership3 + "</td>";
			vehicle3 += "<td>" + primaryUse3 + "</td>";
			vehicle3 += "<td>" + milesDriven3 + "</td>";
			vehicle3 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle3 += "</tr>";
		}
		// Fourth vehicle
		var vehicle4 = "";
		if($("input[name=miles-driven-per-year-vehicle-4]:checked").val()){
			var year4 = ($('select[name=vehicle-year-4]').val()) ? $('select[name=vehicle-year-4]').val() : $("input[name=vehicle4-year]:checked").val();
			if($('input[name=vehicle4-make-other]').val()){
				var make4 = $('input[name=vehicle4-make-other]').val();
			}else if($('select[name=vehicle4-make-select]').val()){
				var make4 = $('select[name=vehicle4-make-select]').val();
			}else{
				var make4 = $("input[name=vehicle4-make]:checked").val();
			}
			var model4 = ($('input[name=model4-other]').val()) ? $('input[name=model4-other]').val() : $("input[name=model-4]:checked").val();
			var trim4 = $("input[name=trim-4]:checked").val();
			var vin4 = $('input[name=vin4]').val();
			var ownership4 = $("input[name=ownership-vehicle-4]:checked").val();
			var primaryUse4 = $("input[name=primary-use-vehicle-4]:checked").val();
			var milesDriven4 = $("input[name=miles-driven-per-year-vehicle-4]:checked").val();
				
			vehicle4 += "<tr>";
			vehicle4 += "<th>4.</th>";
			vehicle4 += "<td>" + year4 + "</td>";
			vehicle4 += "<td>" + make4 + "</td>";
			vehicle4 += "<td>" + model4 + "</td>";
			vehicle4 += "<td>" + trim4 + "</td>";
			vehicle4 += "<td>" + vin4 + "</td>";
			vehicle4 += "<td>" + ownership4 + "</td>";
			vehicle4 += "<td>" + primaryUse4 + "</td>";
			vehicle4 += "<td>" + milesDriven4 + "</td>";
			vehicle4 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle4 += "</tr>";
		}
		// Fifth vehicle
		var vehicle5 = "";
		if($("input[name=miles-driven-per-year-vehicle-5]:checked").val()){
			var year5 = ($('select[name=vehicle-year-5]').val()) ? $('select[name=vehicle-year-5]').val() : $("input[name=vehicle5-year]:checked").val();
			if($('input[name=vehicle5-make-other]').val()){
				var make5 = $('input[name=vehicle5-make-other]').val();
			}else if($('select[name=vehicle5-make-select]').val()){
				var make5 = $('select[name=vehicle5-make-select]').val();
			}else{
				var make5 = $("input[name=vehicle5-make]:checked").val();
			}
			var model5 = ($('input[name=model5-other]').val()) ? $('input[name=model5-other]').val() : $("input[name=model-5]:checked").val();
			var trim5 = $("input[name=trim-5]:checked").val();
			var vin5 = $('input[name=vin5]').val();
			var ownership5 = $("input[name=ownership-vehicle-5]:checked").val();
			var primaryUse5 = $("input[name=primary-use-vehicle-5]:checked").val();
			var milesDriven5 = $("input[name=miles-driven-per-year-vehicle-5]:checked").val();
				
			vehicle5 += "<tr>";
			vehicle5 += "<th>5.</th>";
			vehicle5 += "<td>" + year5 + "</td>";
			vehicle5 += "<td>" + make5 + "</td>";
			vehicle5 += "<td>" + model5 + "</td>";
			vehicle5 += "<td>" + trim5 + "</td>";
			vehicle5 += "<td>" + vin5 + "</td>";
			vehicle5 += "<td>" + ownership5 + "</td>";
			vehicle5 += "<td>" + primaryUse5 + "</td>";
			vehicle5 += "<td>" + milesDriven5 + "</td>";
			vehicle5 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle5 += "</tr>";
		}
		// Sixth vehicle
		var vehicle6 = "";
		if($("input[name=miles-driven-per-year-vehicle-6]:checked").val()){
			var year6 = ($('select[name=vehicle-year-6]').val()) ? $('select[name=vehicle-year-6]').val() : $("input[name=vehicle6-year]:checked").val();
			if($('input[name=vehicle6-make-other]').val()){
				var make6 = $('input[name=vehicle6-make-other]').val();
			}else if($('select[name=vehicle6-make-select]').val()){
				var make6 = $('select[name=vehicle6-make-select]').val();
			}else{
				var make6 = $("input[name=vehicle6-make]:checked").val();
			}
			var model6 = ($('input[name=model6-other]').val()) ? $('input[name=model6-other]').val() : $("input[name=model-6]:checked").val();
			var trim6 = $("input[name=trim-6]:checked").val();
			var vin6 = $('input[name=vin6]').val();
			var ownership6 = $("input[name=ownership-vehicle-6]:checked").val();
			var primaryUse6 = $("input[name=primary-use-vehicle-6]:checked").val();
			var milesDriven6 = $("input[name=miles-driven-per-year-vehicle-6]:checked").val();
				
			vehicle6 += "<tr>";
			vehicle6 += "<th>6.</th>";
			vehicle6 += "<td>" + year6 + "</td>";
			vehicle6 += "<td>" + make6 + "</td>";
			vehicle6 += "<td>" + model6 + "</td>";
			vehicle6 += "<td>" + trim6 + "</td>";
			vehicle6 += "<td>" + vin6 + "</td>";
			vehicle6 += "<td>" + ownership6 + "</td>";
			vehicle6 += "<td>" + primaryUse6 + "</td>";
			vehicle6 += "<td>" + milesDriven6 + "</td>";
			vehicle6 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle6 += "</tr>";
		}
		// Seventh vehicle
		var vehicle7 = "";
		if($("input[name=miles-driven-per-year-vehicle-7]:checked").val()){
			var year7 = ($('select[name=vehicle-year-7]').val()) ? $('select[name=vehicle-year-7]').val() : $("input[name=vehicle7-year]:checked").val();
			if($('input[name=vehicle7-make-other]').val()){
				var make7 = $('input[name=vehicle7-make-other]').val();
			}else if($('select[name=vehicle7-make-select]').val()){
				var make7 = $('select[name=vehicle7-make-select]').val();
			}else{
				var make7 = $("input[name=vehicle7-make]:checked").val();
			}
			var model7 = ($('input[name=model7-other]').val()) ? $('input[name=model7-other]').val() : $("input[name=model-7]:checked").val();
			var trim7 = $("input[name=trim-7]:checked").val();
			var vin7 = $('input[name=vin7]').val();
			var ownership7 = $("input[name=ownership-vehicle-7]:checked").val();
			var primaryUse7 = $("input[name=primary-use-vehicle-7]:checked").val();
			var milesDriven7 = $("input[name=miles-driven-per-year-vehicle-7]:checked").val();
				
			vehicle7 += "<tr>";
			vehicle7 += "<th>7.</th>";
			vehicle7 += "<td>" + year7 + "</td>";
			vehicle7 += "<td>" + make7 + "</td>";
			vehicle7 += "<td>" + model7 + "</td>";
			vehicle7 += "<td>" + trim7 + "</td>";
			vehicle7 += "<td>" + vin7 + "</td>";
			vehicle7 += "<td>" + ownership7 + "</td>";
			vehicle7 += "<td>" + primaryUse7 + "</td>";
			vehicle7 += "<td>" + milesDriven7 + "</td>";
			vehicle7 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle7 += "</tr>";
		}
		// Eighth vehicle
		var vehicle8 = "";
		if($("input[name=miles-driven-per-year-vehicle-8]:checked").val()){
			var year8 = ($('select[name=vehicle-year-8]').val()) ? $('select[name=vehicle-year-8]').val() : $("input[name=vehicle8-year]:checked").val();
			if($('input[name=vehicle8-make-other]').val()){
				var make8 = $('input[name=vehicle8-make-other]').val();
			}else if($('select[name=vehicle8-make-select]').val()){
				var make8 = $('select[name=vehicle8-make-select]').val();
			}else{
				var make8 = $("input[name=vehicle8-make]:checked").val();
			}
			var model8 = ($('input[name=model8-other]').val()) ? $('input[name=model8-other]').val() : $("input[name=model-8]:checked").val();
			var trim8 = $("input[name=trim-8]:checked").val();
			var vin8 = $('input[name=vin8]').val();
			var ownership8 = $("input[name=ownership-vehicle-8]:checked").val();
			var primaryUse8 = $("input[name=primary-use-vehicle-8]:checked").val();
			var milesDriven8 = $("input[name=miles-driven-per-year-vehicle-8]:checked").val();
				
			vehicle8 += "<tr>";
			vehicle8 += "<th>8.</th>";
			vehicle8 += "<td>" + year8 + "</td>";
			vehicle8 += "<td>" + make8 + "</td>";
			vehicle8 += "<td>" + model8 + "</td>";
			vehicle8 += "<td>" + trim8 + "</td>";
			vehicle8 += "<td>" + vin8 + "</td>";
			vehicle8 += "<td>" + ownership8 + "</td>";
			vehicle8 += "<td>" + primaryUse8 + "</td>";
			vehicle8 += "<td>" + milesDriven8 + "</td>";
			vehicle8 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle8 += "</tr>";
		}
		// Ninth vehicle
		var vehicle9 = "";
		if($("input[name=miles-driven-per-year-vehicle-9]:checked").val()){
			var year9 = ($('select[name=vehicle-year-9]').val()) ? $('select[name=vehicle-year-9]').val() : $("input[name=vehicle9-year]:checked").val();
			if($('input[name=vehicle9-make-other]').val()){
				var make9 = $('input[name=vehicle9-make-other]').val();
			}else if($('select[name=vehicle9-make-select]').val()){
				var make9 = $('select[name=vehicle9-make-select]').val();
			}else{
				var make9 = $("input[name=vehicle9-make]:checked").val();
			}
			var model9 = ($('input[name=model9-other]').val()) ? $('input[name=model9-other]').val() : $("input[name=model-9]:checked").val();
			var trim9 = $("input[name=trim-9]:checked").val();
			var vin9 = $('input[name=vin9]').val();
			var ownership9 = $("input[name=ownership-vehicle-9]:checked").val();
			var primaryUse9 = $("input[name=primary-use-vehicle-9]:checked").val();
			var milesDriven9 = $("input[name=miles-driven-per-year-vehicle-9]:checked").val();
				
			vehicle9 += "<tr>";
			vehicle9 += "<th>9.</th>";
			vehicle9 += "<td>" + year9 + "</td>";
			vehicle9 += "<td>" + make9 + "</td>";
			vehicle9 += "<td>" + model9 + "</td>";
			vehicle9 += "<td>" + trim9 + "</td>";
			vehicle9 += "<td>" + vin9 + "</td>";
			vehicle9 += "<td>" + ownership9 + "</td>";
			vehicle9 += "<td>" + primaryUse9 + "</td>";
			vehicle9 += "<td>" + milesDriven9 + "</td>";
			vehicle9 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle9 += "</tr>";
		}
		// Tenth vehicle
		var vehicle10 = "";
		if($("input[name=miles-driven-per-year-vehicle-10]:checked").val()){
			var year10 = ($('select[name=vehicle-year-10]').val()) ? $('select[name=vehicle-year-10]').val() : $("input[name=vehicle10-year]:checked").val();
			if($('input[name=vehicle10-make-other]').val()){
				var make10 = $('input[name=vehicle10-make-other]').val();
			}else if($('select[name=vehicle10-make-select]').val()){
				var make10 = $('select[name=vehicle10-make-select]').val();
			}else{
				var make10 = $("input[name=vehicle10-make]:checked").val();
			}
			var model10 = ($('input[name=model10-other]').val()) ? $('input[name=model10-other]').val() : $("input[name=model-10]:checked").val();
			var trim10 = $("input[name=trim-10]:checked").val();
			var vin10 = $('input[name=vin10]').val();
			var ownership10 = $("input[name=ownership-vehicle-10]:checked").val();
			var primaryUse10 = $("input[name=primary-use-vehicle-10]:checked").val();
			var milesDriven10 = $("input[name=miles-driven-per-year-vehicle-10]:checked").val();
				
			vehicle10 += "<tr>";
			vehicle10 += "<th>10.</th>";
			vehicle10 += "<td>" + year10 + "</td>";
			vehicle10 += "<td>" + make10 + "</td>";
			vehicle10 += "<td>" + model10 + "</td>";
			vehicle10 += "<td>" + trim10 + "</td>";
			vehicle10 += "<td>" + vin10 + "</td>";
			vehicle10 += "<td>" + ownership10 + "</td>";
			vehicle10 += "<td>" + primaryUse10 + "</td>";
			vehicle10 += "<td>" + milesDriven10 + "</td>";
			vehicle10 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			vehicle10 += "</tr>";
		}
		return html + "<table class='table table-sm table-bordered '>" + vehcileHead + vehicle1 + vehicle2 + vehicle3 + vehicle4 + vehicle5 + vehicle6 + vehicle7 + vehicle8 + vehicle9 + vehicle10 + "</table>"		
	}
	function insuranceHtml(){
		var html = "";
		var previousIns = $("input[name=previous-insurance]:checked").val();
		html += "<h5>Have you had auto insurance in the past 30 days?</h5>";
		html += "<p>";
		html += (previousIns == 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		if(previousIns == 1){
			html += "<h5>Current Auto Insurance?</h5>";
			html += "<p>";
			html += $('input[name=current-insurance]:checked').val();
			html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
			html += "</p>";

			html += "<h5>How long have you continuously had auto insurance?</h5>";
			html += "<p>";
			html += $('input[name=current-insurance-duration]:checked').val() + "year(s)";
			html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
			html += "</p>";
		}
		return html;
	}

	function getPersonalInfoHtml(){
		var html = "";
		var married = $("input[name=married]:checked").val();
		html += "<h5>Married?</h5>";
		html += "<p>";
		html += (married == 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		if(married == 1){
			html += "<h5>Children under the age of 16?</h5>";
			html += "<p>";
			html += ($('input[name=children]:checked').val() == 1 ) ? "Yes" : "No" ;
			html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
			html += "</p>";
		}
		html += "<h5>Do you own/rent?</h5>";
		html += "<p>";
		html += $('input[name=homeowner]:checked').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		if( $('input[name=homeowner]:checked').val() == 'owner'){
			html += "<h5>Would you like to also receive home insurance policy quotes? You may be able to bundle and save even more on your auto policy.</h5>";
		}else{
			html += "<h5>Would you like to also receive <span class='font-weight-bold'>Renters Insurance</span> policy quotes? You may be able to bundle and save even more on your auto policy.</h5>";
		}
		html += "<p>";
		html += ($('input[name=bundled]:checked').val() == 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		html += "<p><strong>Has anyone on this policy had:</strong></p>";
		html += "<h5>An at-fault accident in the past <strong>three (3) years?</strong></h5>";
		html += "<p>";
		html += ($('input[name=at_fault]:checked').val() == 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		html += "<h5><strong>Two (2) or more tickets</strong> in the past <strong>three (3) years?</strong>";
		html += "<p>";
		html += ($('input[name=tickets]:checked').val() == 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		html += "<h5>A DUI conviction in the past <strong>ten (10) years?</strong></h5>";
		html += "<p>";
		html += ($('input[name=dui]:checked').val()== 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";		

		html += "<h5>Bodily Injury Liability</h5>";
		html += "<p>";
		html += $('select[name=bodily-injury] option:selected').text();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";	

		html += "<h5>Property Damage</h5>";
		html += "<p>";
		html += "$" + $('select[name=property-damage]').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";			

		html += "<h5>Comprehensive Deductible</h5>";
		html += "<p>";
		html += "$" + $('select[name=deductible]').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		html += "<h5>Collision Deductible</h5>";
		html += "<p>";
		html += "$" + $('select[name=collision-deductible]').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		html += "<h5>Medical Coverage</h5>";
		html += "<p>";
		html += "$" + $('select[name=medical]').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		html += "<h5>Uninsured Motorist</h5>";
		html += "<p>";
		html += ($('input[name=uninsured]:checked').val() == 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";				

		html += "<h5>Road Side &amp; Towing</h5>";
		html += "<p>";
		html += ($('input[name=towing]:checked').val()== 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";				

		html += "<h5>Rental Car</h5>";
		html += "<p>";
		html += ($('input[name=rental]:checked').val()== 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";	

		html += "<h5>What is the most important quality you look for when choosing an auto insurer?</h5>";
		html += "<p>";
		html += $('select[name=quality] option:selected').text();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";	

		html += "<h5>Will it be important to you to be able to speak to your local agent in person?</h5>";
		html += "<p>";
		html += ($('input[name=agent_in_person]:checked').val()== 1 ) ? "Yes" : "No";
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";						

		html += "<h5>How did you hear about us?</h5>";
		html += "<p>";
		html += $('select[name=referrer] option:selected').text();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";	

		html += "<h5>Referrer Name</h5>";
		html += "<p>";
		html += $('input[name=referrer_name]').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";
		return html;
	}
	function getDriverHtml(){
		var html = "<h5 class='text-uppercase'>Driver Information</h5>";
		var head =	"<tr class='bg-primary text-white'>" +
							"<th>#</th>" +
							"<th>First name</th>" +
							"<th>Last name</th>" +
							"<th>Birthday</th>" +
							"<th>Gender</th>" +
							"<th>Drivers License Number</th>" +
							"<th>State</th>" +
							"<th>Edit</th>" +
							"</tr>";
		var driver1 = "<tr>";
		driver1 += "<th>1.</th>";
		driver1 += "<td>" + $('input[name=first_name]').val() + "</td>";
		driver1 += "<td>" + $('input[name=last_name]').val() + "</td>";
		driver1 += "<td>" + $('input[name=dob]').val() + "</td>";
		driver1 += "<td>" + $('input[name=gender]:checked').val() + "</td>";
		driver1 += "<td>" + $('input[name=dl1]').val() + "</td>";
		driver1 += "<td>" + $('select[name=state1] option:selected').text();+ "</td>";
		driver1 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
		driver1 += "</tr>";

		var driver2 = "";
		if($('input[name=first_name2]').val() && $('input[name=dl2]').val()){			
			driver2 += "<tr>";
			driver2 += "<th>1.</th>";
			driver2 += "<td>" + $('input[name=first_name2]').val() + "</td>";
			driver2 += "<td>" + $('input[name=last_name2]').val() + "</td>";
			driver2 += "<td>" + $('input[name=dob2]').val() + "</td>";
			driver2 += "<td>" + $('input[name=gender-2]:checked').val() + "</td>";
			driver2 += "<td>" + $('input[name=dl2]').val() + "</td>";
			driver2 += "<td>" + $('select[name=state2] option:selected').text()+ "</td>";
			driver2 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			driver2 += "</tr>";		
		}
		var driver3 = "";
		if($('input[name=first_name3]').val() && $('input[name=dl3]').val()){			
			driver3 += "<tr>";
			driver3 += "<th>1.</th>";
			driver3 += "<td>" + $('input[name=first_name3]').val() + "</td>";
			driver3 += "<td>" + $('input[name=last_name3]').val() + "</td>";
			driver3 += "<td>" + $('input[name=dob3]').val() + "</td>";
			driver3 += "<td>" + $('input[name=gender-3]:checked').val() + "</td>";
			driver3 += "<td>" + $('input[name=dl3]').val() + "</td>";
			driver3 += "<td>" + $('select[name=state3] option:selected').text()+ "</td>";
			driver3 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			driver3 += "</tr>";		
		}
		var driver4 = "";
		if($('input[name=first_name4]').val() && $('input[name=dl4]').val()){			
			driver4 += "<tr>";
			driver4 += "<th>1.</th>";
			driver4 += "<td>" + $('input[name=first_name4]').val() + "</td>";
			driver4 += "<td>" + $('input[name=last_name4]').val() + "</td>";
			driver4 += "<td>" + $('input[name=dob4]').val() + "</td>";
			driver4 += "<td>" + $('input[name=gender-4]:checked').val() + "</td>";
			driver4 += "<td>" + $('input[name=dl4]').val() + "</td>";
			driver4 += "<td>" + $('select[name=state4] option:selected').text()+ "</td>";
			driver4 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			driver4 += "</tr>";		
		}
		var driver5 = "";
		if($('input[name=first_name5]').val() && $('input[name=dl5]').val()){			
			driver5 += "<tr>";
			driver5 += "<th>1.</th>";
			driver5 += "<td>" + $('input[name=first_name5]').val() + "</td>";
			driver5 += "<td>" + $('input[name=last_name5]').val() + "</td>";
			driver5 += "<td>" + $('input[name=dob5]').val() + "</td>";
			driver5 += "<td>" + $('input[name=gender-5]:checked').val() + "</td>";
			driver5 += "<td>" + $('input[name=dl5]').val() + "</td>";
			driver5 += "<td>" + $('select[name=state5] option:selected').text()+ "</td>";
			driver5 += "<td><a href='javascript:;'><i class='fa fa-edit'></i></a></td>";
			driver5 += "</tr>";		
		}
		return html + "<table class='table table-sm table-bordered '>" + head + driver1 + driver2 + driver3 + driver4 + driver5 + "</table>"				
	}
	function getContactInfoHtml(){
		var html = "";
		html += "<h5>Phone Number</h5>";
		html += "<p>";
		html += $('input[name=phone]').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		html += "<h5>Email</h5>";
		html += "<p>";
		html += $('input[name=email]').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";

		html += "<h5>Street Address</h5>";
		html += "<p>";
		html += $('input[name=street]').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";		
		html += "<h5>City</h5>";
		html += "<p>";
		html += $('input#d-city').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";		
		html += "<h5>State</h5>";
		html += "<p>";
		html += $('input#d-state').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";
		html += "<h5>Zipcode</h5>";
		html += "<p>";
		html += $('input#d-zipcode').val();
		html += "<a class='pull-right' href='javascript:;'><i class='fa fa-edit'></i></a>";
		html += "</p>";			
		return html;							
	}
})