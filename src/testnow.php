<?php
include('classes/PayClass.php');
use iqpay\PayClass;//f
use iqpay\getWays;
if (isset($_POST['submit'])) {

  
    $PayClass = new PayClass();
    $PayClass->amount = "10000";
    $PayClass->currency = "IQD";// or USD
    $PayClass->returnUrl = "http://example.com";
    $PayClass->failUrl = "http://example.com";
    $PayClass->language = "ar";// or "en"
    $PayClass->description = "xxxxxxx";
    $PayClass->ordernum = "xxxxxxx";
    $PayClass->nameCostumer = "xxxxxxx";
    $PayClass->phoneCostumer = "xxxxxxx";
   
   if($_POST['methodpay']=="zaincash"){
    $PayClass->method = getWays::zaincash;
   }
    if($_POST['methodpay']=="aps"){
      $PayClass->method = getWays::aps;
     }
     if($_POST['methodpay']=="switch"){
      $PayClass->method = getWays::switch;
     }
     if($_POST['methodpay']=="amwal"){
      $PayClass->method = getWays::amwal;
     }
     if($_POST['methodpay']=="tasdid"){
      $PayClass->method = getWays::tasdid;
     }
   
 

  if( $_POST['methodpay']=="switch"){
    $PayClass->method=getWays::switch;
    $PayClass->amount="90";
    $PayClass->cardNumber="xxxxxxxxxxxxxxx";
    $PayClass->cardHolder="xxxxxxxxxxxxxxx";
    $PayClass->currency="IQD"; // or USD
    $PayClass->Mounth="xxx";
    $PayClass->Year="xxx";
    $PayClass->Cvv="xxx";

    $response=$PayClass->PaySwitch();
  }else{
    $response=$PayClass->Pay();
  }








    if($response){
        $transiction_id=$response['transiction_id'];
        $url=$response['url'];
      if(!empty($response['url'])){
        header('location: '.$url);
      }else{
        echo " success pay<br>";
      }
      
    }else {
        echo "error pay<br>";
    }
}
$orderIdcheck = "387d9086-9d6a-4e22-86f1-3c600f50fbc5";
// $orderIdcheck=md5("4994459");
$PayClass = new PayClass();

$PayClass->method = "aps";
$res = $PayClass->checkOrder($orderIdcheck);
if ($res == -1) {
    echo "method not supported";
} else if ($res == 1) {
    echo "succes order<br>";
} else {
    echo "error order<br>";
}
?>

<h3>mohammed akeel do you need pay 10000 IQD now ? select method!</h3><br>
<form method="POST" action="">
    amwal:
    <input type="radio" name="methodpay" value="amwal" />
    <br>
    aps:
    <input type="radio" name="methodpay" value="aps" />
    <br>
    zaincash:
    <input type="radio" name="methodpay" value="zaincash" />
    <br>
 
    switch:
    <input type="radio" name="methodpay" value="switch" />
    <br>
    <br>

    <button name="submit"> pay now</button>
</form>
