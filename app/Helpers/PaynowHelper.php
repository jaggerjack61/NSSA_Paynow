<?php
namespace App\Helpers;
use App\Models\WhatsappSetting;
use GuzzleHttp\Client;
use Paynow\Payments\Paynow;


class PaynowHelper{
    public $id = '15562';
    public $key = 'ff0ea85d-68ba-4bf2-88b8-16171c3cd747';
    public $returnUrl = 'https://8dc4-197-221-253-183.ngrok.io/api/paynow/return';
    public  $resultUrl = 'https://8dc4-197-221-253-183.ngrok.io/api/paynow/result';
    public $fee;

    public function __construct()
    {
        $this->fee=WhatsappSetting::first()->amount;
        $this->paynow = new Paynow($this->id,$this->key,$this->returnUrl,$this->resultUrl);

    }

    public function makePaymentMobile($paymentId,$email,$phone,$method)
    {
        $payment=$this->paynow->createPayment($paymentId,$email);

        $payment->add('Look up details',$this->fee);

        $response = $this->paynow->sendMobile($payment, $phone, $method);
//        $fptr = fopen('response.txt', 'w');
//        fwrite($fptr, implode("::",$response?:array('sam','tag')));;
//        fclose($fptr);
//        $data=$response->data();
//        if(array_key_exists('error',$data)){
//            $fptr = fopen('status.txt', 'w');
//            fwrite($fptr, 'Error');
//            fclose($fptr);
//        }
//        else{
//            $client = new Client();
//
//            while(1==1){
//                $response=$client->get($data['pollurl'])->getBody()->getContents();
//                parse_str($response,$output);
//                if($output['status']=='Paid'){
//                    $fptr = fopen('status.txt', 'w');
//                    fwrite($fptr, 'Paid');
//                    fclose($fptr);
//                    break;
//                }
//                elseif($output['status']=='Sent'){
//                    $fptr = fopen('status.txt', 'w');
//                    fwrite($fptr, 'Sent');
//                    fclose($fptr);
//                    sleep(1);
//                }
//                elseif($output['status']=='Failed'){
//                    $fptr = fopen('status.txt', 'w');
//                    fwrite($fptr, 'Failed');
//                    fclose($fptr);
//                    break;
//
//                }
//                elseif($output['status']=='Cancelled'){
//                    $fptr = fopen('status.txt', 'w');
//                    fwrite($fptr, 'Cancelled');
//                    fclose($fptr);
//                    break;
//                }
//                elseif($output['status']=='Insufficient funds'){
//                    $fptr = fopen('status.txt', 'w');
//                    fwrite($fptr, 'Insufficient funds');
//                    fclose($fptr);
//                    break;
//                }
//            }

//            $fptr = fopen('myfile2.txt', 'w');
//            fwrite($fptr, $output['status'].$output['reference'].$output['paynowreference']);
//            fclose($fptr);
//        }
//
//        dd($response);
    }


}


