<?php

get_header();



global $wpdb;

$pageSuccess = "";
$settings = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."aa_settings");

?>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATwmJTGbgCoJ99DWOnrnR8yenz1tTOFIk&libraries=places&callback=initAutocomplete"></script> -->
<?php

if(isset($_POST['submit'])){

	global $wpdb;

	$cpName = explode(',',$_POST['company_name']);

	

	$company_contact_person_name=$_POST['company_contact_person_name'];

	$company_zip=$_POST['company_zip'];

	$company_city=$_POST['company_city'];

	$company_state=$_POST['company_state'];

	$company_house_no=$_POST['company_house_no'];

	$company_street=$_POST['company_street'];

	$company_country=$_POST['company_country'];

	$company_contact_phone=$_POST['company_contact_phone'];

	$company_contact_email=$_POST['company_contact_email'];

	$company_type=$_POST['company_type'];

	$guest_composition=$_POST['guest_composition'];

	$opening_days=$_POST['opening_days'];

	

	$company_name=$cpName[0];

	$checkCompanyQuery = "select count(*) from ".$wpdb->prefix."aa_cafes where company_street='".$company_street."' and company_house_no='".$company_house_no."' and company_city='".$company_city."' ";

	$checkCompany = $wpdb->get_var($checkCompanyQuery);

	if($checkCompany>0) {

		header('Location: '.$_SERVER['REQUEST_URI']);

		$_SESSION['ERROR'] = "Failed: Cafe already exist"; 

		exit();

	}

        (isset($_POST['service_ontbijt']) ? $service_ontbijt=1 : $service_ontbijt=0);

        (isset($_POST['service_lunch']) ? $service_lunch=1 : $service_lunch=0);

        (isset($_POST['service_diner']) ? $service_diner=1 : $service_diner=0);

        (isset($_POST['service_borrel']) ? $service_borrel=1 : $service_borrel=0);

        (isset($_POST['service_uitgaan']) ? $service_uitgaan=1 : $service_uitgaan=0);

        (isset($_POST['service_overnachting']) ? $service_overnachting=1 : $service_overnachting=0);



        (isset($_POST['klant_kinderen']) ? $klant_kinderen=1 : $klant_kinderen=0);

        (isset($_POST['klant_studenten']) ? $klant_studenten=1 : $klant_studenten=0);

        (isset($_POST['klant_zakelijk']) ? $klant_zakelijk=1 : $klant_zakelijk=0);

        (isset($_POST['klant_familiair']) ? $klant_familiair=1 : $klant_familiair=0);

        (isset($_POST['klant_toeristen']) ? $klant_toeristen=1 : $klant_toeristen=0);

        (isset($_POST['klant_stamgasten']) ? $klant_stamgasten=1 : $klant_stamgasten=0);

                                        

   	$company_monthly_visitors=$_POST['company_monthly_visitors'];

	$company_beer_mats=$_POST['company_beer_mats'];

	$company_client_age=$_POST['company_client_age'];

	$company_client_expense=$_POST['company_client_expense'];

	

        $start_period=date("Y-m-d");

        $end_period="2050-01-01";

        

        $sql_insert_empty_row = "INSERT INTO ".$wpdb->prefix."aa_cafes () VALUES()";

        if($wpdb->query($sql_insert_empty_row))

        {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Successfully executed the UPDATE SQL: '.$sql_insert_empty_row);

        }

        else

        {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Error after extecuting UPDATE SQL: '.$sql_insert_empty_row);

        }    

        $current_row=$wpdb->insert_id;



        $sql_update_date_entry = "UPDATE ".$wpdb->prefix."aa_cafes SET date_entry = TIMESTAMP(curdate(), curtime()) WHERE company_id_bm='".$current_row."'";    

        if($wpdb->query($sql_update_date_entry))

        {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Successfully executed the UPDATE SQL: '.$sql_update_date_entry);

        }

        else

        {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Error after extecuting UPDATE SQL: '.$sql_update_date_entry);

        }    
        

        $address = $company_street.' '.$company_house_no.','.$company_zip.','.$company_city.',The Netherlands';

        $latitude='0';

        $longitude='0';

        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');

        $geo = json_decode($geo, true);

        if ($geo['status'] == 'OK'){

            $latitude = $geo['results'][0]['geometry']['location']['lat'];

            $longitude = $geo['results'][0]['geometry']['location']['lng'];

            $sql_geo = "UPDATE ".$wpdb->prefix."aa_cafes SET company_lon='".$longitude."', company_lat='".$latitude."', latlon_ok = '1' WHERE company_id_bm='".$current_row."'";

            if($wpdb->query($sql_geo)){

                write_log(date("Y-m-d_His__").'[FRONT END] -> Successfully executed the UPDATE SQL: '.$sql_geo);

            }

            else{

                write_log(date("Y-m-d_His__").'[FRONT END] -> Error after extecuting UPDATE SQL: '.$sql_geo);

            }   

        }

        else{

            write_log(date("Y-m-d_His__").'[FRONT END] -> GEO API server is busy, please try again later');

        }
        

    $logo_upload=false;

    if (strlen(basename($_FILES["company_logo"]["name"]))  == 0 )  // no file to upload

    {

        //if (strlen($cafeDetailsEdit->company_logo)<2)

        //{

            $sql_company_logo="UPDATE ".$wpdb->prefix."aa_cafes SET company_logo='uw_logo_hier.png' WHERE company_id_bm='".$current_row."'";

            if($wpdb->query($sql_company_logo))

            {

                write_log(date("Y-m-d_His__").'[FRONT END] -> Successfully executed the UPDATE SQL: '.$sql_company_logo);

            }

            else

            {

                write_log(date("Y-m-d_His__").'[FRONT END] -> Error after extecuting UPDATE SQL: '.$sql_company_logo);

            }

        //}

    }

    else   // upload a selected file

    {

        

        $target_dir = CUS_CAFE_PLUGIN_DIR."/assets/uploads/";

        $array = explode('.', basename($_FILES["company_logo"]["name"]));

        $extension = end($array);   // get the file extension

        $company_logo = date("Y-m-d_His__").getUserIP().".".$extension;

        $destination = $target_dir . $company_logo;

        if(move_uploaded_file($_FILES["company_logo"]["tmp_name"], $destination)) 

        {

            $sql="UPDATE ".$wpdb->prefix."aa_cafes SET company_logo='".$company_logo."' WHERE company_id_bm='".$current_row."'";

            if($wpdb->query($sql))

            {

                write_log(date("Y-m-d_His__").'[FRONT END] -> Successfully executed the UPDATE SQL: '.$sql);

                $logo_upload=true;

            }

            else {

                write_log(date("Y-m-d_His__").'[FRONT END] -> Error after extecuting UPDATE SQL: '.$sql);

            }

        }

        else {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Error after moving file to: '.$destination);

        }

    }
          

    $sql_update_row_new_entry = "UPDATE ".$wpdb->prefix."aa_cafes SET company_name='".$company_name."', company_contact_person_name='".$company_contact_person_name."', company_zip='".$company_zip."', company_city='".$company_city."', company_state='".$company_state."',    company_house_no='".$company_house_no."',    company_street='".$company_street."',    company_country='Netherlands',    company_contact_phone='".$company_contact_phone."',    company_contact_email='".$company_contact_email."',    company_type='".$company_type."',    service_ontbijt='".$service_ontbijt."',    service_lunch='".$service_lunch."',    service_diner='".$service_diner."',    service_borrel='".$service_borrel."',    service_uitgaan='".$service_uitgaan."',    service_overnachting='".$service_overnachting."',    company_monthly_visitors='".$company_monthly_visitors."',    company_beer_mats='".$company_beer_mats."',    company_client_age='".$company_client_age."',    klant_kinderen='".$klant_kinderen."',    klant_studenten='".$klant_studenten."',    klant_zakelijk='".$klant_zakelijk."',    klant_familiair='".$klant_familiair."',    klant_toeristen='".$klant_toeristen."',    klant_stamgasten='".$klant_stamgasten."',   company_client_expense='".$company_client_expense."',   guest_composition='".$guest_composition."',    opening_days='".$opening_days."', start_period='".$start_period."', end_period='".$end_period."', date_edit = TIMESTAMP(curdate(), curtime()), new_subscription = '1' WHERE company_id_bm='".$current_row."'";

                

    if($wpdb->query($sql_update_row_new_entry))

    {

        write_log(date("Y-m-d_His__").'[FRONT END] -> Successfully executed the UPDATE SQL: '.$sql_update_row_new_entry);

    }

    else

    {

        write_log(date("Y-m-d_His__").'[FRONT END] -> Error after extecuting UPDATE SQL: '.$sql_update_row_new_entry);

    }  
            

        $subject="Nieuwe inschrijving horeca bij ReclaVilt";

        $headers  = "From: ReclaVilt website<test@gmail.com>\r\n";

        $headers .='MIME-Version: 1.0' . "\r\n";

        $headers .="Content-type: text/html; charset=iso-8859-1\r\n";

        

        $horecaservices="";        

        if($service_ontbijt){ $horecaservices="Ontbijt".","; }

        if($service_lunch){ $horecaservices.="Lunch".","; }

        if($service_diner){ $horecaservices.="Diner".","; }

        if($service_borrel){ $horecaservices.="Borrel".","; }

        if($service_uitgaan){ $horecaservices.="Uitgaan".",";  }

        if($service_overnachting){ $horecaservices.="Overnachting".","; }

        $horecaservices=rtrim($horecaservices,", ");



        $customertype="";

        if($klant_kinderen){ $customertype.="Kinderen".","; }

        if($klant_studenten){ $customertype.="Studenten".","; }

        if($klant_zakelijk){ $customertype.="Zakelijk".","; }

        if($klant_familiair){ $customertype.="Familiair".","; }

        if($klant_toeristen){ $customertype.="Toeristen".","; }

        if($klant_stamgasten){ $customertype.="Stamgasten".","; } 

        $customertype=rtrim($customertype,", ");



        if($logo_upload)

        {

            $logo_image = '<img src="'.CUS_CAFE_PLUGIN_URL.'/assets/uploads/'.$company_logo.' width=\"50\" height=\"50\" />';                        

            $image_url= CUS_CAFE_PLUGIN_URL.'/assets/uploads/'.$company_logo;

        }

        

        $headers = "From: ReclaVilt@Reclavilt.com \r\n";

        $headers .= "MIME-Version: 1.0\r\n";

        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        

        $message  = '<html><body>';

        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';

        $message .= "<tr style='background: #eee;'><td><strong>Zaak:</strong> </td><td>" . strip_tags($company_name) ."</td></tr>";

        $message .= "<tr><td><strong>Contactpersoon</strong></td><td>".$company_contact_person_name."</td></tr>";

        $message .= "<tr><td><strong>Straat</strong></td><td>".$company_street."</td></tr>";

        $message .= "<tr><td><strong>Huisnummer</strong></td><td>".$company_house_no."</td></tr>";

        $message .= "<tr><td><strong>Postcode</strong></td><td>".$company_zip."</td></tr>";

        $message .= "<tr><td><strong>Plaats</strong></td><td>".$company_city."</td></tr>";

        $message .= "<tr><td><strong>Provincie</strong></td><td>".$company_state."</td></tr>";

        $message .= "<tr><td><strong>Land</strong></td><td>Nederland</td></tr>";        

        $message .= "<tr><td><strong>Email</strong></td><td>".$company_contact_email."</td></tr>";

        $message .= "<tr><td><strong>Telefoon</strong></td><td>".$company_contact_phone."</td></tr>";

        

        if($logo_upload)

        {

            $message .= "<tr><td><strong>Logo</strong></td><td>".$image_url."</td></tr>";

            $message .= "<tr><td><strong>Logo</strong></td><td>".$company_logo."</td></tr>";

        }

        $message .= "<tr><td><strong>GEO lon</strong></td><td>".$longitude."</td></tr>";

        $message .= "<tr><td><strong>GEO lat</strong></td><td>".$latitude."</td></tr>";        

        $message .= "<tr><td><strong>Horeca type</strong></td><td>".$company_type."</td></tr>";

        $message .= "<tr><td><strong>Uitgaven</strong></td><td>".$company_client_expense."</td></tr>";

        $message .= "<tr><td><strong>Openingsdagen</strong></td><td>".$opening_days."</td></tr>";

        $message .= "<tr><td><strong>Leeftijd</strong></td><td>".$company_client_age."</td></tr>";

        $message .= "<tr><td><strong>Samenstelling</strong></td><td>".$guest_composition."</td></tr>";

        $message .= "<tr><td><strong>Services</strong></td><td>".$horecaservices."</td></tr>";

        $message .= "<tr><td><strong>Klanten</strong></td><td>".$customertype."</td></tr>";

        $message .= "<tr><td><strong>Maandelijkse bezoekers</strong></td><td>".$company_monthly_visitors."</td></tr>";

        $message .= "<tr><td><strong>Bierviltjes</strong></td><td>".$company_beer_mats."</td></tr>";

        $message .= "<tr><td><strong>Start datum</strong></td><td>".$start_period."</td></tr>";

        $message .= "<tr><td><strong>Eind datum</strong></td><td>".$end_period."</td></tr>";

        $message .= "<p><br>Horecazaak gaat akkoord met de door ReclaVilt opgestelde Algemene Voorwaarden en Privacy Overeenkomst. </p>";

        $message .= "</table>";

        $message .= "</body></html>";        

        

        

        $to=$settings->admin_email;

        //$multiple_recipients = array('info@reclavilt.nl','john.ploeg@gmail.com');

        //$multiple_recipients = array('john.ploeg@gmail.com');

        

        if (wp_mail($to, $subject, $message, $headers))

        {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Conformation mail sent to site owner');

        }

        else 

        {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Error while sending conformation mail to site owner');

        }

        

        // now composing mail for cafe owner

        $subject2="Bedankt voor uw inschrijving bij ReclaVilt";

        

        $message  = '<html><body>';

        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';

        $message .= "<tr style='background: #eee;'><td><strong>Zaak:</strong> </td><td>" . strip_tags($company_name) ."</td></tr>";

        $message .= "<tr><td><strong>Contactpersoon</strong></td><td>".$company_contact_person_name."</td></tr>";

        $message .= "<tr><td><strong>Straat</strong></td><td>".$company_street."</td></tr>";

        $message .= "<tr><td><strong>Huisnummer</strong></td><td>".$company_house_no."</td></tr>";

        $message .= "<tr><td><strong>Postcode</strong></td><td>".$company_zip."</td></tr>";

        $message .= "<tr><td><strong>Plaats</strong></td><td>".$company_city."</td></tr>";

        $message .= "<tr><td><strong>Provincie</strong></td><td>".$company_state."</td></tr>";

        $message .= "<tr><td><strong>Land</strong></td><td>Nederland</td></tr>";        

        $message .= "<tr><td><strong>Email</strong></td><td>".$company_contact_email."</td></tr>";

        $message .= "<tr><td><strong>Telefoon</strong></td><td>".$company_contact_phone."</td></tr>";

        

        if($logo_upload)

        {

            $message .= "<tr><td><strong>Logo</strong></td><td>".$image_url."</td></tr>";

            $message .= "<tr><td><strong>Logo</strong></td><td>".$company_logo."</td></tr>";

        }        

        

        $message .= "<tr><td><strong>GEO lon</strong></td><td>".$longitude."</td></tr>";

        $message .= "<tr><td><strong>GEO lat</strong></td><td>".$latitude."</td></tr>";        

        $message .= "<tr><td><strong>Horeca type</strong></td><td>".$company_type."</td></tr>";

        $message .= "<tr><td><strong>Uitgaven</strong></td><td>".$company_client_expense."</td></tr>";

        $message .= "<tr><td><strong>Openingsdagen</strong></td><td>".$opening_days."</td></tr>";

        $message .= "<tr><td><strong>Leeftijd</strong></td><td>".$company_client_age."</td></tr>";

        $message .= "<tr><td><strong>Samenstelling</strong></td><td>".$guest_composition."</td></tr>";

        $message .= "<tr><td><strong>Services</strong></td><td>".$horecaservices."</td></tr>";

        $message .= "<tr><td><strong>Klanten</strong></td><td>".$customertype."</td></tr>";

        $message .= "<tr><td><strong>Maandelijkse bezoekers</strong></td><td>".$company_monthly_visitors."</td></tr>";

        $message .= "<tr><td><strong>Bierviltjes</strong></td><td>".$company_beer_mats."</td></tr>";

        $message .= "<tr><td><strong>Start datum</strong></td><td>".$start_period."</td></tr>";

        $message .= "<tr><td><strong>Eind datum</strong></td><td>".$end_period."</td></tr>";

        $message .= "<tr><td><strong>&nbsp;</strong></td><td>&nbsp;</td></tr>";

        $message .= "</table>";

        $message .= "<p><br>Horecazaak gaat akkoord met de door ReclaVilt opgestelde Algemene Voorwaarden en Privacy Overeenkomst. </p>";

        $message .= "<p>Bedankt voor uw aanmelding, we zullen z.s.m. contact met u opnemen om de gegevens te verifiëren</p>";

        $message .= "</body></html>";        

        

        if (wp_mail( $company_contact_email, $subject2, $message, $headers )) {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Conformation mail sent to cafe owner');

        }
        else  {

            write_log(date("Y-m-d_His__").'[FRONT END] -> Error while sending conformation mail to cafe owner');

        }
		
		
		$pageSuccess = 1;
        

        /*echo '<script>window.location = "'.site_url().'/thank-you/"</script>';

        exit;*/

}

?>

<div class="container">
  <div class="row">
  	<?php if($pageSuccess==1) {
		echo '<h1><span style="color: #0000ff;">Bedankt voor uw aanvraag, binnen 24 uur nemen we contact op ter verificatie!</span></h1>';
	}
	else { ?>
		<form method="post" id="frm" enctype="multipart/form-data">
		  <input type="hidden" name="formcheck" id="formcheck" value="1" />
		  <div id="first_form">
			<?php
	
				if(isset($_SESSION['ERROR']) && !empty($_SESSION['ERROR'])) {
	
					echo '<div class="errorMsg">'.$_SESSION['ERROR'].'</div>';
	
					unset($_SESSION['ERROR']);
	
				}
	
				?>
			<div class="form-group col-md-7">
			  <div class="text_sec_1"> <?php echo stripslashes(get_option('advert-text-sec-1')); ?> </div>
			</div>
			<div class="form-group col-md-5 top-image-section">
			  <?php if(get_option('advert-photo-sec-1')!=''){
	
						echo wp_get_attachment_image( get_option('advert-photo-sec-1'),'my-cust-img' );
	
					}else{
	
					?>
			  <img src="<?php echo CUS_CAFE_PLUGIN_URL; ?>/assets/images/400x400-light.jpg" />
			  <?php } ?>
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Naam bedrijf:</label>
			  <input class="form-control" id="company_name" name="company_name" type="text" style="display:none;" >
			  <input class="form-control" id="company_name2" name="company_name2" type="text" >
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Contactpersoon:</label>
			  <input type="text" class="form-control" id="company_contact_person_name" name="company_contact_person_name">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Straat:</label>
			  <input type="text" class="form-control" id="route" name="company_street">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Huisnummer:</label>
			  <input type="text" class="form-control" id="street_number" name="company_house_no">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Postcode:</label>
			  <input type="text" class="form-control" id="postal_code" name="company_zip">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Plaats:</label>
			  <input type="text" class="form-control" id="locality" name="company_city">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Provincie:</label>
			  <input type="text" class="form-control" id="administrative_area_level_1" name="company_state">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Land:</label>
			  <input type="text" class="form-control" id="country" name="company_country">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Telefoon:</label>
			  <input type="text" class="form-control" id="company_contact_phone" name="company_contact_phone">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Email:</label>
			  <input type="email" class="form-control" id="company_contact_email" name="company_contact_email">
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Logo:</label>
			  <div>Upload .jpg .png,.eps,.ai,.pdf</div>
			  <input type="file" class="form-control" id="company_logo" name="company_logo">
			</div>
			<div class="form-group col-md-6">
			  <input type="button" style="background-color:#ff0000 !important;" class="2nd_step" value="Volgende >>" />
			</div>
		  </div>
		  <div id="sec_form" style="display:none">
			<div class="clearfix">&nbsp;</div>
			<div style="width:100%; text-align:center">
			  <!--<h3>Stap 2/3: Doelgroepbepaling  </h3>-->
			</div>
			<div class="form-group col-md-7">
			  <div class="text_sec_1">
				<?=stripslashes(get_option('advert-text-sec-2'));?>
			  </div>
			</div>
			<div class="form-group col-md-5 top-image-section">
			  <?php if(get_option('advert-photo-sec-2')!=''){
	
						echo wp_get_attachment_image( get_option('advert-photo-sec-2'),'my-cust-img' );
	
					}else{
	
					?>
			  <img src="<?php echo CUS_CAFE_PLUGIN_URL; ?>/assets/images/400x400-light.jpg" />
			  <?php } ?>
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Soort gelegenheid:</label>
			  <br />
			  <div id="company_type_msg" class="errorTextClass"> Maak uw keuze</div>
			  <select name="company_type">
				<option>----SELECT-----</option>
				<option value="Bar">Bar</option>
				<option value="Bistro">Bistro</option>
				<option value="Café">Café</option>
				<option value="Discotheek">Discotheek</option>
				<option value="Evenement">Evenement</option>
				<option value="GrandCafé">GrandCafé</option>
				<option value="Hotel">Hotel</option>
				<option value="Night Club">Night Club</option>
				<option value="Restaurant">Restaurant</option>
				<option value="Sportvereniging">Sportvereniging</option>
			  </select>
			  <br />
			  <br />
			  <label for="email">Gemiddelde leeftijd van uw gasten:</label>
			  <br />
			  <div id="company_client_age_msg" class="errorTextClass"> Maak uw keuze</div>
			  <select name="company_client_age" class="company_client_age">
				<option value="0-18">&nbsp;&nbsp;0  - 18 </option>
				<option value="18-27">18 - 27 </option>
				<option value="27-45">27 - 45 </option>
				<option value="45+">45+ </option>
			  </select>
			  <br />
			  <br />
			  <label for="email">Gemiddelde uitgave per gast:</label>
			  <br />
			  <div id="company_client_expense_msg" class="errorTextClass"> Maak uw keuze</div>
			  <select name="company_client_expense" class="company_client_expense">
				<option value="5"> <€10 </option>
				<option value="10"> €10-€20 </option>
				<option value="20"> €20-€35 </option>
				<option value="35"> €35-€50 </option>
				<option value="50"> €50 </option>
			  </select>
			  <br />
			  <br />
			  <label for="email">Aantal openingsdagen:</label>
			  <br />
			  <div id="opening_days_msg" class="errorTextClass"></div>
			  <select name="opening_days" id="opening_days">
				<option value="0">--- Select ---</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
			  </select>
			</div>
			<div class="form-group col-md-6 removeLeftSpace">
			  <label for="email">Service:</label>
			  <br />
			  <div id="company_services_msg" class="errorTextClass">Maak uw keuze(s)</div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Ontbijt
				<input type="checkbox" class="company_services"  name="service_ontbijt" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Lunch
				<input type="checkbox" class="company_services"  name="service_lunch" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Diner
				<input type="checkbox" class="company_services"  name="service_diner" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Borrel
				<input type="checkbox" class="company_services"  name="service_borrel" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Uitgaan
				<input type="checkbox" class="company_services"  name="service_uitgaan" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Overnachting
				<input type="checkbox" class="company_services"  name="service_overnachting" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			</div>
			<div class="form-group col-md-6 removeLeftSpace">
			  <label for="email">Type bezoeker:</label>
			  <br />
			  <div id="company_client_type_msg" class="errorTextClass"> Maak uw keuze(s)</div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Kinderen
				<input type="checkbox" class="company_client_type"  name="klant_kinderen" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Studenten
				<input type="checkbox" class="company_client_type"  name="klant_studenten" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Zakeliik
				<input type="checkbox" class="company_client_type"  name="klant_zakelijk" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Familiair
				<input type="checkbox" class="company_client_type"  name="klant_familiair" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Toeristen
				<input type="checkbox" class="company_client_type"  name="klant_toeristen" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			  <div class="col-md-4">
				<label class="checkBoxContainer">Stamgasten
				<input type="checkbox" class="company_client_type"  name="klant_stamgasten" value="1">
				<span class="checkmark"></span> </label>
			  </div>
			</div>
			<div class="form-group col-md-6">
			  <label for="email">De samenstelling van uw gasten:</label>
			  <br />
			  <div id="guest_composition_msg" class="errorTextClass"> Maak uw keuze</div>
			  <select name="guest_composition" id="guest_composition">
				<option value="Meer mannen dan vrouwen">Meer mannen dan vrouwen </option>
				<option value="Gelijkelijk verdeeld">Gelijkelijk verdeeld </option>
				<option value="Meer vrouwen dan mannen">Meer vrouwen dan mannen</option>
			  </select>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="form-group col-md-6">
			  <input type="button" class="1st_step" value="<< Terug" />
			</div>
			<div class="form-group col-md-6">
			  <input type="button" style="background-color:#ff0000 !important;" class="3rd_step" value="Volgende >>" />
			</div>
		  </div>
		  <div id="third_form"  style="display:none">
			<div style="width:100%; text-align:center">
			  <!--<h3>Stap 3/3: Volumebepaling </h3> -->
			</div>
			<div class="form-group col-md-7">
			  <div class="text_sec_1">
				<?=stripslashes(get_option('advert-text-sec-3'));?>
			  </div>
			</div>
			<div class="form-group col-md-5 top-image-section">
			  <?php if(get_option('advert-photo-sec-3')!=''){
	
						echo wp_get_attachment_image( get_option('advert-photo-sec-3'),'my-cust-img' );
	
					}else{
	
					?>
			  <img src="<?php echo CUS_CAFE_PLUGIN_URL; ?>/assets/images/400x400-light.jpg" />
			  <?php } ?>
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Maandelijkse bezoekers:</label>
			  <select class="form-control" id="company_monthly_visitors" name="company_monthly_visitors">
				<option value="1000">1000</option>
				<option value="1500">1500</option>
				<option value="2000">2000</option>
				<option value="3000">3000</option>
				<option value="4000">4000</option>
				<option value="5000">5000</option>
				<option value="6000">6000</option>
				<option value="7000">7000</option>
				<option value="8000">8000</option>
				<option value="9000">9000</option>
				<option value="10000">10000</option>
				<option value="12000">12000</option>
				<option value="14000">14000</option>
				<option value="16000">16000</option>
				<option value="18000">18000</option>
				<option value="20000">20000</option>
				<option value="25000">25000</option>
				<option value="30000">30000</option>
				<option value="35000">35000</option>
				<option value="40000">>40000 </option>
			  </select>
			</div>
			<div class="form-group col-md-6">
			  <label for="email">Aantal bierviltjes per maand:</label>
			  <select class="form-control" id="company_beer_mats" name="company_beer_mats">
				<option value="250">250</option>
				<option value="500">500 - 750</option>
				<option value="750">750 - 1.000</option>
				<option value="1000">1.000 - 1.500</option>
				<option value="1500">1.500 - 2.000</option>
				<option value="2000">2.000 - 2.500</option>
				<option value="2500">2.500 - 5.000</option>
				<option value="5000">5.000 - 7.500</option>
				<option value="7500">7.500 - 10.000</option>
				<option value="10000">10.000 - 15.000</option>
				<option value="15000">15.000 - 20.000</option>
				<option value="20000">20.000 - 25.000</option>
				<option value="25000">25.000+</option>
			  </select>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="form-group col-md-12">
			  <label class="checkBoxContainer">Ik ga akkoord met de door ReclaVilt opgestelde Algemene Voorwaarden.
			  <input type="checkbox" class="termandcondition" required >
			  <span class="checkmark"></span> </label>
			</div>
			<div class="form-group col-md-12">
			  <label class="checkBoxContainer">Ik ga tevens akkoord met het Privacy Reglement van ReclaVilt.
			  <input type="checkbox" class="termandcondition" required >
			  <span class="checkmark"></span> </label>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="form-group col-md-6">
			  <input type="button" class=" btn btn-info termandconditionaccess" data-toggle="modal" data-target="#myModal" value="Bekijk hier onze Algemene Voorwaarden" style="color: #fff !important;background-color: #F27125 !important;border-color: #1b6d85 !important;width:50%;" >
			  <input type="button" class=" btn btn-info termandconditionaccess" data-toggle="modal" data-target="#privacyModal" value="Bekijk hier ons Privacy Reglement" style="color: #fff !important;background-color: #F27125 !important;padding: 1em 2em;border-color: #1b6d85 !important;width:49%;" >
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="form-group col-md-6">
			  <input type="button" class="2nd_step" value="<<Vorige" />
			</div>
			<div class="form-group col-md-6">
			  <input type="submit" name="submit" style="background-color:#ff0000 !important;" value="AANVRAGEN!" id="submit" />
			</div>
		  </div>
		  <div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Algemene voorwaarden: Bierviltjes kopen met ReclaVilt</h4>
				</div>
				<div class="modal-body">
				  <?=$settings->algemene_voorwaarden?>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
		  </div>
		  <div id="privacyModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Privacy: Bierviltjes kopen met ReclaVilt</h4>
				</div>
				<div class="modal-body">
				  <?=$settings->privacy?>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
		  </div>
		</form>
    <?php } ?>
  </div>
</div>
<?php get_footer(); ?>
