MarTeam- iq-epay:
-----
we write this code with hackathon yanhad

Problem:
------
Many projects that need e-payment through their applications have some problems in e-payment, including the multiplicity of payment gates, which makes it difficult to program these gates due to the multiplicity of documents, links and methods of work

Target:
-----
Providing a special package to solve these problems by creating a single object and calling a unit function with its parameters to create the payment process across all or separately gates

Payment Gates:
1-APS (Validated)
2-Amwal (Validated)
3-ZainCash (Validated)
4-Switch (Validated)
5-Tasdid (Beta)

Solution:
------
Building a set of problem-solving objects where these objects work in conjunction to accomplish the task of payment through a particular gateway

Installation
------------

Use composer to manage your dependencies and download mars-iq/iqpay:

```bash
    composer require mars-iq/iqpay:dev-master
```

Using Object
----------
```php
      use \iqpay\PayClass;
 ```
Example
---------
```php

  
     $PayClass = new PayClass();
     $amount = "10000";
     $currency = "840";
     $returnUrl = "http://example.com";
     $failUrl = "http://example.com";
     $language = "ar";// or "en"
     $description = "xxxxxxx";
     $ordernum = "xxxxxxx";
     $nameCostumer = "xxxxxxx";
     $phoneCostumer = "xxxxxxx";
     $method = "xxxxxxx"; // "zaincash" or "aps"   or "amwal"
     $PayClass->setData($nameCostumer, $phoneCostumer, $amount, $ordernum, $currency, $returnUrl, $failUrl, $language, $description, $method);//for set data to object
     $response=$PayClass->Pay();//to procces Pay  - response (transiction_id,url)
```
Example Switch MasterCard
---------
```php
    $PayClass = new PayClass();
    $PayClass->method="swtich";
    $amount="90";
    $cardNumber="xxxxxxxxxxxxxxx";
    $cardHolder="xxxxxxxxxxxxxxx";
    $currency="xxx";
    $Mounth="xxx";
    $Year="xxx";
    $Cvv="xxx";

    $response=$PayClass->PaySwitch($amount, $cardNumber, $cardHolder, $currency, $Mounth, $Year, $Cvv);
```
Example Check Procces Success(APS)
---------
```php
   $orderId = "xxxxxxxxxxxxxxxxxxxx";
   $PayClass = new PayClass();
   $PayClass->method = "aps";
   $res = $PayClass->checkOrder($orderId);
```

