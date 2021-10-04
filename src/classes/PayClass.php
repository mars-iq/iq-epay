<?php

namespace iqpay;

require_once('main.php');
require_once('ApsClass.php');
require_once('AmwalClass.php');
require_once('SwitchClass.php');
require_once('TasdidClass.php');
require_once('ZainCash.php');
require_once('QiClass.php');

use ApsClass;
use AmwalClass;
use SwitchClass;
use ZainCashIQ\ZainCash;
use TasdidClass;
use QiClass;

abstract class getWays
{
    const zaincash = "zaincash";
    const aps = "aps";
    const amwal = "amwal";
    const tasdid = "tasdid";
    const qi = "qi";
    const switch = "switch";
}
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


    public string $cardNumber;
    public string  $cardHolder;
    public string  $Mounth;
    public string  $Year;
    public string  $Cvv;
    public function __construct()
    {
    }
    public function setData(string $nameCostumer, string $phoneCostumer, float $amount, string $orderNum, string $currency, string $returnUrl, string $failUrl, string $language, string $description, string $method)
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
        } else if ($this->method == "qi") {
            return   $this->PayQi();
        }
    }
    public function PayQi()
    {
        $QiClass = new QiClass();
        $ret = $QiClass->getPay($this->amount, $this->currency, $this->orderNum, $this->returnUrl, $this->failUrl);

        return $ret;
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


            $ret =  $zc->getPay(
                $this->amount,
                $this->description,
                $this->orderNum
            );

            return $ret;
        } catch (Exception $e) {
            echo $e->getMessage();
            return array('status' => false);
        }
    }
    function PayAmwal()
    {

        $AmwalClass = new AmwalClass();

        return  $AmwalClass->getPay($this->amount, $this->description, $this->currency, $this->returnUrl, $this->failUrl, $this->orderNum);
    }


    public function PaySwitch()
    {
        $SwitchClass = new SwitchClass();
        $ret = $SwitchClass->getPay($this->amount, $this->cardNumber, $this->cardHolder, $this->currency, $this->Mounth, $this->Year, $this->Cvv);
        return $ret;
    }

    function checkOrder(String $orderNum, string $transiction_id)
    {
        if ($this->method == "aps") {
            $ApsClass = new ApsClass();
            $ret = $ApsClass->CheckPay($orderNum);
            return $ret;
        } else if ($this->method == "qi") {
            $QiClass = new QiClass();
            $ret = $QiClass->CheckPay($orderNum, $transiction_id);
            return $ret;
        } else {
            return -1;
        }
    }


    function QiVoidOrder(String $orderNum, string $transiction_id)
    {
        $QiClass = new QiClass();
        $ret = $QiClass->VoidOrder($orderNum, $transiction_id);
        return $ret;
    }
}
