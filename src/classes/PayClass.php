<?php
namespace Mars;
require_once('main.php');
require_once('ApsClass.php');
require_once('AmwalClass.php');
require_once('SwitchClass.php');
require_once('TasdidClass.php');
require_once('ZainCash.php');
use ApsClass;
use AmwalClass;
use SwitchClass;
use ZainCashIQ\ZainCash;
use TasdidClass;
class PayClass 
{
    public float $amount;
    public string $currency;
    public  string $returnUrl;
    public string $failUrl;
    public string $language;
    public string $description;
    public string $method;
    public string $nameCostumer;
    public string $phoneCostumer;
    public  string $orderNum;
    public function __construct()
    {
    }
    public function setData(string $nameCostumer,string $phoneCostumer,float $amount,string $orderNum,string $currency,string $returnUrl, string $failUrl,string $language,string $description,string $method)
    {
        $this->nameCostumer = $nameCostumer;
        $this->phoneCostumer = $phoneCostumer;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->returnUrl = $returnUrl;
        $this->failUrl = $failUrl;
        $this->language = $language;
        $this->description = $description;
        $this->orderNum = $orderNum;
        $this->method = $method;
    }

    public function Pay()
    {
        if ($this->method == "aps") {
           return $this->PayAps();
        } else if ($this->method == "switch") {
return $this->PaySwitch();
        } else if ($this->method == "amwal") {
          return  $this->PayAmwal();
        } else if ($this->method == "zaincash") {
         return   $this->PayZainCash();
        } else if ($this->method == "tasdid") {

        }
    }

    public function PayAps()
    {
        $ApsClass = new ApsClass();
       $ret = $ApsClass->getPay($this->amount, $this->orderNum, $this->currency, $this->returnUrl, $this->failUrl, $this->language, $this->description);
  
       return $ret;
    }

    public function PayZainCash()
    {
        try {
            $zc = new ZainCash($this->returnUrl, $this->language);


        $ret=  $zc->getPay(
                $this->amount,
                $this->description,
                $this->orderNum
            );
          
            return $ret;
           
        } catch (Exception $e) {
         echo $e->getMessage();
            return 0;
        }
    }
    function PayAmwal()
    {

        $AmwalClass = new AmwalClass();

      return  $AmwalClass->getPay($this->amount, $this->description, $this->currency, $this->returnUrl, $this->failUrl, $this->orderNum);
    }


    public function PaySwitch($amount, $cardNumber, $cardHolder, $currency, $Mounth, $Year, $Cvv){
        $SwitchClass=new SwitchClass();
        $ret=$SwitchClass->getPay( $amount, $cardNumber, $cardHolder, $currency, $Mounth, $Year, $Cvv);
        return $ret;
    }

    function checkOrder(String $orderNum)
    {
        if ($this->method == "aps") {
            $ApsClass = new ApsClass();
            $ret = $ApsClass->CheckPay($orderNum);
            if ($ret) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return -1;
        }
    }
    
}
