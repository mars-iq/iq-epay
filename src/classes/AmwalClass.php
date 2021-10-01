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
    $this->client = new Client(['base_uri' => $this->urlapi]);
  }

  function getPay(float $amount,string $description,string $currency,string $returnUrl,string $failUrl,string $orderNum)
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
    $data = json_encode($data);

    $serverkey = $this->serverkey;
    $header = array("authorization: " . $serverkey, "content-type: application/json");
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response1 = curl_exec($ch);
 
    curl_close($ch);
    $data = json_decode($response1, true);
    if(isset($data['redirect_url'])){
     
        return array('url'=>$data['redirect_url'],'transiction_id'=>$data['tran_ref']);
    }else{
        return 0;
    }


  }
}
