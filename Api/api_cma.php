<?php
session_start();

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
curl_setopt($ch, CURLOPT_URL, 'https://app.logward.com/api/public/containerTracking/'.$lista.'?carrier=CMDU');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

$d = curl_exec($ch);


$s = json_decode($d, true);
$estimatedDateOfArrival = $s['data']['tracking_response'][0]['containerTracking']['eta'];
$expectedDateOfDeparture = $s['data']['tracking_response'][0]['containerTracking']['eta'];
$pod = $s['data']['tracking_response'][0]['containerTracking']['origin']['city'];
$pol = $s['data']['tracking_response'][0]['containerTracking']['destination']['city'];
$data_array = array('ETA_at_Place_of_Delivery'=>$expectedDateOfDeparture,'Estimated_Date_of_Arrival'=>$estimatedDateOfArrival,'Point_of_Depature'=>$pod,'Point_of_Landing'=>$pol);
$data = json_encode($data_array);
echo ($data);


?>