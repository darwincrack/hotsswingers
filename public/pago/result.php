<?php //echo "pago exitoso";

 //Ejemplo aprenderaprogramar.com, archivo escribir.php

/*$response= '{"order":{"uuid":"C9DD3253-88DC-4FBF-8712-71EEA8228237","created":"2021-03-18T03:44:11+0100","created_from_client_timezone":"2021-03-18T03:44:11+0100","amount":3899,"currency":"978","paid":true,"status":"SUCCESS","safe":true,"refunded":0,"additional":"usuario1234","service":"REDSYSPSD2","service_uuid":"05AABEAB-B1E9-4A28-AFDC-FBC20D723E4B","customer":null,"transactions":[{"uuid":"FDF70011-64CF-416C-BC46-212C8F5EFC88","created":"2021-03-18T03:44:12+0100","created_from_client_timezone":"2021-03-18T03:44:12+0100","operative":"AUTHORIZATION","amount":3899,"authorization":"542313","status":"SUCCESS","error":"NONE","source":{"object":"CARD","uuid":"722DD16A-DB8B-4382-AEB9-39DF816ECA85","type":"CREDIT","token":"ebc9b5ffa2efcf74197734a071192817e6f2a3fc15f49c4b1bdb6edc46b16e3ab4109498bff8e6ba00fb6d2bd1838afbea67095c4caaa2f46e4acf4d5851884c","brand":"VISA","country":"ES","holder":"prueba prueba","bin":454881,"last4":"0004","is_saved":false,"expire_month":"12","expire_year":"30","additional":null,"bank":"SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A.","prepaid":"","validation_date":"2021-03-18 03:45:44","creation_date":"2021-03-18 03:45:17"},"antifraud":null}],"token":null,"ip":"190.74.205.176","reference":"Token implik-2.com"},"client":{"uuid":"AC9129AD-8ED6-45FE-925C-1092E67EE936"},"extra_data":{"profile":{"first_name":"Saville J","last_name":"Dulce Armentrout","email":"name@example.com","document_identification_number":"12345678Z","phone":{"number":"654123789","prefix":null},"work_phone":{"number":"654123789","prefix":null},"home_phone":{"number":"654123789","prefix":null},"mobile_phone":{"number":"654123789","prefix":null}},"address":{"city":"Castell\u00f3n","country":"ESP","address1":"Ronda","address2":null,"address3":null,"zip_code":"12006","state_code":"Castell\u00f3n"},"shipping_address":{"city":"Castell\u00f3n","country":"ESP","address1":"Ronda","address2":null,"address3":null,"zip_code":"12006","state_code":"Castell\u00f3n"},"billing_address":{"city":"Castell\u00f3n","country":"ESP","address1":"Ronda","address2":null,"address3":null,"zip_code":"12006","state_code":"Castell\u00f3n"},"payment":{"installments":1},"halcash":{"sender_name":"Patricio","secret_key":"4321","expiry_date":"2020-04-18"},"cof":{"reason":"INSTALLMENTS"}}}';*/


 //$datos = json_decode( $response);


$data = file_get_contents('php://input');
//echo $data;

$datos= json_decode($data);

echo "respuesta :<br>";
print_r($data);

//die($datos);

 /*echo "uuid: ".$datos->order->uuid."<br>";
 echo "status: ".$datos->order->status."<br>";
 echo "amount: ".$datos->order->amount."<br>";
 echo "ip: ".$datos->order->ip."<br>";
 echo "reference: ".$datos->order->reference."<br>";

  echo "id_user: ".$datos->extra_data->profile->document_identification_number."<br>";*/
  /*$paymentData = json_encode($_REQUEST);
  $jsonData = json_decode($paymentData);*/


$file = fopen("es.txt", "w");

fwrite($file, "uuid: ".$datos->order->uuid."<br>". PHP_EOL);

fwrite($file, "status: ".$datos->order->status."<br>" . PHP_EOL);

fwrite($file, "amount: ".$datos->order->amount."<br>" . PHP_EOL);
fwrite($file, "ip: ".$datos->order->ip."<br>" . PHP_EOL);
fwrite($file, "reference: ".$datos->order->reference."<br>" . PHP_EOL);
fwrite($file, "id_user: ".$datos->extra_data->profile->document_identification_number."<br>" . PHP_EOL);
fclose($file);