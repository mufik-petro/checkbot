<?php


ini_set('max_execution_time', '1700');
set_time_limit(1700);


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: text/html; charset=utf-8');

http_response_code(200);

//********************************


    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE); //convert JSON into array

//-------------------

$phone = $_GET['phone'];
$code = mt_rand(1000, 9999);
$curl = curl_init();

$jsonAnswer['code'] = $code;


//********************************

echo json_encode($jsonAnswer);

//********************************
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://sms-fly.com/api/api.noai.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<request>
   <operation>SENDSMS</operation>		
   <message start_time="AUTO" end_time="AUTO" lifetime="4" rate="60" desc="description" type="single">
      <recipient>'.$phone.'</recipient>		
      <body>'.$code.'</body>
   </message>
</request>',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic MzgwOTY4ODIwMDczOjEzZ3NsZmhmYzIx',
    'Content-Type: application/xml'
  ),
));

$response = curl_exec($curl);

curl_close($curl);