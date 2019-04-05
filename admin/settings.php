<?php

    ob_start();

    ob_clean();

    error_reporting(0);

    global $wpdb;

    $row = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."aa_settings" );



    if(isset($_POST['update']))

    {

	global $wpdb;

	$admin_email=$_POST['admin_email'];

	$derate_6_months=$_POST['derate_6_months'];

	$derate_9_months=$_POST['derate_9_months'];

	$derate_12_months=$_POST['derate_12_months'];

	$algemene_voorwaarden=$_POST['algemene_voorwaarden'];

	$privacy = $_POST['privacy'];
	
	
	$checkPost = $wpdb->get_var("SELECT count(*) from ".$wpdb->prefix."aa_settings");
	
	
    if($checkPost>=1)
    {
        $sql = "UPDATE  ".$wpdb->prefix."aa_settings SET admin_email='".$admin_email."', derate_6_months='".$derate_6_months."', derate_9_months='".$derate_9_months."', derate_12_months='".$derate_12_months."', algemene_voorwaarden='".$algemene_voorwaarden."', privacy='".$privacy."'  WHERE id='1'";
		
    }
    else
    {
		$sql = $wpdb->prepare("INSERT INTO ".$wpdb->prefix."aa_settings 		(`admin_email`,`derate_6_months`,`derate_9_months`,`derate_12_months`,`algemene_voorwaarden`,`privacy`)
		VALUES ( %s, %f, %f, %f, %s, %s )", 
        array($admin_email,$derate_6_months,$derate_9_months,$derate_12_months,$algemene_voorwaarden,$privacy));
		

    }
	

                

	

        if($wpdb->query($sql))

        {

            write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql);

        }

        else

        {

            write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql);

        }        

		echo '<script type="text/javascript">location.href = "admin.php?page=settings";</script>';

        exit;

    }	

    ?>

	

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />


	 <div class="wrap">

        <h2>Settings</h2>

        <div class="tablenav top wp-core-ui">

            <input type="button" id="edit" value="Edit Settings" class="button" />

            <br class="clear">

        </div>

		

        <table class='wp-list-table widefat fixed striped posts customTableWs' id="list">

            <tr>

                <th class="manage-column ss-list-width">Admin Email</th>

                <td class="manage-column ss-list-width"><?php echo $row->admin_email; ?></td>

            </tr>

            

            <tr>

                <th class="manage-column ss-list-width">6 maanden kortingstarief</th>

                <td class="manage-column ss-list-width"><?php echo $row->derate_6_months; ?></td>

            </tr>



            <tr>

                <th class="manage-column ss-list-width">9 maanden kortingstarief</th>

                <td class="manage-column ss-list-width"><?php echo $row->derate_9_months; ?></td>

            </tr>

            

            <tr>

                <th class="manage-column ss-list-width">12 maanden kortingstarief</th>

                <td class="manage-column ss-list-width"><?php echo $row->derate_12_months; ?></td>

            </tr>

            

            <tr>

                <th class="manage-column ss-list-width">Algemene Voorwaarden</th>

                <td class="manage-column ss-list-width"><?php echo $row->algemene_voorwaarden; ?></td>

            </tr>

            

             <tr>

                <th class="manage-column ss-list-width">Privacy</th>

                <td class="manage-column ss-list-width"><?php echo $row->privacy; ?></td>

            </tr>



            

            

	</table>

		

		

	<div class="row wp-core-ui" id="form" style="display:none">

            <form method="post" id="frm" enctype="multipart/form-data">

		<div id="first_form">

                    

			<div class="form-group col-md-6">

				<label for="admin_email">Admin Email</label>

				<input type="text" class="form-control" id="admin_email" name="admin_email" value="<?php echo $row->admin_email; ?>">

			</div>

			

			

			<div class="form-group col-md-6">

				<label for="derate_6_months">6 maanden kortingstarief</label>

				<input type="text" class="form-control" id="derate_6_months" name="derate_6_months" value="<?php echo $row->derate_6_months; ?>">

			</div>



                        <div class="form-group col-md-6">

				<label for="derate_9_months">9 maanden kortingstarief</label>

				<input type="text" class="form-control" id="derate_9_months" name="derate_9_months" value="<?php echo $row->derate_9_months; ?>">

			</div>

                    

                        <div class="form-group col-md-6">

				<label for="derate_12_months">12 maanden kortingstarief</label>

				<input type="text" class="form-control" id="derate_12_months" name="derate_12_months" value="<?php echo $row->derate_12_months; ?>">

			</div>

			 

            <div class="form-group col-md-12">

                <label for="algemene_voorwaarden">Algemene Voorwaarden</label>

    <!--<textarea type="text" cols="140" rows="120"   class="form-control" id="algemene_voorwaarden" name="algemene_voorwaarden" value="<?php echo $row->algemene_voorwaarden; ?>">-->

                    <textarea class="form-control" id="algemene_voorwaarden" name="algemene_voorwaarden" rows="30"><?php echo $row->algemene_voorwaarden; ?></textarea>

</div>            



			<div class="form-group col-md-12">

                <label for="algemene_voorwaarden">Privacy</label>

    

                    <textarea class="form-control" id="privacy" name="privacy" rows="30"><?php echo $row->privacy; ?></textarea>

</div>                    

                    

       

			<div class="clearfix">&nbsp;</div>

                        

			<div class="form-group col-md-6">

					<input type="button" id="cancel" value="Cancel" class="button" />

			</div>

                        

			<div class="form-group col-md-6">

				<input type="submit" name="update" value="Update" id="update" class="button button-primary button-large" />

			</div>

		</div>	 

            </form> 

	</div>

	

	

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>



$(document).ready(function () {

	/*$( "#update" ).click(function(e) {

		

		$( "#frm" ).submit();

	});*/

	

    $( "#edit" ).click(function(e) {

		$( "#list" ).hide();

		$( "#form" ).show();

		

	});

	$( "#cancel" ).click(function(e) {

		$( "#list" ).show();

		$( "#form" ).hide();

		

	});

});

</script>