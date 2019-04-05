jQuery(document).ready(function ($) {

	if($('#formcheck').val()==1) {
		$("#company_name2").keyup(function() {
	
			var val=$(this).val();
	
			if(val.length>=4) {
	
				$(this).hide();
	
				$("#company_name").show();
	
				$("#company_name").val(val);
	
				$("#company_name").focus();
	
			}
	
		});	
	
		$("#company_name").keyup(function() {
	
			var val=$(this).val();
	
			if(val.length<4) {
	
				$(this).hide();
	
				$("#company_name2").show();
	
				$("#company_name2").val(val);
	
				$("#company_name2").focus();
	
			}
	
		});	
	
		$("#frm").submit(function() {
	
			$("#company_name2").remove();
	
		});
	
		$("#submit" ).click(function(e) {		
	
			if(i==0){
	
				$( "#frm" ).submit();
	
			}
	
			$( "#frm" ).submit();
	
		});	
	
		$( ".1st_step" ).click(function() {		
	
			$( "#first_form" ).show();
	
			$( "#sec_form" ).hide();
	
			$( "#third_form" ).hide();		
	
		});
	
		$( ".2nd_step" ).click(function() {
	
			console.log("click start");
	
			var i=0;
	
			if($('#company_name').val()=='') { 
	
				$( "#company_name" ).removeClass( "successClass" );
	
				$('#company_name').addClass( "errorClass" );
	
				console.log("company_name");
	
				i++;
	
			}else{
	
				$( "#company_name" ).removeClass( "errorClass" )
	
				$('#company_name').addClass( "successClass" );
	
			}		
	
			if($('#company_house_no').val()=='') { 
	
				$( "#company_house_no" ).removeClass( "successClass" );
	
				$('#company_house_no').addClass( "errorClass" );
	
				console.log("company_house_no");
	
				i++;
	
			}else{
	
				$( "#company_house_no" ).removeClass( "errorClass" )
	
				$('#company_house_no').addClass( "successClass" );
	
			}
			
	
			if($('#company_street').val()=='') { 
	
				$( "#company_street" ).removeClass( "successClass" );
	
				$('#company_street').addClass( "errorClass" );
	
							console.log("company_street");
	
				i++;
	
			}else{
	
				$( "#company_street" ).removeClass( "errorClass" )
	
				$('#company_street').addClass( "successClass" );
	
			}
			
	
			if($('#company_city').val()=='') { 
	
				$( "#company_city" ).removeClass( "successClass" );
	
				$('#company_city').addClass( "errorClass" );
	
				console.log("company_city");
	
				i++;
	
			}else{
	
				$( "#company_city" ).removeClass( "errorClass" )
	
				$('#company_city').addClass( "successClass" );
	
			}
			
	
			if($('#company_state').val()=='') { 
	
				$( "#company_state" ).removeClass( "successClass" );
	
				$('#company_state').addClass( "errorClass" );
	
							console.log("company_state");
	
				i++;
	
			}else{
	
				$( "#company_state" ).removeClass( "errorClass" )
	
				$('#company_state').addClass( "successClass" );
	
			}
	
			if($('#company_country').val()=='') { 
	
				$( "#company_country" ).removeClass( "successClass" );
	
				$('#company_country').addClass( "errorClass" );
	
							console.log("company_country");
	
				i++;
	
			}else{
	
				$( "#company_country" ).removeClass( "errorClass" )
	
				$('#company_country').addClass( "successClass" );
	
			}		
	
			if($('#company_zip').val()=='') { 
	
				$( "#company_zip" ).removeClass( "successClass" );
	
				$('#company_zip').addClass( "errorClass" );
	
							console.log("company_zip");
	
				i++;
	
			}else{
	
				$( "#company_zip" ).removeClass( "errorClass" )
	
				$('#company_zip').addClass( "successClass" );
	
			}
	
			
	
			if($('#company_contact_phone').val()=='') { 
	
				$( "#company_contact_phone" ).removeClass( "successClass" );
	
				$('#company_contact_phone').addClass( "errorClass" );
	
							console.log("company_contact_phone");
	
				i++;
	
			}else{
	
				$( "#company_contact_phone" ).removeClass( "errorClass" )
	
				$('#company_contact_phone').addClass( "successClass" );
	
			}
	
			if($('#company_contact_email').val()=='') { 
	
				$( "#company_contact_email" ).removeClass( "successClass" );
	
				$('#company_contact_email').addClass( "errorClass" );
	
							console.log("company_contact_email");
	
				i++;
	
			}else{
	
				$( "#company_contact_email" ).removeClass( "errorClass" )
	
				$('#company_contact_email').addClass( "successClass" );
	
			}		
	
			if(i==0){
	
				$( "#first_form" ).hide();
	
				$( "#sec_form" ).show();
	
				$( "#third_form" ).hide();
	
			}else{
	
				alert("Graag alle velden invullen");
	
			}
	
		});
	
		$( ".3rd_step" ).click(function() {
	
			var i=0;
	
			var total = 30;				
	
			var serviceList = 0;
	
			$('input.company_services').each(function () {
	
				var cThisVal = (this.checked ? "1" : "0");
	
				serviceList=serviceList+cThisVal;
	
				console.log("In loop");
	
			});
	
			
	
			var clientTypeList = 0;
	
			$('input.company_client_type').each(function () {
	
				var cThisVal = (this.checked ? "1" : "0");
	
				clientTypeList=clientTypeList+cThisVal;
	
				console.log("In loop");
	
			});
	
			if (serviceList==0) {
	
				$('#company_services_msg').show();
	
				//i++;
	
				i=101;
	
			}
	
			else{
	
				$('#company_services_msg').hide();
	
			}
	
					
	
			if(clientTypeList==0) { 
	
				$('#company_client_type_msg').html("Selecteer het type bezoeker");
	
			//i++;
	
				i=102;
	
			}
	
			else {
	
				$('#company_client_type_msg').hide();
	
			}
		
	
			if($('#company_type').val()==0) { 
	
				$('#company_type_msg').html("Maak qqqqeen keuze uit het type<br />");
	
				i++;
	
			}else{
	
				$('#company_type_msg').hide();
	
			}	
	
			
	
			if($('#company_client_age').val()==0) { 
	
				$('#company_client_age_msg').html("Geef de leeftijds doelgroep op");
	
				i++;
	
			}else{
	
				$('#company_client_age_msg').hide();
	
			}
		
	
			if($('#company_client_expense').val()==0) { 
	
				$('#company_client_expense_msg').html("Selecteer het bestedingspatroon");
	
				i++;
	
			}else{
	
				$('#company_client_expense_msg').hide();
	
			}
	
			if($('#guest_composition').val()==0) { 
	
				$('#guest_composition_msg').html("Geef de samenstelling van uw gasten in");
	
				i++;
	
			}else{
	
				$('#guest_composition_msg').hide();
	
			}
			
	
			if($('#opening_days').val()==0) { 
	
				$('#opening_days_msg').html("Selecteer het aantal openingsdagen");
	
				i++;
	
			}else{
	
				$('#opening_days_msg').hide();
	
			}
		
	
			if(i==0){
	
				$( "#first_form" ).hide();
	
				$( "#sec_form" ).hide();
	
				$( "#third_form" ).show();
	
			}else{
	
				alert("Graag all velden invullen! ");
	
			}
	
		});
	
		function openFile(file) {
	
			var extension = file.substr( (file.lastIndexOf('.') +1) );
	
			switch(extension) {
	
				case 'pdf':
	
				case 'eps':
	
				case 'ai':
	
							case 'jpg':
	
				case 'png':
	
					return 1;
	
				break;
	
				
	
				default:
	
					return 0;
	
			}
	
		}
	
		initAutocomplete();
	}
	
});



var placeSearch, autocomplete;

var componentForm = {

	street_number: 'short_name',

	route: 'long_name',

	locality: 'long_name',

	administrative_area_level_1: 'long_name',

	country: 'long_name',

	postal_code: 'short_name'

};	  



function initAutocomplete() {

	autocomplete = new google.maps.places.Autocomplete(

	/** @type {!HTMLInputElement} */(document.getElementById('company_name')),

	{componentRestrictions: {country: "NL"}});

	autocomplete.addListener('place_changed', fillInAddress);

}



function fillInAddress() {

	// Get the place details from the autocomplete object.

	var place = autocomplete.getPlace();

	console.log(place);



	for (var component in componentForm) {

	  document.getElementById(component).value = '';

	  document.getElementById(component).disabled = false;

	}

	

	for (var i = 0; i < place.address_components.length; i++) {

		var addressType = place.address_components[i].types[0];		  

		if (componentForm[addressType]) {

			var val = place.address_components[i][componentForm[addressType]];

			document.getElementById(addressType).value = val;			

		}

	}

}





jQuery(document).ready(function($) {
	
	if($('#formcheck').val()==2) {		
				
		var gbCenter = new google.maps.LatLng(52.370216,4.895168);
	
		var gbZoom = 7;	
	
		$('#cityModalBtn').click(function() {$('#city').focus();});
	
		$('#stateModalBtn').click(function() {$('#state').focus();});
	
		/******************************************/
	
		$.ajax({
	
				type: "POST",
	
				url: ajax_order_object.ajaxurl,
	
				data: {
	
					action: 'mapfilterall',
	
					selected_country_name: $("#countryVal").val()
	
				},
	
		
	
				success: function(data) {
					
					var obj = JSON.parse(data);
	
					var visitorCost = 0;
	
					var priceMonth = 0;
	
					var deriv_6 = $("#deriv_6").val();
	
					var deriv_9 = $("#deriv_9").val();
	
					var deriv_12 = $("#deriv_12").val();
	
					var avgCLatValMap='';
	
					var avgSLatValMap='';
	
					var dataTable = "<table><tr><td>Wel/niet</td><td>Naam</td><td>Gasten/maand</td><td></td><td>Prijs/maand(Euro)</td></tr>";
	
		
	
					/********************************************************/
	
					for (i = 0; i < obj.length; i++){
	
						
	
						if (obj[i].available == "1") {
	
							dataTable=dataTable+"<tr><td>"+"<input type='hidden' id='hid_price_"+i+"' value='"+obj[i].price_per_month+"'><input type='hidden' id='hid_visitors_"+i+"' value='"+obj[i].company_monthly_visitors+"'><label class='checkBoxContainer'><input type='checkbox' checked name='selectedCafe' class='selectedCafe' id='cafe_"+i+"' value='"+i+"'  cafe_name='"+obj[i].company_name+"'  visitor='"+obj[i].company_monthly_visitors+"' price='"+obj[i].price_per_month+"' /><span class='checkmark'></span></label> "+"</td><td>"+obj[i].company_name+"</td><td id='td_visitor_"+i+"'>"+obj[i].company_monthly_visitors+"</td><td></td> <td id='td_price_"+i+"'>"+obj[i].price_per_month+"</td></tr>";
	
							visitorCost = parseFloat(visitorCost) + parseFloat(obj[i].company_monthly_visitors);
	
							priceMonth = parseFloat(priceMonth) + parseFloat(obj[i].price_per_month);
	
						}
	
					}
	
		
	
					dataTable = dataTable + "<tr><td>" + " " + "</td><td>Geschat maandelijks bereik horecagasten</td><td><div id='visitId'>" + visitorCost + "</div></td><td></td><td></td></tr>";
	
					dataTable = dataTable + "<tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr>";
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Totale prijs per maand gebaseerd op 3 maanden reservering</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='3' name='period' class='period' checked><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_3'>" + Math.round(priceMonth) + "</span></td></tr>";
	
					
	
					var price6=Math.round(parseFloat(priceMonth) * parseFloat(deriv_6)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Totale prijs per maand gebaseerd op 6 maanden reservering</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='6'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_6'>" + Math.round(price6) + "</span></td></tr>";
	
					
	
					var price9=Math.round(parseFloat(priceMonth) * parseFloat(deriv_9)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Totale prijs per maand gebaseerd op 9 maanden reservering</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='9'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_9'>" + Math.round(price9) + "</span></td></tr>";
	
					
	
					var price12=Math.round(parseFloat(priceMonth) * parseFloat(deriv_12)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Totale prijs per maand gebaseerd op 12 maanden reservering</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='12'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_12'>" +  Math.round(price12)+ "</span></td></tr>";
	
					
	
					var dataTable = dataTable + "<table>";
	
					var dataTable = dataTable + "<table>";
	
					$("#listData").html(dataTable);
	
					/********************************************************/
	
					var avgCLatValMap = $('#avgCLat').val();
	
					var avgCLonValMap = $('#avgCLon').val();
	
					var avgSLatValMap = $('#avgSLat').val();
	
					var avgSLonValMap = $('#avgSLon').val();
	
					var avgCnLatValMap = 52.370216;
	
					var avgCnLonValMap = 4.895168;
	
					if(avgCLatValMap.length>0) {
	
						var avgAllLatValMap = avgCLatValMap;
	
						var avgAllLonValMap = avgCLonValMap;
	
						var zoomVal = 10;
	
					}
	
					else 
	
						if(avgSLatValMap.length>0) {
	
						var avgAllLatValMap = avgSLatValMap;
	
						var avgAllLonValMap = avgSLonValMap;
	
						var zoomVal = 8;
	
					}
	
					else {
	
						var avgAllLatValMap = avgCnLatValMap;
	
						var avgAllLonValMap = avgCnLonValMap;
	
						var zoomVal = 7;
	
					}
	
					
	
					var map = new google.maps.Map(document.getElementById('map'), {
	
						zoom: zoomVal,
	
						//center: new google.maps.LatLng(52.370216,4.895168),
	
						center: new google.maps.LatLng(avgAllLatValMap, avgAllLonValMap),				
	
						mapTypeId: google.maps.MapTypeId.ROADMAP
	
					});
	
					
	
					var infowindow = new google.maps.InfoWindow();
	
		
	
					var marker, i, flag;
	
					for (i = 0; i < obj.length; i++){
	
						if (obj[i].available == "1") {
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-green.png";
	
						} 
	
						else {
	
							//flag = "http://icons.iconarchive.com/icons/paomedia/small-n-flat/48/map-marker-icon.png";
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-red.png";
	
						}
	
		
	
						marker = new google.maps.Marker
	
						({
	
							position: new google.maps.LatLng(obj[i].company_lat, obj[i].company_lon),
	
							animation: google.maps.Animation.DROP,
	
							icon: flag,
	
							map: map
	
						});
	
		
	
						google.maps.event.addListener(marker, 'mouseover', (function(marker, i) 
	
						{
	
							return function() 
	
							{
	
								var img ='<img src="'+ajax_order_object.pluginurl+'/assets/uploads/reclavilt-favicon.png" style="width:80px">';
	
								if(obj[i].company_logo!='')
	
								{
	
									var img = '<img src="'+ajax_order_object.pluginurl+'/assets/uploads/' + obj[i].company_logo + '" style="width:80px">';
	
								}
	
								var pdf_url=ajax_order_object.pluginurl+"/companypdf.php?ID="+obj[i].company_id_bm;
	
								infowindow.setContent(obj[i].company_name +"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+img + "<br/>Maandelijkse bezoekers: "+ obj[i].company_monthly_visitors+ "<br/>Maandtarief vanaf: <strong> € "+ obj[i].price_per_month+"</strong><br/><a href=" + pdf_url + " target=_blank>Klik hier voor de Specificaties<a>");
	
								infowindow.open(map, marker);
	
							}
	
						})(marker, i));
	
				google.maps.event.addListener(map, 'zoom_changed',   function () { gbZoom = map.getZoom();});
	
				google.maps.event.addListener(map, 'center_changed', function () { gbCenter = map.getCenter();});
	
		
	
					}
	
		
	
				}
	
		
	
			});
	
		
	
		/*****************************************/
	
		$(".form-control").change(function() {
	
	
	
			var company_services_data = "";
	
			$('input[name="company_services"]:checked').each(function() {
	
				if (company_services_data != "") {
	
					company_services_data = company_services_data + "," + this.value;
	
				} else {
	
					company_services_data = this.value;
	
				}
	
			});
	
	
	
			//console.log(company_services_data);
	
	
	
			$.ajax({
	
				type: "POST",
	
				url: ajax_order_object.ajaxurl,
	
				data: {
	
					action: 'mapfilter',
	
					//type_cafe: $("#type_cafe").is(':checked') ? 1 : 0,
	
					//type_grandcafe: $("#type_grandcafe").is(':checked') ? 1 : 0,
	
					//type_restaurant: $("#type_restaurant").is(':checked') ? 1 : 0,
	
					//type_bar: $("#type_bar").is(':checked') ? 1 : 0,
	
					//type_night_club: $("#type_night_club").is(':checked') ? 1 : 0,
	
					//type_discotheek: $("#type_discotheek").is(':checked') ? 1 : 0,
	
					//type_hotel: $("#type_hotel").is(':checked') ? 1 : 0,
	
					//type_evenement: $("#type_evenement").is(':checked') ? 1 : 0,
	
					service_ontbijt: $("#service_ontbijt").is(':checked') ? 1 : 0,
	
					service_lunch: $("#service_lunch").is(':checked') ? 1 : 0,
	
					service_diner: $("#service_diner").is(':checked') ? 1 : 0,
	
					service_borrel: $("#service_borrel").is(':checked') ? 1 : 0,
	
					service_uitgaan: $("#service_uitgaan").is(':checked') ? 1 : 0,
	
					service_overnachting: $("#service_overnachting").is(':checked') ? 1 : 0,
	
					
	
					company_type: $("#company_type").val(),
	
			
	
					klant_kinderen: $("#klant_kinderen").is(':checked') ? 1 : 0,
	
					klant_studenten: $("#klant_studenten").is(':checked') ? 1 : 0,
	
					klant_zakelijk: $("#klant_zakelijk").is(':checked') ? 1 : 0,
	
					klant_familiair: $("#klant_familiair").is(':checked') ? 1 : 0,
	
					klant_toeristen: $("#klant_toeristen").is(':checked') ? 1 : 0,
	
					klant_stamgasten: $("#klant_stamgasten").is(':checked') ? 1 : 0,
	
					company_monthly_visitors: $("#company_monthly_visitors").val(),
	
					company_client_age_msg: $("#company_client_age_msg").val(),
	
					company_client_expense_msg: $("#company_client_expense_msg").val(),
	
					selected_type: $("#type").val(),
	
					selected_city_name: $("#city").val(),
	
					selected_state_name: $("#state").val()
	
				},
	
	
	
				success: function(data) {
	
	
	
					var obj = JSON.parse(data);
	
	
	
					//console.log(obj);
	
					var visitorCost = 0;
	
					var priceMonth = 0;
	
					var deriv_6 = $("#deriv_6").val();
	
					var deriv_9 = $("#deriv_9").val();
	
					var deriv_12 = $("#deriv_12").val();
	
					var color2show='';
	
			var avgCLatValMap='';
	
			var avgSLatValMap='';
	
					var dataTable = "<table><tr><td>Wel/niet</td><td>Name</td><td>Gasten/maand</td><td></td><td><fontcolor>Pijs/maand(Euro)</td></tr>";
	
					var availability='';
	
	
	
					/********************************************************/
	
					for (i = 0; i < obj.length; i++) 
	
					{
	
						//console.log("test"+i);
	
						//console.log(obj[i].company_name);
	
						
	
						if(obj[i].available == '1')
	
						{
	
							availability=' --> per direct beschikbaar';
	
							color2show="green";
	
							
	
							dataTable=dataTable+"<tr><td>"+"<input type='hidden' id='hid_price_"+i+"' value='"+obj[i].price_per_month+"'><input type='hidden' id='hid_visitors_"+i+"' value='"+obj[i].company_monthly_visitors+"'><label class='checkBoxContainer'><input type='checkbox' checked name='selectedCafe' class='selectedCafe' id='cafe_"+i+"' value='"+i+"' cafe_name='"+obj[i].company_name+"' visitor='"+obj[i].company_monthly_visitors+"' price='"+obj[i].price_per_month+"' /><span class='checkmark'></span></label>"+"</td><td>"+obj[i].company_name+" "+availability.fontcolor(color2show)+"</td><td id='td_visitor_"+i+"'>"+obj[i].company_monthly_visitors+"</td><td></td> <td id='td_price_"+i+"'>"+obj[i].price_per_month+"</td></tr>";
	
							visitorCost = parseFloat(visitorCost) + parseFloat(obj[i].company_monthly_visitors);
	
							priceMonth = parseFloat(priceMonth) + parseFloat(obj[i].price_per_month);
	
						
	
						}
	
						else
	
						{
	
							availability=" --> gereserveerd tot  "+obj[i].end_period+"";
	
							color2show="red";
	
						} 
	
						
	
					}
	
	
	
					dataTable = dataTable + "<tr><td>" + " " + "</td><td>Geschat maandelijks bereik horecagasten</td><td>" + visitorCost + "</td><td></td><td></td></tr>";
	
					dataTable = dataTable + "<tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr>";
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Totale prijs per maand gebaseerd op 3 maanden reservering</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='3' name='period' class='period' checked><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_3'>" + Math.round(priceMonth) + "</span></td></tr>";
	
					//var price6=parseFloat(priceMonth) * parseFloat(deriv_6);
	
					
	
					var price6=Math.round(parseFloat(priceMonth) * parseFloat(deriv_6)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Totale prijs per maand gebaseerd op 6 maanden reservering</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='6'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_6'>" + Math.round(price6) + "</span></td></tr>";
	
					//var price9=parseFloat(priceMonth) * parseFloat(deriv_9);
	
					
	
					var price9=Math.round(parseFloat(priceMonth) * parseFloat(deriv_9)*100)/100;
	
					//console.log("b"+price9);
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Totale prijs per maand gebaseerd op 9 maanden reservering</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='9'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_9'>" +  Math.round(price9)+ "</span></td></tr>";
	
	
	
					
	
					//var price12=parseFloat(priceMonth) * parseFloat(deriv_12);
	
					var price12=Math.round(parseFloat(priceMonth) * parseFloat(deriv_12)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Totale prijs per maand gebaseerd op 12 maanden reservering</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='12'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_12'>" +  Math.round(price12)+ "</span></td></tr>";
	
					var dataTable = dataTable + "<table>";
	
	
	
	
	
	
	
					$("#listData").html(dataTable);
	
			
	
					if($("#cval").text()=='' && $("#sval").text()=='' && $("#countryVal").val()!='')
	
							{
	
								var avgCnLatValMap = 52.370216;
	
								var avgCnLonValMap = 4.895168;
	
					}
	
					else
	
					{
	
						var avgCLatValMap = $('#avgCLat').val();
	
						var avgCLonValMap = $('#avgCLon').val();
	
	
	
						var avgSLatValMap = $('#avgSLat').val();
	
						var avgSLonValMap = $('#avgSLon').val();
	
					}
	
					//console.log(avgCLatValMap);
	
					if(avgCLatValMap.length>0) 
	
					{
	
							var avgAllLatValMap = avgCLatValMap;
	
							var avgAllLonValMap = avgCLonValMap;
	
							var zoomVal = 10;
	
					}
	
					
	
					if(avgSLatValMap.length>0) 
	
					{
	
							var avgAllLatValMap = avgSLatValMap;
	
							var avgAllLonValMap = avgSLonValMap;
	
							var zoomVal = 8;
	
					}
	
					else 
	
					{
	
							var avgAllLatValMap = avgCnLatValMap;
	
							var avgAllLonValMap = avgCnLonValMap;
	
							var zoomVal = 7;
	
					}
	
					
	
					var map = new google.maps.Map(document.getElementById('map'), {
	
	
	
						zoom: gbZoom,
	
						//center: new google.maps.LatLng(52.370216,4.895168),					
	
							
	
						center: gbCenter,
	
						mapTypeId: google.maps.MapTypeId.ROADMAP
	
	
	
					});
	
					
	
					google.maps.event.addListener(map, 'zoom_changed', function () {
	
						gbZoom = map.getZoom();	
	
					});
	
					 
	
					google.maps.event.addListener(map, 'center_changed', function () {
	
						gbCenter = map.getCenter();			
	
					});
	
					
	
	
	
					var infowindow = new google.maps.InfoWindow();
	
	
	
					var marker, i;
	
	
	
					for (i = 0; i < obj.length; i++) 
	
					{
	
						if (obj[i].available == "1") 
	
						{
	
							//flag ="http://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Marker-Outside-Chartreuse-icon.png";
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-green.png";
	
	
	
						} else 
	
						{
	
							flag = "http://icons.iconarchive.com/icons/paomedia/small-n-flat/48/map-marker-icon.png";
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-red.png";
	
						}
	
	
	
						marker = new google.maps.Marker({
	
						position: new google.maps.LatLng(obj[i].company_lat, obj[i].company_lon),
	
						animation: google.maps.Animation.DROP,
	
						icon: flag,
	
						map: map
	
						});
	
	
	
						google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
	
							return function() 
	
							{
	
								var img ='<img src="'+ajax_order_object.pluginurl+'/assets/uploads/reclavilt-favicon.png" style="width:80px">';
	
								if(obj[i].company_logo!='')
	
								{
	
									var img = '<img src="'+ajax_order_object.pluginurl+'/assets/uploads/' + obj[i].company_logo + '" style="width:80px">';
	
								}
	
								var pdf_url=ajax_order_object.pluginurl+"/companypdf.php?ID="+obj[i].company_id_bm;
	
								infowindow.setContent(obj[i].company_name +"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+img + "<br/>Maandelijkse bezoekers: "+ obj[i].company_monthly_visitors+ "<br/>Maandtarief vanaf: <strong> € "+ obj[i].price_per_month+"</strong><br/><a href=" + pdf_url + " target=_blank>Klik hier voor de Specificaties<a>");
	
								infowindow.open(map, marker);
	
							}
	
						})(marker, i));
	
					}
	
				}
	
			});
	
		});
	
	
	
	
	
		$("#next_list").click(function() {
	
			$("#1st_form").hide();
	
			$("#2nd_form").show();
	
			$("#list_cafe").hide();
	
			$("#form").hide();
	
			$('.managebleCheckbox').prop('checked', true);
	
				$.ajax({
	
					type: "POST",
	
					url: ajax_order_object.ajaxurl,
	
					data: {
	
						action: 'mapfilterall',
	
						selected_city_name: $("#city").val()
	
					},
	
					success: function(data) {
	
						var obj = JSON.parse(data);
	
				//console.log(obj);
	
						var visitorCost = 0;
	
						var priceMonth = 0;
	
						var deriv_6 = $("#deriv_6").val();
	
						var deriv_9 = $("#deriv_9").val();
	
						var deriv_12 = $("#deriv_12").val();
	
				var avgCLatValMap='';
	
				var avgSLatValMap='';
	
						var dataTable = "<table><tr><td>Wel/niet</td><td>Naam</td><td>Gasten/maand</td><td></td><td>Prijs/maand(Euro)</td></tr>";
	
		
	
						/********************************************************/
	
						for (i = 0; i < obj.length; i++) {
	
							console.log("test"+i);
	
							console.log(obj[i].company_name);
	
							if(obj[i].available == '1'){ 
	
								dataTable=dataTable+"<tr><td>"+"<input type='hidden' id='hid_price_"+i+"' value='"+obj[i].price_per_month+"'><input type='hidden' id='hid_visitors_"+i+"' value='"+obj[i].company_monthly_visitors+"'><label class='checkBoxContainer'><input type='checkbox' checked name='selectedCafe' class='selectedCafe' id='cafe_"+i+"' value='"+i+"' cafe_name='"+obj[i].company_name+"' visitor='"+obj[i].company_monthly_visitors+"' price='"+obj[i].price_per_month+"' /><span class='checkmark'></span></label>"+"</td><td>"+obj[i].company_name+"</td><td id='td_visitor_"+i+"'>"+obj[i].company_monthly_visitors+"</td><td></td> <td id='td_price_"+i+"'>"+obj[i].price_per_month+"</td></tr>";
	
								visitorCost = parseFloat(visitorCost) + parseFloat(obj[i].company_monthly_visitors);
	
								priceMonth = parseFloat(priceMonth) + parseFloat(obj[i].price_per_month);
	
							}
	
						}
	
		
	
						dataTable = dataTable + "<tr><td>" + " " + "</td><td>Geschat maandelijks bereik horecagasten</td><td><div id='visitId'>" + visitorCost + "</div></td><td></td><td></td></tr>";
	
						dataTable = dataTable + "<tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr>";
	
						dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 3 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='3' name='period' class='period' checked><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_3'>" + Math.round(priceMonth) + "</span>108</td></tr>";
	
						
	
						//var price6=parseFloat(priceMonth) * parseFloat(deriv_6);
	
						var price6=Math.round(parseFloat(priceMonth) * parseFloat(deriv_6)*100)/100;
	
						dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 6 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='6'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_6'>" + Math.round(price6) + "</span>109</td></tr>";
	
						
	
						//var price9=parseFloat(priceMonth) * parseFloat(deriv_9);
	
						var price9=Math.round(parseFloat(priceMonth) * parseFloat(deriv_9)*100)/100;
	
						console.log("c"+price9);
	
						dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 9 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='9'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_9'>" + Math.round(price9) + "</span>110</td></tr>";
	
						
	
						//var price12=parseFloat(priceMonth) * parseFloat(deriv_12);
	
						var price12=Math.round(parseFloat(priceMonth) * parseFloat(deriv_12)*100)/100;
	
						dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 12 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='12'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_12'>" +  Math.round(price12)+ "</span>111</td></tr>";
	
						var dataTable = dataTable + "<table>";
	
						var dataTable = dataTable + "<table>";
	
		
	
						$("#listData").html(dataTable);
	
		
	
						/********************************************************/
	
		
	
						var avgCLatValMap = $('#avgCLat').val();
	
						var avgCLonValMap = $('#avgCLon').val();
	
						
	
						var avgSLatValMap = $('#avgSLat').val();
	
						var avgSLonValMap = $('#avgSLon').val();
	
						
	
						var avgCnLatValMap = 52.370216;
	
						var avgCnLonValMap = 4.895168;
	
						
	
						if(avgCLatValMap.length>0) {
	
							var avgAllLatValMap = avgCLatValMap;
	
							var avgAllLonValMap = avgCLonValMap;
	
							var zoomVal = 10;
	
						}
	
						else if(avgSLatValMap.length>0) {
	
							var avgAllLatValMap = avgSLatValMap;
	
							var avgAllLonValMap = avgSLonValMap;
	
							var zoomVal = 8;
	
						}
	
						else {
	
							var avgAllLatValMap = avgCnLatValMap;
	
							var avgAllLonValMap = avgCnLonValMap;
	
							var zoomVal = 7;
	
						}
	
						
	
						
	
						//console.log($('#avgCLat').val());
	
						//console.log(avgCLatValMap.length);
	
						
	
						//console.log(avgAllLatValMap);
	
						//console.log(avgAllLonValMap);
	
		
	
						var map = new google.maps.Map(document.getElementById('map'), {
	
		
	
							zoom: gbZoom,
	
		
	
							//center: new google.maps.LatLng(52.370216,4.895168),
	
								
	
							center: gbCenter,				
	
							mapTypeId: google.maps.MapTypeId.ROADMAP
	
		
	
						});
	
						
	
						google.maps.event.addListener(map, 'zoom_changed', function () {
	
							gbZoom = map.getZoom();		
	
						});
	
						 
	
						google.maps.event.addListener(map, 'center_changed', function () {
	
							gbCenter = map.getCenter();			
	
						});
	
		
	
						var infowindow = new google.maps.InfoWindow();
	
		
	
						var marker, i, flag,company_logo_available;
	
		
	
						//console.log(obj.length);
	
		
	
						for (i = 0; i < obj.length; i++) 
	
						{
	
							if (obj[i].available == "1") 
	
							{
	
															flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-green.png";
	
							} 
	
							else 
	
							{
	
								flag = "http://icons.iconarchive.com/icons/paomedia/small-n-flat/48/map-marker-icon.png";
	
							   flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-red.png";
	
							}
	
		
	
							marker = new google.maps.Marker({
	
								position: new google.maps.LatLng(obj[i].company_lat, obj[i].company_lon),
	
								animation: google.maps.Animation.DROP,
	
								icon: flag,
	
								map: map
	
							});
	
		
	
							google.maps.event.addListener(marker, 'mouseover', (function(marker, i) 
	
							{
	
								return function() 
	
								{
	
									var img ='<img src="'+ajax_order_object.pluginurl+'/assets/uploads/reclavilt-favicon.png" style="width:80px">';
	
									if(obj[i].company_logo!='')
	
									{
	
										var img = '<img src="'+ajax_order_object.pluginurl+'/assets/uploads/' + obj[i].company_logo + '" style="width:80px">';
	
									}
	
									var pdf_url=ajax_order_object.pluginurl+"/companypdf.php?ID="+obj[i].company_id_bm;
	
									infowindow.setContent(obj[i].company_name +"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+img + "<br/>Maandelijkse bezoekers: "+ obj[i].company_monthly_visitors+ "<br/>Maandtarief vanaf: <strong> € "+ obj[i].price_per_month+"</strong><br/><a href=" + pdf_url + " target=_blank>Klik hier voor de Specificaties<a>");
	
									infowindow.open(map, marker);
	
								}
	
							})(marker, i));
	
						}
	
					}
	
				});
	
			});
	
		
	
		$("select#city").change(function() {
	
			$("#1st_form").hide();
	
			$("#2nd_form").show();
	
			$("#list_cafe").hide();
	
			$("#form").hide();
	
			$('.managebleCheckbox').prop('checked', true);
	
			$.ajax({
	
				type: "POST",
	
				url: ajax_order_object.ajaxurl,
	
				data: {
	
					action: 'mapfilterall',
	
					selected_city_name: $("#city").val()
	
				},
	
				success: function(data) {
	
					var obj = JSON.parse(data);
			
	
					var retLength = obj.length;
	
					console.log(obj[retLength-1]);
	
					if( (obj[retLength-1]['lat'].length === 0) && (obj[retLength-1]['lng'].length === 0) ) {				 	
	
					}
	
					else {
	
						var cityLat = obj[retLength-1]['lat'];
	
						var cityLng = obj[retLength-1]['lng'];
	
						obj.pop(); 					
	
					}
	
						
	
					var visitorCost = 0;
	
					var priceMonth = 0;
	
					var deriv_6 = $("#deriv_6").val();
	
					var deriv_9 = $("#deriv_9").val();
	
					var deriv_12 = $("#deriv_12").val();
	
					var avgCLatValMap='';
	
					var avgSLatValMap='';
	
					var dataTable = "<table><tr><td>Wel/niet</td><td>Naam</td><td>Gasten/maand</td><td></td><td>Prijs/maand(Euro)</td></tr>";
	
	
	
					/********************************************************/
	
					for (i = 0; i < obj.length; i++) {
	
						//$("#listData").html(obj[i].company_name);
	
						console.log("test"+i);
	
						console.log(obj[i].company_name);
	
						if(obj[i].available == '1')
	
						{
	
							dataTable=dataTable+"<tr><td>"+"<input type='hidden' id='hid_price_"+i+"' value='"+obj[i].price_per_month+"'><input type='hidden' id='hid_visitors_"+i+"' value='"+obj[i].company_monthly_visitors+"'><label class='checkBoxContainer'><input type='checkbox' checked name='selectedCafe' class='selectedCafe' id='cafe_"+i+"' value='"+i+"' cafe_name='"+obj[i].company_name+"' visitor='"+obj[i].company_monthly_visitors+"' price='"+obj[i].price_per_month+"' /><span class='checkmark'></span></label>"+"</td><td>"+obj[i].company_name+"</td><td id='td_visitor_"+i+"'>"+obj[i].company_monthly_visitors+"</td><td></td> <td id='td_price_"+i+"'>"+obj[i].price_per_month+"</td></tr>";
	
							visitorCost = parseFloat(visitorCost) + parseFloat(obj[i].company_monthly_visitors);
	
							priceMonth = parseFloat(priceMonth) + parseFloat(obj[i].price_per_month);
	
						}
	
					}
	
	
	
					dataTable = dataTable + "<tr><td>" + " " + "</td><td>Geschat maandelijks bereik horecagasten</td><td><div id='visitId'>" + visitorCost + "</div></td><td></td><td></td></tr>";
	
					dataTable = dataTable + "<tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr>";
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 3 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='3' name='period' class='period' checked><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_3'>" + Math.round(priceMonth) + "</span>108</td></tr>";
	
					
	
					//var price6=parseFloat(priceMonth) * parseFloat(deriv_6);
	
					var price6=Math.round(parseFloat(priceMonth) * parseFloat(deriv_6)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 6 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='6'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_6'>" + Math.round(price6) + "</span>109</td></tr>";
	
					
	
					//var price9=parseFloat(priceMonth) * parseFloat(deriv_9);
	
					var price9=Math.round(parseFloat(priceMonth) * parseFloat(deriv_9)*100)/100;
	
					console.log("c"+price9);
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 9 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='9'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_9'>" + Math.round(price9) + "</span>110</td></tr>";
	
					
	
					//var price12=parseFloat(priceMonth) * parseFloat(deriv_12);
	
					var price12=Math.round(parseFloat(priceMonth) * parseFloat(deriv_12)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 12 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='12'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_12'>" +  Math.round(price12)+ "</span>111</td></tr>";
	
					var dataTable = dataTable + "<table>";
	
					var dataTable = dataTable + "<table>";
	
	
	
					$("#listData").html(dataTable);
	
	
	
					/********************************************************/
	
	
	
					var avgCLatValMap = $('#avgCLat').val();
	
					var avgCLonValMap = $('#avgCLon').val();
	
					
	
					var avgSLatValMap = $('#avgSLat').val();
	
					var avgSLonValMap = $('#avgSLon').val();
	
					
	
					var avgCnLatValMap = 52.370216;
	
					var avgCnLonValMap = 4.895168;
	
					
	
					if(avgCLatValMap.length>0) {
	
						var avgAllLatValMap = avgCLatValMap;
	
						var avgAllLonValMap = avgCLonValMap;
	
						var zoomVal = 10;
	
					}
	
					else if(avgSLatValMap.length>0) {
	
						var avgAllLatValMap = avgSLatValMap;
	
						var avgAllLonValMap = avgSLonValMap;
	
						var zoomVal = 8;
	
					}
	
					else if((cityLat.length>0) && (cityLng.length>0) ) {
	
						var avgAllLatValMap = cityLat;
	
						var avgAllLonValMap = cityLng;
	
						gbCenter = new google.maps.LatLng(cityLat,cityLng);
	
						var gbZoom = 10;					
	
					}
	
					else {
	
						var avgAllLatValMap = avgCnLatValMap;
	
						var avgAllLonValMap = avgCnLonValMap;
	
						var zoomVal = 7;					
	
					}
	
					
	
					
	
	
	
					var map = new google.maps.Map(document.getElementById('map'), {
	
	
	
						zoom: gbZoom,
	
	
	
						//center: new google.maps.LatLng(52.370216,4.895168),
	
							
	
						center: gbCenter,				
	
						mapTypeId: google.maps.MapTypeId.ROADMAP
	
	
	
					});
	
					
	
					google.maps.event.addListener(map, 'zoom_changed', function () {
	
						gbZoom = map.getZoom();		
	
					});
	
					 
	
					google.maps.event.addListener(map, 'center_changed', function () {
	
						gbCenter = map.getCenter();			
	
					});
	
	
	
					var infowindow = new google.maps.InfoWindow();
	
	
	
					var marker, i, flag,company_logo_available;
	
	
	
					//console.log(obj.length);
	
	
	
					for (i = 0; i < obj.length; i++){
	
						if (obj[i].available == "1"){
	
							
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-green.png";
	
						} 
	
						else 
	
						{
	
							flag = "http://icons.iconarchive.com/icons/paomedia/small-n-flat/48/map-marker-icon.png";
	
													flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-red.png";
	
						}
	
	
	
						marker = new google.maps.Marker({
	
							position: new google.maps.LatLng(obj[i].company_lat, obj[i].company_lon),
	
							animation: google.maps.Animation.DROP,
	
							icon: flag,
	
							map: map
	
						});
	
	
	
						google.maps.event.addListener(marker, 'mouseover', (function(marker, i) 
	
						{
	
							return function() 
	
							{
	
								var img ='<img src="'+ajax_order_object.pluginurl+'/assets/uploads/reclavilt-favicon.png" style="width:80px">';
	
								if(obj[i].company_logo!='')
	
								{
	
									var img = '<img src="'+ajax_order_object.pluginurl+'/assets/uploads/' + obj[i].company_logo + '" style="width:80px">';
	
								}
	
								var pdf_url=ajax_order_object.pluginurl+"/companypdf.php?ID="+obj[i].company_id_bm;
	
								infowindow.setContent(obj[i].company_name +"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+img + "<br/>Maandelijkse bezoekers: "+ obj[i].company_monthly_visitors+ "<br/>Maandtarief vanaf: <strong> € "+ obj[i].price_per_month+"</strong><br/><a href=" + pdf_url + " target=_blank>Klik hier voor de Specificaties<a>");
	
								infowindow.open(map, marker);
	
							}
	
						})(marker, i));
	
					}
	
				}
	
			});
	
		});
	
		
	
	
	
		$("select#state").change(function() {
	
			$("#1st_form").hide();
	
			$("#2nd_form").show();
	
			$("#list_cafe").hide();
	
			$("#form").hide();
	
			$('.managebleCheckbox').prop('checked', true);
	
			
	
			$.ajax({
	
				type: "POST",
	
				url: ajax_order_object.ajaxurl,
	
				data: {
	
					action: 'mapfilterall',
	
					selected_state_name: $("#state").val()
	
				},
	
	
	
				success: function(data) {
	
					//$("#city").val("");
	
					//$("#state").val("");
	
					
	
					var obj = JSON.parse(data);
	
					
	
					//console.log(obj);
	
					var retLength = obj.length;				
	
					if( (obj[retLength-1]['lat'].length === 0) && (obj[retLength-1]['lng'].length === 0) ) {				 	
	
					}
	
					else {
	
						var stateLat = obj[retLength-1]['lat'];
	
						var stateLng = obj[retLength-1]['lng'];
	
						obj.pop(); 					
	
					}
	
					
	
					var visitorCost = 0;
	
					var priceMonth = 0;
	
					var deriv_6 = $("#deriv_6").val();
	
					var deriv_9 = $("#deriv_9").val();
	
					var deriv_12 = $("#deriv_12").val();
	
					var avgCLatValMap='';
	
					var avgSLatValMap='';
	
	
	
					var dataTable = "<table><tr><td>Wel/niet<td><td>Naam</td><td>Gasten/maand</td><td></td><td>Prijs/maand(Euro)</td></tr>";
	
	
	
					/********************************************************/
	
					//console.log(obj.length);
	
					for (i = 0; i < obj.length; i++) {
	
	
	
						if(obj[i].available == '1')
	
						{
	
							dataTable=dataTable+"<tr><td>"+"<input type='hidden' id='hid_price_"+i+"' value='"+obj[i].price_per_month+"'><input type='hidden' id='hid_visitors_"+i+"' value='"+obj[i].company_monthly_visitors+"'><label class='checkBoxContainer'><input type='checkbox' checked name='selectedCafe' class='selectedCafe' id='cafe_"+i+"' value='"+i+"' cafe_name='"+obj[i].company_name+"' visitor='"+obj[i].company_monthly_visitors+"' price='"+obj[i].price_per_month+"' /><span class='checkmark'></span></label>"+"</td><td>"+obj[i].company_name+"</td><td id='td_visitor_"+i+"'>"+obj[i].company_monthly_visitors+"</td><td></td> <td id='td_price_"+i+"'>"+obj[i].price_per_month+"</td></tr>";
	
	
	
							visitorCost = parseFloat(visitorCost) + parseFloat(obj[i].company_monthly_visitors);
	
	
	
							priceMonth = parseFloat(priceMonth) + parseFloat(obj[i].price_per_month);
	
						}
	
	
	
					}
	
	
	
					dataTable = dataTable + "<tr><td>" + " " + "</td><td>Geschat maandelijks bereik horecagasten</td><td><div id='visitId'>" + visitorCost + "</div></td><td></td><td></td></tr>";
	
	
	
					dataTable = dataTable + "<tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr>";
	
	
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 3 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='3' name='period' class='period' checked><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_3'>" + Math.round(priceMonth) + "</span>112</td></tr>";
	
					
	
					//var price6=parseFloat(priceMonth) * parseFloat(deriv_6);
	
					var price6=Math.round(parseFloat(priceMonth) * parseFloat(deriv_6)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 6 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='6'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_6'>" + Math.round(price6) + "</span>113</td></tr>";
	
					
	
					//var price9=parseFloat(priceMonth) * parseFloat(deriv_9);
	
					var price9=Math.round(parseFloat(priceMonth) * parseFloat(deriv_9)*100)/100;
	
					console.log("d"+price9);
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 9 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='9'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_9'>" + Math.round(price9) + "</span>114</td></tr>";
	
					
	
					//var price12=parseFloat(priceMonth) * parseFloat(deriv_12);
	
					var price12=Math.round(parseFloat(priceMonth) * parseFloat(deriv_12)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 12 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='12'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_12'>" +  Math.round(price12)+ "</span>115</td></tr>";
	
					var dataTable = dataTable + "<table>";
	
					var dataTable = dataTable + "<table>";
	
	
	
					$("#listData").html(dataTable);
	
	
	
					/********************************************************/
	
	
	
					var avgCLatValMap = $('#avgCLat').val();
	
					var avgCLonValMap = $('#avgCLon').val();
	
					
	
					var avgSLatValMap = $('#avgSLat').val();
	
					var avgSLonValMap = $('#avgSLon').val();
	
					
	
					var avgCnLatValMap = 52.370216;
	
					var avgCnLonValMap = 4.895168;
	
					
	
					if(avgCLatValMap.length>0) {
	
						var avgAllLatValMap = avgCLatValMap;
	
						var avgAllLonValMap = avgCLonValMap;
	
						var zoomVal = 10;
	
					}
	
					else if(avgSLatValMap.length>0) {
	
						var avgAllLatValMap = avgSLatValMap;
	
						var avgAllLonValMap = avgSLonValMap;
	
						var zoomVal = 8;
	
					}
	
					else if((stateLat.length>0) && (stateLng.length>0) ) {
	
						var avgAllLatValMap = stateLat;
	
						var avgAllLonValMap = stateLng;
	
						gbCenter = new google.maps.LatLng(stateLng,stateLat);
	
						var gbZoom = 10;
	
					}
	
					else {
	
						var avgAllLatValMap = avgCnLatValMap;
	
						var avgAllLonValMap = avgCnLonValMap;
	
						var zoomVal = 7;					
	
					}
	
					
	
					console.log(avgAllLatValMap);
	
					
	
					//console.log($('#avgCLat').val());
	
					//console.log(avgCLatValMap.length);
	
					
	
					//console.log(avgAllLatValMap);
	
					//console.log(avgAllLonValMap);
	
	
	
					var map = new google.maps.Map(document.getElementById('map'), {
	
	
	
						zoom: gbZoom,
	
	
	
						//center: new google.maps.LatLng(52.370216,4.895168),
	
							
	
						center: gbCenter,				
	
						mapTypeId: google.maps.MapTypeId.ROADMAP
	
	
	
					});
	
					
	
					google.maps.event.addListener(map, 'zoom_changed', function () {
	
						gbZoom = map.getZoom();			
	
					});
	
					 
	
					google.maps.event.addListener(map, 'center_changed', function () {
	
						gbCenter = map.getCenter();				
	
					});
	
	
	
					var infowindow = new google.maps.InfoWindow();
	
	
	
					var marker, i, flag;
	
	
	
					//console.log(obj.length);
	
	
	
					for (i = 0; i < obj.length; i++) {
	
						//console.log(obj[i].company_lat);
	
						//console.log(obj[i].company_lon);
	
	
	
						if (obj[i].available == "1") {
	
	
	
							//flag = "http://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Marker-Outside-Chartreuse-icon.png";
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-green.png";
	
	
	
						} else {
	
	
	
							flag = "http://icons.iconarchive.com/icons/paomedia/small-n-flat/48/map-marker-icon.png";
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-red.png";
	
	
	
						}
	
	
	
						marker = new google.maps.Marker({
	
							position: new google.maps.LatLng(obj[i].company_lat, obj[i].company_lon),
	
							animation: google.maps.Animation.DROP,
	
							icon: flag,
	
							map: map
	
						});
	
	
	
						google.maps.event.addListener(marker, 'mouseover', (function(marker, i) 
	
						{
	
							return function() 
	
							{
	
								var img ='<img src="'+ajax_order_object.pluginurl+'/assets/uploads/reclavilt-favicon.png" style="width:80px">';
	
								if(obj[i].company_logo!='')
	
								{
	
									var img = '<img src="'+ajax_order_object.pluginurl+'/assets/uploads/' + obj[i].company_logo + '" style="width:80px">';
	
								}
	
								var pdf_url=ajax_order_object.pluginurl+"/companypdf.php?ID="+obj[i].company_id_bm;
	
								infowindow.setContent(obj[i].company_name +"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+img + "<br/>Maandelijkse bezoekers: "+ obj[i].company_monthly_visitors+ "<br/>Maandtarief vanaf: <strong> € "+ obj[i].price_per_month+"</strong><br/><a href=" + pdf_url + " target=_blank>Klik hier voor de Specificaties<a>");
	
								infowindow.open(map, marker);
	
							}
	
						})(marker, i));
	
					}
	
				}
	
			});
	
		});
	
		
	
		$("#showCountryMap").click(function() {
	
			$("#1st_form").hide();
	
			$("#2nd_form").show();
	
			$("#list_cafe").hide();
	
			$("#form").hide();
	
		$('.managebleCheckbox').prop('checked', true);
	
			$.ajax({
	
				type: "POST",
	
				url: ajax_order_object.ajaxurl,
	
				data: {
	
					action: 'mapfilterall',
	
					selected_city_name: $("#cval").text(),
	
					selected_state_name: $("#sval").text()
	
					//selected_country_name: $("#countryVal").val()
	
				},
	
	
	
				success: function(data) {
	
	
	
					var obj = JSON.parse(data);
	
					//console.log(obj);
	
					var visitorCost = 0;
	
					var priceMonth = 0;
	
					var deriv_6 = $("#deriv_6").val();
	
					var deriv_9 = $("#deriv_9").val();
	
					var deriv_12 = $("#deriv_12").val();
	
			var avgCLatValMap='';
	
			var avgSLatValMap='';
	
					var dataTable = "<table><tr><td>Wel/niet</td><td>Naam</td><td>Gasten/maand</td><td></td><td>Prijs/maand(Euro)</td></tr>";
	
	
	
					/********************************************************/
	
					//console.log(obj.length);
	
					for (i = 0; i < obj.length; i++) 
	
					{
	
						if(obj[i].available == '1') {
	
							dataTable=dataTable+"<tr><td>"+"<input type='hidden' id='hid_price_"+i+"' value='"+obj[i].price_per_month+"'><input type='hidden' id='hid_visitors_"+i+"' value='"+obj[i].company_monthly_visitors+"'><label class='checkBoxContainer'><input type='checkbox' checked name='selectedCafe' class='selectedCafe' id='cafe_"+i+"' value='"+i+"' cafe_name='"+obj[i].company_name+"' visitor='"+obj[i].company_monthly_visitors+"' price='"+obj[i].price_per_month+"' /><span class='checkmark'></span></label>"+"</td><td>"+obj[i].company_name+"</td><td id='td_visitor_"+i+"'>"+obj[i].company_monthly_visitors+"</td><td></td> <td id='td_price_"+i+"'>"+obj[i].price_per_month+"</td></tr>";
	
							visitorCost = parseFloat(visitorCost) + parseFloat(obj[i].company_monthly_visitors);
	
							priceMonth = parseFloat(priceMonth) + parseFloat(obj[i].price_per_month);
	
						}
	
	
	
					}
	
	
	
					dataTable = dataTable + "<tr><td>" + " " + "</td><td>Geschat maandelijks bereik horecagasten</td><td><div id='visitId'>" + visitorCost + "</div></td><td></td><td></td></tr>";
	
	
	
					dataTable = dataTable + "<tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr>";
	
	
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 3 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='3' name='period' class='period' checked><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_3'>" + Math.round(priceMonth) + "</span>116</td></tr>";
	
					
	
					//var price6=parseFloat(priceMonth) * parseFloat(deriv_6);
	
					var price6=Math.round(parseFloat(priceMonth) * parseFloat(deriv_6)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 6 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='6'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_6'>" + Math.round(price6) + "</span>117</td></tr>";
	
	
	
					//var price9=parseFloat(priceMonth) * parseFloat(deriv_9);
	
					var price9=Math.round(parseFloat(priceMonth) * parseFloat(deriv_9)*100)/100;
	
					console.log("e"+price9);
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 9 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='9'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_9'>" + Math.round(price9) + "</span>118</td></tr>";
	
	
	
					//var price12=parseFloat(priceMonth) * parseFloat(deriv_12);
	
					var price12=Math.round(parseFloat(priceMonth) * parseFloat(deriv_12)*100)/100;
	
					dataTable = dataTable + "<tr><td></td><td colspan='2'>Total price based on 12 months period reservation</td><td><label class='radioBoxContainer'><input type='radio' pmo='" + priceMonth + "' value='12'  class='period' name='period'><span class='radiomark'></span></label></td><td></td><td>€ <span id='priceId_12'>" +  Math.round(price12)+ "</span>119</td></tr>";
	
	 
	
					var dataTable = dataTable + "<table>";
	
					var dataTable = dataTable + "<table>";
	
	
	
					$("#listData").html(dataTable);
	
	
	
					/********************************************************/
	
	
	
				   
	
					
	
					/* avgCnLatValMap = 52.370216;
	
					avgCnLonValMap = 4.895168;
	
					
	
					avgAllLatValMap = avgCnLatValMap;
	
					avgAllLonValMap = avgCnLonValMap;
	
					zoomVal = 7; */
	
					
	
					var avgCLatValMap = $('#avgCLat').val();
	
					var avgCLonValMap = $('#avgCLon').val();
	
									
	
					var avgSLatValMap = $('#avgSLat').val();
	
					var avgSLonValMap = $('#avgSLon').val();
	
					
	
					var avgCnLatValMap = 52.370216;
	
					var avgCnLonValMap = 4.895168;
	
					
	
					if(avgCLatValMap.length>0) {
	
						var avgAllLatValMap = avgCLatValMap;
	
						var avgAllLonValMap = avgCLonValMap;
	
						var zoomVal = 10;
	
					}
	
					if(avgSLatValMap.length>0) {
	
						var avgAllLatValMap = avgSLatValMap;
	
						var avgAllLonValMap = avgSLonValMap;
	
						var zoomVal = 8;
	
					}
	
					else {
	
						var avgAllLatValMap = avgCnLatValMap;
	
						var avgAllLonValMap = avgCnLonValMap;
	
						var zoomVal = 7;
	
					}
	
	
	
					var map = new google.maps.Map(document.getElementById('map'), {
	
	
	
						zoom: gbZoom,
	
	
	
						//center: new google.maps.LatLng(52.370216,4.895168),
	
							
	
						center: gbCenter,				
	
						mapTypeId: google.maps.MapTypeId.ROADMAP
	
	
	
					});
	
					
	
					google.maps.event.addListener(map, 'zoom_changed', function () {
	
						gbZoom = map.getZoom();			
	
					});
	
					 
	
					google.maps.event.addListener(map, 'center_changed', function () {
	
						gbCenter = map.getCenter();			
	
					});
	
	
	
	
	
					var infowindow = new google.maps.InfoWindow();
	
	
	
					var marker, i, flag;
	
	
	
					//console.log(obj.length);
	
	
	
					for (i = 0; i < obj.length; i++) {
	
						//console.log(obj[i].company_lat);
	
						//console.log(obj[i].company_lon);
	
	
	
						if (obj[i].available == "1") {
	
	
	
							//flag ="http://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Marker-Outside-Chartreuse-icon.png";
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-green.png";
	
	
	
						} else {
	
	
	
							flag = "http://icons.iconarchive.com/icons/paomedia/small-n-flat/48/map-marker-icon.png";
	
							flag = ajax_order_object.pluginurl+"/assets/uploads/pin-head-red.png";
	
	
	
						}
	
	
	
						marker = new google.maps.Marker({
	
							position: new google.maps.LatLng(obj[i].company_lat, obj[i].company_lon),
	
							animation: google.maps.Animation.DROP,
	
							icon: flag,
	
							map: map
	
						});
	
	
	
						google.maps.event.addListener(marker, 'mouseover', (function(marker, i) 
	
						{
	
							return function() 
	
							{
	
								var img ='<img src="'+ajax_order_object.pluginurl+'/assets/uploads/reclavilt-favicon.png" style="width:80px">';
	
								if(obj[i].company_logo!='')
	
								{
	
									var img = '<img src="'+ajax_order_object.pluginurl+'/assets/uploads/' + obj[i].company_logo + '" style="width:80px">';
	
								}
	
								var pdf_url=ajax_order_object.pluginurl+"/companypdf.php?ID="+obj[i].company_id_bm;
	
								infowindow.setContent(obj[i].company_name +"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+img + "<br/>Maandelijkse bezoekers: "+ obj[i].company_monthly_visitors+ "<br/>Maandtarief vanaf: <strong> € "+ obj[i].price_per_month+"</strong><br/><a href=" + pdf_url + " target=_blank>Klik hier voor de Specificaties<a>");
	
								infowindow.open(map, marker);
	
							}
	
						})(marker, i));
	
					}
	
				}
	
			});
	
		});
	
	
	
		$("#next_tab_list").click(function(){
	
			$("#filter").hide();
	
			$("#list_cafe").hide();
	
			$("#list_cafe").show();
	
		});
	
	
	
		$("#back_tab_list").click(function() 
	
		{
	
			$("#2nd_form").hide();
	
			$("#list_cafe").hide();
	
			$("#1st_form").show();
	
			$("#cvalShow").html('');
	
		$("#cval").html('');
	
			$("#suggesstion-box-city").html('');
	
			$("#city").val('');
	
		$("#svalShow").html('');
	
		$("#sval").html('');
	
			$("#suggesstion-box-state").html('');
	
			$("#state").val('');
	
		});
	
	
	
		$("#back_tab_filter").click(function()    {
	
			$("#filter").show();
	
			$("#list_cafe").hide();
	
			$("#form").hide();
	
		});
	
	
	
		$("#next_form").click(function(){
	
			$("#filter").hide();
	
			$("#list_cafe").hide();
	
			$("#form").show();
	
		});
	
	
	
		$("#back_list_cafe").click(function(){
	
			$("#filter").hide();
	
			$("#list_cafe").show();
	
			$("#form").hide();
	
		});
	
	
		$(".typeCity").keyup(function(){	 
	
			if ($(".typeCity").val().length > 2){
	
				$.ajax({
	
					type: "POST",
	
					url: ajax_order_object.ajaxurl,
	
					data:{
	
						action: 'getcity',
						keyword: $(".typeCity").val()
					},
	
	
	
					success: function(data){
	
						$("#suggesstion-box-city").html(data);
	
						$("#getTempValCityShow").html($("#cvalShow").html());
	
						$("#getTempValCity").html($("#cval").html());
	
					}
				});
			}   
	
		});
	
	
	
		$(document).on('click', '.selectCity', function(){
	
			var cityData = "";
	
			var cityDataShow = "";
	
			var getTempVal = "";
	
			var latCData = "";
	
			var longCData = "";
	
			var cSelectCount = 0;
	
		$("#sval").html("");
	
			$('input[name="citylist"]:checked').each(function() {
	
	
	
			if (cityData != ""){
	
				cityDataShow = cityDataShow + "<span>" + this.value + "</span>";
	
				cityData = cityData + ",'" + this.value + "'";
	
			} 
	
			else {
	
				cityDataShow = "<span>" + this.value + "</span>";
	
				cityData = "'" + this.value + "'";
	
			}
	
			var geocoder = new google.maps.Geocoder();
	
			var address = this.value;
	
			geocoder.geocode({
	
				'address': address
	
			}, function(results, status) {
	
					if (status == google.maps.GeocoderStatus.OK) {
	
						var latitude = results[0].geometry.location.lat();
	
						var longitude = results[0].geometry.location.lng();
	
						if (latCData != "") {
	
							latCData = latCData + "," + latitude;
	
						}
						else {
	
							latCData = latitude;
						}
	
						var arrLat = latCData.toString().split(",");
	
						cMaxLat = Math.max.apply(Math, arrLat);
	
						cMinLat = Math.min.apply(Math, arrLat);
	
						if (longCData != ""){
	
							longCData = longCData + "," + longitude;
						} 
						else {
	
							longCData = longitude;
	
						}
	
						var arrLon = longCData.toString().split(",");
	
						cMaxLon = Math.max.apply(Math, arrLon);
	
						cMinLon = Math.min.apply(Math, arrLon);
	
						avgCLatVal = (cMaxLat + cMinLat) / 2;
	
						avgCLonVal = (cMaxLon + cMinLon) / 2;
	
						if (avgCLatVal != '' && avgCLonVal != '') 
	
						{
	
							avgCLat = avgCLatVal;
	
							avgCLon = avgCLonVal;
	
						} 
	
						else
	
						{
	
							avgCLat = 52.370216;
	
							avgCLon = 4.895168;
	
						}
	
						$("#avgCLat").val(avgCLat);
	
						$("#avgCLon").val(avgCLon);
	
					}
	
				});
	
				cSelectCount++;
	
			});
	
	
	
	
	
			var cPreData = $("#getTempValCity").html();
	
			var cPreDataShow = $("#getTempValCityShow").html();
	
			if (cPreData != '') {
	
				cityData = cPreData + "," + cityData;
	
				cityDataShow = cPreDataShow + cityDataShow;
	
				$("#cval").html(' ');
	
				$("#cvalShow").html(' ');
	
			}
	
			$("#cvalShow").html(cityDataShow);
	
			$("#cval").html(cityData);
	
	
	
	
	
		});
	
	
	
		$(".typeState").keyup(function() {
	
			if ($(".typeState").val().length > 2) {
	
				$.ajax({
	
					type: "POST",
	
					url: ajax_order_object.ajaxurl,
	
					data: {
	
						action: 'getstate',
	
						keyword: $(".typeState").val()
	
					},
	
	
	
					success: function(data) {
	
						$("#suggesstion-box-state").html(data);
	
						$("#getTempValStateShow").html($("#svalShow").html());
	
						$("#getTempValState").html($("#sval").html());
	
					}
	
				});
	
			}
	
		});
	
	
	
		$(document).on('click', '.selectState', function() {
	
			var stateData = "";
	
			var stateDataShow = "";
	
			var getSateTempVal = "";
	
			var latSData = "";
	
			var longSData = "";
	
			var sSelectCount = 0;
	
			$("#cval").html("");
	
			$('input[name="statelist"]:checked').each(function() {
	
				if (stateData != "") {
	
					stateDataShow = stateDataShow + "<span>" + this.value + "</span>";
	
					stateData = stateData + ",'" + this.value + "'";
	
				} else {
	
					stateDataShow = "<span>" + this.value + "</span>";
	
					stateData = "'" + this.value + "'";
	
				}
	
	
	
				var geocoder = new google.maps.Geocoder();
	
				var address = this.value;
	
				geocoder.geocode({
	
					'address': address
	
				}, function(results, status) {
	
					if (status === google.maps.GeocoderStatus.OK) {
	
						var latitude = results[0].geometry.location.lat();
	
						var longitude = results[0].geometry.location.lng();
	
						if (latSData !== "") {
	
							latSData = latSData + "," + latitude;
	
						} else {
	
							latSData = latitude;
	
						}
	
						var arrLat = latSData.toString().split(",");
	
						sMaxLat = Math.max.apply(Math, arrLat);
	
						sMinLat = Math.min.apply(Math, arrLat);
	
						if (longSData !== "") {
	
							longSData = longSData + "," + longitude;
	
						} else {
	
							longSData = longitude;
	
						}
	
						var arrLon = longSData.toString().split(",");
	
						sMaxLon = Math.max.apply(Math, arrLon);
	
						sMinLon = Math.min.apply(Math, arrLon);
	
						avgSLatVal = (sMaxLat + sMinLat) / 2;
	
						avgSLonVal = (sMaxLon + sMinLon) / 2;
	
						if (avgSLatVal.length>0 && avgSLonVal.length>0) 
	
						{
	
							avgSLat = avgSLatVal;
	
							avgSLon = avgSLonVal;
	
						}
	
						else
	
						{
	
							avgSLat = 52.370216;
	
							avgSLon = 4.895168;
	
						}
	
						$("#avgSLat").val(avgSLat);
	
						$("#avgSLon").val(avgSLon);
	
					}
	
				});
	
	
	
				sSelectCount++;
	
	
	
			});
	
	
	
			var sPreData = $("#getTempValState").html();
	
			var sPreDataShow = $("#getTempValStateShow").html();
	
			if (sPreData !== '') {
	
				stateData = sPreData + "," + stateData;
	
				stateDataShow = sPreDataShow + stateDataShow;
	
	
	
				$("#sval").html(' ');
	
	
	
				$("#svalShow").html(' ');
	
	
	
			}
	
	
	
			$("#svalShow").html(stateDataShow);
	
	
	
			$("#sval").html(stateData);
	
	
	
		});
	
	
	
		$(document).on('click', '.selectedCafe', function() {
	
	
	
			var visitor = 0;
	
			var price = 0;
	
			var deriv_6 = $("#deriv_6").val();
	
			var deriv_9 = $("#deriv_9").val();
	
			var deriv_12 = $("#deriv_12").val();
	
			
	
			var checkPoint=$(this).attr('value');
	
			//console.log( $(this).attr('value'));
	
			if($('#cafe_'+checkPoint).is(':checked'))
	
			{
	
					$('#td_visitor_'+checkPoint).html($('#hid_visitors_'+checkPoint).val());
	
					$('#td_price_'+checkPoint).html($('#hid_price_'+checkPoint).val());
	
					//console.log("check");
	
					//console.log($('#hid_visitors_'+checkPoint).val());
	
			}
	
			else
	
			{
	
					$('#td_visitor_'+checkPoint).html(0);
	
					$('#td_price_'+checkPoint).html(0);
	
			}
	
	
	
			$('input[name="selectedCafe"]:checked').each(function() {
	
				visitor = parseFloat(visitor) + parseFloat($(this).attr("visitor"));
	
				price = parseFloat(price) + parseFloat($(this).attr("price"));
	
				
	
			});
	
	
	
			$("#visitId").html("<strong>"+visitor+"</strong>");
	
			$("#priceId_3").html("<strong>"+price+"</strong>");
	
			$("#priceId_6").html("<strong>"+Math.round(parseFloat(price)*parseFloat(deriv_6))+"</strong>");
	
			$("#priceId_9").html("<strong>"+Math.round(parseFloat(price)*parseFloat(deriv_9))+"</strong>");
	
			$("#priceId_12").html("<strong>"+Math.round(parseFloat(price)*parseFloat(deriv_12))+"</strong>");	
	
		});
	
	
		jQuery("#mapFormSubmit").on("submit", function(event){
	
			event.preventDefault();			
	
			var cityData = $("#cval").html().replace(/'/g, '');
	
			var stateData = $("#sval").html().replace(/'/g, '');
	
			var countryData = $("#countryVal").val().replace(/'/g, '');
	
			var selValue = $("input[name='period']:checked").val();
	
			var visitor = 0;
	
			var price = 0;
	
			var i = 0;
	
			var cafe_name = "";
	
			var period_reservation = selValue;
	
			var period_reservation_cost = $("#priceId_" + selValue).html();
	
			var arr = [];
	
			var x = 0;
	
			$('input[name="selectedCafe"]:checked').each(function() {
	
				var data = {};
	
				visitor = parseFloat(visitor) + parseFloat($(this).attr("visitor"));
	
				price = parseFloat(price) + parseFloat($(this).attr("price"));
	
				cafe_name = $(this).attr("cafe_name");
	
				data.visitor = visitor;
	
				data.price = price;
	
				data.cafe_name = cafe_name;
	
				arr.push(data);
	
				x++;
	
			});
	
			$.ajax({	
	
				data: {
	
					action: 'advertiseSubmit',
	
					company_name: $("#company_name").val(),
	
					contact_person: $("#contact_person").val(),
	
					contact_email: $("#contact_email").val(),
	
					contact_phone: $("#contact_phone").val(),
	
					period_reservation: period_reservation,
	
					period_reservation_cost: period_reservation_cost,
	
					selectedCafe: arr
	
				},
	
				type: 'POST',
	
				url: ajax_order_object.ajaxurl,
	
				success: function(data) {
					
					console.log(data);
					
					$("#2nd_form").hide();
	
					$("#1st_form").show();
	
					//window.location = ajax_order_object.thankyoupage;
	
					$("#success_message").html('<h1><span style="color: #0000ff;">Bedankt voor uw aanvraag, binnen 24 uur nemen we contact op ter verificatie!</span></h1>');
	
				}
	
	
	
			});
	
	
	
		});
	
	}
	
});