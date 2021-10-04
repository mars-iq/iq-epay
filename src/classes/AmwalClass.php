<?php

// include('main.php');
require('vendor/autoload.php');

use GuzzleHttp\Client;

class AmwalClass extends MainClass
{

  public $client;
  public function __construct()
  {
    $this->sessionTimeoutSecs = "5000";
    // call Grandpa's constructor
    parent::__construct("amwal");
        $this->client = new Client(['base_uri' => $this->urlapi,'http_errors' => false]);
  }

  function getPay(float $amount, string $description, string $currency, string $returnUrl, string $failUrl, string $orderNum)
  {
    //   $randnum=rand(10000,99999);
    $url = $this->urlapi . "/payment/request";
    $data = array(
      "profile_id" => $this->profileid,
      "tran_type" => "sale",
      "tran_class" => "ecom",
      "cart_id" =>  $orderNum,
      "cart_description" => $description,
      "cart_currency" => $currency,
      "cart_amount" => $amount,
      "callback" => $failUrl,
      "return" => $returnUrl
    );
    $body = json_encode($data);
    $response = $this->client->request('POST',  $url, [
      'body' => $body,
      'headers' => [
        'authorization' => $this->serverkey,
        'Content-type'     => 'application/json',

      ]
    ]);
    $json_response = json_decode($response->getBody(), true);
    if (isset($json_response['redirect_url'])) {

      return array('status' => true, 'url' => $json_response['redirect_url'], 'transiction_id' => $json_response['tran_ref'], 'response' => $json_response);
    } else {
      return array('status' => false, 'response' => $json_response);
    }
  }
}
