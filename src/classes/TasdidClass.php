<?php

require_once('main.php');
require('vendor/autoload.php');

use GuzzleHttp\Client;

class TasdidClass extends MainClass
{
    public $client;
    public function __construct()
    {
        $this->sessionTimeoutSecs = "5000";
        // call Grandpa's constructor
        parent::__construct("tasdid");
        $this->client = new Client(['base_uri' => $this->urlapi]);
    }

    public function getPay($nameCostumer, $phoneNumberq, $dueDate, $amount, $description, $currency, $returnUrl, $ordernum)
    {


        $data = array("username" => $this->username,  "password" => $this->password);

        $data = json_encode($data);

        $url = $this->urlapi . "/v1/api/Auth/Token";
        $ch = curl_init($url);
        $header = array("content-type: application/json");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response1 = curl_exec($ch);
        curl_close($ch);

        $jsdata = json_decode($response1, true);
    }
    public function PayNow()
    {
    }
}
