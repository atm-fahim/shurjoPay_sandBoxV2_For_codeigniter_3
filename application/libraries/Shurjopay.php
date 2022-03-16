<?php

class Shurjopay {

    private $username = 'sp_sandbox';
    private $password = 'pyyk97hu&6u6';
    private $client_ip = '127.0.0.1';
    //live
    //private $server_url='https://engine.shurjopayment.com';
    //sandbox
    private $server_url='https://sandbox.shurjopayment.com';
   
    public function get_token(){
		$curl = curl_init();

		$request_credential = array(
            'username' => $this->username,
            'password' => $this->password
        );
		$requestbodyJson = json_encode($request_credential);
		curl_setopt_array($curl, [
		  CURLOPT_URL => $this->server_url.'/api/get_token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $requestbodyJson,
		  CURLOPT_HTTPHEADER => [
			"Content-Type: application/json"
		  ],
		]);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  return $response;
		}
}

public function sendPayment($requestbodyJson) {
    $curl = curl_init();
    $token=$this->get_token();
    $array = json_decode($token, true);
     curl_setopt_array($curl, [
      CURLOPT_URL => $this->server_url."/api/secret-pay",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_SSL_VERIFYHOST => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $requestbodyJson,
      CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer ". $array['token']
      ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
        if ($err) {
          return "Error #:" . $err;
        } else {
          return $response;
         
        }
}

}