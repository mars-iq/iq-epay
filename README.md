
<div>
    <img src="https://mohammedakeel.online/logos/mars.png" width="75">
    <img src="https://mohammedakeel.online/logos/yanhad.png" width="75">
    <img src="https://mohammedakeel.online/logos/station.jpg" width="75">
    <img src="https://mohammedakeel.online/logos/amwal.jpg" width="75">
    <img src="https://mohammedakeel.online/logos/zaincash.png" width="75">
    <img src="https://mohammedakeel.online/logos/aps.png" width="75">
    <img src="https://mohammedakeel.online/logos/switch.jpg" width="75">
</div>

MarTeam/iq-epay:
-----
This peace of code was written using hackathon yanhad, and it is now under testing level

Document:
-----
<a href="http://mohammedakeel.online/logos/marsteam.pdf" target="_blank">work documentation</a>

USES:
----
PHP OOP , Curl,Php HttpClint,JWT


Problem:
------
Most of the applications today come with e-payment tools, where many challenges occur in terms of coding. On top of them, the variety of payment gateways which might be difficult to be implemented in the context of coding, and this is due to the multiplicity of documents, links, and work behavior

Target:
-----
To provide a particular package aiming to overcome the challenges of e-payment, throughout building a single object and then call a unit function along with its parameters in order to achieve a payment process all over the gates

Payment Gates:
```bash
1-APS (Validated)
2-Amwal (Validated)
3-ZainCash (Validated)
4-Switch (Validated)
5-Tasdid (Beta)
```
Solution:
------
Building a set of problem-solving objects that work together to implemented e-payment task in each particular gateway successfully

Installation
------------

Use composer to manage your dependencies and download mars-iq/iqpay (Work Just Composer Version 2):

```bash
    composer require mars-iq/iqpay:dev-master 
    
```
Installation Config File
-------------
now you should add config.json file in your root of project like this (All this Configs It is provided to you by the source)
```json
{
    "aps": {
        "username": "xxxxxxxxxx",
        "password": "xxxxxxxxxx",
        "urlapi": "http://api.example.com",
        "redirect": true
    },
    "zaincash": {
        "Msisdn": "xxxxxxxxxx",
        "Merchant_Id": "xxxxxxxxxx",
        "Secret": "xxxxxxxxxx",
        "production_cred": false
    },
    "switch": {
        "tokenSwitch": "xxxxxxxxxx",
        "entityId": "xxxxxxxxxx",
        "urlapi": "http://api.example.com"

    },
    "tasdid": {
        "username": "xxxxxxxxxx",
        "password": "xxxxxxxxxx",
        "serviceId": "xxxxxxxxxx",
        "urlapi": "http://api.example.com"

    },
    "amwal": {
        "serverkey": "xxxxxxxxxx",
        "profileid": "xxxxxxxxxx",
        "urlapi": "http://api.example.com"

    }

}

```


Using Object
----------
```php
      use \iqpay\PayClass;
      use iqpay\getWays;
 ```
Example
---------
```php

  
     $PayClass = new PayClass();
     $PayClass->amount = "10000";
     $PayClass->currency = "840";
     $PayClass->returnUrl = "http://example.com";
     $PayClass->failUrl = "http://example.com";
     $PayClass->language = "ar";// or "en"
     $PayClass->description = "xxxxxxx";
     $PayClass->ordernum = "xxxxxxx";
     $PayClass->nameCostumer = "xxxxxxx";
     $PayClass->phoneCostumer = "xxxxxxx";
     $PayClass->method =getWays::zaincash; // "getWays::zaincash" or "getWays::aps"   or "getWays::amwal"
      $response=$PayClass->Pay();//to procces Pay  - response (transiction_id,url)
```
Example Switch MasterCard
---------
```php
    $PayClass = new PayClass();
    $PayClass->method=getWays::switch;
    $PayClass->amount="90";
    $PayClass->cardNumber="xxxxxxxxxxxxxxx";
    $PayClass->cardHolder="xxxxxxxxxxxxxxx";
    $PayClass->currency="xxx";
    $PayClass->Mounth="xxx";
    $PayClass->Year="xxx";
    $PayClass->Cvv="xxx";

    $response=$PayClass->PaySwitch();//to procces Pay  - response (transiction_id,url)
```
Example Check Procces Success(APS)
---------
```php
   $orderId = "xxxxxxxxxxxxxxxxxxxx";
   $PayClass = new PayClass();
   $PayClass->method = "aps";
   $res = $PayClass->checkOrder($orderId); // return -1 not suported or 1 succes or 0 error
```

Classes
-----
```bash
   PayClass     Payment interfaces interconnection 
   MainClass    Configuration Payments Gate	 
   ApsClass     Aps Payment Gate 
   AmwalClass 	Amwal Payment Gate	
   ZainCash	    ZainCash Payment Gate		
   SwitchClass	Switch Payment Gate	
   TasdidClass	Tasdid Payment Gate		
  ```
  


