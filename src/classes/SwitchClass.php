<?php


require('vendor/autoload.php');
use GuzzleHttp\Client;
class SwitchClass extends MainClass
{

    public function __construct()
    {
        $this->sessionTimeoutSecs="5000";
        // call Grandpa's constructor
        parent::__construct("switch");

    }


    function getPay(float $amount,string $cardNumber,string $cardHolder,string $currency,string $Mounth,string $Year,string $Cvv){
 
        $url = $this->urlapi."/v1/payments";
	$data = "entityId=".$this->entityId .
                "&amount=".$amount .
                "&currency=".$currency .
                "&paymentBrand=MASTER" .
                "&paymentType=PA" .
                "&card.number=".$cardNumber .
                "&card.holder=".$cardHolder .
                "&card.expiryMonth=".$Mounth .
                "&card.expiryYear=".$Year .
                "&card.cvv=".$Cvv .
                "&standingInstruction.mode=INITIAL" .
                "&standingInstruction.type=UNSCHEDULED" .
                "&standingInstruction.source=CIT" .
                "&createRegistration=true";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Authorization:'.$this->tokenSwitch));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$responseData = curl_exec($ch);
    // echo $responseData;
	if(curl_errno($ch)) {
		return curl_error($ch);
	}
	curl_close($ch);



    $json_data=json_decode($responseData,true);
    if(isset($json_data['resultDetails']['RiskStatusCode'])){
        if( $json_data['resultDetails']['RiskStatusCode']=="APPROVE"){
            return array('url'=>"","transiction_id"=> $json_data['id']);
                }else {
                    return 0;
                }
    }else {
        return 0;
    }
 
	// return $responseData;
    }

}
