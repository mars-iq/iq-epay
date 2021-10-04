<?php

require_once('main.php');
require('vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class QiClass extends MainClass
{
    public $client;
    public function __construct()
    {

        // call Grandpa's constructor
        parent::__construct("qi");
        $this->client = new Client(['base_uri' => $this->urlapi,'http_errors' => false]);
    }

    function getPay($amount, $currency, $orderNum, $returnUrl, $failUrl)
    {
        $t = time();
        $time = date("Y-m-d", $t);

        $body = json_encode([
            "order" => [
                "amount" => $amount,
                "currency" => $currency,
                "orderId" => $orderNum
            ],
            "timestamp" => $time,
            "successUrl" => $returnUrl,
            "failureUrl" => $failUrl,
            "cancelUrl" => $failUrl
        ]);

        $response = $this->client->request('POST', $this->urlapi . "/api/v0/transactions/business/token", [
            'body' => $body,

            'headers' => [
                'Authorization' => $this->serverkey,
                'Content-type'     => 'application/json',

            ]

        ]);
        // echo $response->getBody();
        $json_response = json_decode($response->getBody(), true);
        if ($json_response['success']) {
            return array('status' => true, 'url' => $json_response['data']['link'], 'transiction_id' => $json_response['data']['transactionId'], 'response' => $json_response);
        }
        return array('status' => false, 'response' => $json_response);
    }

    function CheckPay(string $ordernumber, string $transiction_id)
    {

        $response = $this->client->request('GET', $this->urlapi . "/api/v0/transactions/business/" . $transiction_id . "/" . $ordernumber, [
            'headers' => [
                'Authorization' => $this->serverkey,
                'Content-type'     => 'application/json',

            ]
        ]);
        $json_response = json_decode($response->getBody(), true);

        if (isset($json_response['success'])) {
            if ($json_response['success']) {
                return array('status' => 1, 'response' => $json_response);
            } else {
                return array('status' => 2, 'response' => $json_response);
            }
        }

        return 0;
    }

    function VoidOrder(string $ordernumber, string $transiction_id)
    {
        $body = json_encode([

            "orderId" => $ordernumber,
            "transactionId" => $transiction_id,
       
        ]);
        $response = $this->client->request('POST', $this->urlapi . "/api/v0/transactions/business/void", [
            'body'=>$body,
            'headers' => [
                'Authorization' => $this->serverkey,
                'Content-type'     => 'application/json',

            ]
        ]);
        $json_response = json_decode($response->getBody(), true);

        if (isset($json_response['success'])) {
            if ($json_response['success']) {
                return array('status' => 1, 'response' => $json_response);
            } else {
                return array('status' => 2, 'response' => $json_response);
            }
        }

        return 0;
    }
}
