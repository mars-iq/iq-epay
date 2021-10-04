<?php


require('vendor/autoload.php');

use GuzzleHttp\Client;

class SwitchClass extends MainClass
{
    public $client;
    public function __construct()
    {
        $this->sessionTimeoutSecs = "5000";
        // call Grandpa's constructor
        parent::__construct("switch");
        $this->client = new Client(['base_uri' => $this->urlapi]);
    }


    function getPay(float $amount, string $cardNumber, string $cardHolder, string $currency, string $Mounth, string $Year, string $Cvv)
    {

        $url = $this->urlapi . "/v1/payments";

        $body = [
            "entityId" => $this->entityId,
            "amount" => $amount,
            "currency" => $currency,
            "paymentBrand" => "MASTER",
            "paymentType" => "PA",
            "card.number" => $cardNumber,
            "card.holder" => $cardHolder,
            "card.expiryMonth" => $Mounth,
            "card.expiryYear" => $Year,
            "card.cvv" => $Cvv,
            "standingInstruction.mode" => "INITIAL",
            "standingInstruction.type" => "UNSCHEDULED",
            "standingInstruction.source" => "CIT",
            "createRegistration" => true,
        ];
        $response = $this->client->request('POST', $url, [
            'form_params' => $body,

            'headers' => [
                'Authorization' => $this->tokenSwitch,

            ]

        ]);

        $json_data = json_decode($response->getBody(), true);
        if (isset($json_data['resultDetails']['RiskStatusCode'])) {
            if ($json_data['resultDetails']['RiskStatusCode'] == "APPROVE") {
                return array('status' => true, 'url' => "", "transiction_id" => $json_data['id'], 'response' => $json_data);
            } else {
                return array('status' => false, 'response' => $json_data);;
            }
        } else {
            return array('status' => false, 'response' => $json_data);
        }

        // return $responseData;
    }
}
