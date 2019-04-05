<?php

    ob_start();

	//ob_clean();

	error_reporting(0);

	global $wpdb;


//if($_REQUEST['del'] = "delrow") {

	//global $wpdb;

	/* $delid=$_REQUEST["delid"];;

	//Print_r($delid);

	$sqldel = "DELETE FROM aa_advertisers WHERE company_id='".$delid."'";

	//$Dadvertisers = $wpdb->query($sqldel);

	if ($Dadvertisers) {

		echo '<div class="" style="color:#2d9e2f;font-size: 23px;font-weight: 400;margin: 0;padding: 9px 0 4px;line-height: 29px;"> Succesvol Verwijderd...</div>'; ?>

		<a href="admin.php?page=advertisers" id=""> Advertisers List </a>

	<?php

	}  */

//}


if($_REQUEST['id']){

	$advertisersDetailsEdit = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."aa_advertisers WHERE company_id='".$_REQUEST['id']."'" );

}



if(isset($_POST['update']))

{

	global $wpdb;

	//$company_city=$_POST['company_city'];

	$company_name=$_POST['company_name'];

	$contact_person=$_POST['contact_person'];

	$contact_email=$_POST['contact_email'];

	$contact_phone=$_POST['contact_phone'];

	$table_name=$wpdb->prefix."aa_advertisers";

	$sql = "UPDATE $table_name SET company_name='".$company_name."', contact_person='".$contact_person."', contact_email='".$contact_email."', contact_phone='".$contact_phone."' WHERE company_id='".$_REQUEST['id']."'";

	$Uadvertisers = $wpdb->query($sql);



	if ($Uadvertisers) { ?>

		<div class="wrap">

			<div class="" style="color:#2d9e2f;font-size: 23px;font-weight: 400;margin: 0;padding: 9px 0 4px;line-height: 29px;">Succesvol geüpdatet...</div> 

			<div class="tablenav top">

				<div class="alignleft actions">

					<a href="admin.php?page=advertisers" id="" style="color: #337ab7;text-decoration: none;font-size:14px;line-height:1.42857143;"> Advertisers List </a>

				</div>

				<br class="clear">

			</div>

		</div>

		<?php	exit();

	}

}





$advertisersDetails = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."aa_advertisers" );

    ?>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />


	 <div class="wrap">

        <h2>Informatie Adverteerders</h2>

        <div class="tablenav top">



            <div class="alignleft actions">



                <!--<a href="<?php echo admin_url('admin.php?page=sinetiks_schools_create'); ?>">Add New</a>-->



				<a href="admin.php?page=advertisers" id=""> Overzicht adverteerders </a>



            </div>



            <br class="clear">



        </div>



		<?php if(!$_REQUEST['id']){?>



	<table class='wp-list-table widefat fixed striped posts' id="list">

            <tr>

                <th class="manage-column ss-list-width">ID</th>

                <th class="manage-column ss-list-width">Company Name</th>

                <th class="manage-column ss-list-width">Contact Person</th>

                <th class="manage-column ss-list-width">Contact Phone</th>

                <th class="manage-column ss-list-width">Contact Email</th>

                <th class="manage-column ss-list-width"></th>

                <th class="manage-column ss-list-width"></th>

                <th class="manage-column ss-list-width"></th>

            </tr>



	<?php foreach($advertisersDetails as $advertisers){ ?>

            <tr>

                <td class="manage-column ss-list-width"><?php echo $advertisers->company_id;?></td>

                <td class="manage-column ss-list-width"><?php echo $advertisers->company_name;?></td>

                <td class="manage-column ss-list-width"><?php echo $advertisers->contact_person;?></td>

                <td class="manage-column ss-list-width"><?php echo $advertisers->contact_phone;?></td>

                <td class="manage-column ss-list-width"><?php echo $advertisers->contact_email;?></td>

                <td class="manage-column ss-list-width"><a href="admin.php?page=advertisers&id=<?php echo $advertisers->company_id;?>"><input type="submit" class="delete" value=" Edit "/></a></td>

                <!--<td class="manage-column ss-list-width"><a href="admin.php?page=advertisers&type=view&id=<?php echo $advertisers->company_id;?>"><input type="submit" class="delete" value=" View "/></a></td>-->

                <td class="manage-column ss-list-width">

		<form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">

        		<?php  wp_nonce_field( 'my_delete_event' ); ?>

			<input type="hidden" name="action" value="my_delete_event">

        		<input type="hidden" name="eventid" value="<?php echo $advertisers->company_id; ?> ">

			<input type="submit" class="delete" value="Delete" style="color:#ea3c3c;"/>

		</form></td>

            </tr>

        <?php }

   //ob_clean();?> 

	</table>

    </div>



    

    <?php

	}



   //ob_clean();

    ?> 



	<!----- FOR EDIT ----->

	<?php if($_REQUEST['id'] && $_REQUEST['type']!="view" ) { ?>

	<div class="row" id="uform">

	<div class="form-group col-md-6">

            <form method="post" id="frm_update" enctype="multipart/form-data">



		 <div class="form-group col-md-12">

                    <label for="email">Bedrijf</label>

                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $advertisersDetailsEdit->company_name;?>">

		 </div>



			 <div class="form-group col-md-12">

				<label for="email">Contactpersoon</label>

				<input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo $advertisersDetailsEdit->contact_person;?>">

			 </div>



			 <div class="form-group col-md-12">



				<label for="email">Contact telefoon</label>



				<input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo $advertisersDetailsEdit->contact_phone;?>">



			 </div>



			 <div class="form-group col-md-12">



				<label for="email">Contact Email:</label>



				<input type="text" class="form-control" id="contact_email" name="contact_email" value="<?php echo $advertisersDetailsEdit->contact_email;?>">



			 </div>



			 <div class="form-group col-md-12">



				<input type="submit" name="update" value="Update" id="updatebtn" />



			 </div>



		</form>



		</div>



	</div>



	<?php }?>

    

    <?php if($_REQUEST['id'] && $_REQUEST['type']=="view" ) { ?>



        <div class="row" id="uform">



            <div class="form-group col-md-6">



		<form method="post" id="frm_update" enctype="multipart/form-data">

		

                    <div class="form-group col-md-12">

                        <label for="email">Adverteerder</label>

                        <span><?php echo $advertisersDetailsEdit->company_name;?></span>

                    </div>



                    <div class="form-group col-md-12">

                        <label for="email">Contactpersoon</label>

                        <span><?php echo $advertisersDetailsEdit->contact_person;?></span>

                    </div>



                    <div class="form-group col-md-12">

                        <label for="email">Telefoon</label>

			<span><?php echo $advertisersDetailsEdit->contact_phone;?></span>

                    </div>



			 <div class="form-group col-md-12">



				<label for="email">Contact Email:</label>



				<span><?php echo $advertisersDetailsEdit->contact_email;?></span>



			 </div>

             

             <div class="form-group col-md-12">



				<label for="email">Selected Cafe</label>



				<span><?php 

				//echo $advertisersDetailsEdit->selectedCafe;

				$arrData=unserialize($advertisersDetailsEdit->selectedCafe);

				

				?>

                <table>

                	<tr>

                    	<td>Cafe</td>

                        <td>Visitor</td>

                        <td>Price</td>

                    </tr>

                    <?php foreach($arrData as $data){ ?>

                    <tr>

                    	<td><?php echo $data['cafe_name']; ?></td>

                        <td><?php echo $data['visitor']; ?></td>

                        <td><?php echo $data['price']; ?></td>

                    </tr>

                    <?php } ?>

                </table>

                

                </span>



			 </div>



			 <div class="form-group col-md-12">
				<label for="email">Reservation Period and Cost</label>
				<span>Total price based on <?php echo $advertisersDetailsEdit->period_reservation;?> months period reservation : <?php echo $advertisersDetailsEdit->period_reservation_cost;?></span>



			 </div>
		</form>
		</div>
	</div>
	<?php }?>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>
$(document).ready(function () {

	$( "#submit" ).click(function(e) {

		if(i==0){

			 $( "#frm" ).submit();
		}
		$( "#frm" ).submit();
	});



	$( "#company_name" ).focusout(function() {
		$.ajax({

			type   : "POST",
			url    : "<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php",
			data   : {action: 'getmapapi',company_name: $("#company_name" ).val()}, 
			success: function (data){

				if(data!="0"){

					var arrData=data.split('~');

					$( "#company_house_no" ).val(arrData[0]);

					$( "#company_street" ).val(arrData[1]);

        				$( "#company_state" ).val(arrData[3]);

					$( "#company_country" ).val(arrData[4]);

					$( "#company_zip" ).val(arrData[5]);

				}else{

					$( "#company_house_no" ).val("");

					$( "#company_street" ).val("");

					$( "#company_state" ).val("");

					$( "#company_country" ).val("");

					$( "#company_zip" ).val("");

				}

			}

		});	

	});		

});

</script>