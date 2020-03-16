<?php
//The url you wish to send the POST request to
$url = "https://api.instagram.com/oauth/access_token";

echo $_GET['code'];

//The data you want to send via POST
$fields = [
  'client_id' => '325469361745832',
  'client_secret' => $_GET['code'],
  'grant_type' => 'authorization_code',
  'redirect_uri' => 'https://jamiek.it/',
];

//url-ify the data for the POST
$fields_string = http_build_query($fields);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

//execute post
$result = curl_exec($ch);
echo $result;
?>
