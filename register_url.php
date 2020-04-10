<?php

	//fetching access token.
	
	$consumerKey = 'ATCAOqYt4DGapujfaWfGGpONhh2wKXNO'; //Fill with your app Consumer Key
	$consumerSecret = '5HCQCAn056dEOMKV'; // Fill with your app Secret

	$headers = ['Content-Type:application/json; charset=utf8'];

	$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_HEADER, FALSE);
	curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
	$result = curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$result = json_decode($result);

	$access_token = $result->access_token;

	echo $access_token;
	
	// end of access token. the next block of code registers the web url




	$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

	// $access_token = ''; // check the mpesa_accesstoken.php file for this. No need to writing a new file here, just combine the code as in the tutorial.
	$shortCode = '601443'; // provide the short code obtained from your test credentials

	/* This two files are provided in the project. */
	$confirmationUrl = 'https://ryanvictorotieno.github.io/Adventsafaris/confirmation_url.php'; // path to your confirmation url. can be IP address that is publicly accessible or a url
	$validationUrl = 'https://ryanvictorotieno.github.io/Adventsafaris/validation.php'; // path to your validation url. can be IP address that is publicly accessible or a url



	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header


	$curl_post_data = array(
	  //Fill in the request parameters with valid values
	  'ShortCode' => $shortCode,
	  'ResponseType' => 'Confirmed',
	  'ConfirmationURL' => $confirmationUrl,
	  'ValidationURL' => $validationUrl
	);

	$data_string = json_encode($curl_post_data);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

	$curl_response = curl_exec($curl);
	print_r($curl_response);

	echo $curl_response;
?>