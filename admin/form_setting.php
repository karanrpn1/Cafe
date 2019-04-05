<?php

	ob_start();

    ob_clean();

    // Disable all errors

    //error_reporting(0);

    // Report all PHP errors

    //error_reporting(-1);

    global $wpdb;

	

function uploadImage($name) {

	if ( ! function_exists( 'wp_handle_upload' ) ) {

	require_once( ABSPATH . 'wp-admin/includes/file.php' );

	}

	$uploadedfile = $_FILES[$name];

	$upload_overrides = array( 'test_form' => false );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

	

	if ( $movefile && ! isset( $movefile['error'] ) ) {

		//var_dump( $movefile );

		$file =$movefile['url'];

		$new_file_path=$movefile['file'];

		$new_file_mime=$movefile['type'];

		$upload_id = wp_insert_attachment( array(

			'guid'           => $new_file_path, 

			'post_mime_type' => $new_file_mime,

			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename($file)),

			'post_content'   => '',

			'post_status'    => 'inherit'

		), $new_file_path );

		require_once(ABSPATH . 'wp-admin/includes/image.php');

		$attach_data = wp_generate_attachment_metadata($upload_id,$new_file_path);

		wp_update_attachment_metadata($upload_id,$attach_data);

		

		return $upload_id;

	}

}



	if(isset($_POST['update_form_data'])){

		

		$Atext1 = $_POST['advert-text-sec-1'];

		$Atext2 = $_POST['advert-text-sec-2'];

		$Atext3 = $_POST['advert-text-sec-3'];

		$Mtext1 = $_POST['map-text-sec-1'];

		$Mtext2 = $_POST['map-text-sec-2'];

		$Mtext3 = $_POST['map-text-sec-3'];

		

		$imgId1 = uploadImage('advert-photo-sec-1');

		if($imgId1 !=''){

			update_option('advert-photo-sec-1',$imgId1);

		}

		

		$imgId2 = uploadImage('advert-photo-sec-2');

		if($imgId2 !=''){

			update_option('advert-photo-sec-2',$imgId2);

		}

		

		$imgId3 = uploadImage('advert-photo-sec-3');

		if($imgId3 !=''){

			update_option('advert-photo-sec-3',$imgId3);

		}

		

		$imgId4 = uploadImage('map-photo-sec-1');

		if($imgId4 !=''){

			update_option('map-photo-sec-1',$imgId4);

		}

		

		$imgId5 = uploadImage('map-photo-sec-2');

		if($imgId5 !=''){

			update_option('map-photo-sec-2',$imgId5);

		}

		

		$imgId6 = uploadImage('map-photo-sec-3');

		if($imgId6 !=''){

			update_option('map-photo-sec-3',$imgId6);

		}

		

		update_option('advert-text-sec-1',$Atext1);

		update_option('advert-text-sec-2',$Atext2);

		update_option('advert-text-sec-3',$Atext3);

		update_option('map-text-sec-1',$Mtext1);

		update_option('map-text-sec-2',$Mtext2);

		update_option('map-text-sec-3',$Mtext3);

		

	}

	

	$text1=stripslashes(get_option('advert-text-sec-1'));

	$text2=stripslashes(get_option('advert-text-sec-2'));

	$text3=stripslashes(get_option('advert-text-sec-3'));

	$text4=stripslashes(get_option('map-text-sec-1'));

	$text5=stripslashes(get_option('map-text-sec-2'));

	$text6=stripslashes(get_option('map-text-sec-3'));

?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />


<style>

.wp-admin input[type=file] {

	padding: 6px 12px;

	cursor: pointer;

}

#blah1, #blah2,#blah3, #blah4, #blah5, #blah6{

	padding:10px;

}

img{

	max-width: 260px !important;	

}

h2{

	font-weight:500 !important;

	text-align:center;

	text-decoration:underline;	

}

h1{

	font-weight:bold !important;

}



</style>

<form action="" method="post" enctype="multipart/form-data">

  <div class="wrap">

  	<h1>Form Setting</h1>

  	<div class="tablenav top"> <br class="clear">

    </div>

    <h2>Adverteerders</h2>

    <div class="tablenav top"> <br class="clear">

    </div>

    <div class="row">

      <div class="col-md-6">

        <h4>Text Section 1</h4>

        <?php $settings = array(

							'textarea_rows' => 8,

					  );

 					  $editor_id = 'advert-text-sec-1';

 					  echo wp_editor( $text1, $editor_id, $settings); 

				?>

      </div>

      <div class="col-md-6">

        <h4>Photo Section 1</h4>

        <input type="file" name="advert-photo-sec-1" data-id="blah1" class="ImgInp form-control" />

        <div id="blah1">

        	<?php if(get_option('advert-photo-sec-1') !=''){ ?><img class="img-responsive" src="<?=wp_get_attachment_url( get_option('advert-photo-sec-1') );?>"><?php } ?>

        </div>

      </div>

    </div>

    <hr>

    <div class="tablenav top"> <br class="clear">

    </div>

    <div class="row">

      <div class="col-md-6">

        <h4>Text Section 2</h4>

        <?php $editor_id = 'advert-text-sec-2';

			  echo wp_editor( $text2, $editor_id, $settings); 

		?>

      </div>

      <div class="col-md-6">

        <h4>Photo Section 2</h4>

        <input type="file" name="advert-photo-sec-2" data-id="blah2" class="ImgInp form-control" />

        <div id="blah2">

        	<?php if(get_option('advert-photo-sec-2') !=''){ ?><img class="img-responsive" src="<?=wp_get_attachment_url( get_option('advert-photo-sec-2') );?>"><?php } ?>

        </div>

      </div>

    </div>

    <hr>

    <div class="tablenav top"> <br class="clear">

    </div>

    <div class="row">

      <div class="col-md-6">

        <h4>Text Section 3</h4>

        <?php $editor_id = 'advert-text-sec-3';

			  echo wp_editor( $text3, $editor_id, $settings); 

		?>

      </div>

      <div class="col-md-6">

        <h4>Photo Section 3</h4>

        <input type="file" name="advert-photo-sec-3" data-id="blah3" class="ImgInp form-control" />

        <div id="blah3">

        	<?php if(get_option('advert-photo-sec-3') !=''){ ?><img class="img-responsive" src="<?=wp_get_attachment_url( get_option('advert-photo-sec-3') );?>"><?php } ?>

        </div>

      </div>

    </div>

  </div>

  <hr>

  <div class="wrap">

    <h2>Map</h2>

    <hr>

    <div class="tablenav top"> <br class="clear">

    </div>

    <div class="row">

      <div class="col-md-6">

        <h4>Text Section 1</h4>

        <?php $editor_id = 'map-text-sec-1';

			  echo wp_editor( $text4, $editor_id, $settings); 

		?>

      </div>

      <div class="col-md-6">

        <h4>Photo Section 1</h4>

        <input type="file" name="map-photo-sec-1" data-id="blah4" class="ImgInp form-control" />

        <div id="blah4">

        	<?php if(get_option('map-photo-sec-1') !=''){ ?><img class="img-responsive" src="<?=wp_get_attachment_url( get_option('map-photo-sec-1') );?>"><?php } ?>

        </div>

      </div>

    </div>

    <hr>

    <div class="tablenav top"> <br class="clear">

    </div>

    <div class="row">

      <div class="col-md-6">

        <h4>Text Section 2</h4>

        <?php $editor_id = 'map-text-sec-2';

			  echo wp_editor( $text5, $editor_id, $settings); 

		?>

      </div>

      <div class="col-md-6">

        <h4>Photo Section 2</h4>

        <input type="file" name="map-photo-sec-2" data-id="blah5" class="ImgInp form-control" />

        <div id="blah5">

        	<?php if(get_option('map-photo-sec-2') !=''){ ?><img class="img-responsive" src="<?=wp_get_attachment_url( get_option('map-photo-sec-2') );?>"><?php } ?>

        </div>

      </div>

    </div>

    <hr>

    <div class="tablenav top"> <br class="clear">

    </div>

    <div class="row">

      <div class="col-md-6">

        <h4>Text Section 3</h4>

        <?php $editor_id = 'map-text-sec-3';

			  echo wp_editor( $text6, $editor_id, $settings); 

		?>

      </div>

      <div class="col-md-6">

        <h4>Photo Section 3</h4>

        <input type="file" name="map-photo-sec-3" data-id="blah6" class="ImgInp form-control" />

        <div id="blah6">

        	<?php if(get_option('map-photo-sec-3') !=''){ ?><img class="img-responsive" src="<?=wp_get_attachment_url( get_option('map-photo-sec-3') );?>"><?php } ?>

        </div>

      </div>

    </div>

  </div>

  <div class="tablenav top"> <br class="clear">

  </div>

  <div class="wrap">

    <div class="col-md-12">

      <input type="submit" name="update_form_data" class="btn btn-danger" value="Update">

    </div>

  </div>

</form>

<script>

function readURL(input) {

	var ID = jQuery(input).attr('data-id');

	//alert(ID);

	if (input.files && input.files[0]) {

    var reader = new FileReader();



    reader.onload = function(e) {

		//alert(e.target.result);

      jQuery('#'+ID).html('<img src="'+e.target.result+'"/>');

    }



    reader.readAsDataURL(input.files[0]);

  }

}



jQuery(".ImgInp").change(function() {

	readURL(this);

});

</script>