<?php
function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] ;
}

include "../../../wp-load.php";

$file = 'assets/uploads/'.$_GET['ID'].'.pdf';  
$filename = $_GET['ID'].'.pdf';  
if (file_exists($file)) 
{
  header('Content-type: application/pdf');
  header('Content-Disposition: inline; filename="' . $filename . '"');
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');
  @readfile($file);
}
else
{
    $mediafolder=url()."/WP/uploads/";
    $getAll = $wpdb->get_row("SELECT * FROM aa_cafes where company_id_bm=".$_GET['ID']);
    $html = '';
    $html .='<div style="text-align:center;"><img src="'.$mediafolder.$getAll->company_logo.'"><h3>'.$getAll->company_name.'</h3>'
            . '<p>Contactpersoon : '.$getAll->company_contact_person_name.'<br/> Telefoon ( '.$getAll->company_contact_phone.')</p>'
            . '<p>Email : '.$getAll->company_contact_email.'</p>'
            . '</div>'
            . '<div style="text-align:left;"><p><b>Adres</b></p>'
            . '<p> '.$getAll->company_street.'&nbsp;'.$getAll->company_house_no.'<br/>'
            . ''.$getAll->company_zip.'&nbsp;&nbsp;'.$getAll->company_city.'&nbsp;&nbsp;('.$getAll->company_state.')<br/>'
            . 'Nederland</p>'
            . '<p><b>Soort onderneming :</b> '.$getAll->company_type.'</p>'
            . '<p><b>Openingsdagen : </b>'.$getAll->opening_days.'</p>'
            . '<p><b>Klant uitgaven :</b> '.$getAll->company_client_expense.'</p>'
            . '<p><b>Klantsamenstelling : </b>'.$getAll->guest_composition.'</p>'
            . '<p><b>Leeftijd klanten : </b>'.$getAll->company_client_age.' jaar</p>'
            . '<p><b>Aantal maandelijkse bezoekers : </b>'.$getAll->company_monthly_visitors.'</p>'
            . '<p><b>Aantal bierviltjes per maand : </b>'.$getAll->company_beer_mats.''
            . '<p><b>Services : </b>';
    $services="";
    if($getAll->service_ontbijt==1) {  $services .=' Ontbijt,'; }
    if($getAll->service_lunch==1) {  $services .=' Lunch,'; }
    if($getAll->service_diner==1) {  $services .=' Dinner,'; }
    if($getAll->service_borrel==1) {  $services .=' Borrel,'; }
    if($getAll->service_uitgaan==1) {  $services .=' Uitgaan,'; }
    if($getAll->service_overnachting==1) {  $services .=' Overnachtingen,'; }
    $services=substr_replace($services, "", -1);
    $html .= $services;
    $html .='</p><p><b>Samenstelling van klanten : </b>';
    $klanten="";
    if($getAll->klant_kinderen==1) {  $klanten .='Kinderen,'; }
    if($getAll->klant_studenten==1) {  $klanten .=' Studenten,'; }
    if($getAll->klant_zakelijk==1) {  $klanten .=' Zakelijk,'; }
    if($getAll->klant_familiair==1) {  $klanten .=' Familiair,'; }
    if($getAll->klant_toeristen==1) {  $klanten .=' Touristen,'; }
    if($getAll->klant_stamgasten==1) {  $klanten .=' Stamgasten,'; }
    $klanten=substr_replace($klanten, "", -1);
    $html .= $klanten;
    $html .='</p></div>';
    include("MPDF57/mpdf.php");
    $mpdf=new mPDF(); 
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    exit;
}
?>