<?php

ob_start();
ob_clean();

// Disable all errors
//error_reporting(0);

// Report all PHP errors
//error_reporting(-1);
global $wpdb;
$cafeDetails = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."aa_cafes ORDER BY new_subscription DESC, latlon_ok ASC" );

$LatLonCheckCafes = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."aa_cafes where latlon_ok = '0'" );
foreach($LatLonCheckCafes as $LatLonCheck)
{
    $address = $LatLonCheck->company_street.' '.$LatLonCheck->company_house_no.','.$LatLonCheck->company_zip.','.$LatLonCheck->company_city.',The Netherlands';
    $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
    $geo = json_decode($geo, true);
    if ($geo['status'] == 'OK') 
    {
        $latitude = $geo['results'][0]['geometry']['location']['lat'];
        $longitude = $geo['results'][0]['geometry']['location']['lng'];
        $sql_geo_lat_lon = "UPDATE ".$wpdb->prefix."aa_cafes SET company_lon='".$longitude."', company_lat='".$latitude."', latlon_ok='1' WHERE company_id_bm='".$LatLonCheck->company_id_bm."'";

        
        if($wpdb->query($sql_geo_lat_lon))
        {
            write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql_geo_lat_lon);
        }
        else
        {
            write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql_geo_lat_lon);
        }        
    }
    else
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> GEO API server is busy, please try again later');
    }          
}


    
    
if(isset($_POST['submit'])){
    global $wpdb;
    $company_name=$_POST['company_name'];
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
    $opening_days=$_POST['opening_days'];
    $guest_composition=$_POST['guest_composition'];

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

    $start_period=$_POST['start_period'];
    $end_period=$_POST['end_period'];

    $sql_insert_empty_row = "INSERT INTO ".$wpdb->prefix."aa_cafes () VALUES()";
    if($wpdb->query($sql_insert_empty_row))
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql_insert_empty_row);
    }
    else
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql_insert_empty_row);
    }    
    $current_row=mysql_insert_id();
    
    $sql_update_date_entry = "UPDATE ".$wpdb->prefix."aa_cafes SET date_entry = TIMESTAMP(curdate(), curtime()) WHERE company_id_bm='".$current_row."'";    
    if($wpdb->query($sql_update_date_entry))
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql_update_date_entry);
    }
    else
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql_update_date_entry);
    }    
    
    
    $address = $company_street.' '.$company_house_no.','.$company_zip.','.$company_city.',The Netherlands';
    $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
    $geo = json_decode($geo, true);
    if ($geo['status'] == 'OK') 
    {
        $latitude = $geo['results'][0]['geometry']['location']['lat'];
        $longitude = $geo['results'][0]['geometry']['location']['lng'];
        $sql_geo = "UPDATE ".$wpdb->prefix."aa_cafes SET company_lon='".$longitude."', company_lat='".$latitude."', latlon_ok = '1' WHERE company_id_bm='".$current_row."'";
        if($wpdb->query($sql_geo))
        {
            write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql_geo);
        }
        else
        {
            write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql_geo);
        }        
        
    }
    else
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> GEO API server is busy, please try again later');
    }          

    if (strlen(basename($_FILES["company_logo"]["name"]))  == 0 )  // no file to upload
    {
        if (strlen($cafeDetailsEdit->company_logo)<2)
        {
            $sql_company_logo="UPDATE ".$wpdb->prefix."aa_cafes SET company_logo='uw_logo_hier.png' WHERE company_id_bm='".$current_row."'";
            if($wpdb->query($sql_company_logo))
            {
                write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql_company_logo);
            }
            else
            {
                write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql_company_logo);
            }
        }
    }
    else   // upload a selected file
    {
        $target_dir = "../uploads/";
        $array = explode('.', basename($_FILES["company_logo"]["name"]));
        $extension = end($array);   // get the file extension
        $company_logo = date("Y-m-d_His__").getUserIP().".".$extension;
        $destination = $target_dir . $company_logo;
        if(move_uploaded_file($_FILES["company_logo"]["tmp_name"], $destination)) 
        {
            $sql="UPDATE ".$wpdb->prefix."aa_cafes SET company_logo='".$company_logo."' WHERE company_id_bm='".$current_row."'";
            if($wpdb->query($sql))
            {
                write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql);
            }
            else
            {
                write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql);
            }
        }
        else
        {
            write_log(date("Y-m-d_His__").'[BACK END] -> Error after moving file to: '.$destination);
        }
    }

    
    $sql_update_row_new_entry = "UPDATE ".$wpdb->prefix."aa_cafes SET company_name='".$company_name."', company_contact_person_name='".$company_contact_person_name."', company_zip='".$company_zip."', company_city='".$company_city."', company_state='".$company_state."',    company_house_no='".$company_house_no."',    company_street='".$company_street."',    company_country='Netherlands',    company_contact_phone='".$company_contact_phone."',    company_contact_email='".$company_contact_email."',    company_type='".$company_type."',    service_ontbijt='".$service_ontbijt."',    service_lunch='".$service_lunch."',    service_diner='".$service_diner."',    service_borrel='".$service_borrel."',    service_uitgaan='".$service_uitgaan."',    service_overnachting='".$service_overnachting."',    company_monthly_visitors='".$company_monthly_visitors."',    company_beer_mats='".$company_beer_mats."',    company_client_age='".$company_client_age."',    klant_kinderen='".$klant_kinderen."',    klant_studenten='".$klant_studenten."',    klant_zakelijk='".$klant_zakelijk."',    klant_familiair='".$klant_familiair."',    klant_toeristen='".$klant_toeristen."',    klant_stamgasten='".$klant_stamgasten."',   company_client_expense='".$company_client_expense."',   guest_composition='".$guest_composition."',    opening_days='".$opening_days."', start_period='".$start_period."', end_period='".$end_period."', date_edit = TIMESTAMP(curdate(), curtime()), new_subscription = '1' WHERE company_id_bm='".$current_row."'";
    if($wpdb->query($sql_update_row_new_entry))
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql_update_row_new_entry);
    }
    else
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql_update_row_new_entry);
    }       


    $redirect_url=site_url()."/wp-admin/admin.php?page=cafe_list&id=".$current_row;
    echo '<script>window.location = "'.$redirect_url.'"</script>';
    exit;
}   // end submit new record


if(isset($_REQUEST['id']))
{
    $cafeDetailsEdit = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."aa_cafes WHERE company_id_bm='".$_REQUEST['id']."'" );
}



if(isset($_POST['update']))
{
    global $wpdb;
    
    $current_row=$_REQUEST['id'];
    
    $company_name=$_POST['company_name'];
    $company_contact_person_name=$_POST['company_contact_person_name'];
    $company_zip=$_POST['company_zip'];
    $company_city=$_POST['company_city'];
    $company_state=$_POST['company_state'];
    $company_house_no=$_POST['company_house_no'];
    $company_street=$_POST['company_street'];
    $company_country=$_POST['company_country'];
    $company_contact_phone=$_POST['company_contact_phone'];
    $company_contact_email=$_POST['company_contact_email'];
    $company_lon=$_POST['company_lon'];
    $company_lat=$_POST['company_lat'];
    
    $company_type=$_POST['company_type'];
    $opening_days=$_POST['opening_days'];
    $start_period=$_POST['start_period'];
    $end_period=$_POST['end_period'];
    $guest_composition=$_POST['guest_composition'];

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

    if (strlen(basename($_FILES["company_logo"]["name"]))  == 0 )  // no file to upload
    {
        if (strlen($cafeDetailsEdit->company_logo)<2)
        {
            $sql_company_logo="UPDATE ".$wpdb->prefix."aa_cafes SET company_logo='uw_logo_hier.png' WHERE company_id_bm='".$current_row."'";
            if($wpdb->query($sql_company_logo))
            {
                write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql_company_logo);
            }
            else
            {
                write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql_company_logo);
            }
        }
    }
    else   // upload a selected file
    {
        $target_dir = "../uploads/";
        $array = explode('.', basename($_FILES["company_logo"]["name"]));
        $extension = end($array);   // get the file extension
        $company_logo = date("Y-m-d_His__").getUserIP().".".$extension;
        $destination = $target_dir . $company_logo;
        if(move_uploaded_file($_FILES["company_logo"]["tmp_name"], $destination)) 
        {
            $sql="UPDATE ".$wpdb->prefix."aa_cafes SET company_logo='".$company_logo."' WHERE company_id_bm='".$current_row."'";
            if($wpdb->query($sql))
            {
                write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql);
            }
            else
            {
                write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql);
            }
        }
        else
        {
            write_log(date("Y-m-d_His__").'[BACK END] -> Error after moving file to: '.$destination);
        }
    }

    $sql_update_row = "UPDATE ".$wpdb->prefix."aa_cafes SET company_name='".$company_name."', company_contact_person_name='".$company_contact_person_name."', company_zip='".$company_zip."', company_city='".$company_city."', company_state='".$company_state."',    company_house_no='".$company_house_no."',    company_street='".$company_street."',    company_country='Netherlands',    company_contact_phone='".$company_contact_phone."',    company_contact_email='".$company_contact_email."',    company_type='".$company_type."',    service_ontbijt='".$service_ontbijt."',    service_lunch='".$service_lunch."',    service_diner='".$service_diner."',    service_borrel='".$service_borrel."',    service_uitgaan='".$service_uitgaan."',    service_overnachting='".$service_overnachting."',    company_monthly_visitors='".$company_monthly_visitors."',    company_beer_mats='".$company_beer_mats."',    company_client_age='".$company_client_age."',    klant_kinderen='".$klant_kinderen."',    klant_studenten='".$klant_studenten."',    klant_zakelijk='".$klant_zakelijk."',    klant_familiair='".$klant_familiair."',    klant_toeristen='".$klant_toeristen."',    klant_stamgasten='".$klant_stamgasten."',   company_client_expense='".$company_client_expense."',   guest_composition='".$guest_composition."',    opening_days='".$opening_days."', start_period='".$start_period."', end_period='".$end_period."', date_edit = TIMESTAMP(curdate(), curtime()), new_subscription = '0' WHERE company_id_bm='".$current_row."'";
    if($wpdb->query($sql_update_row))
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql_update_row);
    }
    else
    {
        write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql_update_row);
    } 

    $redirect_url=site_url()."/wp-admin/admin.php?page=cafe_list";
    echo '<script>window.location = "'.$redirect_url.'"</script>';
    exit;
}	

    ?>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
	
     <div class="wrap">

        <h2>Overzicht Horeca gelegenheden</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
    		<a href="javascript:void(0)" id="addNew">Add New</a>&nbsp;&nbsp;
                <a href="admin.php?page=cafe_list" id=""> Overzicht cafes</a>&nbsp;&nbsp;
            </div>

            <br class="clear"> 
        </div>

	<?php if(!isset($_REQUEST['id'])){?>

	<table class='wp-list-table widefat fixed striped posts' id="list">
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Status</th>
                <th class="manage-column ss-list-width">Coordinaten</th>
                <th class="manage-column ss-list-width">Horeca gelegenheid</th>
		<th class="manage-column ss-list-width">Contactpersoon</th>
                <th class="manage-column ss-list-width">Adres</th>
		<th class="manage-column ss-list-width">Plaats</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php foreach($cafeDetails as $cafe){?>
            <tr>
                <td class="manage-column ss-list-width"><?php echo $cafe->company_id_bm; ?></td>
                <td class="manage-column ss-list-width"><?php echo ($cafe->new_subscription == 1 ? 'NIEUW' : '') ; ?></td>
                <td class="manage-column ss-list-width"><?php echo ($cafe->latlon_ok == 1 ? 'ok' : 'oops druk op F5') ; ?></td>
                <td class="manage-column ss-list-width"><?php echo $cafe->company_name;?></td>
                <td class="manage-column ss-list-width"><?php echo $cafe->company_contact_person_name;?></td>
                <td class="manage-column ss-list-width"><?php echo $cafe->company_street;?>&nbsp;<?php echo $cafe->company_house_no;?></td>
                <td class="manage-column ss-list-width"><?php echo $cafe->company_city;?></td>
                <td class="manage-column ss-list-width"><a href="admin.php?page=cafe_list&id=<?php echo $cafe->company_id_bm;?>"><input type="submit" class="delete" value=" Edit "/></a></td>
                <td class="manage-column ss-list-width">
                <form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
        		<?php  wp_nonce_field( 'my_delete_event_cafe' ); ?>
			<input type="hidden" name="action" value="my_delete_event_cafe">
        		<input type="hidden" name="eventid" value="<?php echo $cafe->company_id_bm; ?> ">
			<input type="submit" class="delete" value="Delete" style="color:#ea3c3c;"/>
		</form></td>
            </tr>
            <?php }  //ob_clean();  ?> 

	</table>

        
	<div class="row" id="form" style="display:none">
		<form method="post" id="frm" enctype="multipart/form-data">
		<div id="first_form">

                        <div class="form-group col-md-6">
				<label for="email">Naam bedrijf:</label>
				<input type="text" class="form-control" id="company_name" name="company_name">
			 </div>

			 <div class="form-group col-md-6">
				<label for="email">Huisnummer:</label>
				<input type="text" class="form-control" id="company_house_no" name="company_house_no">
			 </div>

			 <div class="form-group col-md-6">
				<label for="email">Straat:</label>
				<input type="text" class="form-control" id="company_street" name="company_street">
			 </div>

			 <div class="form-group col-md-6">
				<label for="email">Plaats:</label>
				<input type="text" class="form-control" id="company_city" name="company_city">
			 </div>

			 <div class="form-group col-md-6">
				<label for="email">State:</label>
				<input type="text" class="form-control" id="company_state" name="company_state">
			 </div>

			 <div class="form-group col-md-6">

				<label for="email">Country:</label>

				<input type="text" class="form-control" id="company_country" name="company_country">

			 </div>

			 <div class="form-group col-md-6">

				<label for="email">Postcode:</label>

				<input type="text" class="form-control" id="company_zip" name="company_zip">

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
				<input type="file" class="form-control" id="company_logo" name="company_logo">
			 </div>

			 <div class="form-group col-md-6">
					<input type="button" class="2nd_step" value="Volgende >>" />
			  </div>

		</div>	 

		 

		<div id="sec_form" style="display:none">

			<div class="clearfix"> </div>

                        <div class="form-group col-md-6">
                            <label for="email">Soort gelegenheid:</label>
                            <div id="company_type_msg" class="errorTextClass"> Maak je keuze</div>
                            <select name="company_type">
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
			</div>

			<div class="form-group col-md-6">
				<label for="email">Gemiddelde leeftijd van de gasten:</label>
				<div id="company_client_age_msg" class="errorTextClass"> Maak je keuze</div>
				<select name="company_client_age" class="company_client_age">
                                    <option value="0-18">&nbsp;&nbsp;0  - 18 </option>
                                    <option value="18-27">18 - 27 </option>
                                    <option value="27-45">27 - 45 </option>
                                    <option value="45+">45+ </option>
                                </select>
			 </div>                        
                       
                        
			<div class="form-group col-md-6">
                            <label for="email">Gemiddelde uitgave per gast:</label>
                            <div id="company_client_expense_msg" class="errorTextClass"> Maak je keuze</div>
                            <select name="company_client_expense" class="company_client_expense">
                                <option value="5"> &lt;€10 </option>
                                <option value="10"> €10-€20 </option>
                                <option value="20"> €20-€35 </option>
                                <option value="35"> €35-€50 </option>
                                <option value="50"> €50 </option>
                            </select>
			</div>
                        
                        <div class="form-group col-md-6">
                            <label for="email">De samenstelling van uw gasten:</label>
                            <div id="guest_composition_msg" class="errorTextClass"> Maak je keuze</div>				
                            <select name="guest_composition" id="guest_composition">
                                <option value="Meer mannen dan vrouwen">Meer mannen dan vrouwen </option>
                                <option value="Gelijkelijk verdeeld">Gelijkelijk verdeeld </option>
                                <option value="Meer vrouwen dan mannen">Meer vrouwen dan mannen</option>                    
                            </select>
                        </div>                        
                        
                    <div class="form-group col-md-6">
				<label for="email">Service: (meerdere keuzes mogelijk)</label>
				<div id="company_client_type_msg"></div>
				<input type="checkbox" class="company_services"  name="service_ontbijt" value="1"> Ontbijt
				<input type="checkbox" class="company_services"  name="service_lunch" value="1"> Lunch
				<input type="checkbox" class="company_services"  name="service_diner" value="1"> Diner
				<input type="checkbox" class="company_services"  name="service_borrel" value="1"> Borrel
				<input type="checkbox" class="company_services"  name="service_uitgaan" value="1"> Uitgaan
				<input type="checkbox" class="company_services"  name="service_overnachting" value="1"> Overnachting
                    </div>    

                    <div class="form-group col-md-6">
				<label for="email">Type bezoeker: (meerdere keuzes mogelijk)</label>
				<div id="company_client_type_msg"></div>
				<input type="checkbox" class="company_client_type"  name="klant_kinderen" value="1"> Kinderen
				<input type="checkbox" class="company_client_type"  name="klant_studenten" value="1"> Studenten
				<input type="checkbox" class="company_client_type"  name="klant_zakelijk" value="1"> Zakeliik
				<input type="checkbox" class="company_client_type"  name="klant_familiair" value="1"> Familiair
				<input type="checkbox" class="company_client_type"  name="klant_toeristen" value="1"> Toeristen
                                <input type="checkbox" class="company_client_type"  name="klant_stamgasten" value="1"> Stamgasten
                    </div>



            <div class="form-group col-md-6">
                        <label for="email">Opening Days:</label>
                        <div id="company_client_gender_msg"></div>
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

			 <div class="clearfix"> </div>
			 <div class="form-group col-md-6">
				<input type="button" class="1st_step" value="<< Back " />
			  </div>

			 <div class="form-group col-md-6">
				<input type="button" class="3rd_step" value="Next >>" />
			  </div>
		</div>

		<div id="third_form"  style="display:none">
			
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
                    
            <div class="form-group col-md-6">
                    <label for="email">Start Viltcampagne:</label>
                    <input type="date" name="start_period" class="form-control" value="<?=date("Y-m-d")?>"  />
                </div>
        
            <div class="form-group col-md-6">
            <label for="email">Einde Viltcampagne</label>
            <input type="date" name="end_period" class="form-control"  value="<?=date("Y-m-d")?>"  />
            </div>                    
                    

		 	<div class="clearfix"> </div>
			 <div class="form-group col-md-6">
					<input type="button" class="2nd_step" value="<<Back" />
			  </div>

		 <div class="form-group col-md-6">
			<input type="submit" name="submit" value="AANVRAGEN" id="submit" />
		 </div>

		</div>
		 
		</form> 
	</div>

	<?php

		}

   //ob_clean();

?> 

	<!----- FOR EDIT ----->

	<?php if(isset($_REQUEST['id'])){

		

		?>

		<div class="row">

		<form method="post" id="frm_update" enctype="multipart/form-data">

                    <div id="first_form">

			<div class="form-group col-md-6">
				<label for="email">Naam bedrijf:</label>
				<input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $cafeDetailsEdit->company_name;?>">
			 </div>

                        <div class="form-group col-md-6">
				<label for="email">Naam contactpersoon:</label>
				<input type="text" class="form-control" id="company_contact_person_name" name="company_contact_person_name" value="<?php echo $cafeDetailsEdit->company_contact_person_name;?>">
			 </div>
                        
			 <div class="form-group col-md-6">
				<label for="email">Straat:</label>
				<input type="text" class="form-control" id="company_street" name="company_street" value="<?php echo $cafeDetailsEdit->company_street;?>">
			 </div>

                        <div class="form-group col-md-6">
				<label for="email">Huisnummer</label>
				<input type="text" class="form-control" id="company_house_no" name="company_house_no" value="<?php echo $cafeDetailsEdit->company_house_no;?>">
			</div>

			<div class="form-group col-md-6">
				<label for="email">Postcode:</label>
				<input type="text" class="form-control" id="company_zip" name="company_zip" value="<?php echo $cafeDetailsEdit->company_zip;?>">
			</div>
                        
                        <div class="form-group col-md-6">
				<label for="email">Plaats:</label>
				<input type="text" class="form-control" id="company_city" name="company_city" value="<?php echo $cafeDetailsEdit->company_city;?>">
			 </div>

			<div class="form-group col-md-6">
				<label for="email">Provincie:</label>
				<input type="text" class="form-control" id="company_state" name="company_state" value="<?php echo $cafeDetailsEdit->company_state;?>">
			</div>

			 <div class="form-group col-md-6">
				<label for="email">Land:</label>
				<input type="text" class="form-control" id="company_country" name="company_country" value="<?php echo $cafeDetailsEdit->company_country;?>">
			 </div>

			 <div class="form-group col-md-6">
				<label for="email">Telefoon:</label>
				<input type="text" class="form-control" id="company_contact_phone" name="company_contact_phone" value="<?php echo $cafeDetailsEdit->company_contact_phone;?>">
			 </div>

			 <div class="form-group col-md-6">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="company_contact_email" name="company_contact_email" value="<?php echo $cafeDetailsEdit->company_contact_email;?>">
			 </div>

                        <div class="form-group col-md-6">
				<label for="email">GEO longitude:</label>
				<input type="text" class="form-control" id="company_lon" name="company_lon" value="<?php echo $cafeDetailsEdit->company_lon;?>" readonly>
			</div>
                        
                        <div class="form-group col-md-6">
				<label for="email">GEO lattitude:</label>
				<input type="text" class="form-control" id="company_lat" name="company_lat" value="<?php echo $cafeDetailsEdit->company_lat;?>" readonly>
			 </div>

			 <div class="form-group col-md-6">
				<label for="email">Logo  ---></label>
                                <img src="<?php echo CUS_CAFE_PLUGIN_URL; ?>/assets/uploads/<?=$cafeDetailsEdit->company_logo?>" width="50"  />
				<input type="file" class="form-control" id="company_logo" name="company_logo">
			 </div>
                        
        		 <div class="form-group col-md-6">
				<input type="button" class="2nd_step" value="Volgende >>" />
			 </div>

                    </div>	 


		<div id="sec_form" style="display:none">

			<div class="clearfix"> </div>

                        <div class="form-group col-md-6">
                            <label for="email">Soort gelegenheid:</label>
                            <div id="company_type_msg" class="errorTextClass"> Maak je keuze</div>
                            <select name="company_type">
                                <option value="Bar" <?php if($cafeDetailsEdit->company_type=="Bar"){?> selected="selected"<?php } ?>>Bar</option>
                                <option value="Bistro"  <?php if($cafeDetailsEdit->company_type=="Bistro"){?> selected="selected"<?php } ?>>Bistro</option>                
                                <option value="Café"  <?php if($cafeDetailsEdit->company_type=="Café"){?> selected="selected"<?php } ?>>Café</option>
                                <option value="Discotheek"  <?php if($cafeDetailsEdit->company_type=="Discotheek"){?> selected="selected"<?php } ?>>Discotheek</option>
                                <option value="Evenement"  <?php if($cafeDetailsEdit->company_type=="Evenement"){?> selected="selected"<?php } ?>>Evenement</option>
                                <option value="GrandCafé"  <?php if($cafeDetailsEdit->company_type=="GrandCafé"){?> selected="selected"<?php } ?>>GrandCafé</option>
                                <option value="Hotel"  <?php if($cafeDetailsEdit->company_type=="Hotel"){?> selected="selected"<?php } ?>>Hotel</option>
                                <option value="Night Club"  <?php if($cafeDetailsEdit->company_type=="Night Club"){?> selected="selected"<?php } ?>>Night Club</option>
                                <option value="Restaurant"  <?php if($cafeDetailsEdit->company_type=="Restaurant"){?> selected="selected"<?php } ?>>Restaurant</option>
                                <option value="Sportvereniging"  <?php if($cafeDetailsEdit->company_type=="Sportvereniging"){?> selected="selected"<?php } ?>>Sportvereniging</option>
                            </select>
			</div>

			<div class="form-group col-md-6">
				<label for="email">Gemiddelde leeftijd van de gasten:</label>
				<div id="company_client_age_msg" class="errorTextClass"> Maak je keuze</div>
				<select name="company_client_age" class="company_client_age">
                                    <option value="0-18" <?php if($cafeDetailsEdit->company_client_age=="0-18"){?> selected="selected"<?php } ?>>&nbsp;&nbsp;0  - 18 </option>
                                    <option value="18-27" <?php if($cafeDetailsEdit->company_client_age=="18-27"){?> selected="selected"<?php } ?>>18 - 27 </option>
                                    <option value="27-45" <?php if($cafeDetailsEdit->company_client_age=="27-45"){?> selected="selected"<?php } ?>>27 - 45 </option>
                                    <option value="45+" <?php if($cafeDetailsEdit->company_client_age=="45+"){?> selected="selected"<?php } ?>>45+ </option>
                                </select>
			 </div>                        
                        
      			<div class="form-group col-md-6">
                            <label for="email">Gemiddelde uitgave per gast:</label>
                            <div id="company_client_expense_msg" class="errorTextClass"> Maak je keuze</div>
                            <select name="company_client_expense" class="company_client_expense">
                                <option value="5" <?php if($cafeDetailsEdit->company_client_expense=="5"){?> selected="selected"<?php } ?>> <€10 </option>
                                <option value="10" <?php if($cafeDetailsEdit->company_client_expense=="10"){?> selected="selected"<?php } ?>> €10-€20 </option>
                                <option value="20" <?php if($cafeDetailsEdit->company_client_expense=="20"){?> selected="selected"<?php } ?>> €20-€35 </option>
                                <option value="35" <?php if($cafeDetailsEdit->company_client_expense=="35"){?> selected="selected"<?php } ?>> €35-€50 </option>
                                <option value="50" <?php if($cafeDetailsEdit->company_client_expense=="50"){?> selected="selected"<?php } ?>> €50 </option>
                            </select>
			</div>
                        
                        <div class="form-group col-md-6">
                            <label for="email">De samenstelling van uw gasten:</label>
                            <div id="guest_composition_msg" class="errorTextClass"> Maak je keuze</div>				
                            <select name="guest_composition" id="guest_composition">
                                <option value="Meer mannen dan vrouwen" <?php if($cafeDetailsEdit->guest_composition=="Meer mannen dan vrouwen"){?> selected="selected"<?php } ?>>Meer mannen dan vrouwen </option>
                                <option value="Gelijkelijk verdeeld" <?php if($cafeDetailsEdit->guest_composition=="Gelijkelijk verdeeld"){?> selected="selected"<?php } ?>>Gelijkelijk verdeeld </option>
                                <option value="Meer vrouwen dan mannen" <?php if($cafeDetailsEdit->guest_composition=="Meer vrouwen dan mannen"){?> selected="selected"<?php } ?>>Meer vrouwen dan mannen</option>                    
                            </select>
                        </div>                        
                        
			<div class="form-group col-md-6">
				<label for="email">Service: (meerdere keuzes mogelijk)</label>
				<div id="company_client_type_msg"></div>
				<input type="checkbox" class="company_services"  name="service_ontbijt" value="<?=$cafeDetailsEdit->service_ontbijt?>" <?php if($cafeDetailsEdit->service_ontbijt=="1"){?>checked<?php } ?>> Ontbijt
				<input type="checkbox" class="company_services"  name="service_lunch" value="<?=$cafeDetailsEdit->service_lunch?>" <?php if($cafeDetailsEdit->service_lunch=="1"){?>checked<?php } ?>> Lunch
				<input type="checkbox" class="company_services"  name="service_diner" value="<?=$cafeDetailsEdit->service_diner?>" <?php if($cafeDetailsEdit->service_diner=="1"){?>checked<?php } ?>> Diner
				<input type="checkbox" class="company_services"  name="service_borrel" value="<?=$cafeDetailsEdit->service_borrel?>" <?php if($cafeDetailsEdit->service_borrel=="1"){?>checked<?php } ?>> Borrel
				<input type="checkbox" class="company_services"  name="service_uitgaan" value="<?=$cafeDetailsEdit->service_uitgaan?>" <?php if($cafeDetailsEdit->service_uitgaan=="1"){?>checked<?php } ?>> Uitgaan
				<input type="checkbox" class="company_services"  name="service_overnachting" value="<?=$cafeDetailsEdit->service_overnachting?>" <?php if($cafeDetailsEdit->service_overnachting=="1"){?>checked<?php } ?>> Overnachting
			</div>    

        		 <div class="form-group col-md-6">
				<label for="email">Type bezoeker: (meerdere keuzes mogelijk)</label>
				<div id="company_client_type_msg"></div>
				<input type="checkbox" class="company_client_type"  name="klant_kinderen" value="1" <?php if($cafeDetailsEdit->klant_kinderen==1){?>checked<?php } ?>> Kinderen
				<input type="checkbox" class="company_client_type"  name="klant_studenten" value="1" <?php if($cafeDetailsEdit->klant_studenten==1){?>checked<?php } ?>> Studenten
				<input type="checkbox" class="company_client_type"  name="klant_zakelijk" value="1" <?php if($cafeDetailsEdit->klant_zakelijk==1){?>checked<?php } ?>> Zakeliik
				<input type="checkbox" class="company_client_type"  name="klant_familiair" value="1" <?php if($cafeDetailsEdit->klant_familiair==1){?>checked<?php } ?>> Familiair
				<input type="checkbox" class="company_client_type"  name="klant_toeristen" value="1" <?php if($cafeDetailsEdit->klant_toeristen==1){?>checked<?php } ?>> Toeristen
                                <input type="checkbox" class="company_client_type"  name="klant_stamgasten" value="1" <?php if($cafeDetailsEdit->klant_stamgasten==1){?>checked<?php } ?>> Stamgasten
			 </div>
				 

			 <div class="form-group col-md-6">
				<label for="email">Aantal Openingsdagen:</label>
				<div id="company_client_gender_msg"></div>
                                <?php //$arrOp=explode(",",$cafeDetailsEdit->opening_days); ?>
				<select name="opening_days" id="opening_days">
                                    <option value="0">--- Select ---</option>
                                    <option value="1" <?php if($cafeDetailsEdit->opening_days==1){?> selected="selected"<?php } ?>>1</option>
                                    <option value="2" <?php if($cafeDetailsEdit->opening_days==2){?> selected="selected"<?php } ?>>2</option>
                                    <option value="3" <?php if($cafeDetailsEdit->opening_days==3){?> selected="selected"<?php } ?>>3</option>
                                    <option value="4" <?php if($cafeDetailsEdit->opening_days==4){?> selected="selected"<?php } ?>>4</option>
                                    <option value="5" <?php if($cafeDetailsEdit->opening_days==5){?> selected="selected"<?php } ?>>5</option>
                                    <option value="6" <?php if($cafeDetailsEdit->opening_days==6){?> selected="selected"<?php } ?>>6</option>
                                    <option value="7" <?php if($cafeDetailsEdit->opening_days==7){?> selected="selected"<?php } ?>>7</option>
                                </select>
			 </div>

			 <div class="clearfix"> </div>

			 <div class="form-group col-md-6">
					<input type="button" class="1st_step" value="<< Terug " />
			  </div>

			 <div class="form-group col-md-6">
        			<input type="button" class="3rd_step" value="Volgende >>" />
			  </div>

		</div>


		<div id="third_form"  style="display:none">

                    <div class="form-group col-md-6">
                        <label for="email">Maandelijkse bezoekers:</label>
                        <select class="form-control" id="company_monthly_visitors" name="company_monthly_visitors">
                            <option value="1000" <?php if($cafeDetailsEdit->company_monthly_visitors=="1000"){?>selected<?php } ?>>1000</option>
                            <option value="1500" <?php if($cafeDetailsEdit->company_monthly_visitors=="1500"){?>selected<?php } ?>>1500</option>
                            <option value="2000" <?php if($cafeDetailsEdit->company_monthly_visitors=="2000"){?>selected<?php } ?>>2000</option>
                            <option value="3000" <?php if($cafeDetailsEdit->company_monthly_visitors=="3000"){?>selected<?php } ?>>3000</option>
                            <option value="4000" <?php if($cafeDetailsEdit->company_monthly_visitors=="4000"){?>selected<?php } ?>>4000</option>
                            <option value="5000" <?php if($cafeDetailsEdit->company_monthly_visitors=="5000"){?>selected<?php } ?>>5000</option>
                            <option value="6000" <?php if($cafeDetailsEdit->company_monthly_visitors=="6000"){?>selected<?php } ?>>6000</option>
                            <option value="7000" <?php if($cafeDetailsEdit->company_monthly_visitors=="7000"){?>selected<?php } ?>>7000</option>
                            <option value="8000" <?php if($cafeDetailsEdit->company_monthly_visitors=="8000"){?>selected<?php } ?>>8000</option>
                            <option value="9000" <?php if($cafeDetailsEdit->company_monthly_visitors=="9000"){?>selected<?php } ?>>9000</option>
                            <option value="10000" <?php if($cafeDetailsEdit->company_monthly_visitors=="10000"){?>selected<?php } ?>>10000</option>
                            <option value="12000" <?php if($cafeDetailsEdit->company_monthly_visitors=="12000"){?>selected<?php } ?>>12000</option>
                            <option value="14000" <?php if($cafeDetailsEdit->company_monthly_visitors=="14000"){?>selected<?php } ?>>14000</option>
                            <option value="16000" <?php if($cafeDetailsEdit->company_monthly_visitors=="16000"){?>selected<?php } ?>>16000</option>
                            <option value="18000" <?php if($cafeDetailsEdit->company_monthly_visitors=="18000"){?>selected<?php } ?>>18000</option>
                            <option value="20000" <?php if($cafeDetailsEdit->company_monthly_visitors=="20000"){?>selected<?php } ?>>20000</option>
                            <option value="25000" <?php if($cafeDetailsEdit->company_monthly_visitors=="25000"){?>selected<?php } ?>>25000</option>
                            <option value="30000" <?php if($cafeDetailsEdit->company_monthly_visitors=="30000"){?>selected<?php } ?>>30000</option>
                            <option value="35000" <?php if($cafeDetailsEdit->company_monthly_visitors=="35500"){?>selected<?php } ?>>35000</option>                                
                            <option value="40000" <?php if($cafeDetailsEdit->company_monthly_visitors=="40000"){?>selected<?php } ?>>>40000 </option>
                        </select>
                    </div>

		<div class="form-group col-md-6">

                    <label for="email">Aantal bierviltjes per maand:</label>
                    <select class="form-control" id="company_beer_mats" name="company_beer_mats">
                        <option value="250" <?php if($cafeDetailsEdit->company_beer_mats=="250"){?>selected<?php } ?>>250</option>
                        <option value="500" <?php if($cafeDetailsEdit->company_beer_mats=="500"){?>selected<?php } ?>>500 - 750</option>
                        <option value="750" <?php if($cafeDetailsEdit->company_beer_mats=="750"){?>selected<?php } ?>>750 - 1.000</option>
                        <option value="1000" <?php if($cafeDetailsEdit->company_beer_mats=="1000"){?>selected<?php } ?>>1.000 - 1.500</option>
                        <option value="1500" <?php if($cafeDetailsEdit->company_beer_mats=="1500"){?>selected<?php } ?>>1.500 - 2.000</option>
                        <option value="2000" <?php if($cafeDetailsEdit->company_beer_mats=="2000"){?>selected<?php } ?>>2.000 - 2.500</option>
                        <option value="2500" <?php if($cafeDetailsEdit->company_beer_mats=="2500"){?>selected<?php } ?>>2.500 - 5.000</option>
                        <option value="5000" <?php if($cafeDetailsEdit->company_beer_mats=="5000"){?>selected<?php } ?>>5.000 - 7.500</option>
                        <option value="7500" <?php if($cafeDetailsEdit->company_beer_mats=="7500"){?>selected<?php } ?>>7.500 - 10.000</option>
                        <option value="10000" <?php if($cafeDetailsEdit->company_beer_mats=="10000"){?>selected<?php } ?>>10.000 - 15.000</option>
                        <option value="15000" <?php if($cafeDetailsEdit->company_beer_mats=="15000"){?>selected<?php } ?>>15.000 - 20.000</option>
                        <option value="20000" <?php if($cafeDetailsEdit->company_beer_mats=="20000"){?>selected<?php } ?>>20.000 - 25.000</option>
                        <option value="25000" <?php if($cafeDetailsEdit->company_beer_mats=="25000"){?>selected<?php } ?>>25.000+</option>
                    </select>

		</div>
		
                <div class="form-group col-md-6">
                    <label for="email">Start Viltcampagne:</label>
                    <input type="date" name="start_period" class="form-control" value="<?=$cafeDetailsEdit->start_period?>"  />
                </div>
        
                <div class="form-group col-md-6">
                    <label for="email">Einde Viltcampagne</label>
                    <input type="date" name="end_period" class="form-control"  value="<?=$cafeDetailsEdit->end_period?>"  />
                </div>
		
                <div class="clearfix"> </div>
		
                <div class="form-group col-md-6">
                    <input type="button" class="2nd_step" value="<<Terug" />
		</div>

		<div class="form-group col-md-6">
			<input type="submit" name="update" value="Update" id="update" />
		</div>

		</div>

		 

		</form> 

	</div>

	<?php }?>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
$(document).ready(function () {

	$( "#submit" ).click(function(e) {
		$( "#frm" ).submit();
	});

	$( "#update" ).click(function(e) {
                console.log("now submitting the upodate form");
		$( "#frm_update" ).submit();
	});


	$( ".1st_step" ).click(function() {
		$( "#first_form" ).show();
		$( "#sec_form" ).hide();
		$( "#third_form" ).hide();
	});

	$( ".2nd_step" ).click(function() {
		$( "#first_form" ).hide();
		$( "#sec_form" ).show();
		$( "#third_form" ).hide();
	});

	$( ".3rd_step" ).click(function() {
		$( "#first_form" ).hide();
		$( "#sec_form" ).hide();
		$( "#third_form" ).show();
	});

    $( "#addNew" ).click(function(e) {
		$( "#list" ).hide();
		$( "#form" ).show();
	});

});
</script>