<?php
namespace App\Helpers;
use Paynow\Payments\Paynow;


class PaynowHelper{
    public $id = '';
    public $key = '';
    public $returnUrl = '';
    public  $resultUrl = '';

    function __construct(){

        $this->paynow = new Paynow($this->id,$this->key,$this->returnUrl,$this->resultUrl);

    }

    public function makePaymentMobile($userId,$paymentId)
    {
        $this->payment=$this->paynow->createPayment($paymentId,$userId);
    }

    public function add($items)
    {
        foreach($items as $item){
            $this->payment->add($item[0],$item[1]);
        }
    }

}


