<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);



$lista   = $_GET['lista']; 


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://elines.coscoshipping.com/ebtracking/public/booking/'.$lista);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

$d = curl_exec($ch);


$s = json_decode($d, true);
$pod =$s['data']['content']['trackingPath']['pod'];
$pol =$s['data']['content']['trackingPath']['pol'];

$cgoAvailTm = $s['data']['content']['trackingPath']['cgoAvailTm'];
$expectedDateOfDeparture = date("Y-m-d",strtotime($cgoAvailTm));
$EDA = $s['data']['content']['actualShipment'][1]['estimatedDateOfArrival'];
$estimatedDateOfArrival = date("Y-m-d",strtotime($EDA));
$CutOff = $s['data']['content']['cargoCutOff'];
$cargoCutOff = date("Y-m-d",strtotime($CutOff));
$data_array = array('ETA_at_Place_of_Delivery'=>$expectedDateOfDeparture,'Estimated_Date_of_Arrival'=>$estimatedDateOfArrival,'CutOff'=>$cargoCutOff,'Point_of_Depature'=>$pod,'Point_of_Landing'=>$pol);
$data = json_encode($data_array);
echo ($data);





//print_r($d);


?>