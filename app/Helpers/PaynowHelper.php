<?php
namespace App\Helpers;
use Paynow\Payments\Paynow;


class PaynowHelper{
    public $id = '15485';
    public $key = 'df033924-f9bb-4056-bc77-934657ee2ab1';
    public $returnUrl = 'https://7498-208-78-41-150.ngrok.io/api/paynow/return';
    public  $resultUrl = 'https://7498-208-78-41-150.ngrok.io/api/paynow/result';

    function __construct()
    {

        $this->paynow = new Paynow($this->id,$this->key,$this->returnUrl,$this->resultUrl);

    }

    public function makePaymentMobile($paymentId,$userId,$items)
    {
        $payment=$this->paynow->createPayment($paymentId,$userId);
        foreach($items as $item){
            $payment->add($item[0],$item[1]);
        }
        $response = $this->paynow->sendMobile($payment, '0774444444', 'ecocash');
        dd($response);
    }


}


