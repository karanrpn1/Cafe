<?php

define('ROOTDIR', plugin_dir_path(__FILE__));

function sinetiks_schools_modifymenu(){

	//this is the main item for the menu

	add_menu_page('Cafe', //page title

		'Cafe', //menu title

		'manage_options', //capabilities

		'cafe_list', //menu slug

		'cafe_list' //function

	);

	

	//this is a submenu

	add_submenu_page('cafe_list', //parent slug

		'Advertiser', //page title

		'Advertiser', //menu title

		'manage_options', //capability

		'advertisers', //menu slug

		'advertisers'

	);

	

	add_submenu_page('cafe_list', //parent slug

		'Settings', //page title

		'Settings', //menu title

		'manage_options', //capability

		'settings', //menu slug

		'settings'

	); //function

	

	add_submenu_page('cafe_list', //parent slug

		'Prices', //page title

		'Prices', //menu title

		'manage_options', //capability

		'prices', //menu slug

		'prices'

	); 

	

	add_submenu_page('cafe_list', //parent slug

		'Alle cafes info', //page title

		'Alle gegevens info', //menu title

		'manage_options', //capability

		'all_items', //menu slug

		'all_items'

	); 

	 

	

	add_submenu_page('cafe_list', //parent slug

		'Form Setting', //page title

		'Form Setting', //menu title

		'manage_options', //capability

		'form_setting', //menu slug 

		'form_setting_func'

	); 

}

add_action('admin_menu','sinetiks_schools_modifymenu');



function cafe_list() {require_once CUS_CAFE_PLUGIN_DIR . '/admin/cafe1.php';}



function advertisers() {require_once CUS_CAFE_PLUGIN_DIR . '/admin/advertisers.php';}



function settings() { require_once CUS_CAFE_PLUGIN_DIR . '/admin/settings.php';}



function prices() { require_once CUS_CAFE_PLUGIN_DIR . '/admin/prices.php';}



function all_items() { require_once CUS_CAFE_PLUGIN_DIR . '/admin/all_items.php';}



function form_setting_func() { require_once CUS_CAFE_PLUGIN_DIR . '/admin/form_setting.php';}





add_action( 'admin_post_my_delete_event', function () {

	// Remove the event with specified eventid

	if (!empty($_POST['eventid'])) {

		global $wpdb;

		$event_id = $_POST['eventid'];

		$table = $wpdb->prefix.'aa_advertisers';

		check_admin_referer( 'my_delete_event' );

		$wpdb->delete( $table, [ 'company_id' => $event_id ], [ '%d' ] );

	}

	//Redirect to admin.php?page=advertisers    wp-content/plgins/crud/advertisers.php

	wp_redirect(admin_url('/admin.php?page=advertisers'));

	exit;

});



add_action( 'admin_post_my_delete_event_cafe', function () {

  // Remove the event with specified eventid

	  if (!empty($_POST['eventid'])){

		global $wpdb;

		$event_id = $_POST['eventid'];

		$table = $wpdb->prefix.'aa_cafes';

		check_admin_referer( 'my_delete_event_cafe' );

		$wpdb->delete( $table, [ 'company_id_bm' => $event_id ], [ '%d' ] );

	  }

	  //Redirect to admin.php?page=cafe in backoffice  wp-content/plgins/crud/cafe.php   pay attentention filename is not the same page name

	  wp_redirect(admin_url('/admin.php?page=cafe_list'));

	  exit;

});







add_action( 'admin_post_my_delete_event_price', function () {

	// Remove the event with specified eventid

	if (!empty($_POST['eventid'])){

		global $wpdb;

		$event_id = $_POST['eventid'];

		$table = $wpdb->prefix.'aa_prices';

		check_admin_referer( 'my_delete_event_price' );

		$wpdb->delete( $table, [ 'id' => $event_id ], [ '%d' ] );

	}

	//Redirect to admin.php?page=cafe in backoffice  wp-content/plgins/crud/cafe.php   pay attentention filename is not the same page name

	wp_redirect(admin_url('/admin.php?page=prices'));

	exit;

});

