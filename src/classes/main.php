<?php
class MainClass{

public string $username;
public string $password;


public string $Msisdn;
public string $Merchant_Id;
public string $Secret;


public string $serverkey;
public string $profileid;


public string $urlapi;
public string $redirect;
public bool $productionZain;

public string $entityId;
public string $tokenSwitch;

public function __construct(string $bank){
    $string = file_get_contents("config.json");
    $json_a = json_decode($string, true);
   
    if($bank=="aps"){
        $this->username=$json_a[$bank]['username'];
        $this->password=$json_a[$bank]['password'];
        $this->urlapi=$json_a[$bank]['urlapi'];
        $this->redirect=$json_a[$bank]['redirect'];
    }else  if($bank=="zaincash"){
   
        $this->Msisdn=$json_a[$bank]['Msisdn'];
        $this->Merchant_Id=$json_a[$bank]['Merchant_Id'];
        $this->Secret=$json_a[$bank]['Secret'];
        $this->productionZain=$json_a[$bank]['production_cred'];
    }else  if($bank=="amwal"){
      
        $this->serverkey=$json_a[$bank]['serverkey'];
        $this->profileid=$json_a[$bank]['profileid'];
        $this->urlapi=$json_a[$bank]['urlapi'];
  
    }else  if($bank=="tasdid"){
        $this->username=$json_a[$bank]['username'];
        $this->password=$json_a[$bank]['password'];
        $this->urlapi=$json_a[$bank]['urlapi'];
     
    }else  if($bank=="switch"){
        $this->entityId=$json_a[$bank]['entityId'];
        
        $this->tokenSwitch=$json_a[$bank]['tokenSwitch'];
        $this->urlapi=$json_a[$bank]['urlapi'];
     
    }


}

}
