<?php

/** Template name: Map **/

get_header();

global $wpdb;

$getAll = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."aa_cafes");

$introText = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."aa_settings");

$deriv_6=$introText->derate_6_months;

$deriv_9=$introText->derate_9_months;

$deriv_12=$introText->derate_12_months;

$sqlState="SELECT * FROM ".$wpdb->prefix."aa_states ORDER BY name";	

$getAllState = $wpdb->get_results($sqlState);

//$sqlCity="SELECT * FROM aa_cities ORDER BY name";

$sqlCity="SELECT DISTINCT CITY.name FROM ".$wpdb->prefix."aa_cities CITY,".$wpdb->prefix."aa_cafes CAFE where CITY.name=CAFE.company_city";

$getAllCity=$wpdb->get_results($sqlCity);
$settings = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."aa_settings");



?>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<div class="container">
  <input type="hidden" name="formcheck" id="formcheck" value="2" />
  <div class="row" id="1st_form" style="display:none">
    <div id="success_message"></div>
    <div class="col-md-12 text-para"><?php echo ""; ?></div>
    <div class="col-md-12">
      <div class="col-md-4">
        <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" id="cityModalBtn" data-target="#cityModal">City</button>
-->
      </div>
      <div class="col-md-4">
        <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#stateModal" id="stateModalBtn">State</button>-->
      </div>
      <div class="col-md-4">
        <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#countryModal">Country</button>-->
        <!--<a id="showCountryMap" class="btn btn-info btn-lg">Toon op map</a>-->
      </div>
      <div class="col-md-4"> </div>
    </div>
  </div>
  <div class="row mapform" id="2nd_form">
    <div id="filter">
      <div class="form-group col-md-7">
        <div class="text_sec_1">
          <?=stripslashes(get_option('map-text-sec-1'));?>
        </div>
      </div>
      <div class="form-group col-md-5 top-image-section">
        <?php if(get_option('map-photo-sec-1')!=''){

					echo wp_get_attachment_image( get_option('map-photo-sec-1'),'my-cust-img' );

				}else{

				?>
        <img src="<?php echo CUS_CAFE_PLUGIN_URL; ?>/assets/images/400x400-light.jpg" />
        <?php } ?>
      </div>
      <div class="col-md-4 allCheckedFilters">
        <div class="form-group">
          <div>
            <input type="hidden" name="deriv_6" id="deriv_6" value="<?php echo $deriv_6; ?>" />
            <input type="hidden" name="deriv_9" id="deriv_9" value="<?php echo $deriv_9; ?>" />
            <input type="hidden" name="deriv_12" id="deriv_12" value="<?php echo $deriv_12; ?>" />
            <select id="state">
              <option value="">--Selecteer Provincie--</option>
              <?php foreach($getAllState as $state){?>
              <option value="<?php echo $state->name; ?>"><?php echo $state->name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div>
            <select id="city">
              <option value="">--Selecteer Stad--</option>
              <?php foreach($getAllCity as $city){?>
              <option value="<?php echo $city->name; ?>"><?php echo $city->name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <!--<label for="email">Gemiddelde uitgaven:</label>-->
          <select class="form-control" id="company_type" name="company_type_msg">
            <option value="Geen selectie">Selecteer type horeca zaak:</option>
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
            <option value="Geen selectie">Alles selecteren</option>
          </select>
        </div>
        <div class="form-group">
          <label for="email">Services:</label>
          <div class="form-row">
            <label class="checkBoxContainer">Ontbijt
            <input class="form-control company_services managebleCheckbox" type="checkbox" checked="checked" name="company_services" id="service_ontbijt" value="Ontbijt">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Lunch
            <input class="form-control company_services managebleCheckbox" type="checkbox" checked="checked" name="company_services" id="service_lunch" value="Lunch">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Diner
            <input class="form-control company_services managebleCheckbox" type="checkbox" checked="checked" name="company_services" id="service_diner" value="Diner">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Borrel
            <input class="form-control company_services managebleCheckbox" type="checkbox" checked="checked" name="company_services" id="service_borrel" value="Borrel">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Uitgaan
            <input class="form-control company_services managebleCheckbox" type="checkbox" checked="checked" name="company_services" id="service_uitgaan" value="Uitgaan">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Overnachting
            <input class="form-control company_services managebleCheckbox" type="checkbox" checked="checked" name="company_services" id="service_overnachting" value="Overnachting">
            <span class="checkmark"></span> </label>
          </div>
        </div>
        <div class="form-group">
          <select class="form-control" id="company_monthly_visitors" name="company_monthly_visitors">
            <option value="0">Aantal maandelijkse bezoekers:</option>
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
            <option value="0">Maak selectie ongedaan</option>
          </select>
        </div>
        <div class="form-group">
          <!--<label for="email">Gemiddelde uitgaven:</label>-->
          <select class="form-control" id="company_client_expense_msg" name="company_client_expense_msg">
            <option value="0">Gemiddelde uitgaven:</option>
            <option value="10">€10</option>
            <option value="20">€10-€20 </option>
            <option value="30">€20-€35</option>
            <option value="40">€35-€50</option>
            <option value="50">meer dan €50</option>
            <option value="0">Maak uitgave selectie ongedaan</option>
          </select>
        </div>
        <div class="form-group">
          <select class="form-control" id="company_client_age_msg" name="company_client_age_msg">
            <option value="0">Selecteer Leeftijd</option>
            <option value="0 - 18">0 - 18</option>
            <option value="18 - 27">18 - 27</option>
            <option value="27 - 45">27 - 45</option>
            <option value="45+">45+</option>
            <option value="0">Maak leeftijd selectie ongedaan</option>
          </select>
        </div>
        <div class="form-group">
          <label for="email">Type bezoeker: (meerdere keuzes mogelijk)</label>
          <div class="form-row">
            <label class="checkBoxContainer">Kinderen
            <input class="form-control company_client_type_msg managebleCheckbox" type="checkbox" checked="checked" name="company_client_type_msg" id="klant_kinderen" value="1">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Studenten
            <input class="form-control company_client_type_msg managebleCheckbox" type="checkbox" checked="checked" name="company_client_type_msg" id="klant_studenten" value="1">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Zakelijk
            <input class="form-control company_client_type_msg managebleCheckbox" type="checkbox" checked="checked" name="company_client_type_msg" id="klant_zakelijk" value="1">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Familiair
            <input class="form-control company_client_type_msg managebleCheckbox" type="checkbox" checked="checked" name="company_client_type_msg" id="klant_familiair" value="1">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Toeristen
            <input class="form-control company_client_type_msg managebleCheckbox" type="checkbox" checked="checked" name="company_client_type_msg" id="klant_toeristen" value="1">
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-row">
            <label class="checkBoxContainer">Stamgasten
            <input class="form-control company_client_type_msg managebleCheckbox" type="checkbox" checked="checked" name="company_client_type_msg" id="klant_stamgasten" value="1">
            <span class="checkmark"></span> </label>
          </div>
        </div>
        <div class="form-group">
          <!--<input type="button" id="back_tab_list" value="<< Terug" />-->
          <input type="button" id="next_tab_list" style="background-color:#ff0000 !important;" value="Volgende >>" style="float:right"/>
        </div>
      </div>
      <div class="col-md-8">
        <div><img src="<?php echo CUS_CAFE_PLUGIN_URL;?>/assets/images/legenda_map.png" width="350px" />
          <?php  //echo getcwd() . "\n"; ?>
        </div>
        <div id="map" style="height: 600px; width: 100%px;">
          <!-- 400 500 -->
        </div>
        <input type="hidden" id="avgCLat" name="avgCLat" />
        <input type="hidden" id="avgCLon" name="avgCLon" />
        <input type="hidden" id="avgSLat" name="avgSLat" />
        <input type="hidden" id="avgSLon" name="avgSLon" />
        <input type="hidden" id="avgCnLat" name="avgCnLat" />
        <input type="hidden" id="avgCnLon" name="avgCnLon" />
      </div>
    </div>
    <div id="list_cafe" style="display:none">
      <div class="form-group col-md-7">
        <div class="text_sec_1">
          <?=stripslashes(get_option('map-text-sec-2'));?>
        </div>
      </div>
      <div class="form-group col-md-5 top-image-section">
        <?php if(get_option('map-photo-sec-2')!=''){

					echo wp_get_attachment_image( get_option('map-photo-sec-2'),'my-cust-img' );

				}else{

				?>
        <img src="<?php echo CUS_CAFE_PLUGIN_URL; ?>/assets/images/400x400-light.jpg" />
        <?php } ?>
      </div>
      <div class="col-md-8">
        <div id="listData"> </div>
        <div class="row">
          <div class="form-group col-md-6">
            <input type="button" id="back_tab_filter" value="<< Terug" />
          </div>
          <div class="form-group col-md-6">
            <input type="button" style="background-color:#ff0000 !important;" id="next_form" value="Maak reservering" />
          </div>
          <div class="col-md-12">
            <p>Uw reservering is altijd kosteloos en vrijblijvend. Wij nemen binnen een dag contact op om de mogelijkheden te bespreken! </p>
          </div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
    <div class="col-md-12" id="form" style="display:none">
      <form id="mapFormSubmit" method="post">
        <div class="row">
          <div class="form-group col-md-7">
            <div class="text_sec_1">
              <?=stripslashes(get_option('map-text-sec-3'));?>
            </div>
          </div>
          <div class="form-group col-md-5 top-image-section">
            <?php if(get_option('map-photo-sec-3')!=''){

                            echo wp_get_attachment_image( get_option('map-photo-sec-3'),'my-cust-img' );

                        }else{

                        ?>
            <img src="<?php echo CUS_CAFE_PLUGIN_URL; ?>/assets/images/400x400-light.jpg" />
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <input type="button" class=" btn btn-info termandconditionaccess" data-toggle="modal" data-target="#myModal" value="Bekijk hier onze Algemene Voorwaarden" style="color: #fff !important;background-color: #F27125 !important;border-color: #1b6d85 !important;width:50%;" >
            <input type="button" class=" btn btn-info termandconditionaccess" data-toggle="modal" data-target="#privacyModal" value="Bekijk hier ons Privacy Reglement" style="color: #fff !important;background-color: #F27125 !important;padding: 1em 2em;border-color: #1b6d85 !important;width:49%;" >
          </div>
          <div class="form-group col-md-12">
            <label class="checkBoxContainer">Ik ga akkoord met de door ReclaVilt opgestelde Algemene Voorwaarden.
            <input type="checkbox" class="termandcondition" required>
            <span class="checkmark"></span> </label>
          </div>
          <div class="form-group col-md-12">
            <label class="checkBoxContainer">Ik ga tevens akkoord met het Privacy Reglement van ReclaVilt.
            <input type="checkbox" class="termandcondition" required >
            <span class="checkmark"></span> </label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="form-group col-md-6">
                <input type="text" placeholder="Naam bedrijf" name="company_name" id="company_name">
              </div>
              <div class="form-group col-md-6">
                <input type="text" placeholder="Naam contactpersoon" name="contact_person" id="contact_person">
              </div>
              <div class="form-group col-md-6">
                <input type="text" placeholder="Email" name="contact_email" id="contact_email">
              </div>
              <div class="form-group col-md-6">
                <input type="text" placeholder="Telefoon" name="contact_phone" id="contact_phone">
              </div>
              <div class="form-group col-md-6">
                <input type="button" id="back_list_cafe" value="<< Terug" />
              </div>
              <div class="form-group col-md-6">
                <input type="submit" id="submit_frm" style="background-color:#ff0000 !important;" name="submit" value="Aanvragen" />
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
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
<div id="cityModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Select City</h4>
      </div>
      <div class="modal-body">
        <div class="ui-widget">
          <div id="cvalShow"></div>
          <div id="cval" style="display:none"></div>
          <div id="getTempValCityShow" style="display:none"></div>
          <div id="getTempValCity" style="display:none"></div>
          <input type="hidden" id="getSelectCityVal" />
          <input id="city" class="form-control typeCity" autofocus>
          <div id="suggesstion-box-city" style="max-height:150px; overflow-y: scroll;"></div>
        </div>
      </div>
      <div class="modal-footer"> <span class="map-icon"><a id="showCityMap" data-dismiss="modal">Show on Map</a></span>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="stateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Select State</h4>
      </div>
      <div class="modal-body">
        <div class="ui-widget">
          <div id="svalShow"></div>
          <div id="sval" style="display:none"></div>
          <div id="getTempValStateShow" style="display:none"></div>
          <div id="getTempValState" style="display:none"></div>
          <input id="state"  class="form-control typeState" autofocus>
          <div id="suggesstion-box-state" style="max-height:80px; overflow-y: scroll;"></div>
        </div>
      </div>
      <div class="modal-footer"> <span class="map-icon"><a id="showStateMap" data-dismiss="modal">Show on Map</a></span>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="countryModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Select Country</h4>
      </div>
      <div class="modal-body">
        <div class="ui-widget">
          <input id="countryVal" class="form-control typeState" value="Netherlands" disabled >
        </div>
      </div>
      <div class="modal-footer"> <span class="map-icon"><a id="showCountryMap" data-dismiss="modal">Show on Map</a></span>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
