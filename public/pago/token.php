<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.paylands.com/v1/sandbox/payment/process/89b46c47e59bcfa8dbc3a22529dcc0078d4721d280e8dab01db3245d6f12b4a222a8ea0b7b3353cc588ac40877db2e9dc83e090856a42dc8a8fe18c5a1b6d11e");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: text/html"
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);