<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
function GetStr($string, $start, $end){
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}
function multiexplode($delimiters, $string)

{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}



$lista   = $_GET['lista']; 




$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://app.logward.com/api/public/containerTracking/'.$lista.'?carrier=MSCU');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

$d = curl_exec($ch);


$s = json_decode($d, true);
$ETA = $s['data']['tracking_response'][0]['containerTracking']['eta'];
$expectedDateOfDeparture = date("Y-m-d",strtotime($ETA));
$events = $s['data']['tracking_response'][0]['containerTracking']['trackingEvents'];
if ($estimatedDateOfArrival = ":null,") {
    $pos = count($events);
    $actualpos = ($pos - 2);
    $actualTimestamp = $s['data']['tracking_response'][0]['containerTracking']['trackingEvents'][$actualpos]['actualTimestamp'];
    $estimatedDateOfArrival = date("Y-m-d",strtotime($actualTimestamp));

}

$expectedDateOfDeparture = $estimatedDateOfArrival;
$pod = $s['data']['tracking_response'][0]['containerTracking']['origin']['city'];
$pol = $s['data']['tracking_response'][0]['containerTracking']['destination']['city'];
$data_array = array('ETA_at_Place_of_Delivery'=>$expectedDateOfDeparture,'Estimated_Date_of_Arrival'=>$estimatedDateOfArrival,'Point_of_Depature'=>$pod,'Point_of_Landing'=>$pol);
$data = json_encode($data_array);

echo ($data);


?>