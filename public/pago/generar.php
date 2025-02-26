<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.paylands.com/v1/sandbox/payment");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"signature\": \"NjkZuwJh8cIKzss00AtBW1pL\",
  \"amount\": 3899,
  \"operative\": \"AUTHORIZATION\",
  \"additional\": \"usuario1234\",
  \"service\": \"05AABEAB-B1E9-4A28-AFDC-FBC20D723E4B\",
  \"secure\": true,
  \"url_post\": \"https://implik-2.com/pago/result.php\",
  \"url_ok\": \"https://implik-2.com/pago/success.php\",
  \"url_ko\": \"https://implik-2.com/pago/error.php\",
  \"template_uuid\": \"92C57435-17B5-488B-B188-1EC1BD8DB01D\",
  \"description\": \"order's description\",
  \"extra_data\": {
    \"profile\": {
      \"first_name\": \"Saville J\",
      \"last_name\": \"Dulce Armentrout\",
      \"email\": \"name@example.com\",

      \"document_identification_number\": \"12345678Z\",

      \"phone\": {
        \"number\": \"654123789\"
      },
      \"work_phone\": {
        \"number\": \"654123789\"
      },
      \"home_phone\": {
        \"number\": \"654123789\"
      },
      \"mobile_phone\": {
        \"number\": \"654123789\"
      }
    },
    \"address\": {
      \"city\": \"Castellón\",
      \"country\": \"ESP\",
      \"address1\": \"Ronda\",
      \"zip_code\": \"12006\",
      \"state_code\": \"Castellón\"
    },
    \"shipping_address\": {
      \"city\": \"Castellón\",
      \"country\": \"ESP\",
      \"address1\": \"Ronda\",
      \"zip_code\": \"12006\",
      \"state_code\": \"Castellón\"
    },
    \"billing_address\": {
      \"city\": \"Castellón\",
      \"country\": \"ESP\",
      \"address1\": \"Ronda\",
      \"zip_code\": \"12006\",
      \"state_code\": \"Castellón\"
    },
    \"payment\": {
      \"installments\": 1
    },
    \"cof\": {
      \"reason\": \"INSTALLMENTS\"
    }
  },
  \"save_card\": false,
  \"reference\": \"Token implik-2.com\"
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Basic NmNjZWUzZjE4ZGQyNGE3NTgyMDUzYzZhOThhZmFhYTk="
));

$response = curl_exec($ch);
curl_close($ch);



$datos = json_decode( $response);



/*echo "<br>---------------------------------<br>";




echo "code: ". $datos->code."<br>";
echo "token: ". $datos->order->token."<br>";*/

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.paylands.com/v1/sandbox/payment/process/".$datos->order->token);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: text/html"
));

$response = curl_exec($ch);
curl_close($ch);

echo $response;