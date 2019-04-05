<?php

    ob_start();

    ob_clean();

    error_reporting(0);

    global $wpdb;

    $priceDetails = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."aa_prices ORDER BY visitors_per_month" );

    

    if(isset($_REQUEST['id']))

    {

        $row = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."aa_prices WHERE id='".$_REQUEST['id']."'" );

    }



    if(isset($_POST['submit']))

    {

	global $wpdb;

	$visitors_per_month=$_POST['visitors_per_month'];

	$sale_price_per_month=$_POST['sale_price_per_month'];

	$sql =  $sql="INSERT INTO ".$wpdb->prefix."aa_prices (`id`,`visitors_per_month`, `sale_price_per_month`) values ('','".$visitors_per_month."','".$sale_price_per_month."')";

        if($wpdb->query($sql))

        {

            write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql);

        }

        else

        {

            write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql);

        }

	echo '<script type="text/javascript">location.href = "admin.php?page=prices";</script>';

        exit;

     }



     if(isset($_POST['update']))

     {

	global $wpdb;

	$visitors_per_month=$_POST['visitors_per_month'];

	$costs=$_POST['costs'];

	$sale_price_per_month=$_POST['sale_price_per_month'];

	$sql = "UPDATE  ".$wpdb->prefix."aa_prices SET visitors_per_month='".$visitors_per_month."', sale_price_per_month='".$sale_price_per_month."' WHERE id='".$_REQUEST['id']."'";

        if($wpdb->query($sql))

        {

            write_log(date("Y-m-d_His__").'[BACK END] -> Successfully executed the UPDATE SQL: '.$sql);

        }

        else

        {

            write_log(date("Y-m-d_His__").'[BACK END] -> Error after extecuting UPDATE SQL: '.$sql);

        }	

	echo '<script type="text/javascript">location.href = "admin.php?page=prices";</script>';

        exit;

    }	



    ?>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />


	 <div class="wrap">

        <h2>Prices</h2>

        <div class="tablenav top">

            <input type="button" id="add" value="Add" />

            <br class="clear">

        </div>

		

	<?php if(!$_REQUEST['id']){?>

	<table class='wp-list-table widefat fixed striped posts' id="list">

            <tr>

                <th class="manage-column ss-list-width">id</th>

                <th class="manage-column ss-list-width">Bezoekers per maand</th>

		<th class="manage-column ss-list-width">Prijs per maand</th>

                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

            </tr>

            <?php foreach($priceDetails as $price){?>

            <tr>

                <td class="manage-column ss-list-width"><?php echo $price->id; ?></td>

                <td class="manage-column ss-list-width"><?php echo $price->visitors_per_month;?></td>

		<td class="manage-column ss-list-width"><?php echo $price->sale_price_per_month;?></td>

                <td class="manage-column ss-list-width"><a href="admin.php?page=prices&id=<?php echo $price->id;?>"><input type="submit" class="delete" value=" Edit "/></a></td>

                <!--<td class="manage-column ss-list-width"><a href="admin.php?page=prices&id=<?php echo $price->id;?>"> Edit </a></td>-->

                <td class="manage-column ss-list-width">

                    <form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">

        		<?php  wp_nonce_field( 'my_delete_event_price' ); ?>

			<input type="hidden" name="action" value="my_delete_event_price">

        		<input type="hidden" name="eventid" value="<?php echo $price->id; ?> ">

			<input type="submit" class="delete" value="Delete" style="color:#ea3c3c;"/>

		</form></td>

            </tr>

	    <?php

		}

		   //ob_clean();

            ?> 

	</table>

		<?php } ?>

		

	<div class="row" id="form" style="display:none">

            <form method="post" id="frm" enctype="multipart/form-data">

                <div id="first_form">



                    <div class="form-group col-md-6">

                        <label for="email">Visitors per month</label>

                        <input type="text" class="form-control" id="visitors_per_month" name="visitors_per_month" >

                    </div>



                    <div class="form-group col-md-6">

                        <label for="email">Sale price/per_month</label>

                        <input type="text" class="form-control" id="sale_price_per_month" name="sale_price_per_month" >

                    </div>



                    <div class="clearfix">&nbsp;</div>

                    

                    <div class="form-group col-md-6">

                        <input type="button" id="cancel" value="Cancel" />

                     </div>

                    <div class="form-group col-md-6">

                        <input type="submit" name="submit" value="Add" id="submit" />

                    </div>

                </div>	 

		 

		

            </form> 

	</div>

	

        <?php if($_REQUEST['id']){?>

	<div class="row"  >

            <form method="post" id="frm" enctype="multipart/form-data">

                <div id="first_form">



                    <div class="form-group col-md-6">

                        <label for="email">Bezoekers per maand</label>

                        <input type="text" class="form-control" id="visitors_per_month" name="visitors_per_month" value="<?php echo $row->visitors_per_month; ?>">

                    </div>



                     <div class="form-group col-md-6">

                           <label for="email">Prijs per maand</label>

                           <input type="text" class="form-control" id="sale_price_per_month" name="sale_price_per_month" value="<?php echo $row->sale_price_per_month; ?>">

                    </div>



                    <div class="clearfix">&nbsp;</div>

                    

                    <div class="form-group col-md-6">

                        <input type="button" id="cancel" value="Cancel" />

                    </div>

                    

                    <div class="form-group col-md-6">

                           <input type="submit" name="update" value="Update" id="update" />

                    </div>

                </div>	 

            </form> 

	</div>

<?php } ?>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>



$(document).ready(function () {

	/*$( "#update" ).click(function(e) {

		

		$( "#frm" ).submit();

	});*/

	

    $( "#add" ).click(function(e) {

		$( "#list" ).hide();

		$( "#form" ).show();

		

	});

	$( "#cancel" ).click(function(e) {

		$( "#list" ).show();

		$( "#form" ).hide();

		

	});

});

</script>