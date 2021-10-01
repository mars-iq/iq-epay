<?php
include('classes/PayClass.php');
use Mars\PayClass;//f
if (isset($_POST['submit'])) {
    $amount = "10000";
    $currency = "840";
    $returnUrl = "https://localhost";
    $failUrl = "https://localhost";
    $language = "ar";
    $description = "for test";
    $ordernum = rand(10000, 99999);
    $nameCostumer = "mohammed akeel";
    $phoneCostumer = "07709312173";
    $method = $_POST['methodpay'];
    $PayClass = new PayClass();
    $PayClass->setData($nameCostumer, $phoneCostumer, $amount, $ordernum, $currency, $returnUrl, $failUrl, $language, $description, $method);
  
  if( $_POST['methodpay']=="switch"){
    $PayClass->method="swtich";
    $amount="90";
    $cardNumber="5454545454545454";
    $cardHolder="Jane Jones";
    $currency="USD";
    $Mounth="05";
    $Year="2034";
    $Cvv="123";

    $response=$PayClass->PaySwitch($amount, $cardNumber, $cardHolder, $currency, $Mounth, $Year, $Cvv);
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
