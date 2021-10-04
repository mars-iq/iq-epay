<?php
// require_once('main.php');
require_once('vendor/autoload.php');

use GuzzleHttp\Client;

class ApsClass extends MainClass
{




    public $client;

    //
    public function __construct()
    {
        $this->sessionTimeoutSecs = "5000";
        // call Grandpa's constructor
        parent::__construct("aps");
             $this->client = new Client(['base_uri' => $this->urlapi,'http_errors' => false]);
    }

    public function getPay(float $amount, string $orderNum, string $currency, string $returnUrl, string $failUrl, string $language, string $description)
    {

        $body = [
            "userName" => $this->username,
            "password" => $this->password,
            "orderNumber" => $orderNum,
            "amount" => $amount,
            "currency" => $currency,
            "returnUrl" => $returnUrl,
            "failUrl" => $failUrl,
            "language" => $language,
            "description" => $description,
            "sessionTimeoutSecs" => "5000"
        ];
        $response = $this->client->request('POST', $this->urlapi . "/rest/register.do", ['form_params' => $body]);
        $json_response = json_decode($response->getBody(), true);

        if ($json_response['errorCode'] == 0) {
            return array('status' => true, 'url' => $json_response['formUrl'], 'transiction_id' => $json_response['orderId'], 'response' => $json_response);
        }
        return array('status' => false, 'response' => $json_response);;
    }


    public function PayOrder(string $EXPIRY, string $PAN, string $CVC, string $TEXT, string $MM, string $YYYY)
    {

        $body = [
            "MDORDER" => $this->orderId,
            "$" . "EXPIRY" => $EXPIRY,
            "$" . "PAN" => $PAN,
            "MM" => $MM,
            "YYYY" => $YYYY,
            "TEXT" => $TEXT,
            "$" . "CVC" => $CVC,
            "language" => "",
            "email" => "",
            "bindingNotNeeded" => "false",
            "jsonParams" => "{}",
        ];
        $response = $this->client->request('POST', $this->urlapi . "/payment/rest/processform.do", ['form_params' => $body]);
        $json_response = json_decode($response->getBody(), true);

        if (strpos($response->getBody(), "payment_deposited") !== false) {
            return 1;
        } else {
            return 0;
        }
    }



    function CheckPay(string $ordernumber)
    {
        $body = [
            "userName" => $this->username,
            "password" => $this->password,
            "orderId" => $ordernumber,
            "language" => "en",

        ];
        $response = $this->client->request('POST', $this->urlapi . "/payment/rest/getOrderStatusExtended.do", ['form_params' => $body]);
        $json_response = json_decode($response->getBody(), true);

        if (isset($json_response['orderStatus'])) {
            if ($json_response['orderStatus'] == 2) {
                return array('status' => 1, 'response' => $json_response);
            }
        }

        return array('status' => 0, 'response' => $json_response);
    }
}
