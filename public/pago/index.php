<?php 
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.paylands.com/v1/sandbox/api-key/profiles");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Basic NmNjZWUzZjE4ZGQyNGE3NTgyMDUzYzZhOThhZmFhYTk="
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);