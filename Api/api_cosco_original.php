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



#====================== [ SAVE CVV LIVES ] =====================#


$lista   = $_GET['lista']; 
$explode = explode('|',$lista); 
$cc     = $explode[0]; 
$mm     = $explode[1];
$yy     = $explode[2];
$cvv     = $explode[3];
$yy = substr($yy, 2, 4);
$binn = substr($cc,0,6);



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://app.logward.com/api/public/containerTracking/'.$lista.'?carrier=COSU');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

$d = curl_exec($ch);


$s = json_decode($d, true);
$lastlocal = $s['data']['tracking_response'][0]['containerTracking']['lastLocation'];
$eta = $s['data']['tracking_response'][0]['containerTracking']['eta'];
$isbooking = $s['data']['tracking_response'][0];
$lastlocal_booking = $s['data']['tracking_response'][0]['containers'][0]['lastLocation'];
$eta_booking = $s['data']['tracking_response'][0]['containers'][0]['eta'];
$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
$time = substr($time, 0, 4);

if($isbooking == "booking"){
  echo 'Ultima Localizacion: '.$lastlocal_booking;
}else{
  echo '<span class="badge badge-warning">Tracking: '.$lista.' </span> <span class="badge badge-primary"> Ultima Localizacion: '.$lastlocal.'</span> <span class="badge badge-secondary"> Tiempo estimado de llegada: '.$eta.' </span> <span class="badge badge-info"> </span> ';

}
print_r($d);


?>