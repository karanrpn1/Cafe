<?php

    ob_start();

    ob_clean();

    // Disable all errors

    //error_reporting(0);

    // Report all PHP errors

    error_reporting(-1);

    global $wpdb;

    $cafeDetails = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."aa_cafes ORDER BY new_subscription DESC, latlon_ok ASC" );

?>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />


    <div class="wrap">



        <h2>Overzicht Horeca gelegenheden alle info</h2>

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

                <th class="manage-column ss-list-width">Gegevens horezazaak</th>

                <th class="manage-column ss-list-width">Kenmerken horezazaak</th>

                <th class="manage-column ss-list-width">Aantallen</th>

                <th class="manage-column ss-list-width">Bewerken</th>

            </tr>

        

            <?php foreach($cafeDetails as $cafe){?>

            <tr>

                <td class="manage-column ss-list-width">

                        <?php echo $cafe->company_name;?><br />

                        <?php echo $cafe->company_contact_person_name;?><br />

                        <?php echo $cafe->company_contact_phone;?><br />

                        <?php echo $cafe->company_contact_email;?><br /><br />

                        <?php echo $cafe->company_street."  ".$cafe->company_house_no;?><br />

                        <?php echo $cafe->company_zip."  ".$cafe->company_city;?><br />Nederland<br />

                        <?php echo $cafe->company_state."  ".$cafe->company_lon."  ".$cafe->company_lat;?><br />

                </td>

                

                <td class="manage-column ss-list-width">

                        <?php echo 'Type: '.$cafe->company_type;?><br />

                        <?php echo 'Uitgaven: '.$cafe->company_client_expense;?><br />

                        <?php echo 'Openingsdagen: '.$cafe->opening_days;?><br />

                        <?php echo 'Klant leeftijd: '.$cafe->company_client_age;?><br />

                       

                        <?php

                        echo ($cafe->service_lunch=='1' ? ' service_lunch ' : '');

                        echo ($cafe->service_ontbijt=='1' ? ' service_ontbijt ' : '');        

                        echo ($cafe->service_diner=='1' ? ' service_diner ' : '');

                        echo ($cafe->service_borrel=='1' ? ' service_borrel ' : '');        

                        echo ($cafe->service_uitgaan=='1' ? ' service_uitgaan ' : '');

                        echo ($cafe->service_overnachting=='1' ? ' service_overnachting ' : '');   

                        echo "<BR />";

                        echo ($cafe->klant_kinderen=='1' ? ' klant_kinderen ' : '');

                        echo ($cafe->klant_studenten=='1' ? ' klant_studenten ' : '');        

                        echo ($cafe->klant_zakelijk=='1' ? ' klant_zakelijk ' : '');

                        echo ($cafe->klant_familiair=='1' ? ' klant_familiair ' : '');        

                        echo ($cafe->klant_toeristen=='1' ? ' klant_toeristen ' : '');

                        echo ($cafe->klant_stamgasten=='1' ? ' klant_stamgasten ' : '');        

                        ?>

                </td>



                <td class="manage-column ss-list-width">

                        <?php echo 'Maandelijkse bezoekers '.$cafe->company_monthly_visitors;?><br />

                        <?php echo 'Bierviltjes '.$cafe->company_beer_mats;?><br />

                        <?php echo 'Start '.$cafe->start_period;?><br />

                        <?php echo 'Einde '.$cafe->end_period;?><br />

                        <?php //echo $cafe->image_url;?><br />

                        <?php echo $cafe->company_logo;?><br />

                        <img src="<?php echo CUS_CAFE_PLUGIN_URL; ?>/assets/uploads/<?=$cafe->company_logo?>" width="50" />

                </td>

                

                <td class="manage-column ss-list-width">

                    <a href="admin.php?page=cafe_list&id=<?php echo $cafe->company_id_bm;?>"><input type="submit" class="delete" value=" Edit "/></a>

                </td>

            </tr>

            <?php }  //ob_clean();  ?> 

	</table>

	<?php

	}

   //ob_clean();

        ?> 

    </div>



