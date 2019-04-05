<?php 
/*
  Plugin Name: Cafe
  Plugin URI: http://helpfulinsight.in
  Description: Custom cafe management
  Version: 1.0
  Author: helpfulinsight	
  Author URI: http://helpfulinsight.in
*/         
 
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

if (!defined('CUS_CAFE_THEME_DIR')) 
    define('CUS_CAFE_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('CUS_CAFE_PLUGIN_NAME'))
    define('CUS_CAFE_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/')); 

if (!defined('CUS_CAFE_PLUGIN_DIR'))
    define('CUS_CAFE_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . CUS_CAFE_PLUGIN_NAME);		

if (!defined('CUS_CAFE_PLUGIN_URL'))
    define('CUS_CAFE_PLUGIN_URL', WP_PLUGIN_URL . '/' . CUS_CAFE_PLUGIN_NAME);	

if ( ! class_exists( 'cuscafeinit' ) ) {

	class cuscafeinit {

		public function __construct()	{
			// Add styles			

			add_action( 'wp_enqueue_scripts', array($this, 'of_enqueue_styles') );

			add_action( 'admin_enqueue_scripts', array($this, 'of_enqueue_admin_ss') );

		}

		public function of_enqueue_styles()	{				

			wp_enqueue_style( 'cus_cafe_theme_css',plugins_url('/assets/css/plugin-style.css', __FILE__) );

			wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyATwmJTGbgCoJ99DWOnrnR8yenz1tTOFIk&libraries=places', array(), '', true); 

			wp_enqueue_script('googlemaps'); 

			wp_enqueue_style( 'cus_cafe_bootstrap_css',plugins_url('/assets/css/bootstrap.min.css', __FILE__),array('twentyseventeen-style') ); 			

			wp_register_script('cus_cafe_theme_script', plugins_url('/assets/js/plugin-script.js', __FILE__), array('jquery','googlemaps'), '0.5', false ); 

			wp_enqueue_script('cus_cafe_theme_script');

			wp_localize_script( 'cus_cafe_theme_script', 'ajax_order_object', array('ajaxurl' => admin_url( 'admin-ajax.php' ),'thankyoupage' => get_site_url().'/thank-you','siteurl' => get_site_url(),'pluginurl' => CUS_CAFE_PLUGIN_URL ));	

			wp_enqueue_script( 'cus_cafe_bootstrap_script',plugins_url('/assets/js/bootstrap.min.js', __FILE__) ,array( 'jquery' ), '0.5', false);				

		}     

		public function of_enqueue_admin_ss($hook) {			

			wp_enqueue_style( 'cus_cage_admin_style',  plugins_url('/admin/admin-style.css', __FILE__));			

		}		 

	}     

}



if ( class_exists( 'cuscafeinit' ) ) {

	global $cuscafeinit;

	$cuscafeinit	= new cuscafeinit();

}  



class PageTemplater {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	 
	protected $templates;

	/**
	 * Returns an instance of this class. 
	 */

	public static function get_instance() {

		if ( null == self::$instance ) {
		
			self::$instance = new PageTemplater();

		} 

		return self::$instance;
	} 



	/**

	 * Initializes the plugin by setting filters and administration functions.

	 */

	private function __construct() {

		$this->templates = array();

		// Add a filter to the attributes metabox to inject template into the cache.

		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {



			// 4.6 and older

			add_filter(

				'page_attributes_dropdown_pages_args',

				array( $this, 'register_project_templates' )

			);



		} else {

			// Add a filter to the wp 4.7 version attributes metabox

			add_filter(

				'theme_page_templates', array( $this, 'add_new_template' )

			);



		}



		// Add a filter to the save post to inject out template into the page cache

		add_filter(

			'wp_insert_post_data', 

			array( $this, 'register_project_templates' ) 

		);





		// Add a filter to the template include to determine if the page has our 

		// template assigned and return it's path

		add_filter(

			'template_include', 

			array( $this, 'view_project_template') 

		);

		// Add your templates to this array.

		$this->templates = array(

			'first-form.php' => 'First Form',

			'second-form.php' => 'Second Form',

		);

			

	} 


	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */

	public function add_new_template( $posts_templates ) {

		$posts_templates = array_merge( $posts_templates, $this->templates );

		return $posts_templates;

	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */

	public function register_project_templates( $atts ) {
		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list. 

		// If it doesn't exist, or it's empty prepare an array

		$templates = wp_get_theme()->get_page_templates();

		if ( empty( $templates ) ) {

			$templates = array();

		} 

		// New cache, therefore remove the old one

		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates

		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates

		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	} 

	/**
	 * Checks if the template is assigned to the page
	 */

	public function view_project_template( $template ) {		

		// Get global post

		global $post;
		// Return template if post is empty
		if ( ! $post ) {
			return $template;

		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta( 
			$post->ID, '_wp_page_template', true 
		)] ) ) {
			return $template;
		} 



		$file = plugin_dir_path( __FILE__ ). get_post_meta( 
			$post->ID, '_wp_page_template', true
		);
		// Just to be safe, we check if the file exist first

		if ( file_exists( $file ) ) {

			return $file;

		} else {

			echo $file;

		}



		// Return template

		return $template;



	}



} 

add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );







/*--------------------------------------------------
				ADD ADMIN MENU PAGE			
-----------------------------------------------------*/

require_once(CUS_CAFE_PLUGIN_DIR."/admin/admin-data.php");


/*---------------------------------------------------
				GET USER IP 
------------------------------------------------------*/

if (!function_exists('getUserIP')) {

	function getUserIP() {

		$client  = @$_SERVER['HTTP_CLIENT_IP'];

		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];

		$remote  = $_SERVER['REMOTE_ADDR'];		

		if(filter_var($client, FILTER_VALIDATE_IP)){

			$ip = $client;

		}

		elseif(filter_var($forward, FILTER_VALIDATE_IP)){
			$ip = $forward;
		}

		else {

			$ip = $remote;

		}

		return $ip;

	}

}



 /**

 * Logs messages/variables/data to browser console from within php

 *

 * @param $name: message to be shown for optional data/vars

 * @param $data: variable (scalar/mixed) arrays/objects, etc to be logged

 * @param $jsEval: whether to apply JS eval() to arrays/objects

 *

 * @return none

 * @author Sarfraz

 */

if (!function_exists('logConsole')) {

	function logConsole($name, $data = NULL, $jsEval = FALSE) {

		if (! $name) return false;

		

		$isevaled = false;

		$type = ($data || gettype($data)) ? 'Type: ' . gettype($data) : '';

		

		if ($jsEval && (is_array($data) || is_object($data))){

		   $data = 'eval(' . preg_replace('#[\s\r\n\t\0\x0B]+#', '', json_encode($data)) . ')';

		   $isevaled = true;

		}

		else {

		   $data = json_encode($data);

		}	

		# sanitalize

		$data = $data ? $data : '';

		$search_array = array("#'#", '#""#', "#''#", "#\n#", "#\r\n#");

		$replace_array = array('"', '', '', '\\n', '\\n');

		$data = preg_replace($search_array,  $replace_array, $data);

		$data = ltrim(rtrim($data, '"'), '"');

		$data = $isevaled ? $data : ($data[0] === "'") ? $data : "'" . $data . "'";

	} # end logConsole

}

/*----------------------------------------------------
		CREATE TABLES ON PLUGIN ACTIVATION
-------------------------------------------------------*/
function custom_cafe_tables() {
   	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  	$advertisersTable = $wpdb->prefix.'aa_advertisers';
	$cafesTable = $wpdb->prefix.'aa_cafes';
	$citiesTable = $wpdb->prefix.'aa_cities';
	$pricesTable = $wpdb->prefix.'aa_prices';
	$settingsTable = $wpdb->prefix.'aa_settings';
	$statesTable = $wpdb->prefix.'aa_states';

	if($wpdb->get_var("show tables like '$advertisersTable'") != $advertisersTable)	{
		$sql = "CREATE TABLE " . $advertisersTable . " (
			`company_id` int(11) NOT NULL AUTO_INCREMENT,
			`company_name` varchar(255) NOT NULL,
			`contact_person` varchar(255) NOT NULL,
			`contact_email` varchar(255) NOT NULL,
			`contact_phone` varchar(255) NOT NULL,
			`period_reservation` int(11) NOT NULL,
			`period_reservation_cost` varchar(255) NOT NULL,
			`selectedCafe` text NOT NULL,
			PRIMARY KEY (`company_id`)
		);";		
		dbDelta($sql);
	} 
	
	if($wpdb->get_var("show tables like '$cafesTable'") != $cafesTable) 
	{
		$sql = "CREATE TABLE " . $cafesTable . " (
			`company_id_bm` int(10) NOT NULL AUTO_INCREMENT,
			`company_name` varchar(50) NOT NULL DEFAULT '',
			`company_contact_person_name` varchar(30) NOT NULL DEFAULT '',
			`company_zip` varchar(30) NOT NULL DEFAULT '',
			`company_city` varchar(30) NOT NULL DEFAULT '',
			`company_state` varchar(255) NOT NULL,
			`company_house_no` varchar(255) NOT NULL,
			`company_street` varchar(255) NOT NULL,
			`company_country` varchar(255) NOT NULL,
			`company_lon` varchar(30) NOT NULL DEFAULT '',
			`company_lat` varchar(30) NOT NULL DEFAULT '',
			`company_contact_phone` varchar(30) NOT NULL DEFAULT '',
			`company_contact_email` varchar(50) NOT NULL DEFAULT '',
			`company_type` varchar(255) NOT NULL,
			`service_ontbijt` tinyint(1) NOT NULL DEFAULT 0,
			`service_lunch` tinyint(1) NOT NULL DEFAULT 0,
			`service_diner` tinyint(1) NOT NULL DEFAULT 0,
			`service_borrel` tinyint(1) NOT NULL DEFAULT 0,
			`service_uitgaan` tinyint(1) NOT NULL DEFAULT 0,
			`service_overnachting` tinyint(1) NOT NULL DEFAULT 0,
			`company_monthly_visitors` varchar(255) NOT NULL DEFAULT '',
			`company_beer_mats` varchar(255) NOT NULL DEFAULT '',
			`company_client_age` varchar(50) NOT NULL DEFAULT '',
			`klant_kinderen` tinyint(1) NOT NULL DEFAULT 0,
			`klant_studenten` tinyint(1) NOT NULL DEFAULT 0,
			`klant_zakelijk` tinyint(1) NOT NULL DEFAULT 0,
			`klant_familiair` tinyint(1) NOT NULL DEFAULT 0,
			`klant_toeristen` tinyint(1) NOT NULL DEFAULT 0,
			`klant_stamgasten` tinyint(1) NOT NULL DEFAULT 0,
			`company_client_expense` varchar(50) NOT NULL DEFAULT '',
			`company_logo` varchar(40) NOT NULL,
			`opening_days` varchar(255) NOT NULL,
			`start_period` date NOT NULL,
			`end_period` date NOT NULL,
			`guest_composition` varchar(255) NOT NULL,
			`new_subscription` tinyint(1) NOT NULL DEFAULT 0,
			`latlon_ok` tinyint(1) NOT NULL DEFAULT 0,
			`date_entry` datetime NOT NULL,
			`date_edit` datetime NOT NULL,
			PRIMARY KEY (`company_id_bm`)
		);";		
		dbDelta($sql);
	} 
	if($wpdb->get_var("show tables like '$citiesTable'") != $citiesTable) 
	{
		$sql = "CREATE TABLE " . $citiesTable . " (
			`id` int(11) NOT NULL,
			`name` varchar(30) NOT NULL,
			`city_lat` varchar(30) NOT NULL,
			`city_lon` varchar(30) NOT NULL,
			`state_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		);";		
		dbDelta($sql);
	} 
	if($wpdb->get_var("show tables like '$pricesTable'") != $pricesTable) 
	{
		$sql = "CREATE TABLE " . $pricesTable . " (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`visitors_per_month` int(20) NOT NULL,
			`sale_price_per_month` decimal(6,2) NOT NULL,
			PRIMARY KEY (`id`)
		);";		 
		dbDelta($sql);
	} 
	
	if($wpdb->get_var("show tables like '$settingsTable'") != $settingsTable) {
		$sql = "CREATE TABLE " . $settingsTable . " (
			`id` int(11) NOT NULL,
			`admin_email` varchar(255) NOT NULL,
			`derate_6_months` float(10,2) NOT NULL,
			`derate_9_months` float(10,2) NOT NULL,
			`derate_12_months` float(10,2) NOT NULL,
			`algemene_voorwaarden` text NOT NULL,
			`privacy` text NOT NULL,
			PRIMARY KEY (`id`)
		);";		 
		dbDelta($sql);
	} 
	
	if($wpdb->get_var("show tables like '$statesTable'") != $statesTable) {
		$sql = "CREATE TABLE " . $statesTable . " (
			`id` int(11) NOT NULL,
			`name` varchar(30) NOT NULL,
			`state_lon` varchar(30) NOT NULL,
			`state_lat` varchar(30) NOT NULL,
			`country_id` int(11) NOT NULL DEFAULT 1,
			PRIMARY KEY (`id`),
			UNIQUE KEY `id` (`id`)
		);";		 
		dbDelta($sql);
	} 
	
	if(empty(get_option('cafe_plugin_table_insert'))) {
		
		$wpdb->query("INSERT INTO $citiesTable
            (id, name, city_lat, city_lon, state_id)
            VALUES
			(29855, 'SchipolRijk', '51.9758', '4.3139', 2585),
			(29856, 'Amstelveen', '52.2308', '4.8333', 2586),
			(29857, 'Aa en Hunze', '52.8942', '7.0278', 2587),
			(29858, 'Assen', '52.9967', '6.5625', 2587),
			(29859, 'Borger-Odoorn', '52.9233', '6.7931', 2587),
			(29860, 'Coevorden', '52.6625', '6.7417', 2587),
			(29861, 'De Wolden', '53.1417', '6.0167', 2587),
			(29862, 'Den Oever', '52.935', '5.0306', 2587),
			(29863, 'Emmen', '52.7792', '6.9069', 2587),
			(29864, 'Gasteren', '53.035', '6.6639', 2587),
			(29865, 'Hoogeveen', '52.7225', '6.4764', 2587),
			(29866, 'Menterwolde', '53.3517', '6.4653', 2587),
			(29867, 'Meppel', '52.6958', '6.1944', 2587),
			(29868, 'Midden-Drenthe', '52.5492', '4.9125', 2587),
			(29869, 'Noordenveld', '52.1675', '4.8278', 2587),
			(29870, 'Stadskanaal', '53', '6.9167', 2587),
			(29871, 'Tynaarlo', '52.7408', '5.0528', 2587),
			(29872, 'Veenoord', '52.715', '6.8417', 2587),
			(29873, 'Westerveld', '53.4008', '6.4833', 2587),
			(29874, 'Zuidlaren', '53.0942', '6.6819', 2587),
			(29875, 'Almere', '52.1583', '6.3', 2588),
			(29876, 'Dronten', '52.525', '5.7181', 2588),
			(29877, 'Lelystad', '52.51073044', '5.470619565', 2588),
			(29878, 'Noordoostpolder', '53.1208', '6.6667', 2588),
			(29879, 'Urk', '52.67726667', '5.568233333', 2588),
			(29880, 'Zeewolde', '52.33168', '5.51884', 2588),
			(29881, 'Achtkarspelen', '51.6883', '4.2792', 2589),
			(29882, 'Ameland', '51.955', '4.9625', 2589),
			(29883, 'Boarnsterhim', '52.7267', '5.9611', 2589),
			(29884, 'Bolsward', '53.0667', '5.5333', 2589),
			(29885, 'Dantumadeel', '53.2833', '6', 2589),
			(29886, 'Dongeradeel', '51.6267', '4.9389', 2589),
			(29887, 'Drachten', '53.1', '6.1', 2589),
			(29888, 'Ferwerderadiel', '53.3333', '5.8333', 2589),
			(29889, 'Franekeradeel', '53.2', '5.5333', 2589),
			(29890, 'Gaasterlan-Sleat', '53.0167', '5.4167', 2589),
			(29891, 'Gorredijk', '53', '6.0667', 2589),
			(29892, 'Harlingen', '53.16346667', '5.3771', 2589),
			(29893, 'Heerenveen', '52.95', '5.9333', 2589),
			(29894, 'Het Bildt', '51.9167', '4.4833', 2589),
			(29895, 'Kollumerland', '53.2833', '6.15', 2589),
			(29896, 'Leeuwarden', '53.2', '5.7833', 2589),
			(29897, 'Leeuwarderadeel', '53.2', '5.7833', 2589),
			(29898, 'Lemsterland', '52.85', '5.7167', 2589),
			(29899, 'Littenseradiel', '51.8025', '5.4639', 2589),
			(29900, 'Menaldumadeel', '53.2', '5.7', 2589),
			(29901, 'Nijefurd', '52.95', '6.1833', 2589),
			(29902, 'Oostrum', '52.43125', '6.0417', 2589),
			(29903, 'Ooststellingwerf', '51.4633', '3.6042', 2589),
			(29904, 'Opsterland', '52.7608', '5.0486', 2589),
			(29905, 'Schiermonnikoog', '53.4833', '6.1667', 2589),
			(29906, 'Skasterlan', '50.9983', '5.8694', 2589),
			(29907, 'Smallingerland', '52.95', '5.6333', 2589),
			(29908, 'Sneek', '53.0333', '5.6667', 2589),
			(29909, 'Terschelling', '52.9333', '5.7', 2589),
			(29910, 'Tytsjerksteradiel', '52.7408', '5.0528', 2589),
			(29911, 'Ureterp', '51.55', '4.8', 2589),
			(29912, 'Weststellingwerf', '51.7867', '4.475', 2589),
			(29913, 'Wolvega', '52.8833', '6', 2589),
			(29914, 'Wunseradiel', '51.4842', '4.3875', 2589),
			(29915, 'Wymbritseradiel', '51.4842', '4.3875', 2589),
			(29916, 'Aalten', '51.925', '6.5806', 2590),
			(29917, 'Angerlo', '51.9958', '6.1347', 2590),
			(29918, 'Apeldoorn', '52.21', '5.9694', 2590),
			(29919, 'Appeldoorn', '52.21', '5.9694', 2590),
			(29920, 'Arnhem', '51.98', '5.9111', 2590),
			(29921, 'Barneveld', '52.14', '5.5847', 2590),
			(29922, 'Bemmel', '51.8917', '5.8986', 2590),
			(29923, 'Bergh', '52.5267', '6.6139', 2590),
			(29924, 'Beuningen', '51.8608', '5.7667', 2590),
			(29925, 'Borculo', '52.1158', '6.5222', 2590),
			(29926, 'Brummen', '52.09', '6.1556', 2590),
			(29927, 'Buren', '51.9117', '5.3319', 2590),
			(29928, 'Culemborg', '51.955', '5.2278', 2590),
			(29929, 'Delden', '52.26', '6.7111', 2590),
			(29930, 'Didam', '51.9408', '6.1319', 2590),
			(29931, 'Dieren', '52.0525', '6.1', 2590),
			(29932, 'Dinxperlo', '51.8642', '6.4875', 2590),
			(29933, 'Dodewaard', '51.9125', '5.6556', 2590),
			(29934, 'Doesburg', '52.0125', '6.1389', 2590),
			(29935, 'Doetinchem', '51.965', '6.2889', 2590),
			(29936, 'Druten', '51.8883', '5.6056', 2590),
			(29937, 'Duiven', '51.9467', '6.0139', 2590),
			(29938, 'Ede', '52.0333', '5.6583', 2590),
			(29939, 'Eerbeek', '52.105', '6.0583', 2590),
			(29940, 'Eibergen', '52.1', '6.6486', 2590),
			(29941, 'Elburg', '52.4475', '5.8431', 2590),
			(29942, 'Epe', '52.3475', '5.9833', 2590),
			(29943, 'Ermelo', '52.2983', '5.6222', 2590),
			(29944, 'Geldermalsen', '51.8808', '5.2889', 2590),
			(29945, 'Gendringen', '51.8733', '6.3764', 2590),
			(29946, 'Giesbeek', '51.9933', '6.0667', 2590),
			(29947, 'Gorssel', '52.2017', '6.2014', 2590),
			(29948, 'Groenlo', '52.0417', '6.6111', 2590),
			(29949, 'Groesbeek', '51.7767', '5.9361', 2590),
			(29950, 'Harderwijk', '52.3417', '5.6208', 2590),
			(29951, 'Hattem', '52.475', '6.0639', 2590),
			(29952, 'Heerde', '52.3833', '6.05', 2590),
			(29953, 'Hengelo', '52.24625455', '6.749154545', 2590),
			(29954, 'Heumen', '51.765', '5.8444', 2590),
			(29955, 'Huisen', '52.5896', '5.85945', 2590),
			(29956, 'Hummelo en Keppel', '52.0042', '6.2333', 2590),
			(29957, 'Kesteren', '51.935', '5.5694', 2590),
			(29958, 'Kootwijkerbroek', '52.1508', '5.6694', 2590),
			(29959, 'Leerdam', '51.8933', '5.0917', 2590),
			(29960, 'Leeuwen', '53.2', '5.7833', 2590),
			(29961, 'Lichtenvoorde', '51.9867', '6.5667', 2590),
			(29962, 'Lingewaal', '51.7492', '5.8306', 2590),
			(29963, 'Lochem', '52.1592', '6.4111', 2590),
			(29964, 'Loppersum', '51.9917', '5.0458', 2590),
			(29965, 'Maasdriel', '51.9592', '4.2139', 2590),
			(29966, 'Malden', '51.7808', '5.8542', 2590),
			(29967, 'Millingen', '51.6883', '5.7792', 2590),
			(29968, 'Molenhoek', '52.3951', '5.2627', 2590),
			(29969, 'Neede', '52.1342', '6.6139', 2590),
			(29970, 'Neerijnen', '51.8317', '5.2819', 2590),
			(29971, 'Nijkerk', '52.22', '5.4861', 2590),
			(29972, 'Nijmegen', '51.8425', '5.8528', 2590),
			(29973, 'Nunspeet', '52.3792', '5.7861', 2590),
			(29974, 'Oldebroek', '52.445', '5.9014', 2590),
			(29975, 'Oosterbeek', '51.97743333', '5.7695', 2590),
			(29976, 'Overbetuwe', '52.04', '5.4944', 2590),
			(29977, 'Putten', '52.2592', '5.6069', 2590),
			(29978, 'Renkum', '51.9767', '5.7333', 2590),
			(29979, 'Rheden', '52.005', '6.0292', 2590),
			(29980, 'Rijnwaarden', '52.0986', '5.0958', 2590),
			(29981, 'Rozendaal', '52.0058', '5.9625', 2590),
			(29982, 'Ruurlo', '52.0883', '6.45', 2590),
			(29983, 'Scherpenzeel', '52.45665', '5.6861', 2590),
			(29984, 'Steenderen', '52.0642', '6.1875', 2590),
			(29985, 'Terborg', '51.92', '6.3542', 2590),
			(29986, 'Tiel', '51.8867', '5.4292', 2590),
			(29987, 'Twello', '52.2367', '6.1028', 2590),
			(29988, 'Ubbergen', '51.8375', '5.9014', 2590),
			(29989, 'Vaassen', '52.2858', '5.9667', 2590),
			(29990, 'Varsseveld', '51.9433', '6.4583', 2590),
			(29991, 'Voorst', '52.02415', '6.2764', 2590),
			(29992, 'Vorden', '52.105', '6.3097', 2590),
			(29993, 'Waardenburg', '51.8325', '5.2569', 2590),
			(29994, 'Wageningen', '51.97', '5.6667', 2590),
			(29995, 'Warmsveld', '52.1967', '4.5028', 2590),
			(29996, 'Wehl', '51.9608', '6.2111', 2590),
			(29997, 'Westervoort', '51.9558', '5.9722', 2590),
			(29998, 'Wijchen', '51.8092', '5.725', 2590),
			(29999, 'Winterswijk', '51.9725', '6.7194', 2590),
			(30000, 'Wisch', '53.1972', '5.8139', 2590),
			(30001, 'Zaltbommel', '51.81', '5.2444', 2590),
			(30002, 'Zelhem', '52.0067', '6.3486', 2590),
			(30003, 'Zevenaar', '51.93', '6.0708', 2590),
			(30004, 'Zutphen', '52.1383', '6.2014', 2590),
			(30005, 's-Heerenberg', '51.5017', '3.8625', 2590),
			(30006, 'Appingedam', '53.3217', '6.8583', 2591),
			(30007, 'Bedum', '53.3008', '6.6028', 2591),
			(30008, 'Bellingwedde', '52.0889', '4.2889', 2591),
			(30009, 'De Marne', '52.3142', '6.9889', 2591),
			(30010, 'Delfzijl', '53.33', '6.9181', 2591),
			(30011, 'Eemsmond', '53.4414', '6.8362', 2591),
			(30012, 'Groningen', '53.2192', '6.5667', 2591),
			(30013, 'Grootegast', '52.6975', '5.2167', 2591),
			(30014, 'Haren', '52.82545', '6.346175', 2591),
			(30015, 'Hoogezand-Sappemeer', '53.1617', '6.7611', 2591),
			(30016, 'Leek', '53.1625', '6.3764', 2591),
			(30017, 'Marum', '53.1442', '6.2625', 2591),
			(30018, 'Midwolda', '53.1833', '5.45', 2591),
			(30019, 'Muntendam', '53.1342', '6.8694', 2591),
			(30020, 'Pekela', '53.1467', '6.4972', 2591),
			(30021, 'Reiderland', '52.0833', '4.2933', 2591),
			(30022, 'Scheemda', '52.6217', '5.0139', 2591),
			(30023, 'Slochteren', '53.2167', '6.8014', 2591),
			(30024, 'Ten Boer', '53.2758', '6.6944', 2591),
			(30025, 'Tolbert', '53.1767', '6.3722', 2591),
			(30026, 'Veendam', '53.1067', '6.8792', 2591),
			(30027, 'Vlagtwedde', '53.0275', '7.1083', 2591),
			(30028, 'Winschoten', '53.1442', '7.0347', 2591),
			(30029, 'Winsum', '53.15', '5.6333', 2591),
			(30030, 'Zuidhorn', '53.2467', '6.4028', 2591),
			(30031, 'Ambt Montfort', '51.8843', '4.3765', 2592),
			(30032, 'Arcen en Velden', '51.4767', '6.1806', 2592),
			(30033, 'Beek', '50.9408', '5.7972', 2592),
			(30034, 'Beesel', '51.2683', '6.0389', 2592),
			(30035, 'Bergen', '52.4019', '5.036475', 2592),
			(30036, 'Blerick', '52.0108', '4.5319', 2592),
			(30037, 'Brunssum', '50.9467', '5.9708', 2592),
			(30038, 'Echt', '51.1058', '5.8736', 2592),
			(30039, 'Eijsden', '50.7783', '5.7111', 2592),
			(30040, 'Gennep', '51.6983', '5.9736', 2592),
			(30041, 'Gulpen-Wittem', '50.8158', '5.8889', 2592),
			(30042, 'Haelen', '51.2358', '5.9569', 2592),
			(30043, 'Heel', '51.1792', '5.8944', 2592),
			(30044, 'Heerlen', '50.9', '5.9833', 2592),
			(30045, 'Helden', '51.3192', '6', 2592),
			(30046, 'Heythuysen', '51.25', '5.8986', 2592),
			(30047, 'Horst', '51.4542', '6.0514', 2592),
			(30048, 'Hunsel', '51.19', '5.8125', 2592),
			(30049, 'Kerkrade', '50.8658', '6.0625', 2592),
			(30050, 'Kessel', '51.2917', '6.0542', 2592),
			(30051, 'Landgraaf', '50.89544', '6.0007', 2592),
			(30052, 'Maasbracht', '51.1458', '5.8944', 2592),
			(30053, 'Maasbree', '51.3575', '6.0486', 2592),
			(30054, 'Maastricht', '50.8483', '5.6889', 2592),
			(30055, 'Margraten', '50.8208', '5.8208', 2592),
			(30056, 'Meerlo-Wanssum', '51.5133', '6.0847', 2592),
			(30057, 'Meerssen', '50.8875', '5.75', 2592),
			(30058, 'Meijel', '51.3442', '5.8847', 2592),
			(30059, 'Mook en Middelaar', '51.7525', '5.8819', 2592),
			(30060, 'Nederweert', '51.2858', '5.7486', 2592),
			(30061, 'Nuth', '50.9175', '5.8861', 2592),
			(30062, 'Onderbanken', '51.9167', '4.4833', 2592),
			(30063, 'Roerdalen', '52.2033', '4.6333', 2592),
			(30064, 'Roermond', '51.1942', '5.9875', 2592),
			(30065, 'Roggel', '51.2633', '5.9236', 2592),
			(30066, 'Roggel en Neer', '51.2633', '5.9236', 2592),
			(30067, 'Schinnen', '50.9433', '5.8889', 2592),
			(30068, 'Sevenum', '51.4125', '6.0375', 2592),
			(30069, 'Simpelveld', '50.8342', '5.9819', 2592),
			(30070, 'Sittard', '50.9983', '5.8694', 2592),
			(30071, 'Sittard-Geleen', '50.9983', '5.8694', 2592),
			(30072, 'Stein', '50.9692', '5.7667', 2592),
			(30073, 'Stramproy', '51.1942', '5.7194', 2592),
			(30074, 'Susteren', '51.065', '5.8556', 2592),
			(30075, 'Swalmen', '51.2308', '6.0361', 2592),
			(30076, 'Tegelen', '51.3442', '6.1361', 2592),
			(30077, 'Thorn', '51.1617', '5.8417', 2592),
			(30078, 'Vaals', '50.7708', '6.0181', 2592),
			(30079, 'Valkenburg', '51.3028', '5.364366667', 2592),
			(30080, 'Venlo', '51.37', '6.1681', 2592),
			(30081, 'Venray', '51.525', '5.975', 2592),
			(30082, 'Vilt Limburg', '52.5108', '6.3514', 2592),
			(30083, 'Voerendaal', '50.8783', '5.9306', 2592),
			(30084, 'Weert', '51.2517', '5.7069', 2592),
			(30085, '\'s-Hertogenbosch', '51.6992', '5.3042', 2593),
			(30086, 'Aalburg', '51.5467', '3.5097', 2593),
			(30087, 'Alphen-Chaam', '52.135', '4.6597', 2593),
			(30088, 'Asten', '51.4042', '5.7486', 2593),
			(30089, 'Baarle-Nassau', '51.4475', '4.9292', 2593),
			(30090, 'Bergeijk', '51.3192', '5.3583', 2593),
			(30091, 'Bergen op Zoom', '51.495', '4.2917', 2593),
			(30092, 'Berghem', '51.77', '5.5736', 2593),
			(30093, 'Bernheze', '51.7483', '5.1653', 2593),
			(30094, 'Bernisse', '51.7483', '5.1653', 2593),
			(30095, 'Best', '51.5075', '5.3903', 2593),
			(30096, 'Bladel', '51.3683', '5.2208', 2593),
			(30097, 'Boekel', '51.6033', '5.675', 2593),
			(30098, 'Boxmeer', '51.6467', '5.9472', 2593),
			(30099, 'Boxtel', '51.5908', '5.3292', 2593),
			(30100, 'Breda', '51.5667', '4.8', 2593),
			(30101, 'Budel', '51.2717', '5.575', 2593),
			(30102, 'Cranendonck', '51.9967', '5.3083', 2593),
			(30103, 'Cuijk', '51.7308', '5.8792', 2593),
			(30104, 'Den Bosch', '51.7158', '4.2847', 2593),
			(30105, 'Den Dungen', '51.665', '5.3722', 2593),
			(30106, 'Deurne', '51.46', '5.7972', 2593),
			(30107, 'Dongen', '51.6267', '4.9389', 2593),
			(30108, 'Drimmelen', '51.7067', '4.8042', 2593),
			(30109, 'Drunen', '51.6858', '5.1333', 2593),
			(30110, 'Duizel', '51.3683', '5.2972', 2593),
			(30111, 'Eersel', '51.3575', '5.3181', 2593),
			(30112, 'Eindhoven', '51.4408', '5.4778', 2593),
			(30113, 'Etten-Leur', '51.5742', '4.6403', 2593),
			(30114, 'Geertruidenberg', '51.7017', '4.8569', 2593),
			(30115, 'Geldrop', '51.4217', '5.5597', 2593),
			(30116, 'Gemert-Bakel', '51.5558', '5.6903', 2593),
			(30117, 'Gilze en Rijen', '51.5442', '4.9403', 2593),
			(30118, 'Goirle', '51.5208', '5.0667', 2593),
			(30119, 'Grave', '51.7558', '5.7375', 2593),
			(30120, 'Haaren', '51.6025', '5.2222', 2593),
			(30121, 'Halderberge', '51.4958', '5.2069', 2593),
			(30122, 'Heeze-Leende', '51.3833', '5.5667', 2593),
			(30123, 'Heijningen', '51.6558', '4.4083', 2593),
			(30124, 'Helmond', '51.4817', '5.6611', 2593),
			(30125, 'Heusden', '51.9367', '6.59', 2593),
			(30126, 'Hilvarenbeek', '51.4858', '5.1375', 2593),
			(30127, 'Hoeven', '51.5792', '4.5833', 2593),
			(30128, 'Hoogerheide', '51.4242', '4.325', 2593),
			(30129, 'Kaatsheuvel', '51.6575', '5.0347', 2593),
			(30130, 'Korendijk', '51.9025', '4.49', 2593),
			(30131, 'Laarbeek', '52.0708', '4.3042', 2593),
			(30132, 'Landerd', '51.3442', '4.0556', 2593),
			(30133, 'Lith', '51.8058', '5.4389', 2593),
			(30134, 'Loon op Zand', '51.6275', '5.075', 2593),
			(30135, 'Maarheeze', '51.3117', '5.6167', 2593),
			(30136, 'Maasdonk', '51.9592', '4.2139', 2593),
			(30137, 'Mierlo', '51.44', '5.6194', 2593),
			(30138, 'Mill en Sint Hubert', '51.6883', '5.7792', 2593),
			(30139, 'Moerdijk', '51.7017', '4.6264', 2593),
			(30140, 'Nieuwkuijk', '51.69', '5.1819', 2593),
			(30141, 'Nuenen', '51.47', '5.5528', 2593),
			(30142, 'Oirschot', '51.505', '5.3139', 2593),
			(30143, 'Oisterwijk', '51.5792', '5.1889', 2593),
			(30144, 'Oosterhout', '51.645', '4.8597', 2593),
			(30145, 'Oss', '51.765', '5.5181', 2593),
			(30146, 'Raamsdonksveer', '51.6967', '4.8736', 2593),
			(30147, 'Ravenstein', '51.7967', '5.65', 2593),
			(30148, 'Reusel-De Mierden', '51.3625', '5.1653', 2593),
			(30149, 'Roosendaal', '51.5308', '4.4653', 2593),
			(30150, 'Rosmalen', '51.7167', '5.3653', 2593),
			(30151, 'Rucphen', '51.5317', '4.5583', 2593),
			(30152, 'Schaijk', '51.7458', '5.6319', 2593),
			(30153, 'Schijndel', '51.6225', '5.4319', 2593),
			(30154, 'Sint Anthonis', '51.6267', '5.8819', 2593),
			(30155, 'Sint Willebrord', '52.66', '4.7833', 2593),
			(30156, 'Sint-Michielsgestel', '51.6417', '5.3528', 2593),
			(30157, 'Sint-Oedenrode', '51.5675', '5.4597', 2593),
			(30158, 'Sleeuwijk', '51.8158', '4.9528', 2593),
			(30159, 'Someren', '51.385', '5.7111', 2593),
			(30160, 'Son en Breugel', '51.5167', '5.4875', 2593),
			(30161, 'Steenbergen', '51.5842', '4.3194', 2593),
			(30162, 'Tilburg', '51.553464', '5.102424', 2593),
			(30163, 'Uden', '51.6608', '5.6194', 2593),
			(30164, 'Valkenswaard', '51.3508', '5.4597', 2593),
			(30165, 'Veghel', '51.6167', '5.5486', 2593),
			(30166, 'Veldhoven', '51.4183', '5.4028', 2593),
			(30167, 'Vinkel', '51.7058', '5.4625', 2593),
			(30168, 'Vught', '51.6533', '5.2875', 2593),
			(30169, 'Waalre', '51.3867', '5.4444', 2593),
			(30170, 'Waalwijk', '51.6825', '5.0708', 2593),
			(30171, 'Werkendam', '51.81', '4.8944', 2593),
			(30172, 'Woensdrecht', '51.43', '4.3028', 2593),
			(30173, 'Woudrichem', '51.815', '5.0014', 2593),
			(30174, 'Zundert', '51.4717', '4.6556', 2593),
			(30175, 'Aalsmeer', '52.2592', '4.7597', 2594),
			(30176, 'Alkmaar', '52.6317', '4.7486', 2594),
			(30177, 'Amstelveen', '52.2308', '4.8333', 2594),
			(30178, 'Amsterdam', '52.35', '4.9167', 2594),
			(30179, 'Andijk', '52.7467', '5.2222', 2594),
			(30180, 'Ankeveen', '52.265', '5.0986', 2594),
			(30181, 'Anna Paulowna', '52.8608', '4.8361', 2594),
			(30182, 'Assendelft', '52.4683', '4.7431', 2594),
			(30183, 'Badhoevedorp', '51.7433', '5.0222', 2594),
			(30184, 'Beemster', '52.16', '5.9639', 2594),
			(30185, 'Bennebroek', '52.3208', '4.5986', 2594),
			(30186, 'Bergen', '52.4019', '5.036475', 2594),
			(30187, 'Beverwijk', '52.4833', '4.6569', 2594),
			(30188, 'Blaricum', '52.2725', '5.2417', 2594),
			(30189, 'Bloemendaal', '51.5308', '6.1083', 2594),
			(30190, 'Bovenkarspel', '52.6967', '5.2403', 2594),
			(30191, 'Bussum', '52.2733', '5.1611', 2594),
			(30192, 'Castricum', '52.5483', '4.6694', 2594),
			(30193, 'Den Helder', '52.9533', '4.7597', 2594),
			(30194, 'Diemen', '52.3383', '4.9597', 2594),
			(30195, 'Drechterland', '53.145', '6.085', 2594),
			(30196, 'Edam-Volendam', '52.5133', '5.0514', 2594),
			(30197, 'Enkhuizen', '52.7033', '5.2917', 2594),
			(30198, 'Graft-De Rijp', '52.5608', '4.8306', 2594),
			(30199, 'Haarlem', '52.3667', '4.65', 2594),
			(30200, 'Haarlemmerliede', '52.3883', '4.6861', 2594),
			(30201, 'Haarlemmermeer', '52.3883', '4.6861', 2594),
			(30202, 'Harenkarspel', '52.82545', '6.346175', 2594),
			(30203, 'Heemskerk', '52.5167', '4.6667', 2594),
			(30204, 'Heemstede', '52.3458', '4.6208', 2594),
			(30205, 'Heerhugowaard', '52.6667', '4.85', 2594),
			(30206, 'Heiloo', '52.6', '4.7', 2594),
			(30207, 'Hillegom', '52.2908', '4.5833', 2594),
			(30208, 'Hilversum', '52.2233', '5.1764', 2594),
			(30209, 'Hoofddorp', '52.3025', '4.6889', 2594),
			(30210, 'Hoorn', '52.6425', '5.0597', 2594),
			(30211, 'Huizen', '52.2992', '5.2417', 2594),
			(30212, 'Ijmuiden', '52.46', '4.6167', 2594),
			(30213, 'Katwijk', '52.1111', '4.627085714', 2594),
			(30214, 'Krommenie', '52.4992', '4.7625', 2594),
			(30215, 'Landsmeer', '52.4308', '4.9153', 2594),
			(30216, 'Langedijk', '52.0125', '5.3278', 2594),
			(30217, 'Laren', '52.23586667', '5.606966667', 2594),
			(30218, 'Loosdrecht', '52.2167', '5.0667', 2594),
			(30219, 'Medemblik', '52.7717', '5.1056', 2594),
			(30220, 'Middenbeemster', '52.5492', '4.9125', 2594),
			(30221, 'Muiden', '52.33', '5.0694', 2594),
			(30222, 'Naarden', '52.2958', '5.1625', 2594),
			(30223, 'Niedorp', '53.1608', '6.3278', 2594),
			(30224, 'Nieuw-Vennep', '52.2642', '4.6306', 2594),
			(30225, 'Noorder-Koggenland', '52.1675', '4.8278', 2594),
			(30226, 'Obdam', '52.6758', '4.9069', 2594),
			(30227, 'Oostzaan', '52.4392', '4.8764', 2594),
			(30228, 'Opmeer', '52.7067', '4.9444', 2594),
			(30229, 'Oude Meer', '52.2883', '4.7861', 2594),
			(30230, 'Ouder-Amstel', '51.8275', '4.1917', 2594),
			(30231, 'Oudkarspel', '52.7158', '4.8056', 2594),
			(30232, 'Purmerend', '52.505', '4.9597', 2594),
			(30233, 'Rozenburg', '52.03003333', '4.411566667', 2594),
			(30234, 'Schagen', '52.7875', '4.7986', 2594),
			(30235, 'Schermer', '52.0917', '5.0917', 2594),
			(30236, 'Stede Broec', '52.8833', '5.3667', 2594),
			(30237, 'Texel', '52.2375', '6.05', 2594),
			(30238, 'Tuitjenhorn', '52.7375', '4.75', 2594),
			(30239, 'Uitgeest', '52.5292', '4.7097', 2594),
			(30240, 'Uithoorn', '52.2375', '4.8264', 2594),
			(30241, 'Velsen', '51.94566', '5.9225', 2594),
			(30242, 'Venhuizen', '52.6625', '5.2028', 2594),
			(30243, 'Vijfhuizen', '52.3508', '4.6778', 2594),
			(30244, 'Waarland', '52.7267', '4.8319', 2594),
			(30245, 'Waterland', '51.8333', '4.3333', 2594),
			(30246, 'Weesp', '52.3075', '5.0417', 2594),
			(30247, 'Wervershoof', '52.73', '5.1583', 2594),
			(30248, 'Wester-Koggenland', '51.3325', '5.3958', 2594),
			(30249, 'Westwoud', '52.685', '5.1347', 2594),
			(30250, 'Wieringen', '52.3592', '6.5931', 2594),
			(30251, 'Wieringermeer', '52.3592', '6.5931', 2594),
			(30252, 'Wognum', '52.6833', '5.0222', 2594),
			(30253, 'Wormer', '52.495', '4.8056', 2594),
			(30254, 'Wormerland', '52.495', '4.8056', 2594),
			(30255, 'Wormerveer', '52.4908', '4.7903', 2594),
			(30256, 'Zaandam', '52.44', '4.825', 2594),
			(30257, 'Zaanstad', '52.475', '4.8028', 2594),
			(30258, 'Zandvoort', '52.3725', '4.5292', 2594),
			(30259, 'Zeevang', '51.6975', '5.6764', 2594),
			(30260, 'Zwaag', '52.6692', '5.0764', 2594),
			(30261, 'Zwanenburg', '52.38', '4.7458', 2594),
			(30262, 'Almelo', '52.3567', '6.6625', 2595),
			(30263, 'Bathmen', '52.25', '6.2875', 2595),
			(30264, 'Borne', '52.3', '6.75', 2595),
			(30265, 'Dalfsen', '52.5117', '6.2569', 2595),
			(30266, 'Dedemsvaart', '52.6', '6.4583', 2595),
			(30267, 'Denekamp', '52.6017', '6.6958', 2595),
			(30268, 'Deventer', '52.255', '6.1639', 2595),
			(30269, 'Diepenheim', '52.2', '6.5556', 2595),
			(30270, 'Enschede', '52.2183', '6.8958', 2595),
			(30271, 'Genemuiden', '52.6233', '6.0403', 2595),
			(30272, 'Haaksbergen', '52.1567', '6.7389', 2595),
			(30273, 'Hardenberg', '52.5758', '6.6194', 2595),
			(30274, 'Hasselt', '52.6', '6.1', 2595),
			(30275, 'Hellendoorn', '52.3883', '6.4514', 2595),
			(30276, 'Hengelo', '52.24625455', '6.749154545', 2595),
			(30277, 'Hof van Twente', '51.5792', '4.5833', 2595),
			(30278, 'IJsselmuiden', '52.565', '5.9333', 2595),
			(30279, 'Kampen', '52.1108', '4.8944', 2595),
			(30280, 'Lemelerveld', '52.4458', '6.3417', 2595),
			(30281, 'Losser', '52.2608', '7.0042', 2595),
			(30282, 'Nieuwleusen', '52.5825', '6.2819', 2595),
			(30283, 'Nijverdal', '52.36', '6.4681', 2595),
			(30284, 'Oldenzaal', '52.3133', '6.9292', 2595),
			(30285, 'Olst', '52.3375', '6.1097', 2595),
			(30286, 'Ommen', '52.5208', '6.4208', 2595),
			(30287, 'Ootmarsum', '52.4083', '6.9014', 2595),
			(30288, 'Raalte', '52.3858', '6.275', 2595),
			(30289, 'Rijssen', '52.3067', '6.5181', 2595),
			(30290, 'Staphorst', '52.645', '6.2111', 2595),
			(30291, 'Steenwijk', '52.7875', '6.1208', 2595),
			(30292, 'Tubbergen', '52.4075', '6.7847', 2595),
			(30293, 'Vriezenveen', '52.4083', '6.6222', 2595),
			(30294, 'Vroomshoop', '52.4608', '6.5653', 2595),
			(30295, 'Weerselo', '52.2217', '4.8986', 2595),
			(30296, 'Wierden', '52.3592', '6.5931', 2595),
			(30297, 'Zwartewaterland', '51.8833', '4.2208', 2595),
			(30298, 'Zwolle', '52.5125', '6.0944', 2595),
			(30299, 'Abcoude', '52.2725', '4.9694', 2597),
			(30300, 'Amerongen', '52', '5.45', 2597),
			(30301, 'Amersfoort', '52.155', '5.3875', 2597),
			(30302, 'Baarn', '52.2117', '5.2875', 2597),
			(30303, 'Benschop', '52.0083', '4.9806', 2597),
			(30304, 'Breukelen', '51.5175', '5.5111', 2597),
			(30305, 'Bunnik', '52.0667', '5.1986', 2597),
			(30306, 'Bunschoten', '52.0667', '5.1986', 2597),
			(30307, 'De Bilt', '52.11', '5.1806', 2597),
			(30308, 'De Ronde Venen', '51.55', '5.8097', 2597),
			(30309, 'Den Dolder', '52.1392', '5.2389', 2597),
			(30310, 'Doorn', '52.0375', '5.3417', 2597),
			(30311, 'Driebergen-Rijsenburg', '52.0533', '5.2806', 2597),
			(30312, 'Eemnes', '52.2542', '5.2611', 2597),
			(30313, 'Houten', '52.0283', '5.1681', 2597),
			(30314, 'IJsselstein', '52.02', '5.0431', 2597),
			(30315, 'Kockengen', '52.1542', '4.9653', 2597),
			(30316, 'Leersum', '52.0117', '5.4278', 2597),
			(30317, 'Leusden', '52.1325', '5.4319', 2597),
			(30318, 'Loenen', '52.1175', '6.0194', 2597),
			(30319, 'Lopik', '52.5942', '6.6653', 2597),
			(30320, 'Maarn', '52.05', '5.4', 2597),
			(30321, 'Maarsen', '52.0986', '5.0958', 2597),
			(30322, 'Mijdrecht', '52.2067', '4.8625', 2597),
			(30323, 'Montfoort', '52.0458', '4.9528', 2597),
			(30324, 'Nieuwegein', '52.0292', '5.0806', 2597),
			(30325, 'Nigtevecht', '52.2742', '5.0278', 2597),
			(30326, 'Odijk', '52.0525', '5.2361', 2597),
			(30327, 'Oudewater', '52.025', '4.8681', 2597),
			(30328, 'Renswoude', '52.0733', '5.5403', 2597),
			(30329, 'Rhenen', '51.9592', '5.5681', 2597),
			(30330, 'Soest', '52.1733', '5.2917', 2597),
			(30331, 'Soesterberg', '52.1183', '5.2861', 2597),
			(30332, 'Utrecht', '53.4025', '6.6111', 2597),
			(30333, 'Veenendaal', '52.0233', '5.55', 2597),
			(30334, 'Vianen', '51.7183', '5.8569', 2597),
			(30335, 'Wijdemeren', '52.8833', '5.6333', 2597),
			(30336, 'Wijk', '52.3867', '6.1347', 2597),
			(30337, 'Wilnis', '52.1967', '4.8972', 2597),
			(30338, 'Woerden', '52.085', '4.8833', 2597),
			(30339, 'Woudenberg', '52.0808', '5.4167', 2597),
			(30340, 'Zeist', '52.09', '5.2333', 2597),
			(30341, 'Axel', '51.2667', '3.9083', 2598),
			(30342, 'Borsele', '53.3333', '5.9667', 2598),
			(30343, 'Goes', '51.5042', '3.8889', 2598),
			(30344, 'Hontenisse', '52', '4.2333', 2598),
			(30345, 'Hulst', '51.28', '4.0528', 2598),
			(30346, 'Kapelle', '51.56125', '3.9627', 2598),
			(30347, 'Middelburg', '51.5', '3.6139', 2598),
			(30348, 'Noord-Beveland', '53.2083', '5.975', 2598),
			(30349, 'Oostburg', '51.3258', '3.4875', 2598),
			(30350, 'Reimerswaal', '50.7992', '5.8375', 2598),
			(30351, 'Sas van Gent', '51.2275', '3.7986', 2598),
			(30352, 'Schouwen-Duiveland', '52.1667', '5.4', 2598),
			(30353, 'Sluis-Aardenburg', '51.3083', '3.3861', 2598),
			(30354, 'Terneuzen', '51.3358', '3.8278', 2598),
			(30355, 'Tholen', '51.5317', '4.2208', 2598),
			(30356, 'Veere', '51.5483', '3.6667', 2598),
			(30357, 'Vlissingen', '51.4490625', '3.5556', 2598),
			(30358, 'Zierikzee', '51.65', '3.9194', 2598),
			(30359, 'Zijpe', '53.3942', '6.7569', 2598),
			(30360, '\'s-Gravendeel', '51.78', '4.6167', 2599),
			(30361, '\'s-Gravenhage', '51.78', '4.6167', 2599),
			(30362, '\'s-Gravenzande', '52.0017', '4.1653', 2599),
			(30363, 'Alblasserdam', '51.8658', '4.6611', 2599),
			(30364, 'Albrandswaard', '51.8658', '4.6611', 2599),
			(30365, 'Alkemade', '51.7867', '5.3431', 2599),
			(30366, 'Alphen', '51.5953', '5.129133333', 2599),
			(30367, 'Alphen aan den Rijn', '52.135', '4.6597', 2599),
			(30368, 'Barendrecht', '51.8567', '4.5347', 2599),
			(30369, 'Bergambacht', '51.9342', '4.7861', 2599),
			(30370, 'Bergschenhoek', '51.99', '4.4986', 2599),
			(30371, 'Berkel en Rodenrijs', '52.00593333', '4.420533333', 2599),
			(30372, 'Binnenmaas', '50.97', '5.9361', 2599),
			(30373, 'Bleiswijk', '52.0108', '4.5319', 2599),
			(30374, 'Bodegraven', '52.0825', '4.75', 2599),
			(30375, 'Boskoop', '52.075', '4.6556', 2599),
			(30376, 'Brielle', '51.9017', '4.1625', 2599),
			(30377, 'Capelle', '52.84', '4.6958', 2599),
			(30378, 'Cromstrijen', '52.7401', '5.5347', 2599),
			(30379, 'De Lier', '51.975', '4.2486', 2599),
			(30380, 'Delft', '52.0067', '4.3556', 2599),
			(30381, 'Dirksland', '51.7492', '4.1', 2599),
			(30382, 'Dordrecht', '51.80990667', '4.677156667', 2599),
			(30383, 'Giessenlanden', '51.8508', '4.8903', 2599),
			(30384, 'Goedereede', '51.8175', '3.9806', 2599),
			(30385, 'Gorinchem', '51.8325', '4.975', 2599),
			(30386, 'Gouda', '52.0167', '4.7083', 2599),
			(30387, 'Graafstroom', '53.1833', '5.8', 2599),
			(30388, 'Hardinxveld-Giessendam', '51.82855', '4.8106', 2599),
			(30389, 'Heerjansdam', '51.8358', '4.5639', 2599),
			(30390, 'Hellevoetsluis', '51.8342', '4.1472', 2599),
			(30391, 'Hendrik-Ido-Ambacht', '51.8442', '4.6389', 2599),
			(30392, 'Jacobswoude', '50.9808', '5.9417', 2599),
			(30393, 'Katwijk', '52.1111', '4.627085714', 2599),
			(30394, 'Kinderdijk', '51.8858', '4.6319', 2599),
			(30395, 'Krimpen', '52.8417', '5.0819', 2599),
			(30396, 'Leiden', '52.1583', '4.4931', 2599),
			(30397, 'Leiderdorp', '52.1583', '4.5292', 2599),
			(30398, 'Leidschendam-Voorburg', '52.0883', '4.3944', 2599),
			(30399, 'Liemeer', '51.9867', '6.5667', 2599),
			(30400, 'Liesveld', '51.4133', '5.8208', 2599),
			(30401, 'Lisse', '52.26', '4.5569', 2599),
			(30402, 'Maasland', '51.9342', '4.2722', 2599),
			(30403, 'Maassluis', '51.9194', '4.265857143', 2599),
			(30404, 'Middelharnis', '51.7575', '4.1653', 2599),
			(30405, 'Monster', '52.0258', '4.175', 2599),
			(30406, 'Moordrecht', '51.9867', '4.6681', 2599),
			(30407, 'Naaldwijk', '51.9942', '4.2097', 2599),
			(30408, 'Nederlek', '52.7833', '5.975', 2599),
			(30409, 'Nieuw-Lekkerland', '52.6958', '6.6139', 2599),
			(30410, 'Nieuwekerk aan den IJssel', '52.95', '6.05', 2599),
			(30411, 'Nieuwkoop', '52.1508', '4.7764', 2599),
			(30412, 'Noordwijk', '52.3915', '4.748816667', 2599),
			(30413, 'Noordwijkerhout', '52.2617', '4.4931', 2599),
			(30414, 'Oegestgeest', '51.6983', '5.9333', 2599),
			(30415, 'Oostflakkee', '52.8667', '5.75', 2599),
			(30416, 'Oud-Beijerland', '51.8242', '4.4125', 2599),
			(30417, 'Ouderkerk', '51.8275', '4.1917', 2599),
			(30418, 'Papendrecht', '51.8304', '4.701914286', 2599),
			(30419, 'Pijnacker-Nootdorp', '52.0167', '4.4375', 2599),
			(30420, 'Reeuwijk', '52.0467', '4.725', 2599),
			(30421, 'Ridderkerk', '51.8725', '4.6028', 2599),
			(30422, 'Rijnsburg', '52.19', '4.4417', 2599),
			(30423, 'Rijnwoude', '52.0986', '5.0958', 2599),
			(30424, 'Rijswijk', '51.99364167', '4.476241667', 2599),
			(30425, 'Rotterdam', '51.9225', '4.4792', 2599),
			(30426, 'Sassenheim', '52.225', '4.5222', 2599),
			(30427, 'Schiedam', '51.9192', '4.3889', 2599),
			(30428, 'Schipluiden', '51.9758', '4.3139', 2599),
			(30429, 'Schoonhoven', '51.9475', '4.8486', 2599),
			(30430, 'Sliedrecht', '51.8208', '4.7764', 2599),
			(30431, 'Spijkenisse', '51.845', '4.3292', 2599),
			(30432, 'Strijen', '51.75', '4.55', 2599),
			(30433, 'Ter Aar', '52.1658', '4.7069', 2599),
			(30434, 'The Hague', '52.2375', '6.05', 2599),
			(30435, 'Valkenburg', '51.3028', '5.364366667', 2599),
			(30436, 'Vierpolders', '51.8792', '4.1792', 2599),
			(30437, 'Vlaardingen', '51.8843', '4.3765', 2599),
			(30438, 'Vlist', '51.98', '4.8194', 2599),
			(30439, 'Voorhout', '52.2217', '4.4847', 2599),
			(30440, 'Voorschoten', '52.1275', '4.4486', 2599),
			(30441, 'Waddinxveen', '52.045', '4.6514', 2599),
			(30442, 'Warmond', '52.1967', '4.5028', 2599),
			(30443, 'Wassenaar', '52.1458', '4.4028', 2599),
			(30444, 'Wateringen', '52.0242', '4.2708', 2599),
			(30445, 'West Maas en Waal', '51.8396', '4.34375', 2599),
			(30446, 'Westvoorne', '51.7867', '4.475', 2599),
			(30447, 'Zederik', '51.9033', '6.2597', 2599),
			(30448, 'Zevenhuizen-Moerkapelle', '52.0536', '4.5313', 2599),
			(30449, 'Zoetermeer', '52.0575', '4.4931', 2599),
			(30450, 'Zoeterwoude', '52.12', '4.4958', 2599),
			(30451, 'Zwijndrecht', '51.8175', '4.6333', 2599)
		");
		
		$wpdb->query("INSERT INTO $statesTable
            (id, name, state_lon, state_lat, country_id)
            VALUES
			(2587, 'Drenthe', '52.9080482', '6.3262207', 155),
			(2588, 'Flevoland', '52.548423', '5.2863347', 155),
			(2589, 'Friesland', '53.1577282', '5.3563487', 155),
			(2590, 'Gelderland', '52.1278978', '5.6332887', 155),
			(2591, 'Groningen', '53.1958843', '6.4171036', 155),
			(2592, 'Limburg', '51.2640022', '5.3360482', 155),
			(2593, 'Noord-Brabant', '51.5259193', '4.8387296', 155),
			(2594, 'Noord-Holland', '52.6740634', '4.3506279', 155),
			(2595, 'Overijssel', '52.4862162', '6.1451217', 155),
			(2596, 'Zuid-Holland', '51.9922611', '4.2139132', 155),
			(2597, 'Utrecht', '52.1186801', '5.0696362', 155),
			(2598, 'Zeeland', '51.4795203', '3.5386536', 155)
		");
			
		update_option( 'cafe_plugin_table_insert', 1 );
	}
	
	
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'custom_cafe_tables');


/*-------------------------------------------------
 				START SESSION
----------------------------------------------------*/

add_action('init','start_session', 1);

function start_session() {

    if(!session_id()) {

        session_start();

    } 

}  



function articledetails(){
	
   $account_login=array("price"=>'20',
   "days"=>'10');
	echo json_encode($account_login);
	exit;
	
}
add_action('wp_ajax_article_details', 'articledetails');
add_action('wp_ajax_nopriv_article_details', 'articledetails'); 
function secondpagedetails(){
	$return_value= array();
	$price_hidden=$_POST['price_hidden'];
	$days_hidden=$_POST['days_hidden'];
	$qty1_hidden=$_POST['qty1_hidden'];
	$qty2_hidden=$_POST['qty2_hidden'];
	$package_data=$_POST['package'];
	$delivery_data=$_POST['delivery'];
	$radio=$_POST['radio'];
	
	$return_value[0] =$price_hidden;
	$return_value[1] =$days_hidden;
	$return_value[2] =$qty1_hidden;
	$return_value[3] =$qty2_hidden;
	$return_value[4] =$delivery_data;
	$return_value[5] =$package_data;
	$return_value[6] =$radio;
	echo json_encode($return_value);
	exit;    
}


add_action('wp_ajax_secondpage_details', 'secondpagedetails');
add_action('wp_ajax_nopriv_secondpage_details', 'secondpagedetails'); 
function thirdpagedetails(){
	$return_value1= array();
	$name=$_POST['name'];
	$email=$_POST['email'];
	$subject=$_POST['subject'];
	$include_keyword=$_POST['include_keyword'];
	$target_audience=$_POST['target_audience'];
	$target_gender=$_POST['target_gender'];
	$reference_link=$_POST['reference_link'];
	$comments=$_POST['comments'];
	$price1_hidden=$_POST['price1_hidden'];
	$radio_hidden=$_POST['radio_hidden'];
	$days_hidden1=$_POST['days_hidden1'];
	$qty1_hidden=$_POST['qty1_hidden'];
	$qty2_hidden=$_POST['qty2_hidden'];
	$radio_hidden=$_POST['radio_hidden'];
	
	
	$return_value1[0] =$name;
	$return_value1[1] =$email;
	$return_value1[2] =$subject;
	$return_value1[3] =$include_keyword;
	$return_value1[4] =$target_audience;
	$return_value1[5] =$target_gender;
	$return_value1[6] =$reference_link;
	$return_value1[7] =$comments;
	$return_value1[8] =$price1_hidden;
	$return_value1[9] =$radio_hidden;
	$return_value1[10] =$days_hidden1;
	$return_value1[11] =$qty1_hidden;
	$return_value1[12] =$qty2_hidden;
	echo json_encode($return_value1);
	exit;    
}
add_action('wp_ajax_thirdpage_details', 'thirdpagedetails');
add_action('wp_ajax_nopriv_thirdpage_details', 'thirdpagedetails'); 


/***************************************************/
function mapfilter(){
	global $wpdb;
	//$company_type=$_POST['company_type'];
	$ww="";        
	foreach ($_POST as $param_name => $param_val) {
		$ww.="Param: $param_name; Value: $param_val<br />\n";
                write_log(date("Y-m-d_His__").'Param: '.$param_name.' Value: '.$param_val);
	}
      
	$sql="SELECT * FROM ".$wpdb->prefix."aa_cafes WHERE   ";
	$firstTime=true;
	$firstClause=0;
	$secondClause=0;
	//$thirdClause=0;       

	if(isset($_POST['service_ontbijt']) &&  $_POST['service_ontbijt'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" OR ";  } 
		if($firstClause==0){ $sql.="("; $firstClause++;}
		$sql.=" `service_ontbijt` LIKE '%".$_POST['service_ontbijt']."%' ";
	}
	
	if(isset($_POST['service_lunch']) &&  $_POST['service_lunch'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" OR ";  } 
		if($firstClause==0){ $sql.="("; $firstClause++;}
		$sql.=" `service_lunch` LIKE '%".$_POST['service_lunch']."%' ";
	}
	if(isset($_POST['service_diner']) &&  $_POST['service_diner'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" OR ";  } 
		if($firstClause==0){ $sql.="("; $firstClause++;}
		$sql.=" `service_diner` LIKE '%".$_POST['service_diner']."%' ";
	}
	if(isset($_POST['service_borrel']) &&  $_POST['service_borrel'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" OR ";  } 
		if($firstClause==0){ $sql.="("; $firstClause++;}
		$sql.=" `service_borrel` LIKE '%".$_POST['service_borrel']."%' ";
	}
	if(isset($_POST['service_uitgaan']) &&  $_POST['service_uitgaan'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" OR ";  } 
		$sql.=" `service_uitgaan` LIKE '%".$_POST['service_uitgaan']."%' ";
	}
	if(isset($_POST['service_overnachting']) &&  $_POST['service_overnachting'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" OR ";  } 
		if($firstClause==0){ $sql.="("; $firstClause++;}
		$sql.=" `service_overnachting` LIKE '%".$_POST['service_overnachting']."%' ";
	}

        
	if(isset($_POST['klant_kinderen']) &&  $_POST['klant_kinderen'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { if($secondClause==0){$sql.=") AND ("; $secondClause++;}else{ $sql.=" OR ";} } 
		$sql.=" `klant_kinderen` LIKE '%".$_POST['klant_kinderen']."%' ";
	}
	if(isset($_POST['klant_studenten']) &&  $_POST['klant_studenten'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { if($secondClause==0){$sql.=") AND ("; $secondClause++;}else{ $sql.=" OR ";} } 
		$sql.=" `klant_studenten` LIKE '%".$_POST['klant_studenten']."%' ";
	}
	if(isset($_POST['klant_zakelijk']) &&  $_POST['klant_zakelijk'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { if($secondClause==0){$sql.=") AND ("; $secondClause++;}else{ $sql.=" OR ";} } 
		$sql.=" `klant_zakelijk` LIKE '%".$_POST['klant_zakelijk']."%' ";
	}
	if(isset($_POST['klant_familiair']) &&  $_POST['klant_familiair'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { if($secondClause==0){$sql.=") AND ("; $secondClause++;}else{ $sql.=" OR ";} } 
		$sql.=" `klant_familiair` LIKE '%".$_POST['klant_familiair']."%' ";
	}
	if(isset($_POST['klant_toeristen']) &&  $_POST['klant_toeristen'] == '1')
	{
		if ($firstTime) { $firstTime=FALSE; } else { if($secondClause==0){$sql.=") AND ("; $secondClause++;}else{ $sql.=" OR ";} } 
		$sql.=" `klant_toeristen` LIKE '%".$_POST['klant_toeristen']."%' ";
	}

	if(isset($_POST['klant_stamgasten']) &&  $_POST['klant_stamgasten'] == '1')	{
		if ($firstTime) { $firstTime=FALSE; } else { if($secondClause==0){$sql.=") AND ("; $secondClause++;}else{ $sql.=" OR ";} } 
		$sql.=" `klant_stamgasten` LIKE '%".$_POST['klant_stamgasten']."%' ";
	}

    if(isset($_POST['company_type']) && $_POST['company_type']!='Geen selectie'){
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" ) AND ( "; } 
		$sql.=" `company_type` LIKE '%".$_POST['company_type']."%' ";
	}  
       
        
    if(isset($_POST['company_monthly_visitors']) && $_POST['company_monthly_visitors']!=0){
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" ) AND ( "; } 
		$sql.=" `company_monthly_visitors` LIKE '%".$_POST['company_monthly_visitors']."%' ";
	}

	if(isset($_POST['company_client_expense_msg']) && $_POST['company_client_expense_msg']!=0 ){
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" ) AND ( "; } 
		$sql.=" `company_client_expense` LIKE '%".$_POST['company_client_expense_msg']."%' ";
	}

	if(isset($_POST['company_client_age_msg']) && $_POST['company_client_age_msg']!=0 )	{
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" ) AND ( "; } 
		$sql.=" `company_client_age` LIKE '%".$_POST['company_client_age_msg']."%' ";
	}
	
	if(isset($_POST['company_client_gender']) && $_POST['company_client_gender']!=0){
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=" ) AND ( "; } 
		$sql.=" `company_client_gender` LIKE '%".$_POST['company_client_gender']."%' ";
	}
	
	if(isset($_POST['selected_city_name']) && $_POST['selected_city_name']!='')	{
		$_POST['selected_city_name']=stripslashes($_POST['selected_city_name']);
		$_POST['selected_country_name']=stripslashes($_POST['selected_country_name']);
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=") AND "; } 
		$sql.=" `company_city` IN ('".stripslashes($_POST['selected_city_name'])."') AND `company_country` IN ('".$_POST['selected_country_name']."') ";
	}
	
	if(isset($_POST['selected_state_name']) && $_POST['selected_state_name']!='')	{
		$_POST['selected_state_name']=stripslashes($_POST['selected_state_name']);
		$_POST['selected_country_name']=stripslashes($_POST['selected_country_name']);
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=") AND "; } 
		$sql.=" `company_state` IN ('".$_POST['selected_state_name']."') AND `company_country` IN ('".$_POST['selected_country_name']."')";
	}
	
	if(isset($_POST['selected_country_name']) && $_POST['selected_country_name']!='' && $_POST['selected_state_name']=='' && $_POST['selected_city_name']=='')	{
		$_POST['selected_country_name']=stripslashes($_POST['selected_country_name']);
		if ($firstTime) { $firstTime=FALSE; } else { $sql.=") AND "; } 
		$sql.=" `company_country` IN ('".$_POST['selected_country_name']."') ";
	}
	
	$sql.=" )";        //echo $sql;
        
    write_log(date("Y-m-d_His__").'[FRONT END] ->BIG SQL =  '.$sql);
	
	
	$getAll = $wpdb->get_results($sql);        
        
	foreach($getAll as $data){
		 
		$visitor=$data->company_monthly_visitors;
		$sql="SELECT * FROM ".$wpdb->prefix."aa_prices WHERE visitors_per_month BETWEEN ".$visitor." AND ".$visitor;
                
		$getRow = $wpdb->get_row($sql);
		if($getRow){
			if($getRow->sale_price_per_month > 0)
			{
				write_log(date("Y-m-d_His__").'[FRONT END] ->Successfully executed the UPDATE SQL: '.$sql);
				$data->price_per_month=$getRow->sale_price_per_month;
			}
		}
		else {
			write_log(date("Y-m-d_His__").'[FRONT END] ->Error after extecuting UPDATE SQL: '.$sql);
			$data->price_per_month="0";
		}
		
		$currentDate=date('Y-m-d');
		/*echo "1st point".$currentDate.">=".$data->start_period;
		echo "2nd point".$currentDate."<=".$data->end_period;*/
		if(($currentDate>=$data->start_period) && ($currentDate<=$data->end_period)){
        	$data->available="1";  
		}
		else {
			$data->available="0";
		}
	}
	echo json_encode($getAll);
	exit;	
}
add_action('wp_ajax_mapfilter', 'mapfilter');
add_action('wp_ajax_nopriv_mapfilter', 'mapfilter'); 


function mapfilterall(){
	global $wpdb;
        
	$company_services=$_POST['company_services'];
        $company_cntry="Netherlands";

        $company_type="";
        if (isset($_POST['company_type']))
        {
            $company_type=$_POST['company_type'];
        }
                
        $company_city="";
        if (isset($_POST['selected_city_name']))
        {
            $company_city=str_replace("\'","'", $_POST['selected_city_name']);
        }
        
        $company_state="";
        if (isset($_POST['selected_state_name']))
        {
            $company_state=str_replace("\'","'", $_POST['selected_state_name']);
        }
        
        $company_monthly_visitors="";
        if (isset($_POST['company_monthly_visitors']))
        {
            $company_monthly_visitors=$_POST['company_monthly_visitors'];
        }
        
        $company_beer_mats="";
        if (isset($_POST['company_beer_mats']))
        {
            $company_beer_mats=$_POST['company_beer_mats'];
        }
        
	
	$whQuery = '';

        
	if($company_city!='')
    {
            $whQuery .= "where company_city IN ('".$company_city."') ";
			
			$cityQuery="SELECT * FROM ".$wpdb->prefix."aa_cities where name='".$company_city."'";
			$getCityData = $wpdb->get_row($cityQuery);
	}
        
	if($company_state!='')
   	{
            $whQuery .= "where company_state IN ('".$company_state."')";
			
			$stateQuery="SELECT * FROM ".$wpdb->prefix."aa_states where name='".$company_state."'";
			$getStateData = $wpdb->get_row($stateQuery);
	}
        
	if($company_city=='' && $company_state=='' && $company_cntry!='')
    {
            $whQuery .= "where company_country = '".$company_cntry."'";
	}
	
	$sql=" SELECT * FROM ".$wpdb->prefix."aa_cafes ".$whQuery;
	$getAll = $wpdb->get_results($sql);
	foreach($getAll as $data)
        {
            //print_r($data);
            //$visitor=explode("-",$data->company_monthly_visitors);
            $visitor=$data->company_monthly_visitors;
            $sql="SELECT * FROM ".$wpdb->prefix."aa_prices WHERE visitors_per_month BETWEEN ".$visitor." AND ".$visitor;

            $getRow = $wpdb->get_row($sql);
            if ($getRow)
            {
                if($getRow->sale_price_per_month)
                {
                    $data->price_per_month=$getRow->sale_price_per_month;
                }
            }
            else
            {
                $data->price_per_month="0";
            }
            

            $currentDate=date('Y-m-d');
            if(($currentDate>=$data->start_period) && ($currentDate<=$data->end_period))
            {
                $data->available="1";
            }
            else
            {
                $data->available="0";
            }
	}
	
	if($company_state!='') 	{
		$getAll[] = array("lat"=>$getStateData->state_lat,"lng"=>$getStateData->state_lon);
	}	
	if($company_city!='') 	{
		$getAll[] = array("lat"=>$getCityData->city_lat,"lng"=>$getCityData->city_lon);
	} 
	echo json_encode($getAll);
	exit;
}
add_action('wp_ajax_mapfilterall', 'mapfilterall');
add_action('wp_ajax_nopriv_mapfilterall', 'mapfilterall'); 


function getmapapi(){
	// Address
	
	$company_name=$_POST['company_name'];
	// Get JSON results from this request
        
   	$reclavilt_api_key='AIzaSyDx5DRfQmPObpwOs9cjGDm_0djznFQJl_M';
        
	
   $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($company_name).'&sensor=false');	// Convert the JSON to an array
	$geo = json_decode($geo, true);
	//
	
	if($geo['status']!='') {
	
		foreach ($geo["results"] as $result){
			foreach ($result["address_components"] as $address) 
			{
				// Repeat the following for each desired type
				if (in_array("street_number", $address["types"])) echo $address["long_name"].'~';
				if (in_array("route", $address["types"])) echo $address["long_name"].'~';
				if (in_array("locality", $address["types"])) echo $address["long_name"].'~';
				if (in_array("administrative_area_level_1", $address["types"])) echo $address["long_name"].'~';
				if (in_array("country", $address["types"])) echo $address["long_name"].'~';
				if (in_array("postal_code", $address["types"])) echo $address["long_name"];
			}
		}
                //print_r($address);
	}
	else{
		echo "0";
	}
	exit;
    
}


add_action('wp_ajax_getmapapi', 'getmapapi');
add_action('wp_ajax_nopriv_getmapapi', 'getmapapi');
function getcity(){
	global $wpdb;
	$keyword=$_POST['keyword'];
	$sql="SELECT *
		FROM ".$wpdb->prefix."aa_cities where name LIKE '%".$keyword."%'";
		
	$getAll = $wpdb->get_results($sql);
	//print_r($getAll);
	foreach($getAll as $city){
		
		$address = $city->name;
		$prepAddr = str_replace(' ','+',$address);
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
  
		$citylist.="<div> <input type='checkbox' name='citylist' class='selectCity' value='".$city->name."' lat='".$latitude."' lon='".$longitude."' /> ".$city->name."</div>"; 
	}
	echo $citylist;
	exit; 
}



add_action('wp_ajax_getcity', 'getcity');
add_action('wp_ajax_nopriv_getcity', 'getcity'); 
function getstate(){
	global $wpdb;
	$keyword=$_POST['keyword'];
	$sql="SELECT * FROM ".$wpdb->prefix."aa_states where name LIKE '%".$keyword."%'";
	$getAll = $wpdb->get_results($sql);
	//print_r($getAll);
	foreach($getAll as $state)
        {
            $statelist.="<div> <input type='checkbox' name='statelist' class='selectState' value='".$state->name."' /> ".$state->name."</div>";
	}
	echo $statelist;
	exit;
}
add_action('wp_ajax_getstate', 'getstate');
add_action('wp_ajax_nopriv_getstate', 'getstate'); 



function advertiseSubmit() {
	global $wpdb;
	$company_name=$_POST['company_name'];
	$contact_person=$_POST['contact_person'];
	$contact_email=$_POST['contact_email'];
	$contact_phone=$_POST['contact_phone'];
	$arrData=$_POST['selectedCafe'];       
	
	$period_reservation=$_POST['period_reservation'];
	$period_reservation_cost=$_POST['period_reservation_cost'];       
     
	   
   	write_log(date("Y-m-d_His__").'$arrData: '.print_r($arrData));
    
   
	$introText = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."aa_settings");
	
	$to=$introText->admin_email; 
	
	
	
	$sql="INSERT INTO ".$wpdb->prefix."aa_advertisers (`company_name`, `contact_person`, `contact_email`,`contact_phone`,`period_reservation`,`period_reservation_cost`,`selectedCafe`) values ('".$company_name."', '".$contact_person."', '".$contact_email."', '".$contact_phone."', '".$_POST['period_reservation']."', '".$_POST['period_reservation_cost']."', '".serialize($_POST['selectedCafe'])."')";
	
    if($wpdb->query($sql)) {
           
		    write_log(date("Y-m-d_His__").'[FRONT END] -> Successfully executed the UPDATE SQL: '.$sql);
            $subject= "Nieuw reserveringsformulier van een adverteerder op ReclaVilt";
            $headers  = "From:".$company_name."<".$contact_email.">\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $message  = '<html><body>';
            $message .= '<p>Kostenopbouw voor een reserveringsperiode van '.$period_reservation.' maanden.</p>';
            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            $message .= "<tr style='background: #eee;'><td><strong>Zaak:</strong></td><td><strong>Bezoekers</td><td><strong>Prijs</td></tr>"; 
            foreach($arrData as $data) { $message.='<tr><td>'.$data['cafe_name'].'</td><td>'.$data['visitor'].'</td><td>'.$data['price'].'</td></tr>'; } 
            $message .= "<tr><td><strong>Totaal</strong></td><td><strong>&nbsp;</strong></td><td><strong>".$period_reservation_cost."</strong></td></tr>";
            $message .= "</table>";
            $message .= '<p>Gegevens adverteerder:</p>';
            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            $message .= "<tr><td><strong>Bedrijf</strong></td><td>".$company_name."</td></tr>";
            $message .= "<tr><td><strong>Contactpersoon</strong></td><td>".$contact_person."</td></tr>";
            $message .= "<tr><td><strong>Email</strong></td><td>".$contact_email."</td></tr>";
            $message .= "<tr><td><strong>Telefoon</strong></td><td>".$contact_phone."</td></tr>";
            $message .= "<p><br>Adverteerder gaat akkoord met de door ReclaVilt opgestelde Algemene Voorwaarden en Privacy Overeenkomst. </p>";
            $message .= "</table>";
            $message .= '</table>';
            $message .= '</body></html>';
            
            //$multiple_recipients = array('info@reclavilt.nl','john.ploeg@gmail.com');
            //$multiple_recipients = array('john.ploeg@gmail.com');
            

            if (wp_mail($to, $subject, $message, $headers))
            {
                write_log(date("Y-m-d_His__").'[FRONT END] -> Conformation mail sent to site owner + adverteerder');
            }
            else 
            {
                write_log(date("Y-m-d_His__").'[FRONT END] -> Error while sending conformation mail to site owner + adverteerder');
            }            

        }
        else
        {
            write_log(date("Y-m-d_His__").'[FRONT END] -> Advertisor request -> Error after extecuting UPDATE SQL: '.$sql);
        }                
                

	die();

}
add_action('wp_ajax_advertiseSubmit', 'advertiseSubmit');
add_action('wp_ajax_nopriv_advertiseSubmit', 'advertiseSubmit'); 

add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
    add_image_size( 'my-cust-img', 400, 400, true );
}

if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}
